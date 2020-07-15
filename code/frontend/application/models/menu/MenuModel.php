<?php 

    class MenuModel extends CI_Model {

        public function listMenu($start = null,$length =null,$search = null,$filter = null){
            //get list menu
            $this->db->select('menu.*, mnc_name AS kategori');
            $this->db->from('menu');
            $this->db->join('menu_category','mnu_category = mnc_id');
            $this->db->where('mnu_status',PUBLISH);
            if (isset($filter["minprice"]) && $filter["minprice"] !== '') $this->db->where('mnu_price >=', (int)$filter["minprice"]);
            if (isset($filter["maxprice"]) && $filter["maxprice"] !== '') $this->db->where('mnu_price <=', (int)$filter["maxprice"]);
            if (isset($filter["idmenu"]) && $filter["idmenu"] !== '' ) $this->db->where('mnu_id',(int)$filter["idmenu"]);
            if (isset($filter["category"]) && $filter["category"] !== '') $this->db->like('mnc_name',$filter["category"]);
            if (isset($filter["menuType"]) && $filter["menuType"] !== '') $this->db->where('mnu_category',(int)$filter["menuType"]);
            if (isset($search) && $search !== '') $this->db->like('mnu_name',$search);
            $this->db->order_by('mnu_created', 'DESC');
            if (isset($start) || isset($length)) $this->db->limit($length,$start);

            $query = $this->db->get();
            return array($query, $this->db->last_query());
        }

        public function listMenuOptional($start=null, $length=null, $search=null,$filter=null){
            //get list menu
            $this->db->select("*");
            $this->db->from('menu_additionalitem');
            $this->db->join('menu_additional','mad_id = mai_menuadditional');
            if (isset($filter["idmenu"]) && $filter["idmenu"] !== '' ) $this->db->where('mai_menu',(int)$filter["idmenu"]);
            if (isset($search) && $search !== '') $this->db->like('mad_name',$search);
            if (isset($start) || isset($length)) $this->db->limit($length,$start);
            $query = $this->db->get();
            return $query;
        }

        public function listOptional($start=null,$length=null,$search=null,$filter=null){
            $this->db->select("*");
            $this->db->from('menu_additional');
            if (isset($filter["idmenu_tambahan"]) && $filter["idmenu_tambahan"] !== '' ) $this->db->where('mad_id',(int)$filter["idmenu_tambahan"]);
            if (isset($search) && $search !== '') $this->db->like('mad_name',$search);
            if (isset($start) || isset($length)) $this->db->limit($length,$start);
            $query = $this->db->get();
            return $query;

        }
        
        function get_totalMenu($filter){
            if (isset($filter["menuType"]) && $filter["menuType"] !== '') $this->db->where('mnu_category',(int)$filter["menuType"]);
            $result = $this->db->get_where('menu',array('mnu_status '=> PUBLISH))->result();
            return $result !== NULL ? count($result) : 0;
        }

        public function addMenu($data){
            
            $this->db->select("idkategori_menu");
            $this->db->from("kategori_menu");
            $this->db->where("nama",$data['kategori']);
            $this->db->limit(1);
            $result = $this->db->get();
            if($result->num_rows() >0){
                $idkategori = $result->row_array();
                unset($data['kategori']);   //remove key value pair for kategori because not in table
                $data['idkategori_menu'] = $idkategori['idkategori_menu'];

                $this->db->insert('menu',$data);
                if(!$this->db->affected_rows()){
                    return array(
                        "success" => false,
                        "message" => "Data sudah ada"
                    );
                }else {
                    return array(
                        "success" => true,
                        "message" => "Sukses tambah menu"
                    );
                }
            }else{
                return array(
                    "success" => false,
                    "message" => "Menu kategori tidak ada"
                );
            }
        }

        public function addMenuOpt($data){

            $this->db->insert('menu_tambahan',$data);
            if(!$this->db->affected_rows()){
                return array(
                    "success" => false,
                    "message" => "Data sudah ada"
                );
            }else {
                return array(
                    "success" => true,
                    "message" => "Sukses tambah menu"
                );
            }
            
        }

        public function editMenu($data){
            $this->db->select("idkategori_menu");
            $this->db->from("kategori_menu");
            $this->db->where("nama",$data['kategori']);
            $this->db->limit(1);
            $result = $this->db->get();
            $idkategori = $result->row_array();
            $colupdated = array(
                'nama' => $data['nama'],
                'deskripsi' => $data['deskripsi'],
                'harga' => $data['harga'],
                'idkategori_menu' => $idkategori['idkategori_menu'],
                'minim_dp' => $data['minim_dp'],
                'minim_order' => $data['minim_order']

            );
            if (isset($data['foto'])){
                $colupdated["foto"] = $data['foto'];
            }
            //update data 
            $this->db->where('idmenu',$data['idmenu']);
            $this->db->update('menu',$colupdated);
            if(!$this->db->affected_rows()){
                return array(
                    "success" => false,
                    "message" => "ID menu tidak ditemukan atau menu tidak diedit"
                );
            }else {
                return array(
                    "success" => true,
                    "message" => "Sukses edit Menu"
                );
            }
        }

        public function editMenuOpt($data){
            $colupdated = array(
                'nama' => $data['nama'],
                'deskripsi' => $data['deskripsi'],
                'harga' => $data['harga'],
                'unit' => $data['unit']
            );
            //update data 
            $this->db->where('idmenu_tambahan',$data['idmenu_tambahan']);
            unset($data['idmenu_tambahan']);
            $this->db->update('menu_tambahan',$data);
            if(!$this->db->affected_rows()){
                return array(
                    "success" => false,
                    "message" => "ID menu tidak ditemukan atau menu tidak diedit"
                );
            }else {
                return array(
                    "success" => true,
                    "message" => "Sukses edit Menu"
                );
            }
        }

        public function deleteMenu($idmenus){
            //change status delete to 1 by idmenu
            $data = array(
                'status_delete' => 1,
                'modified_date' => date("Y-m-d H:i:s")
            );
            $totDel = 0;

            foreach($idmenus as $idmenu){
                $this->db->where('idmenu',$idmenu);
                $this->db->where('status_delete',0);
                $this->db->update('menu',$data);

                if($this->db->affected_rows()){
                    $totDel++;
                }
            }
            
            return $totDel;
        }

        public function deleteMenuOpt($idmenus_opt){
            $totDel = 0;
            foreach($idmenus_opt as $idmenu){
                $this->db->where('idmenu_tambahan',$idmenu);
                $this->db->delete('menu_tambahan');
                if($this->db->affected_rows()){
                    $totDel++;
                }
            }            
            return $totDel;
        }
        
        public function setStatusMenu($idmenu){
            $this->db->where('idmenu',$idmenu);
            $this->db->select('active');
            $this->db->from('menu');
            $this->db->limit(1);
            $result = $this->db->get();
            if($result->num_rows() >0){
                $data = $result->row_array();
                if($data['active'] != 0){
                    $this->db->where('idmenu',$idmenu);
                    $this->db->update('menu',array('active' => 0));
                    $status = 'deactivated';
                }else{
                    $this->db->where('idmenu',$idmenu);
                    $this->db->update('menu',array('active' => 1));
                    $status = 'activated';
                }
                return array(
                    "success" => true,
                    "message" => "Success status menjadi ".$status
                );
            }
            return array("success" => false);
        }

        public function LastUpdateMenu(){
            $this->db->select('modified_date');
            $this->db->from('menu');
            $this->db->order_by('modified_date','DESC');
            $this->db->limit(1);
            $query = $this->db->get();
            return $query;

        }

        public function listCategory(){
            $this->db->select('*');
            $this->db->from('kategori_menu');
            $this->db->where('status_delete',0);
            $query = $this->db->get();
            return $query;
        }

        public function LastUpdateCategoryMenu(){
            $this->db->select('modified_date');
            $this->db->from('kategori_menu');
            $this->db->order_by('modified_date','DESC');
            $this->db->limit(1);
            $query = $this->db->get();
            return $query;
        }

        public function addCategory($data){
            $insert = $this->db->insert('kategori_menu',$data);
            $error = $this->db->error();
            if (!$insert && $error['code'] === 1062) {
                return array(
                    "success" => false,
                    "message" => 'Data sudah ada' //$error['message]
                );
             } else {
                return array(
                    "success" => true,
                    "message" => "Sukses tambah data"
                );
             }   
        }

        public function editCategory($data){
            //update data 
            $this->db->where('idkategori_menu',$data['idkategori_menu']);
            unset($data['idkategori_menu']);
            $this->db->update('kategori_menu',$data);
            if(!$this->db->affected_rows()){
                return array(
                    "success" => false,
                    "message" => "ID kategori tidak ditemukan atau kategori menu tidak diedit"
                );
            }else {
                return array(
                    "success" => true,
                    "message" => "Sukses edit Kategori Menu"
                );
            }
        }

        public function deleteCategory($idctgMenus){
            $totDel = 0;
            foreach($idctgMenus as $idctg){
                $this->db->where('idkategori_menu',$idctg);
                $this->db->where('status_delete',0);
                $this->db->update('kategori_menu',array('status_delete' => 1));
                if($this->db->affected_rows()){
                    $totDel++;
                }
            }
            return $totDel;
        }

        //jenis pesanan

        public function listJenisPesanan(){
            $this->db->select('*');
            $this->db->from('jenis_menu');
            $query = $this->db->get();
            return $query;
        }

        //TODO add delete and update and adding data 
    }