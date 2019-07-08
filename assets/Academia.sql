-- ************************************** `Unidade_Federacao`

CREATE TABLE `Unidade_Federacao`
(
 `IdUnidadeFederacao` int NOT NULL ,
 `Nome`               varchar(30) NOT NULL ,
 `Sigla`              varchar(2) NOT NULL ,

PRIMARY KEY (`IdUnidadeFederacao`)
);

-- ************************************** `Grupo`

CREATE TABLE `Grupo`
(
 `IdGrupo` int NOT NULL ,
 `Nome`    varchar(20) NOT NULL ,

PRIMARY KEY (`IdGrupo`)
);

-- ************************************** `Endereco`

CREATE TABLE `Endereco`
(
 `IdEndereco`         int NOT NULL ,
 `IdUnidadeFederacao` int NOT NULL ,
 `Logradouro`         varchar(45) NOT NULL ,
 `Numero`             varchar(10) NOT NULL ,
 `Complemento`        varchar(10) NOT NULL ,
 `Bairro`             varchar(20) NOT NULL ,
 `Cidade`             varchar(45) NOT NULL ,

PRIMARY KEY (`IdEndereco`),
KEY `fkIdx_36` (`IdUnidadeFederacao`),
CONSTRAINT `FK_36` FOREIGN KEY `fkIdx_36` (`IdUnidadeFederacao`) REFERENCES `Unidade_Federacao` (`IdUnidadeFederacao`)
);

-- ************************************** `Aparelho`

CREATE TABLE `Aparelho`
(
 `IdAparelho` int NOT NULL ,
 `IdGrupo`    int NOT NULL ,
 `Nome`       varchar(45) NOT NULL ,

PRIMARY KEY (`IdAparelho`),
KEY `fkIdx_105` (`IdGrupo`),
CONSTRAINT `FK_105` FOREIGN KEY `fkIdx_105` (`IdGrupo`) REFERENCES `Grupo` (`IdGrupo`)
);

-- ************************************** `Pessoa`

CREATE TABLE `Pessoa`
(
 `IdPessoa`       int NOT NULL ,
 `IdEndereco`     int NOT NULL ,
 `Nome`           varchar(100) NOT NULL ,
 `CPF`            int(11) NOT NULL ,
 `DataNascimento` date NOT NULL ,
 `Email`          varchar(45) NOT NULL ,
 `Senha`          varchar(255) NOT NULL ,
 `DataInclusao`   date NOT NULL ,
 `IndicadorAtivo` varchar(1) NOT NULL ,

PRIMARY KEY (`IdPessoa`),
KEY `fkIdx_39` (`IdEndereco`),
CONSTRAINT `FK_39` FOREIGN KEY `fkIdx_39` (`IdEndereco`) REFERENCES `Endereco` (`IdEndereco`)
);



-- ************************************** `Aluno`

CREATE TABLE `Aluno`
(
 `IdAluno`                            int NOT NULL ,
 `IdPessoa`                           int NOT NULL ,
 `IndicadorDorPeitoAtividadesFisicas` varchar(1) NOT NULL ,
 `IndicadorDorPeitoUltimoMes`         varchar(1) NOT NULL ,
 `IndicadorPerdaConscienciaTontura`   varchar(1) NOT NULL ,
 `IndicadorProblemaArticular`         varchar(1) NOT NULL ,
 `IndicadorTabagista`                 varchar(1) NOT NULL ,
 `IndicadorDiabetico`                 varchar(1) NOT NULL ,
 `IndicadorFamiliarAtaqueCardiaco`    varchar(1) NOT NULL ,
 `Lesoes`                             varchar(200) NOT NULL ,
 `Observacoes`                        varchar(200) NOT NULL ,
 `Objetivos`                          varchar(200) NOT NULL ,
 `TreinoEspecifico`                   varchar(200) NOT NULL ,
 `IndicadorAtivo`                     varchar(1) NOT NULL ,

PRIMARY KEY (`IdAluno`),
KEY `fkIdx_83` (`IdPessoa`),
CONSTRAINT `FK_83` FOREIGN KEY `fkIdx_83` (`IdPessoa`) REFERENCES `Pessoa` (`IdPessoa`)
);

-- ************************************** `Treino`

CREATE TABLE `Treino`
(
 `IdTreino`       int NOT NULL ,
 `IdAluno`        int NOT NULL ,
 `Nome`           varchar(45) NOT NULL ,
 `IdProfessor`    int NOT NULL ,
 `DataInclusao`   date NOT NULL ,
 `IndicadorAtivo` varchar(1) NOT NULL ,

PRIMARY KEY (`IdTreino`),
KEY `fkIdx_89` (`IdAluno`),
CONSTRAINT `FK_89` FOREIGN KEY `fkIdx_89` (`IdAluno`) REFERENCES `Aluno` (`IdAluno`),
KEY `fkIdx_92` (`IdProfessor`),
CONSTRAINT `FK_92` FOREIGN KEY `fkIdx_92` (`IdProfessor`) REFERENCES `Pessoa` (`IdPessoa`)
);

-- ************************************** `Exercicio`

CREATE TABLE `Exercicio`
(
 `IdExercicio`    int NOT NULL ,
 `IdTreino`       int NOT NULL ,
 `IdAparelho`     int NOT NULL ,
 `Series`         int NOT NULL ,
 `Repeticoes`     int NOT NULL ,
 `Peso`           varchar(3) NOT NULL ,
 `IndicadorAtivo` varchar(1) NOT NULL ,

PRIMARY KEY (`IdExercicio`),
KEY `fkIdx_63` (`IdTreino`),
CONSTRAINT `FK_63` FOREIGN KEY `fkIdx_63` (`IdTreino`) REFERENCES `Treino` (`IdTreino`),
KEY `fkIdx_66` (`IdAparelho`),
CONSTRAINT `FK_66` FOREIGN KEY `fkIdx_66` (`IdAparelho`) REFERENCES `Aparelho` (`IdAparelho`)
);

-- FIM DA CRIAÇÃO DAS TABELAS

--  ************************************** INÍCIO INSERÇÃO DE DADOS

-- UNIDADE DA FEDERAÇÃO
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(12,'AC','Acre');  
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(27,'AL','Alagoas');  
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(13,'AM','Amazonas');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(16,'AP','Amapá');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(29,'BA','Bahia');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(23,'CE','Ceará');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(53,'DF','Distrito Federal');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(32,'ES','Espírito Santo');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(52,'GO','Goiás');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(21,'MA','Maranhão');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(31,'MG','Minas Gerais');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(50,'MS','Mato Grosso do Sul');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(51,'MT','Mato Grosso');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(15,'PA','Pará');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(25,'PB','Paraíba');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(26,'PE','Pernambuco');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(22,'PI','Piauí');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(41,'PR','Paraná');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(33,'RJ','Rio de Janeiro');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(24,'RN','Rio Grande do Norte');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(11,'RO','Rondônia');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(14,'RR','Roraima');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(43,'RS','Rio Grande do Sul');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(42,'SC','Santa Catarina');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(28,'SE','Sergipe');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(35,'SP','São Paulo');
INSERT INTO unidade_federacao (IdUnidadeFederacao,Sigla,Nome) VALUES(17,'TO','Tocantins');

-- GRUPO
INSERT INTO grupo (IdGrupo, Nome) VALUES(1,'Peito');
INSERT INTO grupo (IdGrupo, Nome) VALUES(2,'Costas');
INSERT INTO grupo (IdGrupo, Nome) VALUES(3,'Ombros');
INSERT INTO grupo (IdGrupo, Nome) VALUES(4,'ABS');
INSERT INTO grupo (IdGrupo, Nome) VALUES(5,'Tríceps');
INSERT INTO grupo (IdGrupo, Nome) VALUES(6,'Bíceps');
INSERT INTO grupo (IdGrupo, Nome) VALUES(7,'Membros Inferiores');

-- APARELHOS
INSERT INTO aparelho (IdAparelho, IdGrupo, Nome) VALUES
(1, 1, 'Supino Vertical'),
(2, 1, 'Supino Horizontal'),
(3, 1, 'Supino Inclinado'),
(4, 1, 'Supino Declinado'),
(5, 1, 'Voador'),
(6, 1, 'Crossover'),
(7, 1, 'Crucifixo'),
(8, 1, 'Crucifixo Inclinado'),
(9, 2, 'Barra Fixa'),
(10, 2, 'Puxada Frontal'),
(11, 2, 'Puxada Dorsal'),
(12, 2, 'Remada Fechada'),
(13, 2, 'Remada Aberta'),
(14, 2, 'Remada Supinada'),
(15, 2, 'Pull Down'),
(16, 2, 'Voador Invertido'),
(17, 2, 'Serrote'),
(18, 3, 'Elevação Lateral'),
(19, 3, 'Elevação Frontal'),
(20, 3, 'Desenvolvimento'),
(21, 3, 'Desenvolvimento Articulado'),
(22, 3, 'Desenvolvimento \"Arnold\"'),
(23, 3, 'Remada Alta'),
(24, 3, 'Crucifixo Inverso'),
(25, 6, 'Rosca Direta (Barra)'),
(26, 6, 'Rosca Direta (Halter)'),
(27, 6, 'Rosca Alternada'),
(28, 6, 'Rosca Concentrada'),
(29, 6, 'Rosca Pronada'),
(30, 6, 'Rosca no Cross'),
(31, 6, '\"Neutra\"'),
(32, 5, 'Roldana Supinada'),
(33, 5, 'Roldana Pronada'),
(34, 5, 'Roldana com Corda'),
(35, 5, 'Roldana Unilateral'),
(36, 5, 'Testa com Barra'),
(37, 5, 'Testa com Halteres'),
(38, 5, 'Testa na Polia'),
(39, 5, '\"Coice\"'),
(40, 5, 'Mergulho'),
(41, 5, 'Francesa'),
(42, 7, 'Agachamento MF'),
(43, 7, 'Agachamento'),
(44, 7, 'Passada MF'),
(45, 7, 'Passada'),
(46, 7, 'Leg Press 45º'),
(47, 7, 'Leg Press \"Life\"'),
(48, 7, 'Extensão de Joelho'),
(49, 7, 'Flexão de Joelho'),
(50, 7, 'Adução'),
(51, 7, 'Abdução'),
(52, 7, '3 Apoios');