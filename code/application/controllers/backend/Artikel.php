<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_artikel'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('artikel'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Artikel';
        $data['plugin'] = array('assets/plugins/summernote/summernote-bs4.js');
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/artikel'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/artikel/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("art_status != ".DELETED);

        $this->m_artikel->get_datatable(implode(" AND ",$filter_cols),"art_name desc");
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('art_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_artikel->set_select_mode('detail');
        $detail = $this->m_artikel->get_by_multiple_column(array(
                                                                    'art_id' => $pk_id,
                                                                    'art_status !=' => DELETED
                                                                ));
                                                            
        //output
        if($detail !== NULl) json_response('success','',$detail);
        else json_response('error','Data tidak ada');
    }

    public function add(){

		$this->auth->set_access_create();

		$this->save();
    }
    
    public function edit(){
        $this->auth->set_access_update();

        $this->save();
    }

    private function save(){
        if(!$this->input->is_ajax_request()) show_404();

        //validation
		$this->load->library('form_validation');
		$this->form_validation->set_rules('art_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('art_name'  , 'Nama artikel'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('art_content' , 'Konten artikel'  , 'trim|required'); 
        $this->form_validation->set_rules('art_status', 'Status', 'integer');
        
        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');
            //insert
            if($this->input->post('art_id') == ''){
                $art_id = $this->m_artikel->insert(
                                                $this->auth->getUserid(),
                                                $this->input->post('art_name'),
                                                implode("-",explode(" ",$this->input->post('art_name'))),
                                                $this->input->post('art_content'),
                                                $this->input->post('art_status') == PUBLISH ? PUBLISH : DRAFT,
                                                $current_time,
                                                $current_time
                                                );
                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('art_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_artikel->get_by_multiple_column(array(
                                                'art_id' => $pk_id,
                                                'art_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_artikel->update($pk_id,
                                                $this->auth->getUserid(),
                                                $this->input->post('art_name'),
                                                implode("-",explode(" ",$this->input->post('art_name'))),
                                                $this->input->post('art_content'),
                                                $this->input->post('art_status') == PUBLISH ? PUBLISH : DRAFT,
                                                FALSE,
                                                $current_time
                                                );
                    json_response('success','Sukses Edit');
                }else
                    json_response('error','Data tidak ditemukan');
            }
        }else
            json_response('error',validation_errors());
    }

    public function delete(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_delete();
        if($this->input->post('art_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('art_id') as $row){
			$row = intval($row);
            $deleted = $this->m_artikel->get_by_column($row);
			if($deleted !== NULL){
                $this->m_artikel->update_single_column('art_status', DELETED, $row);
                $all_deleted[] = array("id" => $row, "status" => "success");
			}
        }
        if(count($all_deleted) > 0){
            json_response('success','sukses hapus');
        }else{
            json_response('error','gagal hapus');
        }

    }

    //upload image summernote
    public function upload_image(){
        $this->auth->set_access_create();

        $this->load->library('upload');
        if(isset($_FILES["image"]["name"])){
           
            $config['upload_path'] = './assets/img/upload/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '1024';
            $config['file_name'] = md5(date('Y-m-d H:i:s'));
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('image')){
                json_response('error',$this->upload->display_errors());
                //json_response('error','Error');
                //die();
            }else{
                $data = $this->upload->data();
                //Compress Image
                $config['image_library']='gd2';
                $config['source_image']='./assets/img/upload/'.$data['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= TRUE;
                $config['quality']= '50%';
                $config['width']= 800;
                $config['height']= 800;
                $config['new_image']= './assets/img/upload/'.$data['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                json_response('success',base_url().'assets/img/upload/'.$data['file_name']);
            }
        }
        
    }

    //Delete image summernote
    function delete_image(){
        $this->auth->set_access_update();

        $src = $this->input->post('src');
        $file_name = str_replace(base_url(), '', $src);
        if(file_exists($file_name)){
            if(unlink($file_name))
            {
                json_response('success','sukses hapus');
            }
        }else{
            json_response('error','file tidak ada di server');
        }
    }


    
}