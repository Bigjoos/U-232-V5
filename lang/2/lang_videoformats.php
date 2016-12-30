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
    'videoformats_body' => "Vous venez de télécharger une vidéo et vous ignorez ce que veulent dire les tags CAM/TS/TC/SCR etc?",
	//

    'videoformats_cam' => "CAM -",

    'videoformats_cam1' => "C'est une copie d'un film réalisé dans un cinéma, à l'aide d'une caméra (Take on Screen). Le son provient du micro embarqué de la caméra. Ensemble d'une qualité souvent médiocre.",
	//

    'videoformats_ts' => "TELESYNC (TS) -",

    'videoformats_ts1' => "C'est une copie d'un film réalisé dans un cinéma, à l'aide d'une caméra, mais avec un son ou une vidéo provenant d'une source externe..",
	//

	'videoformats_tc' => "TELECINE (TC) -",

	'videoformats_tc1' => "Une machine de téléciné copie le film digitalement des bobines (il est aussi possible d’utiliser un graveur dvd, un mini-dv recorder, etc.). Le son et la vidéo devraient être très bons, mais en raison de l’équipement impliqué qui est très coûteux, ils sont assez rares.",
	//

    'videoformats_scr' => "SCREENER (SCR) -",

	'videoformats_scr1' => "Un screener est fait à partir d’une cassette VHS promotionnelle. Habituellement, le film est en 4:3 (plein écran) bien que des widescreen ont déjà été fait par le passé. Un message de copyright permanent ou intermittant défile à l’écran.",
	//

	'videoformats_dvdscr' => "DVD-SCREENER (DVDscr) -",

	'videoformats_dvdscr1' => "Même chose que le SCREENER sauf que la copie promotionnelle est diffusée sur DVD au lieu de VHS. Un message de copyright permanent ou intermittant défile à l’écran. Il arrive aussi qu’il y ait des passages en noir/blanc pendant quelques minutes.",
	//

    'videoformats_dvdrip' => "DVDRip -",

	'videoformats_dvdrip1' => "Copie depuis le DVD commercialisé final (retail).",

    //

	'videoformats_vhsrip' => "VHSRip -",

    'videoformats_vhsrip1' => "Copie depuis la VHS commercialisée finale (retail).", 
	//

    'videoformats_tvrip' => "TVRip -", 
	'videoformats_tvrip1' => "Copie réalisée à partir de l'enregistrement d'une chaîne de Télévision.",
	//
	'videoformats_workpoint' => "WORKPRINT (WP) -", 
	'videoformats_workpoint1' => "Un workprint est une copie du film qui n’a pas été fini. Cela peut être des scènes absentes, musique, etc La qualité va d’excellente à très mauvaise. Certains WP sont très différents de la copie finale et d’autres peuvent contenir des scènes supplémentaires. Les WP peuvent s’ajouter à la collection une fois qu’une version finale de bonne qualité a été obtenue.",

    //
	'videoformats_divxre' => "DivX Re-Enc -", 
	'videoformats_divxre1' => "Un DivX re-enc est un film pris d’une source VCD et réencodé dans un fichier DivX plus petit. A éviter, à moins de vouloir regarder un film basse qualité qui pèse 200 Mo.",
	//

	'videoformats_watermarks' => "Watermarks -", 
	'videoformats_watermarks1' => "Beaucoup de films qui viennent des Silvers/PDVD asiatique (voir ci-dessous) sont marquée par les personnes responsables. Habituellement avec des lettres (initiales) ou un petit logo sont généralement dans un des coins. Le plus célèbres sont les watermarks 'A' 'Z' et 'Globe'.",
	//

	'videoformats_pdvd' => "Asian Silvers / PDVD -", 
	'videoformats_pdvd1' => "Ce sont des films qui sont piratés par des asiatiques avant leurs sortie sur le marché et qui sont ensuite acheté par des groupes de releases principalement sur la scène américaine. Ils les achètent la majorité du temps par des contacts qui vivent en Asie et qui peuvent les acheter sur les marchés orientaux (Thaïlande, HK, etc.). Les Silvers sont très bon marché et facilement disponible dans beaucoup de pays, donc il est facile de sortir une release, voilà pourquoi il y en a tellement sur la scène à l’heure actuelle. Les PDVD sont la même chose mai copiés sur un DVD. Ils ont des sous-titres optionnels et la qualité est habituellement meilleure que les Silvers. Ceux-ci sont rippés comme un DVD normal mais habituellement encodés en VCD.",
	//

	'videoformats_scene' => "Scene Tags...", 
	//
	'videoformats_proper' => "PROPER -", 
	'videoformats_proper1' => "Tag indiquant qu’il y a une amélioration par rapport à une version précédente. La raison du PROPER devrait toujours être indiquée dans le NFO.",
	//
	'videoformats_limited' => "LIMITED -", 
	'videoformats_limited1' => "Un film LiMiTED signifie qu’il est sorti dans un nombre restreint de cinémas (souvent moins de 250 cinémas). Il s’agit souvent de petits films comme les films sur l’art, etc.",
	//

    'videoformats_internal' => "INTERNAL -", 
	'videoformats_internal1' => "Ce tag est principalement utilisé pour les releases CAM ou TS et indique que la qualité est mauvaise. Il peut aussi y avoir d’autres raisons qui sont indiquées dans le fichier NFO.",
	//

	'videoformats_stv' => "STV -", 
	'videoformats_stv1' => "Straight to Video: n'a jamais été sorti dans les cinémas, donc beaucoup de sites ne permettent pas ces dernières. Normalement, ceci doit être très clairement dit dans le nom du dossier et dans le NFO.",
	//

    'videoformats_aspect' => "ASPECT RATIO TAGS -", 
	'videoformats_ws' => "C'est 'WS' for WideScreen (letterbox) et 'FS' pour FullScreen (plein écran). Selon les normes, les DVDRips sont toujours en WideScreen. Si ce n'est pas le cas, cela sera spécifié dans le nom de la release et dans le NFO.",
	//

    'videoformats_repack' => "REPACK -", 
	'videoformats_repack1' => "Si un groupe sort une mauvaise release, ils releaseront ensuite un 'FIX' qui réglera le problème (dirfix, nfofix, CD2fix, etc.) ou littéralement un REPACK si c'est le fichier de base qui avait un problème.",
	//

    'videoformats_nuked' => "NUKED -", 
	'videoformats_nuked1' => "Un film peut être nuked pour différentes raisons. Les différents sites veulent le nuke car la release ne suit pas leurs règles perso (telles que 'aucun Telesyncs' mais si la release a quelque chose extrêmement mauvais (aucune bande sonore pour 20mins, CD2 est incorrect film/game, etc...) alors un nuke global se produira et les gens qui le traderons à travers les sites perdront leurs crédits.",
    'videoformats_reason' => "Raisons du NUKE REASONS...", 
	'videoformats_reason1' => "Vous trouverez ci-dessous une liste des raisons communes pour qu'un film puisse être nuked (généralement DVDRip)",

    'videoformats_badar' => "BAD A/R",
	'videoformats_badar1' => "= mauvais aspect ratio, par ex. les personnages apparaissent minces",

    'videoformats_badivtc' => "BAD IVTC",
	'videoformats_badivtc1' => "= mauvais téléciné. la conversion des trames était incorrecte.",

    'videoformats_interlaced' => "INTERLACED",
	'videoformats_interlaced1' => "= des lignes noires en mouvement apparaissent sur la vidéo à l'écran dans un des champs de l'image.",
	//

    'videoformats_dupe' => "DUPE -",

    'videoformats_dupe1' => "Ce terme signifie simplement que si quelque chose a déjà été releasé, il n'y a aucune raison de le refaire sauf si 'PROPER' avec de bonnes raisons.",
	//
    'videoformats_header' => "Formats Video"
);
?>