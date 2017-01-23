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

	/* @var \phpbb\template\template */
	protected $template;
	/* @var \phpbb\user */
	protected $user;
	/* @var \phpbb\config\config */
	protected $config;



	public function __construct(
		\phpbb\user $user, 
		\phpbb\config\config $config,
		\phpbb\template\template $template)
	{
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
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
			'ext_name' => 'lmdi/links',
			'lang_set' => 'links',
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
		$this->template->assign_vars(array(
			'U_INPN'	=> "http://inpn.mnhn.fr/accueil/recherche-de-donnees/especes/",
			'U_FE'	=> "http://www.faunaeur.org/?no_redirect=1",
			'L_INPN'	=> $this->user->lang['LINPN'],
			'L_FE'	=> $this->user->lang['LFE'],
			'T_INPN'	=> $this->user->lang['TINPN'],
			'T_FE'	=> $this->user->lang['TFE'],
			'S_320'	=> $mlinks_class,
		));
	}
}
