# Correções de Segurança — Financeiro Revizzi

Documento de acompanhamento das correções aplicadas após a análise de prontidão para deploy
(2026-08-12). Todos os itens de código abaixo foram implementados e testados localmente
(login, CSRF, cookie assinado, XSS, rate limit, bloqueio de dotfiles). Serve para retomar o
trabalho em outra sessão sem perder contexto.

Ver também [`PRODUCAO.md`](PRODUCAO.md) para o checklist original de deploy (ainda válido).

## Status

- ✅ **Feito e testado** — código alterado e validado nesta sessão.
- 🔴 **Ação manual necessária** — não pode ser feito por edição de código (acesso a serviço
  externo, operação destrutiva que exige confirmação explícita do usuário).

---

## 1. Credenciais movidas para `.env` — ✅ Feito

Senha do MySQL e login/senha do sistema não estão mais hardcoded no código.

- [`config/env.php`](config/env.php) — loader simples de `.env` (`function env(string $key, ?string $default)`), sem dependências.
- [`.env.example`](.env.example) — versionado, só com os nomes das chaves.
- `.env` — **não versionado** (está no `.gitignore`), criado localmente com os valores que já
  estavam em uso (para não quebrar o ambiente atual). Contém `DB_HOST/DB_NAME/DB_USER/DB_PASS`,
  `AUTH_USER`, `AUTH_PASS_HASH` (agora um hash `password_hash`, não mais texto puro) e
  `REMEMBER_SECRET`.
- [`config/database.php`](config/database.php) e
  [`app/Controllers/AuthController.php`](app/Controllers/AuthController.php) passaram a ler
  dessas variáveis. `AuthController::login()` agora usa `password_verify()` em vez de comparar
  string.

⚠️ Os valores atuais no `.env` local **são os mesmos que já estavam expostos publicamente no
GitHub** (ver item 10.1) — funcionam para não travar o dev, mas precisam ser trocados por
valores novos em produção.

**Algoritmo de hash — bcrypt + salt (pedido explícito do usuário):** `password_hash()` com
`PASSWORD_BCRYPT` já implementa bcrypt com salt aleatório único gerado pelo próprio PHP e
embutido no hash (`$2y$10$<22 chars de salt><31 chars de hash>`) — não existe "salt separado" a
gerenciar, isso seria o padrão pré-`password_hash` (PHP < 5.5), hoje considerado anti-padrão.
Trocamos `PASSWORD_DEFAULT` por `PASSWORD_BCRYPT` explícito em
[`.env.example`](.env.example) para fixar o algoritmo (`PASSWORD_DEFAULT` pode mudar de
algoritmo em versões futuras do PHP). `password_verify()` já era algoritmo-agnóstico, não
precisou mudar. Hash local em `.env` regenerado com `PASSWORD_BCRYPT` e testado (login OK).

---

## 2. `.gitignore` + bloqueio de dotfiles no `.htaccess` — ✅ Feito e testado

- [`.gitignore`](.gitignore) criado (ignora `.env`).
- [`.htaccess`](.htaccess) ganhou `RewriteRule "(^|/)\." - [F,L]` antes das regras existentes,
  bloqueando qualquer acesso direto a caminhos com dotfiles (`.git`, `.env`, `.htaccess`, etc).
- Testado: `GET /.env` → 403, `GET /.git/config` → 403, assets normais (`/assets/css/...`) → 200.

---

## 3. Bypass de autenticação no cookie "lembrar-me" — ✅ Feito e testado

- Novo [`app/Core/RememberMe.php`](app/Core/RememberMe.php): cookie passa a carregar
  `expiração.hmac`, assinado com `hash_hmac('sha256', ...)` usando `REMEMBER_SECRET` (novo, só no
  `.env`). Validação usa `hash_equals()`.
- `index.php` e `AuthController::logout()` atualizados para usar `RememberMe::valido()` /
  `RememberMe::emitir()` / `RememberMe::limpar()`.
- Cookie ganha flag `secure` automaticamente quando a requisição é HTTPS.
- **Testado:** cookie forjado antigo (`revizzi_lembrar=1`) → redireciona para `/login` (bypass
  fechado). Cookie assinado corretamente → autentica normalmente.

---

## 4. Proteção CSRF nas rotas de API e no login — ✅ Feito e testado

- Token gerado uma vez por sessão em `$_SESSION['csrf_token']` (`index.php`), exposto via
  `window.CSRF_TOKEN` no [layout principal](app/Views/layouts/main.php).
- `Controller::requireCsrf()` — novo helper em
  [`app/Controllers/Controller.php`](app/Controllers/Controller.php) — valida o header
  `X-CSRF-Token` com `hash_equals()` e responde 403 se inválido.
- Aplicado em `LancamentoController::store/update/destroy` e `OrcamentoController::store/destroy`.
- Login (`AuthController::login()`) valida um campo oculto `csrf_token` no formulário
  ([`auth/login.php`](app/Views/auth/login.php)).
- `dashboard.js` e o script inline de `orcamentos/index.php` passaram a enviar o header
  `X-CSRF-Token` em todo `fetch` de POST/PUT/DELETE.
- **Testado:** POST sem token → 403 `{"erro":"Token CSRF inválido ou ausente"}`; com token → 200
  e grava no banco.
- CSP (item 7) precisou de `script-src 'self' 'unsafe-inline'` porque essas views usam `<script>`
  inline — ver nota no próprio `index.php`. Melhoria futura: mover para arquivos externos + nonce.

---

## 5. XSS em `dashboard.js` (`innerHTML`) — ✅ Feito e testado

[`assets/js/dashboard.js`](assets/js/dashboard.js) `adicionarNaTabela()` agora cria `<td>` via
`document.createElement` + `textContent` em vez de `innerHTML` com template string.

**Testado:** cadastrando um lançamento com descrição `<img src=x onerror=alert(1)>`, o valor
aparece escapado como texto (`&lt;img ...&gt;`) na tabela — não executa mais.

---

## 6. Rate limiting no login — ✅ Feito e testado

Em `AuthController`: `$_SESSION['login_tentativas']` conta falhas; a partir da 3ª tentativa
falha, a próxima exige espera progressiva (`min(30, (tentativas-2)*5)` segundos) antes de
processar de novo — mensagem "Muitas tentativas. Tente novamente em Ns.". Zerado ao logar com
sucesso.

**Testado:** 4ª tentativa consecutiva errada bloqueou com "Tente novamente em 4s."

---

## 7. Headers de segurança + `session_regenerate_id` — ✅ Feito

Em `index.php`: `X-Content-Type-Options`, `X-Frame-Options: DENY`, `Referrer-Policy`, e uma CSP
básica (`default-src 'self'`, permitindo Google Fonts e inline styles/scripts — ver nota do item
4). `AuthController::login()` chama `session_regenerate_id(true)` após autenticar com sucesso.

---

## 8. Migration da tabela `lancamentos` — ✅ Feito (schema inferido)

Criado [`database/migrations/001_lancamentos.sql`](database/migrations/001_lancamentos.sql) com
o schema inferido do uso no código (`Lancamento.php` / `LancamentoController.php`).

⚠️ **Foi inferido, não extraído do banco real.** A tabela já existe em dev/produção com dados reais
(confirmado — a página `/entradas` mostra registros existentes). Antes de considerar essa
migration "fonte da verdade", rode `SHOW CREATE TABLE lancamentos;` no banco real e compare —
ver item 10.3.

---

## 9. `RewriteBase` do `.htaccess` — 🔴 Ação manual (no momento do deploy)

Não alterado nesta sessão de propósito: o valor correto depende do ambiente (local: subpasta do
XAMPP `/projetos-estudos/financeiro-revizzi/`; produção: raiz do domínio
`sistema.derickrosa.com.br`, ou seja `/`). Mudar agora quebraria o dev local. **No deploy**,
trocar em [`.htaccess`](.htaccess).

---

## 10. Ações manuais que exigem acesso/decisão do usuário — 🔴

Nenhuma destas pode ser feita por edição de código:

1. **Rotacionar a senha real do MySQL** (`app_admin` / a senha antiga que estava no código) —
   continua exposta no histórico do Git e no GitHub público (branch `master` de
   `derickdarosa/financeiro-revizzi`), independente da mudança para `.env` feita aqui. Trocar no
   servidor MySQL de produção/dev e atualizar `DB_PASS` no `.env`.
2. **Trocar a senha de login também** — o par `jonathan`/senha antiga também estava público no
   GitHub. Gerar novo hash com `php -r "echo password_hash('nova-senha', PASSWORD_DEFAULT);"` e
   colocar em `AUTH_PASS_HASH` no `.env` de produção.
3. **Repositório GitHub público** — considerar tornar privado e/ou limpar o histórico do Git
   (remover o commit que introduziu as credenciais, ou reescrever todo o histórico). Reescrever
   histórico publicado é destrutivo (exige force-push) — não fiz isso sem sua confirmação
   explícita. Aviso: mesmo limpando o histórico, quem já clonou o repo pode ter uma cópia — por
   isso rotacionar as credenciais (itens 1 e 2) é mais importante do que limpar o histórico.
4. **Confirmar o schema real da tabela `lancamentos`** em produção contra a migration do item 8.
5. **Definir os valores reais de produção do `.env`** no servidor — o `.env` local usado no dev
   tem os valores antigos (já comprometidos); produção precisa de credenciais novas.
6. **`RewriteBase`** — ver item 9.

---

## Como testar localmente (para retomar em outra sessão)

App local roda em `http://localhost:8080/projetos-estudos/financeiro-revizzi/` (Apache do XAMPP
nesta máquina está na porta 8080, não 80 — IIS ocupa a 80). Login de dev continua
`jonathan` / `revizzitimao` (valores antigos, mantidos só localmente — ver item 10.2).

---

## Backlog (não bloqueante, do PRODUCAO.md)

Auth via banco com tabela `usuarios`, categorias dinâmicas, filtro de data, visão semanal real,
exportação de relatório (PDF/CSV), múltiplos usuários — mantidos como estavam, fora do escopo
desta rodada de correções.
