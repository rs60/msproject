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
		
		$this->load->view('welcome_message');
		//echo "hola";
		//return;
		
		//$query = $this->db->get('employees');
		//foreach($query->result() as $row)
		//{
			//echo $row->first_name;
			//echo " ";
		//}
	}
	
	   function qa()
    {
	
	
		
				
		
		$q = urlencode($_GET['q']);
		$url= "http://quepy.machinalis.com/engine/get_query?question=".$q;
		
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url
		
		));
		
		$result = curl_exec($curl);
		$res = json_decode($result);
		$ans = "Your majesty! Jon Snow knows nothing! So do I!";
		$spaquery = $res->queries[0]->query;
		$target = $res->queries[0]->target;
		$target = trim($target,"?");
		
		
		if($spaquery!=null)
		{
			
			$spaquery = urlencode($spaquery);
			$url2= "http://dbpedia.org/sparql?query=".$spaquery."&format=json";
		
		
			$curl2 = curl_init();
			curl_setopt_array($curl2, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url2
			
			));
			
			$result2 = curl_exec($curl2);
			$res2 = json_decode($result2);
			
			
			//echo $spaquery;	
			
			$lng="xml:lang";
			$arr = $res2->results->bindings;
			
			$found=false;
			if(count($arr)>1){
					foreach($arr as $temp)
					{
						if($temp->$target->$lng == "en")
						{
							$ans = $temp->$target->value;
							$found=true;
							break;
						}
					}
					if(!$found)
					{
						$ans = $arr[0]->$target->value;
					}
			}
			else
			{
				if(count($arr)==1)
				{
					$ans = $arr[0]->$target->value;
				}
				
			}
			
			//echo $result2;
			
		
		}
		
		$data = array( 'answer' => $ans);
		echo json_encode( $data );
		
		//echo $ans;
				

	}
	
	    function greetings()
    {
	
		$keywords = preg_split("/[\s,?!]+/", $_GET['q']);
		
		$flag=false;
		$flag2=false;
		$ans="Kitty I can't understand you. Please ask me again...";
		
		foreach($keywords as $key)
		{
			if($key=="Hi"|| $key=="Hello" || $key=="Good"  || $key=="good"|| ($key=="evening" || $key=="Evening" || $key == "morning" || $key=="Morning" || $key=="night" || $key=="Night"  ))
			{
				if($key == "Good"|| $key=="good")
				{
					$flag2=true;
				}
				else if($flag2 && ($key=="evening" || $key=="Evening" || $key == "morning" || $key=="Morning" || $key=="night" || $key=="Night" ))
				{
					$ans = "Hello, Kitty! Good ".$key." I am pleased to meet with you.";
					$flag=true;
						break;
				}
				else if($key=="Hi"|| $key=="Hello")
				{
						$ans = "Hello, Kitty! I am pleased to meet with you. How Are You";
						$flag=true;
						break;
				}
				
			}
			
		}
		
		
		
		
		$data = array( 'answer' => $ans);
		echo json_encode( $data );
		
		//$this->load->view('print_msg',$data,TRUE);
		return;
		
		
		
        
    }
	
	
	function weather()
	{
	
		$keywords = preg_split("/[\s,?]+/", $_GET['q']);
		$id;
		$main_weather="";
		$flag=false;
		$city="";
		$count = count($keywords);
		$i=0;
		foreach($keywords as $key)
		{
			$i++;
		
			if($key=="temperature"|| $key=="humidity" || ($key=="Rain" || $key == "Clouds" || $key=="Clear" ))
			{
				if($key=="temperature")
				{
					$id=1;
				}
				else if($key=="humidity")
				{
					$id=2;
				}
				else
				{
					$id=3;
					$main_weather=$key;
				}
				
			}
			if($flag)
			{
				if($city!="")
				{
					if($i!=$count)
					$city = $city."%20";
				}
				$city = $city.$key;
			}
			if($key=="in")
			{
				$flag=true;
			}
			
			
			
		}
		
		//echo $city;
		
		
		$url= "http://api.openweathermap.org/data/2.5/weather?q=".$city;
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url
		
		));
		
		$result = curl_exec($curl);
		
		$res = json_decode($result);
		$ans ="noting";
		
		if($id==1)
		{
			$temp_kelvin = $res->main->temp;
			$ans = $temp_kelvin-273.16;
			$ans = $ans." C";
			
		}
		else if($id==2)
		{
			$ans=$res->main->humidity;
			
		}
		else if($id==3)
		{
			$rcc=$res->weather[0]->main;
			if($rcc=="rain"||$rcc=="Rain")
			{
					if($main_weather=="Rain")
					{
						$ans="Yes";
					}
					else
					{
						$ans="No";
					}
			}
			else if($rcc=="clouds"||$rcc=="Clouds")
			{
				
					if($main_weather=="Clouds")
					{
						$ans="Yes";
					}
					else
					{
						$ans="No";
					}
			}
			else if($rcc=="clear"||$rcc=="Clear")
			{
			
					if($main_weather=="Clear")
					{
						$ans="Yes";
					}
					else
					{
						$ans="No";
					}
			}
			else
			{
				$ans="No";
			}
		}
	
	
		//$keywords = preg_split("/[\s,]+/", $_GET['q']);
		//$response = http_get("api.openweathermap.org/data/2.5/weather?q=dhaka", array("timeout"=>1), $weather);
		//echo $weather;
		//echo $ans;
		$data = array( 'answer' => $ans);
		echo json_encode( $data );
		
		//echo $result;
	}
}