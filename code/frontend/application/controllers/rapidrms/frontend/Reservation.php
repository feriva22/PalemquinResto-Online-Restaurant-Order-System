<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/rapidrms/frontend/TemplateRms.php");

class Reservation extends TemplateRms {

    public function __construct(){
		parent::__construct();
        $this->load->model(array('menu/MenuModel','reservation/ReservationModel'));
        $this->load->library('cart');
        $this->load->library('form_validation');

    }

    public function index(){
        $this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Reservasi Tempat";
        $this->data["css"] = NULL;
		$this->data["js"] = array('reservation.js');
		$this->data["breadcrumb"] = TRUE;
        $this->data["content"] = "reservation.php";
        $this->data["records"] = array(
        );  
        $this->data['with_footer'] = false;

        $this->loadView();

    }


    public function get_mapReservation(){

        $this->form_validation->set_rules('date', 'Date Reservation', 'trim|required|callback_check_date');   
        $this->form_validation->set_rules('time', 'Time Reservation', 'trim|required|callback_check_time');
        $this->form_validation->set_rules('people','People Reservation','required|numeric');
        if ($this->form_validation->run() == FALSE)
        {
            $this->output->set_status_header('404'); //status bad request
            echo json_encode(array(
                'success' => false,
                'message' => validation_errors()
            ));
            exit();
        }
        
        $fromDateQuery = date("Y-m-d H:i:s", strtotime($this->input->post("date")." ".$this->input->post("time")));
        $timeDefaultReservation = $this->db->get_where('setting',array('stg_name' => 'reservationend_default'))->row()->stg_value;

        $toDateReservation = date(" Y-m-d H:i:s", strtotime('+'.$timeDefaultReservation.' minutes',
                            strtotime($this->input->post("date")." ".$this->input->post("time"))));

        $filters = array(
            'byPeople' => $this->input->post('people'),
            'byfromDate' => $fromDateQuery,
            'bytoDate' => $toDateReservation
        );

        $imageMap = $this->db->get_where('setting',array('stg_name' => 'tablemap_img'))->row()->stg_value;
        $datatableMap = $this->ReservationModel->getMapData();
        //check image exist or not
        if($imageMap !== NULL){
            $urlImage = $this->config->item('upload_backend_path').$imageMap;
            /*if(!file_exists('./assets/rapidrms/img/'.$urlImage)){
                $this->output->set_status_header('404'); //status access denied
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Image map not found, please contact your provider'
                ));
                exit();
            }*/
            list($width, $height, $type, $attr) = getimagesize($urlImage);
        }
        $data = array();
        $data['message'] = "Silahkan pilih kursi";
        $data['filters'] = $filters;
        $data['imageData'] = $this->config->item('backend_url').$imageMap;
        $data['width'] = $width;
        $data['height'] = $height;
        $data['tableMap'] = array();

        foreach($datatableMap->result() as $row){
            $attr = json_decode($row->tbm_attr);
            $data['tableMap'][] = array(
                "id" => $row->tbm_id,
                "title" => $row->tbm_name,
                "capacity" => $row->tbm_max,
                "min_people" => $row->tbm_min,
                "x" => $attr->loc_x,
                "y" => $attr->loc_y,
                "radius" => $attr->rad_circle,
                "text_size" => $attr->text_size,
                "selected" => $this->order_check($row->tbm_max,$row->tbm_min,$filters,$row->tbm_name),
                    "color" => ($this->order_check($row->tbm_max,$row->tbm_min,$filters,$row->tbm_name)) ? "#d82020" : "#c0d6e4",  
            );
        }

        echo json_encode($data);
        exit();
    }

    private function order_check($max,$min,$filters,$id_table){
        $result = $this->ReservationModel->getOrderReservation(array(
                                                'odr_table' => $id_table,
                                                'odr_start <=' => $filters['byfromDate'],
                                                'odr_end >'   => $filters['bytoDate'],
                                                'odr_status' => PROCESS
                                                ));
        $check_people = ((int) $filters['byPeople'] <= (int) $max && (int) $filters['byPeople'] >= (int) $min ? true : false);

        if(count($result) == 0 && $check_people)
            return true; //NO ORDER WITH THIS PARAMETER
        else
            return false; //HAVE ORDER WITH THIS PARAMETER
    }

    public function check_date($str){
        if (!DateTime::createFromFormat('d-m-Y', $str)) { //yes it's YYYY-MM-DD
            $this->form_validation->set_message('check_date', 'The {field} has not a valid date format');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_time($str){
        list($hh, $mm) = explode(':', $str);
        if (!is_numeric($hh) || !is_numeric($mm))
        {
            $this->form_validation->set_message('check_time', 'Not numeric');
            return FALSE;
        }
        else if ((int) $hh > 24 || (int) $mm > 59)
        {
            $this->form_validation->set_message('check_time', 'Invalid time');
            return FALSE;
        }
        else if (mktime((int) $hh, (int) $mm) === FALSE)
        {
            $this->form_validation->set_message('check_time', 'Invalid time');
            return FALSE;
        }
        return TRUE;
    }
}