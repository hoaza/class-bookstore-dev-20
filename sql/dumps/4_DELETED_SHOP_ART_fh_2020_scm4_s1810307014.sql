DROP DATABASE IF EXISTS fh_2020_scm4_s1810307014; 
COMMIT; 

CREATE DATABASE IF NOT EXISTS `fh_2020_scm4_s1810307014` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fh_2020_scm4_s1810307014`;

--
-- Database: `fh_2020_scm4_s1810307014`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `shoppingListId` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `maxPrice` decimal(10,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `categoryId`, `shoppingListId`, `caption`, `quantity`, `maxPrice`) VALUES
(1, 1, 1, 'Lenovo 1020', 0, '0.00'),
(2, 1, 1, 'HP 999', 0, '0.00'),
(3, 2, 1, 'Apfel', 0, '0.00'),
(4, 2, 2, 'Banane', 0, '0.00'),
(5, 2, 2, 'Schnitzel', 0, '0.00'),
(6, 3, 3, 'Bier', 0, '0.00'),
(7, 3, 4, 'Milch', 0, '0.00'),
(8, 3, 4, 'Wein', 0, '0.00'),
(9, 3, 5, 'Wasser', 0, '0.00'),
(10, 4, 5, 'Klopapier', 0, '0.00'),
(11, 4, 6, 'Taschentuch', 0, '0.00'),
(12, 4, 6, 'Reinigungstuch', 0, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(5, 'Computer'),
(2, 'Essen'),
(4, 'Getränke'),
(3, 'Hygiene'),
(1, 'Keine Kategorie');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `ipAddress` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `timeStamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shoppinglist`
--

CREATE TABLE `shoppinglist` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `dueDateTime` datetime NOT NULL,
  `closed` tinyint(4) NOT NULL DEFAULT 0,
  `entrepreneurUserId` int(11) DEFAULT NULL,
  `pricePaid` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shoppinglist`
--

INSERT INTO `shoppinglist` (`id`, `userId`, `dueDateTime`, `closed`, `entrepreneurUserId`, `pricePaid`) VALUES
(1, 3, '2020-07-01 00:00:00', 1, 1, '10.00'),
(2, 4, '2020-07-02 00:00:00', 0, NULL, NULL),
(3, 5, '2020-07-04 00:00:00', 0, NULL, NULL),
(4, 6, '2020-07-05 00:00:00', 0, NULL, NULL),
(5, 4, '2020-07-06 00:00:00', 1, 2, '11.00'),
(6, 4, '2020-07-07 00:00:00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `passwordHash` char(40) NOT NULL,
  `type` enum('NEEDSHELP','ENTREPRENEUR') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userName`, `passwordHash`, `type`) VALUES
(1, 'hai', 'hai', 'ENTREPRENEUR'),
(2, 'pah', 'pah', 'ENTREPRENEUR'),
(3, 'pi', 'pi', 'NEEDSHELP'),
(4, 'sn', 'sn', 'NEEDSHELP'),
(5, 'ln', 'ln', 'NEEDSHELP'),
(6, 'ssf', 'ssf', 'NEEDSHELP');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryId` (`categoryId`),
  ADD KEY `shoppinglist_id_idx` (`shoppingListId`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoppinglist`
--
ALTER TABLE `shoppinglist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `entrepreneurUserId` (`entrepreneurUserId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoppinglist`
--
ALTER TABLE `shoppinglist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shoppinglist_id` FOREIGN KEY (`shoppingListId`) REFERENCES `shoppinglist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shoppinglist`
--
ALTER TABLE `shoppinglist`
  ADD CONSTRAINT `fk_order_user1` FOREIGN KEY (`entrepreneurUserId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
