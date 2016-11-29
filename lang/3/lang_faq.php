<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                                            |
 |--------------------------------------------------------------------------|
 |   Licence Info: WTFPL                                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5                                            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
$lang = array(
    //FAQ
    'faq_welcome' => "<b>Welcome to {$INSTALLER09['site_name']} FAQ's!</b><br />
    <br />
    Our goal is not to become another Bytemonsoon or Suprnova (not dizzying either of them though).
    The goal is to provide the absolutely latest stuff. Therefore, only specially authorised users have
    permission to upload torrents. If you have access to 0-day stuff do not hesitate to
    <a class='altlink' href='staff.php'>contact</a> us!<br />
    <br />
    This is a private tracker, and you have to register before you can get full access to the site.
    Before you do anything here at {$INSTALLER09['site_name']} we suggest you read the <a class='altlink' href='rules.php'>rules</a>!
    There are only a few rules to abide by, but we do enforce them!<br />
    <br />
    Before you go any further you should read the {$INSTALLER09['site_name']} <a class='altlink' href='useragreement.php'>user agreement</a>.
    <br />",
    'faq_contents_header' => "Contents",
    'faq_siteinfo_header' => "Site information",
    'faq_siteinfo' => "<ul>
        <li><a href='#site1' class='altlink'>What is this bittorrent all about anyway? How do I get the files?</a></li>
        <li><a href='#site2' class='altlink'>Where does the donated money go?</a></li>
        <li><a href='#site4' class='altlink'>Where can I get a copy of the source code?</a></li>
      </ul>
    <br />",
    'faq_userinfo_header' => "User information",
    'faq_userinfo' => "<ul>
        <li><a href='#user1' class='altlink'>I registered an account but did not receive the confirmation e-mail!</a></li>
        <li><a href='#user2' class='altlink'>I've lost my user name or password! Can you send it to me?</a></li>
        <li><a href='#user3' class='altlink'>Can you rename my account?</a></li>
        <li><a href='#user4' class='altlink'>Can you delete my (confirmed) account?</a>
        <img src='{$INSTALLER09['pic_base_url']}updated.png' alt='Updated' width='46' height='11' /></li>
        <li><a href='#userb' class='altlink'>So, what's MY ratio?</a></li>
        <li><a href='#user5' class='altlink'>Why is my IP displayed on my details page?</a></li>
        <li><a href='#user6' class='altlink'>Help! I cannot login!? (a.k.a. Login of Death)</a></li>
        <li><a href='#user7' class='altlink'>My IP address is dynamic. How do I stay logged in?</a>
        <img src='{$INSTALLER09['pic_base_url']}updated.png' alt='Updated' width='46' height='11' /></li>
        <li><a href='#user8' class='altlink'>Why am I listed as not connectable? (And why should I care?)</a></li>
        <li><a href='#user9' class='altlink'>What are the different user classes?</a></li>
        <li><a href='#usera' class='altlink'>How does this promotion thing work anyway?</a></li>
        <li><a href='#usere' class='altlink'>Hey! I've seen Power Users with less than 25GB uploaded!</a></li>
        <li><a href='#userc' class='altlink'>Why can't my friend become a member?</a>
        <img src='{$INSTALLER09['pic_base_url']}updated.png' alt='Updated' width='46' height='11' /></li>
        <li><a href='#userd' class='altlink'>How do I add an avatar to my profile?</a></li>
      </ul>
    <br />",
    'faq_stats_header' => "Stats",
    'faq_stats' => "<ul>
        <li><a href='#stats1' class='altlink'>Most common reasons for stats not updating</a></li>
        <li><a href='#stats2' class='altlink'>Best practices</a></li>
        <li><a href='#stats3' class='altlink'>May I use any bittorrent client?</a></li>
        <li><a href='#stats4' class='altlink'>Why is a torrent I'm leeching/seeding listed several times in my profile?</a></li>
        <li><a href='#stats5' class='altlink'>I've finished or cancelled a torrent. Why is it still listed in my profile?</a></li>
        <li><a href='#stats6' class='altlink'>Why do I sometimes see torrents I'm not leeching in my profile!?</a>
        <img src='{$INSTALLER09['pic_base_url']}/updated.png' alt='Updated' width='46' height='11' /></li>
        <li><a href='#stats7' class='altlink'>Multiple IPs (Can I login from different computers?)</a>
        <img src='{$INSTALLER09['pic_base_url']}updated.png' alt='Updated' width='46' height='11' /></li>
        <li><a href='#stats8' class='altlink'>How does NAT/ICS change the picture?</a></li>
        <li><a href='#stats9' class='altlink'>For those of you who are interested (Anatomy of a torrent session)</a></li>
      </ul>
    <br />",
    'faq_uploading_header' => "Uploading",
    'faq_uploading' => "<ul>
        <li><a href='#up1' class='altlink'>Why can't I upload torrents?</a> </li>
      <li><a href='#up2' class='altlink'>What criteria must I meet before I can join the Uploader team?</a></li>
      <li><a href='#up3' class='altlink'>Can I upload your torrents to other trackers?</a>
      <img src='{$INSTALLER09['pic_base_url']}new.png' alt='New' width='27' height='11' /></li>
      </ul>
    <br />",
    'faq_downloading_header' => "Downloading",
    'faq_downloading' => "<ul>
        <li><a href='#dl1' class='altlink'>How do I use the files I've downloaded?</a></li>
        <li><a href='#dl2' class='altlink'>Downloaded a movie and don't know what CAM/TS/TC/SCR means?</a></li>
        <li><a href='#dl3' class='altlink'>Why did an active torrent suddenly disappear?</a>
        <img src='{$INSTALLER09['pic_base_url']}updated.png' alt='Updated' width='46' height='11' /></li>
        <li><a href='#dl4' class='altlink'>How do I resume a broken download or reseed something?</a></li>
        <li><a href='#dl5' class='altlink'>Why do my downloads sometimes stall at 99%?</a></li>
        <li><a href='#dl6' class='altlink'>What are these &quot;a piece has failed an hash check&quot; messages?</a></li>
        <li><a href='#dl7' class='altlink'>The torrent is supposed to be 100MB. How come I downloaded 120MB?</a></li>
        <li><a href='#dl8' class='altlink'>Why do I get a &quot;Not authorized (xx h) - READ THE FAQ!&quot; error?</a></li>
        <li><a href='#dl9' class='altlink'>Why do I get a &quot;rejected by tracker - Port xxxx is blacklisted&quot; error?</a></li>
        <li><a href='#dla' class='altlink'>What's this 'IOError - [Errno13] Permission denied' error?</a></li>
        <li><a href='#dlb' class='altlink'>What's this &quot;TTL&quot; in the browse page?</a></li>
      </ul>
    <br />",
    'faq_improve_header' => "How can I improve my download speed?",
    'faq_improve' => "<ul>
        <li><a href='#dlsp1' class='altlink'>Do not immediately jump on new torrents</a></li>
        <li><a href='#dlsp2' class='altlink'>Make yourself connectable</a></li>
        <li><a href='#dlsp3' class='altlink'>Limit your upload speed</a></li>
        <li><a href='#dlsp4' class='altlink'>Limit the number of simultaneous connections</a></li>
        <li><a href='#dlsp5' class='altlink'>Limit the number of simultaneous uploads</a></li>
      <li><a href='#dlsp6' class='altlink'>Just give it some time</a></li>
        <li><a href='#dlsp7' class='altlink'>Why is my browsing so slow while leeching?</a></li>
      </ul>
    <br />",
    'faq_isp_header' => "My ISP uses a transparent proxy. What should I do?",
    'faq_isp' => "<ul>
        <li><a href='#prox1' class='altlink'>What is a proxy?</a></li>
        <li><a href='#prox2' class='altlink'>How do I find out if I'm behind a (transparent/anonymous) proxy?</a></li>
        <li><a href='#prox3' class='altlink'>Why am I listed as not connectable even though I'm not NAT/Firewalled?</a></li>
        <li><a href='#prox4' class='altlink'>Can I bypass my ISP's proxy?</a></li>
        <li><a href='#prox5' class='altlink'>How do I make my bittorrent client use a proxy?</a></li>
        <li><a href='#prox6' class='altlink'>Why can't I signup from behind a proxy?</a></li>
        <li><a href='#prox7' class='altlink'>Does this apply to other torrent sites?</a></li>
      </ul>
    <br />",
    'faq_connect_header' => "Why can't I connect? Is the site blocking me?",
    'faq_connect' => "<ul>  <li><a href='#conn1' class='altlink'>Name resolution problems</a></li>
        <li><a href='#conn2' class='altlink'>Maybe my address is blacklisted?</a></li>
        <li><a href='#conn3' class='altlink'>Your ISP blocks the site's address</a></li>
      <li><a href='#conn4' class='altlink'>Alternate port (81)</a>
      <img src='{$INSTALLER09['pic_base_url']}updated.png' alt='Updated' width='46' height='11' /></li>
      </ul>
    <br />",
    'faq_problem' => "<b>What if I can't find the answer to my problem here?</b>",
    'faq_siteinfo_body' => "<br />
    <b>What is this bittorrent all about anyway? How do I get the files?</b><a name='site1' id='site1'></a><br />
    <br />
    Check out <a class='altlink' href='redir.php?url=http://www.btfaq.com/'>Brian's BitTorrent FAQ and Guide</a>.<br />
    <br />
    <br />
    <b>Where does the donated money go?</b><a name='site2' id='site2'></a><br />
    <br />
    {$INSTALLER09['site_name']} is situated on a dedicated server in the Netherlands.
    For the moment we have monthly running costs of approximately &pound; 213.<br />
    <br />
    <br />
    <b>Where can I get a copy of the source code?<a name='site4' id='site4'></a></b><br />
    <br />
    U-232 is an active open source project available for download via Github <a href='https://github.com/Bigjoos/U-232-V3' class='altlink'>Zip download</a> or directly from the support forum <a href='https://forum.u-232.com/index.php?action=downloads;cat=1' class='altlink'>Zip downloads</a>. Please note: We do not give any kind of support on the source code so please don't bug us about it. If it works, great, if not too bad. Use this software at your own risk!
    <p>
    Here is a nice tutorial on getting it all to work. Note: This tutorial is not supported by U-232. Please direct all comments on the tutorial to the author</p>",
    'faq_userinfo_body' => "<b>I registered an account but did not receive the confirmation e-mail!</b><a name='user1' id='user1'></a><br />
    <br />
    You can contact site staff with your request on irc<br />
    <br />
    <br />
    <b>I've lost my user name or password! Can you send it to me?</b><a name='user2' id='user2'></a><br />
    <br />
    Please use <a class='altlink' href='recover.php'>this form</a> to have the login details mailed back to you.<br />
    <br />
    <br />
    <b>Can you rename my account?</b><a name='user3' id='user3'></a><br />
    <br />
    We do not rename accounts. Please create a new one. You can contact site staff with your request.<br />
    <br />
    <br />
    <b>Can you delete my (confirmed) account?</b><a name='user4' id='user4'></a><br />
    <br />
    You can contact site staff with your request.<br />
    <br />
    <br />
    <b>So, what's MY ratio?</b><a name='userb' id='userb'></a><br />
    <br />
    Click on your <a class='altlink' href='usercp.php?action=default'>profile</a>, then on your user name (at the top).<br />
    <br />
    It's important to distinguish between your overall ratio and the individual ratio on each torrent
    you may be seeding or leeching. The overall ratio takes into account the total uploaded and downloaded
    from your account since you joined the site. The individual ratio takes into account those values for each torrent.<br />
    <br />
    You may see two symbols instead of a number: &quot;Inf.&quot;, which is just an abbreviation for Infinity, and
    means that you have downloaded 0 bytes while uploading a non-zero amount (ul/dl becomes infinity); &quot;---&quot;,
    which should be read as &quot;non-available&quot;, and shows up when you have both downloaded and uploaded 0 bytes
    (ul/dl = 0/0 which is an indeterminate amount).<br />
    <br />
    <br />
    <b>Why is my IP displayed on my details page?</b><a name='user5' id='user5'></a><br />
    <br />
    Only you and the site moderators can view your IP address and email. Regular users do not see that information.<br />
    <br />
    <br />
    <b>Help! I cannot login!? (a.k.a. Login of Death)</b><a name='user6' id='user6'></a><br />
    <br />
    This problem sometimes occurs with MSIE. Close all Internet Explorer windows
    and open Internet Options in the control panel. Click the Delete Cookies button.
    You should now be able to login.<br />
    <br />
    <br />
    <b> My IP address is dynamic. How do I stay logged in?</b><a name='user7' id='user7'></a><br />
    <br />
    You do not have to anymore. All you have to do is make sure you are logged in with your actual
    IP when starting a torrent session. After that, even if the IP changes mid-session,
    the seeding or leeching will continue and the statistics will update without any problem.<br />
    <br />
    <br />
    <b>Why am I listed as not connectable? (And why should I care?)</b><a name='user8' id='user8'></a><br />
    <br />
    The tracker has determined that you are firewalled or NATed and cannot accept incoming connections.
    <br />
    <br />
    This means that other peers in the swarm will be unable to connect to you, only you to them. Even worse,
    if two peers are both in this state they will not be able to connect at all. This has obviously a
    detrimental effect on the overall speed.
    <br />
    <br />
    The way to solve the problem involves opening the ports used for incoming connections
    (the same range you defined in your client) on the firewall and/or configuring your
    NAT server to use a basic form of NAT
    for that range instead of NAPT (the actual process differs widely between different router models.
    Check your router documentation and/or support forum. You will also find lots of information on the
    subject at <a class='altlink' href='redir.php?url=http://portforward.com/'>PortForward</a>).<br />
    <br />
    <br />
    <b>What are the different user classes?</b><a name='user9' id='user9'></a><br />
    <div class='col-md-6'>
    <table class='table table-bordered table-striped' cellspacing='3' cellpadding='0'>
    <tr>
      <td class='embedded' width='100'>&nbsp; <b>User</b></td>
      <td class='embedded'>The default class of new members.</td>
    </tr>
    <tr>
      <td class='embedded'>&nbsp; <b>Power User</b></td>
      <td class='embedded'>Can download DOX over 1MB and view NFO files.</td>
    </tr>
    <tr>
      <td class='embedded'>&nbsp;  <img src='{$INSTALLER09['pic_base_url']}star.gif' alt='Star' /></td>
      <td class='embedded'>Has donated money to {$INSTALLER09['site_name']} . </td>
    </tr>
    <tr>
      <td class='embedded' valign='top'>&nbsp; <b>VIP</b></td>
      <td class='embedded' valign='top'>Same privileges as Power User and is considered an Elite Member of {$INSTALLER09['site_name']}. Immune to automatic demotion.</td>
    </tr>
    <tr>
      <td class='embedded'>&nbsp; <b>Other</b></td>
       <td class='embedded'>Customised title.</td>
    </tr>
    <tr>
      <td class='embedded'>&nbsp; <b><font color='#4040c0'>Uploader</font></b></td>
      <td class='embedded'>Same as PU except with upload rights and immune to automatic demotion.</td>
    </tr>
    <tr>
      <td class='embedded' valign='top'>&nbsp; <b><font color='#A83838'>Moderator</font></b></td>
      <td class='embedded' valign='top'>Can edit and delete any uploaded torrents. Can also moderate user	comments and disable accounts.</td>
    </tr>
    <tr>
      <td class='embedded'>&nbsp; <b><font color='#A83838'>Administrator</font></b></td>
      <td class='embedded'>Can do just about anything.</td>
    </tr>
    <tr>
      <td class='embedded'>&nbsp; <b><font color='#A83838'>SysOp</font></b></td>
      <td class='embedded'>Runs day to day matters on site</td>
    </tr>
    </table></div>
    ",
    'faq_promotion_header' => "<b>How does this promotion thing work anyway?</b><a name='usera' id='usera'></a><br />
    <br />",
    'faq_promotion_body' => "<tr>
      <td class='embedded'valign='top' width='100'>&nbsp; <b>Power User</b></td>
      <td class='embedded' valign='top'>Must have been be a member for at least 4 weeks, have uploaded at least 25GB and
      have a ratio at or above 1.05.<br />
      The promotion is automatic when these conditions are met. Note that you will be automatically demoted from<br />
      this status if your ratio drops below 0.95 at any time.</td>
    </tr>
    <tr>
      <td class='embedded'>&nbsp; <img src='{$INSTALLER09['pic_base_url']}star.gif' alt='Star' /></td>
      <td class='embedded'>Just donate, and send <a class='altlink' href='pm_system.php?action=send_message&amp;receiver=1'>Sysop</a> - and only sysop - the details.</td>
    </tr>
    <tr>
      <td class='embedded' valign='top'>&nbsp; <b>VIP</b></td>
      <td class='embedded' valign='top'>Assigned by mods at their discretion to users they feel contribute
      something special to the site.<br />
      (Anyone begging for VIP status will be automatically disqualified.)</td>
    </tr>
    <tr>
      <td class='embedded'>&nbsp; <b>Other</b></td>
      <td class='embedded'>Conferred by mods at their discretion (not available to Users or Power Users).</td>
    </tr>
    <tr>
      <td class='embedded'>&nbsp; <b><font color='#4040c0'>Uploader</font></b></td>
      <td class='embedded'>Appointed by Admins/SysOp (see the 'Uploading' section for conditions).</td>
    </tr>
    <tr>
      <td class='embedded'>&nbsp; <b><font color='#A83838'>Moderator</font></b></td>
      <td class='embedded'>You don't ask us, we'll ask you!</td>
    </tr>
    </table>
    <br />
    <br /><br><br><br>
    <span class='text-left'><b>Hey! I've seen Power Users with less than 25GB uploaded!</b><a name='usere'></a></span><br />
    <br />
    The PU limit used to be 10GB and we didn't demote anyone when we raised it to 25GB.<br />
    <br />
    <br />
    <b>Why can't my friend become a member?</b><a name='userc'></a><br />
    <br />
    There is a 75.000 users limit. When that number is reached we stop accepting new members.
    Accounts inactive for more than 42 days are automatically deleted, so keep trying.
    (There is no reservation or queuing system, don't ask for that.)<br />
    <br />
    <br />
    <b>How do I add an avatar to my profile?</b><a name='userd'></a><br />
    <br />
    First, find an image that you like, and that is within the
    <a class='altlink' href='rules.php'>rules</a>. Then you will have
    to find a place to host it, such as our own <a class='altlink' href='bitbucket.php'>BitBucket</a>.
    (Other popular choices are <a class='altlink' href='http://photobucket.com/'>Photobucket</a>,
    <a class='altlink' href='http://uploadit.org/'>Upload-It!</a> or
    <a class='altlink' href='http://www.imageshack.us/'>ImageShack</a>).
    All that is left to do is copy the URL you were given when
    uploading it to the avatar field in your <a class='altlink' href='usercp.php?action=default'>profile</a>.<br />
    <br />
    Please do not make a post just to test your avatar. If everything is allright you'll see it
    in your ",
    'faq_details_page' => "details page",
    'faq_stats_title' => "Stats",
    'faq_stats_body' => "<br />
    <b>Most common reason for stats not updating</b><a name='stats1'></a><br />
    <br />
    <ul>
      <li>The user is cheating. (a.k.a. &quot;Summary Ban&quot;)</li>
      <li>The server is overloaded and unresponsive. Just try to keep the session open
          until the server responds again. (Flooding the server with consecutive manual updates is not recommended.)</li>
      <li>You are using a faulty client. If you want to use an experimental or CVS version you do it at your own risk.</li>
    </ul>
    <br />
    <b>Best practices</b><a name='stats2'></a><br />
    <br />
    <ul>
      <li>If a torrent you are currently leeching/seeding is not listed on your profile, just wait or force a manual update.</li>
      <li>Make sure you exit your client properly, so that the tracker receives &quot;event=completed&quot;.</li>
      <li>If the tracker is down, do not stop seeding. As long as the tracker is back up before you exit the client the stats
          should update properly.</li>
    </ul>
    <br />
    <b>May I use any bittorrent client?</b><a name='stats3'></a><br />
    <br />
    Yes. The tracker now updates the stats correctly for all bittorrent clients. However, we still recommend
    that you <b>avoid</b> the following clients:<br />
    <br />
    * BitTorrent++,<br />
    * Nova Torrent,<br />
    * TorrentStorm.<br />
    <br />
    These clients do not report correctly to the tracker when canceling/finishing a torrent session.
    If you use them then a few MB may not be counted towards
    the stats near the end, and torrents may still be listed in your profile for some time after you have closed the client.<br />
    <br />
    Also, clients in alpha or beta version should be avoided.<br />
    <br />
    <br />
    <b>Why is a torrent I'm leeching/seeding listed several times in my profile?</b><a name='stats4'></a><br />
    <br />
    If for some reason (e.g. pc crash, or frozen client) your client exits improperly and you restart it,
    it will have a new peer_id, so it will show as a new torrent. The old one will never receive a &quot;event=completed&quot;
    or &quot;event=stopped&quot; and will be listed until some tracker timeout. Just ignore it, it will eventually go away.<br />
    <br />
    <br />
    <b>I've finished or cancelled a torrent. Why is it still listed in my profile?</b><a name='stats5'></a><br />
    <br />
    Some clients, notably TorrentStorm and Nova Torrent, do not report properly to the tracker when canceling or finishing a torrent.
    In that case the tracker will keep waiting for some message - and thus listing the torrent as seeding or leeching - until some
    timeout occurs. Just ignore it, it will eventually go away.<br />
    <br />
    <br />
    <b>Why do I sometimes see torrents I'm not leeching in my profile!?</b><a name='stats6'></a><br />
    <br />
    When a torrent is first started, the tracker uses the IP to identify the user. Therefore the torrent will
    become associated with the user <i>who last accessed the site</i> from that IP. If you share your IP in some
    way (you are behind NAT/ICS, or using a proxy), and some of the persons you share it with are also users,
    you may occasionally see their torrents listed in your profile. (If they start a torrent session from that
    IP and you were the last one to visit the site the torrent will be associated with you). Note that now
    torrents listed in your profile will always count towards your total stats.
    <br />
    <br />
    To make sure your torrents show up in your profile you should visit the site immediately before starting a session.
    <br />
    <br />
    (The only way to completely stop foreign torrents from showing in profiles is to forbid users without
    an individual IP from accessing the site. Yes, that means you. Complain at your own risk.)<br />
    <br />
    <br />
    <b>Multiple IPs (Can I login from different computers?)</b><a name='stats7' id='stats7'></a><br />
    <br />
    Yes, the tracker is now capable of following sessions from different IPs for the same user. A torrent is associated with
    the user when it starts, and only at that moment is the IP relevant. So if you want to seed/leech from computer A
    and computer B with the same account you should access the site from computer A, start the torrent there, and then repeat both
    steps from computer B (not limited to two computers or to a single torrent on each, this is just the simplest example).
    You do not need to login again when closing the torrent.<br />
    <br />
    <br />
    <b>How does NAT/ICS change the picture?<a name='stats8' id='stats8'></a></b><br />
    <br />
    This is a very particular case in that all computers in the LAN will appear to the outside world as having the same IP. We must distinguish
    between two cases:<br />
    <br />
    <b>1.</b> <i>You are the single {$INSTALLER09['site_name']} users in the LAN</i><br />
    <br />
    You should use the same {$INSTALLER09['site_name']} account in all the computers.<br />
    <br />
    Note also that in the ICS case it is preferable to run the BT client on the ICS gateway. Clients running on the other computers
    will be unconnectable (they will be listed as such, as explained elsewhere in the FAQ) unless you specify
    the appropriate services in your ICS configuration (a good explanation of how to do this for Windows XP can be found
    <a class='altlink' href='redir.php?url=http://www.microsoft.com/downloads/details.aspx?FamilyID=1dcff3ce-f50f-4a34-ae67-cac31ccd7bc9&amp;displaylang=en'>here</a>).
    In the NAT case you should configure different ranges for clients on different computers and create appropriate NAT rules in the router. (Details vary widely from router to router and are outside the scope of this FAQ. Check your router documentation and/or support forum.)<br />
    <br />
    <br />
    <b>2.</b> <i>There are multiple {$INSTALLER09['site_name']} users in the LAN</i><br />
    <br />
    At present there is no way of making this setup always work properly with {$INSTALLER09['site_name']}.
    Each torrent will be associated with the user who last accessed the site from within
    the LAN before the torrent was started.
    Unless there is cooperation between the users mixing of statistics is possible.
    (User A accesses the site, downloads a .torrent file, but does not start the torrent immediately.
    Meanwhile, user B accesses the site. User A then starts the torrent. The torrent will count
    towards user B's statistics, not user A's.)
    <br />
    <br />
    It is your LAN, the responsibility is yours. Do not ask us to ban other users
    with the same IP, we will not do that. (Why should we ban <i>him</i> instead of <i>you</i>?)
    <br />
    <br />
    <br />
    <b>For those of you who are interested...</b><a name='stats9' id='stats9'></a><br />
    <br />
    Some <a class='altlink' href='anatomy.php'>info</a> about the &quot;Anatomy of a torrent session&quot;.
    <br />
    </div>
    </td></tr></table>
    </td></tr></table>
    <br />
    <br />",
    'faq_uploading_body' => "<br />
    <b>Why can't I upload torrents?</b><a name='up1'></a><br />
    <br />
    Only specially authorized users (<font color='#4040C0'><b>Uploaders</b></font>) have permission to upload torrents.<br />
    <br />
    <br />
    <b>What criteria must I meet before I can join the <font color='#4040C0'>Uploader</font> team?</b><a name='up2'></a><br />
    <br />
    You must be able to provide releases that:<br />
    * include a proper NFO,<br />
    * are genuine scene releases. If it's not on <a class='altlink' href='redir.php?url=http://www.nforce.nl'>NFOrce</a> or <a href='http://www.grokmusiq.com/' class='altlink'>grokMusiQ</a> then forget it!<br />
    * are not older than seven (7) days,<br />
    * have all files in original format (usually 14.3 MB RARs),<br />
    * you'll be able to seed, or make sure are well-seeded, for at least 24 hours.<br />
    Also, you should have at least 2MBit upload bandwith.<br />
    <br />
    If you think you can match these criteria do not hesitate to <a class='altlink' href='staff.php'>contact</a> one of the administrators.<br />
    <b>Remember!</b> Write your application carefully! Be sure to include your UL speed and what kind of stuff you're planning to upload.<br />
    Only well written letters with serious intent will be considered.<br />
    <br />
    <br />
    <b>Can I upload your torrents to other trackers?</b><a name='up3'></a><br />
    <br />
    No. We are a closed, limited-membership community. Only registered users can use the TB tracker.
    Posting our torrents on other trackers is useless, since most people who attempt to download them will
    be unable to connect with us. This generates a lot of frustration and bad-will against us at {$INSTALLER09['site_name']},
    and will therefore not be tolerated.<br />
    <br />
    Complaints from other sites' administrative staff about our torrents being posted on their sites will
    result in the banning of the users responsible.<br />
    <br />
    (However, the files you download from us are yours to do as you please. You can always create another
    torrent, pointing to some other tracker, and upload it to the site of your choice.)<br />",
    'faq_downloading_body' => "<br />
    <b>How do I use the files I've downloaded?</b><a name='dl1'></a><br />
    <br />
    Check out <a class='altlink' href='formats.php'>this guide</a>.<br />
    <br />
    <br />
    <b>Downloaded a movie and don't know what CAM/TS/TC/SCR means?</b><a name='dl2'></a><br />
    <br />
    Check out <a class='altlink' href='videoformats.php'>this guide</a>.<br />
    <br />
    <br />
    <b>Why did an active torrent suddenly disappear?</b><a name='dl3' id='dl3'></a><br />
    <br />
    There may be three reasons for this:<br />
    (<b>1</b>) The torrent may have been out-of-sync with the site
    <a class='altlink' href='rules.php'>rules</a>.<br />
    (<b>2</b>) The uploader may have deleted it because it was a bad release.
    A replacement will probably be uploaded to take its place.<br />
    (<b>3</b>) Torrents are automatically deleted after 28 days.<br />
    <br />
    <br />
    <b>How do I resume a broken download or reseed something?</b><a name='dl4' id='dl4'></a><br />
    <br />
    Open the .torrent file. When your client asks you for a location, choose the location of
    the existing file(s) and it will resume/reseed the torrent.<br />
    <br />
    <br />
    <b>Why do my downloads sometimes stall at 99%?</b><a name='dl5'></a><br />
    <br />
    The more pieces you have, the harder it becomes to find peers who have pieces you are missing.
    That is why downloads sometimes slow down or even stall when there are just a few percent remaining.
    Just be patient and you will, sooner or later, get the remaining pieces.<br />
    <br />
    <br />
    <b>What are these &quot;a piece has failed an hash check&quot; messages?</b><a name='dl6'></a>
    <br />
    <br />
    Bittorrent clients check the data they receive for integrity. When a piece fails this check it is
    automatically re-downloaded. Occasional hash fails are a common occurrence, and you shouldn't worry.<br />
    <br />
    Some clients have an (advanced) option/preference to 'kick/ban clients that send you bad data' or
    similar. It should be turned on, since it makes sure that if a peer repeatedly sends you pieces that
    fail the hash check it will be ignored in the future.<br />
    <br />
    <br />
    <b>The torrent is supposed to be 100MB. How come I downloaded 120MB?</b><a name='dl7'></a>
    <br />
    <br />
    See the hash fails topic. If your client receives bad data it will have to redownload it, therefore
    the total downloaded may be larger than the torrent size. Make sure the &quot;kick/ban&quot; option is turned on
    to minimize the extra downloads.<br />
    <br />
    <br />
    <b>Why do I get a &quot;Not authorized (xx h) - READ THE FAQ!&quot; error?</b><a name='dl8' id='dl8'></a><br />
    <br />
    From the time that each <b>new</b> torrent is uploaded to the tracker, there is a period of time that
    some users must wait before they can download it.<br />
    This delay in downloading will only affect users with a low ratio, and users with low upload amounts.<br />
    <br />
    <div class='col-md-5'> <table class='table table-bordered table-striped' cellspacing='3' cellpadding='0'>
     <tr>
      <td class='embedded' width='70'>Ratio below</td>
      <td class='embedded' width='40'><div align='center'><font color='#BB0000'>0.50</font></div></td>
      <td class='embedded' width='110'>and/or upload below</td>
      <td class='embedded' width='40'><div align='center'>5.0GB</div></td>
      <td class='embedded' width='50'>delay of</td>
      <td class='embedded' width='40'><div align='center'>48h</div></td>
     </tr>
     <tr>
      <td class='embedded'>Ratio below</td>
      <td class='embedded'><div align='center'><font color='#A10000'>0.65</font></div></td>
      <td class='embedded'>and/or upload below</td>
      <td class='embedded'><div align='center'>6.5GB</div></td>
      <td class='embedded'>delay of</td>
      <td class='embedded'><div align='center'>24h</div></td>
     </tr>
     <tr>
      <td class='embedded'>Ratio below</td>
      <td class='embedded'><div align='center'><font color='#880000'>0.80</font></div></td>
      <td class='embedded'>and/or upload below</td>
      <td class='embedded'><div align='center'>8.0GB</div></td>
      <td class='embedded'>delay of</td>
      <td class='embedded'><div align='center'>12h</div></td>
     </tr>
     <tr>
      <td class='embedded'>Ratio below</td>
      <td class='embedded'><div align='center'><font color='#6E0000'>0.95</font></div></td>
      <td class='embedded'>and/or upload below</td>
      <td class='embedded'><div align='center'>9.5GB</div></td>
      <td class='embedded'>delay of</td>
      <td class='embedded><div align='center'>06h</div></td>
     </tr>
    </table></div>

    '<b>And/or</b>' means any or both. Your delay will be the <b>largest</b> one for which you meet <b>at least</b> one condition.<br />",
    'faq_in' => "In ",
    'faq_your' => "your",
    'faq_case' => " particular case, ",
    'faq_both' => "both ",
    'faq_ratio' => "your ratio of ",
    'faq_and' => " and ",
    'faq_totalup' => "your total uploaded of ",
    'faq_delay' => " a delay of ",
    'faq_hours' => " hours",
    'faq_even' => "Even if your ",
    'faq_totup' => "total uploaded is ",
    'faq_ratiois' => "ratio is ",
    'faq_nodelay' => "you will experience no delay.",
    'faq_downloading_body1' => "This applies to new users as well, so opening a new account will not help. Note also that this
    works at tracker level, you will be able to grab the .torrent file itself at any time.<br />
    <br />
    <!--The delay applies only to leeching, not to seeding. If you got the files from any other source and
    wish to seed them you may do so at any time irrespectively of your ratio or total uploaded.<br />-->
    N.B. Due to some users exploiting the 'no-delay-for-seeders' policy we had to change it. The delay
    now applies to both seeding and leeching. So if you are subject to a delay and get the files from
    some other source you will not be able to seed them until the delay has elapsed.<br />
    <br />
    <br />
    <b>Why do I get a &quot;rejected by tracker - Port xxxx is blacklisted&quot; error?</b><a name='dl9'></a><br />
    <br />
    Your client is reporting to the tracker that it uses one of the default bittorrent ports
    (6881-6889) or any other common p2p port for incoming connections.<br />
    <br />
    {$INSTALLER09['site_name']} does not allow clients to use ports commonly associated with p2p protocols.
    The reason for this is that it is a common practice for ISPs to throttle those ports
    (that is, limit the bandwidth, hence the speed). <br />
    <br />
    The blocked ports list include, but is not neccessarily limited to, the following:<br />
    <br />
    <table class='table table-bordered table-striped' cellspacing='3' cellpadding='0'>
      <tr>
      <td class='embedded' width='80'>Direct Connect</td>
      <td class='embedded' width='80'><div align='center'>411 - 413</div></td>
      </tr>
      <tr>
      <td class='embedded' width='80'>Kazaa</td>
      <td class='embedded' width='80'><div align='center'>1214</div></td>
      </tr>
      <tr>
      <td class='embedded' width='80'>eDonkey</td>
      <td class='embedded' width='80'><div align='center'>4662</div></td>
      </tr>
      <tr>
      <td class='embedded' width='80'>Gnutella</td>
      <td class='embedded' width='80'><div align='center'>6346 - 6347</div></td>
      </tr>
      <tr>
      <td class='embedded' width='80'>BitTorrent</td>
      <td class='embedded' width='80'><div align='center'>6881 - 6889</div></td>
     </tr>
    </table>
    <br />
    In order to use use our tracker you must  configure your client to use
    any port range that does not contain those ports (a range within the region 49152 through 65535 is preferable,
    cf. <a class='altlink' href='http://www.iana.org/assignments/port-numbers'>IANA</a>). Notice that some clients,
    like Azureus 2.0.7.0 or higher, use a single port for all torrents, while most others use one port per open torrent. The size
    of the range you choose should take this into account (typically less than 10 ports wide. There
    is no benefit whatsoever in choosing a wide range, and there are possible security implications). <br />
    <br />
    These ports are used for connections between peers, not client to tracker.
    Therefore this change will not interfere with your ability to use other trackers (in fact it
    should <i>increase</i> your speed with torrents from any tracker, not just ours). Your client
    will also still be able to connect to peers that are using the standard ports.
    If your client does not allow custom ports to be used, you will have to switch to one that does.<br />
    <br />
    Do not ask us, or in the forums, which ports you should choose. The more random the choice is the harder
    it will be for ISPs to catch on to us and start limiting speeds on the ports we use.
    If we simply define another range ISPs will start throttling that range also. <br />
    <br />
    Finally, remember to forward the chosen ports in your router and/or open them in your
    firewall, should you have them. See the
    <i><a href='#user8' class='altlink'>Why am I listed as not connectable?</a></i> &nbsp;section
    and links therein for more information on this.<br />
    <br />
    <br />",
    'faq_downloading_body2' => "<b>What's this 'IOError - [Errno13] Permission denied' error?</b><a name='dla'></a><br />
    <br />
    If you just want to fix it reboot your computer, it should solve the problem.
    Otherwise read on.<br />
    <br />
    IOError means Input-Output Error, and that is a file system error, not a tracker one.
    It shows up when your client is for some reason unable to open the partially downloaded
    torrent files. The most common cause is two instances of the client to be running
    simultaneously:
    the last time the client was closed it somehow didn't really close but kept running in the
    background, and is therefore still
    locking the files, making it impossible for the new instance to open them.<br />
    <br />
    A more uncommon occurrence is a corrupted FAT. A crash may result in corruption
    that makes the partially downloaded files unreadable, and the error ensues. Running
    scandisk should solve the problem. (Note that this may happen only if you're running
    Windows 9x - which only support FAT - or NT/2000/XP with FAT formatted hard drives.
    NTFS is much more robust and should never permit this problem.)<br />
    <br />
    <br />
    <b>What's this &quot;TTL&quot; in the browse page?</b><a name='dlb'></a><br />
    <br />
    The torrent's Time To Live, in hours. It means the torrent will be deleted
    from the tracker after that many hours have elapsed (yes, even if it is still active).
    Note that this a maximum value, the torrent may be deleted at any time if it's inactive.<br />",
    'faq_improve_speed_title' => "How can I improve my download speed?",
    'faq_improve_speed_body' => "The download speed mostly depends on the seeder-to-leecher ratio (SLR). Poor download speed is
    mainly a problem with new and very popular torrents where the SLR is low.<br />
    <br />
    (Proselytising sidenote: make sure you remember that you did not enjoy the low speed.
    <b>Seed</b> so that others will not endure the same.)<br />
    <br />
    There are a couple of things that you can try on your end to improve your speed:<br />
    <br />
    <br />
    <b>Do not immediately jump on new torrents</b><a name='dlsp1'></a><br />
    <br />
    In particular, do not do it if you have a slow connection. The best speeds will be found around the
    half-life of a torrent, when the SLR will be at its highest. (The downside is that you will not be able to seed
    so much. It's up to you to balance the pros and cons of this.)<br />
    <br />
    <br />
    <b>Make yourself connectable</b> <a name='dlsp2'></a><br />
    <br />
    See the <i><a href='#user8' class='altlink'>Why am I listed as not connectable?</a></i> &nbsp;section.<br />
    <br />
    <br />
    <b>Limit your upload speed</b><a name='dlsp3'></a><br />
    <br />
    The upload speed affects the download speed in essentially two ways:<br />
    <ul>
        <li>Bittorrent peers tend to favour those other peers that upload to them. This means that if A and B
      are leeching the same torrent and A is sending data to B at high speed then B will try to reciprocate.
      So due to this effect high upload speeds lead to high download speeds.</li>

        <li>Due to the way TCP works, when A is downloading something from B it has to keep telling B that
            it received the data sent to him. (These are called acknowledgements - ACKs -, a sort of &quot;got it!&quot; messages).
            If A fails to do this then B will stop sending data and wait. If A is uploading at full speed there may be no
            bandwidth left for the ACKs and they will be delayed. So due to this effect excessively high upload speeds lead
            to low download speeds.</li>
    </ul>

    The full effect is a combination of the two. The upload should be kept as high as possible while allowing the
    ACKs to get through without delay. <b>A good thumb rule is keeping the upload at about 80% of the theoretical
    upload speed.</b> You will have to fine tune yours to find out what works best for you. (Remember that keeping the
    upload high has the additional benefit of helping with your ratio.) <br />
    <br />
    If you are running more than one instance of a client it is the overall upload speed that you must take into account.
    Some clients (e.g. Azureus) limit global upload speed, others (e.g. Shad0w's) do it on a per torrent basis.
    Know your client. The same applies if you are using your connection for anything else (e.g. browsing or ftp),
    always think of the overall upload speed.<br />
    <br />
    <br />
    <b>Limit the number of simultaneous connections</b><a name='dlsp4'></a><br />
    <br />
    Some operating systems (like Windows 9x) do not deal well with a large number of connections, and may even crash.
    Also some home routers (particularly when running NAT and/or firewall with stateful inspection services) tend to become
    slow or crash when having to deal with too many connections. There are no fixed values for this, you may try 60 or 100
    and experiment with the value. Note that these numbers are additive, if you have two instances of
    a client running the numbers add up.<br />
    <br />
    <br />
    <b>Limit the number of simultaneous uploads</b><a name='dlsp5'></a><br />
    <br />
    Isn't this the same as above? No. Connections limit the number of peers your client is talking to and/or
    downloading from. Uploads limit the number of peers your client is actually uploading to. The ideal number is
    typically much lower than the number of connections, and highly dependent on your (physical) connection.<br />
    <br />
    <br />
    <b>Just give it some time</b><a name='dlsp6'></a><br />
    <br />
    As explained above peers favour other peers that upload to them. When you start leeching a new torrent you have
    nothing to offer to other peers and they will tend to ignore you. This makes the starts slow, in particular if,
    by change, the peers you are connected to include few or no seeders. The download speed should increase as soon
    as you have some pieces to share.<br />
    <br />
    <br />
    <b>Why is my browsing so slow while leeching?</b><a name='dlsp7'></a><br />
    <br />
    Your download speed is always finite. If you are a peer in a fast torrent it will almost certainly saturate your
    download bandwidth, and your browsing will suffer. At the moment there is no client that allows you to limit the
    download speed, only the upload. You will have to use a third-party solution,
    such as <a class='altlink' href='redir.php?url=http://www.netlimiter.com/'>NetLimiter</a>.<br />
    <br />
    Browsing was used just as an example, the same would apply to gaming, IMing, etc...<br />",
    'faq_proxy_title' => "My ISP uses a transparent proxy. What should I do?",
    'faq_proxy_body' => "<br />
    <i>Caveat: This is a large and complex topic. It is not possible to cover all variations here.</i><br />
    <br />
    Short reply: change to an ISP that does not force a proxy upon you. If you cannot or do not want to then read on.<br />
    <br />
    <b>What is a proxy?</b><a name='prox1'></a><br />
    <br />
    Basically a middleman. When you are browsing a site through a proxy your requests are sent to the proxy and the proxy
    forwards them to the site instead of you connecting directly to the site. There are several classifications
    (the terminology is far from standard):<br />
    <br />",
    'faq_proxy_body2' => "<tr>
      <td class='embedded' valign='top'width='100'>&nbsp;Transparent</td>
      <td class='embedded' valign='top'>A transparent proxy is one that needs no configuration on the clients. It works by automatically redirecting all port 80 traffic to the proxy. (Sometimes used as synonymous for non-anonymous.)</td>
     </tr>
     <tr>
      <td class='embedded' valign='top'>&nbsp;Explicit/Voluntary</td>
      <td class='embedded' valign='top'>Clients must configure their browsers to use them.</td>
     </tr>
     <tr>
      <td class='embedded' valign='top'>&nbsp;Anonymous</td>
      <td class='embedded' valign='top'>The proxy sends no client identification to the server. (HTTP_X_FORWARDED_FOR header is not sent; the server does not see your IP.)</td>
     </tr>
     <tr>
      <td class='embedded' valign='top'>&nbsp;Highly Anonymous</td>
      <td class='embedded' valign='top'>The proxy sends no client nor proxy identification to the server. (HTTP_X_FORWARDED_FOR, HTTP_VIA and HTTP_PROXY_CONNECTION headers are not sent; the server doesn't see your IP and doesn't even know you're using a proxy.)</td>
     </tr>
     <tr>
      <td class='embedded' valign='top'>&nbsp;Public</td>
      <td class='embedded' valign='top'>(Self explanatory)</td>
     </tr>
    </table>
    <br />
    A transparent proxy may or may not be anonymous, and there are several levels of anonymity.<br />
    <br />
    <br />
    <b>How do I find out if I'm behind a (transparent/anonymous) proxy?</b><a name='prox2'></a><br />
    <br />
    Try <a href='redir.php?url=http://proxyjudge.org' class='altlink'>ProxyJudge</a>. It lists the HTTP headers that the server where it is running
    received from you. The relevant ones are HTTP_CLIENT_IP, HTTP_X_FORWARDED_FOR and REMOTE_ADDR.<br />
    <br />
    <br />
    <b>Why am I listed as not connectable even though I'm not NAT/Firewalled?</b><a name='prox3'></a><br />
    <br />
    The {$INSTALLER09['site_name']} tracker is quite smart at finding your real IP, but it does need the proxy to send the HTTP header
    HTTP_X_FORWARDED_FOR. If your ISP's proxy does not then what happens is that the tracker will interpret the proxy's IP
    address as the client's IP address. So when you login and the tracker tries to connect to your client to see if you are
    NAT/firewalled it will actually try to connect to the proxy on the port your client reports to be using for
    incoming connections. Naturally the proxy will not be listening on that port, the connection will fail and the
    tracker will think you are NAT/firewalled.<br />
    <br />
    <br />
    <b>Can I bypass my ISP's proxy?</b><a name='prox4'></a><br />
    <br />
    If your ISP only allows HTTP traffic through port 80 or blocks the usual proxy ports then you would need to use something
    like <a href='redir.php?url=http://www.socks.permeo.com'>socks</a> and that is outside the scope of this FAQ.<br />
    <br />
    The site accepts connections on port 81 besides the usual 80, and using them may be enough to fool some proxies. So the first
    thing to try should be connecting to {$INSTALLER09['baseurl']}:81. Note that even if this works your bt client will still try
    to connect to port 80 unless you edit the announce url in the .torrent file.<br />
    <br />
    Otherwise you may try the following:<br />
    <ul>
        <li>Choose any public <b>non-anonymous</b> proxy that does <b>not</b> use port 80
      (e.g. from <a href='redir.php?url=http://tools.rosinstrument.com/proxy' class='altlink'>this</a>,
      <a href='redir.php?url=http://www.proxy4free.com/index.html' class='altlink'>this</a> or
      <a href='redir.php?url=http://www.samair.ru/proxy' class='altlink'>this</a> list).</li>

        <li>Configure your computer to use that proxy. For Windows XP, do <i>Start</i>, <i>Control Panel</i>, <i>Internet Options</i>,
      <i>Connections</i>, <i>LAN Settings</i>, <i>Use a Proxy server</i>, <i>Advanced</i> and type in the IP and port of your chosen
      proxy. Or from Internet Explorer use <i>Tools</i>, <i>Internet Options</i>, ...<br /></li>

        <li>(Facultative) Visit <a href='redir.php?url=http://proxyjudge.org' class='altlink'>ProxyJudge</a>. If you see an HTTP_X_FORWARDED_FOR in
      the list followed by your IP then everything should be ok, otherwise choose another proxy and try again.<br /></li>

        <li>Visit {$INSTALLER09['site_name']}. Hopefully the tracker will now pickup your real IP (check your profile to make sure).</li>
    </ul>
    <br />
    Notice that now you will be doing all your browsing through a public proxy, which are typically quite slow.
    Communications between peers do not use port 80 so their speed will not be affected by this, and should be better than when
    you were &quot;unconnectable&quot;.<br />
    <br />
    <br />
    <b>How do I make my bittorrent client use a proxy?</b><a name='prox5'></a><br />
    <br />
    Just configure Windows XP as above. When you configure a proxy for Internet Explorer you're actually configuring a proxy for
    all HTTP traffic (thank Microsoft and their &quot;IE as part of the OS policy&quot; ). On the other hand if you use another
    browser (Opera/Mozilla/Firefox) and configure a proxy there you'll be configuring a proxy just for that browser. We don't
    know of any BT client that allows a proxy to be specified explicitly.<br />
    <br />
    <br />
    <b>Why can't I signup from behind a proxy?</b><a name='prox6'></a><br />
    It is our policy not to allow new accounts to be opened from behind a proxy.<br />
    <br />
    <br />
    <b>Does this apply to other torrent sites?</b><a name='prox7'></a><br />
    <br />
    This section was written for {$INSTALLER09['site_name']}, a closed, port 80-81 tracker. Other trackers may be open or closed, and many listen
    on e.g. ports 6868 or 6969. The above does <b>not</b> necessarily apply to other trackers.<br />",
    'faq_blocked_title' => "Why can't I connect? Is the site blocking me?",
    'faq_blocked_body' => "<br />
    Your failure to connect may be due to several reasons. <br />

    <br />
    <br />
    <b>Maybe my address is blacklisted?</b><a name='conn2'></a><br />
    <br />
    The site blocks addresses listed in the (former) <a class='altlink' href='redir.php?url=http://methlabs.org/'>PeerGuardian</a>
    database, as well as addresses of banned users. This works at Apache/PHP level, it's just a script that
    blocks <i>logins</i> from those addresses. It should not stop you from reaching the site. In particular
    it does not block lower level protocols, you should be able to ping/traceroute the server even if your
    address is blacklisted. If you cannot then the reason for the problem lies elsewhere.<br />
    <br />
    If somehow your address is indeed blocked in the PG database do not contact us about it, it is not our
    policy to open <i>ad hoc</i> exceptions. You should clear your IP with the database maintainers instead.<br />
    <br />
    <br />
    <b>Your ISP blocks the site's address</b><a name='conn3'></a><br />
    <br />
    (In first place, it's unlikely your ISP is doing so. DNS name resolution and/or network problems are the usual culprits.)
    <br />
    There's nothing we can do.
    You should contact your ISP (or get a new one). Note that you can still visit the site via a proxy, follow the instructions
    in the relevant section. In this case it doesn't matter if the proxy is anonymous or not, or which port it listens to.<br />
    <br />
    Notice that you will always be listed as an &quot;unconnectable&quot; client because the tracker will be unable to
    check that you're capable of accepting incoming connections.<br />
    <br />
    <br />",
    'faq_alt_port' => "Alternate port (81)",
    'faq_alt_port_body' => "<br />
    Some of our torrents use ports other than the usual HTTP port 80. This may cause problems for some users,
    for instance those behind some firewall or proxy configurations.

    You can easily solve this by editing the .torrent file yourself with any torrent editor, e.g.
    <a href='redir.php?url=http://sourceforge.net/projects/burst/' class='altlink'>MakeTorrent</a>,
    and replacing the announce url {$INSTALLER09['baseurl']}:81 with {$INSTALLER09['site_name']}:80 or just {$INSTALLER09['site_name']}.<br />
    <br />
    Editing the .torrent with Notepad is not recommended. It may look like a text file, but it is in fact
    a bencoded file. If for some reason you must use a plain text editor, change the announce url to
    {$INSTALLER09['site_name']}:80, not {$INSTALLER09['site_name']}. (If you're thinking about changing the number before the
    announce url instead, you know too much to be reading this.)
    </div>
    </td></tr></table>
    </td></tr></table>
    <br />
    <br />",
    'faq_problem_title' => "What if I can't find the answer to my problem here?",
    'faq_problem_body' => "<br />
    Post in the <a class='altlink' href='forums.php'>Forums</a>, by all means. You'll find they
    are usually a friendly and helpful place,
    provided you follow a few basic guidelines:
    <ul>
    <li>Make sure your problem is not really in this FAQ. There's no point in posting just to be sent
    back here.</li>
    <li>Before posting read the sticky topics (the ones at the top). Many times new information that
    still hasn't been incorporated in the FAQ can be found there.</li>
    <li>Help us in helping you. Do not just say 'it doesn't work!'. Provide details so that we don't
    have to guess or waste time asking. What client do you use? What's your OS? What's your network setup? What's the exact
    error message you get, if any? What are the torrents you are having problems with? The more
    you tell the easiest it will be for us, and the more probable your post will get a reply.</li>
    <li>And needless to say: be polite. Demanding help rarely works, asking for it usually does
    the trick.</li>",
);
?>
