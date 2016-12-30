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
    //takeeditcp
    'takeeditcp_no_data' => "Il manque des données",
    'takeeditcp_pass_long' => "Désolé, le mot de passe est trop long (max 40 caractères)",
    'takeeditcp_pass_not_match' => "Les mots de passe ne correspondent pas. Essayez à nouveau.",
    'takeeditcp_not_valid_email' => "...ça ne ressemble pas à une adresse Email valide!",
    'takeeditcp_address_taken' => "Modification adresse Email impossible, l'addresse est déjà prise ou le mot de passe ne correspond pas.",
    'takeeditcp_user_error' => "ERREUR UTILISATEUR",
    'takeeditcp_image_error' => "Ce n'est pas une image ou le format n'est pas pris en charge!",
    'takeeditcp_small_image' => "L'image est trop petite",
    'takeeditcp_confirm' => "Confirmation de la Modification du Profil",
    'takeeditcp_avatar_not_allow' => "Désolé - Le changement d'Avatar est désactivé pour votre classe",
	'takeeditcp_err' => "Erreur",
	'takeeditcp_uerr' => "ERREUR UTILISATEUR",
	'takeeditcp_img_unsupported' => "Ce n'est pas une image ou le format n'est pas pris en charge!",
	'takeeditcp_img_to_small' => "L'image est trop petite",
	'takeeditcp_sorry' => "Désolé",
	'takeeditcp_secret_long' => "la réponse secrète est trop longue (max 40 caractères)",
	'takeeditcp_secret_short' => "la réponse secrète est trop courte (min 6 caractères)",
	'takeeditcp_email_from' => "De: ",
	'takeeditcp_email_alert' => "Alerte Email",
	'takeeditcp_email_user' => "Le membre ",
	'takeeditcp_email_changed' => " a changé son adresse Email :",
	'takeeditcp_email_old' => " L'ancien email était ",
	'takeeditcp_email_new' => " le nouvel email est ",
	'takeeditcp_email_check' => ", merci de vérifier que la raison de ce changement était légitime.",
	'takeeditcp_invalid_custom' => "Titre personnalisé invalide!",
	'takeeditcp_birth_year' => "SVP renseignez votre année de naissance.",
	'takeeditcp_birth_month' => "SVP renseignez votre mois de naissance.",
	'takeeditcp_birth_day' => "SVP renseignez votre jour de naissance..",
	'takeeditcp_birth_not' => "La date saisie est invalide, merci de réessayer!",
);
$lang['takeeditcp_email_body'] = <<<EOD

Vous avez requis une modification du profil utilisateur (username <#USERNAME#>)

sur le site <#SITENAME#>, mis à jour avec cette adresse Email (<#USEREMAIL#>)

sur votre fiche contact.


Si vous n'avez rien changé, merci d'ignorer cet Email. La personne ayant utilisée

votre email s'est connectée avec cette IP <#IP_ADDRESS#>.

Merci de ne pas répondre à cet Email.


Pour finaliser la mise à jour de votre profil, merci de suivre ce lien:



<#CHANGE_LINK#>



Votre nouvelle adresse Email n'apparaitra sur votre profil qu'après cela.

Le cas échéant votre profil restera inchangé.

EOD;

?>