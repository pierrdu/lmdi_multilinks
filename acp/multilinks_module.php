<?php
/**
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017-2019 Pierre Duhem - LMDI
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
	protected $table;

	public function main ($id, $mode)
	{
		global $user, $config, $db, $template, $request, $phpbb_container, $table_prefix;

		$this->path_helper = $phpbb_container->get('lmdi.multilinks.multilinks_path_helper');
		$this->ext_path = $this->path_helper->get_ext_path_web ();

		$form_name = 'acp_multilinks';
		$this->table = $table_prefix . 'lmdi_multilinks';

		$user->add_lang_ext ('lmdi/multilinks', 'acp_multilinks');
		$this->tpl_name = 'acp_multilinks_body';
		$this->page_title = $user->lang['ACP_MULTILINKS_TITLE'];

		$ppap = $request->variable ('ppap', 0); // false = prepend, true = append

		if (version_compare ($config['version'], '3.2.x', '<'))
		{
			$mlinks_320 = 0;
		}
		else
		{
			$mlinks_320 = 1;
		}
		$action = $request->variable ('action', '');

		// Deletion cancelled => plain display of data
		if ($action == 'delete' && $request->is_set_post('cancel'))
		{
			$action = '';
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

		if ($action)
		{
			switch ($action)
			{
				// Item transfer into the other table
				case 'transfer' :
					$token = $request->variable ('hash', '');
					if (check_link_hash ($token, $form_name))
					{
						$uid = (int) $request->variable('uid', -1);
						$var_ppap = (int) !$ppap;
						$sql = "UPDATE " . $this->table . " SET ppap = $var_ppap WHERE item_id = $uid";
						$db->sql_query($sql);
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
						$uid = (int) $request->variable('uid', -1);
						$sql = "DELETE FROM " . $this->table . " WHERE item_id = $uid";
						$db->sql_query($sql);
						trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
					}
					else
					{
						$uid = $request->variable('uid', -1);
						confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
							'i' => $id,
							'mode' => $mode,
							'action' => $action,
							'uid' => $uid,
							))
						);
					}
				break;
				// Item edition
				case 'edit' :
					$uid = $request->variable('uid', -1);
					$sql = "SELECT * FROM " . $this->table . " WHERE item_id = $uid";
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$template->assign_vars(array(
						'S_320'		=> $mlinks_320,
						'URL_ID'		=> $uid,
						'ANCHOR'		=> $row['anchor'],
						'TITLE'		=> $row['title'],
						'URL'		=> $row['url'],
						'ENABLED'		=> $row['enabled']==true ? 'CHECKED' : '',
						'BLANK'		=> $row['blank']==true ? 'CHECKED' : '',
						'MLICON'		=> $row['icon'],
						'MLFILE'		=> $row['pict'],
						'ICON_YES'	=> $row['usicon']==true ? 'CHECKED' : '',
						'ICON_NO'		=> $row['usicon']==false ? 'CHECKED' : '',
						'FILE_YES'	=> $row['usfile']==true ? 'CHECKED' : '',
						'FILE_NO'		=> $row['usfile']==false ? 'CHECKED' : '',
						'PP_ACTION'	=> $this->u_action . '&amp;action=edit&amp;ppap='.$ppap,
						'S_ED_URL'	=> true,
						'S_ED_PP'	=> $ppap == 'pp' ? true : false,
						));
					$db->sql_freeresult($result);
				break;
				// New item creation
				case 'add' :
					$template->assign_vars(array(
						'S_320'		=> $mlinks_320,
						'URL_ID'		=> -1,
						'ANCHOR'		=> '',
						'TITLE'		=> '',
						'URL'		=> '',
						'ENABLED'		=> '',
						'BLANK'		=> '',
						'MLICON'		=> '',
						'MLFILE'		=> '',
						'ICON_YES'	=> 'CHECKED',
						'ICON_NO'		=> '',
						'FILE_YES'	=> '',
						'FILE_NO'		=> 'CHECKED',
						'PP_ACTION'	=> $this->u_action . '&amp;action=add&amp;ppap='.$ppap,
						'S_ADD_URL'	=> true,
						'S_ADD_PP'	=> $ppap == 'pp' ? true : false,
						));
				break;
				// Saving the new or edited item
				case 'save' :
					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
					}
					$this->validation_data ($mlinks_320, $ppap);
				break;
				// Moving records up and down
				case 'move_up':
					$uid = $request->variable ('uid', 0);
					$pid = $request->variable ('pid', 0);
					$sql1 = "UPDATE " . $this->table . " SET item_id = 0 WHERE item_id = $uid";
					$sql2 = "UPDATE " . $this->table . " SET item_id = $uid WHERE item_id = $pid";
					$sql3 = "UPDATE " . $this->table . " SET item_id = $pid WHERE item_id = 0";
					$db->sql_query($sql1);
					$db->sql_query($sql2);
					$db->sql_query($sql3);
					// Message with link back to the main ACP page
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
				case 'move_down':
					$uid = $request->variable ('uid', 0);
					$nid = $request->variable ('nid', 0);
					$sql1 = "UPDATE " . $this->table . " SET item_id = 0 WHERE item_id = $uid";
					$sql2 = "UPDATE " . $this->table . " SET item_id = $uid WHERE item_id = $nid";
					$sql3 = "UPDATE " . $this->table . " SET item_id = $uid WHERE item_id = 0";
					$db->sql_query($sql);
					$db->sql_query($sql1);
					$db->sql_query($sql2);
					trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				break;
			}
		}
		// Default action = display
		else
		{
			$this->assign_block_vars ('mlpp', 0 /* _PP_ */, $form_name);
			$this->assign_block_vars ('mlap', 1 /* _AP_ */, $form_name);
			$pict = $this->ext_path . 'adm/style/icon_trans.gif';
			$pictno = $this->ext_path . 'adm/style/icon_trans_disabled.gif';
			$altstr = $user->lang['ACP_ML_TRANSFER'];
			$template->assign_vars(array(
				'PP_ACTION'		=> $this->u_action . '&amp;action=add&amp;ppap=0', // _PP_
				'AP_ACTION'		=> $this->u_action . '&amp;action=add&amp;ppap=1', // _AP_
				'S_CONFIG_PAGE'	=> true,
				'U_ACTION'		=> $this->u_action,
				'ICON_ML_TRANSFER'	=> "<img src=\"$pict\" alt=\"$altstr\" title=\"$altstr\" />",
				'ICON_ML_TRANSNO'	=> "<img src=\"$pictno\" alt=\"$altstr\" title=\"$altstr\" />",
				));
		}
		add_form_key ($form_name);
	}


	private function assign_block_vars ($block, $ppap, $form_name)
	{
		global $template, $db;

		$sql = "SELECT * FROM " . $this->table . " WHERE ppap = $ppap ORDER BY enabled DESC";
		$result = $db->sql_query($sql);
		// Compute the set of ids
		$idset = array();
		$cpteur = 0;
		while ($row = $db->sql_fetchrow($result))
		{
			$uid = $row['item_id'];
			$idset[] = $uid;
			$cpteur++;
		}
		// Rewind the result
		$db->sql_rowseek (0, $result);
		// Compute the table lines
		$cpteur = 0;
		$nb = count ($idset);
		while ($row = $db->sql_fetchrow($result))
		{
			$uid = $row['item_id'];
			$str_pid = "&amp;pid=";
			$str_nid = "&amp;nid=";
			if ($cpteur)
			{
				$pid = $idset[$cpteur - 1];
				$str_pid .= $pid;
			}
			if ($cpteur < $nb)
			{
				$nid = $idset[$cpteur];
				$str_nid .= $nid;
			}
			$str_checked = "<input type='checkbox' name='enabled' checked disabled>";
			$str_unchecked = "<input type='checkbox' name='enabled' disabled>";
			$template->assign_block_vars($block, array(
				'NAME'			=> $row['anchor'],
				'TITLE'			=> $row['title'],
				'URL'			=> $row['url'],
				'ENABLED'			=> $row['enabled'] ? $str_checked : $str_unchecked,
				'U_ML_MOVE_UP'		=> $this->u_action . "&amp;action=move_up&amp;ppap=$ppap&amp;uid=$uid$str_pid&amp;hash=" . generate_link_hash($form_name),
				'U_ML_MOVE_DOWN'	=> $this->u_action . "&amp;action=move_down&amp;ppap=$ppap&amp;uid=$uid$str_nid&amp;hash=" . generate_link_hash($form_name),
				'U_ML_EDIT'		=> $this->u_action . "&amp;action=edit&amp;ppap=$ppap&amp;uid=$uid",
				'U_ML_DELETE'		=> $this->u_action . "&amp;action=delete&amp;ppap=$ppap&amp;uid=$uid",
				'U_ML_TRANSFER'	=> $this->u_action . "&amp;action=transfer&amp;ppap=$ppap&amp;uid=$uid&amp;hash=" . generate_link_hash($form_name),
				'U_ML_TRANSNO'		=> '',
				));
			$cpteur ++;
		}
		$db->sql_freeresult($result);
	}

	private function sanity_check ($var, $length)
	{
		global $db;
		$var = trim ($var);
		$var = substr ($var, 0, $length);
		$var = $db->sql_escape ($var);
		return ($var);
	}


	private function validation_data ($mlinks_320, $ppap)
	{
		global $request, $user, $db;

		$uid = $request->variable('uid', -1);
		$anchor = $request->variable ('ml_anchor', '', true);
		$anchor = $this->sanity_check ($anchor, 32);
		$title = $request->variable ('ml_title', '', true);
		$title = $this->sanity_check ($title, 64);
		$icon = $request->variable ('ml_icon', '', true);
		$icon = $this->sanity_check ($icon, 32);
		$pict = $request->variable ('ml_file', '', true);
		$pict = $this->sanity_check ($pict, 512);
		$url = $request->variable ('ml_url', '', true);
		$url = $this->sanity_check ($url, 512);
		$enabled = (int) $request->variable('ml_enabled', false);
		$blank = (int) $request->variable('ml_blank', false);
		$usicon = (int) $request->variable('use_icon', false);
		$usfile = (int) $request->variable('use_file', false);
		// Using icon by default
		if (!$usfile && !$usicon)
		{
			$usicon = 1;
		}
		// Default icons if empty
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
		// FA icon without the 'fa-' prefix
		if (!empty ($icon) && $mlinks_320)
		{
			if (substr ($icon, 0, 3) != 'fa-')
			{
				$icon = 'fa-' . $icon;
			}
		}
		if ($uid == -1)
		{
			$sql = "INSERT INTO ". $this->table ."
				(anchor, title, icon, pict, url, ppap, enabled, blank, usicon, usfile) 
				VALUES ('$anchor', '$title', '$icon', '$pict', '$url', $ppap, $enabled, $blank, $usicon, $usfile)";
			$db->sql_query($sql);
			$item_id = $db->sql_nextid();
		}
		else
		{
			$sql  = "UPDATE ". $this->table ." SET
				anchor = '$anchor',
				title = '$title',
				icon = '$icon',
				pict = '$pict',
				url = '$url',
				ppap = '$ppap',
				enabled = $enabled,
				blank = $blank,
				usicon = $usicon,
				usfile = $usfile
				WHERE item_id = $uid";
			$db->sql_query($sql);
		}
		trigger_error($user->lang['MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
	}
}
