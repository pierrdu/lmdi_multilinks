<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017-2022 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\multilinks\migrations;

class migration_2 extends \phpbb\db\migration\migration
{

	public static function depends_on()
	{
		return array('\lmdi\multilinks\migrations\migration_1');
	}


	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'lmdi_multilinks' => array('guests' => array('BOOL', 1),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'lmdi_multilinks' => array('guests'),
				),
		);
	}

}
