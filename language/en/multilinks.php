<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017-2022 Pierre Duhem — LMDI
* English version
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
	'ACP_MULTILINKS_TITLE'	=> 'Multilinks',
	'ACP_MULTILINKS_CONFIG'	=> 'Extension settings',
));
