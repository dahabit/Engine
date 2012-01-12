<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
function static_url($path = '')
{
	$path = '/' . trim($path, '/');
    $CI =& get_instance();
	$CI->config->load('twig');
	return base_url('/') . $CI->config->item('twig_static') . '/' . $CI->config->item('twig_style') . $path;
}