<?php
declare(strict_types=1);

class OrcamentoController extends Controller
{
    public function index(): void
    {
        $model = new Orcamento();
        $this->render('orcamentos/index', [
            'titulo'      => 'Orçamentos - Revizzi',
            'paginaAtiva' => 'orcamentos',
            'historico'   => $model->all(),
        ]);
    }

    public function listar(): void
    {
        $this->json((new Orcamento())->all());
    }

    public function show(string $id): void
    {
        $orcamento = (new Orcamento())->find((int) $id);
        if (!$orcamento) {
            $this->json(['erro' => 'Orçamento não encontrado'], 404);
            return;
        }
        $this->json($orcamento);
    }

    public function store(): void
    {
        if (!$this->requireCsrf()) return;

        $d = json_decode(file_get_contents('php://input'), true) ?? [];

        $modelo  = trim($d['modelo'] ?? '');
        $cliente = trim($d['cliente'] ?? '');
        $itensIn = is_array($d['itens'] ?? null) ? $d['itens'] : [];

        if ($modelo === '' || $cliente === '') {
            $this->json(['erro' => 'Dados inválidos'], 422);
            return;
        }

        $itens = [];
        foreach ($itensIn as $item) {
            $descricao = trim($item['descricao'] ?? '');
            if ($descricao === '') {
                continue;
            }
            $itens[] = [
                'qtd'       => trim($item['qtd'] ?? '') ?: '01',
                'descricao' => $descricao,
                'marca'     => trim($item['marca'] ?? '') ?: null,
                'valor'     => is_numeric($item['valor'] ?? '') ? (float) $item['valor'] : 0,
                'cortesia'  => ($item['cortesia'] ?? 'nao') === 'sim',
            ];
        }

        $id = (new Orcamento())->create([
            'oficina_nome'     => trim($d['oficina_nome'] ?? '') ?: null,
            'oficina_telefone' => trim($d['oficina_telefone'] ?? '') ?: null,
            'oficina_endereco' => trim($d['oficina_endereco'] ?? '') ?: null,
            'modelo'           => $modelo,
            'cliente'          => $cliente,
            'servico'          => trim($d['servico'] ?? '') ?: null,
            'mao_de_obra'      => is_numeric($d['mao_de_obra'] ?? '') ? (float) $d['mao_de_obra'] : 0,
            'total_manual'     => is_numeric($d['total_manual'] ?? '') ? (float) $d['total_manual'] : null,
        ], $itens);

        $this->json(['id' => $id]);
    }

    public function destroy(string $id): void
    {
        if (!$this->requireCsrf()) return;

        $ok = (new Orcamento())->delete((int) $id);
        $this->json(['ok' => $ok]);
    }
}
