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
	//ers
	'usersearch_error' => 'Erreur',
	'usersearch_warn' => 'Attention',
	'usersearch_bademail' => 'Mauvais email',
	'usersearch_badip' => 'Mauvaise IP',
	'usersearch_badmask' => 'Mauvais masque de sous-réseau',
	'usersearch_badratio' => 'Mauvais ratio',
	'usersearch_badratio2' => 'Deux ratios sont requis pour ce type de recherche.',
	'usersearch_badratio2' => 'Mauvais 2ème ratio.',
	'usersearch_badup' => "Mauvais taux d'upload.",
	'usersearch_badup2' => "Deux taux d'upload sont requis pour ce type de recherche.",
	'usersearch_badup3' => "Mauvais 2ème taux d'upload.",
	'usersearch_baddl' => 'Mauvais taux de download.',
	'usersearch_baddl2' => "Deux taux de download sont requis pour ce type de recherche.",
	'usersearch_baddl3' => "Mauvais 2ème taux de download",
	'usersearch_baddate' => 'Date invalide',
	'usersearch_baddate2' => "Deux dates sont requises pour ce type de recherche.",
	'usersearch_nouser' => "Aucun user n'a été trouvé.",
	//temp thingy
	'usersearch_count' => 'Count Query',
	'usersearch_query' => 'Search Query',
	'usersearch_url' => 'URL Paramètres \'Actuallement\' Utilisé',
	//main table
	'usersearch_window_title' => 'Recherche Administrative de User',
	'usersearch_title' => 'Recherche Administrative de User',
	'usersearch_inlink' => 'Instructions',
	'usersearch_reset' => 'Reset',
	'usersearch_name' => 'Nom',
	'usersearch_ratio' => 'Ratio',
	'usersearch_status' => 'Status du Membre',
	'usersearch_email' => 'Email',
	'usersearch_ip' => 'IP',
	'usersearch_acstatus' => 'Status du Compte',
	'usersearch_comments' => 'Commentaires',
	'usersearch_mask' => 'Masque',
	'usersearch_class' => 'Classe',
	'usersearch_joined' => 'Rejoins le',
	'usersearch_uploaded' => 'Uploadé',
	'usersearch_donor' => 'Donateur',
	'usersearch_lastseen' => 'Dernier login',
	'usersearch_downloaded' => 'Downloadé',
	'usersearch_warned' => 'Averti',
	'usersearch_active' => 'Seulement actif',
	'usersearch_banned' => 'IP désactivé',
	'usersearch_hnrwarn' => 'Averti pour HnR',
	//second table
	'usersearch_enabled' => 'Activé',
	'usersearch_asts' => 'Status',
	'usersearch_history' => 'Historique',
	'usersearch_pR' => 'pR',
	'usersearch_pUL' => 'pUL (MB)',
	'usersearch_pDL' => 'pDL(MB)',
	//select area
	'usersearch_equal' => 'égal à',     
	'usersearch_above' => 'au-dessus de',     
	'usersearch_below' => 'en-dessous de', 
	'usersearch_between' => 'entre', 
	'usersearch_any' => "(tous)",
	'usersearch_confirmed' => "confirmé",
	'usersearch_pending' => "en attente",
	'usersearch_enabled' => "activé",
	'usersearch_disabled' => "désactivé",
	'usersearch_on' => "le",
	'usersearch_before' => "avant le",
	'usersearch_after' => "après le",
	'usersearch_yes' => "Oui",
	'usersearch_no' => "Non",
	'usersearch_create_ann' => "Créer une Nouvelle Annonce",
	    //instructions
	'usersearch_instructions' => "<table border='0' align='center'><tr><td class='embedded' bgcolor='#F5F4EA'><div align='left'>\n
	    Les champs laissés vides seront ignorés.\n <br /><br />
	    Des jockers * et ? peuvent être utilisés pour le Nom, l'Email ou les Commentaires, tout comme de multiples valeurs\n
	    séparées par des espaces (ex. 'wyz Max*' dans le champ Nom listera tous les membres nommés\n
	    'wyz' et ceux dont le nom commence par 'Max'. De la même manière  '~' peut être employé pour la\n
	    négation, ex. '~alfiest' dans le champ Commentaires restreindra la recherche aux membres\n
	    qui ne comportent pas 'alfiest' dans leurs commentaires).<br /><br />\n
       Le champ Ratio accepte 'Inf' and '---' à côté d'une valeur numérique.<br /><br />\n
	    Le masque de sous-réseau peut-être entré à la fois en valeur décimale ou en notation CIDR\n
	    (ex. 255.255.255.0 est identique à /24).<br /><br />\n
       Le champ Uploadé et Downloadé doivent être renseigné en GB.<br /><br />\n
	    Pour les paramètres de recherche avec de multiples champs de textes, le second sera ignoré\n
	    sauf s'il est adéquat au type de recherche choisi. <br /><br />\n
	    'Seulement Actif' restreint la recherche aux membres qui actuellement sont en seed ou en leech,\n
	    'IP désactivé' pour ceux dont l'IP est visible dans des comptes désactivés.<br /><br />\n
	    La colonne 'p' des résultats montrent des stats partielles, liées aux torrents en activité. <br /><br />\n
	    La colonne historique liste le nombre de publications forum et de commentaires torrents,\n
	    respectivement, et propose un lien direct aux pages d'historiques correspondantes.\n
	    </div></td></tr></table><br /><br />\n"
);
?>