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
    //Headers
    'stdhead_templates' => 'Templates',
    //Main table
    'themes_id' => 'ID',
    'themes_name' => 'Nom',
    'themes_uri' => 'Fichier CSS',
    'themes_is_folder' => 'Répertoire existant ?',
    'themes_e_d' => 'Editer/Supprimer',
    'themes_edit' => 'Editer',
    'themes_delete' => 'Supprimer',
    'themes_file_exists' => '<font color=\'green\'>Oui</font>',
    'themes_not_exists' => '<font color=\'red\'>Non</font>',
    //Other Stuff
    'themes_use_temp' => 'Utiliser cette template',
    'themes_addnew' => 'Ajouter une template',
    'themes_edit_tem' => 'Editer Template', //---' <Template Name>' added in source
    'themes_edit_uri' => 'Editer Fichier CSS',
    'themes_save' => 'Sauvegarder',
    'themes_add' => 'Ajouter',
    'themes_some_wrong' => 'Il y a eu un problème',
    'themes_delete_sure_q' => 'Etes-vous sûr de vouloir supprimer cette template ??',
    'themes_delete_sure_q2' => 'Cliquez ici',
    'themes_delete_sure_q3' => 'si vous êtes sûr',
    'themes_delete_q' => 'Supprimer Template',
    'themes_takenids' => 'ID utilisée: ',
    //Messages
    'themes_msg' => 'Edité avec succès',
    'themes_msg1' => 'Sauvegardé avec succès',
    'themes_msg2' => 'Spprimé avec succès',
    'themes_msg3' => 'Ajouté avec succès',
    //Guide/Explains
    'themes_guide' => "<ul>

<li>Créer un répertoire dans /Templates/</li>

<li>Créer un fichier PHP nommé template.php à l'intérieur du répertoire créé (étape 1)</li>

<li>Le fichier template.php doit comporter au minimum 4 fonctions

<ul>

<li>stdhead</li>

<li>stdfoot</li>

<li>stdmsg</li>

<li>StatusBar</li>

</ul></li>

</ul>

",
    'themes_explain_id' => 'Cela doit correspondre au num du répertoire',
    //Errors
    'themes_error' => 'Erreur',
    'themes_inv_act' => 'Action Invalide',
    'themes_inv_id' => 'ID Invalide',
    'themes_inv_uri' => 'Fichier CSS Invalide',
    'themes_inv_name' => 'Nom Invalide',
    'themes_nofile' => "Le fichier Template n'existe pas",
    'themes_inv_file' => 'Continuer ?',
    //Credits
    'themes_credits' => 'Credits to AronTh for making this template mananger and the template system',
);
?>