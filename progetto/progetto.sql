-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 22, 2021 alle 19:35
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `progetto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `blog`
--

CREATE TABLE `blog` (
  `id` tinyint(4) NOT NULL,
  `autore` tinyint(4) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `categoria` tinyint(4) NOT NULL,
  `data` datetime NOT NULL,
  `nome_c` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `blog`
--

INSERT INTO `blog` (`id`, `autore`, `nome`, `foto`, `categoria`, `data`, `nome_c`) VALUES
(25, 14, 'Architettura Blog', 'architecture.jpg', 21, '2021-11-21 12:08:05', NULL),
(26, 15, 'Natura Blog', 'nature.jpg', 22, '2021-08-29 17:41:08', NULL),
(27, 16, 'Persona Blog', 'people.jpg', 23, '2021-08-29 17:45:49', NULL),
(28, 18, 'Lavoro Blog', 'work.jpg', 24, '2021-11-21 19:26:45', NULL),
(31, 14, 'Calcio Blog', 'football.jpg', 27, '2021-11-21 19:24:59', NULL),
(32, 15, 'Basketball Blog', 'basketball.jpg', 28, '2021-07-29 10:55:33', NULL),
(33, 16, 'Tennis Blog', 'tennis.jpg', 29, '2021-07-29 11:00:25', NULL),
(35, 18, 'Gatto Blog', 'cat.jpg', 31, '2021-11-21 19:17:39', NULL),
(36, 14, 'Golf Blog', 'golf.jpg', 32, '2021-07-31 08:57:37', NULL),
(37, 14, 'Natura2 Blog', 'nature2.jpg', 22, '2021-08-29 17:32:33', NULL),
(51, 22, 'Cane Blog', 'dog.jpg', 37, '2021-11-21 15:27:15', NULL),
(54, 21, 'Cane Blog', 'dog2.jpg', 37, '2021-11-22 11:03:20', 'paola');

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `id` tinyint(4) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `utente` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `utente`) VALUES
(21, 'Architettura', 14),
(22, 'Natura', 15),
(23, 'Persona', 16),
(24, 'Lavoro', 18),
(27, 'Calcio', 14),
(28, 'Basketball', 15),
(29, 'Tennis', 16),
(31, 'Gatto', 18),
(32, 'Golf', 14),
(33, 'Sport', 14),
(34, 'Animali', 22),
(37, 'Cane', 22);

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `id` tinyint(4) NOT NULL,
  `data` datetime NOT NULL,
  `nota` varchar(255) DEFAULT NULL,
  `utente` tinyint(4) NOT NULL,
  `post` tinyint(4) NOT NULL,
  `somma_punti` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `commento`
--

INSERT INTO `commento` (`id`, `data`, `nota`, `utente`, `post`, `somma_punti`) VALUES
(57, '2021-07-25 09:33:10', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ut porttitor felis. Donec vestibulum eros eu lacus interdum, vel tristique ipsum dapibus. Ut sagittis quam id lacus vulputate semper. Quisque a massa condimentum, fringilla metus malesuada, rho', 15, 42, NULL),
(58, '2021-07-25 09:44:43', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel posuere justo. Praesent aliquet tempor massa, vitae dapibus diam blandit ut. Donec blandit, est ut viverra porta, dolor metus rhoncus lorem, vel pretium orci sem sit amet nibh. Nullam sed ', 16, 42, NULL),
(59, '2021-07-25 09:45:48', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum auctor nunc massa, sit amet posuere odio accumsan vitae. Aliquam maximus aliquam enim, at maximus odio aliquet ut. Morbi tristique rhoncus lacus, ut luctus urna dapibus vitae. Fusce lorem', 16, 43, NULL),
(60, '2021-07-25 09:46:08', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum auctor nunc massa, sit amet posuere odio accumsan vitae. Aliquam maximus aliquam enim, at maximus odio aliquet ut. Morbi tristique rhoncus lacus, ut luctus urna dapibus vitae. Fusce lorem', 16, 44, NULL),
(61, '2021-07-25 09:46:31', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum auctor nunc massa, sit amet posuere odio accumsan vitae. Aliquam maximus aliquam enim, at maximus odio aliquet ut. Morbi tristique rhoncus lacus, ut luctus urna dapibus vitae. Fusce lorem', 16, 45, NULL),
(62, '2021-07-25 09:46:48', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum auctor nunc massa, sit amet posuere odio accumsan vitae. Aliquam maximus aliquam enim, at maximus odio aliquet ut. Morbi tristique rhoncus lacus, ut luctus urna dapibus vitae. Fusce lorem', 16, 46, NULL),
(67, '2021-07-25 12:01:54', 'Cras nec aliquet turpis, ac ornare purus. Nunc semper vitae enim sed posuere. Nam interdum lobortis nibh sit amet rutrum. Nullam vel sem elit. Duis tincidunt ullamcorper sodales. Nulla et euismod augue. Quisque sit amet arcu nec sem pellentesque ultrices ', 15, 54, NULL),
(68, '2021-07-25 12:03:04', 'It has survived not only five centuries, but also the leap into electronic typesetting', 14, 54, NULL),
(69, '2021-07-25 12:04:20', 'Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed posuere aliquam faucibus. Integer finibus ac tortor quis vestibulum. P', 18, 54, 14),
(73, '2021-08-05 08:10:02', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et leo non velit rhoncus blandit. Vivamus euismod dignissim dignissim. In mattis, ante eget rhoncus dictum, nibh lectus pretium purus, ac dignissim enim turpis ac leo. Donec sollicitudin just', 18, 57, NULL),
(74, '2021-08-05 08:11:44', 'Duis quis nunc sit amet quam consectetur fringilla in eget sem. Integer fermentum in sapien vel vestibulum. Phasellus eu fringilla nulla, vitae hendrerit erat. Aliquam erat volutpat. Suspendisse a pulvinar augue. Fusce auctor dictum mattis. Nullam a tempo', 14, 57, NULL),
(75, '2021-08-05 08:13:07', 'Phasellus sit amet feugiat lectus, vel laoreet leo. In eu urna tortor. Aliquam eros mi, tempor a tempus id, suscipit sit amet purus. Donec pretium libero id tellus feugiat pellentesque. Sed rutrum lorem vitae sapien vehicula cursus. Suspendisse nec condim', 15, 57, NULL),
(81, '2021-08-05 08:41:11', 'Mauris quam mauris, tincidunt a malesuada sit amet, tincidunt eu nisi. Quisque rhoncus efficitur eros, rutrum vehicula libero rhoncus vitae. Maecenas at vulputate nibh. Quisque fringilla magna id elementum ultricies. Sed fermentum lacus vitae urna commodo', 21, 48, NULL),
(82, '2021-08-06 14:38:50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ac sollicitudin magna. Donec semper egestas risus, et gravida nibh gravida id. In semper, massa eu mattis feugiat, metus metus maximus leo, vel malesuada turpis tortor a metus. In ut risus l', 21, 51, NULL),
(86, '2021-10-20 22:17:56', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', 22, 67, 3),
(90, '2021-11-05 21:02:31', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rhoncus dignissim interdum. Proin ac rutrum dolor. Donec euismod tristique libero, at cursus augue viverra in. Integer a aliquam ex.', 14, 67, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE `post` (
  `id` tinyint(4) NOT NULL,
  `data` datetime NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `testo` text DEFAULT NULL,
  `blog` tinyint(4) NOT NULL,
  `somma_punti_post` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `post`
--

INSERT INTO `post` (`id`, `data`, `titolo`, `foto`, `testo`, `blog`, `somma_punti_post`) VALUES
(42, '2021-09-15 17:51:26', 'Architettura Post', 'architecture.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 25, NULL),
(43, '2021-08-29 17:42:02', 'Natura Post', 'nature.jpg', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 26, NULL),
(44, '2021-08-29 17:42:59', 'Natura2 Post', 'nature2.jpg', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 26, NULL),
(45, '2021-08-29 17:43:13', 'Natura3 Post', 'nature3.jpg', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 26, NULL),
(46, '2021-08-29 17:43:34', 'Natura4 Post', 'nature4.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 26, NULL),
(47, '2021-08-29 17:43:47', 'Natura5 Post', 'nature5.jpg', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 26, NULL),
(48, '2021-08-29 17:46:19', 'Persona Post', 'people.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 27, NULL),
(49, '2021-08-29 17:46:36', 'Persona2 Post', 'people2.jpg', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 27, 0),
(51, '2021-08-29 17:52:56', 'Lavoro Post', 'work.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 28, NULL),
(52, '2021-08-29 17:53:21', 'Lavoro2 Post', 'work2.jpg', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 28, NULL),
(53, '2021-08-29 17:53:38', 'Lavoro3 Post', 'work3.jpg', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 28, NULL),
(54, '2021-08-29 17:54:01', 'Lavoro4 Post', 'work4.jpg', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 28, 5),
(56, '2021-09-15 17:42:36', 'Calcio Post', 'football.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 31, NULL),
(57, '2021-07-29 10:56:26', 'Basketball Post', 'basketball.jpg', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 32, 1),
(58, '2021-07-29 11:01:40', 'Tennis Post', 'tennis.jpg', 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 33, 2),
(60, '2021-08-29 17:54:17', 'Gatto Post', 'cat.jpg', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 35, NULL),
(61, '2021-11-21 11:58:46', 'Golf Post', 'golf.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 36, 4),
(62, '2021-08-29 17:34:33', 'Natura Post2', 'nature2.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 37, 4),
(66, '2021-11-22 19:29:17', 'Calcio Post 2', 'football2.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. ', 31, NULL),
(67, '2021-10-23 20:52:17', 'Gatto2 Post', 'cat2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam a sem et risus lobortis dapibus. Quisque sagittis magna convallis libero rhoncus, eu dignissim ex semper. Curabitur malesuada tellus ut nisi vehicula vestibulum. Sed non purus nulla. Morbi sapien sem, aliquet et mattis at, malesuada quis quam. Ut eleifend nec magna eget hendrerit. Vestibulum tempor risus ut odio consectetur volutpat. Fusce vel elit diam. Nulla vel pellentesque urna. Quisque lectus ante, pulvinar et enim vitae, vestibulum consequat ligula. Cras venenatis hendrerit eleifend. In tristique sodales erat, a pellentesque leo dapibus non. In non ullamcorper diam. Ut eget consequat erat, non egestas ligula.\r\nAenean massa ante, varius non velit id, bibendum scelerisque elit. Cras eget consequat quam. Nullam feugiat imperdiet risus, et laoreet felis euismod eu. Mauris luctus nisl vitae dolor consequat, quis malesuada sem blandit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis vitae elit lorem. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean tristique eros vel posuere euismod. Nulla imperdiet, mi ut commodo auctor, ex lacus aliquam eros, iaculis porttitor magna ex vitae tellus. Vivamus sit amet suscipit elit, dignissim varius sapien. Sed sit amet maximus sem, feugiat aliquam est. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer finibus lorem purus, ultricies placerat tellus ultricies vitae.', 35, 8),
(72, '2021-11-21 15:27:43', 'Cane Post', 'dog.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam varius in felis quis hendrerit. Sed ullamcorper quam velit, eu volutpat libero feugiat at. Integer metus enim, varius et cursus nec, accumsan nec ligula. Sed vehicula purus eu sapien scelerisque semper. Proin at facilisis massa. Quisque sit amet elit ut ligula bibendum euismod non ut nisl. Vivamus et neque vestibulum, dignissim enim in, finibus felis. Vestibulum molestie magna erat, id ultricies sem maximus quis. Nam lobortis mollis facilisis. Sed scelerisque orci in orci cursus, scelerisque molestie arcu faucibus.', 51, NULL),
(75, '2021-11-22 11:16:30', 'Cane Post', 'dog2.jpg', 'Donec bibendum sem ex, vitae pretium lectus tempus a. Morbi scelerisque a quam ultrices pharetra. Nunc suscipit tincidunt nulla quis pharetra. Curabitur varius nec quam sit amet hendrerit. Vivamus pretium porta pharetra. Donec elementum purus nec nisl luctus imperdiet. Etiam accumsan finibus tempus. Curabitur at faucibus erat, at mollis lectus. Vivamus venenatis ligula pellentesque sem finibus laoreet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur auctor urna nec odio faucibus tempor eget viverra massa.', 54, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `punteggio`
--

CREATE TABLE `punteggio` (
  `utente` tinyint(4) NOT NULL,
  `commento` tinyint(4) NOT NULL,
  `punteggio` tinyint(4) NOT NULL CHECK (`punteggio` >= 0 and `punteggio` <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `punteggio`
--

INSERT INTO `punteggio` (`utente`, `commento`, `punteggio`) VALUES
(14, 69, 5),
(14, 86, 3),
(15, 69, 4),
(16, 69, 3),
(16, 86, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `punteggio_post`
--

CREATE TABLE `punteggio_post` (
  `utente` tinyint(4) NOT NULL,
  `post` tinyint(4) NOT NULL,
  `punteggio` tinyint(4) NOT NULL CHECK (`punteggio` >= 0 and `punteggio` <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `punteggio_post`
--

INSERT INTO `punteggio_post` (`utente`, `post`, `punteggio`) VALUES
(14, 49, 0),
(14, 54, 3),
(14, 58, 0),
(14, 67, 3),
(15, 54, 2),
(15, 67, 0),
(16, 49, 5),
(16, 67, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `sub`
--

CREATE TABLE `sub` (
  `cat1` tinyint(4) NOT NULL,
  `cat2` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `sub`
--

INSERT INTO `sub` (`cat1`, `cat2`) VALUES
(27, 33),
(28, 33),
(29, 33),
(31, 34),
(32, 33),
(37, 34);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` tinyint(4) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `documento` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `email`, `nome`, `pass`, `tel`, `documento`, `foto`) VALUES
(14, 'mario@rossi.it', 'mario', 'rossi123', '3891122333', 'DARSRD91R22S019A', 'user1.jpg'),
(15, 'paolo@neri.it', 'paolo', 'neri123', '3334566700', 'FCGMEC05T12A089L', NULL),
(16, 'marco@bianchi.it', 'marco', 'bianchi123', '3214567800', 'ACRSRC55R12A069F', 'user2.jpg'),
(18, 'paola@paoli.it', 'paola', 'paoli123', '3432241098', 'DKRAEC25P12A010M', 'user3.jpg'),
(21, 'franco@franchi.it', 'franco', 'franchi123', '3898722890', 'DCRMRS95L12B089D', NULL),
(22, 'simona@verdi.it', 'simona', 'simona123', '3335598511', 'DVRVRV95R12V089F', 'user4.jpg');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autore_fk` (`autore`),
  ADD KEY `categoria_fk` (`categoria`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utente4_fk` (`utente`);

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_fk` (`post`),
  ADD KEY `utente3_fk` (`utente`);

--
-- Indici per le tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_fk` (`blog`);

--
-- Indici per le tabelle `punteggio`
--
ALTER TABLE `punteggio`
  ADD PRIMARY KEY (`utente`,`commento`),
  ADD KEY `commento_fk` (`commento`);

--
-- Indici per le tabelle `punteggio_post`
--
ALTER TABLE `punteggio_post`
  ADD PRIMARY KEY (`utente`,`post`),
  ADD KEY `post2_fk` (`post`);

--
-- Indici per le tabelle `sub`
--
ALTER TABLE `sub`
  ADD PRIMARY KEY (`cat1`,`cat2`),
  ADD KEY `cat2_fk` (`cat2`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `blog`
--
ALTER TABLE `blog`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `autore_fk` FOREIGN KEY (`autore`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categoria_fk` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `utente4_fk` FOREIGN KEY (`utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `post_fk` FOREIGN KEY (`post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utente3_fk` FOREIGN KEY (`utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `blog_fk` FOREIGN KEY (`blog`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `punteggio`
--
ALTER TABLE `punteggio`
  ADD CONSTRAINT `commento_fk` FOREIGN KEY (`commento`) REFERENCES `commento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utente5_fk` FOREIGN KEY (`utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `punteggio_post`
--
ALTER TABLE `punteggio_post`
  ADD CONSTRAINT `post2_fk` FOREIGN KEY (`post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utente6_fk` FOREIGN KEY (`utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `sub`
--
ALTER TABLE `sub`
  ADD CONSTRAINT `cat1_fk` FOREIGN KEY (`cat1`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cat2_fk` FOREIGN KEY (`cat2`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
