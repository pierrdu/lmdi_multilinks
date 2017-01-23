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
	protected $table;

	public function main ($id, $mode)
	{
		global $db, $user, $template, $cache, $request;
		global $config, $phpbb;
		global $table_prefix, $phpbb_log;

		$user->add_lang_ext ('lmdi/multilinks', 'acp_multilinks');
		$this->tpl_name = 'acp_multilinks_body';
		$this->page_title = $user->lang('ACP_MULTILINKS_TITLE');
		
		$action = $request->variable ('action', '');
		$update_action = false;


		switch ($action)
		{
		}

		if ($request->variable('submit', 0))
		{
			trigger_error($user->lang['LOG_MULTILINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
		}

		$form_key = 'acp_multilinks';
		add_form_key ($form_key);

		$template->assign_vars(array(
			'F_ACTION'		=> $this->u_action . '&amp;action=forums',
			'R_ACTION'		=> $this->u_action . '&amp;action=recursion',
			'S_CONFIG_PAGE'	=> true,
			'ALLOW_FEATURE_NO'	=> $config['lmdi_multilinks'] == 1 ? 'checked="checked"' : '',
			'ALLOW_FEATURE_YES'	=> $config['lmdi_multilinks'] == 2 ? 'checked="checked"' : '',
			'U_ADD'			=> $this->u_action . '&amp;action=add',
			'U_ACTION'		=> $this->u_action,
			'S_SET_FORUMS'		=> true,
			'TH_TERM'			=> $this->u_action . $th_term,
			'TH_URL'			=> $this->u_action . $th_url,
			'BLANK_TARGET_NO'	=> $config['lmdi_multilinks_blank'] == 0 ? 'checked="checked"' : '',
			'BLANK_TARGET_YES'	=> $config['lmdi_multilinks_blank'] == 1 ? 'checked="checked"' : '',
			));
	}	// Main

}
