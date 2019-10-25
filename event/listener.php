<?php
/*
*
* @package LMDI Multilinks
* @copyright (c) 2017-2019 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace lmdi\multilinks\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

	protected $db;
	protected $user;
	protected $config;
	protected $template;
	protected $table;


	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user,
		$ml_table)
	{
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->table = $ml_table;
	}


	static public function getSubscribedEvents ()
	{
		return array(
			'core.user_setup'	=> 'load_language',
			'core.page_header'	=> 'build_navbar_links',
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
	* Construction of the links to inject in the navbar
	*/
	public function build_navbar_links ($event)
	{
		$this->local_assign_block_vars(0 /* Prepend */, 'mlpp');
		$this->local_assign_block_vars(1 /* Append */, 'mlap');
	}


	private function local_assign_block_vars($ppap, $block)
	{
		$sql = "SELECT * FROM " . $this->table . " WHERE ppap = $ppap AND enabled = 1 ORDER BY sort";
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$icon = $row['icon'];
			$usicon = $row['usicon'];
			$pict = $row['pict'];
			// Do we display to guests ?
			$user = (int) $this->user->data['user_id'];
			$guests = (int) $row['guests'];
			if ($user == ANONYMOUS && !$guests)
			{
				continue;
			}
			else
			{
				$this->template->assign_block_vars($block, array(
					'NAME'	=> $row['anchor'],
					'TITLE'	=> $row['title'],
					'URL'	=> $row['url'],
					'BLANK'	=> $row['blank']==true ? 'target="_blank"' : '',
					'ICON'	=> $icon,
					'FILE'	=> $pict,
					'S_ICON'	=> $usicon,
					));
			}
		}
		$this->db->sql_freeresult($result);
	}
}
