<?php
declare(strict_types=1);

class LancamentoController extends Controller
{
    private const CATEGORIAS      = ['pecas', 'escritorio', 'oficina', 'servicos', 'prejuizo', 'salarios'];
    private const FORMAS_PAGAMENTO = ['pix', 'debito', 'credito', 'dinheiro'];
    private const RESPONSAVEIS     = ['Jonathan', 'Rubens'];
    private const TIPOS            = ['entrada', 'saida_variavel', 'saida_fixa'];

    private function semanaAtual(): array
    {
        $hoje      = new DateTime();
        $diaSemana = (int) $hoje->format('N'); // 1=Seg … 7=Dom
        $segunda   = (clone $hoje)->modify('-' . ($diaSemana - 1) . ' days');
        $sexta     = (clone $segunda)->modify('+4 days');
        return [$segunda->format('Y-m-d'), $sexta->format('Y-m-d')];
    }

    public function entradas(): void
    {
        [$inicio, $fim] = $this->semanaAtual();
        $model = new Lancamento();
        $this->render('lancamentos/entradas', [
            'titulo'       => 'Entradas - Revizzi',
            'paginaAtiva'  => 'entradas',
            'tipo'         => 'entrada',
            'lancamentos'  => $model->all('entrada'),
            'resumo'       => $model->resumoSemana($inicio, $fim),
        ]);
    }

    public function saidasVariaveis(): void
    {
        [$inicio, $fim] = $this->semanaAtual();
        $model = new Lancamento();
        $this->render('lancamentos/saidas-var', [
            'titulo'       => 'Saídas Variáveis - Revizzi',
            'paginaAtiva'  => 'saidas-var',
            'tipo'         => 'saida_variavel',
            'lancamentos'  => $model->all('saida_variavel'),
            'resumo'       => $model->resumoSemana($inicio, $fim),
        ]);
    }

    public function saidasFixas(): void
    {
        [$inicio, $fim] = $this->semanaAtual();
        $model = new Lancamento();
        $this->render('lancamentos/saidas-fix', [
            'titulo'       => 'Saídas Fixas - Revizzi',
            'paginaAtiva'  => 'saidas-fix',
            'tipo'         => 'saida_fixa',
            'lancamentos'  => $model->all('saida_fixa'),
            'resumo'       => $model->resumoSemana($inicio, $fim),
        ]);
    }

    public function store(): void
    {
        $d = json_decode(file_get_contents('php://input'), true) ?? [];

        $tipo           = in_array($d['tipo'] ?? '', self::TIPOS, true)            ? $d['tipo']           : null;
        $data           = $d['data'] ?? '';
        $descricao      = trim($d['descricao'] ?? '');
        $valor          = is_numeric($d['valor'] ?? '') ? (float) $d['valor']      : null;
        $categoria      = in_array($d['categoria'] ?? '', self::CATEGORIAS, true)  ? $d['categoria']      : null;
        $formaPagamento = in_array($d['forma_pagamento'] ?? '', self::FORMAS_PAGAMENTO, true) ? $d['forma_pagamento'] : null;
        $responsavel    = in_array($d['responsavel'] ?? '', self::RESPONSAVEIS, true) ? $d['responsavel'] : null;
        $observacao     = trim($d['observacao'] ?? '');

        if (!$tipo || !$data || strlen($descricao) < 3 || strlen($descricao) > 30
            || $valor === null || $valor <= 0
            || !$categoria || !$formaPagamento || !$responsavel) {
            $this->json(['erro' => 'Dados inválidos'], 422);
            return;
        }

        $id = (new Lancamento())->create([
            'tipo'            => $tipo,
            'data'            => $data,
            'descricao'       => $descricao,
            'valor'           => $valor,
            'categoria'       => $categoria,
            'forma_pagamento' => $formaPagamento,
            'responsavel'     => $responsavel,
            'observacao'      => $observacao,
        ]);

        $this->json(['id' => $id]);
    }

    public function update(string $id): void
    {
        $d = json_decode(file_get_contents('php://input'), true) ?? [];

        $data           = $d['data'] ?? '';
        $descricao      = trim($d['descricao'] ?? '');
        $valor          = is_numeric($d['valor'] ?? '') ? (float) $d['valor'] : null;
        $categoria      = in_array($d['categoria'] ?? '', self::CATEGORIAS, true)  ? $d['categoria']      : null;
        $formaPagamento = in_array($d['forma_pagamento'] ?? '', self::FORMAS_PAGAMENTO, true) ? $d['forma_pagamento'] : null;
        $responsavel    = in_array($d['responsavel'] ?? '', self::RESPONSAVEIS, true) ? $d['responsavel'] : null;
        $observacao     = trim($d['observacao'] ?? '');

        if (!$data || strlen($descricao) < 3 || strlen($descricao) > 30
            || $valor === null || $valor <= 0
            || !$categoria || !$formaPagamento || !$responsavel) {
            $this->json(['erro' => 'Dados inválidos'], 422);
            return;
        }

        $ok = (new Lancamento())->update((int) $id, [
            'data'            => $data,
            'descricao'       => $descricao,
            'valor'           => $valor,
            'categoria'       => $categoria,
            'forma_pagamento' => $formaPagamento,
            'responsavel'     => $responsavel,
            'observacao'      => $observacao,
        ]);

        $this->json(['ok' => $ok]);
    }

    public function destroy(string $id): void
    {
        $ok = (new Lancamento())->delete((int) $id);
        $this->json(['ok' => $ok]);
    }
}
