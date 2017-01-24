<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017 Pierre Duhem — LMDI
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
	'ACP_ML_PREPEND'		=> 'Links added at the beginning of the navigation bar',
	'ACP_ML_PREPEND_EXPLAIN'	=> 'You may add up to 5 links at the beginning of the navigation bar (before the link to the FAQ). Take in account the space needed for all links in the available width.',
	'ML_NAME'				=> 'Anchor ofthe link',
	'ML_URL'				=> 'URL of the link',
	'ML_BLANK'			=> 'Target = blank',
	'ML_ADD_LINK'			=> 'Creation of a new link',
	'ACP_ML_APPEND'		=> 'Links added at the end of the navigation bar',
	'ACP_ML_APPEND_EXPLAIN'	=> 'You may add up to 5 links at the end of the navigation bar (after the link to the FAQ and befor the links to the ACP and MCP). Take in account the space needed for all links in the available width.',
	'MULTILINK_CONFIG_UPDATED'	=> 'The configuration was successfully updated.',
	'ACP_MULTILINK_ADD_URL'	=> 'Creation of a new link in the navigation bar',
	'ACP_ADD_URL_PP'		=> '(Added at the beginning of the navigation bar)',
	'ACP_ADD_URL_AP'		=> '(Added at the end of the navigation bar)',
	'ACP_MULTILINK_ANCHOR'	=> 'Term displayed on screen',
	'ACP_MULTILINK_URL'		=> 'URL of the link',
	'ACP_MULTILINK_BLANK'	=> 'Link target=\'_blank\'',
	'ACP_ML_ANCHOR_EXPLAIN'	=> 'Clickable term, for instance \'phpBB\'.',
	'ACP_ML_URL_EXPLAIN'	=> 'Address of the page to display. For instance, URL of phpBB site.',
	'ACP_ML_BLANK_EXPLAIN'	=> 'Check this box if you want the link to be opened in a new window.',

));
