-- ************************************** `Grupo`

CREATE TABLE `Grupo`
(
 `IdGrupo` int NOT NULL ,
 `Nome`    varchar(20) NOT NULL ,

PRIMARY KEY (`IdGrupo`)
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

-- ************************************** `Professor`

CREATE TABLE `Professor`
(
 `IdProfessor`    		int NOT NULL ,
 `Nome`           		varchar(100) NOT NULL ,
 `Email`          		varchar(45) NOT NULL ,
 `Senha`          		varchar(255) NOT NULL ,
 `DataInclusao`   		date NOT NULL ,
 `DataHoraUltimaAtu`	datetime NOT NULL ,
 `IndicadorAtivo` 		varchar(1) NOT NULL ,

PRIMARY KEY (`IdProfessor`),
UNIQUE KEY `Ind_131` (`Email`)
);

-- ************************************** `Aluno`

CREATE TABLE `Aluno`
(
 `IdAluno`                            int NOT NULL ,
 `IdUsuarioInclusao`                  int NOT NULL ,
 `Nome`                               varchar(100) NOT NULL ,
 `DataNascimento`                     date NOT NULL ,
 `IndicadorDorPeitoAtividadesFisicas` varchar(1) NOT NULL ,
 `IndicadorDorPeitoUltimoMes`         varchar(1) NOT NULL ,
 `IndicadorPerdaConscienciaTontura`   varchar(1) NOT NULL ,
 `IndicadorProblemaArticular`         varchar(1) NOT NULL ,
 `IndicadorTabagista`                 varchar(1) NOT NULL ,
 `IndicadorDiabetico`                 varchar(1) NOT NULL ,
 `IndicadorFamiliarAtaqueCardiaco`    varchar(1) NOT NULL ,
 `Lesoes`                             varchar(200) NULL ,
 `Observacoes`                        varchar(200) NULL ,
 `TreinoEspecifico`                   varchar(200) NULL ,
 `DataInclusao`                       date NOT NULL ,
 `DataHoraUltimaAtu`				  datetime NOT NULL ,
 `IndicadorAtivo`                     varchar(1) NOT NULL ,

PRIMARY KEY (`IdAluno`),
KEY `fkIdx_119` (`IdUsuarioInclusao`),
CONSTRAINT `FK_119` FOREIGN KEY `fkIdx_119` (`IdUsuarioInclusao`) REFERENCES `Professor` (`IdProfessor`)
);

-- ************************************** `Treino`

CREATE TABLE `Treino`
(
 `IdTreino`       		int NOT NULL ,
 `IdProfessor`    		int NOT NULL ,
 `IdAluno`        		int NOT NULL ,
 `Nome`           		varchar(45) NULL ,
 `Objetivos`      		varchar(200) NULL ,
 `DataInclusao`   		date NOT NULL ,
 `DataHoraUltimaAtu`	datetime NOT NULL ,
 `IndicadorAtivo` 		varchar(1) NOT NULL ,

PRIMARY KEY (`IdTreino`),
KEY `fkIdx_122` (`IdAluno`),
CONSTRAINT `FK_122` FOREIGN KEY `fkIdx_122` (`IdAluno`) REFERENCES `Aluno` (`IdAluno`),
KEY `fkIdx_125` (`IdProfessor`),
CONSTRAINT `FK_125` FOREIGN KEY `fkIdx_125` (`IdProfessor`) REFERENCES `Professor` (`IdProfessor`)
);

-- ************************************** `Exercicio`

CREATE TABLE `Exercicio`
(
 `IdExercicio`   		 int NOT NULL ,
 `IdTreino`       		int NOT NULL ,
 `IdAparelho`     		int NOT NULL ,
 `Series`         		int NOT NULL ,
 `Repeticoes`     		int NOT NULL ,
 `Peso`           		varchar(3) NOT NULL ,
 `DataHoraUltimaAtu`	datetime NOT NULL ,
 `IndicadorAtivo` 		varchar(1) NOT NULL ,

PRIMARY KEY (`IdExercicio`),
KEY `fkIdx_63` (`IdTreino`),
CONSTRAINT `FK_63` FOREIGN KEY `fkIdx_63` (`IdTreino`) REFERENCES `Treino` (`IdTreino`),
KEY `fkIdx_66` (`IdAparelho`),
CONSTRAINT `FK_66` FOREIGN KEY `fkIdx_66` (`IdAparelho`) REFERENCES `Aparelho` (`IdAparelho`)
);

--  ************************************** INÍCIO INSERÇÃO DE DADOS

-- GRUPO
INSERT INTO grupo (IdGrupo, Nome) VALUES
(1,'Peito'),
(2,'Costas'),
(3,'Ombros'),
(4,'ABS'),
(5,'Tríceps'),
(6,'Bíceps'),
(7,'Membros Inferiores');

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

INSERT INTO `professor` (`IdProfessor`, `Nome`, `Email`, `Senha`, `DataInclusao`, `IndicadorAtivo`) VALUES
(1, 'Matheus', 'matmic08@gmail.com', '$2y$13$gExU/Exjr1emyT8Pq1ZriudLs.bsxLFrbut2gaikNQ6AOjlkSXDi6', '2019-07-12', '1');