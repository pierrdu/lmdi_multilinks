<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017-2020 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\multilinks\migrations;

class migration_3 extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return array('\lmdi\multilinks\migrations\migration_2');
	}


	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'lmdi_multilinks' => array('sort' => array('ULINT', 0),
				),
			),
		);
	}


	public function update_data()
	{
		return array(
			// Duplication of item_id column in sort column
			array('custom', array(array(&$this, 'duplicate_ids'))),
		);
	}


	public function duplicate_ids()
	{
		$sql = "update ". $this->table_prefix . "lmdi_multilinks SET sort = item_id";
		$this->db->sql_query($sql);
	}

}
