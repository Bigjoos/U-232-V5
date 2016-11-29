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
    //takeupload errors
    'takeupload_failed' => "Upload raté!",
    'takeupload_no_formdata' => "il manque des données",
    'takeupload_no_filename' => "Nom de fichier vide!",
    'takeupload_no_nfo' => "Pas de NFO!",
    'takeupload_0_byte' => "0-byte NFO",
    'takeupload_nfo_big' => "NFO est trop lourd! Max 65,535 bytes.",
    'takeupload_nfo_failed' => "NFO n'a pas été uploadé",
    'takeupload_no_descr' => "Vous devez entrer une description ou un NFO!",
    'takeupload_no_cat' => "Vous devez sélectionner une catégorie où placer le torrent!",
    'takeupload_invalid' => "Nom de fichier invalide!",
    'takeupload_not_torrent' => "Nom de fichier invalide (pas un .torrent).",
    'takeupload_eek' => "eek",
    'takeupload_no_file' => "Fichier vide!",
    'takeupload_not_benc' => "Que diable avez vous uploadé? Ce n'est pas un fichier bencoded!",
    'takeupload_not_dict' => "pas un dictionnaire",
    'takeupload_no_keys' => "Manque de(s) clef(s) au dictionnaire",
    'takeupload_invalid_entry' => "entrée invalide au dictionnaire",
    'takeupload_dict_type' => "mauvaise entrée du type de dictionnaire",
    'takeupload_unkown' => "Inconnu",
    'takeupload_pieces' => "pièces invalides",
    'takeupload_url' => "Announce URL invalide! Ce doit être <b>%s</b>",
    'takeupload_both' => "manque à la fois taille et fichiers",
    'takeupload_no_files' => "aucun fichier",
    'takeupload_error' => "erreur de nom de fichier",
    'takeupload_already' => "torrent déjà uploadé!",
    'takeupload_log' => "Le Torrent %s (%s) a été uploadé par %s",
    'takeupload_img_failed' => "Upload d'image raté",
    'takeupload_img_type' => "Format d'image invalide.",
    'takeupload_img_big' => "Le fichier image est trop lourd! Max 512,000 bytes.",
    'takeupload_img_exists' => "Une image existe déjà. Contacter le staff pour une assistance.",
    'takeupload_img_copyerror' => "Une erreur est survenue pendant la copie de l'image. Contacter le staff pour une assistance.",
    'takeupload_bucket_format' => "L'image que vous tentez (%s) d'uploader n'est pas conforme!",
    'takeupload_bucket_size' => "L'image est trop grande (%s)! taille max de " . mksize($INSTALLER09['bucket_maxsize']) ,
    'takeupload_no_youtube' => "Le lien youtube est incorrect ou n'est pas présent!",
    'takeupload_bucket_noimg' => "Vous avez tout oublié à propos des images!",
    ////////
    'takeupload_no_md' => "Pas de README.md!",
    'takeupload_0_md' => "0-byte README.md",
    'takeupload_md_big' => "README.md est trop lourd! Max 65,535 bytes.",
    'takeupload_md_failed' => "README.md n'a pas été uploadé"
);
?>