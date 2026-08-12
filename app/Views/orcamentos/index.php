<?php
$mostrarNav = false;

$historicoJson = json_encode($historico ?? [], JSON_UNESCAPED_UNICODE);

$extraStyles = <<<'HTML'
<style>
  #orcamento-app {
    --space-2: .5rem; --space-3: .75rem; --space-4: 1rem; --space-5: 1.25rem;
    --space-6: 1.5rem; --space-8: 2rem; --space-10: 2.5rem;
    flex: 1;
    min-width: 0;
    padding: 12px 0 2rem;
    color: var(--cor-carvao-ford);
  }
  #orcamento-app button,
  #orcamento-app input,
  #orcamento-app select { font-size: 1rem; }
  #orcamento-app .app {
    display: grid;
    grid-template-columns: minmax(0, 1.65fr) minmax(300px, .72fr);
    gap: var(--space-5);
    align-items: start;
  }
  #orcamento-app .workspace { display: grid; gap: var(--space-5); min-width: 0; }
  #orcamento-app .hero {
    background: var(--cor-branco-GM);
    border: 1px solid #7070701e;
    border-radius: var(--bdr-md);
    padding: var(--space-5);
    box-shadow: 0 2px 6px rgba(0,0,0,.08);
    display: grid;
    grid-template-columns: 1.2fr auto;
    gap: var(--space-4);
    align-items: center;
  }
  #orcamento-app .hero h1 { margin: 0; font-size: 1.5rem; color: var(--cor-carvao-ford); }
  #orcamento-app .toolbar { display:flex; gap:var(--space-3); flex-wrap:wrap; justify-content:flex-end; }
  #orcamento-app .btn {
    min-height: 40px;
    padding: .5rem 1rem;
    border-radius: var(--bdr-sm);
    border: 1px solid var(--cor-borda);
    background: #fff;
    color: var(--cor-cinza);
    font-weight: 600;
    cursor: pointer;
    transition: background-color .15s ease;
  }
  #orcamento-app .btn:hover { background: var(--cor-branco-GM); }
  #orcamento-app .btn-primary {
    background: var(--cor-azul);
    border-color: var(--cor-azul);
    color: #fff;
  }
  #orcamento-app .btn-primary:hover { background: #1e3f6e; border-color: #1e3f6e; }
  #orcamento-app .board {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-5);
  }
  #orcamento-app .card {
    background: var(--cor-branco-GM);
    border: 1px solid #7070701e;
    border-radius: var(--bdr-md);
    padding: var(--space-6);
    box-shadow: 0 2px 6px rgba(0,0,0,.08);
  }
  #orcamento-app .card h2 {
    margin: 0 0 var(--space-5);
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--cor-cinza);
  }
  #orcamento-app .grid { display:grid; gap: var(--space-4); }
  #orcamento-app .cols-2 { grid-template-columns: 1fr 1fr; }
  #orcamento-app .cols-3 { grid-template-columns: 1fr 1fr 1fr; }
  #orcamento-app label { display:block; margin-bottom:.4rem; font-weight:600; color:#444; }
  #orcamento-app input,
  #orcamento-app select {
    width:100%;
    min-height:40px;
    border-radius: 10px;
    border:1px solid #dcdfe4;
    background: #fafafa;
    color: var(--cor-carvao-ford);
    padding: .6rem .75rem;
    transition: .2s;
  }
  #orcamento-app input:focus,
  #orcamento-app select:focus {
    outline: none;
    border-color: #3b82f6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(59,130,246,.12);
  }
  #orcamento-app .items-card { grid-column: 1 / -1; }
  #orcamento-app .items-head {
    display:flex;
    justify-content:space-between;
    gap:var(--space-4);
    align-items:center;
    margin-bottom:var(--space-5);
    flex-wrap:wrap;
  }
  #orcamento-app .item-list { display:grid; gap: var(--space-4); }
  #orcamento-app .item {
    background: var(--cor-tabela-zebra);
    border: 1px solid var(--cor-borda);
    border-radius: var(--bdr-md);
    padding: var(--space-5);
  }
  #orcamento-app .item-top {
    display:grid;
    grid-template-columns: 88px minmax(0, 1.6fr) minmax(120px, .8fr) 150px 150px auto;
    gap: var(--space-3);
    align-items:end;
  }
  #orcamento-app #removeall {
    margin-right: var(--space-2);
  }

  #orcamento-app .remove {
    min-height:40px;
    border:none;
    border-radius: var(--bdr-sm);
    background:#fef2f2;
    color:#dc2626;
    font-weight: 600;
    padding: .5rem 1rem;
    cursor:pointer;
    transition: background-color .15s ease;
  }
  #orcamento-app .remove:hover { background: #fee2e2; }

  /* ===== SIDEBAR / PREVIEW ===== */
  #orcamento-app .sidebar {
    position: sticky;
    top: var(--space-4);
    align-self: start;
    height: calc(100vh - 6rem);
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
  }
  #orcamento-app .preview-card {
    background:#fff;
    color:#111;
    border:1px solid var(--cor-borda);
    border-radius: var(--bdr-md);
    box-shadow: 0 2px 6px rgba(0,0,0,.08);
    overflow:hidden;
    flex: 1;
    min-height: 0;
    display: flex;
    flex-direction: column;
  }
  #orcamento-app .preview-top {
    padding: var(--space-4) var(--space-5);
    border-bottom:1px solid var(--cor-borda);
    display:grid;
    gap: var(--space-3);
    background: #f8fbfd;
    flex-shrink: 0;
  }
  #orcamento-app .preview-actions { display:flex; gap: var(--space-3); flex-wrap:wrap; }
  #orcamento-app .preview-shell {
    padding: var(--space-4) var(--space-5);
    overflow:auto;
    flex: 1;
    scrollbar-width: thin;
    scrollbar-color: var(--cor-cinza-GM) transparent;
  }
  #orcamento-app .preview-shell::-webkit-scrollbar { width: 10px; }
  #orcamento-app .preview-shell::-webkit-scrollbar-track { background: transparent; }
  #orcamento-app .preview-shell::-webkit-scrollbar-thumb {
    background: var(--cor-cinza-GM);
    border-radius: 999px;
    border: 2px solid transparent;
    background-clip: padding-box;
  }

  /* ===== HISTÓRICO ===== */
  #orcamento-app .historico-card {
    background: var(--cor-branco-GM);
    border: 1px solid #7070701e;
    border-radius: var(--bdr-md);
    box-shadow: 0 2px 6px rgba(0,0,0,.08);
    overflow: hidden;
    flex-shrink: 0;
  }
  #orcamento-app .historico-header {
    padding: var(--space-3) var(--space-4);
    border-bottom: 1px solid var(--cor-borda);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-2);
    cursor: pointer;
    user-select: none;
  }
  #orcamento-app .historico-header strong { color: var(--cor-carvao-ford); }
  #orcamento-app .historico-toggle { color: var(--cor-cinza); }
  #orcamento-app .historico-body {
    max-height: 240px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--cor-cinza-GM) transparent;
  }
  #orcamento-app .historico-body.collapsed { display: none; }
  #orcamento-app .historico-empty {
    padding: var(--space-4);
    color: var(--cor-cinza);
    text-align: center;
  }
  #orcamento-app .historico-item {
    display: grid;
    grid-template-columns: 1fr auto auto;
    gap: var(--space-2);
    align-items: center;
    padding: var(--space-3) var(--space-4);
    border-bottom: 1px solid var(--cor-borda);
  }
  #orcamento-app .historico-item:last-child { border-bottom: none; }
  #orcamento-app .historico-item-info { min-width: 0; }
  #orcamento-app .historico-item-title {
    font-weight: 700;
    color: var(--cor-carvao-ford);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  #orcamento-app .historico-item-meta { color: var(--cor-cinza); margin-top: 2px; }
  #orcamento-app .historico-btn {
    padding: .35rem .7rem;
    border-radius: var(--bdr-sm);
    border: 1px solid var(--cor-borda);
    background: transparent;
    color: var(--cor-cinza);
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
  }
  #orcamento-app .historico-btn:hover { background: var(--cor-branco-GM); }
  #orcamento-app .historico-btn-del {
    background: #fef2f2;
    border-color: #fecaca;
    color: #dc2626;
  }
  #orcamento-app .historico-btn-del:hover { background: #fee2e2; }

  #orcamento-app pre {
    margin:0;
    white-space:pre-wrap;
    font-family: Arial, Helvetica, sans-serif;
    line-height: 1.55;
  }

  /* ===== TOAST ===== */
  #orcamento-toast {
    position: fixed;
    bottom: var(--space-6);
    left: 50%;
    transform: translateX(-50%) translateY(20px);
    background: var(--cor-azul);
    color: #fff;
    padding: .6rem 1.4rem;
    border-radius: var(--bdr-sm);
    font-weight: 700;
    opacity: 0;
    pointer-events: none;
    transition: opacity .2s, transform .2s;
    z-index: 9999;
  }
  #orcamento-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

  /* ===== PRINT / PDF ===== */
  @media print {
    * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }

    @page {
      size: A4 portrait;
      margin: 0;
    }

    body { background: #fff !important; }
    header, #nav-header { display: none !important; }
    main {
      display: block !important;
      max-width: none !important;
      margin: 0 !important;
      padding: 0 !important;
      gap: 0 !important;
    }
    #orcamento-app { padding: 0 !important; }
    #orcamento-app .workspace, #orcamento-app .preview-top, #orcamento-app .historico-card { display:none !important; }
    #orcamento-app .app { display: block; padding: 0; }
    #orcamento-app .sidebar { position: static; height: auto; gap: 0; }
    #orcamento-app .preview-card {
      box-shadow: none;
      border: none;
      display: block;
      height: auto;
      overflow: visible;
    }
    #orcamento-app .preview-shell {
      overflow: visible;
      padding: 0;
      height: auto;
      max-height: none !important;
    }
    #orcamento-app #print-doc {
      display: block !important;
      width: 100%;
      overflow: visible;
    }
    #orcamento-app pre { display: none !important; }

    /* Evita que tabela, totais e rodapé sejam cortados no meio */
    .pd-table { page-break-inside: auto; }
    .pd-table tr { page-break-inside: avoid; page-break-after: auto; }
    .pd-totals { page-break-inside: avoid; }
    .pd-footer { page-break-inside: avoid; }
  }

  /* ===== PRINT DOC (documento impresso — mantém visual próprio de papel/PDF) ===== */
  #orcamento-app #print-doc {
    display: none;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 13px;
    color: #111;
    padding: 28px 32px;
    background: #fff;
  }
  .pd-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 2px solid #1a365b;
  }
  .pd-logo-area { display: flex; align-items: center; gap: 10px; }
  .pd-brand { line-height: 1.2; }
  .pd-brand-name { font-size: 18px; font-weight: 700; color: #1a365b; letter-spacing: .5px; }
  .pd-brand-sub { font-size: 11px; color: #516b88; }
  .pd-oficina-info { text-align: right; font-size: 11px; color: #516b88; line-height: 1.7; }
  .pd-oficina-info strong { display: block; color: #1a365b; font-size: 13px; margin-bottom: 2px; }
  .pd-meta {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
    background: #eef2f6;
    border-radius: 6px;
    padding: 12px 16px;
    margin-bottom: 18px;
  }
  .pd-meta-item label {
    display: block;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #516b88;
    margin-bottom: 2px;
    font-weight: 700;
  }
  .pd-meta-item span { font-weight: 700; color: #1a365b; font-size: 13px; }
  .pd-section-title {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #516b88;
    margin-bottom: 8px;
  }
  .pd-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
    font-size: 12px;
  }
  .pd-table thead tr {
    background: #1a365b;
    color: #fff;
  }
  .pd-table thead th {
    padding: 7px 10px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
  }
  .pd-table thead th:last-child { text-align: right; }
  .pd-table tbody tr { border-bottom: 1px solid #e7edf3; }
  .pd-table tbody tr:nth-child(even) { background: #f7f9fb; }
  .pd-table tbody td { padding: 7px 10px; vertical-align: middle; }
  .pd-table tbody td:last-child { text-align: right; font-weight: 700; }
  .pd-badge-cortesia {
    display: inline-block;
    background: #dcfce7;
    color: #166534;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    border-radius: 3px;
    padding: 1px 5px;
    margin-left: 5px;
    vertical-align: middle;
  }
  .pd-totals {
    margin-left: auto;
    width: 260px;
    margin-bottom: 18px;
  }
  .pd-totals table { width: 100%; border-collapse: collapse; font-size: 12px; }
  .pd-totals td { padding: 5px 10px; }
  .pd-totals tr:last-child { border-top: 2px solid #1a365b; }
  .pd-totals tr:last-child td {
    font-size: 14px;
    font-weight: 700;
    color: #1a365b;
    padding-top: 8px;
  }
  .pd-totals td:last-child { text-align: right; }
  .pd-footer {
    margin-top: 24px;
    padding-top: 12px;
    border-top: 1px solid #e7edf3;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    font-size: 11px;
    color: #516b88;
  }
  .pd-assinatura { text-align: center; }
  .pd-assinatura-linha {
    border-top: 1px solid #aaa;
    width: 200px;
    margin: 0 auto 4px;
  }

  /* ===== RESPONSIVO ===== */
  @media (max-width: 1280px) {
    #orcamento-app .board { grid-template-columns: 1fr; }
    #orcamento-app .item-top { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 1080px) {
    #orcamento-app { padding: 1rem 0 2rem; }
    #orcamento-app .app { grid-template-columns: 1fr; }
    #orcamento-app .sidebar { position: relative; top: 0; height: auto; }
    #orcamento-app .preview-shell { max-height: 400px; }
    #orcamento-app .hero { grid-template-columns: 1fr; }
    #orcamento-app .toolbar { justify-content:flex-start; }
  }
  @media (max-width: 720px) {
    #orcamento-app { padding: 0.8rem 0 2rem; }
    #orcamento-app .app { gap: var(--space-4); }
    #orcamento-app .card, #orcamento-app .hero { padding: var(--space-5); }
    #orcamento-app .cols-2, #orcamento-app .cols-3, #orcamento-app .item-top { grid-template-columns: 1fr; }
  }
</style>
HTML;
?>
<div id="orcamento-toast"></div>

<div id="orcamento-app">
  <div class="app">
    <!-- WORKSPACE -->
    <section class="workspace">
      <header class="hero">
        <div>
          <h1>Orçamentos</h1>
        </div>
        <div class="toolbar">
          <button class="btn" id="loadExample" type="button">Carregar exemplo</button>
          <button class="btn" id="saveOrcamento" type="button">Salvar orçamento</button>
        </div>
      </header>

      <div class="board">
        <!-- DADOS DA OFICINA -->
        <section class="card" style="grid-column: 1 / -1;">
          <h2>Dados da oficina</h2>
          <div class="grid cols-3">
            <div>
              <label for="oficinaNome">Nome da oficina</label>
              <input id="oficinaNome" placeholder="Ex.: Revizzi Centro Automotivo" />
            </div>
            <div>
              <label for="oficinaTelefone">Telefone / WhatsApp</label>
              <input id="oficinaTelefone" placeholder="Ex.: (47) 98486-5739" />
            </div>
            <div>
              <label for="oficinaEndereco">Endereço</label>
              <input id="oficinaEndereco" placeholder="Ex.: Rua Benedito Bernz, 289 - Gaspar/SC" />
            </div>
          </div>
        </section>

        <!-- DADOS PRINCIPAIS -->
        <section class="card">
          <h2>Dados principais</h2>
          <div class="grid cols-2">
            <div>
              <label for="modelo">Modelo</label>
              <input id="modelo" placeholder="Ex.: Onix 1.0" />
            </div>
            <div>
              <label for="cliente">Cliente</label>
              <input id="cliente" placeholder="Ex.: João da Silva" />
            </div>
          </div>
          <div class="grid" style="margin-top:1rem;">
            <div>
              <label for="servico">Serviço / título da seção</label>
              <input id="servico" placeholder="Ex.: Troca de óleo e filtros" />
            </div>
          </div>
        </section>

        <!-- TOTAIS -->
        <section class="card">
          <h2>Totais</h2>
          <div class="grid cols-2">
            <div>
              <label for="maoDeObra">Mão de obra técnica</label>
              <input id="maoDeObra" value="0" inputmode="decimal" />
            </div>
            <div>
              <label for="totalManual">Total manual opcional</label>
              <input id="totalManual" placeholder="Deixe vazio para calcular" inputmode="decimal" />
            </div>
          </div>
        </section>

        <!-- ITENS -->
        <section class="card items-card">
          <div class="items-head">
            <div><h2 style="margin-bottom:.25rem;">Itens do orçamento</h2></div>
            <div>
              <button id="removeall" class="remove" type="button">Limpar tudo</button>
              <button class="btn btn-primary" id="addItemInline" type="button">Adicionar item</button>
            </div>
          </div>
          <div id="itemList" class="item-list"></div>
        </section>
      </div>
    </section>

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <!-- HISTÓRICO -->
      <div class="historico-card" id="historicoCard">
        <div class="historico-header" id="historicoToggle">
          <strong>Orçamentos salvos</strong>
          <span class="historico-toggle" id="historicoCount">0 salvos</span>
        </div>
        <div class="historico-body" id="historicoBody">
          <div class="historico-empty" id="historicoEmpty">Nenhum orçamento salvo ainda.</div>
          <div id="historicoList"></div>
        </div>
      </div>

      <!-- PREVIEW -->
      <section class="preview-card">
        <div class="preview-top">
          <div><strong>Pré-visualização</strong></div>
          <div class="preview-actions">
            <button class="btn" id="copyText" type="button">Copiar texto</button>
            <button class="btn btn-primary" id="printBtn" type="button">Imprimir / PDF</button>
          </div>
        </div>
        <div class="preview-shell">
          <pre id="output"></pre>
          <!-- PRINT DOC (só aparece na impressão) -->
          <div id="print-doc"></div>
        </div>
      </section>
    </aside>
  </div>
</div>

<div id="overlay-confirmar" class="overlay-acoes">
  <div class="sheet-acoes">
    <div class="sheet-header">
      <span class="sheet-descricao" id="confirmar-titulo">Confirmar ação?</span>
    </div>
    <p style="margin:0; color:var(--cor-cinza);" id="confirmar-mensagem"></p>
    <div class="sheet-botoes">
      <button id="btn-confirmar-acao" class="btn-sheet btn-excluir" type="button">Confirmar</button>
    </div>
    <button id="btn-cancelar-confirmar" class="btn-fechar-sheet" type="button">Cancelar</button>
  </div>
</div>

<template id="itemTemplate">
  <article class="item">
    <div class="item-top">
      <div><label>Qtd</label><input class="qtd" value="01" /></div>
      <div><label>Descrição</label><input class="descricao" placeholder="Ex.: Filtro de óleo" /></div>
      <div><label>Marca</label><input class="marca" placeholder="Ex.: WEGA" /></div>
      <div><label>Valor</label><input class="valor" value="0" inputmode="decimal" /></div>
      <div>
        <label>Cortesia?</label>
        <select class="cortesia">
          <option value="nao">Não</option>
          <option value="sim">Sim</option>
        </select>
      </div>
      <div><label>&nbsp;</label><button class="remove" type="button">Remover</button></div>
    </div>
  </article>
</template>
<?php

$extraScripts = '<script>const historicoInicial = ' . $historicoJson . ';</script>';
$extraScripts .= <<<'HTML'
<script>
(function () {
  const state = { items: [] };
  const API = window.BASE + '/api/orcamentos';

  const exampleItems = [
    { qtd:'04', descricao:'Litros de Óleo 10W40', marca:'Mobil', valor:'370', cortesia:'nao' },
    { qtd:'01', descricao:'Filtro de Óleo', marca:'WEGA', valor:'50', cortesia:'nao' },
    { qtd:'01', descricao:'Jogo de Velas', marca:'NGK', valor:'135', cortesia:'nao' },
    { qtd:'01', descricao:'Revisão geral', marca:'', valor:'150', cortesia:'sim' }
  ];

  // ===== UTILS =====
  function numero(valor) {
    return Number(String(valor).replace(/\./g, '').replace(',', '.')) || 0;
  }
  function moeda(valor) {
    return numero(valor).toLocaleString('pt-BR', { style:'currency', currency:'BRL' });
  }
  function hoje() {
    return new Date().toLocaleDateString('pt-BR');
  }
  function formatarDataBanco(str) {
    if (!str) return '';
    const d = new Date(str.replace(' ', 'T'));
    if (isNaN(d.getTime())) return str;
    return d.toLocaleDateString('pt-BR');
  }
  function showToast(msg) {
    const t = document.getElementById('orcamento-toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2200);
  }

  // ===== TEXTO (WhatsApp) =====
  function linhaItem(item) {
    const marca = item.marca ? ' - ' + item.marca : '';
    const cortesia = item.cortesia === 'sim' ? ' (cortesia)' : '';
    return item.qtd + ' ' + item.descricao + marca + ': ' + moeda(item.valor) + cortesia;
  }
  function renderOutput() {
    const modelo = document.getElementById('modelo').value.trim();
    const cliente = document.getElementById('cliente').value.trim();
    const servico = document.getElementById('servico').value.trim();
    const maoDeObra = numero(document.getElementById('maoDeObra').value);
    const totalManual = document.getElementById('totalManual').value.trim();
    const somaPecas = state.items.reduce((acc, item) => acc + (item.cortesia === 'sim' ? 0 : numero(item.valor)), 0);
    const total = totalManual ? numero(totalManual) : somaPecas + maoDeObra;

    const linhas = [
      '*Orçamento - ' + modelo + ' - ' + cliente + '*',
      '',
      '*' + servico + ':*',
      '',
      '_Peças:_',
      '',
      ...state.items.map(linhaItem).flatMap(l => [l, '']),
      '',
      '',
      'Mão de obra técnica: ' + moeda(maoDeObra),
      '*Total: ' + moeda(total) + '*'
    ];
    document.getElementById('output').textContent = linhas.join('\n').replace(/\n{4,}/g, '\n\n\n\n');

    renderPrintDoc();
  }

  // ===== PRINT DOC (PDF visual) =====
  function mk(tag, className, children) {
    const e = document.createElement(tag);
    if (className) e.className = className;
    if (typeof children === 'string') {
      e.textContent = children;
    } else if (Array.isArray(children)) {
      children.forEach(c => c && e.appendChild(c));
    }
    return e;
  }

  function renderPrintDoc() {
    const modelo    = document.getElementById('modelo').value.trim();
    const cliente   = document.getElementById('cliente').value.trim();
    const servico   = document.getElementById('servico').value.trim();
    const maoDeObra = numero(document.getElementById('maoDeObra').value);
    const totalManual = document.getElementById('totalManual').value.trim();
    const oficinaNome = document.getElementById('oficinaNome').value.trim() || 'Revizzi Centro Automotivo';
    const oficinaTel  = document.getElementById('oficinaTelefone').value.trim();
    const oficinaEnd  = document.getElementById('oficinaEndereco').value.trim();
    const somaPecas = state.items.reduce((acc, i) => acc + (i.cortesia === 'sim' ? 0 : numero(i.valor)), 0);
    const total = totalManual ? numero(totalManual) : somaPecas + maoDeObra;

    const doc = document.getElementById('print-doc');
    doc.innerHTML = '';

    const brand = mk('div', 'pd-brand', [
      mk('div', 'pd-brand-name', oficinaNome),
      mk('div', 'pd-brand-sub', 'Orçamento de Serviços')
    ]);
    const logoArea = mk('div', 'pd-logo-area', [brand]);

    const infoDiv = mk('div', 'pd-oficina-info');
    [oficinaTel, oficinaEnd].filter(Boolean).forEach((line, i, arr) => {
      infoDiv.appendChild(document.createTextNode(line));
      if (i < arr.length - 1) infoDiv.appendChild(document.createElement('br'));
    });

    doc.appendChild(mk('div', 'pd-header', [logoArea, infoDiv]));

    const meta = mk('div', 'pd-meta');
    [['Veículo', modelo || '—'], ['Cliente', cliente || '—'], ['Data', hoje()]].forEach(([l, v]) => {
      const item = mk('div', 'pd-meta-item');
      const lbl = document.createElement('label'); lbl.textContent = l;
      const span = document.createElement('span'); span.textContent = v;
      item.appendChild(lbl); item.appendChild(span);
      meta.appendChild(item);
    });
    doc.appendChild(meta);

    doc.appendChild(mk('div', 'pd-section-title', servico || 'Itens do orçamento'));

    const table = mk('table', 'pd-table');
    const thead = document.createElement('thead');
    const htr = document.createElement('tr');
    [['#','30px'],['Qtd','50px'],['Descrição / Marca',''],['Valor','100px']].forEach(([t, w]) => {
      const th = document.createElement('th');
      th.textContent = t;
      if (w) th.style.width = w;
      if (t === 'Valor') th.style.textAlign = 'right';
      htr.appendChild(th);
    });
    thead.appendChild(htr);
    table.appendChild(thead);

    const tbody = document.createElement('tbody');
    state.items.forEach((item, i) => {
      const tr = document.createElement('tr');

      const tdN = document.createElement('td'); tdN.textContent = i + 1;
      const tdQ = document.createElement('td'); tdQ.textContent = item.qtd;

      const tdD = document.createElement('td');
      tdD.appendChild(document.createTextNode(item.descricao));
      if (item.marca) {
        const s = document.createElement('span');
        s.style.cssText = 'color:#516b88;font-size:11px;';
        s.textContent = ' / ' + item.marca;
        tdD.appendChild(s);
      }
      if (item.cortesia === 'sim') {
        const b = mk('span', 'pd-badge-cortesia', 'Cortesia');
        tdD.appendChild(b);
      }

      const tdV = document.createElement('td');
      tdV.style.textAlign = 'right';
      tdV.style.fontWeight = '700';
      if (item.cortesia === 'sim') {
        const g = document.createElement('span');
        g.style.cssText = 'color:#166534;font-weight:700;';
        g.textContent = 'Grátis';
        tdV.appendChild(g);
      } else {
        tdV.textContent = moeda(item.valor);
      }

      tr.appendChild(tdN); tr.appendChild(tdQ); tr.appendChild(tdD); tr.appendChild(tdV);
      tbody.appendChild(tr);
    });
    table.appendChild(tbody);
    doc.appendChild(table);

    const totalsDiv = mk('div', 'pd-totals');
    const totalsTable = document.createElement('table');
    [
      ['Peças e materiais', moeda(somaPecas)],
      ['Mão de obra técnica', moeda(maoDeObra)],
      ['Total', moeda(total), true]
    ].forEach(([label, val, bold]) => {
      const tr = document.createElement('tr');
      const td1 = document.createElement('td');
      const td2 = document.createElement('td');
      if (bold) {
        const s1 = document.createElement('strong'); s1.textContent = label; td1.appendChild(s1);
        const s2 = document.createElement('strong'); s2.textContent = val;   td2.appendChild(s2);
      } else {
        td1.textContent = label;
        td2.textContent = val;
      }
      tr.appendChild(td1); tr.appendChild(td2);
      totalsTable.appendChild(tr);
    });
    totalsDiv.appendChild(totalsTable);
    doc.appendChild(totalsDiv);

    const assin = mk('div', 'pd-assinatura', [
      mk('div', 'pd-assinatura-linha'),
      mk('div', '', 'Assinatura do responsável')
    ]);
    const footer = mk('div', 'pd-footer', [
      mk('div', '', 'Documento gerado em ' + hoje() + ' · Revizzi'),
      assin
    ]);
    doc.appendChild(footer);
  }

  // ===== ITEMS DOM =====
  function syncItemsFromDOM() {
    state.items = [...document.getElementById('itemList').querySelectorAll('.item')].map(item => ({
      qtd: item.querySelector('.qtd').value.trim() || '01',
      descricao: item.querySelector('.descricao').value.trim(),
      marca: item.querySelector('.marca').value.trim(),
      valor: item.querySelector('.valor').value.trim() || '0',
      cortesia: item.querySelector('.cortesia').value
    }));
    renderOutput();
  }
  function bindItem(itemEl) {
    itemEl.querySelectorAll('input, select').forEach(el => el.addEventListener('input', syncItemsFromDOM));
    itemEl.querySelector('.remove').addEventListener('click', () => {
      itemEl.remove();
      syncItemsFromDOM();
    });
  }
  function addItem(data = { qtd:'01', descricao:'', marca:'', valor:'0', cortesia:'nao' }) {
    const template = document.getElementById('itemTemplate');
    const node = template.content.firstElementChild.cloneNode(true);
    node.querySelector('.qtd').value = data.qtd;
    node.querySelector('.descricao').value = data.descricao;
    node.querySelector('.marca').value = data.marca;
    node.querySelector('.valor').value = data.valor;
    node.querySelector('.cortesia').value = data.cortesia;
    document.getElementById('itemList').appendChild(node);
    bindItem(node);
    syncItemsFromDOM();
  }

  // ===== HISTÓRICO (banco de dados) =====
  let historicoCache = historicoInicial;

  function coletarDados() {
    return {
      modelo: document.getElementById('modelo').value.trim(),
      cliente: document.getElementById('cliente').value.trim(),
      servico: document.getElementById('servico').value.trim(),
      mao_de_obra: document.getElementById('maoDeObra').value,
      total_manual: document.getElementById('totalManual').value,
      oficina_nome: document.getElementById('oficinaNome').value,
      oficina_telefone: document.getElementById('oficinaTelefone').value,
      oficina_endereco: document.getElementById('oficinaEndereco').value,
      itens: state.items
    };
  }
  function carregarDados(d) {
    document.getElementById('modelo').value = d.modelo || '';
    document.getElementById('cliente').value = d.cliente || '';
    document.getElementById('servico').value = d.servico || '';
    document.getElementById('maoDeObra').value = d.mao_de_obra || '';
    document.getElementById('totalManual').value = d.total_manual || '';
    document.getElementById('oficinaNome').value = d.oficina_nome || '';
    document.getElementById('oficinaTelefone').value = d.oficina_telefone || '';
    document.getElementById('oficinaEndereco').value = d.oficina_endereco || '';
    document.getElementById('itemList').innerHTML = '';
    (d.itens || []).forEach(item => addItem({
      qtd: item.qtd,
      descricao: item.descricao,
      marca: item.marca || '',
      valor: item.valor,
      cortesia: Number(item.cortesia) ? 'sim' : 'nao'
    }));
    renderOutput();
  }
  function renderHistorico() {
    const list = historicoCache;
    const count = document.getElementById('historicoCount');
    const empty = document.getElementById('historicoEmpty');
    const ul = document.getElementById('historicoList');
    count.textContent = list.length + ' salvo' + (list.length !== 1 ? 's' : '');
    ul.innerHTML = '';
    if (list.length === 0) {
      empty.style.display = '';
      return;
    }
    empty.style.display = 'none';
    list.forEach(d => {
      const row = document.createElement('div');
      row.className = 'historico-item';
      row.innerHTML = `
        <div class="historico-item-info">
          <div class="historico-item-title">${d.modelo || '—'} · ${d.cliente || '—'}</div>
          <div class="historico-item-meta">${d.servico || ''} · ${formatarDataBanco(d.criado_em)}</div>
        </div>
        <button class="historico-btn" data-id="${d.id}" data-action="load">Carregar</button>
        <button class="historico-btn historico-btn-del" data-id="${d.id}" data-action="del">🗑</button>
      `;
      ul.appendChild(row);
    });
  }
  async function recarregarHistorico() {
    try {
      const res = await fetch(API);
      historicoCache = await res.json();
    } catch {
      historicoCache = [];
    }
    renderHistorico();
  }
  document.getElementById('historicoList').addEventListener('click', async e => {
    const btn = e.target.closest('[data-action]');
    if (!btn) return;
    const id = btn.dataset.id;
    if (btn.dataset.action === 'load') {
      try {
        const res = await fetch(API + '/' + id);
        if (!res.ok) throw new Error();
        const d = await res.json();
        carregarDados(d);
        showToast('Orçamento carregado!');
      } catch {
        alert('Erro ao carregar orçamento.');
      }
    } else if (btn.dataset.action === 'del') {
      abrirConfirmacao({
        titulo: 'Excluir orçamento?',
        mensagem: 'Essa ação não pode ser desfeita.',
        textoBotao: 'Excluir',
        onConfirmar: async () => {
          try {
            const res = await fetch(API + '/' + id, {
              method: 'DELETE',
              headers: { 'X-CSRF-Token': window.CSRF_TOKEN }
            });
            if (!res.ok) throw new Error();
            await recarregarHistorico();
            showToast('Orçamento excluído.');
          } catch {
            alert('Erro ao excluir orçamento.');
          }
        }
      });
    }
  });
  document.getElementById('historicoToggle').addEventListener('click', () => {
    document.getElementById('historicoBody').classList.toggle('collapsed');
  });

  // ===== AÇÕES =====
  document.getElementById('saveOrcamento').addEventListener('click', async () => {
    try {
      const res = await fetch(API, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': window.CSRF_TOKEN },
        body: JSON.stringify(coletarDados())
      });
      if (!res.ok) throw new Error();
      await recarregarHistorico();
      showToast('✔ Orçamento salvo!');
    } catch {
      alert('Erro ao salvar orçamento. Tente novamente.');
    }
  });
  document.getElementById('addItemInline').addEventListener('click', () => addItem());

  // ===== MODAL DE CONFIRMAÇÃO (reaproveitado para limpar tudo e excluir orçamento) =====
  const overlayConfirmar = document.getElementById('overlay-confirmar');
  const elConfirmarTitulo = document.getElementById('confirmar-titulo');
  const elConfirmarMensagem = document.getElementById('confirmar-mensagem');
  const btnConfirmarAcao = document.getElementById('btn-confirmar-acao');
  let acaoConfirmada = null;

  function fecharConfirmacao() {
    overlayConfirmar.classList.remove('aberto');
    acaoConfirmada = null;
  }
  function abrirConfirmacao({ titulo, mensagem, textoBotao, onConfirmar }) {
    elConfirmarTitulo.textContent = titulo;
    elConfirmarMensagem.textContent = mensagem;
    btnConfirmarAcao.textContent = textoBotao;
    acaoConfirmada = onConfirmar;
    overlayConfirmar.classList.add('aberto');
  }
  overlayConfirmar.addEventListener('click', e => {
    if (e.target === overlayConfirmar) fecharConfirmacao();
  });
  document.getElementById('btn-cancelar-confirmar').addEventListener('click', fecharConfirmacao);
  btnConfirmarAcao.addEventListener('click', () => {
    const acao = acaoConfirmada;
    fecharConfirmacao();
    if (acao) acao();
  });

  document.getElementById('removeall').addEventListener('click', () => {
    abrirConfirmacao({
      titulo: 'Limpar tudo?',
      mensagem: 'Isso vai remover todos os itens do orçamento atual. Essa ação não pode ser desfeita.',
      textoBotao: 'Limpar tudo',
      onConfirmar: () => {
        document.querySelectorAll('#orcamento-app .item').forEach(item => item.remove());
        syncItemsFromDOM();
        showToast('Itens removidos.');
      }
    });
  });
  document.getElementById('loadExample').addEventListener('click', () => {
    document.getElementById('modelo').value = 'Ferrari 458';
    document.getElementById('cliente').value = 'Pedro Pascal';
    document.getElementById('servico').value = 'Retifica do cabeçote';
    document.getElementById('maoDeObra').value = '1000';
    document.getElementById('totalManual').value = '';
    document.getElementById('itemList').innerHTML = '';
    exampleItems.forEach(addItem);
    renderOutput();
  });
  document.getElementById('printBtn').addEventListener('click', () => window.print());
  document.getElementById('copyText').addEventListener('click', async () => {
    await navigator.clipboard.writeText(document.getElementById('output').textContent);
    const btn = document.getElementById('copyText');
    const old = btn.textContent;
    btn.textContent = 'Copiado ✓';
    setTimeout(() => btn.textContent = old, 1200);
  });

  ['modelo','cliente','servico','maoDeObra','totalManual','oficinaNome','oficinaTelefone','oficinaEndereco'].forEach(id => {
    document.getElementById(id).addEventListener('input', renderOutput);
  });

  // ===== INIT =====
  renderHistorico();
  renderOutput();
})();
</script>
HTML;
