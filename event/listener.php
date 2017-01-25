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

	/* @var \phpbb\user */
	protected $user;
	/* @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\config\config_text */
	protected $config_text;
	/* @var \phpbb\template\template */
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
		);
	}


	public function load_language ($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'lmdi/multilinks',
			'lang_set' => 'multilinks',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	} 


	public function build_url ($event)
	{
		if (version_compare ($this->config['version'], '3.2.x', '<'))
		{
			$mlinks_class = 0;
		}
		else
		{
			$mlinks_class = 1;
		}
		$links = $this->config_text->get ('lmdi_multilinks_pp');
		$rows = json_decode ($links, true);
		$nb = count ($rows);
		for ($i = 0; $i < $nb; $i++)
		{
			$row = $rows[$i];
			$this->template->assign_block_vars('mlpp', array(
				'NAME'			=> $row['anchor'],
				'TITLE'			=> $row['title'],
				'URL'			=> $row['url'],
				'BLANK'			=> $row['blank']==true ? 'target="_blank"' : '',
				));
		}

		$links = $this->config_text->get ('lmdi_multilinks_ap');
		$rows = json_decode ($links, true);
		$nb = count ($rows);
		for ($i = 0; $i < $nb; $i++)
		{
			$row = $rows[$i];
			$this->template->assign_block_vars('mlap', array(
				'NAME'			=> $row['anchor'],
				'TITLE'			=> $row['title'],
				'URL'			=> $row['url'],
				'BLANK'			=> $row['blank']==true ? 'target="_blank"' : '',
				));
		}

		$this->template->assign_vars(array(
			'S_320'	=> $mlinks_class,
		));
	}
}
