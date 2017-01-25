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
		global $user, $template, $request, $phpbb_container;

		$form_name = 'acp_multilinks';

		$config_text = $phpbb_container->get('config_text');
		$user->add_lang_ext ('lmdi/multilinks', 'acp_multilinks');
		$this->tpl_name = 'acp_multilinks_body';
		$this->page_title = $user->lang['ACP_MULTILINKS_TITLE'];

		$action = $request->variable ('action', '');
		$submit = $request->variable ('submit', '');

		if ($submit)
		{
			switch ($action)
			{
				case 'add_pp' :
					$action = 'save_pp';
				break;
				case 'edit_pp' :
					$action = 'saved_pp';
				break;
				case 'add_ap' :
					$action = 'save_ap';
				break;
				case 'edit_ap' :
					$action = 'saved_ap';
				break;
			}
		}
		if ($action)
		{
			switch ($action)
			{
				// Prepended URLs
				// Item move up
				case 'move_up_pp' :
					$id = $request->variable('id', -1);
					$links = $config_text->get ('lmdi_multilinks_pp');
					$rows = json_decode ($links, true);
					$row0 = $rows[$id-1];
					$row1 = $rows[$id];
					$rows[$id-1] = $row1;
					$rows[$id] = $row0;
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_pp', $links);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
				// Item move down
				case 'move_down_pp' :
					$id = $request->variable('id', -1);
					$links = $config_text->get ('lmdi_multilinks_pp');
					$rows = json_decode ($links, true);
					$row0 = $rows[$id+1];
					$row1 = $rows[$id];
					$rows[$id+1] = $row1;
					$rows[$id] = $row0;
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_pp', $links);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
				// Item deletion
				case 'delete_pp' :
					$id = $request->variable('id', -1);
					$links = $config_text->get ('lmdi_multilinks_pp');
					$rows = json_decode ($links, true);
					unset ($rows[$id]);
					// array_slice ($rows, $id, 1);
					$rows = array_values ($rows);
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_pp', $links);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
				// Item edition
				case 'edit_pp' :
					$id = $request->variable('id', -1);
					$links = $config_text->get ('lmdi_multilinks_pp');
					$rows = json_decode ($links, true);
					$row = $rows[$id];
					$template->assign_vars(array(
						'URL_ID'			=> $id,
						'ANCHOR'			=> $row['anchor'],
						'TITLE'			=> $row['title'],
						'URL'			=> $row['url'],
						'BLANK'			=> $row['blank']==true ? 'CHECKED' : '',
						'PP_ACTION'		=> $this->u_action . '&amp;action=edit_pp',
						'S_ADD_URL'		=> true,
						'S_ADD_PP'		=> true,
						));
				break;
				// New item creation
				case 'add_pp' :
					$template->assign_vars(array(
						'URL_ID'			=> -1,
						'ANCHOR'			=> '',
						'TITLE'			=> '',
						'URL'			=> '',
						'BLANK'			=> '',
						'PP_ACTION'		=> $this->u_action . '&amp;action=add_pp',
						'S_ADD_URL'		=> true,
						'S_ADD_PP'		=> true,
						));
				break;
				// New item saving
				case 'save_pp' :
					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
					}
					$anchor = $request->variable ('ml_anchor', '', true);
					$title = $request->variable ('ml_title', '', true);
					$url = $request->variable ('ml_url', '', true);
					$blank = $request->variable('ml_blank', false);
					$links = $config_text->get ('lmdi_multilinks_pp');
					$rows = json_decode ($links, true);
					$rows[] = array ('anchor' => $anchor, 'title' => $title, 'url' => $url, 'blank' => $blank);
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_pp', $links);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
				// Edited item saving
				case 'saved_pp' :
					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
					}
					$id = $request->variable ('id', -1);
					$anchor = $request->variable ('ml_anchor', '', true);
					$title = $request->variable ('ml_title', '', true);
					$url = $request->variable ('ml_url', '', true);
					$blank = $request->variable('ml_blank', false);
					$links = $config_text->get ('lmdi_multilinks_pp');
					$rows = json_decode ($links, true);
					unset ($rows[$id]);
					$rows[$id] = array ('anchor' => $anchor, 'title' => $title, 'url' => $url, 'blank' => $blank);
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_pp', $links);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
				// Appended URLs
				// Item move up
				case 'move_up_ap' :
					$id = $request->variable('id', -1);
					$links = $config_text->get ('lmdi_multilinks_ap');
					$rows = json_decode ($links, true);
					$row0 = $rows[$id-1];
					$row1 = $rows[$id];
					$rows[$id-1] = $row1;
					$rows[$id] = $row0;
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_ap', $links);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
				// Item move down
				case 'move_down_ap' :
					$id = $request->variable('id', -1);
					$links = $config_text->get ('lmdi_multilinks_ap');
					$rows = json_decode ($links, true);
					$row0 = $rows[$id+1];
					$row1 = $rows[$id];
					$rows[$id+1] = $row1;
					$rows[$id] = $row0;
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_ap', $links);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
				// Item deletion
				case 'delete_ap' :
					$id = $request->variable('id', -1);
					$links = $config_text->get ('lmdi_multilinks_ap');
					$rows = json_decode ($links, true);
					unset ($rows[$id]);
					// array_slice ($rows, $id, 1);
					$rows = array_values ($rows);
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_ap', $links);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
				// Item edition
				case 'edit_ap' :
					$id = $request->variable('id', -1);
					$links = $config_text->get ('lmdi_multilinks_ap');
					$rows = json_decode ($links, true);
					$row = $rows[$id];
					$template->assign_vars(array(
						'URL_ID'			=> $id,
						'ANCHOR'			=> $row['anchor'],
						'TITLE'			=> $row['title'],
						'URL'			=> $row['url'],
						'BLANK'			=> $row['blank']==true ? 'CHECKED' : '',
						'PP_ACTION'		=> $this->u_action . '&amp;action=edit_ap',
						'S_ADD_URL'		=> true,
						'S_ADD_AP'		=> true,
						));
				break;
				// New item creation
				case 'add_ap' :
					$template->assign_vars(array(
						'URL_ID'			=> -1,
						'ANCHOR'			=> '',
						'TITLE'			=> '',
						'URL'			=> '',
						'BLANK'			=> '',
						'PP_ACTION'		=> $this->u_action . '&amp;action=add_ap',
						'S_ADD_URL'		=> true,
						'S_ADD_AP'		=> true,
						));
				break;
				// New item saving
				case 'save_ap' :
					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
					}
					$anchor = $request->variable ('ml_anchor', '', true);
					$title = $request->variable ('ml_title', '', true);
					$url = $request->variable ('ml_url', '', true);
					$blank = $request->variable('ml_blank', false);
					$links = $config_text->get ('lmdi_multilinks_ap');
					$rows = json_decode ($links, true);
					$rows[] = array ('anchor' => $anchor, 'title' => $title, 'url' => $url, 'blank' => $blank);
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_ap', $links);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
				// Edited item saving
				case 'saved_ap' :
					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
					}
					$id = $request->variable ('id', -1);
					$title = $request->variable ('ml_title', '', true);
					$anchor = $request->variable ('ml_anchor', '', true);
					$url = $request->variable ('ml_url', '', true);
					$blank = $request->variable('ml_blank', false);
					$links = $config_text->get ('lmdi_multilinks_ap');
					$rows = json_decode ($links, true);
					unset ($rows[$id]);
					$rows[$id] = array ('anchor' => $anchor, 'title' => $title, 'url' => $url, 'blank' => $blank);
					$links = json_encode ($rows);
					$config_text->set ('lmdi_multilinks_ap', $links);
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
					'NAME'			=> $row['anchor'],
					'TITLE'			=> $row['title'],
					'URL'			=> $row['url'],
					'BLANK'			=> $row['blank']==true ? $user->lang['YES'] : $user->lang['NO'],
					'U_PP_MOVE_UP'		=> $this->u_action . '&amp;action=move_up_pp&amp;id=' . $i,
					'U_PP_MOVE_DOWN'	=> $this->u_action . '&amp;action=move_down_pp&amp;id=' . $i,
					'U_PP_EDIT'		=> $this->u_action . '&amp;action=edit_pp&amp;id=' . $i,
					'U_PP_DELETE'		=> $this->u_action . '&amp;action=delete_pp&amp;id=' . $i,
					));
			}

			$links = $config_text->get ('lmdi_multilinks_ap');
			$rows = json_decode ($links, true);
			$nb = count ($rows);
			for ($i = 0; $i < $nb; $i++)
			{
				$row = $rows[$i];
				$template->assign_block_vars('mlap', array(
					'NAME'			=> $row['anchor'],
					'TITLE'			=> $row['title'],
					'URL'			=> $row['url'],
					'BLANK'			=> $row['blank']==true ? $user->lang['YES'] : $user->lang['NO'],
					'U_AP_MOVE_UP'		=> $this->u_action . '&amp;action=move_up_ap&amp;id=' . $i,
					'U_AP_MOVE_DOWN'	=> $this->u_action . '&amp;action=move_down_ap&amp;id=' . $i,
					'U_AP_EDIT'		=> $this->u_action . '&amp;action=edit_ap&amp;id=' . $i,
					'U_AP_DELETE'		=> $this->u_action . '&amp;action=delete_ap&amp;id=' . $i,
					));
			}

			$template->assign_vars(array(
				'PP_ACTION'		=> $this->u_action . '&amp;action=add_pp',
				'AP_ACTION'		=> $this->u_action . '&amp;action=add_ap',
				'S_CONFIG_PAGE'	=> true,
				'U_ACTION'		=> $this->u_action,
				));
		}
		add_form_key ($form_name);
	}

}
