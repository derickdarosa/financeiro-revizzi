<?php
function fmt(float $v): string {
    return 'R$ ' . number_format($v, 2, ',', '.');
}
$resumo ??= ['entradas' => 0, 'saidas' => 0, 'balanco' => 0, 'fixos' => 0, 'total' => 0];
?>
<div id="container-exibicoes">
  <div class="card-resumo" id="card-entradas">
    <p class="card-label">Entradas</p>
    <span class="card-valor"><?= fmt($resumo['entradas']) ?></span>
  </div>
  <span class="icons">-</span>
  <div class="card-resumo" id="card-saidas">
    <p class="card-label">Saídas</p>
    <span class="card-valor"><?= fmt($resumo['saidas']) ?></span>
  </div>
  <span class="icons">=</span>
  <div class="card-resumo" id="card-balanco">
    <p class="card-label">Balanço</p>
    <span class="card-valor"><?= fmt($resumo['balanco']) ?></span>
  </div>
  <span class="icons">-</span>
  <div class="card-resumo" id="card-fixos">
    <p class="card-label">Custos Fixos</p>
    <span class="card-valor"><?= fmt($resumo['fixos']) ?></span>
  </div>
  <span class="icons">=</span>
  <div class="card-resumo" id="card-total">
    <p class="card-label">Total da Semana</p>
    <span class="card-valor"><?= fmt($resumo['total']) ?></span>
  </div>
</div>
