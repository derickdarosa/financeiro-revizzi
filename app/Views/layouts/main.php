<?php $extraStyles ??= ''; $conteudo ??= ''; $extraScripts ??= ''; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($titulo ?? 'Revizzi') ?></title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/dashboard.css?v=<?= time() ?>">
  <?= $extraStyles ?>
</head>

<body>
  <div id="wrapper">

    <header>
      <div>
        <a href="relatorios" id="logo-link">
          <img src="assets/img/teste.webp" alt="logo" id="logo">
          <span>Gestão Inteligente</span>
        </a>
      </div>
      <?php if (!empty($_SESSION['autenticado'])): ?>
        <a href="logout" id="btn-logout">Sair</a>
      <?php endif; ?>
    </header>

    <?php if ($mostrarNav ?? true): ?>
      <?php include __DIR__ . '/../partials/_nav.php'; ?>
    <?php endif; ?>

    <main>
      <?= $conteudo ?>
    </main>

  </div>
  <script>window.BASE = '<?= rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') ?>';</script>
  <script src="assets/js/dashboard.js"></script>
  <?= $extraScripts ?>
</body>

</html>
