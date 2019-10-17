<?php
/**
*
* @package phpBB Extension - LMDI Multilinks
* @copyright (c) 2017-2019 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\multilinks\acp;

class multilinks_info
{
	public function module()
	{
		return array(
			'filename'	=> '\lmdi\multilinks\acp\multilinks_module',
			'title'		=> 'ACP_MULTILINKS_TITLE',
			'version'		=> '1.0.0',
			'modes'		=> array (
				'settings' => array('title' => 'ACP_MULTILINKS_CONFIG',
					'auth' => 'ext_lmdi/multilinks && acl_a_multilinks',
					'cat' => array('ACP_MULTILINKS_TITLE')),
			),
		);
	}
}
