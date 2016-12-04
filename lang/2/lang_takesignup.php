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
    //takesignup
    'stderr_errorhead' => "Désolé",
	'takesignup_invite_only' => "Seulement sur Invitations - Les Enregistrements sont fermés, si vous avez un code d'invitation cliquez",
	'takesignup_here' => 'ICI',
    'takesignup_error' => "Erreur",
    'takesignup_limit' => "Désolé, le nombre max d'utilisateurs est atteint. Merci de réessayer plus tard.",
    'takesignup_user_error' => "ERREUR UTILISATEUR",
    'takesignup_form_data' => "Les données remplies sont invalides!",
    'takesignup_username_length' => "Pseudo trop long ou trop court",
    'takesignup_allowed_chars' => "Autorisé : abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.",
    'takesignup_blank' => "Ne laissez pas de champs vide.",
    'takesignup_nomatch' => "Les mots de passe ne correspondent pas! Vérifiez et réessayez.",
    'takesignup_pass_short' => "Désolé, le mot de passe est trop court (min de 6 caractères)",
    'takesignup_pass_long' => "Désolé, le mot de passe est trop long (max de 40 caractères)",
    'takesignup_same' => "Désolé, le mot de passe doit être différent du nom d'utilisateur.",
    'takesignup_validemail' => "L'adresse email ne semble pas valide.",
	'takesignup_birthday' => "Il faut remplir votre date de naissance.",
	'takesignup_correct_birthday' => "Vous devez remplir votre date de naissance correctement.",
	'takesignup_country' => "Vous devez sélectionner votre localité.",
	'takesignup_ip' => "Cette IP",
	'takesignup_ip_used' => "est déjà utilisée. Nous n'autorisons qu'un seul compte par adresse IP.",
	'takesignup_welcome' => "Bienvenue au nouveau",
	'takesignup_hey' => "Salut",
	'takesignup_msg_subject' => "Bienvenue",
	'takesignup_msg_body0' => "! Bienvenue à",
	'takesignup_msg_body1' => "! :clap2: \n\n Vérifiez votre connectivité avnt tout téléchargement ou tout upload de torrents\n - En cas de problème merci de jeter un oeil au Forum, aux FAQs ou envoyer un message au staff.\n\nBien à vous. Le Staff.\n",
	'takesignup_member' => "Membre: -",
	'takesignup_yearsold' => "Vous devez avoir au moins 18 ans pour pouvoir vous enregistrer.",
    'takesignup_invalidname' => "Pseudo Invalide.",
    'takesignup_failed' => "Enregistrement raté",
    'takesignup_qualify' => "Désolé, vous ne pouvez prétendre à une inscription sur ce site.",
    'takesignup_email_used' => "L'adresse e-mail est déjà utilisée.",
    'takesignup_user_exists' => "Pseudo déjà pris!",
    'takesignup_fatal_error' => "Erreur Fatale!",
    'takesignup_mail' => "",
    'takesignup_confirm' => "confirmation de l'enregistrement du membre",
    'takesignup_badusername' => "Le pseudo que vous essayez d'utiliser <b>(%s)</b> est sur notre liste noire, choisissez en un autre",
    'takesignup_bannedmail' => "Cette adresse email est bannie!<br /><br /><strong>Raison</strong>:",
    'takesignup_from' => "DE:",
	'takesignup_x_head' => "Hi Hi",
	'takesignup_x_body' => "Pas de bol, c'est raté!"
);
$lang['takesignup_email_body'] = <<<EOD

Vous avez requis un compte nouvel utilisateur sur <#SITENAME#> et vous avez
spécifié cette addresse (<#USEREMAIL#>) comme adresse de contact.

Si vous n'avez pas fait cela, merci d'ignorer cet email. La personne qui a entré
votre adresse email avit l'IP suivante : <#IP_ADDRESS#>. 
Merci de ne pas répondre à cet email.

Pour confirmer votre enregistrement, merci de suivre ce lien:

<#REG_LINK#>

Après cette confirmation, vous pourrez utiliser ce nouveau compte.
Sans confirmation de votre part, ce compte sera supprimé au bout de quelques jours.
Nous vous demandons aussi de bien lire les Règles et les FAQs avant de commencer
à utiliser le site <#SITENAME#>.
A très vite.
EOD;

?>