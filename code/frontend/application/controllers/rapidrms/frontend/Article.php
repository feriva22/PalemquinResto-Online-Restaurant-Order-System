<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/rapidrms/frontend/TemplateRms.php");

class Article extends TemplateRms {

    public function __construct(){
        parent::__construct();
        $this->load->model(array('article/ArticleModel'));
    }

    public function index(){

        $this->load->library('pagination');

        $config['base_url'] = base_url().'article/index';
        $config['total_rows'] = $this->ArticleModel->get_total();
        $config['suffix'] = '?'.http_build_query($_REQUEST, '', "&");
        $config["uri_segment"] = 3;  // uri paramete
        $config['per_page'] = 5;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        //bootstrap 4         
        $config['first_link']       = 'Pertama';
        $config['last_link']        = 'Akhir';
        $config['full_tag_open']    = '<div class="pagination page-list "><ul class=" list-inline text-right">';
        $config['full_tag_close']   = '</ul></div>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="active">';
        $config['cur_tag_close']    = '</li>';
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tagl_close']  = '</li>';
        $config['first_tag_open']   = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tagl_close']  = '</li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['articles'] = $this->ArticleModel->get(array('art_status'=>PUBLISH),$config['per_page'],$data['page']);
        $data['new_article'] = $this->ArticleModel->get(array('art_status'=>PUBLISH),2,0);
        $data['pagination'] = $this->pagination->create_links(); //create link first
        

        $this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Info & Event";
        $this->data["css"] = NULL;
		$this->data["js"] = array('info-event.js');
		$this->data["breadcrumb"] = FALSE;
        $this->data["content"] = "article.php";
        $this->data["records"] = array(
            "data" =>  $data
        );  
        $this->data['with_footer'] = true;

        $this->loadView();
    }

    public function view($url_slug){


        $data['article'] = $this->ArticleModel->get(array('art_status'=>PUBLISH,'art_slug'=>trim($url_slug)),
                                                    1,0);
        $data['new_article'] = $this->ArticleModel->get(array('art_status'=>PUBLISH),2,0);


        $this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Info & Event";
        $this->data["css"] = NULL;
		$this->data["js"] = array('info-event.js');
		$this->data["breadcrumb"] = FALSE;
        $this->data["content"] = "article_view.php";
        $this->data["records"] = array(
            "data" =>  $data
        );  
        $this->data['with_footer'] = true;

        $this->loadView();
    }

}