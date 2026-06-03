const campoTipo       = document.querySelector('input[name="tipo"]')
const campoDescricao  = document.getElementById("descricao")
const campoValor      = document.getElementById("valor")
const campoCategoria  = document.getElementById("categoria")
const campoPagamento  = document.getElementById("pagamento")
const campoResponsavel = document.getElementById("responsavel")
const campoObservacao = document.getElementById("observacao")
const campoData       = document.getElementById("dataHoje")

if (campoData) {
  campoData.value = new Date().toISOString().split("T")[0];
}


function formatarMoeda(valor){
    const valorArredondado = Math.ceil(valor);

    return valorArredondado.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}

const valorBruto = document.getElementById('valor-bruto');
if (valorBruto) {
  valorBruto.addEventListener('input', function(){
    const custo = parseFloat(this.value) || 0;
    const margens = [50, 55, 60, 65];
    margens.forEach(margem => {
      document.getElementById(`margem-${margem}`).textContent = formatarMoeda(custo * (1 + margem / 100));
    });
  });

  document.querySelectorAll('#resultados-margem .card-valor').forEach(card => {
    card.addEventListener('click', function () {
      const valor = this.textContent.replace('R$', '').replace('.', '').replace(',', '.').trim();
      navigator.clipboard.writeText(valor).then(() => {
        this.classList.add('copiado');
        setTimeout(() => this.classList.remove('copiado'), 1500);
      });
    });
  });
}

function validarFormulario(){
  const valor = parseFloat(campoValor.value)
  const valoresCategorias = ['pecas', 'escritorio', 'oficina', 'servicos', 'prejuizo', 'salarios']
  const valoresPagamento = ['pix', 'debito', 'credito', 'dinheiro']
  const valoresResponsavel = ['Jonathan', 'Rubens']

  if(!campoData.value) return false
  if(new Date(campoData.value) > new Date()) return false
  if(!campoDescricao.value.trim() || campoDescricao.value.trim().length < 3) return false
  if (campoDescricao.value.trim().length > 30) return false
  if(!campoValor.value ||isNaN(valor) || valor <= 0) return false
  if(!valoresCategorias.includes(campoCategoria.value)) return false
  if(!valoresPagamento.includes(campoPagamento.value)) return false
  if(!valoresResponsavel.includes(campoResponsavel.value)) return false

  return true
}

function limparFormulario(){
    campoDescricao.value = ''
    campoValor.value = ''
    campoObservacao.value = ''
    campoData.value = new Date().toISOString().split("T")[0]
}

function formatarValor(valor) {
  return valor.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
}

function adicionarNaTabela(movimentacao) {
  const tbody = document.querySelector("#tab-registros tbody");

  const [ano, mes, dia] = movimentacao.data.split("-");
  const dataFormatada = `${dia}/${mes}/${ano}`;

  const linha = document.createElement("tr");

  if (movimentacao.id) linha.dataset.id = movimentacao.id;
  linha.dataset.data        = movimentacao.data;
  linha.dataset.descricao   = movimentacao.descricao;
  linha.dataset.valor       = movimentacao.valor;
  linha.dataset.categoria   = movimentacao.categoria;
  linha.dataset.pagamento   = movimentacao.forma_pagamento;
  linha.dataset.responsavel = movimentacao.responsavel;
  linha.dataset.observacao  = movimentacao.observacao;

  linha.innerHTML = `
    <td>${dataFormatada}</td>
    <td>${movimentacao.descricao}</td>
    <td>${movimentacao.categoriaLabel}</td>
    <td>${formatarValor(movimentacao.valor)}</td>
  `;

  tbody.appendChild(linha);
}

// ── Bottom sheet ──
let linhaSelecionada = null;

const overlayAcoes = document.getElementById("overlay-acoes");

if (overlayAcoes) {
  // event delegation — cobre linhas renderizadas pelo servidor e novas adicionadas pelo JS
  document.querySelector("#tab-registros tbody")?.addEventListener("click", (e) => {
    const tr = e.target.closest("tr");
    if (tr) abrirSheet(tr);
  });

  function abrirSheet(tr) {
    linhaSelecionada = tr;
    document.getElementById("sheet-descricao").textContent = tr.dataset.descricao;
    document.getElementById("sheet-valor").textContent = formatarValor(parseFloat(tr.dataset.valor));
    overlayAcoes.classList.add("aberto");
  }

  function fecharSheet() {
    overlayAcoes.classList.remove("aberto");
    linhaSelecionada = null;
  }

  overlayAcoes.addEventListener("click", (e) => {
    if (e.target === overlayAcoes) fecharSheet();
  });

  document.getElementById("btn-fechar-sheet").addEventListener("click", fecharSheet);

  document.getElementById("btn-editar-registro").addEventListener("click", () => {
    if (!linhaSelecionada) return;

    const d = linhaSelecionada.dataset;
    campoData.value        = d.data;
    campoDescricao.value   = d.descricao;
    campoValor.value       = d.valor;
    campoCategoria.value   = d.categoria;
    campoPagamento.value   = d.pagamento;
    campoResponsavel.value = d.responsavel;
    campoObservacao.value  = d.observacao;

    const btnSubmit = document.getElementById("btn-submit");
    btnSubmit.textContent       = "Atualizar";
    btnSubmit.dataset.editando  = "true";
    btnSubmit._linhaEditando    = linhaSelecionada;

    fecharSheet();
    document.getElementById("form-data").scrollIntoView({ behavior: "smooth", block: "start" });
  });

  document.getElementById("btn-excluir-registro").addEventListener("click", async () => {
    if (!linhaSelecionada) return;
    if (!confirm(`Excluir "${linhaSelecionada.dataset.descricao}"?`)) return;

    const id = linhaSelecionada.dataset.id;
    try {
      const res = await fetch(`${window.BASE}/api/lancamentos/${id}`, { method: "DELETE" });
      if (!res.ok) throw new Error();
    } catch {
      alert("Erro ao excluir. Tente novamente.");
      return;
    }

    linhaSelecionada.remove();
    fecharSheet();
  });

  document.getElementById("btn-submit").addEventListener("click", async (e) => {
    e.preventDefault();

    if (!validarFormulario()) {
      alert("Preencha todos os campos corretamente antes de salvar.");
      return;
    }

    const movimentacao = {
      tipo:            campoTipo ? campoTipo.value : "",
      data:            campoData.value,
      descricao:       campoDescricao.value.trim(),
      categoria:       campoCategoria.value.toLowerCase(),
      categoriaLabel:  campoCategoria.options[campoCategoria.selectedIndex].text,
      forma_pagamento: campoPagamento.value.toLowerCase(),
      valor:           parseFloat(campoValor.value),
      responsavel:     campoResponsavel.value.trim(),
      observacao:      campoObservacao.value.trim(),
    };

    const btnSubmit = e.currentTarget;

    if (btnSubmit.dataset.editando === "true" && btnSubmit._linhaEditando) {
      const tr = btnSubmit._linhaEditando;
      const id = tr.dataset.id;

      try {
        const res = await fetch(`${window.BASE}/api/lancamentos/${id}`, {
          method: "PUT",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(movimentacao),
        });
        if (!res.ok) throw new Error();
      } catch {
        alert("Erro ao atualizar. Tente novamente.");
        return;
      }

      tr.dataset.data        = movimentacao.data;
      tr.dataset.descricao   = movimentacao.descricao;
      tr.dataset.valor       = movimentacao.valor;
      tr.dataset.categoria   = movimentacao.categoria;
      tr.dataset.pagamento   = movimentacao.forma_pagamento;
      tr.dataset.responsavel = movimentacao.responsavel;
      tr.dataset.observacao  = movimentacao.observacao;

      const [ano, mes, dia] = movimentacao.data.split("-");
      tr.cells[0].textContent = `${dia}/${mes}/${ano}`;
      tr.cells[1].textContent = movimentacao.descricao;
      tr.cells[2].textContent = movimentacao.categoriaLabel;
      tr.cells[3].textContent = formatarValor(movimentacao.valor);

      btnSubmit.textContent = "Salvar";
      delete btnSubmit.dataset.editando;
      btnSubmit._linhaEditando = null;
    } else {
      try {
        const res = await fetch(`${window.BASE}/api/lancamentos`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(movimentacao),
        });
        if (!res.ok) throw new Error();
        const json = await res.json();
        adicionarNaTabela({ ...movimentacao, id: json.id });
      } catch {
        alert("Erro ao salvar. Tente novamente.");
        return;
      }
    }

    limparFormulario();
  });
}
