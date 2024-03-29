<?php
/**
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017-2022 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\multilinks\acp;

class multilinks_module
{

	public $u_action;
	protected $ext_path;
	protected $table;
	protected $page_title;


	public function main ($id, $mode)
	{
		global $language, $db, $template, $request, $phpbb_container, $table_prefix;

		$this->ext_path = $phpbb_container->get('lmdi.multilinks.multilinks_path_helper')->get_ext_path_web ();

		$form_name = 'acp_multilinks';
		$this->table = $table_prefix . 'lmdi_multilinks';

		$language->add_lang ('acp_multilinks', 'lmdi/multilinks');
		$this->tpl_name = 'acp_multilinks_body';
		$this->page_title = $language->lang('ACP_MULTILINKS_TITLE');

		$ppap = $request->variable ('ppap', 0); // false = prepend, true = append

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
						$sql = "UPDATE " . $this->table . " SET ppap = $var_ppap WHERE sort = $uid";
						$db->sql_query($sql);
						trigger_error($language->lang('MULTILINK_CONFIG_UPDATED') . adm_back_link($this->u_action));
					}
					else
					{
						trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action));
					}
					break;
				// Item deletion
				case 'delete' :
					if (confirm_box(true))
					{
						$uid = (int) $request->variable('uid', -1);
						$sql = "DELETE FROM " . $this->table . " WHERE sort = $uid";
						$db->sql_query($sql);
						trigger_error($language->lang('MULTILINK_CONFIG_UPDATED') . adm_back_link($this->u_action));
					}
					else
					{
						$uid = $request->variable('uid', -1);
						confirm_box(false, $language->lang('CONFIRM_OPERATION'), build_hidden_fields(array(
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
					$sql = "SELECT * FROM " . $this->table . " WHERE sort = $uid";
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$template->assign_vars(array(
						'URL_ID'		=> $uid,
						'ANCHOR'		=> $row['anchor'],
						'TITLE'		=> $row['title'],
						'URL'		=> $row['url'],
						'ENABLED'		=> $row['enabled']==true ? 'CHECKED' : '',
						'GUESTS'		=> $row['guests']==true ? 'CHECKED' : '',
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
						'URL_ID'		=> -1,
						'ANCHOR'		=> '',
						'TITLE'		=> '',
						'URL'		=> '',
						'ENABLED'		=> '',
						'GUESTS'		=> '',
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
						trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action));
					}
					$this->validation_data ($ppap);
					break;
				// Moving records up and down
				case 'move_up':
					$uid = $request->variable ('uid', 0);
					$pid = $request->variable ('pid', 0);
					$sql1 = "UPDATE " . $this->table . " SET sort = 0 WHERE sort = $uid";
					$sql2 = "UPDATE " . $this->table . " SET sort = $uid WHERE sort = $pid";
					$sql3 = "UPDATE " . $this->table . " SET sort = $pid WHERE sort = 0";
					$db->sql_query($sql1);
					$db->sql_query($sql2);
					$db->sql_query($sql3);
					// Message with link back to the main ACP page
					trigger_error($language->lang('MULTILINK_CONFIG_UPDATED') . adm_back_link($this->u_action));
					break;
				case 'move_down':
					$uid = $request->variable ('uid', 0);
					$nid = $request->variable ('nid', 0);
					$sql1 = "UPDATE " . $this->table . " SET sort = 0 WHERE sort = $uid";
					$sql2 = "UPDATE " . $this->table . " SET sort = $uid WHERE sort = $nid";
					$sql3 = "UPDATE " . $this->table . " SET sort = $nid WHERE sort = 0";
					$db->sql_query($sql1);
					$db->sql_query($sql2);
					$db->sql_query($sql3);
					trigger_error($language->lang('MULTILINK_CONFIG_UPDATED') . adm_back_link($this->u_action));
					break;
			}
		}
		// Default action = display
		else
		{
			$this->assign_block_vars ('mlpp', 0 /* _PP_ */, $form_name);
			$this->assign_block_vars ('mlap', 1 /* _AP_ */, $form_name);
			$pict = $this->ext_path . 'adm/style/icon_trans.gif';
			$pict_no = $this->ext_path . 'adm/style/icon_trans_disabled.gif';
			$alt_str = $language->lang('ACP_ML_TRANSFER');
			$template->assign_vars(array(
				'PP_ACTION'		=> $this->u_action . '&amp;action=add&amp;ppap=0', // _PP_
				'AP_ACTION'		=> $this->u_action . '&amp;action=add&amp;ppap=1', // _AP_
				'S_CONFIG_PAGE'	=> true,
				'U_ACTION'		=> $this->u_action,
				'ICON_ML_TRANSFER'	=> "<img src=\"$pict\" alt=\"$alt_str\" title=\"$alt_str\" />",
				'ICON_ML_TRANSNO'	=> "<img src=\"$pict_no\" alt=\"$alt_str\" title=\"$alt_str\" />",
				));
		}
		add_form_key ($form_name);
	}


	private function assign_block_vars ($block, $ppap, $form_name)
	{
		global $template, $db;

		$sql = "SELECT * FROM " . $this->table . " WHERE ppap = $ppap ORDER BY enabled DESC, sort";
		$result = $db->sql_query($sql);
		// Compute the set of ids
		$idset = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$uid = $row['sort'];
			$idset[] = $uid;
		}
		// Rewind the result
		$db->sql_rowseek (0, $result);
		// Compute the table lines
		$cpteur = 0;
		$nb = count ($idset);
		$idset[] = -1;
		while ($row = $db->sql_fetchrow($result))
		{
			$uid = $row['sort'];
			$str_pid = "&amp;pid=";
			$str_nid = "&amp;nid=";
			if ($cpteur)
			{
				$pid = $idset[$cpteur - 1];
				$str_pid .= $pid;
			}
			if ($cpteur < $nb)
			{
				$nid = $idset[$cpteur + 1];
				$str_nid .= $nid;
			}
			$str_checked = "<input type='checkbox' name='enabled' checked disabled>";
			$str_unchecked = "<input type='checkbox' name='enabled' disabled>";
			$template->assign_block_vars($block, array(
				'NAME'			=> $row['anchor'],
				'TITLE'			=> $row['title'],
				'URL'			=> $row['url'],
				'ENABLED'			=> $row['enabled'] ? $str_checked : $str_unchecked,
				'GUESTS'			=> $row['guests'] ? $str_checked : $str_unchecked,
				'BLANK'			=> $row['blank'] ? $str_checked : $str_unchecked,
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


	private function validation_data ($ppap)
	{
		global $request, $db, $language;

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
		$guests = (int) $request->variable('ml_guests', false);
		$blank = (int) $request->variable('ml_blank', false);
		$use_icon = (int) $request->variable('use_icon', false);
		$use_file = (int) $request->variable('use_file', false);
		$sort = $uid;
		// Using icon by default
		if (!$use_file && !$use_icon)
		{
			$use_icon = 1;
		}
		// Default icons if empty
		if (empty ($icon))
		{
			$icon = 'fa-external-link';
		}
		// FA icon without the 'fa-' prefix
		if (!empty ($icon))
		{
			if (substr ($icon, 0, 3) != 'fa-')
			{
				$icon = 'fa-' . $icon;
			}
		}
		if ($uid == -1)
		{
			$sql = "INSERT INTO ". $this->table ."
				(anchor, title, icon, pict, url, ppap, enabled, blank, usicon, usfile, guests) 
				VALUES ('$anchor', '$title', '$icon', '$pict', '$url', $ppap, $enabled, $blank, $use_icon, $use_file, $guests)";
			$db->sql_query($sql);
			$uid = $db->sql_nextid();
			$sql = "UPDATE " . $this->table . " SET sort = $uid WHERE item_id = $uid";
			$db->sql_query($sql);
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
				usicon = $use_icon,
				usfile = $use_file,
				guests = $guests
				WHERE sort = $uid";
			$db->sql_query($sql);
		}
		trigger_error($language->lang('MULTILINK_CONFIG_UPDATED') . adm_back_link($this->u_action));
	}
}
