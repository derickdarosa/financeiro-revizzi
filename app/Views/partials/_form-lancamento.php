<form action="/api/lancamentos" method="POST" id="form-data">
  <div class="form-container">

    <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo ?? '') ?>">

    <div class="field">
      <label for="dataHoje">Data</label>
      <input type="date" id="dataHoje" name="data">
    </div>

    <div class="field">
      <label for="descricao">Descrição</label>
      <input list="fornecedores" id="descricao" name="descricao">
      <datalist id="fornecedores">
        <option value="Coremma"></option>
        <option value="Krambeck"></option>
      </datalist>
    </div>

    <div class="field">
      <label for="valor">Valor</label>
      <div class="input-money">
        <span>R$</span>
        <input type="number" id="valor" placeholder="0,00" step="0.01" name="valor">
      </div>
    </div>

    <div class="field">
      <label for="categoria">Categoria</label>
      <select name="categoria" id="categoria">
        <option value="pecas">Peças</option>
        <option value="escritorio">Escritório</option>
        <option value="oficina">Oficina</option>
        <option value="servicos">Serviços</option>
        <option value="prejuizo">Prejuízo</option>
        <option value="salarios">Salário</option>
      </select>
    </div>

    <div class="field">
      <label for="pagamento">Forma de Pagamento</label>
      <select name="pagamento" id="pagamento">
        <option value="pix">Pix</option>
        <option value="debito">Débito</option>
        <option value="credito">Crédito</option>
        <option value="dinheiro">Dinheiro</option>
      </select>
    </div>

    <div class="field">
      <label for="responsavel">Responsável</label>
      <select name="responsavel" id="responsavel">
        <option value="Jonathan" selected>Jonathan</option>
        <option value="Rubens">Rubens</option>
      </select>
    </div>

    <div class="field full">
      <label for="observacao">Observação</label>
      <input type="text" id="observacao" name="observacao">
    </div>

    <div class="field full">
      <button type="submit" id="btn-submit">Salvar</button>
    </div>

  </div>
</form>
