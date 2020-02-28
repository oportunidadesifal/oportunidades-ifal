-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Fev-2020 às 15:29
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `oportunista`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `courses`
--

INSERT INTO `courses` (`id`, `name`) VALUES
(1, 'Sistemas de Informação');

-- --------------------------------------------------------

--
-- Estrutura da tabela `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `eventSchedule` varchar(255) NOT NULL,
  `eventDate` varchar(30) NOT NULL,
  `site` varchar(255) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `events`
--

INSERT INTO `events` (`id`, `location`, `eventSchedule`, `eventDate`, `site`, `price`) VALUES
(3, 'LCCV - Laboratório de Computação Científica e Visualização localizado no Campus A. C. Simões da UFAL - Universidade Federal de Alagoas.', 'Data: 25 à 28 março de 2020\r\n\r\n    25 e 26 de março (quarta e quinta): MiniDebCamp — período para colaboradores(as) do Debian se encontrarem e trabalharem conjuntamente em um ou mais aspectos do projeto. Essa será a nossa versão da brasileira da Debcamp, ', '2020-03-25', 'https://maceio2020.debian.net', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `interests`
--

CREATE TABLE `interests` (
  `id` int(11) NOT NULL,
  `opportunityId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `opportunityData` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastUpdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `opportunityVersion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `interests`
--

INSERT INTO `interests` (`id`, `opportunityId`, `userId`, `opportunityData`, `created`, `lastUpdate`, `opportunityVersion`) VALUES
(2, 2, 1, '{\"salary\":0,\"numberVacantJob\":1,\"weeklyWorkLoad\":30,\"benefits\":\"N\\u00e3o informado, ver contato.\",\"requirements\":\"- Aplicativos h\\u00edbridos com Angular\\r\\n- Banco de Dados\",\"location\":\"N\\u00e3o informado, ver contato.\",\"shift\":\"N\\u00e3o informado, ver contato.\",\"code\":1,\"companyId\":1,\"id\":2,\"title\":\"Desenvolvedor de Apps - Empresa divulga vaga para est\\u00e1gio ou formando\",\"description\":\"Empresa divulga vaga para est\\u00e1gio ou formando com possibilidade de contrata\\u00e7\\u00e3o imediata. \\r\\nNecess\\u00e1rio Expertise em desenvolvimento de aplicativos h\\u00edbridos(angular) e conhecimento em banco de dados.\\r\\nContato: Marco Cavalcanti (82) 99997-0300\",\"authorId\":2,\"author\":{\"user_id\":\"2\",\"username\":\"prof.augusto.ifal@gmail.com\",\"name\":\"Augusto\",\"surname\":\"IFAL\",\"gender\":\"m\",\"enrollment\":\"123456\",\"birthday\":\"1980-01-01\",\"university_id\":\"1\"},\"type\":\"Internship\",\"posterIconId\":1,\"posterBackgroundId\":1,\"closed\":false,\"version\":0,\"created\":\"2020-02-28 11:15:14\",\"lastUpdate\":\"\",\"deleted\":false,\"interest\":true}', '2020-02-28 14:23:46', '2020-02-28 14:23:46', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `internships`
--

CREATE TABLE `internships` (
  `id` int(11) NOT NULL,
  `salary` float NOT NULL,
  `numberVacantJob` int(11) NOT NULL,
  `weeklyWorkLoad` int(11) NOT NULL,
  `benefits` text NOT NULL,
  `requirements` text NOT NULL,
  `location` text NOT NULL,
  `shift` text NOT NULL,
  `code` text NOT NULL,
  `companyId` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `internships`
--

INSERT INTO `internships` (`id`, `salary`, `numberVacantJob`, `weeklyWorkLoad`, `benefits`, `requirements`, `location`, `shift`, `code`, `companyId`) VALUES
(2, 0, 1, 30, 'Não informado, ver contato.', '- Aplicativos híbridos com Angular\r\n- Banco de Dados', 'Não informado, ver contato.', 'Não informado, ver contato.', '1', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jwtblacklist`
--

CREATE TABLE `jwtblacklist` (
  `id` int(11) NOT NULL,
  `jwtId` varchar(255) NOT NULL,
  `expTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jwtblacklist`
--

INSERT INTO `jwtblacklist` (`id`, `jwtId`, `expTime`) VALUES
(1, '5e581a173a2d89.78128726', '2020-03-08 19:35:51'),
(2, '5e581b436b27d9.15872644', '2020-03-08 19:40:51');

-- --------------------------------------------------------

--
-- Estrutura da tabela `monitoring`
--

CREATE TABLE `monitoring` (
  `id` int(11) NOT NULL,
  `monitors` int(11) NOT NULL,
  `scholarship` float NOT NULL,
  `numberOfMonitors` int(11) NOT NULL,
  `disciplineCode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `opportunities`
--

CREATE TABLE `opportunities` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `authorId` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `version` int(11) NOT NULL DEFAULT 0,
  `closed` tinyint(1) NOT NULL DEFAULT 0,
  `posterBackgroundId` int(11) NOT NULL DEFAULT 0,
  `posterIconId` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastUpdate` timestamp NULL DEFAULT NULL ,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `opportunities`
--

INSERT INTO `opportunities` (`id`, `title`, `description`, `authorId`, `type`, `version`, `closed`, `posterBackgroundId`, `posterIconId`, `created`, `lastUpdate`, `deleted`) VALUES
(1, 'CIEE Oportunidades - Um sistema de integração entre alunos, professores, instituição e empresas para oportunidades de prática profissional', 'O sistema web atua na busca e divulgação de vagas de estágios, projetos de ensino, pesquisa e extensão, bem como eventos na área de atuação dos alunos. Em parceria com o CIEE/IFAL Maceió, o sistema web contará com informações sobre procedimentos para atender o requisito da prática profissional no contexto dos cursos no IFAL\r\n                        ', 2, 'Research', 1, 0, 0, 0, '2020-02-27 19:38:52', '2020-02-28 13:57:44', 0),
(2, 'Desenvolvedor de Apps - Empresa divulga vaga para estágio ou formando', 'Empresa divulga vaga para estágio ou formando com possibilidade de contratação imediata. \r\nNecessário Expertise em desenvolvimento de aplicativos híbridos(angular) e conhecimento em banco de dados.\r\nContato: Marco Cavalcanti (82) 99997-0300', 2, 'Internship', 0, 0, 1, 1, '2020-02-28 14:15:14', NULL, 0),
(3, ' MiniDebConf Maceió 2020 ', 'De 25 à 28 de março (quarta, quinta, sexta e sábado) Maceió sediará uma MiniDebCamp e uma MiniDebConf composta por palestras, debates, oficinas, sprints, BSP (Bug Squashing Party) e eventos sociais.\r\n\r\nA MiniDebConf Maceió 2020 é um evento aberto a todos(as), independente do seu nível de conhecimento sobre Debian.', 2, 'Event', 0, 0, 0, 0, '2020-02-28 14:28:45', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `opportunities_tags`
--

CREATE TABLE `opportunities_tags` (
  `id` int(11) NOT NULL,
  `opportunityId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20180530132703, 'CreateUsersTable', '2020-02-26 22:37:00', '2020-02-26 22:37:00', 0),
(20180530134256, 'CreateTeachersTable', '2020-02-26 22:37:00', '2020-02-26 22:37:02', 0),
(20180530135123, 'CreateStudentsTable', '2020-02-26 22:37:03', '2020-02-26 22:37:04', 0),
(20180530140410, 'CreateProfilesTable', '2020-02-26 22:37:04', '2020-02-26 22:37:05', 0),
(20180530143034, 'CreateCoursesTable', '2020-02-26 22:37:05', '2020-02-26 22:37:06', 0),
(20180530143226, 'CreateSubjectsTable', '2020-02-26 22:37:06', '2020-02-26 22:37:08', 0),
(20180530150338, 'CreateUrgentNews', '2020-02-26 22:37:09', '2020-02-26 22:37:10', 0),
(20180530153239, 'CreateStudentsSubjects', '2020-02-26 22:37:10', '2020-02-26 22:37:12', 0),
(20180530181830, 'CreateTeacherSubjectsTable', '2020-02-26 22:37:12', '2020-02-26 22:37:13', 0),
(20180530184640, 'CreateTagsTable', '2020-02-26 22:37:13', '2020-02-26 22:37:14', 0),
(20180530184810, 'CreateStudentsTagsTable', '2020-02-26 22:37:14', '2020-02-26 22:37:15', 0),
(20180530191645, 'CreateOpportunitiesTable', '2020-02-26 22:37:16', '2020-02-26 22:37:17', 0),
(20180530192947, 'CreateOpportunitiesTagsTable', '2020-02-26 22:37:17', '2020-02-26 22:37:19', 0),
(20180530193541, 'CreateInterestsTable', '2020-02-26 22:37:19', '2020-02-26 22:37:20', 0),
(20180530195544, 'CreateMonitoringTable', '2020-02-26 22:37:20', '2020-02-26 22:37:22', 0),
(20180530202538, 'CreateResearchesTable', '2020-02-26 22:37:22', '2020-02-26 22:37:24', 0),
(20180530203448, 'CreateInternshipsTable', '2020-02-26 22:37:24', '2020-02-26 22:37:26', 0),
(20180530203806, 'CreateEventsTable', '2020-02-26 22:37:27', '2020-02-26 22:37:28', 0),
(20180530204447, 'CreateJwtBlackListTable', '2020-02-26 22:37:28', '2020-02-26 22:37:29', 0),
(20180612184850, 'CreateUserDeviceTokenTable', '2020-02-26 22:37:29', '2020-02-26 22:37:30', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `image_id` varchar(255) DEFAULT NULL,
  `gender` enum('m','f') NOT NULL,
  `enrollment` varchar(30) NOT NULL,
  `birthday` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `name`, `surname`, `image_id`, `gender`, `enrollment`, `birthday`) VALUES
(1, 1, 'Aluno', 'IFAL', NULL, 'm', '1234', '2000-01-01'),
(2, 2, 'Augusto', 'IFAL', NULL, 'm', '123456', '1980-01-01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `researches`
--

CREATE TABLE `researches` (
  `id` int(11) NOT NULL,
  `status` text NOT NULL,
  `modality` text NOT NULL,
  `startDate` varchar(30) NOT NULL,
  `duration` int(11) NOT NULL,
  `scholarship` float NOT NULL,
  `members` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `researches`
--

INSERT INTO `researches` (`id`, `status`, `modality`, `startDate`, `duration`, `scholarship`, `members`) VALUES
(1, 'Em andamento', 'Desenvolvimento', '2020-01-27', 3, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `students`
--

CREATE TABLE `students` (
  `user_id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `students`
--

INSERT INTO `students` (`user_id`, `university_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `students_subjects`
--

CREATE TABLE `students_subjects` (
  `id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `students_subjects`
--

INSERT INTO `students_subjects` (`id`, `studentId`, `subjectId`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `students_tags`
--

CREATE TABLE `students_tags` (
  `id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  `Schedule` text NOT NULL,
  `days` varchar(255) NOT NULL,
  `period` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `subjects`
--

INSERT INTO `subjects` (`id`, `course_id`, `name`, `code`, `Schedule`, `days`, `period`) VALUES
(1, 1, 'Análise e Projeto de Sistemas de Informação', 'APSI125', 'Terça-feira  18:50 - 20:30\r\nQuarta-feira 20:40 - 22:20', '2', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `teachers`
--

CREATE TABLE `teachers` (
  `user_id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `teachers`
--

INSERT INTO `teachers` (`user_id`, `university_id`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `teachers_subjects`
--

CREATE TABLE `teachers_subjects` (
  `id` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `teachers_subjects`
--

INSERT INTO `teachers_subjects` (`id`, `teacherId`, `subjectId`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `urgent_news`
--

CREATE TABLE `urgent_news` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `authorId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastUpdate` timestamp NULL DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `userdevicetoken`
--

CREATE TABLE `userdevicetoken` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deviceToken` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastUpdate` timestamp NULL DEFAULT NULL ,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `category` enum('Teacher','Student') NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastUpdate` timestamp NULL DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `category`, `created`, `lastUpdate`) VALUES
(1, 'aluno@ifal.edu.br', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Student', '2020-02-26 18:39:08', NULL),
(2, 'prof.augusto.ifal@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Teacher', '2020-02-26 21:48:28', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_interests_opportunities` (`opportunityId`),
  ADD KEY `fk_interests_users` (`userId`);

--
-- Índices para tabela `internships`
--
ALTER TABLE `internships`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `jwtblacklist`
--
ALTER TABLE `jwtblacklist`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `monitoring`
--
ALTER TABLE `monitoring`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `opportunities`
--
ALTER TABLE `opportunities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_opportunities_users` (`authorId`);

--
-- Índices para tabela `opportunities_tags`
--
ALTER TABLE `opportunities_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_opportunitiesTags_opportunities` (`opportunityId`),
  ADD KEY `fk_opportunitiesTags_tags` (`tagId`);

--
-- Índices para tabela `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Índices para tabela `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_profiles_users` (`user_id`);

--
-- Índices para tabela `researches`
--
ALTER TABLE `researches`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices para tabela `students_subjects`
--
ALTER TABLE `students_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_studentsSubjects_students` (`studentId`),
  ADD KEY `fk_studentsSubjects_subjects` (`subjectId`);

--
-- Índices para tabela `students_tags`
--
ALTER TABLE `students_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_studentsTags_students` (`studentId`),
  ADD KEY `fk_studentsTags_tags` (`tagId`);

--
-- Índices para tabela `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subjects_course` (`course_id`);

--
-- Índices para tabela `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices para tabela `teachers_subjects`
--
ALTER TABLE `teachers_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_teacherSubjects_teachers` (`teacherId`),
  ADD KEY `fk_teacherSubjects_subjects` (`subjectId`);

--
-- Índices para tabela `urgent_news`
--
ALTER TABLE `urgent_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_urgentNews_users` (`authorId`),
  ADD KEY `fk_urgentNews_subject` (`subjectId`);

--
-- Índices para tabela `userdevicetoken`
--
ALTER TABLE `userdevicetoken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userDeviceToken_users` (`user_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `interests`
--
ALTER TABLE `interests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `jwtblacklist`
--
ALTER TABLE `jwtblacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `opportunities`
--
ALTER TABLE `opportunities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `opportunities_tags`
--
ALTER TABLE `opportunities_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `students_subjects`
--
ALTER TABLE `students_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `students_tags`
--
ALTER TABLE `students_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `teachers_subjects`
--
ALTER TABLE `teachers_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `urgent_news`
--
ALTER TABLE `urgent_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `userdevicetoken`
--
ALTER TABLE `userdevicetoken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_events_opportunities` FOREIGN KEY (`id`) REFERENCES `opportunities` (`id`);

--
-- Limitadores para a tabela `interests`
--
ALTER TABLE `interests`
  ADD CONSTRAINT `fk_interests_opportunities` FOREIGN KEY (`opportunityId`) REFERENCES `opportunities` (`id`),
  ADD CONSTRAINT `fk_interests_users` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `internships`
--
ALTER TABLE `internships`
  ADD CONSTRAINT `fk_internships_opportunities` FOREIGN KEY (`id`) REFERENCES `opportunities` (`id`);

--
-- Limitadores para a tabela `monitoring`
--
ALTER TABLE `monitoring`
  ADD CONSTRAINT `fk_monitoring_opportunities` FOREIGN KEY (`id`) REFERENCES `opportunities` (`id`);

--
-- Limitadores para a tabela `opportunities`
--
ALTER TABLE `opportunities`
  ADD CONSTRAINT `fk_opportunities_users` FOREIGN KEY (`authorId`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `opportunities_tags`
--
ALTER TABLE `opportunities_tags`
  ADD CONSTRAINT `fk_opportunitiesTags_opportunities` FOREIGN KEY (`opportunityId`) REFERENCES `opportunities` (`id`),
  ADD CONSTRAINT `fk_opportunitiesTags_tags` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`);

--
-- Limitadores para a tabela `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `fk_profiles_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `researches`
--
ALTER TABLE `researches`
  ADD CONSTRAINT `fk_researches_opportunities` FOREIGN KEY (`id`) REFERENCES `opportunities` (`id`);

--
-- Limitadores para a tabela `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_students_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `students_subjects`
--
ALTER TABLE `students_subjects`
  ADD CONSTRAINT `fk_studentsSubjects_students` FOREIGN KEY (`studentId`) REFERENCES `students` (`user_id`),
  ADD CONSTRAINT `fk_studentsSubjects_subjects` FOREIGN KEY (`subjectId`) REFERENCES `subjects` (`id`);

--
-- Limitadores para a tabela `students_tags`
--
ALTER TABLE `students_tags`
  ADD CONSTRAINT `fk_studentsTags_students` FOREIGN KEY (`studentId`) REFERENCES `students` (`user_id`),
  ADD CONSTRAINT `fk_studentsTags_tags` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`);

--
-- Limitadores para a tabela `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_subjects_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Limitadores para a tabela `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `fk_teachers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `teachers_subjects`
--
ALTER TABLE `teachers_subjects`
  ADD CONSTRAINT `fk_teacherSubjects_subjects` FOREIGN KEY (`subjectId`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `fk_teacherSubjects_teachers` FOREIGN KEY (`teacherId`) REFERENCES `teachers` (`user_id`);

--
-- Limitadores para a tabela `urgent_news`
--
ALTER TABLE `urgent_news`
  ADD CONSTRAINT `fk_urgentNews_subject` FOREIGN KEY (`subjectId`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `fk_urgentNews_users` FOREIGN KEY (`authorId`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `userdevicetoken`
--
ALTER TABLE `userdevicetoken`
  ADD CONSTRAINT `fk_userDeviceToken_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
