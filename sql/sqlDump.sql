DROP DATABASE IF EXISTS fh_2020_scm4_s1810307014; 
COMMIT; 

CREATE DATABASE IF NOT EXISTS `fh_2020_scm4_s1810307014` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;


/* privileges */
/*GRANT ALL PRIVILEGES ON fh_2020_scm4_S1810307037 . * TO 'fh_2020_scm4'@'localhost'; */
GRANT ALL PRIVILEGES ON fh_2020_scm4_S1810307014.* TO 'fh_2020_scm4'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES; 
COMMIT; 

USE `fh_2020_scm4_s1810307014`;

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
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `done` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `shoppingListId`, `caption`, `quantity`, `maxPrice`, `active`, `done`) VALUES
(1, 1, 'Lenovo 1020', 4, '345.60', 1, 0),
(2, 1, 'HP 999', 5, '0.80', 1, 0),
(3, 1, 'Apfel', 2, '5.00', 1, 0),
(4, 2, 'Banane', 2, '6.60', 0, 0),
(5, 2, 'Schnitzel', 4, '7.90', 1, 0),
(6, 3, 'Bier', 6, '4.50', 1, 0),
(7, 4, 'Milch', 7, '5.30', 1, 0),
(8, 4, 'Wein', 8, '24.00', 1, 0),
(9, 5, 'Wasser', 9, '0.00', 1, 0),
(10, 5, 'Klopapier', 3, '0.00', 1, 0),
(11, 6, 'Taschentuch', 6, '0.00', 1, 0),
(12, 6, 'Reinigungstuch', 2, '0.00', 1, 0),
(16, 2, 'asdf', 4, '34.34', 0, 0),
(17, 2, 'asdf', 345, '45.00', 0, 0),
(18, 2, 'fads', 34, '345.00', 1, 0),
(19, 2, 'fsdg', 345, '345.00', 1, 0),
(20, 18, 'asdf', 44, '44.00', 1, 0),
(21, 18, 'qwer', 55, '55.00', 1, 0),
(22, 20, 'wqer', 44, '44.00', 1, 0),
(23, 20, 'fsdg', 66, '66.00', 1, 0),
(24, 21, 'sdfg', 55, '55.00', 1, 0),
(25, 21, 'fsfdg', 44, '345.00', 0, 0);

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

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `action`, `ipAddress`, `userName`, `timeStamp`) VALUES
(4, 'ACTION_ADD_SHOPPING_LIST', '::1', 'pi', '2020-06-24 18:59:13'),
(5, 'ACTION_ADD_SHOPPING_LIST', '::1', 'pi', '2020-06-24 19:00:35'),
(6, 'ACTION_ADD_SHOPPING_LIST', '::1', 'pi', '2020-06-24 19:01:00'),
(7, 'ACTION_ADD_SHOPPING_LIST', '::1', 'pi', '2020-06-24 19:01:49'),
(8, 'ACTION_ADD_SHOPPING_LIST', '::1', 'pi', '2020-06-24 19:02:22'),
(9, 'ACTION_ADD_SHOPPING_LIST', '::1', 'pi', '2020-06-24 19:03:45'),
(10, 'ACTION_LOGOUT', '::1', 'N/A', '2020-06-24 19:07:10'),
(11, 'ACTION_LOGIN', '::1', 'hai', '2020-06-24 19:23:23'),
(12, 'ACTION_SHOW_ARTICLES', '::1', 'hai', '2020-06-24 19:23:29'),
(13, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:23:33'),
(14, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:23:35'),
(15, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:23:37'),
(16, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:23:39'),
(17, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:23:48'),
(18, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:23:49'),
(19, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:23:52'),
(20, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:24:16'),
(21, 'ACTION_SHOW_ARTICLES', '::1', 'hai', '2020-06-24 19:24:30'),
(22, 'ACTION_SHOW_ARTICLES', '::1', 'hai', '2020-06-24 19:24:37'),
(23, 'ACTION_SHOW_ARTICLES', '::1', 'hai', '2020-06-24 19:24:42'),
(24, 'ACTION_SHOW_ARTICLES', '::1', 'hai', '2020-06-24 19:24:46'),
(25, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:24:48'),
(26, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:24:49'),
(27, 'ACTION_SHOW_ARTICLES', '::1', 'hai', '2020-06-24 19:25:29'),
(28, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:25:31'),
(29, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:25:33'),
(30, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:25:35'),
(31, 'ACTION_CHANGE_ARTICLE_DONE', '::1', 'hai', '2020-06-24 19:25:36'),
(32, 'ACTION_CLOSE_SHOPPING_LIST', '::1', 'hai', '2020-06-24 19:26:13');

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
(4, 3, 'Test 4', '2020-07-05', 1, 1, 1, '50.00'),
(5, 3, 'Test 5', '2020-07-06', 1, 1, 1, '11.00'),
(6, 3, 'Test 6', '2020-07-07', 1, 1, 1, '7.00'),
(18, 3, 'asdfdas', '2020-06-04', 0, 1, 1, NULL),
(19, 3, 'asdf', '0000-00-00', 0, 0, NULL, NULL),
(20, 3, 'test', '2020-06-19', 1, 1, 1, '8.00'),
(21, 3, 'asdfads', '2020-06-27', 0, 1, NULL, NULL),
(22, 3, 'aaaaa', '2020-06-20', 1, 1, 1, '50.00'),
(23, 3, 'adsf', '2020-06-12', 0, 1, NULL, NULL),
(24, 3, 'asdf', '2020-06-03', 0, 1, NULL, NULL),
(25, 3, 'dfgsdfg', '2020-06-11', 0, 1, NULL, NULL),
(26, 3, 'asdf', '2020-06-03', 0, 1, NULL, NULL),
(27, 3, 'dfhggf', '2020-06-12', 0, 1, NULL, NULL),
(28, 3, 'asdf', '2020-06-11', 0, 1, NULL, NULL),
(29, 3, 'asdf', '2020-06-19', 0, 1, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `shoppinglist`
--
ALTER TABLE `shoppinglist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
