<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }
	
    
    /**
     * Test Controller
     */
    public function index()
    {
		echo $this->twig->render('h5bp.html', array(
			'title' => "Test page"
		));
    }
     

}