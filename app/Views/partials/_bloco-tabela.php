          <div class="bloco-tabela">
            <div id="tab-registros">
              <table>
                <thead>
                  <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $categoriaLabels = [
                    'pecas'      => 'Peças',
                    'escritorio' => 'Escritório',
                    'oficina'    => 'Oficina',
                    'servicos'   => 'Serviços',
                    'prejuizo'   => 'Prejuízo',
                    'salarios'   => 'Salário',
                  ];
                  foreach ($lancamentos ?? [] as $l):
                    [$ano, $mes, $dia] = explode('-', $l['data']);
                  ?>
                  <tr data-id="<?= $l['id'] ?>"
                      data-data="<?= $l['data'] ?>"
                      data-descricao="<?= htmlspecialchars($l['descricao']) ?>"
                      data-valor="<?= $l['valor'] ?>"
                      data-categoria="<?= $l['categoria'] ?>"
                      data-pagamento="<?= $l['forma_pagamento'] ?>"
                      data-responsavel="<?= htmlspecialchars($l['responsavel']) ?>"
                      data-observacao="<?= htmlspecialchars($l['observacao'] ?? '') ?>">
                    <td><?= "{$dia}/{$mes}/{$ano}" ?></td>
                    <td><?= htmlspecialchars($l['descricao']) ?></td>
                    <td><?= $categoriaLabels[$l['categoria']] ?? $l['categoria'] ?></td>
                    <td>R$ <?= number_format((float)$l['valor'], 2, ',', '.') ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <?php include __DIR__ . '/_calculadora.php'; ?>
          </div>

          <div id="overlay-acoes" class="overlay-acoes">
            <div class="sheet-acoes">
              <div class="sheet-header">
                <span id="sheet-descricao" class="sheet-descricao"></span>
                <span id="sheet-valor" class="sheet-valor"></span>
              </div>
              <div class="sheet-botoes">
                <button id="btn-editar-registro" class="btn-sheet btn-editar">Editar</button>
                <button id="btn-excluir-registro" class="btn-sheet btn-excluir">Excluir</button>
              </div>
              <button id="btn-fechar-sheet" class="btn-fechar-sheet">Cancelar</button>
            </div>
          </div>
