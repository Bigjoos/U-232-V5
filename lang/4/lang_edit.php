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
    //edit errors
    'edit_user_error' => "USER ERREUR",
    'edit_no_torrent' => "Aucun torrent trouvé",
    'edit_no_permission' => "<h1>Impossible d'éditer ce torrent</h1><p>Vous n'êtes pas le propriétaire, ou n'êtes <a href='login.php?returnto=%s&amp;nowarn=1'>connecté</a> convenablement.</p>",
    //edit options
    'edit_poster' => "Affiche (Poster)",
    'edit_poster1' => "Taille minimum de 400 Px de large, toute taille supérieure sera redimensionnée.",
    'edit_torrent_name' => "Nom du Torrent",
    'edit_torrent_description' => "Description sommaire",
    'edit_nfo' => "Fichier NFO :",
    'edit_keep_current' => " Conserver le NFO existant",
    'edit_update' => " ou Mettre à Jour :",
    'edit_description' => "Description",
    'edit_tags' => "Le HTML est interdit. <a href='tags.php'>Cliquez ICI</a> pour une information sur les Balises BBcode disponibles.",
    'edit_type' => "Catégorie",
    'edit_visible' => "Visible",
    'edit_visible_mainpage' => "Visible sur la page principale",
    'edit_visible_info' => "Notez que les torrents sont automatiquement visibles dès qu'il y a un seeder, et redeviennent invisibles (dead) lorsqu'il n'y a pas eu de seeders d'un moment. Cette fonction permet d'accélérer le processus. Notez aussi que les torrents invisibles peuvent quand même être vus ou cherchés, ce n'est juste pas l'option par défaut.",
    'edit_banned' => "Banni",
    'edit_anonymous' => "Uploader Anonyme",
    'edit_anonymous1' => "Cocher cette case pour cacher le nom de l'uploader",
    'edit_revert' => "Annuler les changements",
    'edit_submit' => "Editer!",
    'edit_delete_torrent' => "Supprimer le torrent",
    'edit_reason' => "Raison:",
    'edit_dead' => "Mort (Dead)",
    'edit_peers' => "0 seeders, 0 leechers = 0 peers au total",
    'edit_dupe' => "Doublon",
    'edit_nuked' => "Nuked",
    'edit_rules' => "Règles TB",
    'edit_req' => "Requis",
    'edit_other' => "Autre:",
    'edit_delete' => "Supprimer!",
    'edit_image' => "Image",
    'edit_image_leave' => "Laisser",
    'edit_image_del' => "Supprimer",
    'edit_image_up' => "Mettre à Jour :",
    'edit_cover' => "Fichier(s) de couverture",
    'edit_cover_add' => "Ajouter plus",
    'edit_imdb_url' => "URL Imdb",
    'edit_comment' => "Autoriser les Commentaires",
    'edit_youtube' => '<a href=\'http://youtube.com\' target=\'_blank\'>Youtube</a>',
    'edit_youtube_info' => "Placez votre lien Youtube ici. Le lien devra ressembler à cela http://www.youtube.com/watch?v=camI8yuoy8U",
    'edit_torrent_tags' => "Tags du Torrent",
    'edit_tags_info' => "Si plusieurs Tags sont listés, ils doivent être séparés par une virgule, ex: tag1,tag2",
    'edit_recommend' => "Si vous voulez recommander ce torrent cocher cette case!",
    'edit_recommend_torrent' => "Torrent Recommandé",
    //edit stdhead
    'edit_stdhead' => "Editer le Torrent",
    //add terms by yoooov
    'edit_curr' => " est en train d'éditer ce torrent!",
    'edit_clkhere' => "Cliquez ici",
    'edit_clktemp' => " pour ajouter une notification d'édition temp pendant que vous éditez ce torrent",
    'edit_tube' => "Editer le lien Youtube",
    'edit_scene' => "Scene",
    'edit_p2p' => "p2p",
    'edit_none' => "Autre",
    'edit_relgrp' => "Type de Release:",
    'edit_subs' => "Sous-titres:",
    'edit_banned2' => "Bannir le Torrent",
    'edit_yes' => "Oui",
    'edit_no' => "Non",
    'edit_nukr' => "Motif de Nuke",
    'edit_add_day1' => "Free pour 1 jour",
    'edit_add_week1' => "Free pour 1 semaine",
    'edit_add_week2' => "Free pour 2 semaines",
    'edit_add_week4' => "Free pour 4 semaines",
    'edit_add_week8' => "Free pour 8 semaines",
    'edit_add_unltd' => "Illimité",
    'edit_add_free' => "Freeleech ",
    'edit_add_nofree' => " Retirer le Freeleech",
    'edit_add_silver' => "Silver torrent ",
    'edit_add_nosilver' => " Retirer le Silver Torrent",
    'edit_add_sday1' => "Silver pour 1 jour",
    'edit_add_sweek1' => "Silver pour 1 semaine",
    'edit_add_sweek2' => "Silver pour 2 semaines",
    'edit_add_sweek4' => "Silver pour 4 semaines",
    'edit_add_sweek8' => "Silver pour 8 semaines",
    'edit_free_dur1' => "Free Leech Duration",
    'edit_until' => "Until ",
    'edit_silv_dur1' => "Silver torrent Duration ",
    'edit_com_allow' => "Les Commentaires sont autorisés pour tous sur ce torrent!",
    'edit_com_only' => "Seuls les membres du staff peuvent commenter sur ce torrent!",
    'edit_stick1' => "Epinglé",
    'edit_stick2' => "Epingler ce torrent !",
    'edit_vip1' => "Torrent VIP ?",
    'edit_vip2' => " Si cela est coché, seuls les VIPs peuvent télécharger ce torrent",
    'edit_makefree' => " Cocher pour mettre ce Torrent en Freeleech",
    'edit_opt_genre' => "(Optionnel)",
    'edit_touch1' => "Laisser ce Genre",
    'edit_touch2' => "Actuel: "
);
?>