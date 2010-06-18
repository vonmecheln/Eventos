SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `sistema` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `sistema`;

-- -----------------------------------------------------
-- Table `sistema`.`modulo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sistema`.`modulo` (
  `mdl_cod` INT NOT NULL AUTO_INCREMENT ,
  `mdl_nome` VARCHAR(60) NOT NULL COMMENT 'nome do modulo na classe' ,
  `mdl_titulo` VARCHAR(60) NOT NULL COMMENT 'Titulo que irá aparecer no menu' ,
  `mdl_ordem` INT NULL COMMENT 'Ordem que irá aparecer no menu' ,
  PRIMARY KEY (`mdl_cod`) )
ENGINE = MyISAM
COMMENT = 'Tabela contendo os módulos do sistema.';


-- -----------------------------------------------------
-- Table `sistema`.`acao`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sistema`.`acao` (
  `acao_cod` INT NOT NULL AUTO_INCREMENT ,
  `acao_nome` VARCHAR(60) NOT NULL COMMENT 'nome da ação no metodo' ,
  `acao_titulo` VARCHAR(60) NOT NULL COMMENT 'Titulo que irá aparecer no menu' ,
  `acao_ordem` INT NULL COMMENT 'Ordem que irá aparecer no menu' ,
  `mdl_cod` INT NOT NULL ,
  PRIMARY KEY (`acao_cod`) ,
  INDEX `fk_acao_modulo` (`mdl_cod` ASC) ,
  CONSTRAINT `fk_acao_modulo`
    FOREIGN KEY (`mdl_cod` )
    REFERENCES `sistema`.`modulo` (`mdl_cod` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
COMMENT = 'Tabela contendo as ações de cada módulo.';


-- -----------------------------------------------------
-- Table `sistema`.`status`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sistema`.`status` (
  `stt_cod` INT NOT NULL AUTO_INCREMENT ,
  `stt_nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`stt_cod`) )
ENGINE = MyISAM
COMMENT = 'Status para as tabelas';


-- -----------------------------------------------------
-- Table `sistema`.`grupo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sistema`.`grupo` (
  `grp_cod` INT NOT NULL AUTO_INCREMENT ,
  `grp_nome` VARCHAR(60) NULL ,
  `grp_descricao` VARCHAR(255) NULL ,
  `stt_cod` INT NULL ,
  PRIMARY KEY (`grp_cod`) ,
  INDEX `fk_grupo_status` (`stt_cod` ASC) ,
  CONSTRAINT `fk_grupo_status`
    FOREIGN KEY (`stt_cod` )
    REFERENCES `sistema`.`status` (`stt_cod` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
COMMENT = 'Grupo de usuários do sistema';


-- -----------------------------------------------------
-- Table `sistema`.`permissoes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sistema`.`permissoes` (
  `prm_cod` INT NOT NULL AUTO_INCREMENT ,
  `prm_salvar` BOOLEAN NULL ,
  `prm_exibir` BOOLEAN NULL ,
  `prm_excluir` BOOLEAN NULL ,
  `grp_cod` INT NULL ,
  `acao_cod` INT NULL ,
  PRIMARY KEY (`prm_cod`) ,
  INDEX `fk_permissoes_grupo` (`grp_cod` ASC) ,
  INDEX `fk_permissoes_acao` (`acao_cod` ASC) ,
  CONSTRAINT `fk_permissoes_grupo`
    FOREIGN KEY (`grp_cod` )
    REFERENCES `sistema`.`grupo` (`grp_cod` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permissoes_acao`
    FOREIGN KEY (`acao_cod` )
    REFERENCES `sistema`.`acao` (`acao_cod` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
COMMENT = 'Permissões de acessos as ações para cada grupo';


-- -----------------------------------------------------
-- Table `sistema`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sistema`.`usuario` (
  `usr_cod` INT NOT NULL AUTO_INCREMENT ,
  `usr_nome` VARCHAR(100) NULL ,
  `usr_cpf` VARCHAR(20) NULL ,
  `usr_rg` VARCHAR(20) NULL ,
  `usr_endereco` VARCHAR(200) NULL ,
  `usr_cep` VARCHAR(21) NULL ,
  `usr_numero` INT NULL ,
  `usr_bairro` VARCHAR(45) NULL ,
  `usr_telefone` VARCHAR(20) NULL ,
  `usr_celular` VARCHAR(20) NULL ,
  `usr_email` VARCHAR(100) NULL ,
  `usr_login` VARCHAR(45) NULL ,
  `usr_senha` VARCHAR(150) NULL ,
  `cid_cod` INT NULL ,
  `stt_cod` INT NULL ,
  `grp_cod` INT NULL ,
  PRIMARY KEY (`usr_cod`) ,
  INDEX `fk_usuario_status` (`stt_cod` ASC) ,
  INDEX `fk_usuario_grupo` (`grp_cod` ASC) ,
  CONSTRAINT `fk_usuario_status`
    FOREIGN KEY (`stt_cod` )
    REFERENCES `sistema`.`status` (`stt_cod` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_grupo`
    FOREIGN KEY (`grp_cod` )
    REFERENCES `sistema`.`grupo` (`grp_cod` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
COMMENT = 'Informações dos usuários do sistema';



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
