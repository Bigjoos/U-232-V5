-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 13, 2016 at 07:21 PM
-- Server version: 5.5.49-0+deb8u1
-- PHP Version: 7.0.7-1~dotdeb+8.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `09source`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievementist`
--

CREATE TABLE IF NOT EXISTS `achievementist` (
  `id` int(5) NOT NULL,
  `achievname` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `notes` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `clienticon` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `achievementist`
--

INSERT INTO `achievementist` (`id`, `achievname`, `notes`, `clienticon`) VALUES
(1, 'First Birthday', 'Been a member for at least 1 year.', 'birthday1.png'),
(2, 'Second Birthday', 'Been a member for a period of at least 2 years.', 'birthday2.png'),
(6, 'Fourth Birthday', 'Been a member for a period of at least 4 years.', 'birthday4.png'),
(5, 'Third Birthday', 'Been a member for a period of at least 3 years.', 'birthday3.png'),
(7, 'Fifth Birthday', 'Been a member for a period of at least 5 years.', 'birthday5.png'),
(8, 'Uploader LVL1', 'Uploaded at least 1 torrent to the site.', 'ul1.png'),
(9, 'Uploader LVL2', 'Uploaded at least 50 torrents to the site.', 'ul2.png'),
(10, 'Uploader LVL3', 'Uploaded at least 100 torrents to the site.', 'ul3.png'),
(11, 'Uploader LVL4', 'Uploaded at least 200 torrents to the site.', 'ul4.png'),
(12, 'Uploader LVL5', 'Uploaded at least 300 torrents to the site.', 'ul5.png'),
(13, 'Uploader LVL6', 'Uploaded at least 500 torrents to the site.', 'ul6.png'),
(14, 'Uploader LVL7', 'Uploaded at least 800 torrents to the site.', 'ul7.png'),
(15, 'Uploader LVL8', 'Uploaded at least 1000 torrents to the site.', 'ul8.png'),
(16, 'Uploader LVL9', 'Uploaded at least 1500 torrents to the site.', 'ul9.png'),
(17, 'Uploader LVL10', 'Uploaded at least 2000 torrents to the site.', 'ul10.png'),
(18, 'Inviter LVL1', 'Invited at least 1 new user to the site.', 'invite1.png'),
(19, 'Inviter LVL2', 'Invited at least 2 new users to the site.', 'invite2.png'),
(20, 'Inviter LVL3', 'Invited at least 3 new users to the site.', 'invite3.png'),
(21, 'Inviter LVL4', 'Invited at least 5 new users to the site.', 'invite4.png'),
(22, 'Inviter LVL5', 'Invited at least 10 new users to the site.', 'invite5.png'),
(23, 'Forum Poster LVL1', 'Made at least 1 post in the forums.', 'fpost1.png'),
(24, 'Forum Poster LVL2', 'Made at least 25 posts in the forums.', 'fpost2.png'),
(25, 'Forum Poster LVL3', 'Made at least 50 posts in the forums.', 'fpost3.png'),
(26, 'Forum Poster LVL4', 'Made at least 100 posts in the forums.', 'fpost4.png'),
(27, 'Forum Poster LVL5', 'Made at least 250 posts in the forums.', 'fpost5.png'),
(28, 'Avatar Setter', 'User has successfully set an avatar on profile settings.', 'piratesheep.png'),
(29, 'Old Virginia', 'At the age of 25 still remains a virgin.  (Custom Achievement.)', 'virgin.png'),
(30, 'Forum Poster LVL6', 'Made at least 500 posts in the forums.', 'fpost6.png'),
(31, 'Stick Em Up LVL1', 'Uploading at least 1 sticky torrent to the site.', 'sticky1.png'),
(32, 'Stick Em Up LVL2', 'Uploading at least 5 sticky torrents to the site.', 'sticky2.png'),
(33, 'Stick Em Up LVL3', 'Uploading at least 10 sticky torrents.', 'sticky3.png'),
(34, 'Stick EM Up LVL4', 'Uploading at least 25 sticky torrents.', 'sticky4.png'),
(35, 'Stick EM Up LVL5', 'Uploading at least 50 sticky torrents.', 'sticky5.png'),
(36, 'Gag Da B1tch', 'Getting gagged like he\'s Adams Man!', 'gagged.png'),
(37, 'Signature Setter', 'User has successfully set a signature on profile settings.', 'signature.png'),
(38, 'Corruption Counts', 'Transferred at least 1 byte of corrupt data incoming.', 'corrupt.png'),
(40, '7 Day Seeder', 'Seeded a snatched torrent for a total of at least 7 days.', '7dayseed.png'),
(41, '14 Day Seeder', 'Seeded a snatched torrent for a total of at least 14 days.', '14dayseed.png'),
(42, '21 Day Seeder', 'Seeded a snatched torrent for a total of at least 21 days.', '21dayseed.png'),
(43, '28 Day Seeder', 'Seeded a snatched torrent for a total of at least 28 days.', '28dayseed.png'),
(44, '45 Day Seeder', 'Seeded a snatched torrent for a total of at least 45 days.', '45dayseed.png'),
(45, '60 Day Seeder', 'Seeded a snatched torrent for a total of at least 60 days.', '60dayseed.png'),
(46, '90 Day Seeder', 'Seeded a snatched torrent for a total of at least 90 days.', '90dayseed.png'),
(47, '120 Day Seeder', 'Seeded a snatched torrent for a total of at least 120 days.', '120dayseed.png'),
(48, '200 Day Seeder', 'Seeded a snatched torrent for a total of at least 200 days.', '200dayseed.png'),
(49, '1 Year Seeder', 'Seeded a snatched torrent for a total of at least 1 Year.', '365dayseed.png'),
(50, 'Sheep Fondler', 'User has been caught touching the sheep at least 1 time.', 'sheepfondler.png'),
(51, 'Forum Topic Starter LVL1', 'Started at least 1 topic in the forums.', 'ftopic1.png'),
(52, 'Forum Topic Starter LVL2', 'Started at least 10 topics in the forums.', 'ftopic2.png'),
(53, 'Forum Topic Starter LVL3', 'Started at least 25 topics in the forums.', 'ftopic3.png'),
(55, 'Forum Topic Starter LVL4', 'Started at least 50 topics in the forums.', 'ftopic4.png'),
(58, 'Bonus Banker LVL1', 'Earned at least 1 bonus point.', 'bonus1.png'),
(57, 'Forum Topic Starter LVL5', 'Started at least 75 topics in the forums.', 'ftopic5.png'),
(61, 'Bonus Banker LVL3', 'Earned at least 500 bonus points.', 'bonus3.png'),
(60, 'Bonus Banker LVL2', 'Earned at least 100 bonus points.', 'bonus2.png'),
(66, 'Bonus Banker LVL6', 'Earned at least 5000 bonus points.', 'bonus6.png'),
(63, 'Bonus Banker LVL4', 'Earned at least 1000 bonus points.', 'bonus4.png'),
(65, 'Bonus Banker LVL5', 'Earned at least 2000 bonus points.', 'bonus5.png'),
(71, 'Bonus Banker LVL9', 'Earned at least 70000 bonus points.', 'bonus10.png'),
(68, 'Bonus Banker LVL7', 'Earned at least 10000 bonus points.', 'bonus7.png'),
(70, 'Bonus Banker LVL8', 'Earned at least 30000 bonus points.', 'bonus9.png'),
(72, 'Bonus Banker LVL10', 'Earned at least 100000 bonus points.', 'bonus8.png'),
(73, 'Bonus Banker LVL11', 'Earned at least 1000000 bonus points.', 'bonus11.png'),
(74, 'Christmas Achievement', 'User has found the Christmas Achievement in the advent calendar page.', 'christmas.png'),
(75, 'Advent Playa', 'Played the Advent Calendar all 25 days straight.', 'xmasdays.png'),
(76, 'Request Filler LVL1', 'Filled at least 1 request from the request page.', 'reqfiller1.png'),
(77, 'Request Filler LVL2', 'Filled at least 5 requests from the request page.', 'reqfiller2.png'),
(78, 'Request Filler LVL3', 'Filled at least 10 requests from the request page.', 'reqfiller3.png'),
(79, 'Request Filler LVL4', 'Filled at least 25 requests from the request page.', 'reqfiller4.png'),
(80, 'Request Filler LVL5', 'Filled at least 50 requests from the request page.', 'reqfiller5.png'),
(81, 'Adam Punker', 'Officially Punked Adam in the proper forum thread.', 'adampnkr.png'),
(82, 'Shout Spammer LVL1', 'Made at least 10 posts to the shoutbox today.', 'spam1.png'),
(83, 'Shout Spammer LVL2', 'Made at least 25 posts to the shoutbox today.', 'spam2.png'),
(84, 'Shout Spammer LVL3', 'Made at least 50 posts to the shoutbox today.', 'spam3.png'),
(85, 'Shout Spammer LVL4', 'Made at least 75 posts to the shoutbox today.', 'spam4.png'),
(86, 'Shout Spammer LVL5', 'Made at least 100 posts to the shoutbox today.', 'spam5.png');

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE IF NOT EXISTS `achievements` (
  `id` int(5) UNSIGNED NOT NULL,
  `userid` int(5) NOT NULL DEFAULT '0',
  `achievement` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `achievementid` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ach_bonus`
--

CREATE TABLE IF NOT EXISTS `ach_bonus` (
  `bonus_id` tinyint(3) UNSIGNED NOT NULL,
  `bonus_desc` text CHARACTER SET utf8,
  `bonus_type` tinyint(4) NOT NULL DEFAULT '0',
  `bonus_do` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ach_bonus`
--

INSERT INTO `ach_bonus` (`bonus_id`, `bonus_desc`, `bonus_type`, `bonus_do`) VALUES
(1, 'Subtract 10GB From Your Download.', 1, '10737418240'),
(2, 'Subtract 1GB From Your Download.', 1, '1073741824'),
(3, 'Subtract 3GB From Your Download.', 1, '3221225472'),
(4, 'Subtract 5GB From Your Download.', 1, '5368709120'),
(5, 'Subtract 100MB From Your Download.', 1, '107374182'),
(6, 'Subtract 300MB From Your Download.', 1, '322122547'),
(7, 'Subtract 500MB From Your Download.', 1, '536870910'),
(8, 'Subtract 1MB From Your Download.', 1, '1073741'),
(9, 'Add 1GB to your Upload.', 2, '1073741824'),
(10, 'Add 10GB to your Upload.', 2, '10737418240'),
(11, 'Add 3GB to your Upload.', 2, '3221225472'),
(12, 'Add 5GB to your Upload.', 2, '5368709120'),
(13, 'Add 100MB to your Upload.', 2, '107374182'),
(14, 'Add 300MB to your Upload.', 2, '322122547'),
(15, 'Add 500MB to your Upload.', 2, '536870910'),
(16, 'Add 1MB to your Upload.', 2, '1073741'),
(17, 'Add 1 Invite.', 3, '1'),
(18, 'Add 2 Invites.', 3, '2'),
(19, 'Add 100 Bonus Points to your Total.', 4, '100'),
(20, 'Add 200 Bonus Points to your Total.', 4, '200'),
(21, 'Add 500 Bonus Points to your Total.', 4, '500'),
(22, 'Add 750 Bonus Points to your Total.', 4, '750'),
(23, 'Add 1000 Bonus Points to your Total.', 4, '1000'),
(24, 'Add 50 Bonus Points to your Total.', 4, '50'),
(25, 'Add 25 Bonus Points to your Total.', 4, '25'),
(26, 'Add 75 Bonus Points to your Total.', 4, '75'),
(27, 'Add 10 Bonus Points to your Total.', 4, '10'),
(28, 'Nothing', 5, '0'),
(29, 'Nothing', 5, '0'),
(30, 'Nothing', 5, '0'),
(31, 'Nothing', 5, '0'),
(32, 'Nothing', 5, '0');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_main`
--

CREATE TABLE IF NOT EXISTS `announcement_main` (
  `main_id` int(10) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `expires` int(11) NOT NULL DEFAULT '0',
  `sql_query` text CHARACTER SET utf8,
  `subject` text CHARACTER SET utf8,
  `body` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_process`
--

CREATE TABLE IF NOT EXISTS `announcement_process` (
  `process_id` int(10) UNSIGNED NOT NULL,
  `main_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachmentdownloads`
--

CREATE TABLE IF NOT EXISTS `attachmentdownloads` (
  `id` int(10) UNSIGNED NOT NULL,
  `fileid` int(10) NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userid` int(10) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `downloads` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `topicid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `postid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `size` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `owner` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `downloads` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `avps`
--

CREATE TABLE IF NOT EXISTS `avps` (
  `arg` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `value_s` text CHARACTER SET utf8,
  `value_i` int(11) NOT NULL DEFAULT '0',
  `value_u` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `avps`
--

INSERT INTO `avps` (`arg`, `value_s`, `value_i`, `value_u`) VALUES
('loadlimit', '1.26-1455488682', 0, 0),
('inactivemail', '1', 1341778326, 1),
('sitepot', '0', 0, 1359295634),
('bestfilmofweek', '0', 1402495922, 20),
('last24', '0', 0, 1303875421);

-- --------------------------------------------------------

--
-- Table structure for table `bannedemails`
--

CREATE TABLE IF NOT EXISTS `bannedemails` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` int(11) NOT NULL,
  `addedby` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comment` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bannedemails`
--

INSERT INTO `bannedemails` (`id`, `added`, `addedby`, `comment`, `email`) VALUES
(1, 1282299331, 1, 'Fake provider', '*@emailias.com'),
(2, 1282299331, 1, 'Fake provider', '*@e4ward.com'),
(3, 1282299331, 1, 'Fake provider', '*@dumpmail.de'),
(4, 1282299331, 1, 'Fake provider', '*@dontreg.com'),
(5, 1282299331, 1, 'Fake provider', '*@disposeamail.com'),
(6, 1282299331, 1, 'Fake provider', '*@antispam24.de'),
(7, 1282299331, 1, 'Fake provider', '*@trash-mail.de'),
(8, 1282299331, 1, 'Fake provider', '*@spambog.de'),
(9, 1282299331, 1, 'Fake provider', '*@spambog.com'),
(10, 1282299331, 1, 'Fake provider', '*@discardmail.com'),
(11, 1282299331, 1, 'Fake provider', '*@discardmail.de'),
(12, 1282299331, 1, 'Fake provider', '*@mailinator.com'),
(13, 1282299331, 1, 'Fake provider', '*@wuzup.net'),
(14, 1282299331, 1, 'Fake provider', '*@junkmail.com'),
(15, 1282299331, 1, 'Fake provider', '*@clarkgriswald.net'),
(16, 1282299331, 1, 'Fake provider', '*@2prong.com'),
(17, 1282299331, 1, 'Fake provider', '*@jrwilcox.com'),
(18, 1282299331, 1, 'Fake provider', '*@10minutemail.com'),
(19, 1282299331, 1, 'Fake provider', '*@pookmail.com'),
(20, 1282299331, 1, 'Fake provider', '*@golfilla.info'),
(21, 1282299331, 1, 'Fake provider', '*@afrobacon.com'),
(22, 1282299331, 1, 'Fake provider', '*@senseless-entertainment.com'),
(23, 1282299331, 1, 'Fake provider', '*@put2.net'),
(24, 1282299331, 1, 'Fake provider', '*@temporaryinbox.com'),
(25, 1282299331, 1, 'Fake provider', '*@slaskpost.se'),
(26, 1282299331, 1, 'Fake provider', '*@haltospam.com'),
(27, 1282299331, 1, 'Fake provider', '*@h8s.org'),
(28, 1282299331, 1, 'Fake provider', '*@ipoo.org'),
(29, 1282299331, 1, 'Fake provider', '*@oopi.org'),
(30, 1282299331, 1, 'Fake provider', '*@poofy.org'),
(31, 1282299331, 1, 'Fake provider', '*@jetable.org'),
(32, 1282299331, 1, 'Fake provider', '*@kasmail.com'),
(33, 1282299331, 1, 'Fake provider', '*@mail-filter.com'),
(34, 1282299331, 1, 'Fake provider', '*@maileater.com'),
(35, 1282299331, 1, 'Fake provider', '*@mailexpire.com'),
(36, 1282299331, 1, 'Fake provider', '*@mailnull.com'),
(37, 1282299331, 1, 'Fake provider', '*@mailshell.com'),
(38, 1282299331, 1, 'Fake provider', '*@mymailoasis.com'),
(39, 1282299331, 1, 'Fake provider', '*@mytrashmail.com'),
(40, 1282299331, 1, 'Fake provider', '*@mytrashmail.net'),
(41, 1282299331, 1, 'Fake provider', '*@shortmail.net'),
(42, 1282299331, 1, 'Fake provider', '*@sneakemail.com'),
(43, 1282299331, 1, 'Fake provider', '*@sofort-mail.de'),
(44, 1282299331, 1, 'Fake provider', '*@spamcon.org'),
(45, 1282299331, 1, 'Fake provider', '*@spamday.com'),
(46, 1282299331, 1, 'fake provider', '*@spamex.com'),
(47, 1282299307, 1, 'fake provider', '*@spamgourmet.com'),
(48, 1282299289, 1, 'fake provider', '*@spamhole.com'),
(49, 1282299331, 1, 'Fake provider', '*@spammotel.com'),
(50, 1282299331, 1, 'Fake provider', '*@tempemail.net'),
(51, 1282299331, 1, 'Fake provider', '*@tempinbox.com'),
(52, 1282299331, 1, 'Fake provider', '*@throwaway.de'),
(53, 1282299331, 1, 'Fake provider', '*@woodyland.org');

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE IF NOT EXISTS `bans` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` int(11) NOT NULL,
  `addedby` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comment` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `first` bigint(11) DEFAULT NULL DEFAULT '0',
  `last` bigint(11) DEFAULT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blackjack`
--

CREATE TABLE IF NOT EXISTS `blackjack` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `status` enum('playing','waiting') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'playing',
  `cards` text CHARACTER SET utf8,
  `date` int(11) DEFAULT '0',
  `gameover` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `blockid` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bonus`
--

CREATE TABLE IF NOT EXISTS `bonus` (
  `id` int(5) NOT NULL,
  `bonusname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `points` decimal(10,1) NOT NULL DEFAULT '0.0',
  `description` text CHARACTER SET utf8,
  `art` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `menge` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `pointspool` decimal(10,1) NOT NULL DEFAULT '1.0',
  `enabled` enum('yes','no') CHARACTER SET latin1 NOT NULL DEFAULT 'yes' COMMENT 'This will determined a switch if the bonus is enabled or not! enabled by default',
  `minpoints` decimal(10,1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bonus`
--

INSERT INTO `bonus` (`id`, `bonusname`, `points`, `description`, `art`, `menge`, `pointspool`, `enabled`, `minpoints`) VALUES
(1, '1.0GB Uploaded', '275.0', 'With enough bonus points acquired, you are able to exchange them for an Upload Credit. The points are then removed from your Bonus Bank and the credit is added to your total uploaded amount.', 'traffic', 1073741824, '1.0', 'yes', '275.0'),
(2, '2.5GB Uploaded', '350.0', 'With enough bonus points acquired, you are able to exchange them for an Upload Credit. The points are then removed from your Bonus Bank and the credit is added to your total uploaded amount.', 'traffic', 2684354560, '1.0', 'yes', '350.0'),
(3, '5GB Uploaded', '550.0', 'With enough bonus points acquired, you are able to exchange them for an Upload Credit. The points are then removed from your Bonus Bank and the credit is added to your total uploaded amount.', 'traffic', 5368709120, '1.0', 'yes', '550.0'),
(4, '3 Invites', '650.0', 'With enough bonus points acquired, you are able to exchange them for a few invites. The points are then removed from your Bonus Bank and the invitations are added to your invites amount.', 'invite', 3, '1.0', 'yes', '650.0'),
(5, 'Custom Title!', '50.0', 'For only 50.0 Karma Bonus Points you can buy yourself a custom title. the only restrictions are no foul or offensive language or userclass can be entered. The points are then removed from your Bonus Bank and your special title is changed to the title of your choice', 'title', 1, '1.0', 'yes', '50.0'),
(6, 'VIP Status', '5000.0', 'With enough bonus points acquired, you can buy yourself VIP status for one month. The points are then removed from your Bonus Bank and your status is changed.', 'class', 1, '1.0', 'yes', '5000.0'),
(7, 'Give A Karma Gift', '100.0', 'Well perhaps you dont need the upload credit, but you know somebody that could use the Karma boost! You are now able to give your Karma credits as a gift! The points are then removed from your Bonus Bank and added to the account of a user of your choice!\r\n\r\nAnd they recieve a PM with all the info as well as who it came from...', 'gift_1', 1073741824, '1.0', 'yes', '100.0'),
(8, 'Custom Smilies', '300.0', 'With enough bonus points acquired, you can buy yourself a set of custom smilies for one month! The points are then removed from your Bonus Bank and with a click of a link, your new smilies are available whenever you post or comment!', 'smile', 1, '1.0', 'yes', '300.0'),
(9, 'Remove Warning', '1000.0', 'With enough bonus points acquired... So you have been naughty... tsk tsk :P Yep now for the Low Low price of only 1000 points you can have that warning taken away lol.!', 'warning', 1, '1.0', 'yes', '1000.0'),
(10, 'Ratio Fix', '500.0', 'With enough bonus points acquired, you can bring the ratio of one torrent to a 1 to 1 ratio! The points are then removed from your Bonus Bank and your status is changed.', 'ratio', 1, '1.0', 'yes', '500.0'),
(11, 'FreeLeech', '30000.0', 'The Ultimate exchange if you have over 30000 Points - Make the tracker freeleech for everyone for 3 days: Upload will count but no download.\r\nIf you dont have enough points you can donate certain amount of your points until it accumulates. Everybodys karma counts!', 'freeleech', 1, '3200.0', 'yes', '1.0'),
(12, 'Doubleupload', '30000.0', 'The ultimate exchange if you have over 30000 points - Make the tracker double upload for everyone for 3 days: Upload will count double.\r\nIf you dont have enough points you can donate certain amount of your points until it accumulates. Everybodys karma counts!', 'doubleup', 1, '0.0', 'yes', '1.0'),
(13, 'Halfdownload', '30000.0', 'The ultimate exchange if you have over 30000 points - Make the tracker Half Download for everyone for 3 days: Download will count only half.\r\nIf you dont have enough points you can donate certain amount of your points until it accumulates. Everybodys karma counts!', 'halfdown', 1, '0.0', 'yes', '1.0'),
(14, '1.0GB Download Removal', '150.0', 'With enough bonus points acquired, you are able to exchange them for a Download Credit Removal. The points are then removed from your Bonus Bank and the download credit is removed from your total downloaded amount.', 'traffic2', 1073741824, '1.0', 'yes', '150.0'),
(15, '2.5GB Download Removal', '300.0', 'With enough bonus points acquired, you are able to exchange them for a Download Credit Removal. The points are then removed from your Bonus Bank and the download credit is removed from your total downloaded amount.', 'traffic2', 2684354560, '1.0', 'yes', '300.0'),
(16, '5GB Download Removal', '500.0', 'With enough bonus points acquired, you are able to exchange them for a Download Credit Removal. The points are then removed from your Bonus Bank and the download credit is removed from your total downloaded amount.', 'traffic2', 5368709120, '1.0', 'yes', '500.0'),
(17, 'Anonymous Profile', '750.0', 'With enough bonus points acquired, you are able to exchange them for Anonymous profile for 14 days. The points are then removed from your Bonus Bank and the Anonymous switch will show on your profile.', 'anonymous', 1, '1.0', 'yes', '750.0'),
(18, 'Freeleech for 1 Year', '80000.0', 'With enough bonus points acquired, you are able to exchange them for Freelech for one year for yourself. The points are then removed from your Bonus Bank and the freeleech will be enabled on your account.', 'freeyear', 1, '1.0', 'yes', '80000.0'),
(19, '3 Freeleech Slots', '1000.0', 'With enough bonus points acquired, you are able to exchange them for some Freeleech Slots. The points are then removed from your Bonus Bank and the slots are added to your free slots amount.', 'freeslots', 3, '0.0', 'yes', '1000.0'),
(20, '200 Bonus Points - Invite trade-in', '1.0', 'If you have 1 invite and dont use them click the button to trade them in for 200 Bonus Points.', 'itrade', 200, '0.0', 'yes', '0.0'),
(21, 'Freeslots - Invite trade-in', '1.0', 'If you have 1 invite and dont use them click the button to trade them in for 2 Free Slots.', 'itrade2', 2, '0.0', 'yes', '0.0'),
(22, 'Pirate Rank for 2 weeks', '50000.0', 'With enough bonus points acquired, you are able to exchange them for Pirates status and Freeleech for 2 weeks. The points are then removed from your Bonus Bank and the Pirate icon will be displayed throughout, freeleech will then be enabled on your account.', 'pirate', 1, '1.0', 'yes', '50000.0'),
(23, 'King Rank for 1 month', '70000.0', 'With enough bonus points acquired, you are able to exchange them for Kings status and Freeleech for 1 month. The points are then removed from your Bonus Bank and the King icon will be displayed throughout,  freeleech will then be enabled on your account.', 'king', 1, '1.0', 'yes', '70000.0'),
(24, '10GB Uploaded', '1000.0', 'With enough bonus points acquired, you are able to exchange them for an Upload Credit. The points are then removed from your Bonus Bank and the credit is added to your total uploaded amount.', 'traffic', 10737418240, '0.0', 'yes', '1000.0'),
(25, '25GB Uploaded', '2000.0', 'With enough bonus points acquired, you are able to exchange them for an Upload Credit. The points are then removed from your Bonus Bank and the credit is added to your total uploaded amount.', 'traffic', 26843545600, '0.0', 'yes', '2000.0'),
(26, '50GB Uploaded', '4000.0', 'With enough bonus points acquired, you are able to exchange them for an Upload Credit. The points are then removed from your Bonus Bank and the credit is added to your total uploaded amount.', 'traffic', 53687091200, '0.0', 'yes', '4000.0'),
(27, '100GB Uploaded', '8000.0', 'With enough bonus points acquired, you are able to exchange them for an Upload Credit. The points are then removed from your Bonus Bank and the credit is added to your total uploaded amount.', 'traffic', 107374182400, '0.0', 'yes', '8000.0'),
(28, '520GB Uploaded', '40000.0', 'With enough bonus points acquired, you are able to exchange them for an Upload Credit. The points are then removed from your Bonus Bank and the credit is added to your total uploaded amount.', 'traffic', 558345748480, '0.0', 'yes', '40000.0'),
(29, '1TB Uploaded', '80000.0', 'With enough bonus points acquired, you are able to exchange them for an Upload Credit. The points are then removed from your Bonus Bank and the credit is added to your total uploaded amount.', 'traffic', 1099511627776, '0.0', 'yes', '80000.0'),
(30, 'Parked Profile', '75000.0', 'With enough bonus points acquired, you are able to unlock the parked option within your profile which will ensure your account will be safe. The points are then removed from your Bonus Bank and the parked switch will show on your profile.', 'parked', 1, '1.0', 'yes', '75000.0'),
(31, 'Pirates bounty', '50000.0', 'With enough bonus points acquired, you are able to exchange them for Pirates bounty which will select random users and deduct random amount of reputation points from them. The points are removed from your Bonus Bank and the reputation points will be deducted from the selected users then credited to you.', 'bounty', 1, '1.0', 'yes', '50000.0'),
(32, '100 Reputation points', '40000.0', 'With enough bonus points acquired, you are able to exchange them for some reputation points. The points are then removed from your Bonus Bank and the rep is added to your total reputation amount.', 'reputation', 100, '0.0', 'yes', '40000.0'),
(33, 'Userblocks', '50000.0', 'With enough bonus points acquired and a minimum of 50 reputation points, you are able to exchange them for userblocks access. The points are then removed from your Bonus Bank and the user blocks configuration link will appear on your menu.', 'userblocks', 0, '0.0', 'yes', '50000.0'),
(34, 'Bump a Torrent!', '5000.0', 'With enough bonus points acquired, you can Bump a torrent back to page 1 of the torrents page, bringing it back to life! \r\nThe torrent will then appear on page 1 again! The points are then removed from your Bonus Bank and the torrent is Bumped!\r\n** note there is an option to either view Bumped torrents or not.', 'bump', 1, '0.0', 'yes', '5000.0'),
(35, 'Immunity', '150000.0', 'With enough bonus points acquired, you are able to exchange them for immunity for one year. The points are then removed from your Bonus Bank and the immunity switch is enabled on your account.', 'immunity', 1, '0.0', 'yes', '150000.0'),
(36, 'User Unlocks', '500.0', 'With enough bonus points acquired and a minimum of 50 reputation points, you are able to exchange them for bonus locked moods. The points are then removed from your Bonus Bank and the user unlocks configuration link will appear on your menu.', 'userunlock', 1, '0.0', 'yes', '500.0');

-- --------------------------------------------------------

--
-- Table structure for table `bonuslog`
--

CREATE TABLE IF NOT EXISTS `bonuslog` (
  `id` int(10) UNSIGNED NOT NULL,
  `donation` decimal(10,1) NOT NULL,
  `type` varchar(44) CHARACTER SET utf8 DEFAULT NULL,
  `added_at` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='log of contributors towards freeleech etc...';

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `torrentid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `private` enum('yes','no') CHARACTER SET utf8 NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bugs`
--

CREATE TABLE IF NOT EXISTS `bugs` (
  `id` int(10) NOT NULL,
  `sender` int(10) NOT NULL DEFAULT '0',
  `added` int(12) NOT NULL DEFAULT '0',
  `priority` enum('low','high','veryhigh') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'low',
  `problem` text CHARACTER SET utf8,
  `status` enum('fixed','ignored','na') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'na',
  `staff` int(10) NOT NULL DEFAULT '0',
  `title` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `pic` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `points`, `pic`) VALUES
(1, 2, '2p.bmp'),
(2, 3, '3p.bmp'),
(3, 4, '4p.bmp'),
(4, 5, '5p.bmp'),
(5, 6, '6p.bmp'),
(6, 7, '7p.bmp'),
(7, 8, '8p.bmp'),
(8, 9, '9p.bmp'),
(9, 10, '10p.bmp'),
(10, 10, 'vp.bmp'),
(11, 10, 'dp.bmp'),
(12, 10, 'kp.bmp'),
(13, 1, 'tp.bmp'),
(14, 2, '2b.bmp'),
(15, 3, '3b.bmp'),
(16, 4, '4b.bmp'),
(17, 5, '5b.bmp'),
(18, 6, '6b.bmp'),
(19, 7, '7b.bmp'),
(20, 8, '8b.bmp'),
(21, 9, '9b.bmp'),
(22, 10, '10b.bmp'),
(23, 10, 'vb.bmp'),
(24, 10, 'db.bmp'),
(25, 10, 'kb.bmp'),
(26, 1, 'tb.bmp'),
(27, 2, '2k.bmp'),
(28, 3, '3k.bmp'),
(29, 4, '4k.bmp'),
(30, 5, '5k.bmp'),
(31, 6, '6k.bmp'),
(32, 7, '7k.bmp'),
(33, 8, '8k.bmp'),
(34, 9, '9k.bmp'),
(35, 10, '10k.bmp'),
(36, 10, 'vk.bmp'),
(37, 10, 'dk.bmp'),
(38, 10, 'kk.bmp'),
(39, 1, 'tk.bmp'),
(40, 2, '2c.bmp'),
(41, 3, '3c.bmp'),
(42, 4, '4c.bmp'),
(43, 5, '5c.bmp'),
(44, 6, '6c.bmp'),
(45, 7, '7c.bmp'),
(46, 8, '8c.bmp'),
(47, 9, '9c.bmp'),
(48, 10, '10c.bmp'),
(49, 10, 'vc.bmp'),
(50, 10, 'dc.bmp'),
(51, 10, 'kc.bmp'),
(52, 1, 'tc.bmp');

-- --------------------------------------------------------

--
-- Table structure for table `casino`
--

CREATE TABLE IF NOT EXISTS `casino` (
  `userid` int(10) NOT NULL DEFAULT '0',
  `win` bigint(20) NOT NULL DEFAULT '0',
  `lost` bigint(20) NOT NULL DEFAULT '0',
  `trys` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `enableplay` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `deposit` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `casino_bets`
--

CREATE TABLE IF NOT EXISTS `casino_bets` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0',
  `proposed` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `challenged` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `amount` bigint(20) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `winner` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cat_desc` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `parent_id` mediumint(5) NOT NULL DEFAULT '-1',
  `tabletype` tinyint(2) UNSIGNED NOT NULL DEFAULT '1',
  `min_class` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `cat_desc`, `parent_id`, `tabletype`, `min_class`) VALUES
(2, 'Games', 'cat_games.png', 'No Description', -1, 1, 0),
(3, 'Movies', 'cat_dvd.png', 'No Description', -1, 2, 0),
(4, 'Music', 'cat_music.png', 'No Description', -1, 4, 0),
(5, 'Episodes', 'cat_tveps.png', 'No Description', 3, 2, 0),
(6, 'XXX', 'cat_xxx.png', 'No Description', 3, 2, 2),
(7, 'Games/PSP', 'cat_psp.png', 'No Description', 2, 1, 0),
(8, 'Games/PS2', 'cat_ps2.png', 'No Description', 2, 1, 0),
(9, 'Anime', 'cat_anime.png', 'No Description', 3, 2, 0),
(10, 'Movies/XviD', 'cat_xvid.png', 'No Description', 3, 2, 0),
(11, 'Movies/HDTV', 'cat_hdtv.png', 'No Description', 3, 2, 0),
(12, 'Games/PC Rips', 'cat_pcrips.png', 'No Description', 2, 1, 0),
(13, 'Apps', 'cat_misc.png', 'No Description', -1, 3, 0),
(1, 'Apps', 'cat_appz.png', 'No Description', 13, 3, 0),
(14, 'Music', 'cat_music.png', 'No Description', 4, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cheaters`
--

CREATE TABLE IF NOT EXISTS `cheaters` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` int(11) NOT NULL DEFAULT '0',
  `userid` int(10) NOT NULL DEFAULT '0',
  `torrentid` int(10) NOT NULL DEFAULT '0',
  `client` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `rate` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `beforeup` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `upthis` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `timediff` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `userip` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_config`
--

CREATE TABLE IF NOT EXISTS `class_config` (
  `id` int(5) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `classname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `classcolor` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `classpic` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class_config`
--

INSERT INTO `class_config` (`id`, `name`, `value`, `classname`, `classcolor`, `classpic`) VALUES
(1, 'UC_USER', '0 ', 'USER', '8e35ef', 'user.gif'),
(2, 'UC_POWER_USER', '1 ', 'POWER USER', 'f9a200', 'power.gif'),
(3, 'UC_VIP', '2 ', 'VIP', '009f00', 'vip.gif'),
(4, 'UC_UPLOADER', '3 ', 'UPLOADER', '0000ff', 'uploader.gif'),
(5, 'UC_MODERATOR', '4 ', 'MODERATOR', 'fe2e2e', 'moderator.gif'),
(6, 'UC_ADMINISTRATOR', '5 ', 'ADMINISTRATOR', 'b000b0', 'administrator.gif'),
(7, 'UC_SYSOP', '6 ', 'SYSOP', 'FF0000', 'sysop.gif'),
(8, 'UC_MIN', '0', '', '', ''),
(9, 'UC_MAX', '6', '', '', ''),
(10, 'UC_STAFF', '4', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `class_promo`
--

CREATE TABLE IF NOT EXISTS `class_promo` (
  `id` int(10) NOT NULL,
  `name` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `min_ratio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `uploaded` bigint(20) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `low_ratio` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class_promo`
--

INSERT INTO `class_promo` (`id`, `name`, `min_ratio`, `uploaded`, `time`, `low_ratio`) VALUES
(6, '1', '1.20', 50, 20, '0.85');

-- --------------------------------------------------------

--
-- Table structure for table `cleanup`
--

CREATE TABLE IF NOT EXISTS `cleanup` (
  `clean_id` int(10) NOT NULL,
  `clean_title` char(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `clean_file` char(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `clean_time` int(11) NOT NULL DEFAULT '0',
  `clean_increment` int(11) NOT NULL DEFAULT '0',
  `clean_cron_key` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `clean_log` tinyint(1) NOT NULL DEFAULT '0',
  `clean_desc` text CHARACTER SET utf8,
  `clean_on` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cleanup`
--

INSERT INTO `cleanup` (`clean_id`, `clean_title`, `clean_file`, `clean_time`, `clean_increment`, `clean_cron_key`, `clean_log`, `clean_desc`, `clean_on`) VALUES
(4, 'Lottery Autoclean', 'lotteryclean.php', 1359812894, 86400, 'd6704d582b136ea1ed13635bb9059f57', 1, 'Lottery Autoclean - Lottery clean up here every X days', 0),
(5, 'Optimze Db Auto', 'optimizedb.php', 1466008623, 172800, 'd6704d582b136ea1ed13635bb9059f57', 1, 'Auto Optimize - Runs every 2 days', 1),
(6, 'Auto Backup Db', 'backupdb.php', 1465928432, 86400, 'd6704d582b136ea1ed13635bb9059f57', 1, 'Auto Backup - Runs every 1 day', 1),
(8, 'Irc bonus', 'irc_update.php', 1465847228, 1800, 'c06a074cd6403bcc1f292ce864c3cdd5', 1, 'Irc idle bonus update', 1),
(9, 'Statistics', 'sitestats_update.php', 1465847764, 3600, '2a2afb82d82cc4ddcb6ff1753a40dfe9', 1, 'SIte statistics update', 1),
(10, 'Karma Bonus', 'karma_update.php', 1465845624, 1800, 'd0df8a38cfba26ece2c285189a656ad0', 0, 'Seedbonus award update', 1),
(11, 'Forums', 'forum_update.php', 1465845659, 900, 'c9c58a0d43b02cd5358115673bc04c9e', 0, 'Forum online and count update', 1),
(12, 'Torrents', 'torrents_update.php', 1465846084, 900, '81875d0e7b63771ae2a59f2a48755da4', 1, 'Torrents update', 1),
(13, 'Normalize', 'torrents_normalize.php', 1465846254, 900, '1274dd2d9ffd203e6d489db25d0f28fe', 1, 'File, comment, torrent update', 1),
(14, 'Ips', 'ip_update.php', 1465910150, 86400, '0b4f34774259b5069d220c485aa10eba', 1, 'Ip clean', 1),
(15, 'Signups', 'expired_signup_update.php', 1466046950, 259200, 'bdde41096f769d1a01251813cc2c1353', 1, 'Expired signups update', 1),
(16, 'Peers', 'peer_update.php', 1465846509, 900, '72181fc6214ddc556d71066df031d424', 1, 'Peers update', 1),
(17, 'Visible', 'visible_update.php', 1465846422, 900, '77c523eab12be5d0342e4606188cd2ca', 0, 'Torrents visible update', 1),
(18, 'Announcements', 'announcement_update.php', 1465930904, 86400, 'b73c139b4defbc031e201b91fef29a4c', 1, 'Old announcement updates', 1),
(19, 'Readposts', 'readpost_update.php', 1465931244, 86400, '3e0c8bc6b6e6cc61fdfe8b26f8268b77', 1, 'Old Readposts updates', 1),
(20, 'Happyhour', 'happyhour_update.php', 1465860281, 43200, 'a7c422bc9f17b3fba5dab2d0129acd32', 1, 'HappyHour Updates', 1),
(21, 'Customsmilies', 'customsmilie_update.php', 1465910575, 86400, '9e8a41be2b0a56d83e0d0c0b00639f66', 1, 'Custom Smilie Update', 1),
(22, 'Karma Vips', 'karmavip_update.php', 1465859255, 86400, 'c444f13b95998c98a851714673ff6b84', 1, 'Karma VIp Updates', 1),
(23, 'Anonymous Profile', 'anonymous_update.php', 1465860191, 86400, '25146aec76a7b163ac6955685ff667d9', 1, 'Anonymous Profile Updates', 1),
(24, 'Delete Torrents', 'delete_torrents_update.php', 1465910577, 86400, '52f8e3c9fd438d4a86062f88f1146098', 1, 'Delete Old Torrents Update', 1),
(25, 'Funds', 'funds_update.php', 1465885184, 86400, '5f50f43a9e640cd6203e1964c17361ba', 1, 'Funds And Donation Updates', 1),
(26, 'Leechwarns', 'leechwarn_update.php', 1465885269, 86400, '0303a05302fadf30fc18f987d2a5b285', 1, 'Leechwarnings Update', 1),
(27, 'Auto Invite', 'autoinvite_update.php', 1465886970, 86400, '48839ced75a612d41d9278718075dbb2', 1, 'Auto Invite Updates', 1),
(28, 'Hit And Run', 'hitrun_update.php', 1465846914, 3600, '3ab445bbff84f87e8dc5a16489d7ca31', 1, 'Hit And Run Updates', 1),
(29, 'Freeslots Update', 'freeslot_update.php', 1465910830, 86400, '63db6b0519eccbfe0b06d87b8f0bcaad', 1, 'Freeslots Stuffs Update', 1),
(30, 'Backup Clean', 'backup_update.php', 1465892714, 86400, '2c0d1a9ffa04937255344b97e2c9706f', 1, 'Backups Clean Update', 1),
(31, 'Inactive Clean', 'inactive_update.php', 1465860871, 86400, 'a401de097e031315b751b992ee40d733', 1, 'Inactive Users Update', 1),
(32, 'Shout Clean', 'shout_update.php', 1465996467, 172800, '13515c22103b5b916c3d86023220cd61', 1, 'Shoutbox Clean Update', 1),
(33, 'Power User Clean', 'pu_update.php', 1465910662, 86400, '4751425b1c765360a5f8bab14c6b9a47', 1, 'Power User Clean Updates', 1),
(34, 'Power User Demote Clean', 'pu_demote_update.php', 1465859085, 86400, 'e9249b5f653f03ed425d68947155056b', 1, 'Power User Demote Clean Updates', 1),
(35, 'Bugs Clean', 'bugs_update.php', 1466020236, 1209600, '1e9734cdf50408a7739b7b03272aeab3', 1, 'Bugs Update Clean', 1),
(36, 'Sitepot Clean', 'sitepot_update.php', 1465922298, 86400, '29dae941216f1bdb81f69dce807b3501', 1, 'Sitepot Update Clean', 1),
(37, 'Userhits Clean', 'userhits_update.php', 1465864038, 86400, 'd0cec8e7adb50290db6cf911a5c74339', 1, 'Userhits Clean Updates', 1),
(38, 'Process Kill', 'processkill_update.php', 1465864357, 86400, 'b7c0f14c9482a14e9f5cb0d467dfd7c6', 1, 'Mysql Process KIll Updates', 1),
(39, 'Cleanup Log', 'cleanlog_update.php', 1465870817, 86400, '7dc0b72fc8c12b264fad1613fbea2489', 1, 'Cleanup Log Updates', 1),
(40, 'Pirate Cleanup', 'pirate_update.php', 1465883739, 86400, 'e5f20d43425832e9397841be6bc92be2', 1, 'Pirate Stuffs Update', 1),
(41, 'King Cleanup', 'king_update.php', 1465885014, 86400, '12b5c6c9f9919ca09816225c29fddaeb', 1, 'King Stuffs Update', 1),
(42, 'Free User Cleanup', 'freeuser_update.php', 1465848234, 3900, '37f9de0443159bf284a1c7a703e96cf9', 1, 'Free User Stuffs Update', 1),
(43, 'Download Possible Cleanup', 'downloadpos_update.php', 1465885342, 86400, 'e20bcc6d07c6ec493e106adb8d2a8227', 1, 'Download Possible Stuffs Update', 1),
(44, 'Upload Possible Cleanup', 'uploadpos_update.php', 1465889066, 86400, 'fd1110b750af878faccaf672fe53876d', 1, 'Upload Possible Stuffs Update', 1),
(45, 'Free Torrents Cleanup', 'freetorrents_update.php', 1465847084, 3600, '20390090ac784fee830d19bd708cfcad', 1, 'Free Torrents Stuffs Update', 1),
(46, 'Chatpost Cleanup', 'chatpost_update.php', 1465889268, 86400, 'bab6f1de36dc97dff02745051e076a39', 1, 'Chatpost Stuffs Update', 1),
(47, 'Immunity Cleanup', 'immunity_update.php', 1465892713, 86400, '11bf6f41c659b9f49f6ccdfa616e9f82', 1, 'Immunity Stuffs Update', 1),
(48, 'Warned Cleanup', 'warned_update.php', 1465892717, 86400, '6e558b89ac60454eaa3a45243347c977', 1, 'Warned Stuffs Update', 1),
(49, 'Games Update', 'gameaccess_update.php', 1465922300, 86400, '33704fd97f8840ff08ef4e6ff236b3e4', 1, 'Games Stuffs Updates', 1),
(50, 'Pm Update', 'sendpmpos_update.php', 1465922310, 86400, '32784b9c2891f022a91d5007f068f7d9', 1, 'Pm Stuffs Updates', 1),
(51, 'Avatar Update', 'avatarpos_update.php', 1465909897, 86400, 'f257794129ee772f5cfe00b33b363100', 1, 'Avatar Stuffs Updates', 1),
(52, 'Birthday Pms', 'birthday_update.php', 1465922395, 86400, '1fd167bf236ea5e74e835224d1cc36e9', 1, 'Pm all members with birthdays.', 1),
(53, 'Movie of the week', 'mow_update.php', 1466112315, 604800, '716274782f2f7229d960a6661fb06b60', 1, 'Updates movie of the week', 1),
(54, 'Silver torrents', 'silvertorrents_update.php', 1465846743, 3600, '3e1aab005271870d69934ebe37e28819', 1, 'Clean expired silver', 1),
(55, 'Failed Logins', 'failedlogin_update.php', 1465910152, 86400, 'c90f0f030d7914db6ae1263de1730541', 1, 'Delete expired failed logins', 1),
(56, 'Christmas Gift Rest', 'gift_update.php', 1466831806, 31556926, '4bdd6190a0ba3420d21b50b79945c06b', 1, 'Reset all users yearly xmas gift', 1),
(58, 'Achievements Update', 'achievement_avatar_update.php', 1465922453, 86400, '0c5889bab74e7ff8f920ec524423f627', 1, 'Updates user avatar achievements', 1),
(59, 'Achievements Update', 'achievement_bday_update.php', 1465910660, 86400, '2b95ff34a27d540f61ceca3ee1424216', 1, 'Updates user birthday achievements', 1),
(60, 'Achievements Update', 'achievement_corrupt_update.php', 1465922453, 86400, 'afefaecc0e31e412c28dbab154e43f9d', 1, 'Updates user corrupt achievements', 1),
(61, 'Achievements Update', 'achievement_fpost_update.php', 1465922820, 86400, 'f466ff2246e7e84bc60210aa947185da', 1, 'Updates user forum post achievements', 1),
(62, 'Achievements Update', 'achievement_ftopics_update.php', 1465927754, 86400, '825f6cac5fa992f505ceea3992db5483', 1, 'Updates user forum topic achievements', 1),
(63, 'Achievements Update', 'achievement_invite_update.php', 1465927839, 86400, '02e56c3aeba0b1e3e4bcca11699f23eb', 1, 'Updates user invite achievements', 1),
(64, 'Achievements Update', 'achievement_karma_update.php', 1465930394, 86400, '3827839629ade62f03a9fccbacb8402a', 1, 'Updates user Karma achievements', 1),
(65, 'Achievements Update', 'achievement_request_update.php', 1465930479, 86400, '48ec70ecc00c88b37977e2743d294888', 1, 'Updates user request achievements', 1),
(66, 'Achievements Update', 'achievement_seedtime_update.php', 1465846078, 86400, '158fb134b7a1487bdda67d42544693fc', 1, 'Updates user seedtime achievements', 1),
(67, 'Achievements Update', 'achievement_sheep_update.php', 1465847268, 86400, '97c3919a5947e00952bf82d1dc6f5c58', 1, 'Updates user sheep achievements', 1),
(68, 'Achievements Update', 'achievement_shouts_update.php', 1465849442, 86400, 'b07151b274bb6d568ab1bc3b3364cb6c', 1, 'Updates user shout achievements', 1),
(69, 'Achievements Update', 'achievement_sig_update.php', 1465867672, 86400, '82c3ff41b8e45a96bcd1582345d6dca9', 1, 'Updates user signature achievements', 1),
(70, 'Achievements Update', 'achievement_sreset_update.php', 1465885609, 86400, 'b51582111414701c0bd512fd2b4f0507', 1, 'Updates user achievements - Reset shouts', 1),
(71, 'Achievements Update', 'achievement_sticky_update.php', 1465930309, 86400, '00aaf60d3806924a42e95e64ee00c5fb', 1, 'Updates user sticky torrents achievements', 1),
(72, 'Achievements Update', 'achievement_up_update.php', 1465875067, 86400, 'b0feb2e2c22dbf9f1575c798a5d1560d', 1, 'Updates user uploader achievements', 1),
(73, 'Referrer cleans', 'referrer_update.php', 1465927924, 86400, '36bc2469228c1e0c8269ee9d309be37f', 1, 'Referrer Autoclean - Removes expired referrer entrys', 1),
(74, 'Snatch list admin', 'snatchclean_update.php', 1465877023, 86400, 'cfb8afef5b7a1c41e047dc791b0f1de0', 1, 'Clean old dead data', 1),
(76, 'Normalize XBT', 'torrents_normalize_xbt.php', 1424996020, 900, 'bd4f4ae7d7499aefbce82971a3b1cbbd', 1, 'XBT normalize query updates', 0),
(77, 'Delete torrents', 'delete_torrents_xbt_update.php', 1425032568, 86400, '2d47cfeddfd61ed4529e0d4a25ca0d12', 1, 'Delete torrent xbt update', 0),
(78, 'XBT Torrents', 'torrents_update_xbt.php', 1424996205, 900, '79e243cf24e92a13441b381d033d03a9', 1, 'XBT Torrents update', 0),
(79, 'XBT Peers', 'peer_update_xbt.php', 1418858258, 900, '3a0245bc43e2cad94ac7966bb3fe75f3', 1, 'XBT Peers update', 0),
(80, 'XBT hit and run system', 'hitrun_xbt_update.php', 1424999212, 3600, 'a6804b0f6d5ce68ac390d4d261a82d85', 1, 'XBT hit and run detection', 0),
(81, 'Clean cheater data', 'cheatclean_update.php', 1465910322, 86400, '9b0112ad44b0135220ef539804447d49', 1, 'Clean abnormal upload speed entrys', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cleanup_log`
--

CREATE TABLE IF NOT EXISTS `cleanup_log` (
  `clog_id` int(10) NOT NULL,
  `clog_event` char(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `clog_time` int(11) NOT NULL DEFAULT '0',
  `clog_ip` char(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `clog_desc` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coins`
--

CREATE TABLE IF NOT EXISTS `coins` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `torrentid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `points` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `torrent` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8,
  `ori_text` text CHARACTER SET utf8,
  `editedby` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `editedat` int(11) NOT NULL DEFAULT '0',
  `anonymous` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `request` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `offer` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edit_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_likes` text CHARACTER SET utf8,
  `checked_by` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `checked_when` int(11) NOT NULL DEFAULT '0',
  `checked` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `flagpic` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `flagpic`) VALUES
(1, 'Sweden', 'sweden.gif'),
(2, 'United States of America', 'usa.gif'),
(3, 'Russia', 'russia.gif'),
(4, 'Finland', 'finland.gif'),
(5, 'Canada', 'canada.gif'),
(6, 'France', 'france.gif'),
(7, 'Germany', 'germany.gif'),
(8, 'China', 'china.gif'),
(9, 'Italy', 'italy.gif'),
(10, 'Denmark', 'denmark.gif'),
(11, 'Norway', 'norway.gif'),
(12, 'United Kingdom', 'uk.gif'),
(13, 'Ireland', 'ireland.gif'),
(14, 'Poland', 'poland.gif'),
(15, 'Netherlands', 'netherlands.gif'),
(16, 'Belgium', 'belgium.gif'),
(17, 'Japan', 'japan.gif'),
(18, 'Brazil', 'brazil.gif'),
(19, 'Argentina', 'argentina.gif'),
(20, 'Australia', 'australia.gif'),
(21, 'New Zealand', 'newzealand.gif'),
(22, 'Spain', 'spain.gif'),
(23, 'Portugal', 'portugal.gif'),
(24, 'Mexico', 'mexico.gif'),
(25, 'Singapore', 'singapore.gif'),
(67, 'India', 'india.gif'),
(62, 'Albania', 'albania.gif'),
(26, 'South Africa', 'southafrica.gif'),
(27, 'South Korea', 'southkorea.gif'),
(28, 'Jamaica', 'jamaica.gif'),
(29, 'Luxembourg', 'luxembourg.gif'),
(30, 'Hong Kong', 'hongkong.gif'),
(31, 'Belize', 'belize.gif'),
(32, 'Algeria', 'algeria.gif'),
(33, 'Angola', 'angola.gif'),
(34, 'Austria', 'austria.gif'),
(35, 'Yugoslavia', 'yugoslavia.gif'),
(36, 'Western Samoa', 'westernsamoa.gif'),
(37, 'Malaysia', 'malaysia.gif'),
(38, 'Dominican Republic', 'dominicanrep.gif'),
(39, 'Greece', 'greece.gif'),
(40, 'Guatemala', 'guatemala.gif'),
(41, 'Israel', 'israel.gif'),
(42, 'Pakistan', 'pakistan.gif'),
(43, 'Czech Republic', 'czechrep.gif'),
(44, 'Serbia', 'serbia.gif'),
(45, 'Seychelles', 'seychelles.gif'),
(46, 'Taiwan', 'taiwan.gif'),
(47, 'Puerto Rico', 'puertorico.gif'),
(48, 'Chile', 'chile.gif'),
(49, 'Cuba', 'cuba.gif'),
(50, 'Congo', 'congo.gif'),
(51, 'Afghanistan', 'afghanistan.gif'),
(52, 'Turkey', 'turkey.gif'),
(53, 'Uzbekistan', 'uzbekistan.gif'),
(54, 'Switzerland', 'switzerland.gif'),
(55, 'Kiribati', 'kiribati.gif'),
(56, 'Philippines', 'philippines.gif'),
(57, 'Burkina Faso', 'burkinafaso.gif'),
(58, 'Nigeria', 'nigeria.gif'),
(59, 'Iceland', 'iceland.gif'),
(60, 'Nauru', 'nauru.gif'),
(61, 'Slovenia', 'slovenia.gif'),
(63, 'Turkmenistan', 'turkmenistan.gif'),
(64, 'Bosnia Herzegovina', 'bosniaherzegovina.gif'),
(65, 'Andorra', 'andorra.gif'),
(66, 'Lithuania', 'lithuania.gif'),
(68, 'Netherlands Antilles', 'nethantilles.gif'),
(69, 'Ukraine', 'ukraine.gif'),
(70, 'Venezuela', 'venezuela.gif'),
(71, 'Hungary', 'hungary.gif'),
(72, 'Romania', 'romania.gif'),
(73, 'Vanuatu', 'vanuatu.gif'),
(74, 'Vietnam', 'vietnam.gif'),
(75, 'Trinidad & Tobago', 'trinidadandtobago.gif'),
(76, 'Honduras', 'honduras.gif'),
(77, 'Kyrgyzstan', 'kyrgyzstan.gif'),
(78, 'Ecuador', 'ecuador.gif'),
(79, 'Bahamas', 'bahamas.gif'),
(80, 'Peru', 'peru.gif'),
(81, 'Cambodia', 'cambodia.gif'),
(82, 'Barbados', 'barbados.gif'),
(83, 'Bangladesh', 'bangladesh.gif'),
(84, 'Laos', 'laos.gif'),
(85, 'Uruguay', 'uruguay.gif'),
(86, 'Antigua Barbuda', 'antiguabarbuda.gif'),
(87, 'Paraguay', 'paraguay.gif'),
(89, 'Thailand', 'thailand.gif'),
(88, 'Union of Soviet Socialist Republics', 'ussr.gif'),
(90, 'Senegal', 'senegal.gif'),
(91, 'Togo', 'togo.gif'),
(92, 'North Korea', 'northkorea.gif'),
(93, 'Croatia', 'croatia.gif'),
(94, 'Estonia', 'estonia.gif'),
(95, 'Colombia', 'colombia.gif'),
(96, 'Lebanon', 'lebanon.gif'),
(97, 'Latvia', 'latvia.gif'),
(98, 'Costa Rica', 'costarica.gif'),
(99, 'Egypt', 'egypt.gif'),
(100, 'Bulgaria', 'bulgaria.gif'),
(101, 'Scotland', 'scotland.gif'),
(102, 'United Arab Emirates', 'uae.gif');

-- --------------------------------------------------------

--
-- Table structure for table `dbbackup`
--

CREATE TABLE IF NOT EXISTS `dbbackup` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `added` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deathrow`
--

CREATE TABLE IF NOT EXISTS `deathrow` (
  `uid` int(10) NOT NULL,
  `username` char(80) CHARACTER SET utf8 NOT NULL,
  `tid` int(10) NOT NULL,
  `torrent_name` char(140) CHARACTER SET utf8 NOT NULL,
  `reason` tinyint(1) NOT NULL,
  `notify` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `startTime` int(11) NOT NULL DEFAULT '0',
  `endTime` int(11) NOT NULL DEFAULT '0',
  `overlayText` text CHARACTER SET utf8,
  `displayDates` tinyint(1) NOT NULL,
  `freeleechEnabled` tinyint(1) NOT NULL,
  `duploadEnabled` tinyint(1) NOT NULL,
  `hdownEnabled` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `events` (`id`, `userid`, `startTime`, `endTime`, `overlayText`, `displayDates`, `freeleechEnabled`, `duploadEnabled`, `hdownEnabled`) VALUES
(1, 1, 1371323531, 1371582731, 'HalfDownload [ON]', 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `failedlogins`
--

CREATE TABLE IF NOT EXISTS `failedlogins` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `added` int(11) NOT NULL DEFAULT '0',
  `banned` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `attempts` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(3) NOT NULL,
  `type` int(3) NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `type`, `title`, `text`) VALUES
(1, 1, 'What is this bittorrent all about anyway? How do I get the files?', 'Check out BitTorrent From Wikipedia.'),
(2, 1, 'Where does the donated money go?', 'SITE_NAME is situated on a dedicated server in the Netherlands. For the moment we have monthly running costs of approximately &pound; 60.'),
(3, 1, 'Where can I get a copy of the source code?', 'SITE_NAME is an active open source project available for download via Github <a href=\'https://github.com/Bigjoos/U-232-V4\' class=\'altlink\'>Zip download</a> or directly from the support forum <a href=\'http://forum-u-232.servebeer.com/index.php?action=downloads;cat=1\' class=\'altlink\'>Zip downloads</a>. Please note: We do not give any kind of support on the source code so please don\'t bug us about it. If it works, great, if not too bad. Use this software at your own risk!'),
(4, 2, 'I registered an account but did not receive the confirmation e-mail!', 'You can contact site staff with your request on irc.'),
(5, 2, 'I\'ve lost my user name or password! Can you send it to me?', 'Please use <a class=\'altlink\' href=\'recover.php\'>this form</a> to have the login details mailed back to you.'),
(6, 2, 'Can you rename my account?', 'We do not rename accounts. Please create a new one. You can contact site staff with your request.'),
(7, 2, 'Can you delete my (confirmed) account?', 'You can contact site staff with your request.'),
(8, 2, 'So, what\'s MY ratio?', 'Click on your <a class=\'altlink\' href=\'usercp.php?action=default\'>profile</a>, then on your user name (at the top).<br /><br />It\'s important to distinguish between your overall ratio and the individual ratio on each torrent you may be seeding or leeching. The overall ratio takes into account the total uploaded and downloaded from your account since you joined the site. The individual ratio takes into account those values for each torrent.<br /><br />You may see two symbols instead of a number: &quot;Inf.&quot;, which is just an abbreviation for Infinity, and means that you have downloaded 0 bytes while uploading a non-zero amount (ul/dl becomes infinity); &quot;---&quot;, which should be read as &quot;non-available&quot;, and shows up when you have both downloaded and uploaded 0 bytes (ul/dl = 0/0 which is an indeterminate amount).'),
(9, 2, 'Why is my IP displayed on my details page?', 'Only you and the site moderators can view your IP address and email. Regular users do not see that information.'),
(10, 2, 'Help! I cannot login! Page just reloads?', 'This problem sometimes occurs with MSIE. Close all Internet Explorer windows and open Internet Options in the control panel. Click the Delete Cookies button. You should now be able to login.'),
(11, 2, 'My IP address is dynamic. How do I stay logged in?', 'You do not have to anymore. All you have to do is make sure you are logged in with your actual IP when starting a torrent session. After that, even if the IP changes mid-session, the seeding or leeching will continue and the statistics will update without any problem.'),
(12, 2, 'Why am I listed as not connectable? (And why should I care?)', 'The tracker has determined that you are firewalled or NATed and cannot accept incoming connections.<br /> This means that other peers in the swarm will be unable to connect to you, only you to them. Even worse, if two peers are both in this state they will not be able to connect at all. This has obviously a detrimental effect on the overall speed.<br /> The way to solve the problem involves opening the ports used for incoming connections (the same range you defined in your client) on the firewall and/or configuring your NAT server to use a basic form of NAT for that range instead of NAPT (the actual process differs widely between different router models. Check your router documentation and/or support forum. You will also find lots of information on the subject at PortForward).'),
(13, 2, ' What are the different user classes?', '<div class=\'col-md-6\'><table class=\'table table-bordered table-striped\' cellspacing=\'3\' cellpadding=\'0\'><tr>\r\n <td class=\'embedded\' width=\'100\'>&nbsp;<b>User</b></td>\r\n      <td class=\'embedded\'>The default class of new members.</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'>&nbsp;<b>Power User</b></td>\r\n      <td class=\'embedded\'>Can download DOX over 1MB and view NFO files.</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'>&nbsp;<img src=\'SITE_PIC_URL/star.gif\' alt=\'Star\' /></td>\r\n      <td class=\'embedded\'>Has donated money to SITE_NAME.</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\' valign=\'top\'>&nbsp;<b>VIP</b></td>\r\n      <td class=\'embedded\' valign=\'top\'>Same privileges as Power User and is considered an Elite Member of SITE_NAME. Immune to automatic demotion.</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'>&nbsp;<b>Other</b></td>\r\n       <td class=\'embedded\'>Customised title.</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'>&nbsp;<b><font color=\'#4040c0\'>Uploader</font></b></td>\r\n      <td class=\'embedded\'>Same as PU except with upload rights and immune to automatic demotion.</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\' valign=\'top\'>&nbsp;<b><font color=\'#A83838\'>Moderator</font></b></td>\r\n      <td class=\'embedded\' valign=\'top\'>Can edit and delete any uploaded torrents. Can also moderate user comments and disable accounts.</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'>&nbsp;<b><font color=\'#A83838\'>Administrator</font></b></td>\r\n      <td class=\'embedded\'>Can do just about anything.</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'>&nbsp;<b><font color=\'#A83838\'>SysOp</font></b></td>\r\n      <td class=\'embedded\'>Runs the site and is the highest staff class</td>\r\n    </tr>\r\n    </table></div>\r\n'),
(14, 2, 'How does this promotion thing work anyway?', '<div class=\'col-md-6\' style=\'margin-top:-1.5%;\'>\r\n     <table class=\'table table-bordered table-striped\'><tr>\r\n      <td class=\'embedded\' valign=\'top\' width=\'100\'>&nbsp;<b>Power User</b></td>\r\n      <td class=\'embedded\' valign=\'top\'>Must have been be a member for at least 4 weeks, have uploaded at least 25GB and have a ratio at or above 1.05. The promotion is automatic when these conditions are met. Note that you will be automatically demoted from this status if your ratio drops below 0.95 at any time.</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'>&nbsp; <img src=\'SITE_PIC_URL/star.gif\' alt=\'Star\' /></td>\r\n      <td class=\'embedded\'>Just donate, and send <a class=\'altlink\' href=\'pm_system.php?action=send_message&amp;receiver=1\'>Sysop</a> - and only sysop - the details.</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'valign=\'top\'>&nbsp;<b>VIP</b></td>\r\n      <td class=\'embedded\' valign=\'top\'>Assigned by mods at their discretion to users they feel contribute something special to the site.(Anyone begging for VIP status will be automatically disqualified.)</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'>&nbsp;<b>Other</b></td>\r\n      <td class=\'embedded\'>Conferred by mods at their discretion (not available to Users or Power Users).</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'>&nbsp;<b><font color=\'#4040c0\'>Uploader</font></b></td>\r\n      <td class=\'embedded\'>Appointed by Admins/SysOp (see the \'Uploading\' section for conditions).</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\'embedded\'>&nbsp;<b><font color=\'#A83838\'>Moderator</font></b></td>\r\n      <td class=\'embedded\'>You don\'t ask us, we\'ll ask you!</td>\r\n    </tr>\r\n    </table></div>'),
(15, 2, 'Hey! I\'ve seen Power Users with less than 25GB uploaded!', 'The PU limit used to be 10GB and we didn\'t demote anyone when we raised it to 25GB.'),
(16, 2, 'Why can\'t my friend become a member?', 'There is a 75.000 users limit. When that number is reached we stop accepting new members. Accounts inactive for more than 42 days are automatically deleted, so keep trying.(There is no reservation or queuing system, don\'t ask for that.)'),
(17, 3, 'Most common reason for stats not updating', '<ul>\n<li>The user is cheating. (a.k.a. "Summary Ban")</li>\n<li>The server is overloaded and unresponsive. Just try to keep the session open until the server responds again. (Flooding the server with consecutive manual updates is not recommended.)</li>\n<li>You are using a faulty client. If you want to use an experimental or CVS version you do it at your own risk.</li>\n</ul>'),
(18, 3, 'Best practices', '<ul>\r\n<li>If a torrent you are currently leeching/seeding is not listed on your profile, just wait or force a manual update.</li>\r\n<li>Make sure you exit your client properly, so that the tracker receives &quot;event=completed&quot;.</li>\r\n<li>If the tracker is down, do not stop seeding. As long as the tracker is back up before you exit the client the stats should update properly.</li>\r\n</ul>\r\n'),
(19, 3, 'May I use any bittorrent client?', ' Yes. The tracker now updates the stats correctly for all bittorrent clients. However, we still recommend that you <b>avoid</b> the following clients:\r\n<br /><br />\r\n<ul>\r\n<li>BitTorrent++</li>\r\n<li>Nova Torrent</li>\r\n<li>TorrentStorm.</li>\r\n</ul>\r\n<br />\r\nThese clients do not report correctly to the tracker when cancelling or finishing a torrent session. If you use them then a few MB may not be counted towards the stats near the end, and torrents may still be listed in your profile for some time after you have closed the client. Also, clients in alpha or beta version should be avoided.'),
(20, 3, 'Why is a torrent I\'m leeching/seeding listed several times in my profile?', 'If for some reason (e.g. pc crash, or frozen client) your client exits improperly and you restart it, it will have a new peer_id, so it will show as a new torrent. The old one will never receive a &quot;event=completed&quot; or &quot;event=stopped&quot; and will be listed until the tracker dead peers cleanup runs. Just ignore as it will eventually be updated by the tracker.\r\n    '),
(21, 3, 'I\'ve finished or cancelled a torrent. Why is it still listed in my profile?', 'Some clients, notably TorrentStorm and Nova Torrent, do not report properly to the tracker when cancelling or finishing a torrent. In that case the tracker will keep waiting for some message - and thus listing the torrent as seeding or leeching - until some peers update occurs. Just ignore as it will eventually be updated by the tracker.'),
(22, 3, 'Why do I sometimes see torrents I\'m not leeching in my profile!?', ' When a torrent is first started, the tracker uses the IP to identify the user. Therefore the torrent will become associated with the user <i>who last accessed the site</i> from that IP. If you share your IP in some way (you are behind NAT/ICS, or using a proxy), and some of the persons you share it with are also users, you may occasionally see their torrents listed in your profile. (If they start a torrent session from that IP and you were the last one to visit the site the torrent will be associated with you). Note that now torrents listed in your profile will always count towards your total stats. To make sure your torrents show up in your profile you should visit the site immediately before starting a session. The only way to completely stop foreign torrents from showing in profiles is to forbid users without an individual IP from accessing the site. Yes, that means you. Complain at your own risk.\r\n'),
(23, 3, 'Multiple IPs (Can I login from different computers?)', 'Yes, the tracker is now capable of following sessions from different IPs for the same user. A torrent is associated with the user when it starts, and only at that moment is the IP relevant. So if you want to seed/leech from computer A and computer B with the same account you should access the site from computer A, start the torrent there, and then repeat both steps from computer B (not limited to two computers or to a single torrent on each, this is just the simplest example). You do not need to login again when closing the torrent.\r\n'),
(24, 3, 'How does NAT/ICS change the picture?', 'This is a very particular case in that all computers in the LAN will appear to the outside world as having the same IP. We must distinguish between two cases:\r\n<br />\r\n<b>1.</b><i>You are the single SITE_NAME users in the LAN</i>\r\n<br />\r\nYou should use the same SITE_NAME account in all the computers.\r\n<br />\r\nNote also that in the ICS case it is preferable to run the BT client on the ICS gateway. Clients running on the other computers will be unconnectable (they will be listed as such, as explained elsewhere in the FAQ) unless you specify the appropriate services in your ICS configuration (a good explanation of how to do this for Windows XP can be found <a class=\'altlink\' href=\'http://www.microsoft.com/downloads/details.aspx?FamilyID=1dcff3ce-f50f-4a34-ae67-cac31ccd7bc9&amp;displaylang=en\'>here</a>).\r\nIn the NAT case you should configure different ranges for clients on different computers and create appropriate NAT rules in the router. (Details vary widely from router to router and are outside the scope of this FAQ. Check your router documentation and/or support forum.)\r\n<br />\r\n<br />\r\n<b>2.</b> <i>There are multiple SITE_NAME users in the LAN</i><br>\r\nAt present there is no way of making this setup always work properly with SITE_NAME. Each torrent will be associated with the user who last accessed the site from within the LAN before the torrent was started. Unless there is cooperation between the users mixing of statistics is possible. (User A accesses the site, downloads a .torrent file, but does not start the torrent immediately. Meanwhile, user B accesses the site. User A then starts the torrent. The torrent will count towards user B\'s statistics, not user A\'s.) It is your LAN, the responsibility is yours. Do not ask us to ban other users with the same IP, we will not do that. (Why should we ban <i>him</i> instead of <i>you</i>?)'),
(25, 3, 'For those of you who are interested...', 'Some pish here :)\r\n'),
(26, 4, 'Why can\'t I upload torrents?', 'Only specially authorized users <font color=\'#4040C0\'><b>Uploaders</b></font> have permission to upload torrents.'),
(27, 4, 'What criteria must I meet before I can join the <font color=\'#4040C0\'>Uploader</font> team?', 'You must be able to provide releases that:\r\n<br />\r\n<ul>\r\n<li>Include a proper NFO</li>\r\n<li>Are genuine scene releases</li>\r\n<li>Are not older than seven (7) days</li>\r\n<li>Have all files in original format (usually 14.3 MB RARs)</li>\r\n<li>You\'ll be able to seed, or make sure are well-seeded, for at least 24 hours</li>\r\n<li>Also, you should have at least 2MBit upload bandwith.</li></ul><br />\r\nIf you think you can match these criteria do not hesitate to <a class=\'altlink\' href=\'./staff.php\'>contact</a> one of the administrators.<br />\r\n<b>Remember!</b><br /> Write your application carefully! Be sure to include your UL speed and what kind of stuff you\'re planning to upload. Only well written letters with serious intent will be considered.'),
(28, 4, 'Can I upload your torrents to other trackers?', 'No. We are a closed, limited-membership private community. Only registered users can use the tracker. Posting our torrents on other trackers is useless, since most people who attempt to download them will not be unable to connect with us. This generates a lot of frustration and bad-will against us at SITE_NAME and will not be tolerated. Complaints from other \'sites\' administrative staff about our torrents being posted on their sites will result in the banning of the users responsible (However, the files you download from us are yours to do as you please. You can always create another torrent, pointing to some other tracker, and upload it to the site of your choice.)'),
(29, 5, 'How do I use the files I\'ve downloaded?', 'Check out <a class=\'altlink\' href=\'formats.php\'>this guide</a>.'),
(30, 5, 'Downloaded a movie and don\'t know what CAM/TS/TC/SCR means?', 'Check out <a class=\'altlink\' href=\'videoformats.php\'>this guide</a>.<br>\n'),
(31, 5, 'Why did an active torrent suddenly disappear?', 'There may be three reasons for this:<br />\r\n(<b>1</b>) The torrent may have been out-of-sync with the site <a class=\'altlink\' href=\'./rules.php\'>rules</a>.<br /> (<b>2</b>) The uploader may have deleted it because it was a bad release. A replacement will probably be uploaded to take its place.<br />\r\n(<b>3</b>) Torrents are automatically deleted after 30 days of inactivity.\r\n'),
(32, 5, 'How do I resume a broken download or reseed something?', 'Open the .torrent file. When your client asks you for a location, choose the location of the existing file(s) and it will resume/reseed the torrent.'),
(33, 5, 'Why do my downloads sometimes stall at 99%?', 'The more pieces you have, the harder it becomes to find peers who have pieces you are missing. That is why downloads sometimes slow down or even stall when there are just a few percent remaining. Just be patient and you will, sooner or later, get the remaining pieces.\r\n'),
(34, 5, 'What are these &quot;a piece has failed an hash check&quot; messages?', 'Bittorrent clients check the data they receive for integrity. When a piece fails this check it is automatically re-downloaded. Occasional hash fails are a common occurrence, and you shouldn\'t worry. Some clients have an (advanced) option/preference to \'kick/ban clients that send you bad data\' or similar. It should be turned on, since it makes sure that if a peer repeatedly sends you pieces that fail the hash check it will be ignored in the future.'),
(35, 5, 'The torrent is supposed to be 100MB. How come I downloaded 120MB?', 'See the hash fails topic. If your client receives bad data it will have to re-download it, therefore the total downloaded may be larger than the torrent size. Make sure the &quot;kick/ban&quot; option is turned on to minimize the extra downloads.\r\n'),
(36, 5, 'Why do I get a "Not authorized (xx h) - READ THE FAQ!" error?', 'From the time that each <b>new</b> torrent is uploaded to the tracker, there is a period of time that some users must wait before they can download it.<br />\r\nThis delay in downloading will only affect users with a low ratio, and users with low upload amounts.<br />\r\n<div class=\'col-md-5\'><table class=\'table table-bordered table-striped\' cellspacing=\'3\' cellpadding=\'0\'>\r\n     <tr>\r\n      <td class=\'embedded\' width=\'70\'>Ratio below</td>\r\n      <td class=\'embedded\' width=\'40\'><div align=\'center\'><font color=\'#BB0000\'>0.50</font></div></td>\r\n      <td class=\'embedded\' width=\'110\'>and/or upload below</td>\r\n      <td class=\'embedded\' width=\'40\'><div align=\'center\'>5.0GB</div></td>\r\n      <td class=\'embedded\' width=\'50\'>delay of</td>\r\n      <td class=\'embedded\' width=\'40\'><div align=\'center\'>48h</div></td>\r\n     </tr>\r\n     <tr>\r\n      <td class=\'embedded\'>Ratio below</td>\r\n      <td class=\'embedded\'><div align=\'center\'><font color=\'#A10000\'>0.65</font></div></td>\r\n      <td class=\'embedded\'>and/or upload below</td>\r\n      <td class=\'embedded\'><div align=\'center\'>6.5GB</div></td>\r\n      <td class=\'embedded\'>delay of</td>\r\n      <td class=\'embedded\'><div align=\'center\'>24h</div></td>\r\n     </tr>\r\n     <tr>\r\n      <td class=\'embedded\'>Ratio below</td>\r\n      <td class=\'embedded\'><div align=\'center\'><font color=\'#880000\'>0.80</font></div></td>\r\n      <td class=\'embedded\'>and/or upload below</td>\r\n      <td class=\'embedded\'><div align=\'center\'>8.0GB</div></td>\r\n      <td class=\'embedded\'>delay of</td>\r\n      <td class=\'embedded\'><div align=\'center\'>12h</div></td>\r\n     </tr>\r\n     <tr>\r\n      <td class=\'embedded\'>Ratio below</td>\r\n      <td class=\'embedded\'><div align=\'center\'><font color=\'#6E0000\'>0.95</font></div></td>\r\n      <td class=\'embedded\'>and/or upload below</td>\r\n      <td class=\'embedded\'><div align=\'center\'>9.5GB</div></td>\r\n      <td class=\'embedded\'>delay of</td>\r\n      <td class=\'embedded><div align=\'center\'>06h</div></td>\r\n     </tr>\r\n    </table></div>'),
(37, 5, 'Why do I get a &quot;rejected by tracker - Port xxxx is blacklisted&quot; error?', 'Your client is reporting to the tracker that it uses one of the default bittorrent ports (6881-6889) or any other common p2p port for incoming connections. SITE_NAME does not allow clients to use ports commonly associated with p2p protocols. The reason for this is that it is a common practice for ISPs to throttle those ports (that is, limit the bandwidth, hence the speed). The blocked ports list include, but is not necessarily limited to, the following:\r\n<br />\r\n<table class=\'table table-bordered table-striped\' cellspacing=\'3\' cellpadding=\'0\'>\r\n      <tr>\r\n      <td class=\'embedded\' width=\'80\'>Direct Connect</td>\r\n      <td class=\'embedded\' width=\'80\'><div align=\'center\'>411 - 413</div></td>\r\n      </tr>\r\n      <tr>\r\n      <td class=\'embedded\' width=\'80\'>Kazaa</td>\r\n      <td class=\'embedded\' width=\'80\'><div align=\'center\'>1214</div></td>\r\n      </tr>\r\n      <tr>\r\n      <td class=\'embedded\' width=\'80\'>eDonkey</td>\r\n      <td class=\'embedded\' width=\'80\'><div align=\'center\'>4662</div></td>\r\n      </tr>\r\n      <tr>\r\n      <td class=\'embedded\' width=\'80\'>Gnutella</td>\r\n      <td class=\'embedded\' width=\'80\'><div align=\'center\'>6346 - 6347</div></td>\r\n      </tr>\r\n      <tr>\r\n      <td class=\'embedded\' width=\'80\'>BitTorrent</td>\r\n      <td class=\'embedded\' width=\'80\'><div align=\'center\'>6881 - 6889</div></td>\r\n     </tr>\r\n    </table>\r\n<br />\r\nIn order to use use our tracker you must  configure your client to use any port range that does not contain those ports (a range within the region 49152 through 65535 is preferable, ref, <a class=\'altlink\' href=\'http://www.iana.org/assignments/port-numbers\'>IANA</a>). Notice that some clients, like Azureus 2.0.7.0 or higher, use a single port for all torrents, while most others use one port per open torrent. The size of the range you choose should take this into account (typically less than 10 ports wide. There is no benefit whatsoever in choosing a wide range, and there are possible security implications). These ports are used for connections between peers, not client to tracker. Therefore this change will not interfere with your ability to use other trackers (in fact it should <i>increase</i> your speed with torrents from any tracker, not just ours). Your client will also still be able to connect to peers that are using the standard ports. If your client does not allow custom ports to be used, you will have to switch to one that does. Do not ask us, or in the forums, which ports you should choose. The more random the choice is the harder it will be for ISPs to catch on to us and start limiting speeds on the ports we use. If we simply define another range ISPs will start throttling that range also. Finally, remember to forward the chosen ports in your router and/or open them in your firewall, should you have them. See the&nbsp;<i>Why am I listed as not connectable?</i> &nbsp;section for more information on this.'),
(38, 5, 'What\'s this \'IOError - [Errno13] Permission denied\' error?', 'If you just want to fix it reboot your computer, it should solve the problem.\r\nOtherwise read on.<br /><br />\r\nIOError means Input-Output Error, and that is a file system error, not a tracker one. It shows up when your client is for some reason unable to open the partially downloaded torrent files. The most common cause is two instances of the client to be running simultaneously: the last time the client was closed it somehow didn\'t really close but kept running in the background, and is therefore still locking the files, making it impossible for the new instance to open them.<br />\r\nA more uncommon occurrence is a corrupted FAT. A crash may result in corruption that makes the partially downloaded files unreadable, and the error ensues. Running scandisk should solve the problem. (Note that this may happen only if you\'re running Windows 9x - which only support FAT - or NT/2000/XP with FAT formatted hard drives. NTFS is much more robust and should never permit this problem.)\r\n'),
(39, 5, 'What\'s this &quot;TTL&quot; in the browse page?', 'The torrent\'s Time To Live, in hours. It means the torrent will be deleted from the tracker after that many hours have elapsed (yes, even if it is still active). Note that this a maximum value, the torrent may be deleted at any time if it\'s inactive.'),
(40, 6, 'How can I improve my download speed?', 'The download speed mostly depends on the seeder-to-leecher ratio (SLR). Poor download speed is mainly a problem with new and very popular torrents where the SLR is low. (Proselytising side-note: make sure you remember that you did not enjoy the low speed. <b>Seed</b> so that others will not endure the same.) There are a couple of things that you can try on your end to improve your speed:<br />\r\n<ul><li><b>Do not immediately jump on new torrents</b></li>\r\nIn particular, do not do it if you have a slow connection. The best speeds will be found around the half-life of a torrent, when the SLR will be at its highest. (The downside is that you will not be able to seed so much. It\'s up to you to balance the pros and cons of this.)<br />\r\n<li><b>Make yourself connectable</b> </li></ul><br />\r\nSee the "Why am I listed as not connectable?</i>&nbsp;section.'),
(41, 6, 'Limit your upload speed', 'The upload speed affects the download speed in essentially two ways:<br />\r\n<ul>\r\n<li>Bittorrent peers tend to favour those other peers that upload to them. This means that if A and B are leeching the same torrent and A is sending data to B at high speed then B will try to reciprocate. So due to this effect high upload speeds lead to high download speeds.</li>\r\n<li>Due to the way TCP works, when A is downloading something from B it has to keep telling B that it received the data sent to him. (These are called acknowledgements - ACKs -, a sort of &quot;got it!&quot; messages). If A fails to do this then B will stop sending data and wait. If A is uploading at full speed there may be no bandwidth left for the ACKs and they will be delayed. So due to this effect excessively high upload speeds lead to low download speeds.</li>\r\n</ul>\r\nThe full effect is a combination of the two. The upload should be kept as high as possible while allowing the ACKs to get through without delay. <b>A good thumb rule is keeping the upload at about 80% of the theoretical upload speed.</b> You will have to fine tune yours to find out what works best for you. (Remember that keeping the upload high has the additional benefit of helping with your ratio.)<br /><br /> \r\nIf you are running more than one instance of a client it is the overall upload speed that you must take into account. Some clients (e.g. Azureus) limit global upload speed, others (e.g. Shad0w\'s) do it on a per torrent basis. Know your client. The same applies if you are using your connection for anything else (e.g. browsing or ftp), always think of the overall upload speed.'),
(42, 6, 'Limit the number of simultaneous connections', 'Some operating systems (like Windows 9x) do not deal well with a large number of connections, and may even crash. Also some home routers (particularly when running NAT and/or firewall with stateful inspection services) tend to become slow or crash when having to deal with too many connections. There are no fixed values for this, you may try 60 or 100 and experiment with the value. Note that these numbers are additive, if you have two instances of a client running the numbers add up.\r\n'),
(43, 6, 'Limit the number of simultaneous uploads', 'Isn\'t this the same as above? No. Connections limit the number of peers your client is talking to and/or downloading from. Uploads limit the number of peers your client is actually uploading to. The ideal number is typically much lower than the number of connections, and highly dependent on your (physical) connection.'),
(44, 6, 'Just give it some time', 'As explained above peers favour other peers that upload to them. When you start leeching a new torrent you have nothing to offer to other peers and they will tend to ignore you. This makes the starts slow, in particular if,by change, the peers you are connected to include few or no seeders. The download speed should increase as soon as you have some pieces to share.\r\n'),
(45, 6, 'Why is my browsing so slow while leeching?', 'Your download speed is always finite. If you are a peer in a fast torrent it will almost certainly saturate your download bandwidth, and your browsing will suffer. At the moment there is no client that allows you to limit the download speed, only the upload. You will have to use a third-party solution, such as <a class=\'altlink\' href=\'http://www.netlimiter.com/\'>NetLimiter</a>. Browsing was used just as an example, the same would apply to gaming etc.'),
(46, 7, 'My ISP uses a transparent proxy. What should I do?', '<i>Caveat: This is a large and complex topic. It is not possible to cover all variations here.</i>< Short reply: change to an ISP that does not force a proxy upon you. If you cannot or do not want to then read on.\r\n'),
(47, 7, 'What is a proxy?', 'Basically a middleman. When you are browsing a site through a proxy your requests are sent to the proxy and the proxy forwards them to the site instead of you connecting directly to the site. There are several classifications\r\n(the terminology is far from standard):<br /><br /><table class=\'table table-bordered table-striped\'><tr><td class=\'embedded\' valign=\'top\'width=\'100\'>&nbsp;Transparent</td><td class=\'embedded\' valign=\'top\'>A transparent proxy is one that needs no configuration on the clients. It works by automatically redirecting all port 80 traffic to the proxy. (Sometimes used as synonymous for non-anonymous.)</td></tr>\r\n<tr><td class=\'embedded\' valign=\'top\'>&nbsp;Explicit/Voluntary</td><td class=\'embedded\' valign=\'top\'>Clients must configure their browsers to use them.</td></tr>\r\n<tr>\r\n<td class=\'embedded\' valign=\'top\'>&nbsp;Anonymous</td>\r\n<td class=\'embedded\' valign=\'top\'>The proxy sends no client identification to the server. (HTTP_X_FORWARDED_FOR header is not sent; the server does not see your IP.)</td></tr>\r\n<tr>\r\n<td class=\'embedded\' valign=\'top\'>&nbsp;Highly Anonymous</td>\r\n<td class=\'embedded\' valign=\'top\'>The proxy sends no client nor proxy identification to the server. (HTTP_X_FORWARDED_FOR, HTTP_VIA and HTTP_PROXY_CONNECTION headers are not sent; the server doesn\'t see your IP and doesn\'t even know you\'re using a proxy.)</td></tr>\r\n<tr>\r\n<td class=\'embedded\' valign=\'top\'>&nbsp;Public</td><td class=\'embedded\' valign=\'top\'>(Self explanatory)</td>\r\n</tr>\r\n</table><br />\r\nA transparent proxy may or may not be anonymous, and there are several levels of anonymity.'),
(48, 7, 'How do I find out if I\'m behind a (transparent/anonymous) proxy?', 'Try <a href=\'http://proxyjudge.info\' class=\'altlink\'>ProxyJudge</a>. It lists the HTTP headers that the server where it is running received from you. The relevant ones are HTTP_CLIENT_IP, HTTP_X_FORWARDED_FOR and REMOTE_ADDR.\r\n'),
(49, 7, 'Why am I listed as not connectable even though I\'m not NAT/Firewalled?', 'The SITE_NAME tracker is quite smart at finding your real IP, but it does need the proxy to send the HTTP header HTTP_X_FORWARDED_FOR. If your ISP\'s proxy does not then what happens is that the tracker will interpret the proxy\'s IP address as the client\'s IP address. So when you login and the tracker tries to connect to your client to see if you are NAT/firewalled it will actually try to connect to the proxy on the port your client reports to be using for incoming connections. Naturally the proxy will not be listening on that port, the connection will fail and tracker will think you are NAT/firewalled.\r\n'),
(50, 7, 'Can I bypass my ISP\'s proxy?', 'If your ISP only allows HTTP traffic through port 80 or blocks the usual proxy ports then you would need to use something like <a href=\'http://socks-permeo.software.filedudes.com/\'>socks</a> and that is outside the scope of this FAQ.<br /><br />\r\nThe site accepts connections on port 81 besides the usual 80, and using them may be enough to fool some proxies. So the first thing to try should be connecting to BASE_URL:81. Note that even if this works your bt client will still try to connect to port 80 unless you edit the announce url in the .torrent file. Otherwise you may try the following:\r\n<br />\r\n<ul>\r\n<li>Choose any public <b>non-anonymous</b> proxy that does <b>not</b> use port 80 (e.g. from <a href=\'http://tools.rosinstrument.com/proxy/?rule1\' class=\'altlink\'>this</a>, <a href=\'http://www.proxy4free.com/index.html\' class=\'altlink\'>this</a> or <a href=\'http://www.samair.ru/proxy/\' class=\'altlink\'>this</a> list).</li>\r\n<li>Configure your computer to use that proxy. For Windows XP, do <i>Start</i>, <i>Control Panel</i>, <i>Internet Options</i>, <i>Connections</i>, <i>LAN Settings</i>, <i>Use a Proxy server</i>, <i>Advanced</i> and type in the IP and port of your chosen proxy. Or from Internet Explorer use <i>Tools</i>, <i>Internet Options</i>, ...<br /></li><li>Visit <a href=\'http://proxyjudge.info\' class=\'altlink\'>ProxyJudge</a>. If you see an HTTP_X_FORWARDED_FOR in the list followed by your IP then everything should be ok, otherwise choose another proxy and try again.<br /></li><li>Visit SITE_NAME. Hopefully the tracker will now pickup your real IP (check your profile to make sure).</li>\r\n</ul>\r\n<br />\r\nNotice that now you will be doing all your browsing through a public proxy, which are typically quite slow. Communications between peers do not use port 80 so their speed will not be affected by this, and should be better than when you were &quot;unconnectable&quot;.\r\n'),
(51, 7, 'How do I make my bittorrent client use a proxy?', 'Just configure Windows XP as above. When you configure a proxy for Internet Explorer you\'re actually configuring a proxy for all HTTP traffic (thank Microsoft and their &quot;IE as part of the OS policy&quot; ). On the other hand if you use another browser (Opera/Mozilla/Firefox) and configure a proxy there you\'ll be configuring a proxy just for that browser. We don\'t know of any BT client that allows a proxy to be specified explicitly.\r\n'),
(52, 7, 'Why can\'t I signup from behind a proxy?', 'It is our policy not to allow new accounts to be opened from behind a proxy.\r\n'),
(53, 7, 'Does this apply to other torrent sites?', 'This section was written for SITE_NAME, a closed, port 80-81 tracker. Other trackers may be open or closed, and many listen on e.g. ports 6868 or 6969. The above does <b>not</b> necessarily apply to other trackers.'),
(54, 8, 'Why can\'t I connect? Is the site blocking me?', 'Your failure to connect may be due to several reasons.'),
(55, 8, 'Maybe my address is blacklisted?', 'The site blocks addresses of banned users. This works at Apache/PHP level, it\'s just a script that blocks <i>logins</i> from those addresses. It should not stop you from reaching the site. In particular it does not block lower level protocols, you should be able to ping/traceroute the server even if your address is blacklisted. If you cannot then the reason for the problem lies elsewhere.'),
(56, 8, 'Your ISP blocks the site\'s address', 'Uk ISP\'s are now actively blocking access to well know sites but that will always be countered using https and new domains. You should contact your ISP (or get a new one). Note that you can still visit the site via a proxy, follow the instructions in the relevant section. In this case it doesn\'t matter if the proxy is anonymous or not, or which port it listens to.\r\n<br /><br />\r\nNotice that you will always be listed as an &quot;unconnectable&quot; client because the tracker will be unable to check that you\'re capable of accepting incoming connections.\r\n'),
(57, 8, 'Alternate port (81)', 'Some of our torrents use ports other than the usual HTTP port 80. This may cause problems for some users, for instance those behind some firewall or proxy configurations. You can easily solve this by editing the .torrent file yourself with any torrent editor, e.g. <a href=\'http://sourceforge.net/projects/burst/\' class=\'altlink\'>MakeTorrent</a>,\r\nand replacing the announce url BASE_URL:81 with SITE_NAME:80 or just SITE_NAME. Editing the .torrent with Notepad is not recommended. It may look like a text file, but it is in fact a bencoded file. If for some reason you must use a plain text editor, change the announce url to SITE_NAME:80, not SITE_NAME. (If you\'re thinking about changing the number before the announce url instead, you know too much to be reading this.)\r\n'),
(58, 9, 'What if I can\'t find the answer to my problem here?', 'Post in the <a class=\'altlink\' href=\'./forums.php\'>Forums</a>, by all means. You\'ll find they are usually a friendly and helpful place, provided you follow a few basic guidelines:\r\n<ul>\r\n<li>Make sure your problem is not really in this FAQ. There\'s no point in posting just to be sent back here.</li>\r\n<li>Before posting read the sticky topics (the ones at the top). Many times new information that still hasn\'t been incorporated in the FAQ can be found there.</li>\r\n<li>Help us in helping you. Do not just say \'it doesn\'t work!\'. Provide details so that we don\'t have to guess or waste time asking. What client do you use? What\'s your OS? What\'s your network setup? What\'s the exact error message you get, if any? What are the torrents you are having problems with? The more you tell the easier it will be for us, and the more probable your post will get a reply.</li>\r\n<li>And needless to say: be polite. Demanding help rarely works, asking for it usually does  the trick.</li>');

-- --------------------------------------------------------

--
-- Table structure for table `faq_cat`
--

CREATE TABLE IF NOT EXISTS `faq_cat` (
  `id` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shortcut` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `min_view` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq_cat`
--

INSERT INTO `faq_cat` (`id`, `name`, `shortcut`, `min_view`) VALUES
(1, 'Site information', 'site', 0),
(2, 'User information', 'user', 0),
(3, 'Stats', 'stats', 0),
(4, 'Uploading', 'upload', 3),
(5, 'Downloading', 'download', 0),
(6, 'Improve Download Speed', 'speed', 0),
(7, 'ISP Proxy Issue', 'isp', 0),
(8, 'Connection Problems', 'connect', 0),
(9, 'Can\'t Find Answer?', 'answer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `torrent` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `filename` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `post_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `topic_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `min_class_read` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `min_class_write` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `min_class_create` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `place` int(10) NOT NULL DEFAULT '-1',
  `parent_forum` tinyint(4) NOT NULL DEFAULT '0',
  `forum_id` tinyint(4) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `freeleech`
--

CREATE TABLE IF NOT EXISTS `freeleech` (
  `id` int(5) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `var` int(10) NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8,
  `type` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `amount` bigint(20) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `freeleech`
--

INSERT INTO `freeleech` (`id`, `name`, `var`, `description`, `type`, `amount`) VALUES
(1, 'Contribute 1 to Site Countdown Pot', 1, 'Donate 1 coin and 1 minute will be removed from the Countdown.', 'contribute', 60),
(2, 'Contribute 5 to Site Countdown Pot', 5, 'Donate 5 coins and 5 minutes will be removed from the Countdown.', 'contribute', 300),
(3, 'Contribute 10 to Site Countdown Pot', 10, 'Donate 10 coins and 10 minutes will be removed from the Countdown.', 'contribute', 600),
(4, 'Contribute 25 to Site Countdown Pot', 25, 'Donate 25 coins and 25 minutes will be removed from the Countdown.', 'contribute', 1500),
(5, 'Contribute 50 to Site Countdown Pot', 50, 'Donate 50 coins and 50 minutes will be removed from the Countdown.', 'contribute', 3000),
(6, 'Contribute 100 to Site Countdown Pot', 100, 'Donate 100 coins and 1 hour and 40 minutes will be removed from the Countdown.', 'contribute', 6000),
(7, 'Contribute 500 to Site Countdown Pot', 500, 'Donate 500 coins and 8 hours and 20 minutes will be removed from the Countdown.', 'contribute', 30000),
(8, 'Contribute 1000 to Site Countdown Pot', 1000, 'Donate 1000 coins and 16 hours and 40 minutes will be removed from the Countdown.', 'contribute', 60000),
(9, 'Contribute to Site Countdown Pot', 0, 'Enter a custom amount to donate. ', 'contribut3', 0),
(10, 'Freeleech', 0, 'Freeleech Sunday is enabled', 'countdown', 1362355200),
(11, 'Sitewide Freeleech', 0, 'set by', 'manual', 0),
(12, 'Sitewide Doubleseed', 0, 'set by ', 'manual', 0),
(13, 'Sitewide Freeleech and Doubleseed', 0, 'set by', 'manual', 0),
(15, 'Crazy Hour', 1465893534, 'Freeleech and Double Upload credit for 24 Hours', 'crazyhour', 0);

-- --------------------------------------------------------

--
-- Table structure for table `freeslots`
--

CREATE TABLE IF NOT EXISTS `freeslots` (
  `torrentid` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL,
  `doubleup` enum('yes','no') CHARACTER SET utf8 NOT NULL DEFAULT 'no',
  `free` enum('yes','no') CHARACTER SET utf8 NOT NULL DEFAULT 'no',
  `addedup` int(11) NOT NULL DEFAULT '0',
  `addedfree` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `friendid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `confirmed` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE IF NOT EXISTS `funds` (
  `id` int(10) UNSIGNED NOT NULL,
  `cash` decimal(8,2) NOT NULL DEFAULT '0.00',
  `user` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `happyhour`
--

CREATE TABLE IF NOT EXISTS `happyhour` (
  `id` int(10) NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0',
  `torrentid` int(10) NOT NULL DEFAULT '0',
  `multiplier` float NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `happylog`
--

CREATE TABLE IF NOT EXISTS `happylog` (
  `id` int(10) NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0',
  `torrentid` int(10) NOT NULL DEFAULT '0',
  `multi` float NOT NULL DEFAULT '0',
  `date` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hit_and_run_settings`
--

CREATE TABLE IF NOT EXISTS `hit_and_run_settings` (
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hit_and_run_settings`
--

INSERT INTO `hit_and_run_settings` (`name`, `value`) VALUES
('firstclass', 'UC_POWER_USER'),
('secondclass', 'UC_VIP'),
('thirdclass', 'UC_MODERATOR'),
('_3day_first', '48'),
('_14day_first', '30'),
('_14day_over_first', '18'),
('_3day_second', '48'),
('_14day_second', '30'),
('_14day_over_second', '18'),
('_3day_third', '48'),
('_14day_third', '30'),
('_14day_over_third', '18'),
('torrentage1', '1'),
('torrentage2', '7'),
('torrentage3', '7'),
('cainallowed', '3'),
('caindays', '0.5'),
('hnr_online', '0');

-- --------------------------------------------------------

--
-- Table structure for table `infolog`
--

CREATE TABLE IF NOT EXISTS `infolog` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` int(11) DEFAULT '0',
  `txt` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invite_codes`
--

CREATE TABLE IF NOT EXISTS `invite_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `receiver` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `code` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `invite_added` int(10) NOT NULL,
  `status` enum('Pending','Confirmed') CHARACTER SET latin1 NOT NULL DEFAULT 'Pending',
  `email` varchar(80) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ips`
--

CREATE TABLE IF NOT EXISTS `ips` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `type` enum('login','announce','browse','like') CHARACTER SET latin1 NOT NULL,
  `seedbox` tinyint(1) NOT NULL DEFAULT '0',
  `lastbrowse` int(11) NOT NULL DEFAULT '0',
  `lastlogin` int(11) NOT NULL DEFAULT '0',
  `lastannounce` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `post_id` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0',
  `user_comment_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `userip` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lottery_config`
--

CREATE TABLE IF NOT EXISTS `lottery_config` (
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lottery_config`
--

INSERT INTO `lottery_config` (`name`, `value`) VALUES
('ticket_amount', '1'),
('ticket_amount_type', 'seedbonus'),
('user_tickets', '100'),
('class_allowed', '0|1|2|3|4|5|6'),
('total_winners', '5'),
('prize_fund', '10000000'),
('start_date', '1448999118'),
('end_date', '1449591318'),
('use_prize_fund', '0'),
('enable', '1'),
('lottery_winners', ''),
('lottery_winners_amount', '2000000'),
('lottery_winners_time', '1334782914');

-- --------------------------------------------------------

--
-- Table structure for table `manage_likes`
--

CREATE TABLE IF NOT EXISTS `manage_likes` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `disabled_time` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `receiver` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `subject` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `msg` text CHARACTER SET utf8,
  `unread` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `poster` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `location` smallint(6) NOT NULL DEFAULT '1',
  `saved` enum('no','yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `urgent` enum('no','yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `draft` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modscredits`
--

CREATE TABLE IF NOT EXISTS `modscredits` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` enum('Addon','Forum','Message/Email','Display/Style','Staff/Tools','Browse/Torrent/Details','Misc') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Misc',
  `status` enum('Complete','In-Progress') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Complete',
  `u232lnk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `modscredits`
--

INSERT INTO `modscredits` (`id`, `name`, `category`, `status`, `u232lnk`, `credit`, `description`) VALUES
(1, 'Ratio Free', 'Addon', 'Complete', 'https://forum.u-232.com/index.php/topic,1060.0.html', 'Mindless', 'V3 Ratio free modification; A true ratio free system =]');

-- --------------------------------------------------------

--
-- Table structure for table `moods`
--

CREATE TABLE IF NOT EXISTS `moods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `bonus` int(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `moods`
--

INSERT INTO `moods` (`id`, `name`, `image`, `bonus`) VALUES
(67, 'is a slurpee ninja', 'ninja.gif', 1),
(66, 'is headbanging', 'punk.gif', 0),
(65, 'is grooving to the music', 'music.gif', 0),
(63, 'is farting', 'fart3.gif', 0),
(64, 'is hard at work', 'elektrik.gif', 0),
(62, 'is feeling artistic', 'graffiti.gif', 0),
(61, 'is feeling Good!', 'good.gif', 0),
(59, 'is having a cig', 'cigar.gif', 0),
(60, 'is eating cookies', 'cookies.gif', 0),
(58, 'is telling a story', 'talk2.gif', 0),
(57, 'is pissed drunk', 'drinks.gif', 0),
(56, 'Is old', 'oldman.gif', 0),
(55, 'is in bed', 'sleeping.gif', 0),
(54, 'is kenny', 'kenny.gif', 0),
(53, 'is feeling lucky', 'clover.gif', 1),
(52, 'is feeling super', 'super.gif', 1),
(51, 'is bouncing', 'trampoline.gif', 1),
(50, 'is drinking cola', 'pepsi.gif', 1),
(49, 'is hitting the bong', 'bong.gif', 1),
(48, 'is spidey', 'spidey.gif', 0),
(47, 'is taz!', 'taz.gif', 1),
(133, 'is wanted', 'wanted.gif', 0),
(131, 'is a wizard', 'wizard.gif', 0),
(132, 'is a pissed off', 'soapbox1.gif', 0),
(108, 'is da bomb', 'bomb.gif', 0),
(123, 'hitting the bhong', 'bhong.gif', 0),
(121, 'is smiling', 'smile2.gif', 0),
(122, 'is cheerful', 'clapper1.gif', 0),
(107, 'is crazy', 'crazy.gif', 0),
(105, 'Is banned', 'banned.gif', 0),
(106, 'is teasing', 'blum.gif', 0),
(104, 'is headbanging', 'mini4.gif', 0),
(203, 'is wacko', 'wacko.gif', 0),
(102, 'woof woof!', 'pish.gif', 0),
(101, 'is crabby', 'evilmad.gif', 0),
(100, 'is dead', 'wink_skull.gif', 0),
(46, 'is bored', 'tumbleweed.gif', 0),
(45, 'is in shock', 'sheesh.gif', 0),
(44, 'is feeling weird', 'weirdo.gif', 0),
(43, 'is stoned', 'smokin.gif', 0),
(42, 'is feeling smart', 'smart.gif', 0),
(41, 'is feeling sly', 'sly.gif', 0),
(40, 'is feeling like shit', 'shit.gif', 0),
(39, 'is feeling like a pimp', 'pimp.gif', 0),
(38, 'is feeling old', 'oldtimer.gif', 0),
(37, 'is a ninja', 'ninja.gif', 0),
(36, 'is into the music', 'music.gif', 0),
(35, 'is feeling like a king', 'king.gif', 0),
(34, 'is feeling lazy', 'smoke2.gif', 0),
(33, 'is feeling like kissing', 'kissing2.gif', 0),
(32, 'is laughing out loud', 'laugh.gif', 0),
(31, 'is feeling innocent', 'innocent.gif', 0),
(30, 'is feeling like a winner', 'hooray.gif', 0),
(29, 'is having fun', 'fun.gif', 0),
(28, 'has gone fishing', 'fishing.gif', 0),
(27, 'is drunk', 'drunk.gif', 0),
(26, 'is feeling crazy', 'crazy.gif', 0),
(25, 'is dancing', 'mml.gif', 0),
(24, 'is feeling like crying', 'cry.gif', 0),
(23, 'needs coffee', 'cuppa.gif', 0),
(22, 'is feeling bossy', 'cigar.gif', 0),
(103, 'is feeling like an angel', 'angeldevil.gif', 0),
(21, 'is feeling like an angel', 'angel.gif', 0),
(20, 'is drinking', 'beer.gif', 0),
(19, 'is drinking with friends', 'beer2.gif', 0),
(18, 'is feeling bananas', 'bananadance.gif', 0),
(17, 'is feeling awesome', 'w00t.gif', 0),
(16, 'is feeling like a tease', 'tease.gif', 0),
(15, 'is feeling happy', 'smile1.gif', 0),
(14, 'yarrr matey', 'pirate2.gif', 0),
(13, 'is feeling yucky', 'yucky.gif', 0),
(202, 'devil', 'devil.gif', 0),
(12, 'is feeling devilish', 'devil.gif', 0),
(11, 'is feeling like ranting', 'rant.gif', 0),
(10, 'is a pirate', 'pirate.gif', 0),
(9, 'in love', 'love.gif', 0),
(8, 'is feeling silly', 'clown.gif', 0),
(7, 'is feeling sad', 'wavecry.gif', 0),
(6, 'in wub', 'wub.gif', 0),
(5, 'is feeling angry', 'angry.gif', 0),
(4, 'is feeling tired', 'yawn.gif', 0),
(3, 'is feeling good', 'grin.gif', 0),
(2, 'is feeling bad', 'wall.gif', 0),
(1, 'is feeling neutral', 'noexpression.gif', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `body` text CHARACTER SET utf8,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sticky` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `anonymous` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notconnectablepmlog`
--

CREATE TABLE IF NOT EXISTS `notconnectablepmlog` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `date` int(11) DEFAULT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `now_viewing`
--

CREATE TABLE `now_viewing` (
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `forum_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `topic_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(10) UNSIGNED NOT NULL,
  `offer_name` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(180) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `category` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `offered_by_user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `filled_torrent_id` int(10) NOT NULL DEFAULT '0',
  `vote_yes_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `vote_no_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comments` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `link` varchar(240) CHARACTER SET utf8 DEFAULT NULL,
  `status` enum('approved','pending','denied') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_votes`
--

CREATE TABLE IF NOT EXISTS `offer_votes` (
  `id` int(10) UNSIGNED NOT NULL,
  `offer_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `vote` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `overforums`
--

CREATE TABLE IF NOT EXISTS `over_forums` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `min_class_view` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `forum_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paypal_config`
--

CREATE TABLE IF NOT EXISTS `paypal_config` (
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paypal_config`
--

INSERT INTO `paypal_config` (`name`, `value`) VALUES
('email', '\'bigjoo_1358695307_biz@hotsail.co.uk \''),
('gb', '3'),
('weeks', '4'),
('invites', '1'),
('enable', '0'),
('freeslots', '5'),
('freeleech', '1'),
('immunity', '1'),
('seedbonus', '100'),
('reputation', '100'),
('multiplier', '5'),
('currency', '\'GBP\''),
('staff', '1'),
('sandbox', '\'sandbox.\''),
('gb_donated_1', '2'),
('gb_donated_2', '4'),
('gb_donated_3', '7'),
('gb_donated_4', '13'),
('gb_donated_5', '20'),
('gb_donated_6', '40'),
('vip_dur_1', '1'),
('donor_dur_1', '1'),
('free_dur_1', '1'),
('up_amt_1', '1'),
('kp_amt_1', '200'),
('vip_dur_2', '2'),
('donor_dur_2', '2'),
('free_dur_2', '2'),
('up_amt_2', '2'),
('kp_amt_2', '400'),
('vip_dur_3', '4'),
('donor_dur_3', '4'),
('free_dur_3', '4'),
('up_amt_3', '5'),
('kp_amt_3', '600'),
('vip_dur_4', '8'),
('donor_dur_4', '8'),
('free_dur_4', '9'),
('up_amt_4', '9'),
('kp_amt_4', '900'),
('vip_dur_5', '12'),
('donor_dur_5', '12'),
('free_dur_5', '12'),
('up_amt_5', '350'),
('kp_amt_5', '3000'),
('vip_dur_6', '24'),
('donor_dur_6', '24'),
('free_dur_6', '24'),
('up_amt_6', '450'),
('kp_amt_6', '4000'),
('duntil_dur_1', '1'),
('imm_dur_1', '1'),
('duntil_dur_2', '2'),
('imm_dur_2', '2'),
('duntil_dur_3', '4'),
('imm_dur_3', '4'),
('duntil_dur_4', '8'),
('imm_dur_4', '8'),
('duntil_dur_5', '12'),
('imm_dur_5', '12'),
('duntil_dur_6', '24'),
('imm_dur_6', '24'),
('inv_amt_1', '2'),
('inv_amt_2', '2'),
('inv_amt_3', '3'),
('inv_amt_4', '4'),
('inv_amt_5', '5'),
('inv_amt_6', '6');

-- --------------------------------------------------------

--
-- Table structure for table `peers`
--

CREATE TABLE IF NOT EXISTS `peers` (
  `id` int(10) UNSIGNED NOT NULL,
  `torrent` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `torrent_pass` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `peer_id` binary(20) NOT NULL,
  `ip` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `port` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `uploaded` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `downloaded` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `to_go` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `seeder` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `started` int(11) NOT NULL DEFAULT '0',
  `last_action` int(11) NOT NULL DEFAULT '0',
  `prev_action` int(11) NOT NULL DEFAULT '0',
  `connectable` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `agent` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `finishedat` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `downloadoffset` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `uploadoffset` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `corrupt` int(10) NOT NULL DEFAULT '0',
  `compact` varchar(6) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pmboxes`
--

CREATE TABLE IF NOT EXISTS `pmboxes` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `boxnumber` tinyint(4) NOT NULL DEFAULT '2',
  `name` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE IF NOT EXISTS `poll` (
  `id` int(10) NOT NULL,
  `question` varchar(320) CHARACTER SET utf8 DEFAULT NULL,
  `answers` text CHARACTER SET utf8,
  `votes` int(5) NOT NULL DEFAULT '0',
  `multi` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE IF NOT EXISTS `polls` (
  `pid` mediumint(8) NOT NULL,
  `start_date` int(10) DEFAULT NULL,
  `choices` mediumtext CHARACTER SET utf8,
  `starter_id` mediumint(8) NOT NULL DEFAULT '0',
  `starter_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `votes` smallint(5) NOT NULL DEFAULT '0',
  `poll_question` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poll_voters`
--

CREATE TABLE IF NOT EXISTS `poll_voters` (
  `vid` int(10) NOT NULL,
  `ip_address` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
  `vote_date` int(10) NOT NULL DEFAULT '0',
  `poll_id` int(10) NOT NULL DEFAULT '0',
  `user_id` varchar(32) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `poll_voters`
--
--

-- --------------------------------------------------------

-- Table structure for table `postpollanswers`
--

CREATE TABLE IF NOT EXISTS `postpollanswers` (
  `id` int(10) UNSIGNED NOT NULL,
  `pollid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `selection` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postpolls`
--

CREATE TABLE IF NOT EXISTS `postpolls` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` int(11) NOT NULL DEFAULT '0',
  `question` text COLLATE utf8_unicode_ci NOT NULL,
  `option0` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option1` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option2` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option3` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option4` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option5` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option6` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option7` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option8` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option9` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option10` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option11` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option12` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option13` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option14` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option15` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option16` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option17` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option18` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option19` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sort` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(22) DEFAULT '0',
  `body` longtext COLLATE utf8_bin,
  `edited_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edit_date` int(11) DEFAULT '0',
  `post_history` mediumtext COLLATE utf8_bin NOT NULL,
  `icon` int(2) NOT NULL DEFAULT '0',
  `anonymous` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `user_likes` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE IF NOT EXISTS `promo` (
  `id` int(10) NOT NULL,
  `name` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `added` int(10) NOT NULL DEFAULT '0',
  `days_valid` int(2) NOT NULL DEFAULT '0',
  `accounts_made` int(3) NOT NULL DEFAULT '0',
  `max_users` int(3) NOT NULL DEFAULT '0',
  `link` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `creator` int(10) NOT NULL DEFAULT '0',
  `users` text CHARACTER SET utf8,
  `bonus_upload` bigint(10) NOT NULL DEFAULT '0',
  `bonus_invites` int(2) NOT NULL DEFAULT '0',
  `bonus_karma` int(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(10) NOT NULL,
  `topic` int(10) NOT NULL DEFAULT '0',
  `torrent` int(10) NOT NULL DEFAULT '0',
  `rating` int(1) NOT NULL DEFAULT '0',
  `user` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `readposts`
--

CREATE TABLE IF NOT EXISTS `read_posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `topic_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_post_read` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrers`
--

CREATE TABLE IF NOT EXISTS `referrers` (
  `id` int(100) NOT NULL,
  `browser` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ip` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `referer` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `page` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `releases`
--

CREATE TABLE IF NOT EXISTS `releases` (
  `releasename` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `section` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nuked` int(11) DEFAULT NULL,
  `nukereason` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `nuketime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `releasetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `reported_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `reporting_what` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `reporting_type` enum('User','Comment','Request_Comment','Offer_Comment','Request','Offer','Torrent','Hit_And_Run','Post') CHARACTER SET utf8 NOT NULL DEFAULT 'Torrent',
  `reason` text CHARACTER SET utf8,
  `who_delt_with_it` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `delt_with` tinyint(1) NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `how_delt_with` text CHARACTER SET utf8,
  `2nd_value` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `when_delt_with` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reputation`
--

CREATE TABLE IF NOT EXISTS `reputation` (
  `reputationid` int(11) UNSIGNED NOT NULL,
  `reputation` int(10) NOT NULL DEFAULT '0',
  `whoadded` int(10) NOT NULL DEFAULT '0',
  `reason` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `dateadd` int(10) NOT NULL DEFAULT '0',
  `locale` enum('posts','comments','torrents','users') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'posts',
  `postid` int(10) NOT NULL DEFAULT '0',
  `userid` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reputationlevel`
--

CREATE TABLE IF NOT EXISTS `reputationlevel` (
  `reputationlevelid` int(11) UNSIGNED NOT NULL,
  `minimumreputation` int(10) NOT NULL DEFAULT '0',
  `level` varchar(250) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reputationlevel`
--

INSERT INTO `reputationlevel` (`reputationlevelid`, `minimumreputation`, `level`) VALUES
(1, -999999, 'is infamous around these parts'),
(2, -50, 'can only hope to improve'),
(3, -10, 'has a little shameless behaviour in the past'),
(4, 0, 'is an unknown quantity at this point'),
(5, 15, 'is on a distinguished road'),
(6, 50, 'will become famous soon enough'),
(7, 250, 'has a spectacular aura about'),
(8, 150, 'is a jewel in the rough'),
(9, 350, 'is just really nice'),
(10, 450, 'is a glorious beacon of light'),
(11, 550, 'is a name known to all'),
(12, 650, 'is a splendid one to behold'),
(13, 1000, 'has much to be proud of'),
(14, 1500, 'has a brilliant future'),
(15, 2000, 'has a reputation beyond repute');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_name` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(180) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `category` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `requested_by_user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `filled_by_user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `filled_torrent_id` int(10) NOT NULL DEFAULT '0',
  `vote_yes_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `vote_no_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comments` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `link` varchar(240) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_votes`
--

CREATE TABLE IF NOT EXISTS `request_votes` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `vote` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(3) NOT NULL,
  `type` int(3) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `type`, `title`, `text`) VALUES
(1, 1, 'General rules - Breaking these rules can and will get you banned !', '\r\nAccess to the newest torrents is conditional on a good ratio! (See the FAQ  for details.) Low ratios may result in severe consequences, including banning in extreme cases.\r\nNo duplicate accounts from the same IP. Members with more than one account for whatever reason without approval of Sysops or staff will get banned please do not make multiple  accounts!.\r\nNo aggressive behaviour or flaming in the forums.\r\nNo trashing of other peoples topics (e.g. SPAM).\r\nNo language other than English in the forums.\r\nAbsolutely no racial slurs or racist remarks will be tolerated.\r\n'),
(2, 2, 'Forum Rules', '<ul>\r\n<li>Please, feel free to answer any questions but leave the moderating to the moderators.</li>\r\n<li>Don\'t use all capital letters, excessive !!! (exclamation marks) or ??? (question marks)... it seems like you\'re shouting.</li>\r\n<li>No posting of users stats without their consent is allowed in the forums or torrent comments regardless of ratio or class.</li>  \r\n<li>No trashing of other peoples topics.</li>\r\n<li>No systematic foul language (and none at all on titles).</li>\r\n<li>No double posting. If you wish to post again, and yours is the last post in the thread please use the EDIT function, instead of posting a double.</li>   \r\n<li>No bumping... (All bumped threads will be Locked.)</li>\r\n<li>No direct links to internet sites in the forums.</li>      \r\n<li>No images larger than 400x400, and preferably web-optimised. Use the [img ] tag for images.</li>\r\n<li>No advertising, merchandising or promotions of any sort are allowed on the site.</li>   \r\n<li>Do not tell people to read the Rules, the FAQ, or comment on their ratios and torrents.</li>    \r\n<li>No consistent off-topic posts allowed in the forums. (i.e. SPAM or hijacking)</li>\r\n<li>The Trading/Requesting of invites to other sites is forbidden in the forums.</li>  \r\n<li>Do not post links to other torrent sites or torrents on those sites.</li>    \r\n<li>Users are not allowed, under any circumstance to create their own polls in the forum.</li>    \r\n<li>No self-congratulatory topics are allowed in the forums.</li>    \r\n<li>Do not quote excessively. One quote of a quote box is sufficient.</li>    \r\n<li>Please ensure all questions are posted in the correct section!     (Game questions in the Games section, Apps questions in the Apps section, etc.)</li>    \r\n<li>Please, feel free to answer any questions.. However remain respectful to the people you help ....nobody’s better than anyone else.</li>  \r\n<li>Last, please read the FAQ before asking any questions.</li>\r\n</ul>'),
(3, 3, 'Uploaders Rules', 'All uploaders are subject to follow the below rules in order to be a part of the  uploader team. We realize that it\'s quite a list, and for new uploaders, it might seem a bit overwhelming, but as you spend time here, they\'ll become second hat.\r\n\r\nTo apply to become a site uploader use the uploaders application form, contact staff to get the link.\r\n\r\nTorrents that do not follow the rules below will be deleted.  If you have any questions about the below rules, please feel free to PM them and I will clarify as best I can.\r\n\r\nWelcome to the team and happy uploading!\r\n\r\n<ul>\r\n<li>All Uploaders must upload a minimum of 3 unique torrents each week to retain their Uploader status.</li>\r\n<li>Failure to comply will result in a demotion, and a minimum of a 2 week blackout period where they will not be able to return to the Uploader team.</li>  \r\n<li>If, after the 2 weeks, the Uploader can prove they will be active, they will be reinstated.</li>  \r\n<li>A second instance of inactivity will be cause for permanent removal from the Uploader team.</li>\r\n<li>Extenuating circumstances will be considered if it is the cause of inactivity.  If you are going to be away, please let a staff member know so that your account is not affected.</li>\r\n<li>All torrents must be rarred, no matter what the size or type.  The ONLY exception to this is MP3s.</li>\r\n</ul>'),
(4, 5, 'Free leech rules', '<ul>\r\n<li>From time to time we will have freeleech for 48hours. This means that when you download from site it will not count against your download ratio.</li>\r\n<li>Whatever you seed back will add to your upload ratio.</li>\r\n<li>This is a good opportunity for members with ratio\'s below 1.0 to bring them back into line</li>\r\n<li>Anyone who hit and runs on a freeleech torrent will receive a mandatory 2 week warning. You must seed all torrents downloaded to 100% or for a minimum of 48 hours this is for free leech torrents only.</li>\r\n</ul>\r\n\r\n'),
(5, 4, 'Downloading rules', '<ul>\r\n<li>No comments on torrents you are not about to download.</li>\r\n<li>Once download is complete, remember to seed for as long as possible or for a minimum of 36 hours or a ratio of 1:1</li>\r\n<li>Low ratios will be given the three strike warning from staff and can lead to a total ban.</li>\r\n</ul>');

-- --------------------------------------------------------

--
-- Table structure for table `rules_cat`
--

CREATE TABLE IF NOT EXISTS `rules_cat` (
  `id` int(3) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shortcut` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `min_view` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rules_cat`
--

INSERT INTO `rules_cat` (`id`, `name`, `shortcut`, `min_view`) VALUES
(1, 'General Site Rule', 'site', 0),
(2, 'Forum Rules', 'forum', 0),
(3, 'Uploaders Rules', 'uploaders', 3),
(4, 'Downloading rules', 'downloading', 0),
(5, 'Free leech rules', 'freeleech', 0);

-- --------------------------------------------------------

--
-- Table structure for table `searchcloud`
--

CREATE TABLE IF NOT EXISTS `searchcloud` (
  `id` int(10) UNSIGNED NOT NULL,
  `searchedfor` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `howmuch` int(10) NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `searchcloud` (`id`, `searchedfor`, `howmuch`, `ip`) VALUES
(1, 'Testing', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `shit_list`
--

CREATE TABLE IF NOT EXISTS `shit_list` (
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `suspect` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `shittyness` int(2) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoutbox`
--

CREATE TABLE IF NOT EXISTS `shoutbox` (
  `id` bigint(40) NOT NULL,
  `userid` bigint(6) NOT NULL DEFAULT '0',
  `to_user` int(10) NOT NULL DEFAULT '0',
  `username` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8,
  `text_parsed` text CHARACTER SET utf8,
  `staff_shout` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `autoshout` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sitelog`
--

CREATE TABLE IF NOT EXISTS `sitelog` (
  `id` int(10) UNSIGNED NOT NULL,
  `added` int(11) NOT NULL DEFAULT '0',
  `txt` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_config`
--

CREATE TABLE IF NOT EXISTS `site_config` (
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `site_config`
--

INSERT INTO `site_config` (`name`, `value`) VALUES
('site_online', '1'),
('autoshout_on', '1'),
('seedbonus_on', '1'),
('openreg', 'true'),
('forums_online', '1'),
('maxusers', '10000'),
('invites', '5000'),
('openreg_invites', 'true'),
('failedlogins', '5'),
('ratio_free', 'false'),
('captcha_on', 'true'),
('dupeip_check_on', 'true'),
('totalneeded', '60'),
('bonus_per_duration', '0.225'),
('bonus_per_download', '20'),
('bonus_per_comment', '3'),
('bonus_per_upload', '15'),
('bonus_per_rating', '5'),
('bonus_per_topic', '8'),
('bonus_per_post', '5'),
('bonus_per_delete', '15'),
('bonus_per_thanks', '5'),
('bonus_per_reseed', '10');

-- --------------------------------------------------------

--
-- Table structure for table `snatched`
--

CREATE TABLE IF NOT EXISTS `snatched` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `torrentid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `port` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `connectable` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `agent` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `peer_id` binary(20) NOT NULL,
  `uploaded` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `upspeed` bigint(20) NOT NULL DEFAULT '0',
  `downloaded` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `downspeed` bigint(20) NOT NULL DEFAULT '0',
  `to_go` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `seeder` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `seedtime` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `leechtime` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `start_date` int(11) NOT NULL DEFAULT '0',
  `last_action` int(11) NOT NULL DEFAULT '0',
  `complete_date` int(11) NOT NULL DEFAULT '0',
  `timesann` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hit_and_run` int(11) NOT NULL DEFAULT '0',
  `mark_of_cain` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `finished` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffmessages`
--

CREATE TABLE IF NOT EXISTS `staffmessages` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) DEFAULT '0',
  `msg` text CHARACTER SET utf8,
  `subject` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `answeredby` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `answered` int(1) NOT NULL DEFAULT '0',
  `answer` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffpanel`
--

CREATE TABLE IF NOT EXISTS `staffpanel` (
  `id` int(10) UNSIGNED NOT NULL,
  `page_name` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `file_name` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `type` enum('user','settings','stats','other') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `av_class` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `added_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `staffpanel`
--

INSERT INTO `staffpanel` (`id`, `page_name`, `file_name`, `description`, `type`, `av_class`, `added_by`, `added`) VALUES
(1, 'Flood Control', 'staffpanel.php?tool=floodlimit', 'Manage flood limits', 'settings', 5, 1, 1277910147),
(2, 'Coders Log', 'staffpanel.php?tool=editlog', 'Coders site file edit log', 'other', 6, 1, 1277909868),
(3, 'Bonus Manager', 'staffpanel.php?tool=bonusmanage', 'Site karma bonus manager', 'settings', 5, 1, 1277910813),
(4, 'Non Connectables', 'staffpanel.php?tool=findnotconnectable', 'Find - Pm non-connectable users', 'user', 4, 1, 1277911274),
(5, 'Staff Shout History', 'staffpanel.php?tool=staff_shistory', 'View staff shoutbox history', 'other', 4, 1, 1328723553),
(6, 'Edit Events', 'staffpanel.php?tool=events', 'Edit - Add Freeleech/doubleseed/halfdownload events', 'settings', 6, 1, 1277911847),
(7, 'Site Log', 'staffpanel.php?tool=log', 'View site log', 'other', 4, 1, 1277912694),
(8, 'Poll Manager', 'staffpanel.php?tool=polls_manager', 'Add - Edit site polls', 'settings', 5, 1, 1277912814),
(9, 'Ban Ips', 'staffpanel.php?tool=bans', 'Cached ip ban manager', 'user', 5, 1, 1277912935),
(10, 'Add user', 'staffpanel.php?tool=adduser', 'Add new users from site', 'user', 5, 1, 1277912999),
(11, 'Extra Stats', 'staffpanel.php?tool=stats_extra', 'View graphs of site stats', 'stats', 4, 1, 1277913051),
(12, 'Template Manager', 'staffpanel.php?tool=themes', 'Manage themes', 'settings', 6, 1, 1339372213),
(13, 'Tracker Stats', 'staffpanel.php?tool=stats', 'View uploader and category activity', 'stats', 4, 1, 1277913435),
(14, 'Shoutbox History', 'staffpanel.php?tool=shistory', 'View shout history', 'other', 4, 1, 1277913521),
(15, 'Backup Db', 'staffpanel.php?tool=backup', 'Manual Mysql Database Back Up', 'other', 8, 1, 1277913720),
(16, 'Usersearch', 'staffpanel.php?tool=usersearch', 'Announcement system + Usersearch', 'user', 4, 1, 1277913916),
(17, 'Mysql Stats', 'staffpanel.php?tool=mysql_stats', 'Mysql server stats', 'other', 4, 1, 1277914654),
(18, 'Failed Logins', 'staffpanel.php?tool=failedlogins', 'Clear Failed Logins', 'user', 4, 1, 1277914881),
(19, 'Uploader Applications', 'staffpanel.php?tool=uploadapps&action=app', 'Manage Uploader Applications', 'user', 4, 1, 1325807155),
(20, 'Inactive Users', 'staffpanel.php?tool=inactive', 'Manage inactive users', 'user', 5, 1, 1277915991),
(21, 'Reset Passwords', 'staffpanel.php?tool=reset', 'Reset lost passwords', 'user', 6, 1, 1277916104),
(22, 'Edit Categories', 'staffpanel.php?tool=categories', 'Manage site categories', 'settings', 6, 1, 1277916351),
(23, 'Reputation Admin', 'staffpanel.php?tool=reputation_ad', 'Reputation system admin', 'settings', 6, 1, 1277916398),
(24, 'Reputation Settings', 'staffpanel.php?tool=reputation_settings', 'Manage reputation settings', 'settings', 6, 1, 1277916443),
(25, 'News Admin', 'staffpanel.php?tool=news&mode=news', 'Add - Edit site news', 'settings', 4, 1, 1277916501),
(26, 'Freeleech Manage', 'staffpanel.php?tool=freeleech', 'Manage site wide freeleech', 'settings', 5, 1, 1277916603),
(27, 'Freeleech Users', 'staffpanel.php?tool=freeusers', 'View freeleech users', 'stats', 4, 1, 1277916636),
(28, 'Site Donations', 'staffpanel.php?tool=donations', 'View all/current site donations', 'stats', 6, 1, 1277916690),
(29, 'View Reports', 'staffpanel.php?tool=reports', 'Respond to site reports', 'other', 4, 1, 1278323407),
(30, 'Delete', 'staffpanel.php?tool=delacct', 'Delete user accounts', 'user', 4, 1, 1278456787),
(31, 'Username change', 'staffpanel.php?tool=namechanger', 'Change usernames here.', 'user', 4, 1, 1278886954),
(32, 'Blacklist', 'staffpanel.php?tool=nameblacklist', 'Control username blacklist.', 'settings', 5, 1, 1279054005),
(33, 'System Overview', 'staffpanel.php?tool=system_view', 'Monitor load averages and view phpinfo', 'other', 6, 1, 1277910147),
(34, 'Snatched Overview', 'staffpanel.php?tool=snatched_torrents', 'View all snatched torrents', 'stats', 4, 1, 1277910147),
(35, 'Banned emails.', 'staffpanel.php?tool=bannedemails', 'Manage banned emails.', 'settings', 4, 1, 1333817312),
(36, 'Data Reset', 'staffpanel.php?tool=datareset', 'Reset download stats for nuked torrents', 'user', 5, 1, 1277910147),
(37, 'Dupe Ip Check', 'staffpanel.php?tool=ipcheck', 'Check duplicate ips', 'stats', 4, 1, 1277910147),
(38, 'Lottery', 'lottery.php', 'Configure lottery', 'settings', 5, 1, 1282824272),
(39, 'Group Pm', 'staffpanel.php?tool=grouppm', 'Send grouped pms', 'user', 4, 1, 1282838663),
(40, 'Client Ids', 'staffpanel.php?tool=allagents', 'View all client id', 'stats', 4, 1, 1283592994),
(41, 'Sysop log', 'staffpanel.php?tool=sysoplog', 'View staff actions', 'other', 6, 1, 1284686084),
(42, 'Server Load', 'staffpanel.php?tool=load', 'View current server load', 'other', 4, 1, 1284900585),
(43, 'Promotions', 'promo.php', 'Add new signup promotions', 'settings', 5, 1, 1286231384),
(44, 'Account Manage', 'staffpanel.php?tool=acpmanage', 'Account manager - Conifrm pending users', 'stats', 4, 1, 1289950651),
(45, 'Block Manager', 'staffpanel.php?tool=block.settings', 'Manage Global site block settings', 'settings', 6, 1, 1292185077),
(46, 'Advanced Mega Search', 'staffpanel.php?tool=mega_search', 'Search by ip, invite code, username', 'user', 4, 1, 1292333576),
(47, 'Warnings', 'staffpanel.php?tool=warn&mode=warn', 'Warning Management', 'stats', 4, 1, 1294788655),
(48, 'Leech Warnings', 'staffpanel.php?tool=leechwarn', 'Leech Warning Management', 'stats', 4, 1, 1294794876),
(49, 'Hnr Warnings', 'staffpanel.php?tool=hnrwarn', 'Hit And Run Warning Management', 'stats', 5, 1, 1294794904),
(50, 'Site Peers', 'staffpanel.php?tool=view_peers', 'Site Peers Overview', 'stats', 4, 1, 1296099600),
(51, 'Top Uploaders', 'staffpanel.php?tool=uploader_info', 'View site top uploaders', 'stats', 4, 1, 1297907345),
(52, 'Watched User', 'staffpanel.php?tool=watched_users', 'Manage all watched users here', 'user', 4, 1, 1321020749),
(53, 'Paypal Settings', 'staffpanel.php?tool=paypal_settings', 'Adjust global paypal settings here', 'settings', 6, 1, 1304288197),
(54, 'Update staff arrays - *Member must be offline*', 'staffpanel.php?tool=staff_config', 'Hit once to update allowed staff arrays after member promotion', 'settings', 6, 1, 1330807776),
(55, 'Site Settings', 'staffpanel.php?tool=site_settings', 'Adjust site settings here', 'settings', 6, 1, 1304422497),
(56, 'HIt and run manager', 'staffpanel.php?tool=hit_and_run_settings', 'Manage all hit and run settings here', 'settings', 6, 1, 1373110790),
(57, 'OP cache Manage', 'staffpanel.php?tool=op', 'View Zend OpCache manager', 'other', 6, 1, 1305728681),
(58, 'Memcache Manage', 'staffpanel.php?tool=memcache', 'View memcache manager', 'other', 6, 1, 1305728711),
(59, 'Edit Moods', 'staffpanel.php?tool=edit_moods', 'Edit site usermoods here', 'user', 4, 1, 1308914441),
(60, 'Search Cloud Manage', 'staffpanel.php?tool=cloudview', 'Manage searchcloud entries', 'settings', 4, 1, 1311359588),
(61, 'Mass Bonus Manager', 'staffpanel.php?tool=mass_bonus_for_members', 'MassUpload, MassSeedbonus, MassFreeslot, MassInvite', 'settings', 6, 1, 1311882635),
(62, 'Hit And Runs', 'staffpanel.php?tool=hit_and_run', 'View All Hit And Runs', 'stats', 4, 1, 1312682819),
(63, 'View Possible Cheats', 'staffpanel.php?tool=cheaters', 'View All Cheat Information', 'stats', 4, 1, 1312682871),
(64, 'Cleanup Manager', 'staffpanel.php?tool=cleanup_manager', 'Clean up interval manager', 'settings', 6, 1, 1315001255),
(65, 'Deathrow', 'staffpanel.php?tool=deathrow', 'Torrents on Deathrow', 'user', 4, 1, 1394313792),
(66, 'Referrers', 'staffpanel.php?tool=referrers', 'View referals here', 'stats', 4, 1, 1362000677),
(67, 'Class Configurations', 'staffpanel.php?tool=class_config', 'Configure site user groups', 'settings', 6, 1, 1366566489),
(68, 'Class Promotions', 'staffpanel.php?tool=class_promo', 'Set Promotion Critera', 'settings', 6, 1, 1396513263),
(69, 'Comment viewer', 'staffpanel.php?tool=comments', 'Comment overview page', 'user', 4, 1, 1403735418),
(70, 'Add pretime info', 'staffpanel.php?tool=addpre', 'Manage pretimes', 'other', 5, 1, 1471026242),
(71, 'Moderated torrents', 'staffpanel.php?tool=modded_torrents', 'Manage moderated torrents here', 'other', 4, 1, 1406722110),
(72, 'Forum Manager', 'staffpanel.php?tool=forummanager', 'Forum admin and management', 'settings', 6, 1, 1277916172),
(73, 'Overforum Manager', 'staffpanel.php?tool=moforums', 'Over Forum admin and management', 'settings', 6, 1, 1277916240),
(74, 'Sub Forum Config', 'staffpanel.php?tool=msubforums', 'Configure sub forums', 'settings', 6, 1, 1284303053),
(75, 'Rules administration', 'staffpanel.php?tool=rules_admin', 'Configure site rules', 'settings', 4, 1, 1284303053),
(76, 'Faq administration', 'staffpanel.php?tool=faq_admin', 'Configure site faq', 'settings', 4, 1, 1284303053);

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `id` int(10) UNSIGNED NOT NULL,
  `regusers` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `unconusers` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `torrents` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `seeders` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `leechers` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `torrentstoday` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `donors` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `unconnectables` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `forumtopics` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `forumposts` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `numactive` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `torrentsmonth` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `gender_na` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `gender_male` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `gender_female` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `powerusers` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `disabled` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `uploaders` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `moderators` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `administrators` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `sysops` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`id`, `regusers`, `unconusers`, `torrents`, `seeders`, `leechers`, `torrentstoday`, `donors`, `unconnectables`, `forumtopics`, `forumposts`, `numactive`, `torrentsmonth`, `gender_na`, `gender_male`, `gender_female`, `powerusers`, `disabled`, `uploaders`, `moderators`, `administrators`, `sysops`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stylesheets`
--

CREATE TABLE IF NOT EXISTS `stylesheets` (
  `id` int(10) UNSIGNED NOT NULL,
  `uri` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `name` varchar(64) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stylesheets`
--

INSERT INTO `stylesheets` (`id`, `uri`, `name`) VALUES
(1, '1.css', 'html5 Template');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `topic_id` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subtitles`
--

CREATE TABLE IF NOT EXISTS `subtitles` (
  `id` int(10) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `filename` varchar(36) CHARACTER SET utf8 DEFAULT NULL,
  `imdb` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `lang` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `comment` text CHARACTER SET utf8,
  `fps` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
  `poster` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `cds` int(3) NOT NULL DEFAULT '0',
  `hits` int(10) NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `owner` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thanks`
--

CREATE TABLE IF NOT EXISTS `thanks` (
  `id` int(11) NOT NULL,
  `torrentid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thankyou`
--

CREATE TABLE IF NOT EXISTS `thankyou` (
  `tid` bigint(10) NOT NULL,
  `uid` bigint(10) NOT NULL DEFAULT '0',
  `torid` bigint(10) NOT NULL DEFAULT '0',
  `thank_date` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thumbsup`
--

CREATE TABLE IF NOT EXISTS `thumbsup` (
  `id` int(10) NOT NULL,
  `type` enum('torrents','posts','comments','users') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'torrents',
  `torrentid` int(10) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `commentid` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(4) NOT NULL,
  `user` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `topic_name` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `locked` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `forum_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_post` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `sticky` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `poll_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `anonymous` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `num_ratings` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `rating_sum` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_likes` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrents`
--

CREATE TABLE IF NOT EXISTS `torrents` (
  `id` int(10) UNSIGNED NOT NULL,
  `info_hash` binary(20) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `save_as` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `search_text` text CHARACTER SET utf8,
  `descr` text CHARACTER SET utf8,
  `ori_descr` text CHARACTER SET utf8,
  `category` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `size` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `type` enum('single','multi') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'single',
  `numfiles` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comments` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `times_completed` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `leechers` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `seeders` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_action` int(11) NOT NULL DEFAULT '0',
  `visible` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `banned` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `owner` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `num_ratings` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `rating_sum` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nfo` text CHARACTER SET utf8,
  `client_created_by` char(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unknown',
  `free` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `sticky` enum('yes','fly','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `anonymous` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `url` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `checked_by` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `points` int(10) NOT NULL DEFAULT '0',
  `allow_comments` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `poster` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `nuked` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `nukereason` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `last_reseed` int(11) NOT NULL DEFAULT '0',
  `release_group` enum('scene','p2p','none') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `subs` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `vip` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `newgenre` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `pretime` int(11) NOT NULL DEFAULT '0',
  `bump` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `request` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `offer` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `username` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `thanks` int(10) NOT NULL DEFAULT '0',
  `description` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `youtube` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `tags` text CHARACTER SET utf8,
  `recommended` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `silver` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `checked_when` int(11) NOT NULL DEFAULT '0',
  `flags` int(11) NOT NULL DEFAULT '0',
  `mtime` int(11) NOT NULL DEFAULT '0',
  `ctime` int(11) NOT NULL DEFAULT '0',
  `freetorrent` tinyint(4) NOT NULL DEFAULT '0',
  `user_likes` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploadapp`
--

CREATE TABLE IF NOT EXISTS `uploadapp` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0',
  `applied` int(11) NOT NULL DEFAULT '0',
  `speed` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `offer` longtext CHARACTER SET utf8,
  `reason` longtext CHARACTER SET utf8,
  `sites` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `sitenames` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `scene` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `creating` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `seeding` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `connectable` enum('yes','no','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `status` enum('accepted','rejected','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `moderator` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `comment` varchar(200) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usercomments`
--

CREATE TABLE IF NOT EXISTS `usercomments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8,
  `ori_text` text CHARACTER SET utf8,
  `editedby` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `editedat` int(11) NOT NULL DEFAULT '0',
  `edit_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_likes` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userhits`
--

CREATE TABLE IF NOT EXISTS `userhits` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hitid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `number` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `passhash` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `secret` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `passkey` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(180) CHARACTER SET utf8 DEFAULT NULL,
  `status` enum('pending','confirmed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `added` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_access` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `curr_ann_last_check` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `curr_ann_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `editsecret` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `privacy` enum('strong','normal','low') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'normal',
  `stylesheet` int(10) NOT NULL DEFAULT '1',
  `info` text CHARACTER SET utf8,
  `acceptpms` enum('yes','friends','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `class` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `override_class` tinyint(3) UNSIGNED NOT NULL DEFAULT '255',
  `language` int(11) NOT NULL DEFAULT '1',
  `avatar` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `av_w` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `av_h` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `uploaded` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `downloaded` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `country` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `notifs` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `modcomment` text CHARACTER SET utf8,
  `enabled` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `donor` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `warned` int(11) NOT NULL DEFAULT '0',
  `torrentsperpage` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `topicsperpage` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `postsperpage` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `deletepms` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `savepms` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `reputation` int(10) NOT NULL DEFAULT '10',
  `time_offset` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `dst_in_use` tinyint(1) NOT NULL DEFAULT '0',
  `auto_correct_dst` tinyint(1) NOT NULL DEFAULT '1',
  `show_shout` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `shoutboxbg` enum('1','2','3','4') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '1',
  `chatpost` int(11) NOT NULL DEFAULT '1',
  `smile_until` int(10) NOT NULL DEFAULT '0',
  `seedbonus` decimal(10,1) NOT NULL DEFAULT '200.0',
  `bonuscomment` text CHARACTER SET utf8,
  `vip_added` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `vip_until` int(10) NOT NULL DEFAULT '0',
  `freeslots` int(11) UNSIGNED NOT NULL DEFAULT '5',
  `free_switch` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `invites` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `invitedby` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `invite_rights` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `anonymous` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `uploadpos` int(11) NOT NULL DEFAULT '1',
  `forumpost` int(11) NOT NULL DEFAULT '1',
  `downloadpos` int(11) NOT NULL DEFAULT '1',
  `immunity` int(11) NOT NULL DEFAULT '0',
  `leechwarn` int(11) NOT NULL DEFAULT '0',
  `disable_reason` text CHARACTER SET utf8,
  `clear_new_tag_manually` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `last_browse` int(11) NOT NULL DEFAULT '0',
  `sig_w` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `sig_h` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `signatures` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `signature` varchar(225) CHARACTER SET utf8 DEFAULT NULL,
  `forum_access` int(11) NOT NULL DEFAULT '0',
  `highspeed` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `hnrwarn` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `hit_and_run_total` int(9) DEFAULT '0',
  `donoruntil` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `donated` int(3) NOT NULL DEFAULT '0',
  `total_donated` decimal(8,2) NOT NULL DEFAULT '0.00',
  `vipclass_before` int(10) NOT NULL DEFAULT '0',
  `parked` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `passhint` int(10) UNSIGNED NOT NULL,
  `hintanswer` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `avatarpos` int(11) NOT NULL DEFAULT '1',
  `support` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `supportfor` text CHARACTER SET utf8,
  `language_new` int(11) NOT NULL DEFAULT '1',
  `sendpmpos` int(11) NOT NULL DEFAULT '1',
  `invitedate` int(11) NOT NULL DEFAULT '0',
  `invitees` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `invite_on` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `subscription_pm` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `gender` enum('Male','Female','NA') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA',
  `anonymous_until` int(10) NOT NULL DEFAULT '0',
  `viewscloud` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `tenpercent` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `avatars` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `offavatar` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `pirate` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `king` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `hidecur` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `ssluse` int(1) NOT NULL DEFAULT '1',
  `signature_post` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `forum_post` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `avatar_rights` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `offensive_avatar` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `view_offensive_avatar` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `paranoia` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `google_talk` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `msn` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `aim` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `yahoo` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `icq` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `show_email` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `parked_until` int(10) NOT NULL DEFAULT '0',
  `gotgift` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `hash1` varchar(96) CHARACTER SET utf8 DEFAULT NULL,
  `suspended` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `bjwins` int(10) NOT NULL DEFAULT '0',
  `bjlosses` int(10) NOT NULL DEFAULT '0',
  `warn_reason` text CHARACTER SET utf8,
  `onirc` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `irctotal` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `birthday` date DEFAULT '1801-01-01',
  `got_blocks` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `last_access_numb` bigint(30) NOT NULL DEFAULT '0',
  `onlinetime` bigint(30) NOT NULL DEFAULT '0',
  `pm_on_delete` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `commentpm` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `split` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `browser` text CHARACTER SET utf8,
  `hits` int(10) NOT NULL DEFAULT '0',
  `comments` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `categorie_icon` int(10) DEFAULT '1',
  `perms` int(11) NOT NULL DEFAULT '0',
  `mood` int(10) NOT NULL DEFAULT '1',
  `got_moods` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `pms_per_page` tinyint(3) UNSIGNED DEFAULT '20',
  `show_pm_avatar` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `watched_user` int(11) NOT NULL DEFAULT '0',
  `watched_user_reason` text CHARACTER SET utf8,
  `staff_notes` text CHARACTER SET utf8,
  `game_access` int(11) NOT NULL DEFAULT '1',
  `where_is` text CHARACTER SET utf8,
  `show_staffshout` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `request_uri` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `logout` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `browse_icons` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `numuploads` int(10) NOT NULL DEFAULT '0',
  `corrupt` int(10) NOT NULL DEFAULT '0',
  `ignore_list` text CHARACTER SET utf8,
  `opt1` int(11) NOT NULL DEFAULT '182927957',
  `opt2` int(11) NOT NULL DEFAULT '224',
  `sidebar` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `torrent_pass_version` int(11) NOT NULL DEFAULT '0',
  `torrent_pass` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `can_leech` tinyint(4) NOT NULL DEFAULT '1',
  `wait_time` int(11) NOT NULL DEFAULT '0',
  `peers_limit` int(11) DEFAULT '1000',
  `torrents_limit` int(11) DEFAULT '1000',
  `forum_mod` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `forums_mod` varchar(320) CHARACTER SET utf8 DEFAULT NULL,
  `altnick` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forum_sort` enum('ASC','DESC') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'DESC',
  `pm_forced` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usersachiev`
--

CREATE TABLE IF NOT EXISTS `usersachiev` (
  `id` int(10) UNSIGNED NOT NULL,
  `totalshoutlvl` tinyint(2) NOT NULL DEFAULT '0',
  `username` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `snatchmaster` tinyint(1) NOT NULL DEFAULT '0',
  `invited` int(3) NOT NULL DEFAULT '0',
  `bday` tinyint(1) NOT NULL DEFAULT '0',
  `ul` tinyint(1) NOT NULL DEFAULT '0',
  `inviterach` tinyint(1) NOT NULL DEFAULT '0',
  `forumposts` int(10) NOT NULL DEFAULT '0',
  `postachiev` tinyint(2) NOT NULL DEFAULT '0',
  `avatarset` tinyint(1) NOT NULL DEFAULT '0',
  `avatarach` tinyint(1) NOT NULL DEFAULT '0',
  `stickyup` int(5) NOT NULL DEFAULT '0',
  `stickyachiev` tinyint(1) NOT NULL DEFAULT '0',
  `sigset` tinyint(1) NOT NULL DEFAULT '0',
  `sigach` tinyint(1) NOT NULL DEFAULT '0',
  `corrupt` tinyint(1) NOT NULL DEFAULT '0',
  `dayseed` tinyint(3) NOT NULL DEFAULT '0',
  `sheepyset` tinyint(1) NOT NULL DEFAULT '0',
  `sheepyach` tinyint(1) NOT NULL DEFAULT '0',
  `spentpoints` int(3) NOT NULL DEFAULT '0',
  `achpoints` int(3) NOT NULL DEFAULT '1',
  `forumtopics` int(10) NOT NULL DEFAULT '0',
  `topicachiev` tinyint(2) NOT NULL DEFAULT '0',
  `bonus` tinyint(2) NOT NULL DEFAULT '0',
  `bonusspent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `christmas` tinyint(1) NOT NULL DEFAULT '0',
  `xmasdays` int(2) NOT NULL DEFAULT '0',
  `reqfilled` int(5) NOT NULL DEFAULT '0',
  `reqlvl` tinyint(2) NOT NULL DEFAULT '0',
  `dailyshouts` int(5) NOT NULL DEFAULT '0',
  `dailyshoutlvl` tinyint(2) NOT NULL DEFAULT '0',
  `weeklyshouts` int(5) NOT NULL DEFAULT '0',
  `weeklyshoutlvl` tinyint(2) NOT NULL DEFAULT '0',
  `monthlyshouts` int(5) NOT NULL DEFAULT '0',
  `monthlyshoutlvl` tinyint(2) NOT NULL DEFAULT '0',
  `totalshouts` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_blocks`
--

CREATE TABLE IF NOT EXISTS `user_blocks` (
  `userid` int(10) UNSIGNED NOT NULL,
  `index_page` int(10) UNSIGNED NOT NULL DEFAULT '585727',
  `global_stdhead` int(10) UNSIGNED NOT NULL DEFAULT '2047',
  `userdetails_page` bigint(20) UNSIGNED NOT NULL DEFAULT '4294967295'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ustatus`
--

CREATE TABLE IF NOT EXISTS `ustatus` (
  `id` int(10) NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0',
  `last_status` varchar(140) CHARACTER SET utf8 DEFAULT NULL,
  `last_update` int(11) NOT NULL DEFAULT '0',
  `archive` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wiki`
--

CREATE TABLE IF NOT EXISTS `wiki` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `body` longtext CHARACTER SET utf8,
  `userid` int(10) UNSIGNED DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `lastedit` int(10) unsigned DEFAULT NULL DEFAULT '0',
  `lastedituser` int(10) unsigned DEFAULT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `wiki` (`id`, `name`, `body`, `userid`, `time`, `lastedit`, `lastedituser`) VALUES
(1, 'index', '[align=center][size=6]Welcome to the [b]Wiki[/b][/size][/align]', 0, 1228076412, 1281610709, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xbt_announce_log`
--

CREATE TABLE IF NOT EXISTS `xbt_announce_log` (
  `id` int(11) NOT NULL,
  `ipa` int(10) unsigned NOT NULL DEFAULT '0',
  `port` int(11) NOT NULL DEFAULT '0',
  `event` int(11) NOT NULL DEFAULT '0',
  `info_hash` blob NOT NULL,
  `peer_id` blob NOT NULL,
  `downloaded` bigint(20) NOT NULL DEFAULT '0',
  `left0` bigint(20) NOT NULL DEFAULT '0',
  `uploaded` bigint(20) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `mtime` int(11) NOT NULL DEFAULT '0',
  `useragent` varchar(51) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `xbt_client_whitelist`
--

CREATE TABLE IF NOT EXISTS `xbt_client_whitelist` (
  `id` int(10) UNSIGNED NOT NULL,
  `peer_id` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `vstring` varchar(200) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `xbt_client_whitelist`
--

INSERT INTO `xbt_client_whitelist` (`id`, `peer_id`, `vstring`) VALUES
(1, '-', 'all');

-- --------------------------------------------------------

--
-- Table structure for table `xbt_config`
--

CREATE TABLE IF NOT EXISTS `xbt_config` (
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `xbt_config`
--

INSERT INTO `xbt_config` (`name`, `value`) VALUES
('torrent_pass_private_key', 'MG58LNj5LHHz49A9PKhAkxIH8Aa');

-- --------------------------------------------------------

--
-- Table structure for table `xbt_deny_from_hosts`
--

CREATE TABLE IF NOT EXISTS `xbt_deny_from_hosts` (
  `begin` int(11) NOT NULL DEFAULT '0',
  `end` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `xbt_files`
--

CREATE TABLE IF NOT EXISTS `xbt_files` (
  `fid` int(11) NOT NULL,
  `info_hash` blob NOT NULL,
  `leechers` int(11) NOT NULL DEFAULT '0',
  `seeders` int(11) NOT NULL DEFAULT '0',
  `completed` int(11) NOT NULL DEFAULT '0',
  `announced_http` int(11) NOT NULL DEFAULT '0',
  `announced_http_compact` int(11) NOT NULL DEFAULT '0',
  `announced_http_no_peer_id` int(11) NOT NULL DEFAULT '0',
  `announced_udp` int(11) NOT NULL DEFAULT '0',
  `scraped_http` int(11) NOT NULL DEFAULT '0',
  `scraped_udp` int(11) NOT NULL DEFAULT '0',
  `started` int(11) NOT NULL DEFAULT '0',
  `stopped` int(11) NOT NULL DEFAULT '0',
  `flags` int(11) NOT NULL DEFAULT '0',
  `mtime` int(11) NOT NULL DEFAULT '0',
  `ctime` int(11) NOT NULL DEFAULT '0',
  `balance` int(11) NOT NULL DEFAULT '0',
  `freetorrent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `xbt_files_users`
--

CREATE TABLE IF NOT EXISTS `xbt_files_users` (
  `fid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `announced` int(11) NOT NULL DEFAULT '0',
  `completed` int(11) NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `left` bigint(20) unsigned NOT NULL DEFAULT '0',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `mtime` int(11) NOT NULL DEFAULT '0',
  `leechtime` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `seedtime` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `upspeed` int(10) unsigned NOT NULL DEFAULT '0',
  `downspeed` int(10) unsigned NOT NULL DEFAULT '0',
  `peer_id` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `completedtime` int(11) unsigned NOT NULL DEFAULT '0',
  `ipa` int(11) unsigned NOT NULL DEFAULT '0',
  `connectable` tinyint(4) NOT NULL DEFAULT '1',
  `mark_of_cain` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `hit_and_run` int(11) NOT NULL DEFAULT '0',
  `started` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------

--
-- Table structure for table `xbt_scrape_log`
--

CREATE TABLE IF NOT EXISTS `xbt_scrape_log` (
  `id` int(11) NOT NULL,
  `ipa` int(11) NOT NULL DEFAULT '0',
  `info_hash` blob,
  `uid` int(11) NOT NULL DEFAULT '0',
  `mtime` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievementist`
--
ALTER TABLE `achievementist`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `hostname` (`achievname`);

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `ach_bonus`
--
ALTER TABLE `ach_bonus`
  ADD PRIMARY KEY (`bonus_id`);

--
-- Indexes for table `announcement_main`
--
ALTER TABLE `announcement_main`
  ADD PRIMARY KEY (`main_id`);

--
-- Indexes for table `announcement_process`
--
ALTER TABLE `announcement_process`
  ADD PRIMARY KEY (`process_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `attachmentdownloads`
--
ALTER TABLE `attachmentdownloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fileid_userid` (`fileid`,`userid`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topicid` (`topicid`),
  ADD KEY `postid` (`postid`);

--
-- Indexes for table `avps`
--
ALTER TABLE `avps`
  ADD PRIMARY KEY (`arg`);

--
-- Indexes for table `bannedemails`
--
ALTER TABLE `bannedemails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_last` (`first`);

--
-- Indexes for table `blackjack`
--
ALTER TABLE `blackjack`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonuslog`
--
ALTER TABLE `bonuslog`
  ADD KEY `id` (`id`),
  ADD KEY `added_at` (`added_at`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bugs`
--
ALTER TABLE `bugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `casino`
--
ALTER TABLE `casino`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `casino_bets`
--
ALTER TABLE `casino_bets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheaters`
--
ALTER TABLE `cheaters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_config`
--
ALTER TABLE `class_config`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `class_promo`
--
ALTER TABLE `class_promo`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `cleanup`
--
ALTER TABLE `cleanup`
  ADD PRIMARY KEY (`clean_id`),
  ADD KEY `clean_time` (`clean_time`);

--
-- Indexes for table `cleanup_log`
--
ALTER TABLE `cleanup_log`
  ADD PRIMARY KEY (`clog_id`);

--
-- Indexes for table `coins`
--
ALTER TABLE `coins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torrentid` (`torrentid`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `torrent` (`torrent`),
  ADD KEY `scheck` (`edit_name`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbbackup`
--
ALTER TABLE `dbbackup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deathrow`
--
ALTER TABLE `deathrow`
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `startTime` (`startTime`);

--
-- Indexes for table `failedlogins`
--
ALTER TABLE `failedlogins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_cat`
--
ALTER TABLE `faq_cat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shortcut` (`shortcut`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `torrent` (`torrent`),
  ADD KEY `filename` (`filename`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `freeleech`
--
ALTER TABLE `freeleech`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `freeslots`
--
ALTER TABLE `freeslots`
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `happyhour`
--
ALTER TABLE `happyhour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `happylog`
--
ALTER TABLE `happylog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `hit_and_run_settings`
--
ALTER TABLE `hit_and_run_settings`
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `infolog`
--
ALTER TABLE `infolog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexes for table `invite_codes`
--
ALTER TABLE `invite_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`id`);

--
-- Indexes for table `ips`
--
ALTER TABLE `ips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lottery_config`
--
ALTER TABLE `lottery_config`
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `manage_likes`
--
ALTER TABLE `manage_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`receiver`);

--
-- Indexes for table `modscredits`
--
ALTER TABLE `modscredits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moods`
--
ALTER TABLE `moods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexes for table `notconnectablepmlog`
--
ALTER TABLE `notconnectablepmlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `now_viewing`
--
ALTER TABLE `now_viewing`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `forum_id` (`forum_id`);
--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_added` (`id`),
  ADD KEY `offered_by_name` (`offer_name`);

--
-- Indexes for table `offer_votes`
--
ALTER TABLE `offer_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_offer` (`offer_id`);

--
-- Indexes for table `over_forums`
--
ALTER TABLE `over_forums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paypal_config`
--
ALTER TABLE `paypal_config`
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `peers`
--
ALTER TABLE `peers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `torrent_peer_id` (`torrent`,`peer_id`,`ip`),
  ADD KEY `torrent` (`torrent`),
  ADD KEY `last_action` (`last_action`),
  ADD KEY `connectable` (`connectable`),
  ADD KEY `userid` (`userid`),
  ADD KEY `torrent_pass` (`torrent_pass`);

--
-- Indexes for table `pmboxes`
--
ALTER TABLE `pmboxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `postpollanswers`
--
ALTER TABLE `postpollanswers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollid` (`pollid`);

--
-- Indexes for table `postpolls`
--
ALTER TABLE `postpolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `user_id` (`user_id`);
ALTER TABLE `posts` ADD FULLTEXT KEY `body` (`body`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `readposts`
--
ALTER TABLE `read_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `referrers`
--
ALTER TABLE `referrers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delt_with` (`delt_with`);

--
-- Indexes for table `reputation`
--
ALTER TABLE `reputation`
  ADD PRIMARY KEY (`reputationid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `whoadded` (`whoadded`),
  ADD KEY `multi` (`postid`),
  ADD KEY `dateadd` (`dateadd`),
  ADD KEY `locale` (`locale`);

--
-- Indexes for table `reputationlevel`
--
ALTER TABLE `reputationlevel`
  ADD PRIMARY KEY (`reputationlevelid`),
  ADD KEY `reputationlevel` (`minimumreputation`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_added` (`id`),
  ADD KEY `requested_by_name` (`request_name`);

--
-- Indexes for table `request_votes`
--
ALTER TABLE `request_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_request` (`request_id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rules_cat`
--
ALTER TABLE `rules_cat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shortcut` (`shortcut`);

--
-- Indexes for table `searchcloud`
--
ALTER TABLE `searchcloud`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `searchedfor` (`searchedfor`);

--
-- Indexes for table `shit_list`
--
ALTER TABLE `shit_list`
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `shoutbox`
--
ALTER TABLE `shoutbox`
  ADD PRIMARY KEY (`id`),
  ADD KEY `for` (`to_user`);

--
-- Indexes for table `sitelog`
--
ALTER TABLE `sitelog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added` (`added`);

--
-- Indexes for table `site_config`
--
ALTER TABLE `site_config`
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `snatched`
--
ALTER TABLE `snatched`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tr_usr` (`torrentid`);

--
-- Indexes for table `staffmessages`
--
ALTER TABLE `staffmessages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answeredby` (`answeredby`);

--
-- Indexes for table `staffpanel`
--
ALTER TABLE `staffpanel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_name` (`file_name`),
  ADD KEY `av_class` (`av_class`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stylesheets`
--
ALTER TABLE `stylesheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subtitles`
--
ALTER TABLE `subtitles`
  ADD KEY `id` (`id`);

--
-- Indexes for table `thanks`
--
ALTER TABLE `thanks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thankyou`
--
ALTER TABLE `thankyou`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `thumbsup`
--
ALTER TABLE `thumbsup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `topic_name` (`topic_name`),
  ADD KEY `last_post` (`last_post`),
  ADD KEY `locked_sticky` (`locked`,`sticky`);

--
-- Indexes for table `torrents`
--
ALTER TABLE `torrents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `info_hash` (`info_hash`),
  ADD KEY `owner` (`owner`),
  ADD KEY `visible` (`visible`),
  ADD KEY `category_visible` (`category`),
  ADD KEY `newgenre` (`newgenre`);

--
-- Indexes for table `uploadapp`
--
ALTER TABLE `uploadapp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users` (`userid`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `usercomments`
--
ALTER TABLE `usercomments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `userhits`
--
ALTER TABLE `userhits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `added` (`added`),
  ADD KEY `hitid` (`hitid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `ip` (`ip`),
  ADD KEY `uploaded` (`uploaded`),
  ADD KEY `downloaded` (`downloaded`),
  ADD KEY `country` (`country`),
  ADD KEY `last_access` (`last_access`),
  ADD KEY `enabled` (`enabled`),
  ADD KEY `warned` (`warned`),
  ADD KEY `free_switch` (`free_switch`),
  ADD KEY `T_Pass` (`torrent_pass`);

--
-- Indexes for table `usersachiev`
--
ALTER TABLE `usersachiev`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_blocks`
--
ALTER TABLE `user_blocks`
  ADD UNIQUE KEY `userid` (`userid`);

--
-- Indexes for table `ustatus`
--
ALTER TABLE `ustatus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- Indexes for table `wiki`
--
ALTER TABLE `wiki`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xbt_announce_log`
--
ALTER TABLE `xbt_announce_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xbt_client_whitelist`
--
ALTER TABLE `xbt_client_whitelist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peer_id` (`peer_id`);

--
-- Indexes for table `xbt_files`
--
ALTER TABLE `xbt_files`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `xbt_files_users`
--
ALTER TABLE `xbt_files_users`
  ADD UNIQUE KEY `fid` (`fid`,`uid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `xbt_scrape_log`
--
ALTER TABLE `xbt_scrape_log`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievementist`
--
ALTER TABLE `achievementist`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ach_bonus`
--
ALTER TABLE `ach_bonus`
  MODIFY `bonus_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `announcement_main`
--
ALTER TABLE `announcement_main`
  MODIFY `main_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `announcement_process`
--
ALTER TABLE `announcement_process`
  MODIFY `process_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attachmentdownloads`
--
ALTER TABLE `attachmentdownloads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bannedemails`
--
ALTER TABLE `bannedemails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bonus`
--
ALTER TABLE `bonus`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `bonuslog`
--
ALTER TABLE `bonuslog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `casino_bets`
--
ALTER TABLE `casino_bets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `cheaters`
--
ALTER TABLE `cheaters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class_config`
--
ALTER TABLE `class_config`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `class_promo`
--
ALTER TABLE `class_promo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cleanup`
--
ALTER TABLE `cleanup`
  MODIFY `clean_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `cleanup_log`
--
ALTER TABLE `cleanup_log`
  MODIFY `clog_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coins`
--
ALTER TABLE `coins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `dbbackup`
--
ALTER TABLE `dbbackup`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `failedlogins`
--
ALTER TABLE `failedlogins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `faq_cat`
--
ALTER TABLE `faq_cat`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `freeleech`
--
ALTER TABLE `freeleech`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `happyhour`
--
ALTER TABLE `happyhour`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `happylog`
--
ALTER TABLE `happylog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `infolog`
--
ALTER TABLE `infolog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invite_codes`
--
ALTER TABLE `invite_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ips`
--
ALTER TABLE `ips`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `manage_likes`
--
ALTER TABLE `manage_likes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `modscredits`
--
ALTER TABLE `modscredits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `moods`
--
ALTER TABLE `moods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notconnectablepmlog`
--
ALTER TABLE `notconnectablepmlog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offer_votes`
--
ALTER TABLE `offer_votes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `overforums`
--
ALTER TABLE `over_forums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `peers`
--
ALTER TABLE `peers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pmboxes`
--
ALTER TABLE `pmboxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `poll`
--
ALTER TABLE `poll`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `pid` mediumint(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `postpollanswers`
--
ALTER TABLE `postpollanswers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `postpolls`
--
ALTER TABLE `postpolls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `readposts`
--
ALTER TABLE `read_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `referrers`
--
ALTER TABLE `referrers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reputation`
--
ALTER TABLE `reputation`
  MODIFY `reputationid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reputationlevel`
--
ALTER TABLE `reputationlevel`
  MODIFY `reputationlevelid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `request_votes`
--
ALTER TABLE `request_votes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rules_cat`
--
ALTER TABLE `rules_cat`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `searchcloud`
--
ALTER TABLE `searchcloud`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `shoutbox`
--
ALTER TABLE `shoutbox`
  MODIFY `id` bigint(40) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sitelog`
--
ALTER TABLE `sitelog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `snatched`
--
ALTER TABLE `snatched`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `staffmessages`
--
ALTER TABLE `staffmessages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `staffpanel`
--
ALTER TABLE `staffpanel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `stats`
--
ALTER TABLE `stats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stylesheets`
--
ALTER TABLE `stylesheets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subtitles`
--
ALTER TABLE `subtitles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `thanks`
--
ALTER TABLE `thanks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `thankyou`
--
ALTER TABLE `thankyou`
  MODIFY `tid` bigint(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `thumbsup`
--
ALTER TABLE `thumbsup`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `torrents`
--
ALTER TABLE `torrents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uploadapp`
--
ALTER TABLE `uploadapp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usercomments`
--
ALTER TABLE `usercomments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `userhits`
--
ALTER TABLE `userhits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usersachiev`
--
ALTER TABLE `usersachiev`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ustatus`
--
ALTER TABLE `ustatus`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wiki`
--
ALTER TABLE `wiki`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `xbt_announce_log`
--
ALTER TABLE `xbt_announce_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `xbt_client_whitelist`
--
ALTER TABLE `xbt_client_whitelist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `xbt_scrape_log`
--
ALTER TABLE `xbt_scrape_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `messages` ADD `staff_id` int(10) unsigned NOT NULL DEFAULT '0';
ALTER TABLE `staffmessages` ADD `new`  enum('yes','no') NOT NULL default 'no';
