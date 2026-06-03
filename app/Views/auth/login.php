<?php
$mostrarNav  = false;
$extraStyles = <<<HTML
  <style>
    main {
      min-height: calc(100vh - 60px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      font-family: "DM Sans";
    }
    .login-card {
      background: var(--cor-branco-GM);
      border-radius: var(--bdr-lg);
      box-shadow: 0 4px 16px rgba(0,0,0,0.10);
      border: 1px solid #7070701e;
      padding: 2.4rem 2rem;
      width: 100%;
      max-width: 380px;
    }
    .login-titulo {
      font-size: 2rem;
      font-weight: 600;
      color: var(--cor-azul);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 0.3rem;
    }
    .login-sub {
      font-size: 1rem;
      color: var(--cor-cinza);
      margin-bottom: 2rem;
    }
    .login-field {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-bottom: 1.2rem;
    }
    .login-field label {
      font-size: 1rem;
      font-weight: 600;
      color: var(--cor-cinza);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    .login-field input {
      border: 1px solid #dcdfe4;
      border-radius: var(--bdr-sm);
      background: white;
      padding: 11px 14px;
      font-size: 1rem;
      color: var(--cor-carvao-ford);
      width: 100%;
      transition: border-color 0.15s, box-shadow 0.15s;
    }
    .login-field input:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 4px rgba(59,130,246,0.12);
    }
    .login-field input::placeholder { color: #adb5bd; }
    .btn-login {
      width: 100%;
      background: var(--cor-azul);
      color: white;
      border: none;
      border-radius: var(--bdr-sm);
      padding: 12px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      margin-top: 0.4rem;
      transition: background 0.15s;
    }
    .btn-login:hover { background: #1e3f6e; }
    .login-lembrar {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 1.2rem;
      cursor: pointer;
      width: fit-content;
    }
    .login-lembrar input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: var(--cor-azul);
      cursor: pointer;
    }
    .login-lembrar span {
      font-size: 1rem;
      color: var(--cor-cinza);
    }
    .login-erro {
      background: #fee2e2;
      color: #dc2626;
      border-radius: var(--bdr-sm);
      padding: 10px 14px;
      font-size: 1rem;
      font-weight: 600;
      margin-bottom: 1.2rem;
    }
    @media (max-width: 767px){
      main{
        min-height: 700px;
      }
    }
  </style>
HTML;
?>

<div class="login-card">
  <p class="login-titulo">Revizzi</p>
  <p class="login-sub">Acesse sua conta para continuar</p>

  <?php if (!empty($erro)): ?>
    <div class="login-erro"><?= htmlspecialchars($erro) ?></div>
  <?php endif; ?>

  <form method="POST" action="login">
    <div class="login-field">
      <label for="usuario">Usuário</label>
      <input type="text" id="usuario" name="usuario"
             placeholder="seu usuário"
             autocomplete="username"
             value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>">
    </div>
    <div class="login-field">
      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha"
             placeholder="••••••••"
             autocomplete="current-password">
    </div>
    <label class="login-lembrar">
      <input type="checkbox" name="lembrar" value="1">
      <span>Lembrar-me</span>
    </label>
    <button type="submit" class="btn-login">Entrar</button>
  </form>
</div>
