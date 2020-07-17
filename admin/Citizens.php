<?php

/**
 * Created by HASSAN.
 * User: HASSAN
 * Date: 10/25/2019
 * Time: 12:12 PM
 * Project: smartid
 */
class Citizens extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->helper('json_output_helper');
        $this->load->model('data_model');
    }
    private function verify_access()
    {
        $p_name = $this->input->get_request_header('platform_name');
        $pass_code = $this->input->get_request_header('pass_code');
        $verification = $this->data_model->verify_platform($p_name,$pass_code);
        if($verification == false){
            return false;
        }else{
            return true;
        }
    }
    private function retrieve_data(){
        $data = $this->security->xss_clean($this->input->raw_input_stream);
        $data = json_decode($data, true);
        return $data;
    }
    public function index(){
        echo "Here";
    }
    public function get_details()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400, array('status'=>400,'Error'=>true,'message'=>'Bad request'));
            exit();
        }
        $access = $this->verify_access();
        if($access == false){
            json_output(403,array('status'=>400,'Error'=>true, 'message'=>'Access denied'));
            exit();
        }
        $params = $_REQUEST;
        $smartid = null;
        $fname = null;
        $lname= null;
        $dob = null;
        $admin = null;
        if(isset($params['admin'])){
            $admin = $params['admin'];
            if(isset($params['smart_id'])){
                $smartid = $params['smart_id'];
                $info = $this->data_model->get_details($admin,$smartid);
                json_output(200,$info);

            }elseif (isset($params['fname']) && isset($params['lname']) && isset($params['dob'])){
                $fname = $params['fname'];
                $lname = $params['lname'];
                $dob = date('Y-m-d',strtotime($params['dob']));
                $info = $this->data_model->get_details($admin,null,$fname,$lname,$dob);
                if(is_string($info)){
                    json_output(200,array('message'=>$dob));
                }else{
                    json_output(200,$info);
                }

            }else{
                json_output(400,array('status'=>400,'Error'=>true,'message'=>'provide Smart id or Full names with date of birth'));
            }
        }else{
            //json_output(200,array("error"=>$params));
            json_output(403,array('Error'=>true,'Message'=>'This admin has no access'));
        }
    }
//    public function json_output($statusheader,$response){
//        $cl =& get_instance();
//        $cl->output->set_content_type('application/json');
//        $cl->output->set_status_header($statusheader);
//        $cl->output->set_output(json_encode($response));
//    }
    public function create()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method !== 'POST'){
            json_output(400, array('status'=>400,'message'=>'Bad request'));
        }else{
            $access = $this->verify_access();
            if($access == false){
                json_output(403,array('status'=>403, 'message'=>'Access denied'));
                exit();
            }
            $params = $this->retrieve_data();
            $response = $this->data_model->create_citizen($params);
            if(is_string($response)){
                json_output(403,array('status'=>403,'Error'=>true, 'message'=>$response));
            }else{
                //json_output(200,$response);
                json_output(200,array('status'=>200,'message'=>"Profile created","Citizen_ID"=>$response['Citizen_ID']));
            }
        }

    }

    public function create_citi(){
        $ret_array = array();
        $params = array(
            'fname' => $this->input->post('fname'),
            'lname'=>$this->input->post('lname'),
            'o_name'=>$this->input->post('o_name'),
            'res_address'=>$this->input->post('res_address'),
            'marr_stat'=>$this->input->post('m_stat'),
            'phone'=>$this->input->post('phone'),
            'email'=>$this->input->post('email'),
            'dob'=>$this->input->post('d-o-b')
        );
        $response = $this->data_model->create_citizen($params);
        if(is_string($response)){
            $ret_array['error'] = $response;
        }else{
            $ret_array['message'] = "Profile created";
        }
    }
}