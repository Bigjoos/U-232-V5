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
    //upload errors
    'upload_sorry' => "Désolé...",
    'upload_no_auth' => "Vous n'êtes pas autorisé à uploader des torrents.  (Voir <a href='faq.php#up'>Upload</a> dans les FAQ.)",
    'upload_announce_url' => "L'URL announce du tracker est",
    'upload_delete' => "Supprimer",
    //upload options
    'upload_torrent' => "Fichier Torrent",
    'upload_poster' => "Affiche (Poster)",
    'upload_poster1' => "(Taille minimum de 400 Px de large, toute taille supérieure sera redimensionnée.)",
    'upload_name' => "Nom du Torrent",
    'upload_filename' => "Pris sur le nom du fichier si non spécifié. <b>SVP utilisez des noms descriptifs.</b>",
    'upload_description' => "Description",
    'upload_small_descr' => "Description sommaire pour le fichier torrent. Cette description est visible sous le nom du torrent dans browse.php.",
    'upload_nfo' => "Fichier NFO",
    'upload_nfo_info' => "<b>Optionnel.</b> Ne peut être vu que par les Power users.",
    'upload_small_description' => "Description sommaire",
    'upload_html_bbcode' => "Le HTML est interdit. <a href='tags.php'>Cliquez ICI</a> pour une information sur les Balises BBcode disponibles.",
    'upload_choose_one' => "Choisir un type",
    'upload_anonymous' => "Upload anonyme",
    'upload_anonymous1' => "Ne pas montrer mon pseudo dans le champ 'Uploadé par'",
    'upload_type' => "Catégorie",
    'upload_submit' => "Uploader!",
    'upload_imdb_url' => "URL Imdb",
    'upload_imdb_tfi' => "(Pris du site Imdb - ",
    'upload_imdb_rfmo' => "Ajoutez l'URL Imdb pour afficher les informations issues du site Imdb pour les détails du torrent.)",
    'upload_youtube' => '<a href=\'http://youtube.com\' target=\'_blank\'>Youtube</a>',
    'upload_youtube_info' => 'Lien direct Youtube, sera affiché dans les détails du torrent.<br/>Le lien doit être de cette forme <b>http://www.youtube.com/watch?v=camI8yuoy8U</b>',
    //upload stdhead
    'upload_comment' => "Autoriser les commentaires",
    'upload_discom1' => "Cocher pour désactiver les commentaires des membres!",
    'upload_stdhead' => "Upload",
    //upload bitbucket
    'upload_bitbucket' => 'Bitbucket',
    'upload_tags' => "Tags",
    'upload_tag_info' => "Si plusieurs Tags sont listés, ils doivent être séparés par une virgule, ex: tag1,tag2",
    'upload_bitbucket_1' => "(Note* L'upload d'image est pris en charge par Bitbucket et elle est hébergée sur notre serveur.)",
    //addition terms by yoooov
    'upload_add_fill' => "Si vous remplissez une requête, selectionnez la ici, les membres intérressés seront notifiés.",
    'upload_add_noreq' => "Actuellement aucune requête",
    'upload_add_offer' => "Vous n'avez aucune offre approuvée pour l'instant",
    'upload_add_offer2' => "Si vous uploadez une de vos offres, sélectionnez la ici, les membres intérressés seront notifiés.",
    'upload_add_typ' => "Type de Release",
    'upload_add_typnone' => "None",
    'upload_add_typp2p' => "p2p",
    'upload_add_typscene' => "Scene",
    'upload_add_sub' => "Sous-titre",
    'upload_add_youtub' => "Placez votre lien Youtube ici. Le lien devra ressembler à cela http://www.youtube.com/watch?v=camI8yuoy8U",
    'upload_add_ascii' => "Codage ASCII",
    'upload_add_ascerr' => "Décocher en cas de Description en Langue Française",
    'upload_add_wascii' => "Qu'est-ce donc?",
    'upload_add_free' => "Freeleech",
    'upload_add_freeinf' => "Cochez pour mettre ce torrent en Freeleech",
    'upload_add_nofree' => "Pas Free",
    'upload_add_day1' => "Free pour 1 jour",
    'upload_add_week1' => "Free pour 1 semaine",
    'upload_add_week2' => "Free pour 2 semaines",
    'upload_add_week4' => "Free pour 4 semaines",
    'upload_add_week8' => "Free pour 8 semaines",
    'upload_add_unltd' => "Illimité",
    'upload_add_silv' => "Silver Torrent",
    'upload_add_nosilv' => "Pas Silver",
    'upload_add_sday1' => "Silver pour 1 jour",
    'upload_add_sweek1' => "Silver pour 1 semaine",
    'upload_add_sweek2' => "Silver pour 2 semaines",
    'upload_add_sweek4' => "Silver pour 4 semaines",
    'upload_add_sweek8' => "Silver pour 8 semaines",
    'upload_add_vip' => "VIP Torrent ",
    'upload_add_vipchk' => "Si cela est coché, seuls les VIPs peuvent téléchargés ce torrent",
    //add field to upload.php
	'upload_author' => "Nom Réalisateur : ",
	'upload_author_not_listed' => "Nom du réalisateur non listé, cliquez ici",
	'upload_choose_one' => "Choisissez un nom",
	//add readme.md file to upload
	'upload_readme' => "Fichier README.md",
    'upload_readme_info' => "<b>Optionnel.</b> Ne peut être vu que par les Power users.",
    /// allociné
    'upload_allo_code' => "Code Allociné",
    'upload_allo_tfi' => "(Pris du site Allociné - ",
    'upload_allo_rfmo' => "Indiquez seulement le code Allociné pris à la fin de l'URL pour afficher les informations issues du site.)"
);
?>