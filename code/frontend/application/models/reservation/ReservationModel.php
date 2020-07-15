<?php 

    class ReservationModel extends CI_Model {

        public function getOrderReservation($filters){
            return $this->db->get_where('order_reservation',$filters,200)->result();
        }

        public function setReservationOptions($reservation_Opt,$data){
                $this->db->where('config_name',$reservation_Opt);
                $this->db->update('reservasi_config',array('config_value' => $data));
                if(!$this->db->affected_rows()){
                    return array(
                        "success" => false,
                        "message" => "Gagal update data"
                    );
                }else{
                    return array(
                        "success" => true,
                        "message" => "Berhasil update data"
                    );
                }
            
        }
        

        public function getMapData(){
            $this->db->select('*');
            $this->db->from('table_map');
            $result = $this->db->get();
            return $result;
        }

        public function setMapData($dataMap){
            $this->db->empty_table('reservasi_mejamap');
            $iter = 0;
            foreach($dataMap as $data){
                $this->db->insert('reservasi_mejamap',$data);
                $iter++;
            }
            if($iter === sizeof($dataMap)){
                return true;
            }else{
                return false;
            }
        }

        public function getBookingList($filters,$table_no){
            $this->db->select('*');
            $this->db->from('reservasi_booking');
            $this->db->where('waktu_mulai <= ',$filters['byfromDate']);
            $this->db->where('waktu_selesai >',$filters['byfromDate']);
            $this->db->where('nomer_meja',(int) $table_no);
            $this->db->where('status !=',2);
            $result = $this->db->get();
            
            if($result->num_rows() > 0){
                return true;
            }else{
                return false;
            }
            
        }

    }