<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017-2022 Pierre Duhem - LMDI
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


	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}


	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_MULTILINKS_TITLE')),
			array('module.add', array('acp', 'ACP_MULTILINKS_TITLE', array(
					'module_basename'	=> '\lmdi\multilinks\acp\multilinks_module',
					'auth'			=> 'ext_lmdi/multilinks && acl_a_board',
					'modes'			=> array('settings'),
					),
			)),
			array('config.add', array('lmdi_multilinks', 1)),
			// Add permission
			array('permission.add', array('a_multilinks', true)),
			// Set permissions
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_multilinks')),
		);
	}

	public function update_schema()
	{
		return array(
			'add_tables'   => array(
				$this->table_prefix . 'lmdi_multilinks'   => array(
					'COLUMNS'   => array(
						'item_id'		=> array('UINT', null, 'auto_increment'),
						'anchor'		=> array('VCHAR:32', ''),
						'title'		=> array('VCHAR:64', ''),	// Infotip
						'icon'		=> array('VCHAR:32', ''),
						'pict'		=> array('VCHAR:512', ''),
						'url'		=> array('VCHAR:512', ''),
						'ppap'		=> array('BOOL', 0),	// 0 = prepend, 1 = append
						'enabled'		=> array('BOOL', 0),
						'blank'		=> array('BOOL', 0),	// target = _blank
						'usicon'		=> array('BOOL', 1),	// Icon by default
						'usfile'		=> array('BOOL', 0),	// File by default
					),
					'PRIMARY_KEY'	=> 'item_id',
				),
			),
		);
	}

	public function revert_schema()
	{
		$table = $this->table_prefix . 'lmdi_multilinks';
			return array(
				'drop_tables'   => array(
					$table,
				)
			);
	}

}
