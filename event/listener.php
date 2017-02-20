<?php
/*
*
* @package LMDI Multilinks
* @copyright (c) 2017 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace lmdi\multilinks\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

	protected $user;
	protected $config;
	protected $config_text;
	protected $template;


	public function __construct(
		\phpbb\user $user,
		\phpbb\config\config $config,
		\phpbb\config\db_text $config_text,
		\phpbb\template\template $template)
	{
		$this->user = $user;
		$this->config = $config;
		$this->config_text = $config_text;
		$this->template = $template;
	}


	static public function getSubscribedEvents ()
	{
		return array(
			'core.user_setup'	=> 'load_language',
			'core.page_header'	=> 'build_url',
			// ACP event
			'core.permissions'	=> 'add_permission',
		);
	}


	/**
	* Load the language strings
	*/
	public function load_language ($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'lmdi/multilinks',
			'lang_set' => 'multilinks',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}


	/**
	* Add administrative permissions to manage multilinks
	*/
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_multilinks'] = array('lang' => 'ACL_A_MULTILINKS', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}


	/**
	* Construction of the URL to inject in the navbar
	*/
	public function build_url ($event)
	{
		if (version_compare ($this->config['version'], '3.2.x', '<'))
		{
			$mlinks_320 = 0;
		}
		else
		{
			$mlinks_320 = 1;
		}

		$this->assign_block_vars ('lmdi_multilinks_pp', 'mlpp');
		$this->assign_block_vars ('lmdi_multilinks_ap', 'mlap');

		$this->template->assign_vars(array(
			'S_320'	=> $mlinks_320,
		));
	}

	private function assign_block_vars ($text, $block)
	{
		$links = $this->config_text->get ($text);
		$rows = json_decode ($links, true);
		$nb = count ($rows);
		for ($i = 0; $i < $nb; $i++)
		{
			$row = $rows[$i];
			$uticon = $utfile = false;
			$icon = $file = '';
			$file = $row['file'];
			$uticon = $row['uticon'];
			$utfile = $row['utfile'];
			if ($uticon && $utfile)
			{
				$utfile = false;
			}
			if (!$uticon && !$utfile)
			{
				$uticon = true;
			}
			if ($utfile)
			{
				$file = $row['file'];
				if (empty ($file))
				{
					$uticon = true;
				}
				else
				{
					$uticon = false;
				}
			}
			if ($uticon)
			{
				$icon = $row['icon'];
				$utfile = false;
				if (empty ($icon))
				{
					$icon = 'fa-external-link';
				}
			}
			$this->template->assign_block_vars($block, array(
				'NAME'	=> $row['anchor'],
				'TITLE'	=> $row['title'],
				'URL'	=> $row['url'],
				'BLANK'	=> $row['blank']==true ? 'target="_blank"' : '',
				'ICON'	=> $icon,
				'FILE'	=> $file,
				'S_ICON'	=> $uticon==true ? true : false,
				));
		}
	}
}
