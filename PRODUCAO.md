# Checklist de Produção — Financeiro Revizzi

> Atualizado após a rodada de correções de segurança — ver [`SECURITY_FIXES.md`](SECURITY_FIXES.md)
> para o detalhe/motivo de cada mudança de código. As senhas atuais (dev) já vazaram no GitHub
> público; para v1 isso foi aceito como ok (ambiente de teste), mas os passos abaixo garantem que
> a v1 em produção não suba com essas mesmas credenciais.

## Obrigatório antes de subir

- [ ] **Criar o `.env` de produção no servidor** (copiar de [`.env.example`](.env.example) —
      `.env` nunca é enviado por Git, precisa ser criado manualmente no servidor):
  - [ ] `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` — senha do MySQL **de produção** (não reusar a
        senha antiga que estava hardcoded/vazada no GitHub)
  - [ ] `AUTH_USER` e `AUTH_PASS_HASH` — gerar com
        `php -r "echo password_hash('nova-senha', PASSWORD_BCRYPT);"` (não reusar `jonathan`/senha
        antiga, também vazada)
  - [ ] `REMEMBER_SECRET` — gerar com `php -r "echo bin2hex(random_bytes(32));"`
- [ ] **`.htaccess`** — mudar `RewriteBase` para `/` (atualmente está local:
      `/projetos-estudos/financeiro-revizzi/`)
- [ ] **Banco de dados** — confirmar que a tabela `lancamentos` existe em produção e bate com
      [`database/migrations/001_lancamentos.sql`](database/migrations/001_lancamentos.sql)
      (schema foi inferido do código, não extraído do banco real — conferir com
      `SHOW CREATE TABLE lancamentos;`); rodar `002_orcamentos.sql` se as tabelas de orçamento
      ainda não existirem
- [ ] **Não enviar `.git/` nem `.env` para o servidor** — mesmo com o `.htaccess` bloqueando
      acesso direto (`(^|/)\.` → 403), o ideal é nem fazer upload dessas pastas/arquivos
- [ ] **HTTPS ativo** no domínio final — o cookie "lembrar-me" só ganha a flag `secure` quando a
      requisição chega via HTTPS (`app/Core/RememberMe.php`), então sem HTTPS ele funciona mas
      fica menos protegido
- [ ] **`display_errors` desligado** no `php.ini` de produção (evita vazar caminho/stack trace)
- [ ] **Testar depois do deploy**: login, criar/editar/excluir lançamento, "lembrar-me", logout —
      nessa ordem, num ambiente limpo (aba anônima)

---

## Para o cliente começar a usar

- [ ] Informar ao cliente o endereço de acesso: `https://sistema.derickrosa.com.br`
- [ ] Passar o usuário e senha definidos acima
- [ ] Orientar que o sistema funciona melhor no celular (layout mobile-first)
- [ ] Explicar as 3 páginas: Entradas, Saídas Variáveis e Saídas Fixas

---

## Melhorias futuras (backlog)

- [ ] **Auth via banco** — a senha já é hasheada com bcrypt (`.env` via `AUTH_PASS_HASH`), mas
      ainda é um único usuário fixo; falta criar tabela `usuarios` para suportar múltiplos logins
- [ ] **Categorias dinâmicas** — tabela `categorias` no banco para adicionar sem alterar código
- [ ] **Filtro de data** na tabela de lançamentos (hoje carrega todos os registros)
- [ ] **Visão semanal real** — conectar os dados do banco à tabela seg–sex do dashboard (hoje usa dados do mês, não por dia da semana)
- [ ] **Exportar relatório** — PDF ou CSV do período selecionado
- [ ] **Múltiplos usuários** — separar acesso por responsável (Jonathan / Rubens)
