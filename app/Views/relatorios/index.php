<?php
$extraStyles = <<<HTML
  <style>
    #rel-wrapper {
      flex: 1;
      min-width: 0;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
      padding: 12px 0 2rem;
    }

    
    .secao {
      background: var(--cor-branco-GM);
      border-radius: var(--bdr-md);
      padding: 1.4rem 1.6rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      border: 1px solid #7070701e;
    }
    .secao-titulo {
      font-size: 1rem;
      font-weight: 600;
      color: var(--cor-cinza);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 1.2rem;
    }
    .nav-semana {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      margin-bottom: 1.2rem;
    }
    .btn-semana {
      background: var(--cor-azul);
      color: white;
      border: none;
      border-radius: var(--bdr-sm);
      width: 32px;
      height: 32px;
      font-size: 1.2rem;
      line-height: 1;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.15s;
      flex-shrink: 0;
    }
    .btn-semana:hover:not(:disabled) { background: #1e3f6e; }
    .btn-semana:disabled { background: var(--cor-branco-cinza); cursor: default; }
    #label-semana {
      font-weight: 600;
      font-size: 1rem;
      color: var(--cor-carvao-ford);
      flex: 1;
      text-align: center;
    }
    .tabela-rel {
      width: 100%;
      border-collapse: collapse;
      font-size: 1rem;
    }
    .tabela-rel thead th {
      background: var(--cor-carvao-ford);
      color: white;
      padding: 9px 14px;
      text-align: left;
      font-size: 1rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      font-weight: 600;
    }
    .tabela-rel thead th:first-child { border-radius: var(--bdr-sm) 0 0 0; }
    .tabela-rel thead th:last-child  { border-radius: 0 var(--bdr-sm) 0 0; }
    .tabela-rel tbody td {
      padding: 9px 14px;
      border-bottom: 1px solid var(--cor-borda);
      color: var(--cor-carvao-ford);
    }
    .tabela-rel tbody tr:nth-child(even) { background: var(--cor-tabela-zebra); }
    .tabela-rel tbody tr:last-child td   { border-bottom: none; }
    .tabela-rel tbody tr.hoje td         { background: #eff6ff !important; }
    .tabela-rel tbody tr.sem-mov td      { opacity: 0.4; }
    .tabela-rel tfoot td {
      padding: 9px 14px;
      font-weight: 600;
      background: #e8e8e7;
      border-top: 2px solid #d0d0ce;
    }
    .tabela-rel tfoot td:first-child { border-radius: 0 0 0 var(--bdr-sm); }
    .tabela-rel tfoot td:last-child  { border-radius: 0 0 var(--bdr-sm) 0; }
    .ve { color: #16a34a; font-weight: 600; }
    .vs { color: #dc2626; font-weight: 600; }
    .vp { color: #16a34a; font-weight: 600; }
    .vn { color: #dc2626; font-weight: 600; }
    .cards-3 {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 0.9rem;
      margin-top: 1.2rem;
    }
    .card-s {
      background: white;
      border-radius: var(--bdr-md);
      padding: 0.9rem 1rem;
      border: 1px solid var(--cor-borda);
    }
    .card-s .lbl {
      font-size: 1rem;
      font-weight: 600;
      color: var(--cor-cinza);
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 4px;
    }
    .card-s .val { font-size: 1.3rem; font-weight: 600; color: var(--cor-azul); }
    .card-s .val.verde    { color: #16a34a; }
    .card-s .val.vermelho { color: #dc2626; }
    #grid-inferior { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    .calc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .calc-field { display: flex; flex-direction: column; gap: 5px; }
    .calc-field label {
      font-size: 1rem;
      font-weight: 600;
      color: var(--cor-cinza);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 0;
    }
    .calc-nota {
      font-size: 1rem;
      color: var(--cor-cinza);
      line-height: 1.5;
      align-self: flex-end;
      padding-bottom: 13px;
    }
    .resultado-meta {
      grid-column: 1 / -1;
      background: var(--cor-azul);
      color: white;
      border-radius: var(--bdr-md);
      padding: 1rem 1.4rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .resultado-meta .lbl {
      font-size: 1rem;
      font-weight: 600;
      opacity: 0.75;
      text-transform: uppercase;
      letter-spacing: 0.06em;
    }
    .resultado-meta .val { font-size: 1.8rem; font-weight: 600; }
    .cards-proj { display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; margin-bottom: 1.2rem; }
    .card-proj {
      background: white;
      border-radius: var(--bdr-md);
      padding: 0.85rem 1rem;
      border: 1px solid var(--cor-borda);
    }
    .card-proj .lbl {
      font-size: 1rem;
      font-weight: 600;
      color: var(--cor-cinza);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 4px;
    }
    .card-proj .val { font-size: 1.2rem; font-weight: 600; color: var(--cor-carvao-ford); }
    .barra-wrap { margin-bottom: 1rem; }
    .barra-labels {
      display: flex;
      justify-content: space-between;
      font-size: 1rem;
      font-weight: 600;
      color: var(--cor-cinza);
      margin-bottom: 5px;
    }
    .barra { height: 10px; background: var(--cor-borda); border-radius: 99px; overflow: hidden; }
    .barra-fill {
      height: 100%;
      border-radius: 99px;
      transition: width 0.4s ease, background 0.3s;
      background: #16a34a;
    }
    .barra-fill.alerta { background: #f59e0b; }
    .barra-fill.perigo { background: #dc2626; }
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 1rem;
      font-weight: 600;
      padding: 4px 14px;
      border-radius: 99px;
      margin-bottom: 1rem;
    }
    .badge.ok     { background: #dcfce7; color: #16a34a; }
    .badge.alerta { background: #fef9c3; color: #b45309; }
    .badge.perigo { background: #fee2e2; color: #dc2626; }
    .detalhe-proj { font-size: 1rem; color: var(--cor-cinza); line-height: 1.8; }
    .detalhe-proj strong { color: var(--cor-carvao-ford); }
    .sem-meta { font-size: 1rem; color: var(--cor-cinza); font-style: italic; padding: 1rem 0; }
    .th-mob  { display: none; }
    .th-desk { display: inline; }
    @media (max-width: 880px) {
      #grid-inferior { grid-template-columns: 1fr; }
      .cards-3       { grid-template-columns: 1fr 1fr; }
      #rel-wrapper   { padding: 1rem 0 2rem; }
    }
    @media (max-width: 767px) {
      #rel-wrapper    { padding: 0.8rem 0rem 2rem; }
.th-mob  { display: inline; }
      .th-desk { display: none; }
      .secao          { padding:8px 8px; min-width: 0; }
      .resultado-meta { flex-direction: column; align-items: flex-start; gap: 0.4rem; }
      .resultado-meta .val { font-size: 1.4rem; }
      .dia-data       { display: none; }
      .tabela-rel                { font-size: 0.78rem; table-layout: fixed; width: 100%; }
      .cards-3{gap: 0.4rem;}
      .tabela-rel th,
      .tabela-rel td             { padding: 4px 4px; white-space: nowrap; text-align: center; }
      .tabela-rel thead th       { letter-spacing: 0; padding: 6px 4px; text-align: center; }
      .tabela-rel th:first-child,
      .tabela-rel td:first-child { width: 50px; }
    }
    @media (max-width: 480px) {
      .calc-grid             { grid-template-columns: 1fr; }
      .cards-3               { grid-template-columns: 1fr; }
      .cards-proj            { grid-template-columns: 1fr 1fr; gap: 0.4rem; }
      .card-s .val           { font-size: 1.1rem; }
    }
    #nav-pages{
      margin-bottom:inherit;
    }
  </style>
HTML;

$extraScripts = <<<'HTML'
  <script>
    const DADOS = window.__DADOS__ ?? {};

    const R = v => v.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    const DIAS = ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'];

    function toISO(d) {
      return `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
    }
    function fmtDM(d) {
      return `${String(d.getDate()).padStart(2,'0')}/${String(d.getMonth()+1).padStart(2,'0')}`;
    }
    function getMondayOf(d) {
      const r = new Date(d);
      const day = r.getDay();
      r.setDate(r.getDate() + (day === 0 ? -6 : 1 - day));
      return r;
    }

    const HOJE = new Date();
    let semana = getMondayOf(HOJE);
    let metaMensal = 0;

    function renderSemana() {
      let totE = 0, totS = 0, rows = '';
      for (let i = 0; i < 5; i++) {
        const d = new Date(semana);
        d.setDate(d.getDate() + i);
        const iso = toISO(d);
        const mov = DADOS[iso] || { entradas: 0, saidas: 0 };
        const bal = mov.entradas - mov.saidas;
        const semMov = mov.entradas === 0 && mov.saidas === 0;
        const ehHoje = iso === toISO(HOJE);
        totE += mov.entradas;
        totS += mov.saidas;
        rows += `<tr class="${ehHoje ? 'hoje' : ''} ${semMov ? 'sem-mov' : ''}">
          <td><strong>${DIAS[d.getDay()]}</strong><span class="dia-data">&nbsp;${fmtDM(d)}</span></td>
          <td class="ve">${R(mov.entradas)}</td>
          <td class="vs">${R(mov.saidas)}</td>
          <td class="${bal >= 0 ? 'vp' : 'vn'}">${R(bal)}</td>
        </tr>`;
      }
      const totBal = totE - totS;
      document.getElementById('tbody-semana').innerHTML = rows;
      document.getElementById('tfoot-semana').innerHTML = `<tr>
        <td>Total</td><td>${R(totE)}</td><td>${R(totS)}</td>
        <td class="${totBal >= 0 ? 'vp' : 'vn'}">${R(totBal)}</td>
      </tr>`;
      document.getElementById('c-entradas').textContent = R(totE);
      document.getElementById('c-saidas').textContent   = R(totS);
      const cBal = document.getElementById('c-balanco');
      cBal.textContent = R(totBal);
      cBal.className   = 'val ' + (totBal >= 0 ? 'verde' : 'vermelho');
      const fimSemana = new Date(semana);
      fimSemana.setDate(fimSemana.getDate() + 4);
      document.getElementById('label-semana').textContent = `${fmtDM(semana)} – ${fmtDM(fimSemana)}`;
      const prox = new Date(semana);
      prox.setDate(prox.getDate() + 7);
      document.getElementById('btn-next').disabled = prox > HOJE;
    }

    document.getElementById('btn-prev').addEventListener('click', () => {
      semana.setDate(semana.getDate() - 7);
      renderSemana();
    });
    document.getElementById('btn-next').addEventListener('click', () => {
      const prox = new Date(semana);
      prox.setDate(prox.getDate() + 7);
      if (prox <= HOJE) { semana = prox; renderSemana(); }
    });

    function calcularMeta() {
      const op   = parseFloat(document.getElementById('custo-op').value)   || 0;
      const forn = parseFloat(document.getElementById('custo-forn').value) || 0;
      const pct  = parseFloat(document.getElementById('pct-lucro').value)  || 0;
      metaMensal = (op + forn) * (1 + pct / 100);
      document.getElementById('val-meta').textContent = R(metaMensal);
      renderProjecao();
    }
    ['custo-op','custo-forn','pct-lucro'].forEach(id =>
      document.getElementById(id).addEventListener('input', calcularMeta)
    );

    function renderProjecao() {
      const el = document.getElementById('conteudo-proj');
      const anoMes = `${HOJE.getFullYear()}-${String(HOJE.getMonth()+1).padStart(2,'0')}`;
      let faturado = 0, gastos = 0, diasComMov = 0;
      Object.entries(DADOS).forEach(([iso, d]) => {
        if (!iso.startsWith(anoMes)) return;
        faturado += d.entradas;
        gastos   += d.saidas;
        if (d.entradas > 0) diasComMov++;
      });
      const diaAtual    = HOJE.getDate();
      const diasNoMes   = new Date(HOJE.getFullYear(), HOJE.getMonth() + 1, 0).getDate();
      const projecao    = diaAtual > 0 ? (faturado / diaAtual) * diasNoMes : 0;
      const mediaDiaria = diasComMov > 0 ? faturado / diasComMov : 0;
      const semanasComMov = new Set(
        Object.keys(DADOS).filter(iso => iso.startsWith(anoMes))
          .map(iso => toISO(getMondayOf(new Date(iso.replace(/-/g,'/')))))
      ).size;
      const mediaSemanal = semanasComMov > 0 ? faturado / semanasComMov : 0;
      if (metaMensal <= 0) {
        el.innerHTML = `<p class="sem-meta">Preencha a calculadora ao lado para visualizar a projeção.</p>`;
        return;
      }
      const pctFaturado = Math.min((faturado / metaMensal) * 100, 200);
      const pctProj     = Math.min((projecao / metaMensal) * 100, 200);
      const faltaMeta   = Math.max(metaMensal - faturado, 0);
      let corFill = '', badgeClass = 'ok', badgeTexto = '✓ No caminho da meta';
      if (pctProj < 70)      { corFill = 'perigo'; badgeClass = 'perigo'; badgeTexto = '✗ Abaixo da meta'; }
      else if (pctProj < 92) { corFill = 'alerta'; badgeClass = 'alerta'; badgeTexto = '⚠ Atenção necessária'; }
      el.innerHTML = `
        <div class="cards-proj">
          <div class="card-proj"><p class="lbl">Faturado no mês</p><span class="val">${R(faturado)}</span></div>
          <div class="card-proj"><p class="lbl">Projeção mensal</p><span class="val">${R(projecao)}</span></div>
          <div class="card-proj"><p class="lbl">Média semanal</p><span class="val">${R(mediaSemanal)}</span></div>
          <div class="card-proj"><p class="lbl">Falta para a meta</p><span class="val">${R(faltaMeta)}</span></div>
        </div>
        <div class="barra-wrap">
          <div class="barra-labels"><span>Projeção vs meta</span><span>${Math.min(pctProj,100).toFixed(0)}%</span></div>
          <div class="barra"><div class="barra-fill ${corFill}" style="width:${Math.min(pctProj,100)}%"></div></div>
        </div>
        <div class="badge ${badgeClass}">${badgeTexto}</div>
        <div class="detalhe-proj">
          <p>Dias passados no mês: <strong>${diaAtual} de ${diasNoMes}</strong></p>
          <p>Dias com movimento: <strong>${diasComMov}</strong></p>
          <p>Ticket médio diário: <strong>${R(mediaDiaria)}</strong></p>
          <p>Já faturado: <strong>${pctFaturado.toFixed(0)}% da meta</strong></p>
        </div>`;
    }

    renderSemana();
    calcularMeta();
  </script>
HTML;
?>

<script>
  window.__DADOS__ = <?= json_encode($dadosPorDia, JSON_UNESCAPED_UNICODE) ?>;
</script>

<div id="rel-wrapper">

  <section class="secao">
    <p class="secao-titulo">Visão Semanal</p>
    <div class="nav-semana">
      <button class="btn-semana" id="btn-prev">&#8249;</button>
      <span id="label-semana">—</span>
      <button class="btn-semana" id="btn-next">&#8250;</button>
    </div>
    <div class="tabela-scroll">
      <table class="tabela-rel">
        <thead>
          <tr>
            <th>Dia</th>
            <th><span class="th-desk">Entradas</span><span class="th-mob">Entrou</span></th>
            <th><span class="th-desk">Saídas</span><span class="th-mob">Saiu</span></th>
            <th>Saldo</th>
          </tr>
        </thead>
        <tbody id="tbody-semana"></tbody>
        <tfoot id="tfoot-semana"></tfoot>
      </table>
    </div>
    <div class="cards-3">
      <div class="card-s">
        <p class="lbl">Total Entradas</p>
        <span class="val verde" id="c-entradas">—</span>
      </div>
      <div class="card-s">
        <p class="lbl">Total Saídas</p>
        <span class="val vermelho" id="c-saidas">—</span>
      </div>
      <div class="card-s">
        <p class="lbl">Balanço da Semana</p>
        <span class="val" id="c-balanco">—</span>
      </div>
    </div>
  </section>

  <div id="grid-inferior">

    <section class="secao">
      <p class="secao-titulo">Calculadora de Meta Mensal</p>
      <div class="calc-grid">
        <div class="calc-field">
          <label for="custo-op">Custo de Operação</label>
          <div class="input-money"><span>R$</span>
            <input type="number" id="custo-op" placeholder="0,00" step="0.01" min="0" value="<?= $custoOperacao ?>">
          </div>
        </div>
        <div class="calc-field">
          <label for="custo-forn">Custo de Fornecedor</label>
          <div class="input-money"><span>R$</span>
            <input type="number" id="custo-forn" placeholder="0,00" step="0.01" min="0" value="<?= $custoFornecedor ?>">
          </div>
        </div>
        <div class="calc-field">
          <label for="pct-lucro">Lucro Desejado</label>
          <div class="input-money"><span>%</span>
            <input type="number" id="pct-lucro" placeholder="30" step="1" min="0" max="100">
          </div>
        </div>
        <div class="calc-nota">Meta = (Op. + Forn.) &times; (1 + Lucro%)</div>
        <div class="resultado-meta">
          <span class="lbl">Meta Mensal de Faturamento</span>
          <span class="val" id="val-meta">R$ 0,00</span>
        </div>
      </div>
    </section>

    <section class="secao">
      <p class="secao-titulo">Projeção Mensal</p>
      <div id="conteudo-proj"></div>
    </section>

  </div>

</div>
