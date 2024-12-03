USE meu_banco_de_dados;



ALTER TABLE Empresa AUTO_INCREMENT = 1;
ALTER TABLE Compra AUTO_INCREMENT = 1;
ALTER TABLE Produtos AUTO_INCREMENT = 1;
ALTER TABLE Fornecedores AUTO_INCREMENT = 1;
ALTER TABLE Clientes AUTO_INCREMENT = 1;
ALTER TABLE Vendas AUTO_INCREMENT = 1;

-- Adicionando dados na tabela Empresa
INSERT INTO Empresa (Nome, CNPJ) VALUES ('LuriCosmeticos', 3123456778);

-- Adicionando dados na tabela Compra
INSERT INTO Compra (EntregaPrevista, Entrega, Quantidade, NFe, Data_de_Compra, Valor_de_Compra)
	VALUES ('2001-01-01', '2001-01-01', 100, 123456789, '2001-01-01', 233.33);
INSERT INTO Compra (EntregaPrevista, Entrega, Quantidade, NFe, Data_de_Compra, Valor_de_Compra)
	VALUES ('2001-01-01', '2001-01-011', 90, 223456789, 2001-01-01, 23.33);
INSERT INTO Compra (EntregaPrevista, Entrega, Quantidade, NFe, Data_de_Compra, Valor_de_Compra)
	VALUES ('2001-01-01', '2001-01-01', 10, 323456789, 2001-01-01, 500.33);

-- Adicionando dados na tabela Produtos
INSERT INTO Produtos (Nome, Marca, Categoria, Preco, Validade, Data_da_compra, Quantidade)
	VALUES ('Pronome', 'Marcador', 'Cosmeticos', 12.66, '2001-01-11', '2001-01-11', 100);
INSERT INTO Produtos (Nome, Marca, Categoria, Preco, Validade, Data_da_compra, Quantidade)
	VALUES ('Proneutro', 'Marquilador', 'Cosmo', 50.00, '2001-01-01', 2001-01-01, 90);
INSERT INTO Produtos (Nome, Marca, Categoria, Preco, Validade, Data_da_compra, Quantidade)
	VALUES ('Proverbio', 'Marmita', 'Cosmicio', 16.66, '2001-01-01', '2001-01-01', 10);


-- Adicionando dados na tabela Fornecedores
INSERT INTO Fornecedores (NomeDoFornecedor, CNPJ) VALUES ('ZeCosmeticos', 41234567789);
INSERT INTO Fornecedores (NomeDoFornecedor, CNPJ) VALUES ('MaraCosmeticos', 32234567789);
INSERT INTO Fornecedores (NomeDoFornecedor, CNPJ) VALUES ('DeLeveCosmeticos', 33234567789);

-- Populando a tabela Clientes
INSERT INTO Clientes (Nome, CPF, Telefone, Endereco) 
	VALUES ('Droide', '12345678901', '11999999999', 'Rua A, nº100, Vila 1');
INSERT INTO Clientes (Nome, CPF, Telefone, Endereco) 
	VALUES ('Deudroide', '22345678901', '11999999988', 'Rua B, nº200, Vila 2');
INSERT INTO Clientes (Nome, CPF, Telefone, Endereco) 
	VALUES ('Cicloide', '32345678901', '11999999977', 'Rua C, nº300, Vila 3');


-- Selecionando todas as tabelas para conferência
SELECT * FROM Empresa;
SELECT * FROM Compra;
SELECT * FROM Produtos;
SELECT * FROM Fornecedores;
SELECT * FROM Clientes;

