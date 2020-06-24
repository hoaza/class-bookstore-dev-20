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
  `shoppingListId` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `maxPrice` decimal(10,2) UNSIGNED NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `shoppingListId`, `caption`, `quantity`, `maxPrice`, `active`) VALUES
(1, 1, 'Lenovo 1020', 4, '345.60', 1),
(2, 1, 'HP 999', 5, '0.80', 1),
(3, 1, 'Apfel', 2, '5.00', 1),
(4, 2, 'Banane', 2, '6.60', 0),
(5, 2, 'Schnitzel', 4, '7.90', 1),
(6, 3, 'Bier', 6, '4.50', 1),
(7, 4, 'Milch', 7, '5.30', 1),
(8, 4, 'Wein', 8, '24.00', 1),
(9, 5, 'Wasser', 9, '0.00', 1),
(10, 5, 'Klopapier', 3, '0.00', 1),
(11, 6, 'Taschentuch', 6, '0.00', 1),
(12, 6, 'Reinigungstuch', 2, '0.00', 1),
(16, 2, 'asdf', 4, '34.34', 0),
(17, 2, 'asdf', 345, '45.00', 0),
(18, 2, 'fads', 34, '345.00', 1),
(19, 2, 'fsdg', 345, '345.00', 1),
(20, 18, 'asdf', 44, '44.00', 1),
(21, 18, 'qwer', 55, '55.00', 1),
(22, 20, 'wqer', 44, '44.00', 1),
(23, 20, 'fsdg', 66, '66.00', 1);

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
  `caption` varchar(255) NOT NULL,
  `dueDateTime` date NOT NULL,
  `closed` tinyint(4) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `entrepreneurUserId` int(11) DEFAULT NULL,
  `pricePaid` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shoppinglist`
--

INSERT INTO `shoppinglist` (`id`, `userId`, `caption`, `dueDateTime`, `closed`, `active`, `entrepreneurUserId`, `pricePaid`) VALUES
(1, 3, 'Test 1', '2020-07-01', 1, 1, 1, '2.00'),
(2, 3, 'Test 2', '2020-07-02', 0, 0, NULL, NULL),
(3, 3, 'Test 3', '2020-07-04', 0, 0, NULL, NULL),
(4, 3, 'Test 4', '2020-07-05', 0, 1, 1, NULL),
(5, 3, 'Test 5', '2020-07-06', 1, 1, 1, '11.00'),
(6, 3, 'Test 6', '2020-07-07', 1, 1, 1, '7.00'),
(18, 3, 'asdfdas', '2020-06-04', 0, 1, 1, NULL),
(19, 3, 'asdf', '0000-00-00', 0, 0, NULL, NULL),
(20, 3, 'test', '2020-06-19', 1, 1, 1, '8.00'),
(21, 3, 'asdfads', '2020-06-27', 0, 1, NULL, NULL),
(22, 3, 'aaaaa', '2020-06-20', 0, 1, NULL, NULL);

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
(1, 'hai', '1da818bce04286996d9e1de64ae04146d55ee452', 'ENTREPRENEUR'),
(2, 'pah', '8456474c774dd1e0e06ecdcc6ddded790e605f57', 'ENTREPRENEUR'),
(3, 'pi', '460d1e832f42cc8f4d4e281e82277a28b306a322', 'NEEDSHELP'),
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
  ADD KEY `shoppinglist_id_idx` (`shoppingListId`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoppinglist`
--
ALTER TABLE `shoppinglist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  ADD CONSTRAINT `shoppinglist_id` FOREIGN KEY (`shoppingListId`) REFERENCES `shoppinglist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shoppinglist`
--
ALTER TABLE `shoppinglist`
  ADD CONSTRAINT `fk_order_user1` FOREIGN KEY (`entrepreneurUserId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
