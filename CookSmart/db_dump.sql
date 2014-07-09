-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 50.63.225.171
-- Generation Time: Dec 13, 2012 at 03:30 PM
-- Server version: 5.0.92
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `cooksmart`
--
CREATE DATABASE IF NOT EXISTS cooksmart;

USE cooksmart;

-- --------------------------------------------------------

--
-- Table structure for table `appliances`
--

CREATE TABLE IF NOT EXISTS `appliances` (
  `appliance_id` int(11) NOT NULL auto_increment,
  `appliance_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`appliance_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appliances`
--

INSERT INTO `appliances` VALUES(1, 'appliance 1');
INSERT INTO `appliances` VALUES(2, 'appliance 2');
INSERT INTO `appliances` VALUES(3, 'appliance 3');
INSERT INTO `appliances` VALUES(4, 'appliance 4');
INSERT INTO `appliances` VALUES(5, 'appliance 5');
INSERT INTO `appliances` VALUES(6, 'appliance 6');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL auto_increment,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_time` datetime NOT NULL,
  PRIMARY KEY  (`comment_id`),
  KEY `recipe_id` (`recipe_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` VALUES(1, 1, 2, 'test', '2012-12-04 21:11:26');
INSERT INTO `comments` VALUES(2, 1, 2, 'hey i\\''m a comment', '2012-12-04 21:14:05');
INSERT INTO `comments` VALUES(5, 1, 2, 'hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment hey\r\ni\\''m a really long annoying comment ', '2012-12-04 21:30:26');
INSERT INTO `comments` VALUES(6, 8, 1, 'this doesn\\''t look like sugar\r\ni think the picture is lying', '2012-12-05 11:47:36');
INSERT INTO `comments` VALUES(7, 1, 2, 'testttt', '2012-12-05 14:00:14');
INSERT INTO `comments` VALUES(8, 9, 2, 'test', '2012-12-05 18:48:09');
INSERT INTO `comments` VALUES(9, 9, 12, 'shit pickle', '2012-12-05 20:00:45');
INSERT INTO `comments` VALUES(10, 8, 12, 'what is this i don\\''t even', '2012-12-05 20:04:03');
INSERT INTO `comments` VALUES(11, 2, 1, 'who would eat this', '2012-12-07 13:33:02');
INSERT INTO `comments` VALUES(12, 2, 1, 'seriously', '2012-12-07 13:33:15');
INSERT INTO `comments` VALUES(13, 5, 1, 'wow', '2012-12-10 05:49:45');
INSERT INTO `comments` VALUES(14, 8, 1, 'i didn\\''t even realize how misleading the name \\"Public Sugar\\" was until a few days later WHOOPS', '2012-12-11 14:48:19');
INSERT INTO `comments` VALUES(15, 8, 1, 'test', '2012-12-12 12:05:53');
INSERT INTO `comments` VALUES(16, 17, 1, 'test', '2012-12-12 12:12:21');
INSERT INTO `comments` VALUES(17, 9, 20, 'Its really good', '2012-12-12 12:57:07');
INSERT INTO `comments` VALUES(18, 22, 20, 'Its really good', '2012-12-12 14:19:32');
INSERT INTO `comments` VALUES(19, 24, 11, 'testtest', '2012-12-12 15:36:56');
INSERT INTO `comments` VALUES(20, 26, 2, 'this is awesome', '2012-12-12 18:51:16');
INSERT INTO `comments` VALUES(21, 26, 2, 'alert(\\''boo\\'');  break stuff', '2012-12-12 18:52:14');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `favorite_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  PRIMARY KEY  (`favorite_id`),
  KEY `user_id` (`user_id`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` VALUES(38, 1, 1);
INSERT INTO `favorites` VALUES(37, 1, 2);
INSERT INTO `favorites` VALUES(3, 1, 3);
INSERT INTO `favorites` VALUES(39, 20, 19);
INSERT INTO `favorites` VALUES(40, 2, 26);
INSERT INTO `favorites` VALUES(36, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `friendship_id` int(11) NOT NULL auto_increment,
  `user_id1` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=requested, 2=accepted, 3=rejected, 4=removed',
  PRIMARY KEY  (`friendship_id`),
  KEY `user_id1` (`user_id1`),
  KEY `user_id2` (`user_id2`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` VALUES(1, 2, 4, 2);
INSERT INTO `friends` VALUES(15, 2, 1, 2);
INSERT INTO `friends` VALUES(4, 5, 2, 2);
INSERT INTO `friends` VALUES(6, 1, 10, 2);
INSERT INTO `friends` VALUES(7, 6, 1, 2);
INSERT INTO `friends` VALUES(8, 7, 1, 2);
INSERT INTO `friends` VALUES(9, 8, 1, 2);
INSERT INTO `friends` VALUES(10, 9, 1, 2);
INSERT INTO `friends` VALUES(19, 2, 10, 1);
INSERT INTO `friends` VALUES(20, 11, 2, 2);
INSERT INTO `friends` VALUES(17, 1, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE IF NOT EXISTS `ingredients` (
  `ingredient_id` int(11) NOT NULL auto_increment,
  `ingredient_name` varchar(255) NOT NULL,
  `is_veg` tinyint(1) NOT NULL COMMENT '1=veg; 0=not',
  `ingredient_units` varchar(255) NOT NULL,
  PRIMARY KEY  (`ingredient_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` VALUES(1, 'apples', 1, 'apples');
INSERT INTO `ingredients` VALUES(2, 'eggs', 1, 'eggs');
INSERT INTO `ingredients` VALUES(3, 'vinegar', 1, 'teaspoons');
INSERT INTO `ingredients` VALUES(4, 'sugar', 1, 'tablespoons');
INSERT INTO `ingredients` VALUES(5, 'bacon', 0, 'lbs');
INSERT INTO `ingredients` VALUES(7, 'potatoes', 1, 'potatoes');
INSERT INTO `ingredients` VALUES(8, 'feta cheese', 1, 'ounces');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_units`
--

CREATE TABLE IF NOT EXISTS `ingredient_units` (
  `iu_id` int(11) NOT NULL auto_increment,
  `ingredient_id` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`iu_id`),
  KEY `ingredient_id` (`ingredient_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ingredient_units`
--

INSERT INTO `ingredient_units` VALUES(1, 1, 'apples');
INSERT INTO `ingredient_units` VALUES(2, 1, 'bushels');
INSERT INTO `ingredient_units` VALUES(3, 2, 'eggs');
INSERT INTO `ingredient_units` VALUES(4, 3, 'teaspoons');
INSERT INTO `ingredient_units` VALUES(5, 3, 'floz');
INSERT INTO `ingredient_units` VALUES(6, 4, 'tablespoons');
INSERT INTO `ingredient_units` VALUES(7, 4, 'cups');
INSERT INTO `ingredient_units` VALUES(8, 4, 'kilograms');
INSERT INTO `ingredient_units` VALUES(9, 5, 'lbs');
INSERT INTO `ingredient_units` VALUES(10, 5, 'grams');
INSERT INTO `ingredient_units` VALUES(11, 7, 'potatoes');
INSERT INTO `ingredient_units` VALUES(12, 7, 'lbs');
INSERT INTO `ingredient_units` VALUES(13, 7, 'grams');
INSERT INTO `ingredient_units` VALUES(14, 8, 'ounces');
INSERT INTO `ingredient_units` VALUES(15, 8, 'lbs');
INSERT INTO `ingredient_units` VALUES(16, 8, 'units');
INSERT INTO `ingredient_units` VALUES(17, 8, 'feta cheeses');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL auto_increment,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `message_time` datetime NOT NULL,
  PRIMARY KEY  (`message_id`),
  KEY `from_user_id` (`from_user_id`),
  KEY `to_user_id` (`to_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` VALUES(1, 1, 2, 'Try my recipe!\r\nIt is called \\"Two Dozen Eggs\\"\r\n\r\n', '2012-12-03 06:29:42');
INSERT INTO `messages` VALUES(2, 1, 2, 'test', '2012-12-03 12:23:56');
INSERT INTO `messages` VALUES(3, 8, 1, 'blah blah blah', '2012-12-04 18:06:53');
INSERT INTO `messages` VALUES(4, 8, 1, 'i can\\''t believe it\\''s not butter', '2012-12-04 18:07:09');
INSERT INTO `messages` VALUES(5, 8, 1, 'I literally cannot believe it.', '2012-12-04 18:07:31');
INSERT INTO `messages` VALUES(6, 1, 8, 'hey stop spamming my inbox', '2012-12-04 18:10:38');
INSERT INTO `messages` VALUES(7, 1, 8, 'idgaf its not butter', '2012-12-04 18:10:53');
INSERT INTO `messages` VALUES(8, 1, 11, 'this\r\nis\r\na\r\ntest\r\nwow!!!', '2012-12-04 18:56:30');
INSERT INTO `messages` VALUES(9, 1, 2, 'test test test', '2012-12-04 20:52:30');
INSERT INTO `messages` VALUES(10, 1, 10, 'nice sugars\r\nnot really', '2012-12-05 12:54:28');
INSERT INTO `messages` VALUES(11, 2, 1, 'test', '2012-12-12 12:52:09');
INSERT INTO `messages` VALUES(12, 1, 2, '', '2012-12-12 15:13:00');
INSERT INTO `messages` VALUES(13, 1, 2, 'it\\''s a test\\'' \r\nwowowow', '2012-12-12 15:13:52');
INSERT INTO `messages` VALUES(14, 1, 2, 'test', '2012-12-12 15:37:44');
INSERT INTO `messages` VALUES(15, 11, 2, 'alert(666)test', '2012-12-12 15:42:13');
INSERT INTO `messages` VALUES(16, 2, 10, 'test message', '2012-12-12 18:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `pantry`
--

CREATE TABLE IF NOT EXISTS `pantry` (
  `pantry_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_name` varchar(255) default NULL,
  PRIMARY KEY  (`pantry_id`),
  KEY `user_id` (`user_id`),
  KEY `ingredient_id` (`ingredient_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pantry`
--

INSERT INTO `pantry` VALUES(108, 20, 3, 1, 'teaspoons');
INSERT INTO `pantry` VALUES(107, 11, 8, 4, 'feta cheeses');
INSERT INTO `pantry` VALUES(106, 11, 2, 8, 'eggs');
INSERT INTO `pantry` VALUES(179, 2, 4, 50, 'tablespoons');
INSERT INTO `pantry` VALUES(178, 12, 7, 5, 'potatoes');
INSERT INTO `pantry` VALUES(159, 1, 3, 8, 'teaspoons');
INSERT INTO `pantry` VALUES(158, 1, 2, 9, 'eggs');
INSERT INTO `pantry` VALUES(176, 12, 2, 3, 'eggs');
INSERT INTO `pantry` VALUES(160, 1, 8, 2, 'ounces');
INSERT INTO `pantry` VALUES(157, 1, 4, 8, 'tablespoons');
INSERT INTO `pantry` VALUES(156, 1, 5, 2, 'lbs');
INSERT INTO `pantry` VALUES(155, 1, 7, 2, 'potatoes');
INSERT INTO `pantry` VALUES(177, 12, 8, 3, 'ounces');

-- --------------------------------------------------------

--
-- Table structure for table `pantry_appliances`
--

CREATE TABLE IF NOT EXISTS `pantry_appliances` (
  `pa_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `appliance_id` int(11) NOT NULL,
  PRIMARY KEY  (`pa_id`),
  KEY `user_id` (`user_id`),
  KEY `appliance_id` (`appliance_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pantry_appliances`
--

INSERT INTO `pantry_appliances` VALUES(54, 1, 6);
INSERT INTO `pantry_appliances` VALUES(34, 11, 4);
INSERT INTO `pantry_appliances` VALUES(36, 20, 2);
INSERT INTO `pantry_appliances` VALUES(35, 11, 5);
INSERT INTO `pantry_appliances` VALUES(53, 1, 5);
INSERT INTO `pantry_appliances` VALUES(52, 1, 2);
INSERT INTO `pantry_appliances` VALUES(51, 1, 3);
INSERT INTO `pantry_appliances` VALUES(50, 1, 4);
INSERT INTO `pantry_appliances` VALUES(49, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `rating_id` int(11) NOT NULL auto_increment,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY  (`rating_id`),
  UNIQUE KEY `UNIQUE` (`recipe_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` VALUES(14, 1, 2, 4);
INSERT INTO `ratings` VALUES(15, 1, 1, 4);
INSERT INTO `ratings` VALUES(16, 9, 2, 3);
INSERT INTO `ratings` VALUES(17, 9, 12, 5);
INSERT INTO `ratings` VALUES(18, 2, 1, 5);
INSERT INTO `ratings` VALUES(19, 5, 1, 4);
INSERT INTO `ratings` VALUES(20, 19, 20, 1);
INSERT INTO `ratings` VALUES(21, 9, 20, 5);
INSERT INTO `ratings` VALUES(22, 22, 20, 5);
INSERT INTO `ratings` VALUES(23, 26, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE IF NOT EXISTS `recipes` (
  `recipe_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `recipe_name` varchar(255) NOT NULL,
  `prep_time` int(11) NOT NULL,
  `is_veg` tinyint(1) NOT NULL,
  `instructions_text` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `privacy` int(11) NOT NULL COMMENT '1=public, 2=private, 3=friends only',
  `creation_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  `comments_allowed` tinyint(1) NOT NULL,
  PRIMARY KEY  (`recipe_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` VALUES(1, 1, 'Apple Pie', 42, 1, '1. Mash delicious apples.<br>\r\n2. Fill pie crust with apples.<br>\r\n3. Put into the oven.', 'http://static.flickr.com/99/303982625_da069e81da.jpg', 3, '2012-12-01 11:27:39', '2012-12-01 11:27:39', 1);
INSERT INTO `recipes` VALUES(2, 1, 'Bacon With Vinegar', 10, 0, '1. Put the bacon on a plate.<br />\r\n2. Pour the vinegar on the bacon.<br />\r\n3. Stare at it for as long as you can without laughing.<br />\r\n4. Wonder why your life is so terrible.<br />\r\n5. And it\\''s done!', 'http://www.ctbites.com/storage/greasy-bacon-590-1282238110.jpeg', 1, '2012-12-01 11:47:20', '2012-12-01 11:47:20', 1);
INSERT INTO `recipes` VALUES(3, 1, 'Two Dozen Eggs', 3, 0, 'It\\''s just two dozen eggs. There is nothing special about this \\"recipe\\".<br /><br /><br />Delicious.', 'http://thumbs.dreamstime.com/thumblarge_585/1298385127nqa8gE.jpg', 3, '2012-12-01 11:49:59', '2012-12-01 11:49:59', 1);
INSERT INTO `recipes` VALUES(4, 11, 'Twenty Teaspoons of Vinegar', 10, 1, 'Drink all of the vinegar.<br>\r\nDelicious.', 'http://cdn.phamfatale.com/album/red-and-white-wine-vinegar.jpg', 1, '2012-12-04 18:53:54', '2012-12-04 18:53:54', 1);
INSERT INTO `recipes` VALUES(5, 1, 'Delicious Cookies', 25, 1, 'Get some cookie dough.<br>\r\nPut into oven at 375 degrees F<br>\r\nRemove from oven after 20 minutes.', 'http://foodporndaily.com/pictures/soft-chewy-classic-chocolate-chip-cookies.jpg', 3, '2012-12-04 21:04:12', '2012-12-04 21:04:12', 1);
INSERT INTO `recipes` VALUES(6, 10, 'Private Sugar', 10, 1, 'It''s private sugar. \r\n<br>Best keep this stuff to yourself.', 'http://www.usafutures.com/sugar_trading_broker.jpg', 2, '2012-12-04 22:08:46', '2012-12-04 22:08:46', 1);
INSERT INTO `recipes` VALUES(7, 10, 'Friend Sugar', 10, 1, 'sugar.<br />\r\ntesting recipe privacy permissions', 'http://www.usafutures.com/sugar_trading_broker.jpg', 3, '2012-12-04 22:09:26', '2012-12-04 22:09:26', 1);
INSERT INTO `recipes` VALUES(26, 2, 'Candy Apple\\\\\\''s', 25, 1, '<script language=\\\\\\"javascript\\\\\\"><br />\\r\\nalert(\\\\\\"fail!\\\\\\");<br />\\r\\n</script><br />\\r\\n<br />\\r\\n1. Buy more ingredients<br />\\r\\n2. Soak apples in sugar<br />\\r\\n', 'http://4.bp.blogspot.com/-5o5pkuNjSb0/UJQ9d69mbCI/AAAAAAAAAls/WZNkaoyDmbI/s640/rain.jpg', 3, '2012-12-12 18:49:02', '2012-12-12 18:49:02', 1);
INSERT INTO `recipes` VALUES(8, 10, 'Public Sugar', 54, 0, 'It''s public sugar. \r\n<br>You can do whatever you want with it! <br>Share it with everyone!', 'http://www.usafutures.com/sugar_trading_broker.jpg', 1, '2012-12-04 22:09:56', '2012-12-04 22:09:56', 1);
INSERT INTO `recipes` VALUES(9, 2, 'Potatoes with Feta Cheese', 25, 1, '1. Put potatoes on pan<br />\r\n2. Sprinkle feta on top', 'http://foodporndaily.com/pictures/harissa-potatoes-with-preserved-lemon-feta-dill.jpg', 1, '2012-12-05 16:13:15', '2012-12-05 16:13:15', 1);
INSERT INTO `recipes` VALUES(27, 1, 'Bob\\''s Brownies', 34, 0, 'Bob\\''s brownies are bacon brownies :)', 'http://i.imgur.com/bStSJ.gif', 1, '2012-12-13 15:08:32', '2012-12-13 15:08:32', 0);
INSERT INTO `recipes` VALUES(28, 1, 'alert(2) Potatoes', 877, 1, 'alert(2) that\\''s a lot of potatoes', 'alert(2) http://i.imgur.com/bStSJ.gif', 1, '2012-12-13 15:14:38', '2012-12-13 15:14:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_appliances`
--

CREATE TABLE IF NOT EXISTS `recipe_appliances` (
  `ra_id` int(11) NOT NULL auto_increment,
  `recipe_id` int(11) NOT NULL,
  `appliance_id` int(11) NOT NULL,
  PRIMARY KEY  (`ra_id`),
  KEY `recipe_id` (`recipe_id`),
  KEY `appliance_id` (`appliance_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recipe_appliances`
--

INSERT INTO `recipe_appliances` VALUES(1, 3, 5);
INSERT INTO `recipe_appliances` VALUES(2, 3, 2);
INSERT INTO `recipe_appliances` VALUES(3, 23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredients`
--

CREATE TABLE IF NOT EXISTS `recipe_ingredients` (
  `ri_id` int(11) NOT NULL auto_increment,
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`ri_id`),
  KEY `recipe_id` (`recipe_id`),
  KEY `ingredient_id` (`ingredient_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` VALUES(1, 2, 5, 40, 'lbs');
INSERT INTO `recipe_ingredients` VALUES(2, 2, 3, 5, 'teaspoons');
INSERT INTO `recipe_ingredients` VALUES(3, 3, 2, 24, 'eggs');
INSERT INTO `recipe_ingredients` VALUES(4, 4, 3, 20, 'teaspoons');
INSERT INTO `recipe_ingredients` VALUES(5, 4, 5, 1, 'lbs');
INSERT INTO `recipe_ingredients` VALUES(6, 5, 3, 9999999, 'teaspoons');
INSERT INTO `recipe_ingredients` VALUES(7, 6, 4, 24, 'tablespoons');
INSERT INTO `recipe_ingredients` VALUES(8, 7, 4, 12, 'tablespoons');
INSERT INTO `recipe_ingredients` VALUES(9, 8, 4, 25, 'tablespoons');
INSERT INTO `recipe_ingredients` VALUES(10, 9, 7, 1, 'potatoes');
INSERT INTO `recipe_ingredients` VALUES(11, 9, 8, 3, 'ounces');
INSERT INTO `recipe_ingredients` VALUES(12, 1, 1, 9, 'apples');
INSERT INTO `recipe_ingredients` VALUES(17, 14, 4, 2, 'kilograms');
INSERT INTO `recipe_ingredients` VALUES(16, 14, 8, 2, 'feta cheeses');
INSERT INTO `recipe_ingredients` VALUES(18, 14, 5, 2, 'grams');
INSERT INTO `recipe_ingredients` VALUES(19, 15, 7, 3, 'potatoes');
INSERT INTO `recipe_ingredients` VALUES(20, 16, 7, 4, 'potatoes');
INSERT INTO `recipe_ingredients` VALUES(21, 16, 2, 4, 'eggs');
INSERT INTO `recipe_ingredients` VALUES(22, 16, 8, 4, 'ounces');
INSERT INTO `recipe_ingredients` VALUES(23, 17, 7, 5, 'potatoes');
INSERT INTO `recipe_ingredients` VALUES(24, 17, 1, 4, 'apples');
INSERT INTO `recipe_ingredients` VALUES(25, 17, 5, 6, 'grams');
INSERT INTO `recipe_ingredients` VALUES(26, 19, 1, 2, 'bushels');
INSERT INTO `recipe_ingredients` VALUES(27, 20, 4, 34, 'kilograms');
INSERT INTO `recipe_ingredients` VALUES(28, 21, 4, 2, 'tablespoons');
INSERT INTO `recipe_ingredients` VALUES(29, 22, 4, 2, 'tablespoons');
INSERT INTO `recipe_ingredients` VALUES(30, 23, 5, 5, 'lbs');
INSERT INTO `recipe_ingredients` VALUES(31, 24, 2, 5, 'eggs');
INSERT INTO `recipe_ingredients` VALUES(32, 25, 4, 5, 'tablespoons');
INSERT INTO `recipe_ingredients` VALUES(33, 25, 7, 5, 'potatoes');
INSERT INTO `recipe_ingredients` VALUES(34, 26, 1, 2, 'bushels');
INSERT INTO `recipe_ingredients` VALUES(35, 26, 4, 2, 'kilograms');
INSERT INTO `recipe_ingredients` VALUES(36, 26, 3, 2, 'floz');
INSERT INTO `recipe_ingredients` VALUES(37, 27, 5, 55, 'lbs');
INSERT INTO `recipe_ingredients` VALUES(38, 28, 7, 65, 'potatoes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creation_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  `username` varchar(15) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, 'Jesse', 'Pirnat', 'jpirnat@stevens.edu', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-11-29 20:53:56', '2012-11-29 20:53:56', 'jpirnat');
INSERT INTO `users` VALUES(2, 'Jared', 'Binder', 'jbinder919@gmail.com', '098f6bcd4621d373cade4e832627b4f6', '2012-11-29 21:02:59', '2012-11-29 21:02:59', 'jbinder');
INSERT INTO `users` VALUES(4, 'Steven', 'Gabarro', 'bewchy@stevens.edu', 'encryptedpassword', '2012-11-30 02:10:53', '2012-11-30 02:10:53', 'user4');
INSERT INTO `users` VALUES(5, 'Mark', 'Zuckerberg', 'fail@facebook.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-11-30 02:12:29', '2012-11-30 02:12:29', 'user5');
INSERT INTO `users` VALUES(6, 'Hal', 'Raveche', 'lawl@stevens.edu', 'yayfreemoney', '2012-11-30 02:13:10', '2012-11-30 02:13:10', 'user6');
INSERT INTO `users` VALUES(7, 'test', 'test', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', '2012-11-30 00:20:03', '2012-11-30 00:20:03', 'test');
INSERT INTO `users` VALUES(8, 'test2', 'test2', 'e@mail.com', 'password', '2012-12-04 18:05:59', '2012-12-04 18:05:59', 'user8');
INSERT INTO `users` VALUES(9, 'Ben', 'O\\''Harris', 'benoharris@igiveup.com', '6b446584b34bf5108ac0d1c1bba0d821', '2012-12-04 18:20:48', '2012-12-04 18:20:48', 'user9');
INSERT INTO `users` VALUES(10, 'Test3', 'TestThree', 'test@three.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-12-04 18:35:27', '2012-12-04 18:35:27', 'testnumber3');
INSERT INTO `users` VALUES(11, 'Ben', 'Baker', 'thedude@theemail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-12-04 18:52:01', '2012-12-04 18:52:01', 'thedude');
INSERT INTO `users` VALUES(12, 'Corbin', 'Schwartz', 'cschwart@stevens.edu', '098f6bcd4621d373cade4e832627b4f6', '2012-12-05 19:06:26', '2012-12-05 19:06:26', 'cschwart');
INSERT INTO `users` VALUES(20, 'Hemal', 'Patadia', 'patadia.hemal@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2012-12-12 12:52:32', '2012-12-12 12:52:32', 'Hemal');
INSERT INTO `users` VALUES(19, 'asdf', 'asdf', 'asdf@asdf.com', '912ec803b2ce49e4a541068d495ab570', '2012-12-11 16:01:17', '2012-12-11 16:01:17', 'asdf');
INSERT INTO `users` VALUES(21, 'lame', 'name', 'lame@name.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-12-12 15:17:35', '2012-12-12 15:17:35', 'lamename');
INSERT INTO `users` VALUES(25, 'test\\\\\\''(;', 'hello', 'a@javascript.net', '1a1dc91c907325c69271ddf0c944bc72', '2012-12-12 16:54:43', '2012-12-12 16:54:43', '15325');
