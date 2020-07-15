<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

//helper untuk check empty atau null
if (!function_exists('is_exist')){
    function is_exist($val){
        return (isset($val) || empty($val)  || trim($val) !== '');
    }
}

if (!function_exists('get_valuesetting')){
    function get_valuesetting($key){
        return get_instance()->db->get_where('setting',array('stg_name' => $key))->row()->stg_value; 
       
    }
}


if (! function_exists('json_response')) {
    function json_response($status, $message = null, $data = null, $expand_value = null, $resp_code = 200)
    {
        // get main CodeIgniter object
        $CI = get_instance();
        
        if($status === 'error'){
            if(!is_exist($message))
                $message = 'Invalid input';
        }
        $response = array('status' => $status, 
                            'message' => $message,
                            'data' => $data);

        if($expand_value !== NULL && is_array($expand_value)) {
            $response = array_merge($response,$expand_value);
        }

        $CI->output
                    ->set_status_header($resp_code)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
        
    }
}

if(!function_exists('upload_media_photo')){
    function upload_media_photo($selector,$upload_path,$encrypt_name = TRUE){
        /* foto modification */
        $response = new stdClass();
        $CI = get_instance();
        $CI->load->library('upload');

        $config['upload_path'] = $upload_path; //path folder
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '1024';
        $config['encrypt_name'] = $encrypt_name; //Enkripsi nama yang terupload
        $CI->upload->initialize($config); //initialize upload library
        if(!empty($_FILES[$selector]['name'])){
            if ($CI->upload->do_upload($selector)){  //name of input upload file
                $imgObj = $CI->upload->data();
                //Compress Image
                $config['image_library']='gd2';
                $config['source_image']= $upload_path.''.$imgObj['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= FALSE;
                $config['quality']= '50%';
                $config['width']= 200;
                $config['height']= 200;
                $config['new_image']= $upload_path.$imgObj['file_name'];
                $CI->load->library('image_lib', $config);
                $CI->image_lib->resize();

                $response->success = true;
                $response->data = $imgObj;
            }else{
                $response->success = false;
                $response->data = $CI->upload->display_errors();
            }
        }else{
                $response->success = false;
                $response->data = 'Field '.$selector.' not found';
        }
        return $response;         
    }
}

if(!function_exists('delete_media_photo')){
    function delete_media_photo($upload_name){
        if(file_exists($upload_name)){
            unlink($upload_name);
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('generate_code')){
    function generate_code($input,$pad_len = 7,$prefix=NULL){
        if ($pad_len <= strlen($input))
            trigger_error('$pad_len less than $input', E_USER_ERROR);
        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }
}

if(!function_exists('number_rp')){
    function number_rp($number){
        return "Rp " . number_format($number,2,',','.');
    }
}