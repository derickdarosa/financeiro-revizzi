-- Schema inferido do código (app/Models/Lancamento.php e app/Controllers/LancamentoController.php),
-- pois a tabela nunca foi versionada. CONFIRME contra o schema real do banco de produção/dev
-- antes de rodar em qualquer ambiente onde a tabela já existe (ver SECURITY_FIXES.md, item 8).

CREATE TABLE IF NOT EXISTS lancamentos (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    tipo             VARCHAR(20)  NOT NULL,   -- entrada | saida_variavel | saida_fixa
    data             DATE         NOT NULL,
    descricao        VARCHAR(30)  NOT NULL,
    valor            DECIMAL(10,2) NOT NULL,
    categoria        VARCHAR(20)  NOT NULL,   -- pecas | escritorio | oficina | servicos | prejuizo | salarios
    forma_pagamento  VARCHAR(20)  NOT NULL,   -- pix | debito | credito | dinheiro
    responsavel      VARCHAR(50)  NOT NULL,   -- Jonathan | Rubens
    observacao       VARCHAR(255) NULL,
    criado_em        DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tipo_data (tipo, data),
    INDEX idx_data (data)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
