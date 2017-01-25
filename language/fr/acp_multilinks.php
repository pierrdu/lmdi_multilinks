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
	'ACP_ML_PREPEND_EXPLAIN'	=> 'Vous pouvez ajouter un maximum de 5 liens au début de la barre de navigation (avant le lien vers la FAQ). Tenez bien compte de l’espace que chacun de ces liens peut prendre dans l’espace disponible.',
	'ML_NAME'				=> 'Légende du lien',
	'ML_TITLE'			=> 'Texte affiché au survol',
	'ML_URL'				=> 'URL du lien',
	'ML_BLANK'			=> 'Target = blank',
	'ML_ADD_LINK'			=> 'Création d’un nouveau lien',
	'ACP_ML_APPEND'		=> 'Liens ajoutés à la fin de la barre de navigation',
	'ACP_ML_APPEND_EXPLAIN'	=> 'Vous pouvez ajouter un maximum de 5 liens à la fin de la barre de navigation (après le lien vers la FAQ et avant ceux vers le PCA et le PCM). Tenez bien compte de l’espace que chacun de ces liens peut prendre dans l’espace disponible.',
	'MULTILINK_CONFIG_UPDATED'	=> 'La configuration de l’extension a été mise à jour.',
	'ACP_MULTILINK_ADD_URL'	=> 'Création d’un nouveau lien dans la barre de navigation',
	'ACP_ADD_URL_PP'		=> '(Addition au début de la barre de navigation)',
	'ACP_ADD_URL_AP'		=> '(Addition à la fin de la barre de navigation)',
	'ACP_MULTILINK_ANCHOR'	=> 'Terme affiché à l’écran',
	'ACP_MULTILINK_TITLE'	=> 'Texte affiché au survol',
	'ACP_MULTILINK_URL'		=> 'URL utilisée',
	'ACP_MULTILINK_BLANK'	=> 'Lien avec target="_blank"',
	'ACP_ML_ANCHOR_EXPLAIN'	=> 'Terme cliquable, par exemple « phpBB ».',
	'ACP_ML_TITLE_EXPLAIN'	=> 'Saisissez ici le texte explicatif qui doit être affiché dans une infobulle lorsque le curseur survole le lien.',
	'ACP_ML_URL_EXPLAIN'	=> 'Adresse de la page à afficher. Par exemple, URL du site phpBB.',
	'ACP_ML_BLANK_EXPLAIN'	=> 'Cochez cette case si vous voulez que le lien s’ouvre dans une nouvelle fenêtre.',
));
