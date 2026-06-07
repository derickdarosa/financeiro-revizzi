<?php
$extraStyles = <<<'HTML'
<style>
  #analises-wrapper {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    padding: 0 0 2rem;
  }
  .secao-an {
    background: var(--cor-branco-GM);
    border-radius: var(--bdr-md);
    padding: 1.4rem 1.6rem;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    border: 1px solid #7070701e;
  }
  .secao-titulo-an {
    font-size: 1rem;
    font-weight: 600;
    color: var(--cor-cinza);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 1.2rem;
  }
  .nav-mes {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    margin-bottom: 1.4rem;
  }
  .btn-mes {
    background: var(--cor-azul);
    color: white;
    border: none;
    border-radius: var(--bdr-sm);
    width: 32px;
    height: 32px;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: background 0.15s;
    flex-shrink: 0;
  }
  .btn-mes:hover  { background: #1e3f6e; }
  .btn-mes.off    { background: var(--cor-branco-cinza); pointer-events: none; }
  #label-mes {
    font-weight: 600;
    font-size: 1.1rem;
    color: var(--cor-carvao-ford);
    flex: 1;
    text-align: center;
  }
  .cards-an {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
  }
  .card-an {
    background: white;
    border-radius: var(--bdr-md);
    padding: 1rem 1.2rem;
    border: 1px solid var(--cor-borda);
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
  }
  .card-an .lbl {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--cor-cinza);
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }
  .card-an .val {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--cor-carvao-ford);
  }
  .card-an .val.verde    { color: #16a34a; }
  .card-an .val.vermelho { color: #dc2626; }
  .card-an .val.azul     { color: var(--cor-azul); }
  .card-an .delta {
    font-size: 0.85rem;
    font-weight: 600;
    margin-top: 2px;
  }
  .delta.pos { color: #16a34a; }
  .delta.neg { color: #dc2626; }
  .delta.neu { color: var(--cor-cinza); }
  .tabela-an {
    width: 100%;
    border-collapse: collapse;
    font-size: 1rem;
  }
  .tabela-an thead th {
    background: var(--cor-carvao-ford);
    color: white;
    padding: 9px 14px;
    text-align: center;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
  }
  .tabela-an thead th:first-child { border-radius: var(--bdr-sm) 0 0 0; text-align: left; }
  .tabela-an thead th:last-child  { border-radius: 0 var(--bdr-sm) 0 0; }
  .tabela-an tbody td {
    padding: 9px 14px;
    border-bottom: 1px solid var(--cor-borda);
    color: var(--cor-carvao-ford);
    text-align: center;
  }
  .tabela-an tbody td:first-child { text-align: left; }
  .tabela-an tbody tr:nth-child(even) { background: var(--cor-tabela-zebra); }
  .tabela-an tbody tr:last-child td  { border-bottom: none; }
  .badge-tipo {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 99px;
    font-size: 0.85rem;
    font-weight: 600;
  }
  .badge-entrada  { background: #dcfce7; color: #16a34a; }
  .badge-saida    { background: #fee2e2; color: #dc2626; }
  .grid-pag {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-top: 0.5rem;
  }
  .card-pag {
    background: white;
    border-radius: var(--bdr-md);
    padding: 0.9rem 1rem;
    border: 1px solid var(--cor-borda);
    text-align: center;
  }
  .card-pag .lbl {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--cor-cinza);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
  }
  .card-pag .val {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--cor-azul);
  }
  .vazio {
    color: var(--cor-cinza);
    font-style: italic;
    padding: 1rem 0;
    font-size: 1rem;
  }
  .tabela-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
  .th-mob  { display: none; }
  .th-desk { display: inline; }
  @media (max-width: 880px) {
    .cards-an         { grid-template-columns: 1fr 1fr; }
    .grid-pag         { grid-template-columns: 1fr 1fr; }
    #analises-wrapper { padding: 1rem 0 2rem; }
  }
  @media (max-width: 767px) {
    #analises-wrapper { padding: 0.8rem 0 2rem; }
    .secao-an         { padding: 8px; min-width: 0; }
    .card-an .val     { font-size: 1.1rem; }
    .cards-an         { gap: 0.4rem; }
    .grid-pag         { gap: 0.4rem; }
    .secao-titulo-an    { text-align: center; }
    #nav-header         { padding: 12px 0 0; }
    #nav-pages          { margin-bottom: 0; }
    .th-mob  { display: inline; }
    .th-desk { display: none; }
    .tabela-an              { table-layout: fixed; width: 100%; }
    .tabela-an th,
    .tabela-an td           { padding: 6px 4px; }
    .tabela-an th:nth-child(1),
    .tabela-an td:nth-child(1) { width: 20%; }
    .tabela-an th:nth-child(2),
    .tabela-an td:nth-child(2) { width: 30%; }
    .tabela-an th:nth-child(3),
    .tabela-an td:nth-child(3) { width: 30%; }
    .tabela-an th:nth-child(4),
    .tabela-an td:nth-child(4) { width: 20%; text-align: center; }
    .badge-tipo             { padding: 2px 6px; }
  }
  @media (max-width: 480px) {
    .cards-an { grid-template-columns: 1fr 1fr; }
    .grid-pag { grid-template-columns: 1fr 1fr; }
  }
</style>
HTML;

?>
<?php
$categoriaLabels = [
    'pecas'      => 'Peças',
    'escritorio' => 'Escritório',
    'oficina'    => 'Oficina',
    'servicos'   => 'Serviços',
    'prejuizo'   => 'Prejuízo',
    'salarios'   => 'Salário',
];
$tipoLabel = [
    'entrada'        => ['label' => 'Entrada',  'badge' => 'badge-entrada'],
    'saida_variavel' => ['label' => 'Saída Var', 'badge' => 'badge-saida'],
    'saida_fixa'     => ['label' => 'Saída Fix', 'badge' => 'badge-saida'],
];
$pagamentoLabels = [
    'pix'      => 'Pix',
    'debito'   => 'Débito',
    'credito'  => 'Crédito',
    'dinheiro' => 'Dinheiro',
];

function deltaAn(float $atual, float $anterior, bool $inverso = false): string {
    if ($anterior == 0) return '<span class="delta neu">—</span>';
    $pct    = (($atual - $anterior) / $anterior) * 100;
    $pos    = $inverso ? $pct < 0 : $pct >= 0;
    $classe = $pos ? 'pos' : 'neg';
    $sinal  = $pct >= 0 ? '+' : '';
    return "<span class=\"delta {$classe}\">{$sinal}" . number_format($pct, 1) . "% vs mês ant.</span>";
}

function fmtAn(float $v): string {
    return 'R$ ' . number_format($v, 2, ',', '.');
}

$totalBreakdown = array_sum(array_column($breakdown, 'total'));
$mesProxDesabilitado = $mesProx > $mesAtual;
?>

<div id="analises-wrapper">

  <section class="secao-an">
    <div class="nav-mes">
      <a href="analises?mes=<?= $mesPrev ?>" class="btn-mes">&#8249;</a>
      <span id="label-mes"><?= htmlspecialchars($mesLabel) ?></span>
      <a href="analises?mes=<?= $mesProx ?>" class="btn-mes <?= $mesProxDesabilitado ? 'off' : '' ?>">&#8250;</a>
    </div>

    <div class="cards-an">
      <div class="card-an">
        <p class="lbl">Entradas</p>
        <span class="val verde"><?= fmtAn($entradas) ?></span>
        <?= deltaAn($entradas, $entrPrev) ?>
      </div>
      <div class="card-an">
        <p class="lbl">Saídas</p>
        <span class="val vermelho"><?= fmtAn($saidas) ?></span>
        <?= deltaAn($saidas, $saiPrev, true) ?>
      </div>
      <div class="card-an">
        <p class="lbl">Resultado</p>
        <span class="val <?= $resultado >= 0 ? 'verde' : 'vermelho' ?>"><?= fmtAn($resultado) ?></span>
        <?= deltaAn($resultado, $entrPrev - $saiPrev) ?>
      </div>
      <div class="card-an">
        <p class="lbl">Margem</p>
        <span class="val azul"><?= number_format($margem, 1) ?>%</span>
        <span class="delta neu">sobre faturamento</span>
      </div>
    </div>
  </section>

  <section class="secao-an">
    <p class="secao-titulo-an">Breakdown por Categoria</p>
    <?php if (empty($breakdown)): ?>
      <p class="vazio">Nenhum lançamento neste período.</p>
    <?php else: ?>
    <div class="tabela-scroll">
    <table class="tabela-an">
      <thead>
        <tr>
          <th><span class="th-desk">Categoria</span><span class="th-mob">Cat.</span></th>
          <th>Tipo</th>
          <th>Total</th>
          <th><span class="th-desk">% do período</span><span class="th-mob">%</span></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($breakdown as $row):
          $label  = $categoriaLabels[$row['categoria']] ?? $row['categoria'];
          $tipo   = $tipoLabel[$row['tipo']] ?? ['label' => $row['tipo'], 'badge' => ''];
          $pct    = $totalBreakdown > 0 ? ($row['total'] / $totalBreakdown) * 100 : 0;
        ?>
        <tr>
          <td><?= $label ?></td>
          <td><span class="badge-tipo <?= $tipo['badge'] ?>"><?= $tipo['label'] ?></span></td>
          <td><?= fmtAn((float)$row['total']) ?></td>
          <td><?= number_format($pct, 1) ?>%</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <?php endif; ?>
  </section>

  <section class="secao-an">
    <p class="secao-titulo-an">Entradas por Forma de Pagamento</p>
    <?php if (empty($pagamentos)): ?>
      <p class="vazio">Nenhuma entrada neste período.</p>
    <?php else: ?>
    <div class="grid-pag">
      <?php foreach ($pagamentos as $pag):
        $label = $pagamentoLabels[$pag['forma_pagamento']] ?? $pag['forma_pagamento'];
      ?>
      <div class="card-pag">
        <p class="lbl"><?= $label ?></p>
        <span class="val"><?= fmtAn((float)$pag['total']) ?></span>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </section>

</div>
