CREATE TABLE IF NOT EXISTS orcamentos (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    oficina_nome     VARCHAR(150) NULL,
    oficina_telefone VARCHAR(50)  NULL,
    oficina_endereco VARCHAR(255) NULL,
    modelo           VARCHAR(150) NOT NULL,
    cliente          VARCHAR(150) NOT NULL,
    servico          VARCHAR(150) NULL,
    mao_de_obra      DECIMAL(10,2) NOT NULL DEFAULT 0,
    total_manual     DECIMAL(10,2) NULL,
    criado_em        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS orcamento_itens (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    orcamento_id INT NOT NULL,
    qtd          VARCHAR(10)  NOT NULL DEFAULT '01',
    descricao    VARCHAR(150) NOT NULL,
    marca        VARCHAR(80)  NULL,
    valor        DECIMAL(10,2) NOT NULL DEFAULT 0,
    cortesia     TINYINT(1)   NOT NULL DEFAULT 0,
    ordem        INT          NOT NULL DEFAULT 0,
    CONSTRAINT fk_orcamento_itens_orcamento
        FOREIGN KEY (orcamento_id) REFERENCES orcamentos (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
