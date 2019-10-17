<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017-2019 Pierre Duhem — LMDI
* French version
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_ML_HIDEGUESTS'		=> 'Montrer les liens aux invités',
	'ACP_ML_HIDEGUESTS_EXPLAIN' => 'Cochez cette option pour montrer les liens aux invités. Décochez-la pour les cacher et ne les montrer qu’aux membres de votre forum.',
	'ACP_ML_PREPEND'		=> 'Liens ajoutés au début de la barre de navigation',
	'ACP_ML_PREPEND_EXPLAIN'	=> 'Le tableau ci-dessous énumère les liens qui peuvent être inclus au début de la barre de navigation (avant le lien de la FAQ). Seuls sont inclus ceux dont la case est cochée. Les autres sont en réserve.',
	'ACP_ML_NOTE'			=> '<b>Nota bene&nbsp;:</b> Tenez bien compte de la place que chacun de ces liens peut occuper dans l’espace disponible sur la barre de navigation. S’il n’y a pas assez de place pour afficher vos liens, phpBB place tous les éléments dans le menu déroulant Accès rapide, si bien que la barre de navigation apparaît totalement vide.',
	'ML_NAME'				=> 'Texte du lien',
	'ML_TITLE'			=> 'Texte affiché au survol',
	'ML_URL'				=> 'URL du lien',
	'ML_ENABLED'			=> 'Validé',
	'ML_GUESTS'			=> 'Invités',
	'ML_ADD_LINK'			=> 'Créer un nouveau lien',
	'ACP_ML_APPEND'		=> 'Liens ajoutés à la fin de la barre de navigation',
	'ACP_ML_APPEND_EXPLAIN'	=> 'Le tableau ci-dessous énumère les liens qui peuvent être inclus à la fin de la barre de navigation (entre le lien de la FAQ et ceux vers le PCA et le PCM). Voir ci-dessus les explications relatives à la case à cocher.',
	'ACP_ML_HIDE_LINKS'		=> 'Masquage des liens pour les invités (visiteurs non inscrits)',
	'ACP_ML_HIDE_EXPLAIN'	=> 'Vous pouvez choisir d’afficher ou non les liens lorsque le visiteur est un invité (qui ne s’est pas inscrit sur le forum).',
	'MULTILINK_CONFIG_UPDATED'	=> 'La configuration de l’extension a été mise à jour.',
	'ACP_ADD_URL_PP'		=> 'Création d’un nouveau lien au début de la barre de navigation',
	'ACP_ADD_URL_AP'		=> 'Création d’un nouveau lien à la fin de la barre de navigation',
	'ACP_ED_URL_PP'		=> 'Édition d’un lien au début de la barre de navigation',
	'ACP_ED_URL_AP'		=> 'Édition d’un lien à la fin de la barre de navigation)',
	'ACP_MULTILINK_ANCHOR'	=> 'Terme affiché dans la barre de navigation',
	'ACP_ML_ANCHOR_EXPLAIN'	=> 'Terme cliquable affiché à l’écran, par exemple « phpBB ».',
	'ACP_MULTILINK_TITLE'	=> 'Texte affiché au survol',
	'ACP_ML_TITLE_EXPLAIN'	=> 'Saisissez ici le texte explicatif qui doit être affiché dans une infobulle lorsque le curseur survole le lien.',
	'ACP_MULTILINK_URL'		=> 'URL utilisée',
	'ACP_ML_URL_EXPLAIN'	=> 'Adresse de la page à afficher. Par exemple, URL du site phpBB.',
	'ACP_MULTILINK_ENABLED'	=> 'Lien validé',
	'ACP_ML_ENABLED_EXPLAIN'	=> 'Cochez cette case si le lien doit être affiché dans la barre de navigation.',
	'ACP_MULTILINK_BLANK'	=> 'Lien avec target="_blank"',
	'ACP_ML_BLANK_EXPLAIN'	=> 'Cochez cette case si vous voulez que le lien s’ouvre dans une nouvelle fenêtre.',
	'ACP_MULTILINK_FA'		=> 'Utiliser une icône Font Awesome',
	'ACP_ML_FA_EXPLAIN'		=> 'Indiquez ici l’icône Font Awesome à utiliser. Visitez le <a href="http://fontawesome.io/icons/" target="_blank">site Font Awesome</a> pour connaître les possibilités offertes par cette police. Il suffit d’ajouter le préfixe &#8216;fa-’ devant le nom. Choisissez « Non » pour choisir un fichier graphique. Si vous ne spécifiez ni icône, ni fichier graphique, l’icône utilisée est fa-external-link (&#xF08e;).',
	'ACP_MULTILINK_ICON'	=> 'Utiliser une icône classique',
	'ACP_ML_ICON_EXPLAIN'	=> 'Indiquez ici l’icône classique à utiliser. Par défaut, l’extension utilise icon-faq. Voir également icon-acp, icon-mcp, icon-search, etc. Voir la liste dans styles/colours.css.',
	'ACP_MULTILINK_FILE'	=> 'Utiliser un fichier graphique',
	'ACP_ML_FILE_EXPLAIN'	=> 'Indiquez ici l’URL d’un fichier graphique à utiliser pour accompagner le lien. Il peut s’agir d’une URL distante (à saisir complète) ou d’une URL locale (sur le serveur du forum). Types de fichiers acceptés&nbsp;: gif, png. Si l’image fait plus de 20&nbsp;x&nbsp;20 pixels, elle sera réduite à ces dimensions.',
	'ACP_ML_TRANSFER'		=> 'Transférer dans l’autre table',
	));
