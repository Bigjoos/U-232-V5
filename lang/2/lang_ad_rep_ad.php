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
	//show_level
	'rep_ad_show_title' => "Gestionnaire de Réputation Utilisateur - Vue d'ensemble",
	'rep_ad_show_html1' => "Sur cette page vous pouvez modifier le taux minimum requis pour chaque niveau de réputation. Soyez sûr d'avoir cliqué sur Update Minimum Levels pour sauvegarder les modifications. Vous ne pouvez pas appliquer le même taux minimum à plus d'un niveau.",
	'rep_ad_show_html2' => "Vous pouvez aussi choisir d'éditer ou supprimer un niveau. Cliquez sur le lien Editer pour modifier la description du niveau (voir Editer un niveau de Réputation) ou cliquez sur Supprimer pour en supprimer un. Si vous supprimer un niveau ou modifier le taux minimum nécessaire à un niveau, toutes les Réputations des utilisateurs seront mise à jour pour s'accorder au besoin à la nouvelle définition du niveau.",
	'rep_ad_show_head' => "Gestionnaire de Réputation Utilisateur",
	'rep_ad_show_comments' => "Voir les commentaires",
	'rep_ad_show_id' => "ID",
	'rep_ad_show_level'	 => "Niveau de Réputation",
	'rep_ad_show_min' => "Taux Minimum du Niveau",
	'rep_ad_show_controls' => "Contrôles",
	'rep_ad_show_user' => "Utilisateur",
	'rep_ad_show_edit' => "Editer",
	'rep_ad_show_del' => "Supprimer",
	'rep_ad_show_update' => "Mettre à Jour",
	'rep_ad_show_reset' => "Reset",
	'rep_ad_show_add' => "Ajouter un Nouveau",
	//show_form
	'rep_ad_form_html' => "Cela vous permez d'ajouter un nouveau niveau de réputation ou d'éditer un existant.",
	'rep_ad_form_error' => "Erreur:",
	'rep_ad_form_error_msg' => "SVP spécifiez un ID.",
	'rep_ad_form_title' => "Editer Niveau de Réputation",
	'rep_ad_form_id' => "ID:#",
	'rep_ad_form_btn' => "MàJ",
	'rep_ad_form_back' => "Retour",
	'rep_ad_form_add_title' => "Ajouter Nouveau niveau de réputation",
	'rep_ad_form_add_btn' => "Sauvegarder",
	'rep_ad_form_desc' => "Description du Niveau",
	'rep_ad_form_descr' => "C'est ce qui est affiché aux utilisateurs lorsque les points de réputation sont en-dessous du taux défini comme minimum.",
	'rep_ad_form_min' => "Taux minimum de points de réputation requis pour ce niveau",
	'rep_ad_form_option' => "Ce taux peut être positif ou negatif. Quand les points de réputation d'un utilisateur atteignent de taux, la description ci-dessus sera alors affichée.",
	//do_update
	'rep_ad_update_err1' => "Le texte entré est trop court.",
	'rep_ad_update_err2' => "Le texte entré est trop long.",
	'rep_ad_update_saved' => "Niveau de Reputation sauvegardé",
	'rep_ad_update_success' => "Avec succès.",
	'rep_ad_update_err3' => "L'ID n'est pas valide.",
	'rep_ad_update_err4' => "Aucun ID valide.",
	'rep_ad_update_save_success' => "Niveau de Reputation sauvegardé avec succès.",
	//do_delete
	'rep_ad_delete_no' => "Rép ID n'existe pas",
	'rep_ad_delete_success' => "Réputation supprimée avec succès",
	//show_form_rep
	'rep_ad_rep_form_nothing' => "Rien ici avec cet ID.",
	'rep_ad_rep_form_title' => "Gestionnaire de Réputation Utilisateur",
	'rep_ad_rep_form_erm' => "Erm, ce n'est pas ici!",
	'rep_ad_rep_form_head' => "Editer Réputation",
	'rep_ad_rep_form_topic' => "Topic",
	'rep_ad_rep_form_left_by' => "Laissé par",
	'rep_ad_rep_form_left_for' => "Laissé pour",
	'rep_ad_rep_form_comment' => "Commentaire",
	'rep_ad_rep_form_rep' => "Réputation",
	'rep_ad_rep_form_save' => "Sauvegarder",
	'rep_ad_rep_form_reset'	 => "Reset",
	//view_list
	'rep_ad_view_title' => "Gestionnaire de Réputation Utilisateur",
	'rep_ad_view_view' => "Voir les commentaires de Réputation",
	'rep_ad_view_page' => "Cette page  vous permet de rechercher les commentaires de réputation laissés par / pour des utilisateurs particuliers après la date spécifiée.",
	'rep_ad_view_for' => "Laissé pour",
	'rep_ad_view_for_txt' => "Pour limiter les commentaires laissés pour un utilisateur particulier, entrer son pseudo ici. Laissez ce champ vide pour recevoir les commentaires laissés pour tous les utilisateurs.",
	'rep_ad_view_by' => "Laissé par",
	'rep_ad_view_by_txt' => "Pour limiter les commentaires laissés par un utilisateur particulier, entrer son pseudo ici. Laissez ce champ vide pour recevoir les commentaires laissés par tous les utilisateurs.",
	'rep_ad_view_start' => "Date de lancement",
	'rep_ad_view_month' => "Mois",
	'rep_ad_view_day' => "Jour",
	'rep_ad_view_year' => "Année",
	'rep_ad_view_start_select' => "Sélectionnez une date de lancement pour cette réputation. Sélectionnez mois, jour, et année. La statistique sélectionnée ne doit pas être plus ancienne que cette date pour pouvoir être inclue à la réputation.",
	'rep_ad_view_end' => "Date de fin",
	'rep_ad_view_end_select' => "Sélectionnez une date de fin pour cette réputation. Sélectionnez mois, jour, et année. La statistique sélectionnée ne doit pas être plus récente que cette date pour pouvoir être inclue à la réputation. Vous pouvez utiliser ce réglage en conjonction de la date de lancement pour créer une fourchette de temps pour cette réputation.",
	'rep_ad_view_search' => "Chercher",
	'rep_ad_view_reset' => "Reset",
	'rep_ad_view_err1' => "Heure",
	'rep_ad_view_err2' => "La date de lancement est après la date de fin.",
	'rep_ad_view_err3' => "ERREUR DB",
	'rep_ad_view_err4' => "Utilisateur introuvable ",
	'rep_ad_view_cmts' => "Commentaire Réputation",
	'rep_ad_view_id' => "ID",
	'rep_ad_view_date' => "Date",
	'rep_ad_view_point' => "Point",
	'rep_ad_view_reason' => "Motif",
	'rep_ad_view_control' => "Contrôles",
	'rep_ad_view_none_found' => "Aucune occurence!",
	'rep_ad_view_records' => "Enregistrements",
	'rep_ad_view_err5' => "Rien ici",
	'rep_ad_view_edit' => "Editer",
	'rep_ad_view_delete' => "Supprimer",
	//do_delete_rep
	'rep_ad_delete_rep_err1' => "ERREUR",
	'rep_ad_delete_rep_err2' => "ID introuvable",
	'rep_ad_delete_rep_err3' => "EFFACER",
	'rep_ad_delete_rep_err4' => "L'ID n'est pas valide.",
	'rep_ad_delete_rep_success' => "Réputation supprimée avec succès",
	//do_edit_rep
	'rep_ad_edit_txt' => "TEXTE",
	'rep_ad_edit_short' => "Le texte entré est trop court.",
	'rep_ad_edit_long' => "Le texte entré est trop long.",
	'rep_ad_edit_input' => "ENTREE",
	'rep_ad_edit_noid' => "Aucun ID",
	'rep_ad_edit_saved' => "Réputation sauvegardée #ID",
	'rep_ad_edit_success' => "Avec succès.",
	//html_out
	'rep_ad_html_error' => "Erreur",
	'rep_ad_html_nothing' => "Aucune sortie de donnée...",
	//redirect
	'rep_ad_redirect_title' => "Rép Admin Redirection",
	'rep_ad_redirect_redirect' => "Redirection...",
	'rep_ad_redirect_block' => "Réglages Bloc",
	'rep_ad_redirect_not' => "Cliquez ici si vous n'êtes pas redirigés...",
	//get_month_dropdown
	'rep_ad_month_jan' => "Janvier",
	'rep_ad_month_feb' => "Février",
	'rep_ad_month_mar' => "Mars",
	'rep_ad_month_apr' => "Avril",
	'rep_ad_month_may' => "Mai",
	'rep_ad_month_june' => "Juin",
	'rep_ad_month_july' => "Juillet",
	'rep_ad_month_aug' => "Août",
	'rep_ad_month_sept' => "Septembre",
	'rep_ad_month_oct' => "Octobre",
	'rep_ad_month_nov' => "Novembre",
	'rep_ad_month_dec' => "Decembre",
	//rep_cache
	'rep_ad_cache_cache' => "CACHE",
	'rep_ad_cache_none' => "Aucun item à mettre en cache"
	);
	?>