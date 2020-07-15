<?php 

    class OrderModel extends CI_Model {

        public function listOrder($start = null,$length =null,$search = null,$filter = null){
            //get list order menu
            $this->db->select('pemesanan.*,user_pelanggan.username as pelanggan');
            $this->db->from('pemesanan');
            $this->db->join('user_pelanggan', 'pemesanan.iduser_pelanggan = user_pelanggan.iduser_pelanggan');
            if (isset($filter["orderStatus"]) && $filter["orderStatus"] !== '') $this->db->where('pemesanan.status',(int)$filter["orderStatus"]);
            
            if (isset($filter["orderDeadline"]) && $filter["orderDeadline"] === 'lessOneWeek') { 
                $this->db->where('pemesanan.waktu_kirim > ','NOW()',FALSE); //set false to prevent tick
                $this->db->where('pemesanan.waktu_kirim <= ','DATE_ADD(NOW(), INTERVAL 7 day)',FALSE);}
            
            if (isset($filter["orderDeadline"]) && $filter["orderDeadline"] === 'ratherOneWeek') {
                $this->db->where("pemesanan.waktu_kirim > ","NOW()",FALSE); 
                $this->db->where("pemesanan.waktu_kirim > ","DATE_ADD(NOW(), INTERVAL 7 day)",FALSE);}

            //paid payment
            /* need updated with unpaid filter
            if ( isset($filter["orderPayStatus"]) && $filter["orderPayStatus"] === 'paid') { 
                $this->db->select("IF(x.bayar >= pemesanan.total_pembayaran,'Lunas','Belum lunas') as 'status', (x.bayar-pemesanan.total_pembayaran) as kembalian");
                $this->db->join('( select sum(subtotal+(subtotal*pajak/100)) as bayar, id_pemesanan from pembayaran where status_pembayaran = 1 GROUP by id_pemesanan) as x','pemesanan.id_pemesanan = x.id_pemesanan');
                $this->db->where("x.bayar >=","pemesanan.total_pembayaran");
            }
            */
            if (isset($search) && $search !== '') {
                $this->db->like('user_pelanggan.username',$search);
                //echo ($this->db->last_query());

            }

            //TODO create other filter 

            $this->db->order_by('created_date','DESC');
            if (isset($start) || isset($length)) $this->db->limit($length,$start);
            $query = $this->db->get();

            return $query;
        }

        public function get_lastorder_id(){
            $this->db->order_by('ord_id','desc');
            $result = $this->db->get("order",0,1)->row();
            if($result !== NULL){
                return $result->ord_id;
            }else{
                return 1; //default if table empty return 1
            }
        }


        public function get_lastinvoice_id(){
            $this->db->order_by('inv_id','desc');
            $result = $this->db->get("invoice",0,1)->row();
            if($result !== NULL){
                return $result->inv_id;
            }else{
                return 1; //default if table empty return 1
            }
        }

        public function totalOrder(){
            //get total order
            $this->db->select("COUNT(*) AS num");
            $query = $this->db->get("pemesanan");
            $result = $query->row();
            if(isset($result)) return $result->num;
            return 0;        
        }

        public function changeStatusOrder($idOrder, $status){
            //change status order
            $this->db->where('id_pemesanan',$idOrder);
            $this->db->update('pemesanan', array('status' => (int)$status));
            if ($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function listPayment($idOrder){
            //get list payment based order id
            $this->db->select('pembayaran.*, via_pembayaran.nama as bayar_via');
            $this->db->from('pembayaran');
            $this->db->join('via_pembayaran', 'pembayaran.idvia_pembayaran = via_pembayaran.idvia_pembayaran');
            $this->db->where('id_pemesanan',$idOrder);
            $this->db->order_by('status_pembayaran','ASC');

            $query = $this->db->get();
            return $query;
        }

        public function OrderShippedAddr($idOrder){
            $this->db->select('pemesanan.idalamat_pengiriman as idalamat_pengiriman,alamat_pengiriman.nama_penerima, alamat_pengiriman.no_hp, alamat_pengiriman.alamat, db_postal_code.*');
            $this->db->from('pemesanan');
            $this->db->join('alamat_pengiriman','alamat_pengiriman.idalamat_pengiriman = pemesanan.idalamat_pengiriman','left');
            $this->db->join('db_postal_code','alamat_pengiriman.db_postal_id = db_postal_code.id','left');
//            $this->db->join('pembayaran','pembayaran.id_pemesanan=')
            $this->db->where('id_pemesanan',$idOrder);
            $this->db->limit(1);

            $query = $this->db->get();
            if($query->num_rows() > 0){
                $dataResult = $query->row_array();
                if($dataResult['idalamat_pengiriman'] === null){
                    return array(
                        'success' => false,
                        'data' => null,
                        'message' => 'Pesanan diambil di Restoran'
                    );
                }else{
                    return array(
                        'success' => true,
                        'data' => $dataResult,
                        'message' => 'Pesanan dikirim ke alamat ini'
                    );
                }
            }else{
                return array(
                    'success' => false,
                    'message' => 'Pesanan tidak ada'
                );
            }
        }

        public function addShipmentAddr($data){
            $this->db->insert('alamat_pengiriman',$data);
            $insertId = $this->db->insert_id();
            return $insertId;   
        }

        public function addOrder($data){
            $this->db->insert('pemesanan',$data);
            $idOrder = $this->db->insert_id();
            //return $insertId;

            //add also in pembayaran
            $dataPayment = array(
                'id_pemesanan' => $idOrder,
                'idvia_pembayaran' => 1,
                'subtotal' => $this->cart->total() ,
                'pajak' => 10,
            );
            $this->db->insert('pembayaran',$dataPayment);
            $idPayment = $this->db->insert_id();

            //add menu on cart to table pemesanan_detail
            foreach($this->cart->contents() as $item){
                $option = $this->cart->product_options($item['rowid']);
                if(isset($option['type']) && $option['type'] == 'common' ){
                    $dataMenu = array(
                        'idmenu' => $item['id'],
                        'iduser_pelanggan' => $this->session->userdata('id'),
                        'id_pemesanan' => $idOrder,
                        'kuantitas' => $item['qty'],
                        'catatan' => $option['note']
                    );
                    $this->db->insert('pemesanan_detail',$dataMenu);
                    $idOrderDetail = $this->db->insert_id();

                    //add menu_tambahan to pemesanan_detail_tambahan
                    foreach($this->cart->contents() as $item_tambahan){
                        $optionTambahan = $this->cart->product_options($item_tambahan['rowid']);
                        if(isset($optionTambahan['type']) && $optionTambahan['type'] == 'optional' ){
                            $dataMenuOpt = array(
                                'idpemesanan_detail' => $idOrderDetail,
                                'idmenu_tambahan' => $item_tambahan['id'],
                                'kuantitas' => $item_tambahan['qty']
                            );
                            $this->db->insert('pemesanan_detail_tambahan',$dataMenuOpt);
                        }
                    }
                }
                else if(isset($option['type']) && $option['type'] == 'reservation'){
                    //edit for reservation
                }
            }

            $this->cart->destroy(); //destroy cart after finish

            return array(
                'success' => true,
                'idOrder' => $idOrder,
                'idPayment' => $idPayment
            );
        }


        
        
    }


