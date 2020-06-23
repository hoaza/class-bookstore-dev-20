
DROP DATABASE IF EXISTS fh_2020_scm4_s1810307014; 
COMMIT; 

CREATE DATABASE IF NOT EXISTS `fh_2020_scm4_s1810307014` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fh_2020_scm4_s1810307014`;

--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `articleId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`articleId`, `categoryId`, `caption`) VALUES
(1, 1, 'Lenovo 1020'),
(2, 1, 'HP 999'),
(3, 2, 'Apfel'),
(4, 2, 'Banane'),
(5, 2, 'Schnitzel'),
(6, 3, 'Bier'),
(7, 3, 'Milch'),
(8, 3, 'Wein'),
(9, 3, 'Wasser'),
(10, 4, 'Klopapier'),
(11, 4, 'Taschentuch'),
(12, 4, 'Reinigungstuch');

-- --------------------------------------------------------

--
-- Table structure for table `article_shoppinglist`
--

CREATE TABLE `article_shoppinglist` (
  `articleShoppingListId` int(11) NOT NULL,
  `shoppingListId` int(11) NOT NULL,
  `articleId` int(11) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `maxPrice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article_shoppinglist`
--

INSERT INTO `article_shoppinglist` (`articleShoppingListId`, `shoppingListId`, `articleId`, `quantity`, `maxPrice`) VALUES
(1, 1, 1, 12, '23.00'),
(2, 1, 2, 1, '10.00'),
(3, 1, 3, 3, '34.00'),
(4, 2, 4, 5, '6.00'),
(5, 2, 5, 1, '6.00'),
(6, 2, 6, 2, '7.00'),
(7, 3, 7, 3, '6.00'),
(8, 3, 8, 4, '8.00'),
(9, 4, 9, 5, '9.00'),
(10, 4, 1, 6, '6.00'),
(11, 5, 4, 8, '34.00'),
(12, 5, 5, 5, '10.00'),
(13, 5, 6, 4, '34.00'),
(14, 5, 3, 1, '10.00'),
(15, 6, 4, 6, '7.00'),
(16, 6, 9, 4, '34.00'),
(17, 6, 10, 2, '3.00'),
(18, 6, 11, 1, '30.00'),
(19, 6, 12, 3, '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryId`, `name`) VALUES
(1, 'Computer'),
(2, 'Essen'),
(4, 'Getränke'),
(3, 'Hygiene');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `logId` int(11) NOT NULL,
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
  `shoppingListId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `dueDateTime` datetime NOT NULL,
  `closed` tinyint(4) NOT NULL DEFAULT 0,
  `entrepreneurUserId` int(11) DEFAULT NULL,
  `pricePaid` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shoppinglist`
--

INSERT INTO `shoppinglist` (`shoppingListId`, `userId`, `dueDateTime`, `closed`, `entrepreneurUserId`, `pricePaid`) VALUES
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
  `userId` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `passwordHash` char(40) NOT NULL,
  `type` enum('NEEDSHELP','ENTREPRENEUR') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `userName`, `passwordHash`, `type`) VALUES
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
  ADD PRIMARY KEY (`articleId`),
  ADD UNIQUE KEY `caption_UNIQUE` (`caption`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `article_shoppinglist`
--
ALTER TABLE `article_shoppinglist`
  ADD PRIMARY KEY (`articleShoppingListId`),
  ADD UNIQUE KEY `orderId_bookId_UNIQUE` (`shoppingListId`,`articleId`),
  ADD KEY `shoppingListId` (`shoppingListId`),
  ADD KEY `articleId` (`articleId`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryId`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`logId`);

--
-- Indexes for table `shoppinglist`
--
ALTER TABLE `shoppinglist`
  ADD PRIMARY KEY (`shoppingListId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `entrepreneurUserId` (`entrepreneurUserId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- Constraints for dumped tables
--

ALTER TABLE `article`
  MODIFY `articleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `article_shoppinglist`
  MODIFY `articleShoppingListId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `category` 
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `log` 
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
ALTER TABLE `shoppinglist` 
  MODIFY `shoppingListId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
ALTER TABLE `user` 
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `article_shoppinglist`
--
ALTER TABLE `article_shoppinglist`
  ADD CONSTRAINT `orderedBooks_ibfk_1` FOREIGN KEY (`shoppingListId`) REFERENCES `shoppinglist` (`shoppingListId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderedbooks_ibfk_2` FOREIGN KEY (`articleId`) REFERENCES `article` (`articleId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shoppinglist`
--
ALTER TABLE `shoppinglist`
  ADD CONSTRAINT `fk_order_user1` FOREIGN KEY (`entrepreneurUserId`) REFERENCES `user` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
