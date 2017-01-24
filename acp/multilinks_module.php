<?php
/**
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\multilinks\acp;

class multilinks_module {

	public $u_action;
	protected $action;

	public function main ($id, $mode)
	{
		global $db, $user, $template, $cache, $request;
		global $config, $phpbb, $phpbb_container;

		$form_name = 'acp_multilinks';

		$config_text = $phpbb_container->get('config_text');
		$user->add_lang_ext ('lmdi/multilinks', 'acp_multilinks');
		$this->tpl_name = 'acp_multilinks_body';
		$this->page_title = $user->lang('ACP_MULTILINKS_TITLE');

		$action = $request->variable ('action', '');
		$submit = $request->variable ('submit', '');

		if ($action == 'add_pp' && $submit)
		{
			$action = 'save_pp';
		}
		if ($action == 'add_ap' && $submit)
		{
			$action = 'save_ap';
		}
		if ($action)
		{
			if (!check_form_key($form_name))
			{
				trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
			}
			switch ($action)
			{
				case 'move_up' :
					break;
				case 'move_down' :
					break;
				case 'delete' :
					break;
				case 'edit' :
					break;
				case 'add_pp' :
					$template->assign_vars(array(
						'PP_ACTION'		=> $this->u_action . '&amp;action=add_pp',
						'S_ADD_URL'		=> true,
						'S_ADD_PP'		=> true,
						));
					break;
				case 'save_pp' :
					$anchor = $request->variable ('ml_anchor', '', true);
					$url = $request->variable ('ml_url', '', true);
					// $blank = $request->variable ('ml_blank', false);
					$blank = $request->variable('ml_blank', false);
					/*
					var_dump ($anchor);
					var_dump ($url);
					var_dump ($blank);
					*/
					$links = $config_text->get ('lmdi_multilinks_pp');
					// var_dump ($links);
					$rows = json_decode ($links, true);
					$rows[] = array ('anchor' => $anchor, 'url' => $url, 'blank' => $blank);
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_pp', $links);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
					break;
				case 'add_ap' :
					$template->assign_vars(array(
						'AP_ACTION'		=> $this->u_action . '&amp;action=add_ap',
						'S_ADD_URL'		=> true,
						'S_ADD_AP'		=> true,
						));
					break;
				case 'save_ap' :
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
					break;
			}
		}
		else
		{
			$links = $config_text->get ('lmdi_multilinks_pp');
			$rows = json_decode ($links, true);
			$nb = count ($rows);
			for ($i = 0; $i < $nb; $i++)
			{
				$row = $rows[$i];
				$template->assign_block_vars('mlpp', array(
				'NAME'		=> $row['anchor'],
				'URL'		=> $row['url'],
				'BLANK'		=> $row['blank'],
				'U_MOVE_UP'	=> $this->u_action . '&amp;action=move_up&amp;id=' . $i,
				'U_MOVE_DOWN'	=> $this->u_action . '&amp;action=move_down&amp;id=' . $i,
				'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;id=' . $i,
				'U_DELETE'	=> $this->u_action . '&amp;action=delete&amp;id=' . $i,
				));
			}

			$template->assign_vars(array(
				'PP_ACTION'		=> $this->u_action . '&amp;action=add_pp',
				'AP_ACTION'		=> $this->u_action . '&amp;action=add_ap',
				'S_CONFIG_PAGE'	=> true,
				'U_ACTION'		=> $this->u_action,
				));
		}
		// var_dump ($form_name);
		add_form_key ($form_name);
	}

}
