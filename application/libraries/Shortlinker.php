<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Linker class for generating short links
 */
class Shortlinker
{
	private $CI;
	private $short_domain;
	private $hash_length;
	
	function __construct()
	{
		$this->CI =& get_instance();
		if(!isset($this->CI->db))
		{
			$this->CI->load->library('database');
		}
		$this->CI->config->load('short_linker');
		$this->short_domain = $this->CI->config->item('linker_domain');
		$this->hash_length	= $this->CI->config->item('linker_hash_length');
	}

	public function getLink($link, $customHash = null)
	{
		$link = trim($link);
		$generated = $this->chechExistance($link);
		if($generated)
		{
			return $generated;
		}
		if(is_null($customHash))
		{
			$hash = $this->getUniqueHash($this->hash_length);
		}
		elseif(!$this->checkUniqueness($customHash))
		{
			$hash = $this->getUniqueHash($this->hash_length, $customHash);
		}
		else
		{
			$hash = $customHash;
		}
		$generated = $this->short_domain . $hash;
		$this->saveLink($link, $generated, $hash);
		return $generated;
	}

	private function getUniqueHash($length = 6, $keystr = null)
	{
		if(is_null($keystr))
		{
			$hash = substr(md5(uniqid(rand(), true)), 0, $length);
		}
		else
		{
			$hash = substr(md5($keystr.$keystr), 0, $length);
		}
		if(!$this->checkUniqueness($hash))
		{
			$this->getUniqueHash($length, srand($keystr));
		}
		else
		{
			return $hash;
		}
	}

	private function checkUniqueness($hash)
	{
		$exists = $this->CI->db->select('count(*) as count')->from('linker')->where('link_hash', $hash)->get()->row_array();
		if(isset($exists['count']) && $exists['count'] > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	private function chechExistance($link)
	{
		$exists = $this->CI->db->from('linker')->where('link_original', $link)->get()->row_array();
		if(isset($exists['link_id']))
		{
			return $exists['link_generated'];
		} else
		{
			return false;
		}
	}
	
	private function saveLink($original, $generated, $hash)
	{
		$data = array(
			'link_original'		=> $original,
			'link_generated'	=> $generated,
			'link_hash'			=> $hash
		);
		$this->CI->db->insert('linker', $data);
	}
}