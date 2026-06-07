<?php
declare(strict_types=1);

class RelatorioController extends Controller
{
    public function mensal(): void
    {
        $mes = preg_match('/^\d{4}-\d{2}$/', $_GET['mes'] ?? '') ? $_GET['mes'] : date('Y-m');

        $dt      = new DateTime($mes . '-01');
        $dtPrev  = (clone $dt)->modify('-1 month');
        $dtProx  = (clone $dt)->modify('+1 month');
        $mesesPt = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho',
                    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];

        $model     = new Lancamento();
        $entradas  = $model->somaMes('entrada', $mes);
        $saidasVar = $model->somaMes('saida_variavel', $mes);
        $saidasFix = $model->somaMes('saida_fixa', $mes);
        $saidas    = $saidasVar + $saidasFix;
        $resultado = $entradas - $saidas;
        $margem    = $entradas > 0 ? ($resultado / $entradas) * 100 : 0;

        $mesPrev  = $dtPrev->format('Y-m');
        $entrPrev = $model->somaMes('entrada', $mesPrev);
        $saiPrev  = $model->somaMes('saida_variavel', $mesPrev) + $model->somaMes('saida_fixa', $mesPrev);

        $this->render('relatorios/mensal', [
            'titulo'      => 'Análises - Revizzi',
            'paginaAtiva' => 'analises',
            'mes'         => $mes,
            'mesLabel'    => $mesesPt[(int)$dt->format('m') - 1] . ' ' . $dt->format('Y'),
            'mesPrev'     => $dtPrev->format('Y-m'),
            'mesProx'     => $dtProx->format('Y-m'),
            'mesAtual'    => date('Y-m'),
            'entradas'    => $entradas,
            'saidas'      => $saidas,
            'resultado'   => $resultado,
            'margem'      => $margem,
            'entrPrev'    => $entrPrev,
            'saiPrev'     => $saiPrev,
            'breakdown'   => $model->breakdownPorCategoria($mes),
            'pagamentos'  => $model->totalPorFormaPagamento($mes),
        ]);
    }

    public function index(): void
    {
        $mes  = date('Y-m');
        $model = new Lancamento();

        $this->render('relatorios/index', [
            'titulo'           => 'Relatórios - Revizzi',
            'paginaAtiva'      => 'relatorios',
            'custoOperacao'    => $model->somaMes('saida_fixa', $mes),
            'custoFornecedor'  => $model->somaMesCategorias('saida_variavel', $mes, ['pecas', 'servicos']),
            'dadosPorDia'      => $model->dadosPorDia($mes),
        ]);
    }
}
