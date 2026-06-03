<?php
declare(strict_types=1);

class RelatorioController extends Controller
{
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
