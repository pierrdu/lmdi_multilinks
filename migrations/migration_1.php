<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\multilinks\migrations;

class migration_1 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['lmdi_multilinks']);
	}


	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}


	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_MULTILINKS_TITLE')),
			array('module.add', array('acp', 'ACP_MULTILINKS_TITLE', array(
					'module_basename'	=> '\lmdi\multilinks\acp\multilinks_module',
					'auth'			=> 'ext_lmdi/multilinks && acl_a_board',
					// 'modes'				=> array('settings', 'manage'),
					'modes'			=> array('settings'),
					),
			)),

			array('config.add', array('lmdi_multilinks', 1)),
			array('config_text.add', array('lmdi_multilinks_pp', '')),
			array('config_text.add', array('lmdi_multilinks_ap', '')),

			// Add permission
			array('permission.add', array('a_multilinks', true)),
			// Set permissions
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_multilinks')),
// 			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_boardrules')),
		);
	}

}
