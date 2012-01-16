<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

if (!function_exists('googl'))
{
	function googl($url)
	{
		if(function_exists('curl_init'))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://goo.gl/api/shorten');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('url' => $url));
			$data = json_decode(curl_exec($ch), true);
			curl_close($ch);
			return $data['short_url'];
		}
		else
		{
			return false;
		}
	}
}