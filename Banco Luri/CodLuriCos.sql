CREATE DATABASE meu_banco_de_dados;
USE meu_banco_de_dados;

-- Tabela Empresa
CREATE TABLE Empresa (
  IDEmpresa INT PRIMARY KEY auto_increment,
  Nome VARCHAR(45) NOT NULL,
  CNPJ VARCHAR(45) NOT NULL UNIQUE
);

-- Tabela Compra
CREATE TABLE Compra (
  IDCompra INT PRIMARY KEY auto_increment,
  EntregaPrevista DATE NOT NULL,
  Entrega DATE NOT NULL,
  Quantidade INT NOT NULL,
  NFe INT NOT NULL,
  Data_de_Compra DATE NOT NULL,
  Valor_de_Compra DECIMAL(10,2) NOT NULL,
  Empresa_IDEmpresa INT,
  FOREIGN KEY (Empresa_IDEmpresa) REFERENCES Empresa(IDEmpresa)
);

-- Tabela Produtos
CREATE TABLE Produtos (
  Codigo_do_Produto INT PRIMARY KEY auto_increment,
  Nome VARCHAR(45) NOT NULL,
  Marca VARCHAR(45),
  Categoria VARCHAR(45),
  Preco DECIMAL(10,2) NOT NULL,
  Validade DATE NOT NULL,
  Data_da_compra DATE,
  Quantidade INT NOT NULL,
  Status_do_Estoque_ID_Status INT,
  Compra_IDCompra INT,
  Compra_Empresa_IDEmpresa INT,
  Empresa_IDEmpresa INT,
  FOREIGN KEY (Compra_IDCompra) REFERENCES Compra(IDCompra),
  FOREIGN KEY (Empresa_IDEmpresa) REFERENCES Empresa(IDEmpresa)
);

-- Tabela Fornecedores
CREATE TABLE Fornecedores ( 
IDFornecedor INT PRIMARY KEY auto_increment, 
NomeDoFornecedor VARCHAR(45), 
CNPJ VARCHAR(45) unique, 
Compra_IDCompra INT, 
Empresa_IDEmpresa INT, 
FOREIGN KEY (Compra_IDCompra) REFERENCES Compra(IDCompra), 
FOREIGN KEY (Empresa_IDEmpresa) REFERENCES Empresa(IDEmpresa) 
);

-- Tabela Clientes
CREATE TABLE Clientes (
  IDcliente INT PRIMARY KEY auto_increment,
  CPF VARCHAR(45) NOT NULL unique,
  Nome VARCHAR(45),
  Endereco VARCHAR(45),
  Telefone VARCHAR(45)
);

-- Tabela Vendas
CREATE TABLE Vendas (
  Produtos_ID_codigoProd INT,
  Clientes_IDcliente INT,
  PRIMARY KEY (Produtos_ID_codigoProd, Clientes_IDcliente),
  FOREIGN KEY (Produtos_ID_codigoProd) REFERENCES Produtos(Codigo_do_Produto),
  FOREIGN KEY (Clientes_IDcliente) REFERENCES Clientes(IDcliente)
);
