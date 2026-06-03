# Checklist de Produção — Financeiro Revizzi

## Obrigatório antes de subir

- [ ] **`.htaccess`** — mudar `RewriteBase` para `/` (atualmente está local: `/projetos-estudos/financeiro-revizzi/`)
- [ ] **Credenciais de acesso** — trocar `admin / revizzitimao` em `app/Controllers/AuthController.php` linha 28 por usuário e senha seguros
- [ ] **Banco de dados** — confirmar que a tabela `lancamentos` existe e a conexão em `config/database.php` está correta

---

## Para o cliente começar a usar

- [ ] Informar ao cliente o endereço de acesso: `https://sistema.derickrosa.com.br`
- [ ] Passar o usuário e senha definidos acima
- [ ] Orientar que o sistema funciona melhor no celular (layout mobile-first)
- [ ] Explicar as 3 páginas: Entradas, Saídas Variáveis e Saídas Fixas

---

## Melhorias futuras (backlog)

- [ ] **Auth via banco** — criar tabela `usuarios` com senha hasheada (`password_hash`) em vez de credencial hardcoded
- [ ] **Categorias dinâmicas** — tabela `categorias` no banco para adicionar sem alterar código
- [ ] **Filtro de data** na tabela de lançamentos (hoje carrega todos os registros)
- [ ] **Visão semanal real** — conectar os dados do banco à tabela seg–sex do dashboard (hoje usa dados do mês, não por dia da semana)
- [ ] **Exportar relatório** — PDF ou CSV do período selecionado
- [ ] **Múltiplos usuários** — separar acesso por responsável (Jonathan / Rubens)
