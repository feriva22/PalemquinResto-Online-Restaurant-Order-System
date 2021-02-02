<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_menu', 'm_kategorimenu', 'm_menutambahan'));

        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('menu'); //check for current module

        $this->auth->authorize();    //authorize the user        
    }

    public function index()
    {
        $this->auth->set_access_read();

        $data = array();

        $data['page_title'] = 'Menu';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/menu'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();
        $data['data_group'] = $this->m_kategorimenu->get();
        $data['data_menuadditional'] = $this->m_menutambahan->get();

        $this->load->view('backend/__base/header_dashboard', $data);
        $this->load->view('backend/__base/sidebar', $data);
        $this->load->view('backend/menu/index', $data);
        $this->load->view('backend/__base/footer_dashboard', $data);
    }

    public function get_datatable()
    {
        //allow ajax only
        if (!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("mnu_status != " . DELETED);

        $this->m_menu->get_datatable(implode(" AND ", $filter_cols), "mnu_name asc");
    }

    public function get_menuajax()
    {
        //allow ajax only
        if (!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $query = trim($this->input->post('q'));
        $per_page = 30;
        $page = intval($this->input->post('page'));
        $filter_cols = "mnu_status = " . PUBLISH;
        $param_query = "(mnu_name LIKE '%" . $query . "%' OR mnc_name LIKE '%" . $query . "%')";

        $result = $this->m_menu->search(
            $filter_cols . " AND " . $param_query,
            $page !== NULL ? $page : 0,
            $per_page
        );
        json_response('success', '', $result, array('total_count' => count($result)));
    }


    public function detail()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('mnu_id');
        if ($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_menu->set_select_mode('detail');
        $detail = $this->m_menu->get_by_multiple_column(array(
            'mnu_id' => $pk_id,
            'mnu_status !=' => DELETED
        ));
        //output
        if ($detail !== NULl) {
            $detail->mnu_additional = array();
            $res_selected = $this->db->get_where('menu_additionalitem', array('mai_menu' => $pk_id))->result();
            foreach ($res_selected as $select) {
                $detail->mnu_additional[] = $select->mai_menuadditional;
                $detail->mnu_additionaldetail[] = $this->m_menutambahan->get("mad_id = " . $select->mai_menuadditional);
            }
            json_response('success', '', $detail);
        } else json_response('error', 'Data tidak ada');
    }


    public function add()
    {

        $this->auth->set_access_create();

        $this->save();
    }

    public function edit()
    {
        $this->auth->set_access_update();

        $this->save();
    }

    private function save()
    {
        if (!$this->input->is_ajax_request()) show_404();

        //validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('mnu_id', 'Id Menu', 'integer');
        $this->form_validation->set_rules('mnu_name', 'Nama Menu', 'trim|required|max_length[45]');
        $this->form_validation->set_rules('mnu_desc', 'Deskripsi Menu', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('mnu_category', 'Kategori Menu', 'intval|required');
        $this->form_validation->set_rules('mnu_price', 'Harga', 'intval|required');
        $this->form_validation->set_rules('mnu_minorder', 'Minimal Order', 'trim|required|max_length[45]');
        $this->form_validation->set_rules('mnu_variant_parent', 'Varian', 'intval');
        $this->form_validation->set_rules('mnu_status', 'Status', 'integer');

        if ($this->form_validation->run()) {

            $current_time = date('Y-m-d H:i:s');

            //insert
            if ($this->input->post('mnu_id') == '') {
                if ($_FILES['mnu_photo']['name'] !== "") {
                    $upload_status = upload_media_photo('mnu_photo', './assets/img/upload');
                    if (!$upload_status->success) {
                        json_response('error', $upload_status->data);
                    }
                }
                $mnu_id = $this->m_menu->insert(
                    $this->input->post('mnu_name'),
                    $this->input->post('mnu_desc'),
                    $this->input->post('mnu_category'),
                    $this->input->post('mnu_price'),
                    $_FILES['mnu_photo']['name'] !== "" ?
                        'assets/img/upload/' . $upload_status->data['file_name'] :
                        FALSE,
                    $this->input->post('mnu_minorder'),
                    $this->input->post('mnu_variant_parent') !== "" ? $this->input->post('mnu_variant_parent') : FALSE,
                    $this->input->post('mnu_status') == PUBLISH ? PUBLISH : DRAFT,
                    $current_time,
                    $current_time
                );

                $all_deleted = array();
                if ($this->input->post('mnu_additional') !== NULL) {
                    foreach ($this->input->post('mnu_additional') as $row) {
                        $row = intval($row);
                        $this->db->insert('menu_additionalitem', array(
                            'mai_menu' => $mnu_id,
                            'mai_menuadditional' => $row
                        ));
                        $all_deleted[] = array("id" => $row);
                    }
                }
                json_response('success', 'Sukses menambah');
            }
            //update
            else {
                $pk_id = $this->input->post('mnu_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_menu->get_by_multiple_column(array(
                    'mnu_id' => $pk_id,
                    'mnu_status !=' => DELETED
                ));
                if ($edited !== NULL) {
                    //get current photo
                    $current_photo = $edited->mnu_photo !== NULL ? $edited->mnu_photo : NULL;
                    $upload_status = null;
                    if ($_FILES['mnu_photo']['name'] !== "") {
                        delete_media_photo($current_photo);
                        $upload_status = upload_media_photo('mnu_photo', './assets/img/upload');
                        if (!$upload_status->success) {
                            json_response('error', $upload_status->data);
                        }
                    }

                    //delete on menu additionalitem
                    $res_selected = $this->db->get_where('menu_additionalitem', array('mai_menu' => $pk_id))->result();

                    //set detail selected
                    $detail_menu = array();
                    foreach ($res_selected as $select) {
                        $detail_menu[] = $select->mai_menuadditional;
                    }
                    //delete unselected
                    if ($this->input->post('mnu_additional') == NULL) {
                        $this->db->delete('menu_additionalitem', array('mai_menu' => $pk_id));
                    } else {
                        foreach ($res_selected as $select) {
                            if (!in_array($select->mai_menuadditional, $this->input->post('mnu_additional'))) {
                                $this->db->delete('menu_additionalitem', array(
                                    'mai_menu' => $pk_id,
                                    'mai_menuadditional' => $select->mai_menuadditional
                                ));
                            }
                        }
                        //insert new selected
                        foreach ($this->input->post('mnu_additional') as $row) {
                            if (!in_array($row, $detail_menu)) {
                                $this->db->insert('menu_additionalitem', array(
                                    'mai_menu' => $pk_id,
                                    'mai_menuadditional' => $row
                                ));
                            }
                        }
                    }
                    $this->m_menu->update(
                        $pk_id,
                        $this->input->post('mnu_name'),
                        $this->input->post('mnu_desc'),
                        $this->input->post('mnu_category'),
                        $this->input->post('mnu_price'),
                        $upload_status !== NULL ? 'assets/img/upload/' . $upload_status->data['file_name'] : FALSE,
                        $this->input->post('mnu_minorder'),
                        $this->input->post('mnu_variant_parent') !== "" ? $this->input->post('mnu_variant_parent') : FALSE,
                        $this->input->post('mnu_status') == PUBLISH ? PUBLISH : DRAFT,
                        FALSE,
                        $current_time
                    );

                    json_response('success', 'Sukses Edit', array('photo' => $upload_status->data['file_name']));
                } else
                    json_response('error', 'Data tidak ditemukan');
            }
        } else
            json_response('error', validation_errors());
    }

    public function delete()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_delete();
        if ($this->input->post('mnu_id') === NULL) json_response('error');

        $all_deleted = array();
        foreach ($this->input->post('mnu_id') as $row) {
            $row = intval($row);
            $deleted = $this->m_menu->get_by_column($row);
            if ($deleted !== NULL) {
                $this->m_menu->update_single_column('mnu_status', DELETED, $row);
                $all_deleted[] = array("id" => $row, "status" => "success");
            }
        }
        if (count($all_deleted) > 0) {
            json_response('success', 'sukses hapus');
        } else {
            json_response('error', 'gagal hapus');
        }
    }
}
