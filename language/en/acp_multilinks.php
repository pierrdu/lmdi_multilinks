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
	'ACP_ML_PREPEND'		=> 'Links added at the beginning of the navigation bar',
	'ACP_ML_PREPEND_EXPLAIN'	=> 'You may add <b>up to 5 links</b> at the beginning of the navigation bar (before the link to the FAQ).',
	'ACP_ML_NOTE'			=> '<b>Note:</b> Take in account the space needed for all links in the available navbar width. phpBB puts all elements in the Quick link dropdown menu if there is not enough room in the navbar to hold all your added links and the navbar appears to be totally empty.',
	'ML_NAME'				=> 'Anchor of the link',
	'ML_TITLE'			=> 'Title tooltip',
	'ML_URL'				=> 'URL of the link',
	'ML_ADD_LINK'			=> 'Create a new link',
	'ACP_ML_APPEND'		=> 'Links added at the end of the navigation bar',
	'ACP_ML_APPEND_EXPLAIN'	=> 'You may add <b>up to 5 links</b> at the end of the navigation bar (after the link to the FAQ and before the links to the ACP and MCP).',
	'MULTILINK_CONFIG_UPDATED'	=> 'The configuration was successfully updated.',
	'ACP_MULTILINK_ADD_URL'	=> 'Creation of a new link in the navigation bar',
	'ACP_ADD_URL_PP'		=> '(Prepended at the beginning of the navigation bar)',
	'ACP_ADD_URL_AP'		=> '(Appended at the end of the navigation bar)',
	'ACP_MULTILINK_ANCHOR'	=> 'Term displayed in the navbar',
	'ACP_MULTILINK_TITLE'	=> 'Infotip on hovering',
	'ACP_MULTILINK_URL'		=> 'URL of the link',
	'ACP_MULTILINK_BLANK'	=> 'Link target="_blank"',
	'ACP_MULTILINK_FA'		=> 'Use a Font Awesome',
	'ACP_MULTILINK_ICON'	=> 'Use a legacy icon',
	'ACP_MULTILINK_FILE'	=> 'Use a graphic file',
	'ACP_ML_ANCHOR_EXPLAIN'	=> 'Clickable term displayed on screen, for instance “phpBB”.',
	'ACP_ML_TITLE_EXPLAIN'	=> 'Enter here the explanation which should be displayed when the cursor hovers over the link.',
	'ACP_ML_URL_EXPLAIN'	=> 'Address of the page to display. For instance, URL of phpBB site.',
	'ACP_ML_BLANK_EXPLAIN'	=> 'Check this box if you want the link to open in a new window.',
	'ACP_ML_FA_EXPLAIN'		=> 'Enter here the name of the Font Awesome icon to be used. By default, the extension uses fa-external-link. To look for other icon names, see the file assets/css/font-awesome.min.css.',
	'ACP_ML_ICON_EXPLAIN'	=> 'Enter here the name of the legacy icon to be used. By default, the extension uses icon-faq. See also icon-acp, icon-mcp, icon-search, etc. See the list in styles/colours.css',
	'ACP_ML_FILE_EXPLAIN'	=> 'If you want to use a remote image as the logo then enter the full url of the image. Otherwise, enter the location of the image file on the server. Allowed file types: gif, png. If the width and height of the image are more than 20x20 pixels, the image will be reduced.',
	'ACP_ML_TRANSFER'		=> 'Transfer in other table',
	'ACP_ML_TABLE_FULL'		=> 'The destination table is already full. Aborting.',
));
