<?php
declare(strict_types=1);

class Orcamento
{
    public function all(): array
    {
        $st = db()->query('SELECT * FROM orcamentos ORDER BY criado_em DESC, id DESC');
        return $st->fetchAll();
    }

    public function find(int $id): ?array
    {
        $st = db()->prepare('SELECT * FROM orcamentos WHERE id = ?');
        $st->execute([$id]);
        $orcamento = $st->fetch();
        if (!$orcamento) {
            return null;
        }

        $stItens = db()->prepare('SELECT * FROM orcamento_itens WHERE orcamento_id = ? ORDER BY ordem, id');
        $stItens->execute([$id]);
        $orcamento['itens'] = $stItens->fetchAll();

        return $orcamento;
    }

    public function create(array $d, array $itens): int
    {
        $pdo = db();
        $pdo->beginTransaction();

        $st = $pdo->prepare(
            'INSERT INTO orcamentos
             (oficina_nome, oficina_telefone, oficina_endereco, modelo, cliente, servico, mao_de_obra, total_manual)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $st->execute([
            $d['oficina_nome'], $d['oficina_telefone'], $d['oficina_endereco'],
            $d['modelo'], $d['cliente'], $d['servico'], $d['mao_de_obra'], $d['total_manual'],
        ]);
        $id = (int) $pdo->lastInsertId();

        $this->inserirItens($id, $itens);

        $pdo->commit();
        return $id;
    }

    public function delete(int $id): bool
    {
        $st = db()->prepare('DELETE FROM orcamentos WHERE id = ?');
        return $st->execute([$id]);
    }

    private function inserirItens(int $orcamentoId, array $itens): void
    {
        $st = db()->prepare(
            'INSERT INTO orcamento_itens (orcamento_id, qtd, descricao, marca, valor, cortesia, ordem)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        foreach ($itens as $ordem => $item) {
            $st->execute([
                $orcamentoId,
                $item['qtd'],
                $item['descricao'],
                $item['marca'],
                $item['valor'],
                $item['cortesia'] ? 1 : 0,
                $ordem,
            ]);
        }
    }
}
