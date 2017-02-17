<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017 Pierre Duhem — LMDI
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
	'ACP_ML_PREPEND'		=> 'Liens ajoutés au début de la barre de navigation',
	'ACP_ML_PREPEND_EXPLAIN'	=> 'Vous pouvez ajouter un <b>maximum</b> de 5 liens au début de la barre de navigation (avant le lien vers la FAQ).',
	'ACP_ML_NOTE'			=> '<b>Nota bene&nbsp;:</b> Tenez bien compte de l’espace que chacun de ces liens peut occuper dans l’espace disponible. phpBB place tous les éléments dans le menu déroulant Accès rapide s’il n’y a pas assez de place sur la barre de navigation pour afficher vos liens, si bien que la barre de navigation apparaît totalement vide.',
	'ML_NAME'				=> 'Légende du lien',
	'ML_TITLE'			=> 'Texte affiché au survol',
	'ML_URL'				=> 'URL du lien',
	'ML_ADD_LINK'			=> 'Création d’un nouveau lien',
	'ACP_ML_APPEND'		=> 'Liens ajoutés à la fin de la barre de navigation',
	'ACP_ML_APPEND_EXPLAIN'	=> 'Vous pouvez ajouter un <b>maximum</b> de 5 liens à la fin de la barre de navigation (entre le lien vers la FAQ et ceux vers le PCA et le PCM).',
	'MULTILINK_CONFIG_UPDATED'	=> 'La configuration de l’extension a été mise à jour.',
	'ACP_MULTILINK_ADD_URL'	=> 'Création d’un nouveau lien dans la barre de navigation',
	'ACP_ADD_URL_PP'		=> '(Addition au début de la barre de navigation)',
	'ACP_ADD_URL_AP'		=> '(Addition à la fin de la barre de navigation)',
	'ACP_MULTILINK_ANCHOR'	=> 'Terme affiché dans la barre de navigation',
	'ACP_MULTILINK_TITLE'	=> 'Texte affiché au survol',
	'ACP_MULTILINK_URL'		=> 'URL utilisée',
	'ACP_MULTILINK_BLANK'	=> 'Lien avec target="_blank"',
	'ACP_MULTILINK_FA'		=> 'Utiliser une icône Font Awesome',
	'ACP_MULTILINK_ICON'	=> 'Utiliser une icône classique',
	'ACP_MULTILINK_FILE'	=> 'Utiliser un fichier graphique',
	'ACP_ML_ANCHOR_EXPLAIN'	=> 'Terme cliquable affiché à l’écran, par exemple « phpBB ».',
	'ACP_ML_TITLE_EXPLAIN'	=> 'Saisissez ici le texte explicatif qui doit être affiché dans une infobulle lorsque le curseur survole le lien.',
	'ACP_ML_URL_EXPLAIN'	=> 'Adresse de la page à afficher. Par exemple, URL du site phpBB.',
	'ACP_ML_BLANK_EXPLAIN'	=> 'Cochez cette case si vous voulez que le lien s’ouvre dans une nouvelle fenêtre.',
	'ACP_ML_FA_EXPLAIN'		=> 'Indiquez ici l’icône Font Awesome à utiliser. Par défaut, fa-external-link. Pour rechercher les noms d’autres icônes, consultez le fichier assets/css/font-awesome.min.css.',
	'ACP_ML_ICON_EXPLAIN'	=> 'Indiquez ici l’icône classique à utiliser. Par défaut, l’extension utilise icon-faq. Voir également icon-acp, icon-mcp, icon-search, etc. Voir la liste dans styles/colours.css.',
	'ACP_ML_FILE_EXPLAIN'	=> 'Indiquez ici l’URL d’un fichier graphique à utiliser pour accompagner le lien. Il peut s’agir d’une URL distante (à saisir complète) ou d’une URL locale (sur le serveur du forum). Types de fichiers acceptés&nbsp;: gif, png. Si l’image fait plus de 20&nbsp;x&nbsp;20 pixels, elle sera réduite à ces dimensions.',
	'ACP_ML_TRANSFER'		=> 'Transférer dans l’autre table',
	'ACP_ML_TABLE_FULL'		=> 'La table de destination est déjà pleine. Abandon.',
	));
