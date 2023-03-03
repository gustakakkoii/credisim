SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0; SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0; SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
CREATE SCHEMA IF NOT EXISTS `Credisim` DEFAULT CHARACTER SET utf8 ; USE `Credisim` ;
CREATE TABLE IF NOT EXISTS `Credisim`.`estadocivil` (
 `idestadocivil` INT NOT NULL AUTO_INCREMENT,
 `estadocivil` VARCHAR(45) NOT NULL, PRIMARY KEY (`idestadocivil`)) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `Credisim`.`genero` (
 `idgenero` INT NOT NULL AUTO_INCREMENT,
 `genero` VARCHAR(45) NOT NULL, PRIMARY KEY (`idgenero`)) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `Credisim`.`gruposdebeneficio` (
 `idgruposdebeneficio` INT NOT NULL AUTO_INCREMENT,
 `grupo` VARCHAR(45) NULL, PRIMARY KEY (`idgruposdebeneficio`)) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `Credisim`.`beneficio` (
 `codigo` INT NOT NULL,
 `tipoBeneficio` VARCHAR(450) NULL,
 `gruposdebeneficio` INT NOT NULL, PRIMARY KEY (`codigo`), INDEX `fk_beneficio_gruposdeespecie1_idx` (`gruposdebeneficio` ASC), CONSTRAINT `fk_beneficio_gruposdeespecie1` FOREIGN KEY (`gruposdebeneficio`) REFERENCES `Credisim`.`gruposdebeneficio` (`idgruposdebeneficio`) ON
DELETE NO ACTION ON
UPDATE NO ACTION) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `Credisim`.`cliente` (
 `CPF` VARCHAR(15) NOT NULL,
 `Nome` VARCHAR(45) NULL,
 `Sobrenome` VARCHAR(45) NULL,
 `RG` VARCHAR(45) NULL,
 `estadocivil` INT NULL,
 `genero` INT NULL,
 `nascimento` VARCHAR(45) NULL,
 `nacionalidade` VARCHAR(45) NULL,
 `naturalidade` VARCHAR(45) NULL,
 `telefone` VARCHAR(16) NULL,
 `celular` VARCHAR(16) NULL,
 `email` VARCHAR(200) NULL,
 `fotinha` VARCHAR(450) NULL,
 `pai` VARCHAR(450) NULL,
 `mae` VARCHAR(450) NULL,
 `renda` DECIMAL(10,5) NULL,
 `numerobeneficio` INT(20) NULL,
 `tipobeneficio` INT NULL, PRIMARY KEY (`CPF`), INDEX `fk_client_estadocivil_idx` (`estadocivil` ASC), INDEX `fk_client_genero1_idx` (`genero` ASC), INDEX `fk_cliente_beneficio1_idx` (`tipobeneficio` ASC), CONSTRAINT `fk_client_estadocivil` FOREIGN KEY (`estadocivil`) REFERENCES `Credisim`.`estadocivil` (`idestadocivil`) ON
DELETE NO ACTION ON
UPDATE NO ACTION, CONSTRAINT `fk_client_genero1` FOREIGN KEY (`genero`) REFERENCES `Credisim`.`genero` (`idgenero`) ON
DELETE NO ACTION ON
UPDATE NO ACTION, CONSTRAINT `fk_cliente_beneficio1` FOREIGN KEY (`tipobeneficio`) REFERENCES `Credisim`.`beneficio` (`codigo`) ON
DELETE NO ACTION ON
UPDATE NO ACTION) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `Credisim`.`UF` (
 `idUF` INT NOT NULL AUTO_INCREMENT,
 `siglaUF` VARCHAR(2) NULL,
 `nomeUF` VARCHAR(450) NULL, PRIMARY KEY (`idUF`)) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `Credisim`.`endereco` (
 `CPF` VARCHAR(15) NOT NULL,
 `rua` VARCHAR(45) NULL,
 `numero` INT NULL,
 `bairro` VARCHAR(45) NULL,
 `cidade` VARCHAR(45) NULL,
 `UF` INT NULL,
 `cep` VARCHAR(45) NULL, INDEX `fk_endereco_UF1_idx` (`UF` ASC), INDEX `fk_endereco_cliente1_idx` (`CPF` ASC), CONSTRAINT `fk_endereco_UF1` FOREIGN KEY (`UF`) REFERENCES `Credisim`.`UF` (`idUF`) ON
DELETE NO ACTION ON
UPDATE NO ACTION, CONSTRAINT `fk_endereco_cliente1` FOREIGN KEY (`CPF`) REFERENCES `Credisim`.`cliente` (`CPF`) ON
DELETE NO ACTION ON
UPDATE NO ACTION) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `Credisim`.`tiposdeconta` (
 `idtiposdeconta` INT NOT NULL AUTO_INCREMENT,
 `tipo` VARCHAR(45) NULL, PRIMARY KEY (`idtiposdeconta`)) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `Credisim`.`dadosbancarios` (
 `CPF` VARCHAR(15) NOT NULL,
 `banco` VARCHAR(45) NULL,
 `agencia` VARCHAR(45) NULL,
 `conta` VARCHAR(45) NULL,
 `tipodeconta` INT NULL, INDEX `fk_dadosbancarios_tiposdeconta1_idx` (`tipodeconta` ASC), INDEX `fk_dadosbancarios_cliente1_idx` (`CPF` ASC), CONSTRAINT `fk_dadosbancarios_tiposdeconta1` FOREIGN KEY (`tipodeconta`) REFERENCES `Credisim`.`tiposdeconta` (`idtiposdeconta`) ON
DELETE NO ACTION ON
UPDATE NO ACTION, CONSTRAINT `fk_dadosbancarios_cliente1` FOREIGN KEY (`CPF`) REFERENCES `Credisim`.`cliente` (`CPF`) ON
DELETE NO ACTION ON
UPDATE NO ACTION) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `Credisim`.`anexo` (
 `CPF` VARCHAR(15) NOT NULL,
 `RG` VARCHAR(450) NULL,
 `CTPS` VARCHAR(450) NULL,
 `CNH` VARCHAR(450) NULL,
 `CN` VARCHAR(450) NULL,
 `CompEndereco` VARCHAR(450) NULL, INDEX `fk_anexo_cliente1_idx` (`CPF` ASC), CONSTRAINT `fk_anexo_cliente1` FOREIGN KEY (`CPF`) REFERENCES `Credisim`.`cliente` (`CPF`) ON
DELETE NO ACTION ON
UPDATE NO ACTION) ENGINE = InnoDB;
INSERT IGNORE INTO estadocivil VALUES 
(1, 'Solteiro'), 
(2, 'Casado'), 
(3, 'Separado judicialmente'), 
(4, 'Separado extrajudicialmente'), 
(5, 'Divorciado'), 
(6, 'Viúvo');
INSERT IGNORE INTO genero VALUES 
(1, 'Masculino'), 
(2, 'Feminino'), 
(3, 'Outro');
INSERT IGNORE INTO tiposdeconta VALUES 
(1, 'Conta de depósitos'), 
(2, 'Conta de pagamento'), 
(3, 'Conta corrente'), 
(4, 'Conta poupança');
INSERT IGNORE INTO gruposdebeneficio VALUES 
(1, 'Aposentadoria por Idade'), 
(2, 'Aposentadoria por Invalidez'), 
(3, 'Aposentadoria por tempo de Contribuição'), 
(4, 'Pensão Por Morte'), 
(5, 'Auxílios'), 
(6, 'Benefícios Acidentários'), 
(7, 'Benefícios Assistenciais'), 
(8, 'Espécies Diversas'), 
(9, 'Encargos Previdenciários da União');
INSERT IGNORE INTO beneficio VALUES 
(07, 'Aposentadoria por idade do trabalhador rural', 1),
(08, 'Aposentadoria por idade do empregador rural', 1),
(41, 'Aposentadoria por idade', 1),
(52, 'Aposentadoria por idade (Extinto Plano Básico)', 1),
(78, 'Aposentadoria por idade de ex-combatente marítimo (Lei nº 1.756/52)', 1),
(81, 'Aposentadoria por idade compulsória (Ex-SASSE)', 1),
(04, 'Aposentadoria por invalidez do trabalhador rural', 2),
(06, 'Aposentadoria por invalidez do empregador rural', 2),
(32, 'Aposentadoria por invalidez previdenciária', 2),
(33, 'Aposentadoria por invalidez de aeronauta',2),
(34, 'Aposentadoria por invalidez de ex-combatente marítimo (Lei nº 1.756/52)', 2),
(51, 'Aposentadoria por invalidez (Extinto Plano Básico)', 2),
(83, 'Aposentadoria por invalidez (Ex-SASSE)', 2),
(42, 'Aposentadoria por tempo de contribuição previdenciária', 3),
(43, 'Aposentadoria por tempo de contribuição de ex-combatente', 3),
(44, 'Aposentadoria por tempo de contribuição de aeronauta', 3),
(45, 'Aposentadoria por tempo de contribuição de jornalista profissional', 3),
(46, 'Aposentadoria por tempo de contribuição especial', 3),
(49, 'Aposentadoria por tempo de contribuição ordinária', 3),
(57, 'Aposentadoria por tempo de contribuição de professor (Emenda Const.18/81)', 3),
(72, 'Apos. por tempo de contribuição de ex-combatente marítimo (Lei 1.756/52)', 3),
(82, 'Aposentadoria por tempo de contribuição (Ex-SASSE)', 3),
(01, 'Pensão por morte do trabalhador rural', 4),
(03, 'Pensão por morte do empregador rural', 4),
(21, 'Pensão por morte previdenciária', 4),
(23, 'Pensão por morte de ex-combatente', 4),
(27, 'Pensão por morte de servidor público federal com dupla aposentadoria', 4),
(28, 'Pensão por morte do Regime Geral (Decreto nº 20.465/31)', 4),
(29, 'Pensão por morte de ex-combatente marítimo (Lei nº 1.756/52)', 4),
(55, 'Pensão por morte (Extinto Plano Básico)', 4),
(84, 'Pensão por morte (Ex-SASSE)', 4),
(13, 'Auxílio-doença do trabalhador rural', 5),
(15, 'Auxílio-reclusão do trabalhador rural', 5),
(25, 'Auxílio-reclusão', 5),
(31, 'Auxílio-doença previdenciário', 5),
(36, 'Auxílio Acidente', 5),
(50, 'Auxílio-doença  (Extinto Plano Básico)', 5),
(02, 'Pensão por morte por acidente do trabalho do trabalhador rural', 6),
(05, 'Aposentadoria por invalidez por acidente do trabalho do trabalhador Rural', 6),
(10, 'Auxílio-doença por acidente do trabalho do trabalhador rural', 6),
(91, 'Auxílio-doença por acidente do trabalho', 6),
(92, 'Aposentadoria por invalidez por acidente do trabalho', 6),
(93, 'Pensão por morte por acidente do trabalho', 6),
(94, 'Auxílio-acidente por acidente do trabalho', 6),
(95, 'Auxílio-suplementar por acidente do trabalho', 6),
(11, 'Renda mensal vitalícia por invalidez do trabalhador rural (Lei nº 6.179/74)', 7),
(12, 'Renda mensal vitalícia por idade do trabalhador rural (Lei nº 6.179/74)', 7),
(30, 'Renda mensal vitalícia por invalidez (Lei nº 6179/74)', 7),
(40, 'Renda mensal vitalícia por idade (Lei nº 6.179/74)', 7),
(85, 'Pensão mensal vitalícia do seringueiro (Lei nº 7.986/89)', 7),
(86, 'Pensão mensal vitalícia do dep.do seringueiro (Lei nº 7.986/89)', 7),
(87, 'Amparo assistencial ao portador de deficiência (LOAS)', 7),
(88, 'Amparo assistencial ao idoso (LOAS)', 7),
(47, 'Abono de permanência em serviço 25%', 8),
(48, 'Abono de permanência em serviço 20%', 8),
(68, 'Pecúlio especial de aposentadoria', 8),
(79, 'Abono de servidor aposentado pela autarquia empr.(Lei 1.756/52)', 8),
(80, 'Salário-maternidade', 8),
(22, 'Pensão por morte estatutária', 9),
(26, 'Pensão Especial (Lei nº 593/48)', 9),
(37, 'Aposentadoria de extranumerário da União', 9),
(38, 'Aposentadoria da extinta CAPIN', 9),
(54, 'Pensão especial vitalícia (Lei nº 9.793/99)', 9),
(56, 'Pensão mensal vitalícia por síndrome de talidomida (Lei nº 7.070/82)', 9),
(58, 'Aposentadoria excepcional do anistiado (Lei nº 6.683/79)', 9),
(59, 'Pensão por morte excepcional do anistiado (Lei nº 6.683/79)', 9),
(60, 'Pensão especial mensal vitalícia (Lei 10.923, de 24/07/2004)', 9),
(76, 'Salário-família estatutário da RFFSA (Decreto-lei nº 956/69)', 9),
(89, 'Pensão especial aos depedentes de vítimas fatais p/ contaminação na hemodiálise', 9),
(96, 'Pensão especial às pessoas atingidas pela hanseníase (Lei nº 11.520/2007)', 9);
INSERT IGNORE INTO uf VALUES
(1,'AC', 'Acre'),
(2,'AL', 'Alagoas'),
(3,'AP', 'Amapá'),
(4,'AM', 'Amazonas'),
(5,'BA', 'Bahia'),
(6,'CE', 'Ceará'),
(7,'DF', 'Distrito Federal'),
(8,'ES', 'Espírito Santo'),
(9,'GO', 'Goiás'),
(10,'MA', 'Maranhão'),
(11,'MT', 'Mato Grosso'),
(12,'MS', 'Mato Grosso do Sul'),
(13,'MG', 'Minas Gerais'),
(14,'PA', 'Pará'),
(15,'PB', 'Paraíba'),
(16,'PR', 'Paraná'),
(17,'PE', 'Pernambuco'),
(18,'PI', 'Piauí'),
(19,'RJ', 'Rio de Janeiro'),
(20,'RN', 'Rio Grande do Norte'),
(21,'RS', 'Rio Grande do Sul'),
(22,'RO', 'Rondônia'),
(23,'RR', 'Roraima'),
(24,'SC', 'Santa Catarina'),
(25,'SP', 'São Paulo'),
(26,'SE', 'Sergipe'),
(27,'TO', 'Tocantins');