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
	protected $path_helper;
	protected $ext_path;
	protected $config_text;

	public function main ($id, $mode)
	{
		global $user, $config, $template, $request, $phpbb_container;

		$this->path_helper = $phpbb_container->get('lmdi.multilinks.multilinks_path_helper');
		$this->ext_path = $this->path_helper->get_ext_path_web ();
		// var_dump ($this->ext_path);

		$form_name = 'acp_multilinks';
		$config_text_pp = 'lmdi_multilinks_pp';
		$config_text_ap = 'lmdi_multilinks_ap';

		$this->config_text = $phpbb_container->get('config_text');
		$user->add_lang_ext ('lmdi/multilinks', 'acp_multilinks');
		$this->tpl_name = 'acp_multilinks_body';
		$this->page_title = $user->lang['ACP_MULTILINKS_TITLE'];

		$action = $request->variable ('action', '');
		$ppap = $request->variable ('ppap', '');	// 'pp' = prepend, 'ap' = append

		if (version_compare ($config['version'], '3.2.x', '<'))
		{
			$mlinks_320 = 0;
		}
		else
		{
			$mlinks_320 = 1;
		}

		if ($request->is_set_post('submit'))
		{
			switch ($action)
			{
				case 'add' :
				case 'edit' :
					$action = 'save';
				break;
			}
		}

		// var_dump ($action);
		if ($action)
		{
			switch ($action)
			{
				// Item transfer into the other table
				case 'transfer' :
					$token = $request->variable ('hash', '');
					if (check_link_hash ($token, $form_name))
					{
						if ($ppap == 'ap')
						{
							$otext = $config_text_ap;
							$dtext = $config_text_pp;
							$orig = $this->config_text->get ($config_text_ap);
							$dest = $this->config_text->get ($config_text_pp);
						}
						else
						{
							$otext = $config_text_pp;
							$dtext = $config_text_ap;
							$orig = $this->config_text->get ($config_text_pp);
							$dest = $this->config_text->get ($config_text_ap);
						}
						$orows = json_decode ($orig, true);
						$drows = json_decode ($dest, true);
						$nbdest = count ($drows);
						if ($nbdest >= 5)
						{
							trigger_error($user->lang['ACP_ML_TABLE_FULL'] . adm_back_link($this->u_action), E_USER_WARNING);
						}
						$id = $request->variable('id', -1);
						$orow = $orows[$id];
						$drows[] = $orow;
						$drows = array_values ($drows);
						$dest = json_encode ($drows);
						$this->config_text->set ($dtext, $dest);
						unset ($orows[$id]);
						$orows = array_values ($orows);
						$orig = json_encode ($orows);
						$this->config_text->set ($otext, $orig);
						trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
					}
					else
					{
						trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
					}
				break;
				// Item move up
				case 'move_up' :
					$token = $request->variable ('hash', '');
					if (check_link_hash ($token, $form_name))
					{
						$id = $request->variable('id', -1);
						$links = $this->config_text->get ('lmdi_multilinks_'.$ppap);
						$rows = json_decode ($links, true);
						$row0 = $rows[$id-1];
						$row1 = $rows[$id];
						$rows[$id-1] = $row1;
						$rows[$id] = $row0;
						$rows = array_values ($rows);
						$links = json_encode ($rows);
						$this->config_text->set ('lmdi_multilinks_'.$ppap, $links);
						trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
					}
					else
					{
						trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
					}
				break;
				// Item move down
				case 'move_down' :
					$token = $request->variable ('hash', '');
					if (check_link_hash ($token, $form_name))
					{
						$id = $request->variable('id', -1);
						$links = $this->config_text->get ('lmdi_multilinks_'.$ppap);
						$rows = json_decode ($links, true);
						$row0 = $rows[$id+1];
						$row1 = $rows[$id];
						$rows[$id+1] = $row1;
						$rows[$id] = $row0;
						$rows = array_values ($rows);
						$links = json_encode ($rows);
						$this->config_text->set ('lmdi_multilinks_'.$ppap, $links);
						trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
					}
					else
					{
						trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
					}
				break;
				// Item deletion
				case 'delete' :
					if (confirm_box(true))
					{
						$id = $request->variable('id', -1);
						$links = $this->config_text->get ('lmdi_multilinks_'.$ppap);
						$rows = json_decode ($links, true);
						unset ($rows[$id]);
						$rows = array_values ($rows);
						$links = json_encode ($rows);
						$this->config_text->set ('lmdi_multilinks_'.$ppap, $links);
						trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
					}
					else
					{
						confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
							'i' => $id,
							'mode' => $mode,
							'action' => ''))
						);
					}
				break;
				// Item edition
				case 'edit' :
					$id = $request->variable('id', -1);
					$links = $this->config_text->get ('lmdi_multilinks_'.$ppap);
					$rows = json_decode ($links, true);
					$row = $rows[$id];
					$template->assign_vars(array(
						'S_320'		=> $mlinks_320,
						'URL_ID'		=> $id,
						'ANCHOR'		=> $row['anchor'],
						'TITLE'		=> $row['title'],
						'URL'		=> $row['url'],
						'BLANK'		=> $row['blank']==true ? 'CHECKED' : '',
						'MLICON'		=> $row['icon'],
						'MLFILE'		=> $row['file'],
						'ICON_YES'	=> $row['uticon']==true ? 'CHECKED' : '',
						'ICON_NO'		=> $row['uticon']==false ? 'CHECKED' : '',
						'FILE_YES'	=> $row['utfile']==true ? 'CHECKED' : '',
						'FILE_NO'		=> $row['utfile']==false ? 'CHECKED' : '',
						'PP_ACTION'	=> $this->u_action . '&amp;action=edit&amp;ppap='.$ppap,
						'S_ADD_URL'	=> true,
						'S_ADD_PP'	=> $ppap == 'pp' ? true : false,
						));
				break;
				// New item creation
				case 'add' :
					$template->assign_vars(array(
						'S_320'		=> $mlinks_320,
						'URL_ID'		=> -1,
						'ANCHOR'		=> '',
						'TITLE'		=> '',
						'URL'		=> '',
						'BLANK'		=> '',
						'MLICON'		=> '',
						'MLFILE'		=> '',
						'ICON_YES'	=> '',
						'ICON_NO'		=> 'CHECKED',
						'FILE_YES'	=> '',
						'FILE_NO'		=> 'CHECKED',
						'PP_ACTION'	=> $this->u_action . '&amp;action=add&amp;ppap='.$ppap,
						'S_ADD_URL'	=> true,
						'S_ADD_PP'	=> $ppap == 'pp' ? true : false,
						));
				break;
				// New or edited idem saving
				case 'save' :
					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
					}
					$this->validation_data ($mlinks_320, $config_text, $ppap);
				break;
			}
		}
		else
		{
			$nbpp = $this->count_items ($config_text_pp);
			$nbap = $this->count_items ($config_text_ap);
			$this->assign_block_vars ($config_text_pp, 'mlpp', 'pp', $form_name, $nbap);
			$this->assign_block_vars ($config_text_ap, 'mlap', 'ap', $form_name, $nbpp);
			$s_disable_pp = false;
			if ($nbpp >= 5)
			{
				$s_disable_pp = true;
			}
			$s_disable_ap = false;
			if ($nbap >= 5)
			{
				$s_disable_ap = true;
			}
			$pict = $this->ext_path . 'adm/style/icon_trans.gif';
			$pictno = $this->ext_path . 'adm/style/icon_trans_disabled.gif';
			$altstr = $user->lang['ACP_ML_TRANSFER'];
			$template->assign_vars(array(
				'PP_ACTION'		=> $this->u_action . '&amp;action=add&amp;ppap=pp',
				'AP_ACTION'		=> $this->u_action . '&amp;action=add&amp;ppap=ap',
				'S_CONFIG_PAGE'	=> true,
				'U_ACTION'		=> $this->u_action,
				'ICON_ML_TRANSFER'	=> "<img src=\"$pict\" alt=\"$altstr\" title=\"$altstr\" />",
				'ICON_ML_TRANSNO'	=> "<img src=\"$pictno\" alt=\"$altstr\" title=\"$altstr\" />",
				'S_DISABLE_PP'		=> $s_disable_pp == true ? true : false,
				'S_DISABLE_AP'		=> $s_disable_ap == true ? true : false,
				));
		}
		add_form_key ($form_name);
	}


	private function count_items ($text)
	{
		$links = $this->config_text->get ($text);
		$rows = json_decode ($links, true);
		$nb = count ($rows);
		return $nb;
	}


	private function assign_block_vars ($text, $block, $ppap, $form_name)
	{
		global $template;

		$links = $this->config_text->get ($text);
		$rows = json_decode ($links, true);
		$nb = count ($rows);
		for ($i = 0; $i < $nb; $i++)
		{
			$row = $rows[$i];
			$template->assign_block_vars($block, array(
				'NAME'			=> $row['anchor'],
				'TITLE'			=> $row['title'],
				'URL'			=> $row['url'],
				'U_ML_MOVE_UP'		=> $this->u_action . "&amp;action=move_up&amp;ppap=$ppap&amp;id=$i&amp;hash=" . generate_link_hash($form_name),
				'U_ML_MOVE_DOWN'	=> $this->u_action . "&amp;action=move_down&amp;ppap=$ppap&amp;id=$i&amp;hash=" . generate_link_hash($form_name),
				'U_ML_EDIT'		=> $this->u_action . "&amp;action=edit&amp;ppap=$ppap&amp;id=$i",
				'U_ML_DELETE'		=> $this->u_action . "&amp;action=delete&amp;ppap=$ppap&amp;id=$i",
				'U_ML_TRANSFER'	=> $this->u_action . "&amp;action=transfer&amp;ppap=$ppap&amp;id=$i&amp;hash=" . generate_link_hash($form_name),
				'U_ML_TRANSNO'		=> '',
				));
		}
	}


	private function validation_data ($mlinks_320, $ppap)
	{
		global $request, $user;

		$links = $this->config_text->get ('lmdi_multilinks_'.$ppap);
		$rows = json_decode ($links, true);
		$nbdest = count ($rows);
		if ($nbdest >= 5)
		{
			trigger_error($user->lang['ACP_ML_TABLE_FULL'] . adm_back_link($this->u_action), E_USER_WARNING);
		}
		$id = $request->variable ('id', -1);
		$anchor = $request->variable ('ml_anchor', '', true);
		$title = $request->variable ('ml_title', '', true);
		$url = $request->variable ('ml_url', '', true);
		$blank = $request->variable('ml_blank', false);
		$icon = $request->variable ('ml_icon', '', true);
		$uticon = $request->variable('use_icon', false);
		$file = $request->variable ('ml_file', '', true);
		$utfile = $request->variable('use_file', false);
		if (!$utfile && !$uticon)
		{
			$uticon = true;
		}
		if (empty ($icon))
		{
			if ($mlinks_320)
			{
				$icon = 'fa-external-link';
			}
			else
			{
				$icon = 'icon-faq';
			}
		}
		if (empty ($file))
		{
			$utfile = false;
		}
		if ($id == -1)
		{
			$rows[] = array ('anchor' => $anchor, 'title' => $title, 'url' => $url, 'blank' => $blank, 'icon' => $icon, 'uticon' => $uticon, 'file' => $file, 'utfile' => $utfile);
		}
		else
		{
			$rows[$id] = array ('anchor' => $anchor, 'title' => $title, 'url' => $url, 'blank' => $blank, 'icon' => $icon, 'uticon' => $uticon, 'file' => $file, 'utfile' => $utfile);
		}
		$rows = array_values ($rows);
		$links = json_encode ($rows);
		$this->config_text->set ('lmdi_multilinks_'.$ppap, $links);
		trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
	}
}
