<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\mulilinks\migrations;

// use \phpbb\db\migration\container_aware_migration;


class migration_1 extends \phpbb\db\migration\migration
{

/*
	public function effectively_installed()
	{
		return isset($this->config['lmdi_multilinks']);
	}
*/

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}

	public function update_data()
	{
		return array(
			
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MULTILINKS_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_MULTILINKS_TITLE',
				array(
					'module_basename'	=> '\lmdi\multilinks\acp\multilinks_module',
					'modes'			=> array('settings'),
				),
			)),
			
			array('config.add', array('lmdi_multilinks', 1)),
			/*
			array('config_text.add', array('lmdi_multilinks_pre0', '')),
			array('config_text.add', array('lmdi_multilinks_pre1', '')),
			array('config_text.add', array('lmdi_multilinks_pre2', '')),
			array('config_text.add', array('lmdi_multilinks_pre3', '')),
			array('config_text.add', array('lmdi_multilinks_pre4', '')),
			array('config_text.add', array('lmdi_multilinks_post0', '')),
			array('config_text.add', array('lmdi_multilinks_post1', '')),
			array('config_text.add', array('lmdi_multilinks_post2', '')),
			array('config_text.add', array('lmdi_multilinks_post3', '')),
			array('config_text.add', array('lmdi_multilinks_post4', '')),
			*/
		);
	}

	public function revert_data()
	{
		return array(
			/*
			array('config_text.remove', array('lmdi_multilinks_pre0')),
			array('config_text.remove', array('lmdi_multilinks_pre1')),
			array('config_text.remove', array('lmdi_multilinks_pre2')),
			array('config_text.remove', array('lmdi_multilinks_pre3')),
			array('config_text.remove', array('lmdi_multilinks_pre4')),
			array('config_text.remove', array('lmdi_multilinks_post0')),
			array('config_text.remove', array('lmdi_multilinks_post1')),
			array('config_text.remove', array('lmdi_multilinks_post2')),
			array('config_text.remove', array('lmdi_multilinks_post3')),
			array('config_text.remove', array('lmdi_multilinks_post4')),
			*/
			array('config.remove', array('lmdi_multilinks')),
			/*
			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MULTILINKS_TITLE'
			)),
			*/
		);
	}


}
