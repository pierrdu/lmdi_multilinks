<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017-2019 Pierre Duhem — LMDI
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
	'ACP_ML_HIDEGUESTS'		=> 'Show links to guests',
	'ACP_ML_HIDEGUESTS_EXPLAIN' => 'Check this option to show the links to guests, uncheck it to hide them and only show them to board registered users.',
	'ACP_ML_PREPEND'		=> 'Links added at the beginning of the navigation bar',
	'ACP_ML_PREPEND_EXPLAIN'	=> 'The table below lists all links which may be included at the beginning of the navigation bar (before the link to the FAQ). Only those links with a checked box are included. Others are reserved.',
	'ACP_ML_NOTE'			=> '<b>Note:</b> Keep the number of links and the link text to a minimum if possible, If there is not enough width in the navbar to hold <u>all your added links</u>, phpBB puts <u>all links</u> in the Quick link dropdown menu and the navbar appears to be totally empty.',
	'ML_NAME'				=> 'Link text',
	'ML_TITLE'			=> 'Link tooltip',
	'ML_URL'				=> 'URL of the link',
	'ML_ENABLED'			=> 'Enabled',
	'ML_GUESTS'			=> 'Guests',
	'ML_ADD_LINK'			=> 'Create a new link',
	'ACP_ML_APPEND'		=> 'Links added at the end of the navigation bar',
	'ACP_ML_APPEND_EXPLAIN'	=> 'The table below lists all links which may be included at the end of the navigation bar (after the link to the FAQ and before the links to the ACP and MCP). See above about the checkbox',
	'ACP_ML_HIDE_LINKS'		=> 'Hide links for guests (unregistered visitors)',
	'ACP_ML_HIDE_EXPLAIN'	=> 'You may choose to hide the links for guests (visitors which are not yet registered on your board).',
	'MULTILINK_CONFIG_UPDATED'	=> 'The configuration was successfully updated.',
	'ACP_ADD_URL_PP'		=> 'Creation of a new link  at the beginning of the navigation bar',
	'ACP_ADD_URL_AP'		=> 'Creation of a new link at the end of the navigation bar',
	'ACP_ED_URL_PP'		=> 'Edition of a link at the beginning of the navigation bar',
	'ACP_ED_URL_AP'		=> 'Edition of a link at the end of the navigation bar',
	'ACP_MULTILINK_ANCHOR'	=> 'Term to be displayed in the navbar',
	'ACP_ML_ANCHOR_EXPLAIN'	=> 'Clickable term displayed on screen, for instance “phpBB”.',
	'ACP_MULTILINK_TITLE'	=> 'Infotip on hovering',
	'ACP_ML_TITLE_EXPLAIN'	=> 'Enter the explanation which should be displayed when the cursor hovers over the link (infotip).',
	'ACP_MULTILINK_URL'		=> 'URL of the link',
	'ACP_ML_URL_EXPLAIN'	=> 'Address of the page to display. For instance, URL of phpBB site.',
	'ACP_MULTILINK_ENABLED'	=> 'Enabled link',
	'ACP_ML_ENABLED_EXPLAIN'	=> 'Check this box if you want the link to be inserted in the navbar.',
	'ACP_MULTILINK_BLANK'	=> 'Link target="_blank"',
	'ACP_ML_BLANK_EXPLAIN'	=> 'Check this box if you want the link to open in a new window.',
	'ACP_MULTILINK_FA'		=> 'Use a Font Awesome link icon',
	'ACP_ML_FA_EXPLAIN'		=> 'Enter here the name of the Font Awesome icon to be used. Visit the <a href="https://fontawesome.io/icons/" target="_blank">Font Awesome site</a> to know all possibilities offered by the font. You just have to add the prefix &#8216;fa-’ in front of the name. Select &ldquo;No&rdquo; if you want to enter a graphic icon to be used. <b>Note:</b> If no Font Awesome icon or graphic file is specified then the  fa-external-link (&#xF08e;) icon will be used.',
	'ACP_MULTILINK_ICON'	=> 'Use a legacy icon',
	'ACP_ML_ICON_EXPLAIN'	=> 'Enter here the name of the legacy icon to be used. By default, the extension uses icon-faq. See also icon-acp, icon-mcp, icon-search, etc. See the list in styles/colours.css',
	'ACP_MULTILINK_FILE'	=> 'Use a graphic file link icon',
	'ACP_ML_FILE_EXPLAIN'	=> 'If you want to use a remote image as the logo then enter the full url of the image. Otherwise, enter the location of the image file on the server. Allowed file types: gif, png. If the width and height of the image are more than 20x20 pixels, the image will be reduced.',
	'ACP_ML_TRANSFER'		=> 'Transfer in other table',
));
