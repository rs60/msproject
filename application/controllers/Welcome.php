<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//$this->load->view('welcome_message');
		echo "hello";
		//return;
		
		//$query = $this->db->get('employees');
		//foreach($query->result() as $row)
		//{
			//echo $row->first_name;
			//echo " ";
		//}
	}
	
	    function greetings()
    {
	
		$keywords = preg_split("/[\s,]+/", $_GET['q']);
		
		$flag=false;
		$flag2=false;
		
		foreach($keywords as $key)
		{
			if($key=="Hi!"|| $key=="Hello!" || $key=="Good" || ($key=="evening!" || $key == "morning!" || $key=="night!" ))
			{
				if($key == "Good")
				{
					$flag2=true;
				}
				else if($flag2 && ($key=="evening!" || $key == "morning!" || $key=="night!" ))
				{
					$flag=true;
						break;
				}
				else if($key=="Hi!"|| $key=="Hello!")
				{
						$flag=true;
						break;
				}
				
			}
			
		}
		
		
		$ans="Kitty I can't understand you. Please ask me again...";
		if($flag)
		{
			$ans="Hello, Kitty! I am pleased to meet with you.";
		}
		
		$data = array( 'answer' => $ans);
		echo json_encode( $data );
		
		//$this->load->view('print_msg',$data,TRUE);
		return;
		
		
		
        
    }
}