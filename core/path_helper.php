<?php
/*
*
* @package LMDI Multilinks
* @copyright (c) 2017-2019 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
namespace lmdi\multilinks\core;

class path_helper
{
	/** @var \phpbb\extension\manager "Extension Manager" */
	protected $ext_manager;
	/** @var \phpbb\path_helper */
	protected $path_helper;
	protected $ext_path;
	protected $ext_path_web;

	/**
	 * Constructor
	 *
	 * @param \phpbb\extension\manager		$ext_manager		Extension manager object
	 * @param \phpbb\path_helper			$path_helper		Path helper object
	 */
	public function __construct(
			\phpbb\extension\manager $ext_manager,
			\phpbb\path_helper $path_helper)
	{
		$this->ext_manager	=	$ext_manager;
		$this->path_helper	=	$path_helper;

		$this->ext_path	=	$this->ext_manager->get_extension_path('lmdi/multilinks', true);
		$this->ext_path_web	=	$this->path_helper->update_web_root_path($this->ext_path);
	}

	/**
	 * Returns $ext_path_web
	 *
	 */
	public function get_ext_path_web ()
	{
		return $this->ext_path_web;
	}

}
