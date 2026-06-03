<?php
declare(strict_types=1);

class Lancamento
{
    public function all(string $tipo): array
    {
        $st = db()->prepare(
            'SELECT * FROM lancamentos WHERE tipo = ? ORDER BY data DESC, id DESC'
        );
        $st->execute([$tipo]);
        return $st->fetchAll();
    }

    public function create(array $d): int
    {
        $st = db()->prepare(
            'INSERT INTO lancamentos
             (tipo, data, descricao, valor, categoria, forma_pagamento, responsavel, observacao)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $st->execute([
            $d['tipo'], $d['data'], $d['descricao'], $d['valor'],
            $d['categoria'], $d['forma_pagamento'], $d['responsavel'], $d['observacao'],
        ]);
        return (int) db()->lastInsertId();
    }

    public function update(int $id, array $d): bool
    {
        $st = db()->prepare(
            'UPDATE lancamentos
             SET data = ?, descricao = ?, valor = ?, categoria = ?,
                 forma_pagamento = ?, responsavel = ?, observacao = ?
             WHERE id = ?'
        );
        return $st->execute([
            $d['data'], $d['descricao'], $d['valor'], $d['categoria'],
            $d['forma_pagamento'], $d['responsavel'], $d['observacao'], $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $st = db()->prepare('DELETE FROM lancamentos WHERE id = ?');
        return $st->execute([$id]);
    }

    public function resumoSemana(string $inicio, string $fim): array
    {
        $st = db()->prepare(
            "SELECT
                SUM(CASE WHEN tipo = 'entrada'       THEN valor ELSE 0 END) AS entradas,
                SUM(CASE WHEN tipo = 'saida_variavel' THEN valor ELSE 0 END) AS saidas,
                SUM(CASE WHEN tipo = 'saida_fixa'     THEN valor ELSE 0 END) AS fixos
             FROM lancamentos
             WHERE data BETWEEN ? AND ?"
        );
        $st->execute([$inicio, $fim]);
        $row = $st->fetch();

        $entradas = (float) $row['entradas'];
        $saidas   = (float) $row['saidas'];
        $fixos    = (float) $row['fixos'];

        return [
            'entradas' => $entradas,
            'saidas'   => $saidas,
            'fixos'    => $fixos,
            'balanco'  => $entradas - $saidas,
            'total'    => $entradas - $saidas - $fixos,
        ];
    }

    public function somaMes(string $tipo, string $mes): float
    {
        $st = db()->prepare(
            "SELECT COALESCE(SUM(valor), 0) FROM lancamentos
             WHERE tipo = ? AND DATE_FORMAT(data, '%Y-%m') = ?"
        );
        $st->execute([$tipo, $mes]);
        return (float) $st->fetchColumn();
    }

    public function somaMesCategorias(string $tipo, string $mes, array $categorias): float
    {
        $placeholders = implode(',', array_fill(0, count($categorias), '?'));
        $st = db()->prepare(
            "SELECT COALESCE(SUM(valor), 0) FROM lancamentos
             WHERE tipo = ? AND DATE_FORMAT(data, '%Y-%m') = ? AND categoria IN ($placeholders)"
        );
        $st->execute([$tipo, $mes, ...$categorias]);
        return (float) $st->fetchColumn();
    }

    public function dadosPorDia(string $mes): array
    {
        $st = db()->prepare(
            "SELECT data,
                    SUM(CASE WHEN tipo = 'entrada' THEN valor ELSE 0 END) AS entradas,
                    SUM(CASE WHEN tipo != 'entrada' THEN valor ELSE 0 END) AS saidas
             FROM lancamentos
             WHERE DATE_FORMAT(data, '%Y-%m') = ?
             GROUP BY data
             ORDER BY data"
        );
        $st->execute([$mes]);
        $result = [];
        foreach ($st->fetchAll() as $row) {
            $result[$row['data']] = [
                'entradas' => (float) $row['entradas'],
                'saidas'   => (float) $row['saidas'],
            ];
        }
        return $result;
    }
}
