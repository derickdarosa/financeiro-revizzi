# Financeiro Revizzi

Sistema interno de controle financeiro para a **Revizzi Centro Automotivo**. Substitui planilhas manuais registra entradas e saídas, exibe balanço semanal, calculadora de meta mensal e precificação de peças.

## Stack

- **Backend:** PHP 8+ (MVC sem framework)
- **Frontend:** HTML + CSS + JS vanilla
- **Banco:** MySQL (PDO)
- **Fonte:** DM Sans (Google Fonts)

## Funcionalidades

- Registro de entradas, saídas variáveis e saídas fixas
- Tabela de lançamentos com edição e exclusão via bottom sheet
- Calculadora de precificação com margens de 50%, 55%, 60% e 65%
- Dashboard de relatórios: visão semanal (seg–sex), calculadora de meta mensal e projeção com barra de progresso
- Autenticação por sessão PHP com opção "lembrar-me" (cookie 30 dias)

## Estrutura

```
financeiro-revizzi/
├── index.php                  — front controller + auth guard
├── .htaccess                  — redireciona tudo para index.php
├── config/
│   └── database.php           — conexão PDO (singleton)
├── assets/
│   ├── css/dashboard.css
│   ├── js/dashboard.js
│   └── img/
└── app/
    ├── Core/Router.php
    ├── Controllers/
    │   ├── Controller.php
    │   ├── AuthController.php
    │   ├── LancamentoController.php
    │   └── RelatorioController.php
    ├── Models/
    │   └── Lancamento.php
    └── Views/
        ├── layouts/main.php
        ├── partials/
        ├── auth/
        ├── lancamentos/
        └── relatorios/
```

## Rotas

| Método | URL | Descrição |
|--------|-----|-----------|
| GET | `/` | Dashboard / relatórios |
| GET | `/entradas` | Lançamentos de entradas |
| GET | `/saidas-var` | Saídas variáveis |
| GET | `/saidas-fix` | Saídas fixas |
| GET | `/login` | Tela de login |
| POST | `/api/lancamentos` | Criar lançamento |
| PUT | `/api/lancamentos/{id}` | Atualizar lançamento |
| DELETE | `/api/lancamentos/{id}` | Excluir lançamento |