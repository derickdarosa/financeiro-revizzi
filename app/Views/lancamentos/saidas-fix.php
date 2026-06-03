<?php
$extraStyles = '<style>#tab-registros th { background-color: var(--cor-dim-gray); }</style>';
?>
<div id="container-fluxo">
  <div id="bloco-form">

    <div class="form-dados">
      <?php include __DIR__ . '/../partials/_form-lancamento.php'; ?>
    </div>

    <?php include __DIR__ . '/../partials/_bloco-tabela.php'; ?>

  </div>
</div>

<?php include __DIR__ . '/../partials/_cards-resumo.php'; ?>
