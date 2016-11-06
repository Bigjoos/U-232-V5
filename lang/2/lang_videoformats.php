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
    //VIDEOFORMATS
    'videoformats_body' => "Downloaded a movie and don't know what CAM/TS/TC/SCR means?",
	//
    'videoformats_cam' => "CAM -",
    'videoformats_cam1' => "A cam is a theater rip usually done with a digital video camera. A mini tripod is sometimes used, but a lot of the time this wont be possible, so the camera make shake. Also seating placement isn't always idle, and it might be filmed from an angle. If cropped properly, this is hard to tell unless there's text on the screen, but a lot of times these are left with triangular borders on the top and bottom of the screen. Sound is taken from the onboard microphone of the camera, and especially in comedies, laughter can often be heard during the film. Due to these factors picture and sound quality are usually quite poor, but sometimes we're lucky, and the theater will be' fairly empty and a fairly clear signal will be heard.",
	//
    'videoformats_ts' => "TELESYNC (TS) -",
    'videoformats_ts1' => "A telesync is the same spec as a CAM except it uses an external audio source (most likely an audio jack in the chair for hard of hearing people). A direct audio source does not ensure a good quality audio source, as a lot of background noise can interfere. A lot of the times a telesync is filmed in an empty cinema or from the projection booth with a professional camera, giving a better picture quality. Quality ranges drastically, check the sample before downloading the full release. A high percentage of Telesyncs are CAMs that have been mislabeled.",
	//
	'videoformats_tc' => "TELECINE (TC) -",
	'videoformats_tc1' => " A telecine machine copies the film digitally from the reels. Sound and picture should be very good, but due to the equipment involved and cost telecines are fairly uncommon. Generally the film will be in correct aspect ratio, although 4:3 telecines have existed. A great example is the JURASSIC PARK 3 TC done last year. TC should not be confused with TimeCode , which is a visible counter on screen throughout the film.",
	//
    'videoformats_scr' => "SCREENER (SCR) -",
	'videoformats_scr1' => "A pre VHS tape, sent to rental stores, and various other places for promotional use. A screener is supplied on a VHS tape, and is usually in a 4:3 (full screen) a/r, although letterboxed screeners are sometimes found. The main draw back is a 'ticker' (a message that scrolls past at the bottom of the screen, with the copyright and anti-copy telephone number). Also, if the tape contains any serial numbers, or any other markings that could lead to the source of the tape, these will have to be blocked, usually with a black mark over the section. This is sometimes only for a few seconds, but unfortunately on some copies this will last for the entire film, and some can be quite big. Depending on the equipment used, screener quality can range from excellent if done from a MASTER copy, to very poor if done on an old VHS recorder thru poor capture equipment on a copied tape. Most screeners are transferred to VCD, but a few attempts at SVCD have occurred, some looking better than others.",
	//
	'videoformats_dvdscr' => "DVD-SCREENER (DVDscr) -",
	'videoformats_dvdscr1' => "Same premise as a screener, but transferred off a DVD. Usually letterbox , but without the extras that a DVD retail would contain. The ticker is not usually in the black bars, and will disrupt the viewing. If the ripper has any skill, a DVDscr should be very good. Usually transferred to SVCD or DivX/XviD.",
	//
    'videoformats_dvdrip' => "DVDRip -",
	'videoformats_dvdrip1' => "A copy of the final released DVD. If possible this is released PRE retail (for example, Star Wars episode 2) again, should be excellent quality. DVDrips are released in SVCD and DivX/XviD.",
    //
	'videoformats_vhsrip' => "VHSRip -",
    'videoformats_vhsrip1' => "Transferred off a retail VHS, mainly skating/sports videos and XXX releases.", 
	//
    'videoformats_tvrip' => "TVRip -", 
	'videoformats_tvrip1' => "TV episode that is either from Network (capped using digital cable/satellite boxes are preferable) or PRE-AIR from satellite feeds sending the program around to networks a few days earlier (do not contain 'dogs' but sometimes have flickers etc) Some programs such as WWF Raw Is War contain extra parts, and the 'dark matches' and camera/commentary tests are included on the rips. PDTV is capped from a digital TV PCI card, generally giving the best results, and groups tend to release in SVCD for these. VCD/SVCD/DivX/XviD rips are all supported by the TV scene.",
	//
	'videoformats_workpoint' => "WORKPRINT (WP) -", 
	'videoformats_workpoint1' => "A workprint is a copy of the film that has not been finished. It can be missing scenes, music, and quality can range from excellent to very poor. Some WPs are very different from the final print (Men In Black is missing all the aliens, and has actors in their places) and others can contain extra scenes (Jay and Silent Bob) . WPs can be nice  additions to the collection once a good quality final has been obtained.",
    //
	'videoformats_divxre' => "DivX Re-Enc -", 
	'videoformats_divxre1' => "A DivX re-enc is a film that has been taken from its original VCD source, and re-encoded into a small DivX file. Most commonly found on file sharers, these are usually labeled something like Film.Name.Group(1of2) etc. Common groups are SMR and TND. These aren't really worth downloading, unless you're that unsure about a film u only want a 200mb copy of it. Generally avoid.",
	//
	'videoformats_watermarks' => "Watermarks -", 
	'videoformats_watermarks1' => "A lot of films come from Asian Silvers/PDVD (see below) and these are tagged by the people responsible. Usually with a letter/initials or a little logo, generally in one of the corners. Most famous are the 'Z' 'A' and 'Globe' watermarks.",
	//
	'videoformats_pdvd' => "Asian Silvers / PDVD -", 
	'videoformats_pdvd1' => "These are films put out by eastern bootleggers, and these are usually bought by some groups to put out as their own. Silvers are very cheap and easily available in a lot of countries, and its easy to put out a release, which is why there are so many in the scene at the moment, mainly from smaller groups who don't last more than a few releases. PDVDs are the same thing pressed onto a DVD. They have removable subtitles, and the quality is usually better than the silvers. These are ripped like a normal DVD, but usually released as VCD.",
	//
	'videoformats_scene' => "Scene Tags...", 
	//
	'videoformats_proper' => "PROPER -", 
	'videoformats_proper1' => "Due to scene rules, whoever releases the first Telesync has won that race (for example). But if the quality of that release is fairly poor, if another group has another telesync (or the same source in higher quality) then the tag PROPER is added to the folder to avoid being duped. PROPER is the most subjective tag in the scene, and a lot of people will generally argue whether the PROPER is better than the original release. A lot of groups release PROPERS just out of desperation due to losing the race. A reason for the PROPER should always be included in the NFO.",
	//
	'videoformats_limited' => "LIMITED -", 
	'videoformats_limited1' => "A limited movie means it has had a limited theater run, generally opening in less than 250 theaters, generally smaller films (such as art house films) are released as limited.",
	//
    'videoformats_internal' => "INTERNAL -", 
	'videoformats_internal1' => "An internal release is done for several reasons. Classic DVD groups do a lot of INTERNAL releases, as they wont be dupe'd on it. Also lower quality theater rips are done INTERNAL so not to lower the reputation of the group, or due to the amount of rips done already. An INTERNAL release is available as normal on the groups affiliate sites, but they can't be traded to other sites without request from the site ops. Some INTERNAL releases still trickle down to IRC/Newsgroups, it usually depends on the title and the popularity. Earlier in the year people referred to Centropy going 'internal'. This meant the group were only releasing the movies to their members and site ops. This is in a different context to the usual definition.",
	//
	'videoformats_stv' => "STV -", 
	'videoformats_stv1' => "Straight To Video. Was never released in theaters, and therefore a lot of sites do not allow these.",
	//
    'videoformats_aspect' => "ASPECT RATIO TAGS -", 
	'videoformats_ws' => "These are *WS* for widescreen (letterbox) and *FS* for Fullscreen.",
	//
    'videoformats_repack' => "REPACK -", 
	'videoformats_repack1' => "If a group releases a bad rip, they will release a Repack which will fix the problems.",
	//
    'videoformats_nuked' => "NUKED -", 
	'videoformats_nuked1' => "A film can be nuked for various reasons. Individual sites will nuke for breaking their rules (such as &quot;No Telesyncs&quot;) but if the film has something extremely wrong with it (no soundtrack for 20mins, CD2 is incorrect film/game etc) then a global nuke will occur, and people trading it across sites will lose their credits. Nuked films can still reach other sources such as p2p/usenet, but its a good idea to check why it was nuked first in case. If a group realise there is something wrong, they can request a nuke.",
    'videoformats_reason' => "NUKE REASONS...", 
	'videoformats_reason1' => "this is a list of common reasons a film can be nuked for (generally DVDRip)",
    'videoformats_badar' => "BAD A/R",
	'videoformats_badar1' => "= bad aspect ratio, ie people appear too fat/thin",
    'videoformats_badivtc' => "BAD IVTC",
	'videoformats_badivtc1' => "= bad inverse telecine. process of converting framerates was incorrect.",
    'videoformats_interlaced' => "INTERLACED",
	'videoformats_interlaced1' => "= black lines on movement as the field order is incorrect.",
	//
    'videoformats_dupe' => "DUPE -",
    'videoformats_dupe1' => "Dupe is quite simply, if something exists already, then theres no reason for it to exist again without proper reason.",
	//
    'videoformats_header' => "Video Formats"
);
?>