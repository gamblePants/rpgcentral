-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 27, 2019 at 04:00 AM
-- Server version: 5.7.21
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpgcentral`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

DROP TABLE IF EXISTS `orderitems`;
CREATE TABLE IF NOT EXISTS `orderitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_qty` smallint(6) DEFAULT NULL,
  `item_price` float(6,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `order_id`, `item_id`, `item_qty`, `item_price`) VALUES
(9, 8, 6, 1, 7.00),
(8, 8, 10, 1, 15.00),
(7, 8, 9, 1, 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `timeAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `bfirstname` varchar(20) DEFAULT NULL,
  `blastname` varchar(30) DEFAULT NULL,
  `bstreet` varchar(40) DEFAULT NULL,
  `bsuburb` varchar(40) DEFAULT NULL,
  `baus_state` varchar(30) DEFAULT NULL,
  `bpostcode` varchar(4) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `bphone` varchar(20) DEFAULT NULL,
  `total` float(6,2) DEFAULT NULL,
  `creditcard` varchar(255) NOT NULL,
  `expiry` char(4) DEFAULT NULL,
  `cvv` char(3) DEFAULT NULL,
  `status` enum('pending','complete') DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `street` varchar(40) DEFAULT NULL,
  `suburb` varchar(40) DEFAULT NULL,
  `aus_state` varchar(30) DEFAULT NULL,
  `postcode` varchar(4) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `invoiceno` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `timeAdded`, `bfirstname`, `blastname`, `bstreet`, `bsuburb`, `baus_state`, `bpostcode`, `email`, `bphone`, `total`, `creditcard`, `expiry`, `cvv`, `status`, `firstname`, `lastname`, `street`, `suburb`, `aus_state`, `postcode`, `phone`, `invoiceno`) VALUES
(8, 1, '2019-11-27 14:57:39', 'test', 'test', 'test', 'test', 'NSW', '1234', 'test@gmail.com', 'asdfd', 47.00, '$2y$10$OC8UX.TnvCK1sw0ARp.2z.fgSlTgbfhd9dfWLyEEOD5Hfo33keWey', '1234', '123', 'complete', '', '', '', '', '', '', '', 'date_plus_num');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) NOT NULL,
  `post` text,
  `timeAdded` datetime DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `thread_id`, `post`, `timeAdded`, `username`) VALUES
(1, 1, 'We\'re putting on a regular Call of Cthulhu night soon (starting 11th Dec). Game will run from 7 to 10pm Wednesday nights (or maybe fortnightly depending on how it goes). We have a maximum of 7 spots for players, with 2 already filled. If you\'d like to join please post here.', '2019-11-15 13:35:05', 'Koan'),
(2, 2, 'Christmas party! We won\'t be holding any big RPGs this night. Party games will be out (cards against humanity, jenga, codenames, settlers of catan). BYO or buy from the bar. Free Christmas snacks!', '2019-11-15 13:39:16', 'Koan'),
(3, 3, 'I have some fancy dice I don\'t want anymore? Can I bring them by your shop to sell them?', '2019-11-15 13:41:42', 'Cam'),
(4, 3, 'Sure thing :) We\'re happy for people to sell their 2nd hand rpg stuff at our shop. There\'s no fee. All we require is an image (.jpg, .png, .bmp) of the dice, preferably under 600kb, then we will post that image to the shop.', '2019-11-15 13:45:21', 'Koan'),
(5, 4, 'By popular demand we\'re selling RPG snackfood with the games now :)', '2019-11-15 13:46:44', 'Koan'),
(6, 4, 'Yum!', '2019-11-15 13:47:04', 'Cam'),
(7, 4, 'I have diabetes', '2019-11-15 13:48:15', 'Angus'),
(8, 5, 'Hi guys, I have a group of myself and 4 players and we\'re looking for somewhere to play a weekly game Monday nights. Do you have a spot somewhere in the warehouse for us? Is there a fee? ', '2019-11-15 13:51:51', 'Angus'),
(9, 5, 'Generally Monday nights are out. That\'s our quiet time :) But we do have some rooms that could be used on other nights. Thursday is a good evening for us if that works. No fee involved, all we ask is that you clean up after yourselves. ', '2019-11-15 13:54:57', 'Koan'),
(10, 1, 'Count me in! I might also have 2 friends who will join. Will confirm.', '2019-11-15 13:56:06', 'Cam'),
(11, 1, 'okey dokey', '2019-11-15 13:56:27', 'Koan'),
(12, 6, 'Hey guys, i think i left my beer cooler behind last night at D&D. it\'s a Chubb soft cooler that can hold a 6-pack. had a great game by the way - thanks :)', '2019-11-17 15:33:52', 'Angus'),
(13, 1, 'Alright we have 5 confirmed players - with 2 spots left for the Call of Cthulhu game :)', '2019-11-17 15:35:49', 'Koan'),
(14, 1, 'First 3 games will be Wednesdays: 11th of Dec, 18th of Dec and 8th of Jan.', '2019-11-17 15:44:25', 'Koan'),
(15, 6, 'Had a quick look around but couldn\'t find one. I\'ll ask the others later if they\'ve seen it.', '2019-11-17 15:50:05', 'Koan'),
(16, 7, 'I remember really enjoying this game back in the 90s. A dark dystopian setting with great characters to choose from and descriptive combat rules. Does anyone still play this? Keen to have a go.', '2019-11-17 15:59:21', 'Angus'),
(17, 4, 'Snakes? Gotta get some snakes', '2019-11-17 16:01:12', 'Cam'),
(18, 8, 'So i was wondering what some game masters takes are on generating random encounters. Do you like to pre-roll a bunch of encounters and NPCs or rather roll them up on the fly when the time comes. How \"random\"is your encounter?', '2019-11-25 19:38:04', 'Koan'),
(19, 9, 'Hey guys, there are some giant foam blocks that are made to look like sandstone blocks from a castle up the road. they are being given away for free, fancy some new decorations?', '2019-11-25 19:41:51', 'Cam'),
(20, 10, 'Hey guys, most of you have probably read the guidelines on our website. if anyone thinks they can be improved please give us some suggestions. most of them are about posting on the forum but we could include some others about behaviour around the warehouse. ', '2019-11-25 19:47:38', 'Koan'),
(21, 4, 'Softdrinks, chips, chocolate bars, peanuts and snakes for cam ;)', '2019-11-26 22:09:19', 'Koan'),
(22, 4, 'yessss! thank you ', '2019-11-26 22:10:24', 'Cam'),
(23, 4, 'you\'re welcome', '2019-11-27 14:51:57', 'Koan'),
(24, 11, 'Anyone like using books as story ideas for games?', '2019-11-27 14:52:34', 'Koan');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE IF NOT EXISTS `shoppingcart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(32) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_qty` smallint(6) DEFAULT NULL,
  `timeAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shop_categories`
--

DROP TABLE IF EXISTS `shop_categories`;
CREATE TABLE IF NOT EXISTS `shop_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_categories`
--

INSERT INTO `shop_categories` (`id`, `title`, `image`) VALUES
(1, 'RPG books', 'books.jpg'),
(2, 'Dice', 'dice.jpg'),
(3, 'Miniatures', 'miniatures.jpg'),
(4, 'Comics', 'comics.jpg'),
(5, 'Board games', 'boardgames.jpg'),
(6, 'Card games', 'cardgames.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shop_items`
--

DROP TABLE IF EXISTS `shop_items`;
CREATE TABLE IF NOT EXISTS `shop_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `title` varchar(40) DEFAULT NULL,
  `price` float(6,2) DEFAULT NULL,
  `detail` text,
  `image` varchar(50) DEFAULT NULL,
  `quantity` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_items`
--

INSERT INTO `shop_items` (`id`, `cat_id`, `title`, `price`, `detail`, `image`, `quantity`) VALUES
(1, 1, 'Vampire The Masquerade 1998', 30.00, '(Revised Edition). This is the 3rd edition \r\n									of Vampire: The Masquerade by White Wolf Publishing. It is the core rule book and \r\n									all you need to begin playing. Hard Cover with 294 pages. 2nd-hand, good condition.', 'vampire_revised.jpg', 1),
(2, 1, 'Call of Cthulhu 6th Edition 2005', 30.00, '(Revised Edition). This is the 6th edition\r\n									of Call of Cthulhu by Chaosium Inc. Paperback with 320 pages. It is the core rule book and \r\n									all you need to begin playing. 2nd-hand, good condition.', 'cthulhu_6thedition.jpg', 1),
(3, 1, 'The Sassoon Files 2019', 30.00, 'A sourcebook for the Call of Cthulhu and Gumshoe Role-playing games. \r\n									Published by the Sons of Singularity. 2 new copies generously donated from our friends overseas.', 'sassoon.jpg', 2),
(4, 3, '6 Rifts adventurers', 10.00, '2nd-hand unpainted miniatures for the Rifts RPG by Palladium.\r\n									2 psi-stalkers, 2 ley-line walkers, 1 techno-wizard and 1 scout.', 'miniatures.jpg', 1),
(5, 3, '4 Rifts skelebots', 5.00, '2nd-hand unpainted miniatures for the Rifts RPG by Palladium. 4 skelebots with arms detached', 'skelebots.jpg', 2),
(6, 4, 'Stray Bullets(S&R) 37', 7.00, 'New condition. Stray Bullets (Sunshine & Roses) Number 37. August 2018. By El Capitan Books', 'sunshine37.jpg', 3),
(7, 4, 'Lodger 4', 7.00, 'New condition. Lodger Number 4. By Black Crown Publishing (another work by David Lapham). January 2019.', 'lodger4.jpg', 3),
(8, 4, 'Lodger 5', 7.00, 'New condition. Lodger Number 5. By Black Crown Publishing (another work by David Lapham). January 2019.', 'lodger5.jpg', 4),
(9, 5, 'Wooden chess Set', 15.00, '2nd-hand wooden chess set. The board is hand made. All pieces there.', 'chessset.jpg', 1),
(10, 5, 'Jenga', 15.00, '2nd-hand with original box. Jenga (1988 by Milton Bradley). All pieces there.', 'jenga.jpg', 1),
(11, 6, 'Scrabble cards', 10.00, 'Scrabble Cards. 1999 by Spears and Sons Ltd. 2nd-hand with rules. \r\n									A portable version of the classic Scrabble game. 92 Letter cards and 18 Letter cards. All cards there.', 'scrabblecards.jpg', 1),
(12, 6, 'Regular playing cards', 5.00, 'Regular deck of playing cards (2nd-hand). Cards are made of clear plastic and have a hard plastic protective case. All cards there.', 'clearcards.jpg', 1),
(13, 6, 'Regular playing cards', 5.00, 'Regular deck of playing cards (2nd-hand). Each card features a different dog on the face-side. All cards there.', 'dogcards.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

DROP TABLE IF EXISTS `threads`;
CREATE TABLE IF NOT EXISTS `threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `timeAdded` datetime DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `title`, `timeAdded`, `username`, `topic_id`) VALUES
(1, 'Call of Cthulhu - Wednesday Nights', '2019-11-15 13:35:05', 'Koan', 2),
(2, 'Christmas Party 20th Dec', '2019-11-15 13:39:16', 'Koan', 2),
(3, 'Dice for sale?', '2019-11-15 13:41:42', 'Cam', 1),
(4, 'Announcing snacks for sale!', '2019-11-15 13:46:44', 'Koan', 1),
(5, 'Can I host a game on Monday night?', '2019-11-15 13:51:51', 'Angus', 2),
(6, 'Left my beer cooler behind', '2019-11-17 15:33:52', 'Angus', 1),
(7, 'Anyone play SLA Industries?', '2019-11-17 15:59:21', 'Angus', 11),
(8, 'Random encounters', '2019-11-25 19:38:04', 'Koan', 1),
(9, 'Large foam blocks', '2019-11-25 19:41:51', 'Cam', 1),
(10, 'Guidelines suggestions', '2019-11-25 19:47:38', 'Koan', 1),
(11, 'Using books as stories', '2019-11-27 14:52:34', 'Koan', 5);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(35) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `title`, `description`) VALUES
(1, 'General Discussion', 'This section is for community discussions. Say hello, see who\'s online,\r\n								ask questions and offer gaming advice. Please don\'t post here if you\'re \r\n								asking about events or the game-mechanics of a particular RPG.'),
(2, 'RPGCentral Events', 'This section is reserved for discussion about all events (upcoming and past)\r\n								at our warehouse. To view times for all upcoming events, please go to our \r\n								<a href=\'events.html\'>events</a> page'),
(3, 'Other Events in NSW', 'This section is usually reserved for upcoming rpg conventions in NSW,\r\n								including but not limited to:  Sydcon & Eyecon in Glebe, Ettincon in Blackheath,\r\n								and Macquariecon at Macquarie University. Other NSW RPGs that are open to the public\r\n								should also be discussed here.'),
(4, 'Private NSW Games', 'This section is reserved for anyone looking to host their own role-playing games\r\n								or anyone looking to join a group (outside of RPG Central and inside NSW). Please\r\n								don\'t share personal details like home addresses or phone numbers in the forum, you\r\n								can pass these details out by private messaging.'),
(5, 'Story Ideas', 'We encourage RPGCentral users to share story ideas, campaign tips and character \r\n								ideas here. If they are for a specific role-playing game please use that particular\r\n								forum topic. Also try not to leak spoilers for upcoming games.'),
(6, 'Palladium RPGs', 'This section is reserved for discussion about all Palladium games such as\r\n								Rifts, TMNT & Other Strangeness, Heroes Unlimited and Nightspawn.'),
(7, 'D&D / Pathfinder', 'This section is reserved for discussion about D&D and Pathfinder games. For example\r\n								disucssions could be about game-mechanics, new rule ideas, story ideas, or new races or classes.'),
(8, 'Call of Cthulhu', 'This section is reserved for discussion about the Call of Cthulhu RPG. For example\r\n								disucssions could be about game-mechanics, new rule ideas, story ideas, or a new insanity table.'),
(9, 'Vampire / Werewolf', 'This section is reserved for discussion about Vampire, Werewolf, or other RPGs by Whitewolf. For example\r\n								disucssions could be about game-mechanics, new rule ideas, story ideas, or character creation.'),
(10, 'Star Wars', 'This section is reserved for discussion about the Star Wars RPG. For example\r\n								disucssions could be about game-mechanics, star-systems, story ideas, or new races'),
(11, 'Other RPGs', 'This section is reserved for discussion about any other RPGs not included in the other \r\n								forum topics. For example Cyberpunk, TOON, Nephilim, Fighting Fantasy, or any other RPGs.\r\n								You are also welcome to post here about boardgames.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `timeAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `timeAdded`) VALUES
(1, 'Koan', '$2y$10$av.suzdI4xHR0TH0gCXt0OVIYrXzZ1RvAUpU6Gka3nWNEceQiOaHm', 'snowdroid@yahoo.ca', '2019-11-15 13:28:26'),
(2, 'Cam', '$2y$10$5p.1NCEHl0nYDTWHmp00i.jsSDqYSdaaebEWkqdgkHNRaC2oolBOm', 'cam@hotmail.com', '2019-11-15 13:30:51'),
(3, 'Angus', '$2y$10$zEcggTz4Nvml4Wk5.YOTq.8ZUXu6o3QM6s82BHrw0KLu1jIea8lEC', 'angus@hotmail.com', '2019-11-15 13:47:48');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
