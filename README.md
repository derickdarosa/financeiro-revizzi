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
- Dashboard semanal (seg–sex): visão por semana, calculadora de meta mensal e projeção com barra de progresso
- Análises mensais: 4 cards com delta vs mês anterior, breakdown por categoria e entradas por forma de pagamento
- Navegação por hambúrguer no header (Home, Análises, Sair)
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
| Método | URL | Descrição |
|--------|-----|-----------|
| GET | `/` | Redireciona para `/relatorios` |
| GET | `/relatorios` | Dashboard semanal |
| GET | `/analises` | Análises mensais (`?mes=YYYY-MM`) |
| GET | `/entradas` | Lançamentos de entradas |
| GET | `/saidas-var` | Saídas variáveis |
| GET | `/saidas-fix` | Saídas fixas |
| GET | `/login` | Tela de login |
| POST | `/login` | Autenticação |
| GET | `/logout` | Encerrar sessão |
| POST | `/api/lancamentos` | Criar lançamento |
| PUT | `/api/lancamentos/{id}` | Atualizar lançamento |
| DELETE | `/api/lancamentos/{id}` | Excluir lançamento |