-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Mar-2022 às 21:34
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `banco_liv`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cadastra_autores` (IN `nome_autor` VARCHAR(70), IN `biografia_autor` VARCHAR(500), IN `imagem_autor1` VARCHAR(100), IN `imagem_autor2` VARCHAR(100), IN `imagem_autor3` VARCHAR(100), OUT `saida` VARCHAR(80), OUT `saida_rotulo` VARCHAR(15))  BEGIN
	DECLARE link_autor VARCHAR(100);
	DECLARE codigo_autor INT;
	DECLARE deu_certo INT;
	IF EXISTS (SELECT * FROM autores WHERE nome = nome_autor) THEN
	begin
		SET saida_rotulo = 'OPS!';
		SET saida = 'Este Autor/Autora já está cadastrado!';
	END;
	
	ELSE
		SET link_autor = CONCAT(nome_autor, '-', NOW());
		SET link_autor = (SELECT gera_link(link_autor));
		
		START TRANSACTION;
			/*ESTE INSERT É PARA A TABELA DE AUTORES*/
		INSERT INTO autores(nome,biografia,link)
		VALUES(nome_autor, biografia_autor,link_autor);
		
		IF ROW_COUNT() = 0 THEN
			SET deu_certo = 0;
		ELSE
			SET deu_certo = 1;
		END IF;
			/*ESTE INSERT É PARA A TABELA DE IMAGENS*/
		SET codigo_autor = (SELECT id_autor FROM autores WHERE nome = nome_autor);
		IF imagem_autor1 <> "" THEN
			INSERT INTO imagens (caminho,autores_codigo) VALUES (imagem_autor1, codigo_autor);
		IF ROW_COUNT() = 0 THEN
			SET deu_certo = 0;
		ELSE
			SET deu_certo = deu_certo + 1;
		END IF;
		END IF;
		
		IF imagem_autor2 <> "" THEN
			INSERT INTO imagens (caminho,autores_codigo) VALUES (imagem_autor2, codigo_autor);
		IF ROW_COUNT() = 0 THEN
			SET deu_certo = 0;
		ELSE
			SET deu_certo = deu_certo + 1;
		END IF;
		END IF;
		
		IF imagem_autor3 <> "" THEN
			INSERT INTO imagens (caminho,autores_codigo) VALUES (imagem_autor3, codigo_autor);
		IF ROW_COUNT() = 0 THEN
			SET deu_certo = 0;
		ELSE
			SET deu_certo = deu_certo + 1;
		END IF;
		END IF;
		
		IF deu_certo > 0 THEN
			SET saida_rotulo = 'Tudo certo';
			SET saida = 'Autor/Autora cadastrado(a) com sucesso!';
			COMMIT;
		ELSE
			SET saida_rotulo = 'ERRO';
			SET saida = 'Autor/Autora NÃO FOI cadastrado(a)!';
			ROLLBACK;
		END IF;
END IF;
SELECT saida, saida_rotulo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cadastra_categoria` (IN `nome_categoria` VARCHAR(70), `link_categoria` VARCHAR(100), OUT `saida` VARCHAR(80), OUT `saida_rotulo` VARCHAR(15))  begin
	set link_categoria = CONCAT(link_categoria, '-', NOW());
    set link_categoria = (SELECT gera_link(link_categoria));
	if not exists(select * from categorias where categoria = nome_categoria) then
    begin
			insert into categorias (categoria, link)
            values(nome_categoria, link_categoria);
            
				if row_count() = 0 then
                set saida_rotulo = "ERRO!";
				set saida = "ERRO! A categoria NÃO foi cadatrada ";
    else
		set saida_rotulo = "Tudo certo";
        set saida = 'Categoria cadatrada com sucesso';
        end if;
        end;
        else
			set saida_rotulo = "Ops!";
			set saida = "categoria já existe";
        end if;
        select saida_rotulo, saida;
 end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cadastra_livros` (IN `nome_livro` VARCHAR(70), IN `descricao_livro` TEXT, IN `imagem_livro1` VARCHAR(100), IN `imagem_livro2` VARCHAR(100), IN `imagem_livro3` VARCHAR(100), OUT `saida` VARCHAR(80), OUT `saida_rotulo` VARCHAR(15))  BEGIN
	DECLARE link_livro VARCHAR(100);
	DECLARE codigo_livro INT;
	DECLARE deu_certo INT;
	IF EXISTS (SELECT * FROM livros WHERE titulo = nome_livro) THEN
	begin
		SET saida_rotulo = 'OPS!';
		SET saida = 'Este livro já está cadastrado!';
	END;
	
	ELSE
		SET link_livro = CONCAT(nome_livro, '-', NOW());
		SET link_livro = (SELECT gera_link(link_livro));
		
		START TRANSACTION;
			/*ESTE INSERT É PARA A TABELA DE AUTORES*/
		INSERT INTO livros(titulo,biografia,link)
		VALUES(nome_livro, descricao_livro,link_livro);
		
		IF ROW_COUNT() = 0 THEN
			SET deu_certo = 0;
		ELSE
			SET deu_certo = 1;
		END IF;
			/*ESTE INSERT É PARA A TABELA DE IMAGENS*/
		SET codigo_livro = (SELECT id_livro FROM livros WHERE titulo = nome_livro);
		IF imagem_livro1 <> "" THEN
			INSERT INTO imagens (caminho,id_livro) VALUES (imagem_livro1, codigo_livro);
		IF ROW_COUNT() = 0 THEN
			SET deu_certo = 0;
		ELSE
			SET deu_certo = deu_certo + 1;
		END IF;
		END IF;
		
		IF imagem_livro2 <> "" THEN
			INSERT INTO imagens (caminho,id_livro) VALUES (imagem_livro2, codigo_livro);
		IF ROW_COUNT() = 0 THEN
			SET deu_certo = 0;
		ELSE
			SET deu_certo = deu_certo + 1;
		END IF;
		END IF;
		
		IF imagem_livro3 <> "" THEN
			INSERT INTO imagens (caminho,id_livro) VALUES (imagem_livro3, codigo_livro);
		IF ROW_COUNT() = 0 THEN
			SET deu_certo = 0;
		ELSE
			SET deu_certo = deu_certo + 1;
		END IF;
		END IF;
		
		IF deu_certo > 0 THEN
			SET saida_rotulo = 'Tudo certo';
			SET saida = 'Livro cadastrado(a) com sucesso!';
			COMMIT;
		ELSE
			SET saida_rotulo = 'ERRO';
			SET saida = 'Livro NÃO FOI cadastrado(a)!';
			ROLLBACK;
		END IF;
END IF;
SELECT saida, saida_rotulo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cadastra_usuario` (`nome_usuario` VARCHAR(70), `login_usuario` VARCHAR(30), `email_usuario` VARCHAR(50), `senha_usuario` VARCHAR(60), `salt_usuario` VARCHAR(20), `nivel_usuario` CHAR(1), OUT `saida` VARCHAR(80), OUT `saida_rotulo` VARCHAR(15))  begin
	if exists(select * from usuarios where login = login_usuario) then
    begin
		set saida_rotulo = 'OPS!';
		set saida = 'Este login já está cadastrado';
    
    end;
    elseif exists(select * from usuarios where email = email_usuario) then
	begin
		set saida_rotulo = 'OPS!';
		set saida = 'Este e-mail já está cadastrado';
    end;
    else 
		insert into usuarios (nome, login, email, senha, salt, nivel)
		values(nome_usuario, login_usuario, email_usuario, senha_usuario, salt_usuario, nivel_usuario );
        
        IF ROW_COUNT() = 0 then
			set saida_rotulo = 'ERRO';
            set saida = 'O usuário não foi CADASTRADO com sucesso ';
		else
			set saida_rotulo = 'TUDO CERTO';
            set saida = 'Usuário CADASTRADO com sucesso ';
		end if;
        end if;
        select saida_rotulo, saida;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_deleta_autores` (IN `codigo_autor` INT, OUT `saida` VARCHAR(800), OUT `saida_rotulo` VARCHAR(15))  BEGIN
-- Verificar se o autor está cadastrado
	if NOT EXISTS (SELECT * FROM autores WHERE id_autor = codigo_autor) then 
	begin
		SET saida_rotulo = "OPS!";
		SET saida = "Autor/Autora não encontrado(a)!";
	END;
	ELSE
	-- retira o autor da tabela livros_autores
	DELETE FROM livros_autores WHERE autores_codigo = codigo_autor;
		-- removendo as imagens do autor primeiro
		DELETE FROM  imagens WHERE autores_codigo = codigo_autor;
		-- excluiindo o autor em si--
		DELETE FROM  autores WHERE id_autor = codigo_autor;
		if ROW_COUNT() = 0 THEN
			SET saida_rotulo = "ERRO!";
			SET saida = "Autor/Autora NÃO foi exluido(a)!";
		else
			SET saida_rotulo = "Tudo certo!";
			SET saida = "Autor/Autora excluido(a) com sucesso!";
	END if;
	END if;
	SELECT saida_rotulo, saida;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_deleta_categoria` (IN `codigo_categorias` INT, OUT `saida` VARCHAR(80), IN `saida_rotulo` VARCHAR(15))  begin
	if not exists(select * from categorias where codigo_categorias = id_categorias ) then
    begin
			set saida_rotulo = 'Ops!';
			set saida = 'categoria não encontrada'; 
    end;
    elseif exists(SELECT *FROM livros_categorias where codigo_categorias =id_categorias) then
      begin
			set saida_rotulo = 'OPS!';
			set saida = 'Não foi possivel excluir esta categoria,pois ela está categoria está vinculada a um filme'; 
    end;
    else
		delete from categorias where codigo_categorias = id_categorias;
        if row_count() = 0 then
        set saida_rotulo = 'ERRO!';
        set saida = 'a categoria NÃO foi excluída';
        else
			set saida_rotulo = 'Tudo certo!';
			set saida = 'Categoria excluida com sucesso';
        end if;
        end if;
        select saida_rotulo, saida;
 end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_deleta_livros` (IN `codigo_livro` VARCHAR(100), OUT `saida` VARCHAR(80), OUT `saida_rotulo` VARCHAR(15))  BEGIN
-- Verificar se o autor está cadastrado
	if NOT EXISTS (SELECT * FROM livros WHERE id_livro = codigo_livro) then 
	begin
		SET saida_rotulo = "OPS!";
		SET saida = "livro não encontrado(a)!";
	END;
	ELSE
		-- removendo as imagens do autor primeiro
		DELETE FROM  imagens WHERE id_livro = codigo_livro;
		-- excluiindo o autor em si--
		DELETE FROM  livros WHERE id_livro = codigo_livro;
		if ROW_COUNT() = 0 THEN
			SET saida_rotulo = "ERRO!";
			SET saida = "livro NÃO foi exluido(a)!";
		else
			SET saida_rotulo = "Tudo certo!";
			SET saida = "livro excluido(a) com sucesso!";
	END if;
	END if;
	SELECT saida_rotulo, saida;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_deleta_usuarios` (IN `codigo_usuarios` INT, OUT `saida` VARCHAR(80), IN `saida_rotulo` VARCHAR(15))  begin
	if not exists(select * from usuarios where codigo_usuarios = id_usuarios) then
    begin
			set saida_rotulo = 'Ops!';
			set saida = 'usuário não encontrada'; 
    end;
    else
		delete from usuarios where codigo_usuarios = id_usuarios;
        if row_count() = 0 then
        set saida_rotulo = 'ERRO!';
        set saida = 'o usuário NÃO foi excluída';
        else
			set saida_rotulo = 'Tudo certo!';
			set saida = 'usuário excluida com sucesso';
        end if;
        end if;
        select saida_rotulo, saida;
 end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_edita_autor` (IN `codigo_autor` INT, IN `nome_autor` VARCHAR(100), IN `biografia_autor` TEXT, IN `nome_imagem1` VARCHAR(100), IN `codigo_imagem1` VARCHAR(100), IN `nome_imagem2` VARCHAR(100), IN `codigo_imagem2` VARCHAR(100), IN `nome_imagem3` VARCHAR(100), IN `codigo_imagem3` VARCHAR(100), OUT `saida` VARCHAR(80), IN `saida_rotulo` VARCHAR(15))  BEGIN
/*verifica as imagens que foram enviadas para update*/
if EXISTS(SELECT * FROM imagens WHERE id_imagens = codigo_imagem1) then
	if	nome_imagem1 = "" then
	/*se for enviado apenas o codigo da imegm , sme nome, é para excluir a imagem */
		DELETE FROM imagens WHERE id_imagens = codigo_imagem1;
	else
	/*se for enviado o código da imagem e tambem o nome, é fazer um update na imagem */
		UPDATE imagens SET caminho = nome_imagem1 WHERE id_imagens = codigo_imagem1;
		
		END if;
	END if;
	
if EXISTS(SELECT * FROM imagens WHERE id_imagens = codigo_imagem2) then
	if	nome_imagem2 = "" then
	/*se for enviado apenas o codigo da imegm , sme nome, é para excluir a imagem */
		DELETE FROM imagens WHERE id_imagens = codigo_imagem2;
	else
	/*se for enviado o código da imagem e tambem o nome, é fazer um update na imagem */
		UPDATE imagens SET caminho = nome_imagem2 WHERE id_imagens = codigo_imagem2;
		
		END if;
	END if;
	
if EXISTS(SELECT * FROM imagens WHERE id_imagens = codigo_imagem3) then
	if	nome_imagem3 = "" then
	/*se for enviado apenas o codigo da imegm , sme nome, é para excluir a imagem */
		DELETE FROM imagens WHERE id_imagens = codigo_imagem3;
	else
	/*se for enviado o código da imagem e tambem o nome, é fazer um update na imagem */
		UPDATE imagens SET caminho = nome_imagem3 WHERE id_imagens = codigo_imagem3;
		
		END if;
	END if;
	/*Parte para inserir uma nova imagem */
	if nome_imagem1 <> "" AND codigo_imagem1 = "" then
		INSERT INTO imagens(caminho, autores_codigo) VALUES (nome_imagem1, codigo_autor);
	END if;
	
	if nome_imagem2 <> "" AND codigo_imagem2 = "" then
		INSERT INTO imagens(caminho, autores_codigo) VALUES (nome_imagem2, codigo_autor);
	END if;
	
	if nome_imagem3 <> "" AND codigo_imagem3 = "" then
		INSERT INTO imagens(caminho, autores_codigo) VALUES (nome_imagem3, codigo_autor);
	END if;
	
	START TRANSACTION;
	/*Alterando dados dos autores*/
	UPDATE autores SET nome = nome_autor,biografia = biografia_autor
	WHERE id_autor = codigo_autor;
	
	if ROW_COUNT() > 1 THEN
		SET saida_rotulo = 'ERRO!';
		SET saida = 'Cadastro de autor/autora NÃO FOI ALTERADO';
		ROLLBACK;
	ELSE
		SET saida_rotulo = 'TUDO CERTO';
		SET saida = 'Cadastro de autor/autora alterado com sucesso!';
		COMMIT;
END if;
SELECT saida_rotulo, saida;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_edita_categoria` (`id_categoria` INT, `nome_categoria` VARCHAR(70), OUT `saida` VARCHAR(80), `saida_rotulo` VARCHAR(15))  begin
	if not exists(select * from categorias where categoria = nome_categoria) then
    begin
			declare
            link_categoria varchar(100);
            set link_categoria = nome_categoria;
            set link_categoria = CONCAT(link_categoria, '-', NOW());
			set link_categoria = (SELECT gera_link(link_categoria));
			update categorias
            set categoria = nome_categoria, link = link_categoria
            where id_categorias = id_categoria;
            if row_count() = 0 then
            set saida_rotulo = 'ERRO!';
			set saida = "nenhuma categoria foi ALTERADA ";
		else
			set saida_rotulo = 'Tudo certo!';
			set saida = 'categoria ALTERADA com sucesso!';
        end if;
        end;
        else
			set saida_rotulo = 'Ops!';
			set saida = "essa categoria já existe";
        end if;
	select saida_rotulo,saida;
 end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_edita_livro` (IN `codigo_livro` INT, IN `nome_livro` VARCHAR(100), IN `descricao_livro` TEXT, IN `nome_imagem1` VARCHAR(100), IN `codigo_imagem1` VARCHAR(100), IN `nome_imagem2` VARCHAR(100), IN `codigo_imagem2` VARCHAR(100), IN `nome_imagem3` VARCHAR(100), IN `codigo_imagem3` VARCHAR(100), OUT `saida` VARCHAR(80), IN `saida_rotulo` VARCHAR(15))  BEGIN
/*verifica as imagens que foram enviadas para update*/
if EXISTS(SELECT * FROM imagens WHERE id_imagens = codigo_imagem1) then
	if	nome_imagem1 = "" then
	/*se for enviado apenas o codigo da imagem , sem nome, é para excluir a imagem */
		DELETE FROM imagens WHERE id_imagens = codigo_imagem1;
	else
	/*se for enviado o código da imagem e tambem o nome, é fazer um update na imagem */
		UPDATE imagens SET caminho = nome_imagem1 WHERE id_imagens = codigo_imagem1;
		
		END if;
	END if;
	
if EXISTS(SELECT * FROM imagens WHERE id_imagens = codigo_imagem2) then
	if	nome_imagem2 = "" then
	/*se for enviado apenas o codigo da imegm , sme nome, é para excluir a imagem */
		DELETE FROM imagens WHERE id_imagens = codigo_imagem2;
	else
	/*se for enviado o código da imagem e tambem o nome, é fazer um update na imagem */
		UPDATE imagens SET caminho = nome_imagem2 WHERE id_imagens = codigo_imagem2;
		
		END if;
	END if;
	
if EXISTS(SELECT * FROM imagens WHERE id_imagens = codigo_imagem3) then
	if	nome_imagem3 = "" then
	/*se for enviado apenas o codigo da imegm , sme nome, é para excluir a imagem */
		DELETE FROM imagens WHERE id_imagens = codigo_imagem3;
	else
	/*se for enviado o código da imagem e tambem o nome, é fazer um update na imagem */
		UPDATE imagens SET caminho = nome_imagem3 WHERE id_imagens = codigo_imagem3;
		
		END if;
	END if;
	/*Parte para inserir uma nova imagem */
	if nome_imagem1 <> "" AND codigo_imagem1 = "" then
		INSERT INTO imagens(caminho, id_livro) VALUES (nome_imagem1, codigo_livro);
	END if;
	
	if nome_imagem2 <> "" AND codigo_imagem2 = "" then
		INSERT INTO imagens(caminho, id_livro) VALUES (nome_imagem2, codigo_livro);
	END if;
	
	if nome_imagem3 <> "" AND codigo_imagem3 = "" then
		INSERT INTO imagens(caminho, id_livro) VALUES (nome_imagem3, codigo_livro);
	END if;
	
	START TRANSACTION;
	/*Alterando dados dos autores*/
	UPDATE livros SET nome = nome_livro, biografia = descricao_livro
	WHERE id_livro = codigo_livro;
	
	if ROW_COUNT() > 1 THEN
		SET saida_rotulo = 'ERRO!';
		SET saida = 'Cadastro de livro NÃO FOI ALTERADO';
		ROLLBACK;
	ELSE
		SET saida_rotulo = 'TUDO CERTO';
		SET saida = 'Cadastro de livro alterado com sucesso!';
		COMMIT;
END if;
SELECT saida_rotulo, saida;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_edita_usuario` (IN `id_usuarios` INT, IN `nome_usuario` VARCHAR(70), OUT `saida` VARCHAR(80), IN `saida_rotulo` VARCHAR(15))  begin
	if not exists(select * from usuarios where usuario = nome_usuario) then
    begin
			declare
            link_usuario varchar(100);
            set link_usuario = nome_usuario;
            set link_usuario = CONCAT(link_usuario, '-', NOW());
			set link_usuario = (SELECT gera_link(link_usuario));
			update usuarios
            set usuario = nome_usuario, link = link_usuario
            where id_usuarios = id_usuarios;
            if row_count() = 0 then
            set saida_rotulo = 'ERRO!';
			set saida = "nenhum usuário foi ALTERADA ";
		else
			set saida_rotulo = 'Tudo certo!';
			set saida = 'categoria ALTERADA com sucesso!';
        end if;
        end;
        else
			set saida_rotulo = 'Ops!';
			set saida = "este usuário já existe já existe";
        end if;
	select saida_rotulo,saida;
 end$$

--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `gera_link` (`Texto` VARCHAR(100)) RETURNS VARCHAR(100) CHARSET utf8mb4 BEGIN
 DECLARE Resultado VARCHAR(100);


 SET Resultado   = UPPER(Texto); 
 
 
 SET Resultado = REPLACE(Resultado,' ','-');
 SET Resultado = REPLACE(Resultado,'\'','');
 SET Resultado = REPLACE(Resultado,'`','');
 SET Resultado = REPLACE(Resultado,'.','');
 
 SET Resultado = REPLACE(Resultado,'À','A');
 SET Resultado = REPLACE(Resultado,'Á','A');
 SET Resultado = REPLACE(Resultado,'Â','A');
 SET Resultado = REPLACE(Resultado,'Ã','A');
 SET Resultado = REPLACE(Resultado,'Ä','A');
 SET Resultado = REPLACE(Resultado,'Å','A');
 
 SET Resultado = REPLACE(Resultado,'È','E');
 SET Resultado = REPLACE(Resultado,'É','E');
 SET Resultado = REPLACE(Resultado,'Ê','E');
 SET Resultado = REPLACE(Resultado,'Ë','E');
 
 SET Resultado = REPLACE(Resultado,'Ì','I');
 SET Resultado = REPLACE(Resultado,'Í','I');
 SET Resultado = REPLACE(Resultado,'Î','I');
 SET Resultado = REPLACE(Resultado,'Ï','I');
 
 SET Resultado = REPLACE(Resultado,'Ò','O');
 SET Resultado = REPLACE(Resultado,'Ó','O');
 SET Resultado = REPLACE(Resultado,'Ô','O');
 SET Resultado = REPLACE(Resultado,'Õ','O');
 SET Resultado = REPLACE(Resultado,'Ö','O');
 
 SET Resultado = REPLACE(Resultado,'Ù','U');
 SET Resultado = REPLACE(Resultado,'Ú','U');
 SET Resultado = REPLACE(Resultado,'Û','U');
 SET Resultado = REPLACE(Resultado,'Ü','U');
 
 SET Resultado = REPLACE(Resultado,'Ø','O');
 
 SET Resultado = REPLACE(Resultado,'Æ','A');
 SET Resultado = REPLACE(Resultado,'Ð','D');
 SET Resultado = REPLACE(Resultado,'Ñ','N');
 SET Resultado = REPLACE(Resultado,'Ý','Y');
 SET Resultado = REPLACE(Resultado,'Þ','B');
 SET Resultado = REPLACE(Resultado,'ß','S');
 
 SET Resultado = REPLACE(Resultado,'Ç','C');
 
 RETURN LOWER(Resultado);
  
 END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `autores`
--

CREATE TABLE `autores` (
  `id_autor` int(11) NOT NULL,
  `nome` varchar(70) NOT NULL,
  `biografia` text NOT NULL,
  `link` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `autores`
--

INSERT INTO `autores` (`id_autor`, `nome`, `biografia`, `link`) VALUES
(88, 'Clarice lispector121', 'ESQUISDISASGHDFGASBA', 'clarice-lispector-2022-03-28-23:19:28'),
(90, 'Machado de Assis', ' Joaquim Maria Machado de Assis foi um escritor brasileiro, considerado por muitos críticos, estudiosos, escritores e leitores o maior nome da literatura brasileira.\r\n', 'machado-de-assis-2022-03-29-11:25:54'),
(93, 'dfghdfghdfg', ' dfhhdfhdfhddfdfh', 'dfghdfghdfg-2022-03-30-15:48:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id_categorias` int(11) NOT NULL,
  `categoria` varchar(70) NOT NULL,
  `link` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id_categorias`, `categoria`, `link`) VALUES
(45, 'Infantil', 'infantil-2022-03-20-14:51:51'),
(48, 'Romance', 'Romance'),
(49, 'Drama', 'Drama'),
(50, 'Novela ', 'Novela '),
(51, 'Conto', 'Conto'),
(52, 'Crônica ', 'Crônica '),
(53, 'Poesia ', 'Poesia '),
(54, 'Carta ', 'Carta '),
(55, 'Biografia pão 1', 'biografia-pao-1-2022-03-16-22:54:41'),
(56, 'Memórias', 'Memórias'),
(57, 'Aventura', 'Aventura'),
(58, 'História em Quadrinhos (HQ)', 'História em Quadrinhos (HQ)'),
(59, 'Literatura fantástica', 'Literatura fantástica'),
(60, 'Literatura Infantil', 'Literatura Infantil'),
(61, 'Literatura Infanto-juvenil', 'Literatura Infanto-juvenil'),
(62, 'Literatura nacional', 'Literatura nacional'),
(63, 'Terror', 'Terror'),
(64, 'Suspense', 'Suspense'),
(65, 'Policial', 'Policial'),
(66, 'Artigo acadêmico', 'Artigo acadêmico'),
(67, 'Artigo científico', 'Artigo científico'),
(70, 'Didáticos', 'didaticos-2022-03-19-17:06:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens`
--

CREATE TABLE `imagens` (
  `id_imagens` int(11) NOT NULL,
  `caminho` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `id_livro` int(11) DEFAULT NULL,
  `autores_codigo` int(11) DEFAULT NULL,
  `alterado_em` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `imagens`
--

INSERT INTO `imagens` (`id_imagens`, `caminho`, `link`, `id_livro`, `autores_codigo`, `alterado_em`) VALUES
(49, 'autores1526766709.jpg', '', NULL, 88, '2022-03-29 02:19:28'),
(55, 'autores877053979.jpg', '', NULL, 90, '2022-03-29 14:25:54'),
(56, 'autores316760545.jpg', '', NULL, 90, '2022-03-29 14:25:54'),
(60, 'autores2087843947.jpeg', '', NULL, 93, '2022-03-30 18:48:09'),
(61, 'livros2109318008.png', '', 1, NULL, '2022-03-30 18:55:42'),
(62, 'livros682692257.jpg', '', 3, NULL, '2022-03-30 19:25:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livros`
--

CREATE TABLE `livros` (
  `id_livro` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `subtitulo` varchar(100) NOT NULL,
  `biografia` text NOT NULL,
  `data_lancamento` date DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `livros`
--

INSERT INTO `livros` (`id_livro`, `titulo`, `subtitulo`, `biografia`, `data_lancamento`, `link`) VALUES
(1, 'dfgghdfhdfgh', '', ' dfghdfhdfhdfhdf', NULL, 'dfgghdfhdfgh-2022-03-30-15:55:42'),
(2, 'dfgdfhdfhdfhdf', '', ' dfhdfhdfhdfh', NULL, 'dfgdfhdfhdfhdf-2022-03-30-16:01:47'),
(3, 'gyuftyfty6cfvtgyfvtgyyfvtg', '', ' 7u9tg6y88y7yhu8iyhu8g', NULL, 'gyuftyfty6cfvtgyfvtgyyfvtg-2022-03-30-16:25:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livros_autores`
--

CREATE TABLE `livros_autores` (
  `id_livro` int(11) NOT NULL,
  `autores_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `livros_categorias`
--

CREATE TABLE `livros_categorias` (
  `id_livro` int(11) NOT NULL,
  `id_categorias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `nome` varchar(70) NOT NULL,
  `login` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `salt` varchar(20) DEFAULT NULL,
  `nivel` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `nome`, `login`, `email`, `senha`, `salt`, `nivel`) VALUES
(12, 'dimmy', 'dimmy', 'dimmys@gmail.com', '123', '123', '1');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `vvw_usuario`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `vvw_usuario` (
`id_usuarios` int(11)
,`nome_usuario` varchar(70)
,`login_usuario` varchar(100)
,`email_usuario` varchar(50)
,`senha_usuario` varchar(60)
,`salt_usuario` varchar(20)
,`nivel_usuario` char(1)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `vw_livros_categorias`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `vw_livros_categorias` (
`id_livro` int(11)
,`id_categoria` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `vw_retorna_autores`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `vw_retorna_autores` (
`id_autor` int(11)
,`nome_autor` varchar(70)
,`biografia_autor` text
,`link_autor` varchar(100)
,`caminho_imagem` varchar(100)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `vw_retorna_categorias`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `vw_retorna_categorias` (
`id_categoria` int(11)
,`Nome_Categoria` varchar(70)
,`link_Categoria` varchar(100)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `vw_retorna_livros`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `vw_retorna_livros` (
`id_livro` int(11)
,`nome_livro` varchar(100)
,`descricao_livro` text
,`link_livro` varchar(100)
,`caminho_imagem` varchar(100)
);

-- --------------------------------------------------------

--
-- Estrutura para vista `vvw_usuario`
--
DROP TABLE IF EXISTS `vvw_usuario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vvw_usuario`  AS SELECT `usuarios`.`id_usuarios` AS `id_usuarios`, `usuarios`.`nome` AS `nome_usuario`, `usuarios`.`login` AS `login_usuario`, `usuarios`.`email` AS `email_usuario`, `usuarios`.`senha` AS `senha_usuario`, `usuarios`.`salt` AS `salt_usuario`, `usuarios`.`nivel` AS `nivel_usuario` FROM `usuarios` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `vw_livros_categorias`
--
DROP TABLE IF EXISTS `vw_livros_categorias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_livros_categorias`  AS SELECT `livros_categorias`.`id_livro` AS `id_livro`, `livros_categorias`.`id_categorias` AS `id_categoria` FROM `livros_categorias` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `vw_retorna_autores`
--
DROP TABLE IF EXISTS `vw_retorna_autores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_retorna_autores`  AS SELECT `a`.`id_autor` AS `id_autor`, `a`.`nome` AS `nome_autor`, `a`.`biografia` AS `biografia_autor`, `a`.`link` AS `link_autor`, `b`.`caminho` AS `caminho_imagem` FROM (`autores` `a` left join `imagens` `b` on(`a`.`id_autor` = `b`.`autores_codigo`)) GROUP BY `a`.`id_autor` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `vw_retorna_categorias`
--
DROP TABLE IF EXISTS `vw_retorna_categorias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_retorna_categorias`  AS SELECT `categorias`.`id_categorias` AS `id_categoria`, `categorias`.`categoria` AS `Nome_Categoria`, `categorias`.`link` AS `link_Categoria` FROM `categorias` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `vw_retorna_livros`
--
DROP TABLE IF EXISTS `vw_retorna_livros`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_retorna_livros`  AS SELECT `a`.`id_livro` AS `id_livro`, `a`.`titulo` AS `nome_livro`, `a`.`biografia` AS `descricao_livro`, `a`.`link` AS `link_livro`, `b`.`caminho` AS `caminho_imagem` FROM (`livros` `a` left join `imagens` `b` on(`a`.`id_livro` = `b`.`id_livro`)) GROUP BY `a`.`id_livro` ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id_autor`);

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categorias`);

--
-- Índices para tabela `imagens`
--
ALTER TABLE `imagens`
  ADD PRIMARY KEY (`id_imagens`),
  ADD KEY `fk_imagens_livros` (`id_livro`),
  ADD KEY `fk_imagens_escritores` (`autores_codigo`) USING BTREE;

--
-- Índices para tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id_livro`);

--
-- Índices para tabela `livros_autores`
--
ALTER TABLE `livros_autores`
  ADD PRIMARY KEY (`id_livro`,`autores_codigo`) USING BTREE,
  ADD KEY `fk_livros_autores_autores` (`autores_codigo`) USING BTREE;

--
-- Índices para tabela `livros_categorias`
--
ALTER TABLE `livros_categorias`
  ADD PRIMARY KEY (`id_livro`,`id_categorias`),
  ADD KEY `fk_livros_categorias_categorias` (`id_categorias`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `autores`
--
ALTER TABLE `autores`
  MODIFY `id_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categorias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de tabela `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id_imagens` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id_livro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `livros_categorias`
--
ALTER TABLE `livros_categorias`
  ADD CONSTRAINT `fk_livros_categorias_categorias` FOREIGN KEY (`id_categorias`) REFERENCES `categorias` (`id_categorias`),
  ADD CONSTRAINT `fk_livros_categoriass_livros` FOREIGN KEY (`id_livro`) REFERENCES `livros` (`id_livro`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
