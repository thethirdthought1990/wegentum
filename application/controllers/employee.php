<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class  Employee extends CI_Controller{
public $user=array();
		function employee() 
	{
        parent::__construct();
		$this->load->model('employeemodel');
		$this->user=$this->session->userdata('user');
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    }
	function index()
	{
		echo 'hi';
	}
	
	
	function dashboard()
	{
		
			$data["page"]="empdashboard";
			//$data['user']=$user;
			$this->load->view('employee/page',$data);
		
	}
	
	function search()
			{
				$data=$this->input->post();
				//print_r($data[search]);exit;
				if($data[search]!='')
				{
					$abc=$this->user[int_user_id];
				//print_r($data['search']);exit;
			 $data['users'] = $this->employeemodel->getSearchBook($data['search'],$abc);
				//print_r($users);exit;
				$data["page"]="document_grid";
				 $this->load->view('employee/page',$data);
				 }
				 else
				 {
					 echo 'Please enter some value in the Serach Box';
				 }
			}
	
	
	
	function addcli()
	{
		
				$data["page"]="addclient";
				$data=$this->load->view('employee/page',$data);
			
	}
	
	function submit_cli()
	{
		$data=$this->input->post();
		//print_r($_FILES);exit;
		/*if($_FILES['image']['name']!='')
		{
			$image_name_string=$_FILES['image']['name'];
			$image_name_array=explode(".",$image_name_string);
			$ext=$image_name_array[count($image_name_array)-1];
			$filename='upload/'.date("YmdHis").".".$ext;
			move_uploaded_file($_FILES['image']['tmp_name'],$filename);
			$data['filename']=$filename;
		}
		else
		{
			$data['filename']='';
		}*/
		
			If ($_FILES)
			{
			foreach ($_FILES ['image']['name'] as $Key => $Name) 
			    {
						move_uploaded_file(
						$_FILES['image']['tmp_name'][$Key], 
						$_FILES['image']['name'][$Key] 
						) or die("Move from Temp area Failed");
						$filename= $_FILES['image']['name'][$Key];
						$data['filename']=$filename;
						//print_r($filename);exit;
						echo "<P>$filename: Uploaded";
			    }
			}
			
		$pqr=$this->employeemodel->submit_cli($data);
		echo "Data Inserted successfully";
			
	}
	
	function cli_list()
	{

		$data["page"]="client_grid";
		$user=$this->user;
		$data['users']=$this->employeemodel->get_all_clients($user['int_user_id']);
		//print_r($data['users']);exit;
		$data=$this->load->view('employee/page',$data);
			
	}
	
	function edit_client()
	{
		$id=$this->input->get(id);
		//print_r($id);exit;
		$data["page"]="client_edit";
		$data['details']=$this->employeemodel->client_details($id);
		$data=$this->load->view('employee/page',$data);
			
	}
	function update_client()
	{
		$data=$this->input->post();
		$result=$this->employeemodel->update_client_ind($data);
		redirect('employee/cli_list','refresh');
		
	}
	function delete_client()
	{
		$id=$this->input->get(id);
		$data=$this->employeemodel->delete_records($id);
		redirect('employee/cli_list','refresh');
		//redirect('employee/cli_list','refresh');
	}
	
	function add_doc()
	{
		
				$data["page"]="add_document";
				$data=$this->load->view('employee/page',$data);
			
	}
	
	function submit_doc()
	{
		$data=$this->input->post();
		if($_FILES['file']['name']!='')
		{
			$image_name_string=$_FILES['file']['name'];
			$image_name_array=explode(".",$image_name_string);
			$ext=$image_name_array[count($image_name_array)-1];
			$filename='upload/'.date("YmdHis").".".$ext;
			move_uploaded_file($_FILES['file']['tmp_name'],$filename);
			$data['filename']=$filename;
		}
		else
		{
			$data['filename']='';
		}
		
		$pqr=$this->employeemodel->submit_doc($data);
		echo "Data Inserted successfully";
	}
	public function download()
	{
		$id=$this->input->get(id);
		$data['result'] = $this->employeemodel->download_doc($id);		
		 $this->load->helper('download');
		   force_download($data['result']['Uploaded_File'], NULL);
	}
	
	function doc_list()
	{
		$data["page"]="document_grid";
		//$user=$this->user[''];
		//print_r($this->user['int_user_id']);exit;
		$data['users']=$this->employeemodel->get_all_documents($this->user['int_user_id']);
		$data=$this->load->view('employee/page',$data);
			
	}
	
	function delete_doc()
	{
		$id=$this->input->get(id);
		$data=$this->employeemodel->delete_doc($id);
		redirect('employee/doc_list','refresh');
		//redirect('employee/cli_list','refresh');
	}
}
?>