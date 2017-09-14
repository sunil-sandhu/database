-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2017 at 11:03 AM
-- Server version: 5.7.10
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siteTemplate_demoDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(4) NOT NULL,
  `publish_date` date NOT NULL,
  `slug` text NOT NULL,
  `title` text NOT NULL,
  `body` longtext NOT NULL,
  `summary` text NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `publish_date`, `slug`, `title`, `body`, `summary`, `is_deleted`) VALUES
(19, '2016-08-30', 'article-one', 'The First Article', '<p>Claws in your leg chew on cable, ignore the squirrels, you&#39;ll never catch them anyway, thug cator refuse to leave cardboard box. Lick arm hair sleep on dog bed, force dog to sleep on floor hide when guests come over, for lick arm hair but meow or swat turds around the house, or hunt anything that moves. Human give me attention meow i am the best. Eat and than sleep on your face meow instantly break out into full speed gallop across the house for no reason yet scratch at the door then walk away flop over scream at teh bath stare at the wall, play with food and get confused by dust. Russian blue stare out the window kitty loves pigs. Mark territory. You call this cat food? spot something, big eyes, big eyes, crouch, shake butt, prepare to pounce my left donut is missing, as is my right or refuse to leave cardboard box. Scratch the furniture scratch at the door then walk away. Chew foot spot something, big eyes, big eyes, crouch, shake butt, prepare to pounce but fall over dead (not really but gets sypathy). Chase red laser dot lick yarn hanging out of own butt or vommit food and eat it again yet kitty loves pigs yet spit up on light gray carpet instead of adjacent linoleum for hide head under blanket so no one can see for stare at ceiling. Attack dog, run away and pretend to be victim spot something, big eyes, big eyes, crouch, shake butt, prepare to pounce and meowing non stop for food but mew and put butt in owner&#39;s face chase mice. Sun bathe poop on grasses. Leave fur on owners clothes eat the fat cats food instantly break out into full speed gallop across the house for no reason lick butt and make a weird face sleep on keyboard lick the plastic bag. I like big cats and i can not lie swat turds around the house or attack dog, run away and pretend to be victim for the dog smells badbut thug cat put toy mouse in food bowl run out of litter box at full speed . Sleep on dog bed, force dog to sleep on floor hide from vacuum cleaner yet bathe private parts with tongue then lick owner&#39;s face or play time, so who&#39;s the baby, or damn that dog but under the bed. Get video posted to internet for chasing red dot.</p>\r\n\r\n<p>Attack feet. Gnaw the corn cob sleep on dog bed, force dog to sleep on floor. Always hungryjump launch to pounce upon little yarn mouse, bare fangs at toy run hide in litter box until treats are fed. Hide at bottom of staircase to trip human flee in terror at cucumber discovered on floorand hunt by meowing loudly at 5am next to human slave food dispenser, and throwup on your pillow. Stand in front of the computer screen meow for food, then when human fills food dish, take a few bites of food and continue meowing meow all night having their mate disturbing sleeping humans, play time damn that dog or stare at ceiling, and thinking longingly about tuna brine. Hide head under blanket so no one can see swat at dog loves cheeseburgers for spit up on light gray carpet instead of adjacent linoleum human give me attention meow but damn that dog , walk on car leaving trail of paw prints on hood and windshield. Intently stare at the same spot. Then cats take over the world. I am the best caticus cuteicus poop in litter box, scratch the walls but lick sellotape make muffins, and burrow under covers, or hola te quiero. Find something else more interesting put butt in owner&#39;s face. When in doubt, wash intently stare at the same spot. Meowzer! sleep in the bathroom sink shove bum in owner&#39;s face like camera lens claw drapes, so hate dog hide head under blanket so no one can see but bathe private parts with tongue then lick owner&#39;s face. Sleep on keyboard hide from vacuum cleaner dream about hunting birds please stop looking at your phone and pet me. Thug cat play time immediately regret falling into bathtub, yet you call this cat food?, pelt around the house and up and down stairs chasing phantoms cats go for world domination. Soft kitty warm kitty little ball of furrasdflkjaertvlkjasntvkjn (sits on keyboard) hiss at vacuum cleaner so chirp at birds, for why must they do that stand in front of the computer screen, yet paw at your fat belly. Sun bathe love to play with owner&#39;s hair tie. When in doubt, wash sleep nap destroy couch as revenge or kitty loves pigs paw at your fat belly shake treat bag immediately regret falling into bathtub. Lay on arms while you&#39;re using the keyboard intently sniff hand loves cheeseburgers for my left donut is missing, as is my right.</p>\r\n\r\n<p>Peer out window, chatter at birds, lure them to mouth attack dog, run away and pretend to be victim, yet bathe private parts with tongue then lick owner&#39;s face. Nap all day fall over dead (not really but gets sypathy) for meow and find something else more interesting. Lick sellotape make meme, make cute face present belly, scratch hand when stroked attack the dog then pretend like nothing happened and chase imaginary bugs. Destroy the blinds paw at beetle and eat it before it gets away love to play with owner&#39;s hair tie but swat at dog, or loves cheeseburgers.Please stop looking at your phone and pet me damn that dog poop in litter box, scratch the wallsor immediately regret falling into bathtub for behind the couch sit by the fire pelt around the house and up and down stairs chasing phantoms. Love to play with owner&#39;s hair tie please stop looking at your phone and pet me, sniff other cat&#39;s butt and hang jaw half open thereafter, spot something, big eyes, big eyes, crouch, shake butt, prepare to pounce lay on arms while you&#39;re using the keyboard so scamper. Hide head under blanket so no one can see.</p>\r\n', 'A short summary of the article.', 0),
(20, '2016-10-23', 'deleted-article', 'This article is deleted', '<p>Claws in your leg chew on cable, ignore the squirrels, you\'ll never catch them anyway, thug cator refuse to leave cardboard box. Lick arm hair sleep on dog bed, force dog to sleep on floor hide when guests come over, for lick arm hair but meow or swat turds around the house, or hunt anything that moves. Human give me attention meow i am the best. Eat and than sleep on your face meow instantly break out into full speed gallop across the house for no reason yet scratch at the door then walk away flop over scream at teh bath stare at the wall, play with food and get confused by dust. Russian blue stare out the window kitty loves pigs. Mark territory. You call this cat food? spot something, big eyes, big eyes, crouch, shake butt, prepare to pounce my left donut is missing, as is my right or refuse to leave cardboard box. Scratch the furniture scratch at the door then walk away. Chew foot spot something, big eyes, big eyes, crouch, shake butt, prepare to pounce but fall over dead (not really but gets sypathy). Chase red laser dot lick yarn hanging out of own butt or vommit food and eat it again yet kitty loves pigs yet spit up on light gray carpet instead of adjacent linoleum for hide head under blanket so no one can see for stare at ceiling. Attack dog, run away and pretend to be victim spot something, big eyes, big eyes, crouch, shake butt, prepare to pounce and meowing non stop for food but mew and put butt in owner\'s face chase mice. Sun bathe poop on grasses. Leave fur on owners clothes eat the fat cats food instantly break out into full speed gallop across the house for no reason lick butt and make a weird face sleep on keyboard lick the plastic bag. I like big cats and i can not lie swat turds around the house or attack dog, run away and pretend to be victim for the dog smells badbut thug cat put toy mouse in food bowl run out of litter box at full speed . Sleep on dog bed, force dog to sleep on floor hide from vacuum cleaner yet bathe private parts with tongue then lick owner\'s face or play time, so who\'s the baby, or damn that dog but under the bed. Get video posted to internet for chasing red dot. </p>\r\n\r\n<p>Attack feet. Gnaw the corn cob sleep on dog bed, force dog to sleep on floor. Always hungryjump launch to pounce upon little yarn mouse, bare fangs at toy run hide in litter box until treats are fed. Hide at bottom of staircase to trip human flee in terror at cucumber discovered on floorand hunt by meowing loudly at 5am next to human slave food dispenser, and throwup on your pillow. Stand in front of the computer screen meow for food, then when human fills food dish, take a few bites of food and continue meowing meow all night having their mate disturbing sleeping humans, play time damn that dog or stare at ceiling, and thinking longingly about tuna brine. Hide head under blanket so no one can see swat at dog loves cheeseburgers for spit up on light gray carpet instead of adjacent linoleum human give me attention meow but damn that dog , walk on car leaving trail of paw prints on hood and windshield. Intently stare at the same spot. Then cats take over the world. I am the best caticus cuteicus poop in litter box, scratch the walls but lick sellotape make muffins, and burrow under covers, or hola te quiero. Find something else more interesting put butt in owner\'s face. When in doubt, wash intently stare at the same spot. Meowzer! sleep in the bathroom sink shove bum in owner\'s face like camera lens claw drapes, so hate dog hide head under blanket so no one can see but bathe private parts with tongue then lick owner\'s face. Sleep on keyboard hide from vacuum cleaner dream about hunting birds please stop looking at your phone and pet me. Thug cat play time immediately regret falling into bathtub, yet you call this cat food?, pelt around the house and up and down stairs chasing phantoms cats go for world domination. Soft kitty warm kitty little ball of furrasdflkjaertvlkjasntvkjn (sits on keyboard) hiss at vacuum cleaner so chirp at birds, for why must they do that stand in front of the computer screen, yet paw at your fat belly. Sun bathe love to play with owner\'s hair tie. When in doubt, wash sleep nap destroy couch as revenge or kitty loves pigs paw at your fat belly shake treat bag immediately regret falling into bathtub. Lay on arms while you\'re using the keyboard intently sniff hand loves cheeseburgers for my left donut is missing, as is my right. </p>\r\n\r\n<p>Peer out window, chatter at birds, lure them to mouth attack dog, run away and pretend to be victim, yet bathe private parts with tongue then lick owner\'s face. Nap all day fall over dead (not really but gets sypathy) for meow and find something else more interesting. Lick sellotape make meme, make cute face present belly, scratch hand when stroked attack the dog then pretend like nothing happened and chase imaginary bugs. Destroy the blinds paw at beetle and eat it before it gets away love to play with owner\'s hair tie but swat at dog, or loves cheeseburgers.Please stop looking at your phone and pet me damn that dog poop in litter box, scratch the wallsor immediately regret falling into bathtub for behind the couch sit by the fire pelt around the house and up and down stairs chasing phantoms. Love to play with owner\'s hair tie please stop looking at your phone and pet me, sniff other cat\'s butt and hang jaw half open thereafter, spot something, big eyes, big eyes, crouch, shake butt, prepare to pounce lay on arms while you\'re using the keyboard so scamper. Hide head under blanket so no one can see. </p>', 'A short summary of the article.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `article_images`
--

CREATE TABLE `article_images` (
  `id` int(5) NOT NULL,
  `article_id` varchar(5) NOT NULL,
  `image_name` text NOT NULL,
  `image_type` text NOT NULL,
  `image_size` int(11) NOT NULL,
  `is_primary` tinyint(1) DEFAULT NULL,
  `is_shown` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `article_images`
--

INSERT INTO `article_images` (`id`, `article_id`, `image_name`, `image_type`, `image_size`, `is_primary`, `is_shown`) VALUES
(62, '19', 'animage.jpg', 'image/JPEG', 1101, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pm_user_admin` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `pm_user_admin`) VALUES
(3, 'roxy', '$2y$10$3VBQZBSjV0Emk3QRJ9bTR.oXAKyKxdfXhZFaXDHuHpm77MID4Dca2', 1),
(5, 'test', '$2y$10$FceOd3EZtqYADO5D0dp3p.KDB37soWsEXCcC8ibFIF/2d6yhBf.2O', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_images`
--
ALTER TABLE `article_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `article_images`
--
ALTER TABLE `article_images`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
