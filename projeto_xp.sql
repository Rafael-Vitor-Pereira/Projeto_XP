-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Abr-2022 às 06:22
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_xp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `caixa`
--

CREATE TABLE `caixa` (
  `id` int(11) NOT NULL,
  `valor` double(15,2) NOT NULL,
  `mes` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `custos`
--

CREATE TABLE `custos` (
  `id` int(11) NOT NULL,
  `cod` int(11) NOT NULL,
  `valor` double(15,2) NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `custos`
--

INSERT INTO `custos` (`id`, `cod`, `valor`, `data`) VALUES
(1, 1, 15000.00, '2022-04-13'),
(2, 4, 180000.00, '2022-05-16'),
(3, 2, 12000.00, '2022-04-25'),
(4, 2, 180000.00, '2022-04-25'),
(5, 2, 57500.00, '2022-04-25'),
(6, 2, 224750.00, '2022-04-25'),
(7, 2, 224475.00, '2022-04-25'),
(8, 2, 337250.00, '2022-04-25'),
(9, 2, 12000.00, '2022-04-25'),
(10, 4, 180000.00, '2022-06-15'),
(11, 4, 180000.00, '2022-07-15'),
(12, 4, 180000.00, '2022-08-15'),
(13, 4, 180000.00, '2022-09-15'),
(14, 4, 180000.00, '2022-10-15'),
(15, 4, 180000.00, '2022-11-15'),
(16, 4, 180000.00, '2022-12-15'),
(17, 4, 180000.00, '2023-01-15'),
(18, 4, 180000.00, '2023-02-15'),
(19, 3, 30000.00, '2022-04-25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `cod` int(11) NOT NULL,
  `valor` double(15,2) NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `entradas`
--

INSERT INTO `entradas` (`id`, `cod`, `valor`, `data`) VALUES
(1, 2, 1500000.00, '2022-04-13'),
(2, 1, 29000.00, '2022-04-14'),
(3, 1, 6000.00, '2022-04-25'),
(4, 1, 6000.00, '2022-04-25'),
(5, 1, 120000.00, '2022-04-25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `sobrenome` varchar(80) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `endereco` text NOT NULL,
  `setor` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `sobrenome`, `cpf`, `telefone`, `email`, `endereco`, `setor`) VALUES
(1, 'RAFAEL VITOR', 'PEREIRA', '012.345.678-90', '(38) 9 9190-6355', 'rafaelpereira0599@gmail.com', 'Rua Julio Cesar Batista, Nº 350, Bairro Shekinah, Pirapora-MG', 'Administrativo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL,
  `remetente` int(11) NOT NULL,
  `destinatario` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `conteudo` text NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `hora` time NOT NULL DEFAULT current_timestamp(),
  `excluido` varchar(3) NOT NULL DEFAULT 'não'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `produto` varchar(30) NOT NULL,
  `estoque` int(11) NOT NULL,
  `preco` double(7,2) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`produto`, `estoque`, `preco`, `id`) VALUES
('Placa de vídeo', 100, 2900.00, 1),
('Mouse Gamer', 150, 120.00, 2),
('Teclado Gamer', 150, 120.00, 3),
('Monitor', 200, 1200.00, 4),
('Gabinete', 500, 230.00, 5),
('Placa mãe B550m', 500, 899.00, 6),
('Processador i5-10400', 500, 897.90, 7),
('Processador Ryzen 5 5600G', 500, 1349.00, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rascunho`
--

CREATE TABLE `rascunho` (
  `id` int(11) NOT NULL,
  `remetente` int(11) NOT NULL,
  `destinatario` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `conteudo` text NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `hora` time NOT NULL DEFAULT current_timestamp(),
  `excluido` varchar(3) NOT NULL DEFAULT 'não'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id_tarefa` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `CPF` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(16) NOT NULL,
  `login` varchar(30) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `acesso` varchar(30) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `CPF`, `email`, `telefone`, `login`, `senha`, `acesso`, `status`) VALUES
(1, 'RAFAEL VITOR PEREIRA SOARES', '123.456.789-01', 'rafaelpereira@empresa.com', '(38) 9 9130-6355', 'Rafael', '$2y$10$kFyfpwb6XZ3rwMUIFPstNOkP4oW7DDr6pCEzr3zAOq4nBLJSWMBQS', 'admin', 1),
(2, 'AAA BBB CCC DDD', '000.000.000-00', 'aaa@empresa.com', '(38) 9 1597-5364', 'AAA', '$2y$10$oa0pd15uInvvuZaLToAzuumiEM6vYZ8ssGaQFWkU.jttSVxc4KuC2', 'chefe de RH', 0),
(3, 'EEE FFF GGG HHH', '111.111.111-11', 'eee@empresa.com', '(11) 1 1111-1111', 'EEE', '$2y$10$6HemW8ebp66aDWWeidXT7eY7jIZ/wqf2FXOJfs5i2.uzazUbSzR4q', 'chefe de estoque', 1),
(4, 'HHH III JJJ KKK', '222.222.222-22', 'hhh@empresa.com', '(22) 2 2222-2222', 'HHH', '$2y$10$fkqXn9o3cVv54Abw0dmi4Ov/.weaaL23uibc3DHZtq1IbI.i8VfBK', 'chefe de finanças', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `quant` int(11) NOT NULL,
  `valor` float(12,2) DEFAULT NULL,
  `data` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `id_prod`, `quant`, `valor`, `data`) VALUES
(1, 1, 10, 29000.00, '2022-04-14'),
(2, 2, 50, 6000.00, '2022-04-25'),
(3, 3, 50, 6000.00, '2022-04-25'),
(4, 4, 100, 120000.00, '2022-04-25');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `custos`
--
ALTER TABLE `custos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remetente` (`remetente`),
  ADD KEY `destinatario` (`destinatario`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `rascunho`
--
ALTER TABLE `rascunho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remetente` (`remetente`),
  ADD KEY `destinatario` (`destinatario`);

--
-- Índices para tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`id_tarefa`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`,`nome`);

--
-- Índices para tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id_venda`),
  ADD KEY `id_prod` (`id_prod`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `custos`
--
ALTER TABLE `custos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `rascunho`
--
ALTER TABLE `rascunho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id_tarefa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD CONSTRAINT `mensagens_ibfk_1` FOREIGN KEY (`remetente`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `mensagens_ibfk_2` FOREIGN KEY (`destinatario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `rascunho`
--
ALTER TABLE `rascunho`
  ADD CONSTRAINT `rascunho_ibfk_1` FOREIGN KEY (`remetente`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `rascunho_ibfk_2` FOREIGN KEY (`destinatario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD CONSTRAINT `tarefas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `produtos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
