CREATE TABLE `attachmentdownloads` (
  `id` int(10) UNSIGNED NOT NULL,
  `file_id` int(10) NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(10) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `times_downloaded` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Indexes for table `attachmentdownloads`
--
ALTER TABLE `attachmentdownloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fileid_userid` (`file_id`,`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `attachmentdownloads`
--
ALTER TABLE `attachmentdownloads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `attachments` ADD `topic_id` int(10) UNSIGNED NOT NULL DEFAULT '0'

ALTER TABLE `attachments` ADD `extension2` varchar(100) COLLATE utf8_unicode_ci NOT NULL

UPDATE attachments_orig SET extension2='application/zip' WHERE extension='zip'

UPDATE attachments_orig SET extension2='application/rar' WHERE extension='rar'

-- Then delete extension column, then rename extension2 to extension
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
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

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

--
-- Indexes for table `faq_cat`
--
ALTER TABLE `faq_cat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shortcut` (`shortcut`);
--
-- AUTO_INCREMENT for table `faq_cat`
--
ALTER TABLE `faq_cat`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
-- Dumping data for table `now_viewing`
--

--
-- Indexes for table `now_viewing`
--
ALTER TABLE `now_viewing`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `forum_id` (`forum_id`);

-- --------------------------------------------------------

-- Table structure for table `postpollanswers`
--

CREATE TABLE IF NOT EXISTS `postpollanswers` (
  `id` int(10) UNSIGNED NOT NULL,
  `pollid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `selection` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Indexes for table `postpollanswers`
--
ALTER TABLE `postpollanswers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollid` (`pollid`);

--
-- AUTO_INCREMENT for table `postpollanswers`
--
ALTER TABLE `postpollanswers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
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
--
-- Indexes for table `postpolls`
--
ALTER TABLE `postpolls`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for table `postpolls`
--
ALTER TABLE `postpolls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
-- --------------------------------------------------------
--
-- Table structure for table `releases`
--

CREATE TABLE `releases` (
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
--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
--
-- Indexes for table `rules_cat`
--
ALTER TABLE `rules_cat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shortcut` (`shortcut`);

--
-- AUTO_INCREMENT for table `rules_cat`
--
ALTER TABLE `rules_cat`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
-- --------------------------------------------------------

/* drop staffpanel table and replace with this */

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

/* end staffpanel update */

ALTER TABLE `categories` ADD  `min_class` int(2) NOT NULL DEFAULT '0'
ALTER TABLE `forums` ADD `place` int(10) NOT NULL DEFAULT '-1'
ALTER TABLE `over_forums` ADD `forum_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '1'
ALTER TABLE `posts` ADD `user_likes` text CHARACTER SET utf8 NOT NULL
ALTER TABLE `torrents` ADD `user_likes` text CHARACTER SET utf8 NOT NULL
ALTER TABLE `shoutbox` ADD `autoshout` ENUM('yes', 'no') NOT NULL DEFAULT 'no'
INSERT INTO `site_config` (`name`, `value`) VALUES ('bonus_per_reseed', '10');
ALTER TABLE `topics` ADD `user_likes` text CHARACTER SET utf8 NOT NULL
ALTER TABLE `users` ADD `forum_mod` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no'
ALTER TABLE `users` ADD `forums_mod` varchar(320) CHARACTER SET utf8 DEFAULT NULL
ALTER TABLE `users` ADD `altnick` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
ALTER TABLE `users` ADD `pm_forced` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'yes'
ALTER TABLE `users` ADD `ignore_list` text CHARACTER SET utf8
ALTER TABLE `usercomments` ADD `user_likes` text CHARACTER SET utf8 NOT NULL
