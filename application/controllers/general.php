<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class general extends CI_Controller {

	public function __construct() 
    {
        parent::__construct();
    }
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function set_get_student()
	{
		$this->load->database();
		$data['query'] = $this->db->query("SELECT * FROM siakad_student WHERE gen_student = '' ");
		echo "<table>";
		foreach($data['query']->result() as $result)
		{
			$last_digit = substr($result->nim_student, 4,2);
			if($last_digit > 19)
			{
				$gen_student = '19'.$last_digit;
			}
			else
			{
				$gen_student = '20'.$last_digit;	
			}
			
			echo "<tr><td>$result->id_student</td><td>$gen_student</td><td>$result->nim_student</td></tr>";
		}
		echo "<table>";
	}
	public function gen_studentstatus()
	{
		$this->load->database();
		$data['query'] = $this->db->query("SELECT * FROM siakad_student WHERE gen_student > '2005' ");
		$data['period'] = $this->db->query('SELECT * FROM period where year_period > 2005');
		echo "<table>";
		foreach($data['query']->result() as $result)
		{
			foreach($data['period']->result() as $period)
			{
				if($result->gen_student <= $period->year_period)
				{
					echo "<tr>
					<td>".$result->id_student."</td>
					<td>".$period->id_period."</td>
					</tr>";
				}
			}
		}
		echo "</table>";
	}
	public function just()
	{
		$this->load->database();
		$data['listed_username'] = $this->db->query("SELECT * FROM ViewMigrasiPinMahasiswa");
		foreach($data['listed_username']->result() as $listed_username)
		{
			$hassed_pass = sha1($listed_username->PIN);
			$username = $listed_username->NIM;
			$update_query = "UPDATE siakad_user SET password_user = '$hassed_pass' WHERE username_user =  '$username'";
			if($this->db->query($update_query))
			{

			}
			else
			{
				echo 'a';
				break;
			}
		}
	}
	public function stmtjaya()
	{
		echo sha1('5tmtjaya');
	}

	public function fopen()
	{
		$file = fopen("pin.txt","r");
		$file_w = fopen("respin.txt","w");
		while(! feof($file))
		  {

		  $str =  fgets($file);
		  fwrite($file_w,sha1($str). PHP_EOL);
		  }

		fclose($file);
		fclose($file_w);
	}
}


?>