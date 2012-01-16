<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * @author	Shmavon Gazanchyan
 * @since	10 January 2012
 */

class ScolarDB
{   
	private	$_CI;
	public	$mysql;
	
	/**
	 * Constructor of ScolarDB
	 */
	public function __construct($dbprovider = 'mysql')
	{
		$this->_CI =& get_instance();
		$this->_CI->config->load('config');
		
		require_once(APPPATH.'config/database.php');
		
		if($db['default']['dbdriver'] != '')
		$dbprovider = $db['default']['dbdriver'];
		
		require_once(APPPATH . 'third_party/ScolarDB/' . $dbprovider . '.class.php');
		
		$this->mysql = new db($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['dbprefix']);
	}
}