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
    //invite errors
    'invites_error' => "Erreur",
    'invites_deny' => "Refusé!",
    'invites_limit' => "Désolé, la limite d'utilisateur est atteinte. Merci d'essayer un autre jour.",
    'invites_disabled' => "Vos droits à inviter ont été désactivés par le Staff!",
    'invites_noinvite' => "Aucune invitation!",
    'invites_invalidemail' => "Hum, ça ne ressemble pas à une adresse email valide.",
    'invites_noemail' => "Vous devez entrer une adresse email!",
    'invites_unable' => "Impossible d'envoyer un email. Contactez un  an administrateur pour ce problème.",
    'invites_confirmation' => "Un email de confirmation a été envoyé à l'adresse que vous avez indiqué.",
    'invites_invalid' => "ID Invalide!",
    'invites_noexsist' => "Ce code d'invitation n'existe pas.",
    'invites_sure' => "Etes-vous sûr de vouloir supprimer ce code d'invitation?",
    'invites_errorid' => "Aucun membre avec cet ID.",
    'invites_sure1' => "Etes-vous sûr de vouloir confirmer le compte de",
    //invites
    'invites_users' => "Membres invités",
    'invites_nousers' => "Aucun invité pour l'instant",
    'invites_username' => "Pseudo",
    'invites_uploaded' => "Uploadé",
    'invites_downloaded' => "Downloadé",
    'invites_ratio' => "Ratio",
    'invites_status' => "Status",
    'invites_confirm' => "Confirmer",
    'invites_confirm1' => "Confirmé",
    'invites_pend' => "En attente",
    'invites_codes' => "Codes d'invitation générés",
    'invites_nocodes' => "Vous n'avez généré aucun code d'invitation pour le moment!",
    'invites_date' => "Date de création",
    'invites_delete' => "Supprimer",
    'invites_create' => "Générer un Code Invitation",
    'invites_send_code' => "Envoyer un Code Invitation",
    'invites_delete1' => "Supprimer Invitation",
    'invites_confirm1' => "Compte Confirmé",
    //addterms by yoooov
    'invites_sure2' => "? Cliquez ",
    'invites_sure3' => "ICI",
    'invites_sure4' => " pour confirmer ou ",
    'invites_sure5' => " pour revenir en arrière.",    
    'invites_err1' => "Désolé",
    'invites_err2' => "Votre compte est suspendu",
    'invites_invits' => "Invitations",
    ///
    'invites_mail_email' => "Email",
    'invites_mail_send' => "Envoyer Email",
    'invites_mail_err' => "Cette addresse Email est déjà utilisée!",
    'invites_send_emailpart1' => "Vous avez été invité sur {$INSTALLER09['site_name']} par",
	'invites_send_emailpart2' => "\n\nVotre adresse Email ",
	'invites_send_emailpart3' => "nous a été fourni par ce membre.\n
Si vous ne connaissez pas cette personne, ignore cet email.\n
Merci de na pas répondre.

Ce site est privé et vous devez agréer l'ensemble des règles avant d'en faire usage :\n

- Règles Utilisateur :: {$INSTALLER09['baseurl']}/useragreement.php\n

- Règles Générales :: {$INSTALLER09['baseurl']}/rules.php\n

- FAQ :: {$INSTALLER09['baseurl']}/faq.php\n

------------------------------------------------------------

Pour confirmer votre invitation, vous devez suivre ce lien et taper le code d'invitation suivant:

{$INSTALLER09['baseurl']}/invite_signup.php

Code d'invitation : ",
	'invites_send_emailpart4' => "\n
------------------------------------------------------------

Après cela, votre 'tuteur' devra confirmer votre compte. 
Nous insistons sur ce fait : bien lire les REGLES et les FAQs avant d'utiliser {$INSTALLER09['site_name']}.",
	///
	'invites_send_email1_ema' => "Vous avez été invité sur {$INSTALLER09['site_name']}",
	'invites_send_email1_bod' => "De: {$INSTALLER09['site_email']}",
	///
    'invites_send_email2' => "Salut :wave:
Bienvenue sur {$INSTALLER09['site_name']}!\n
Nous avons modifié en profondeur le site, nous espèrons que cela vous plaira!\n 
Nous avons travailler dur pour faire de {$INSTALLER09['site_name']} quelquechose de spécial!\n
{$INSTALLER09['site_name']} rassemble une large communauté (jeter un coup d'oeil aux forums), et propose de nombreuse fonctions.\n
Nous espèrons que vous prendrez autant de plaisir que nous à naviguer dessus!\n
Soyez sûr de lire les [url={$INSTALLER09['baseurl']}/rules.php]Règles[/url] comme les [url={$INSTALLER09['baseurl']}/faq.php]FAQs[/url] avant d'utiliser le site.\n
Nous sommes une communauté bien soudée :D {$INSTALLER09['site_name']} est bien plus qu'un anuaire supplémentaire de torrents.\n
En cadeau de bienvenue, nous vous offrons 200.0 points bonus de Karma, et quelques GB histoire de se lancer sans crainte!\n 
Alors, profitez!!!\n  
Bien à vous,\n 
{$INSTALLER09['site_name']} Le Staff.\n",
	///
	'invites_send_email2_sub' => "Bienvenue sur {$INSTALLER09['site_name']} !"
);
?>