<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * dont add config here, add in __custom.php
 * if you want preload __custom, add to config/autoload.php
 */
$config['site_info'] = 'Sistem Restoran Palemquinresto';
$config['site_year'] = '2019';
$config['creator_website'] = 'http://ci.framework.com';

/*
config for auth library
*/
$config['auth_session_name']        = 'resto_session';
$config['auth_dashboard_page']      = 'dashboard';
$config['auth_staff_db']            = 'staff';
$config['auth_staffgroup_db']       = 'staffgroup';
$config['auth_staffgroupacc_db']    = 'staffgroupaccess';
$config['auth_staffgroupacc_prefix']= 'sga_';
$config['auth_staff_prefix']        = 'stf_';
$config['auth_user_pk']             = 'id';
$config['auth_moduleaccess_db']     = 'moduleaccess';
$config['auth_moduleaccess_prefix'] = 'mda_';
$config['auth_module_db']           = 'module';
$config['auth_module_prefix']       = 'mdl_';



//general  status account
define('ACTIVE',1);
define('SUSPEND',2);

define('NO_CREDENTIAL',3);

//item status 
define('DELETED',0);
define('PUBLISH',1);
define('DRAFT',2);


//ordering type
define('KATERING',1);
define('RESERVASI',2);
//define delivery
define('DELIVERY',1);
define('TAKEAWAY',2);


//ordering type payment
define('CASH',1);
define('BANK_TRANSFER',2);

//order status
define('NOT_PAID',0);
define('HALF_PAID',1);
define('PAID',2);
define('CANCELED',3);
define('REFUND',4);

//transaction status
define('WAITING',0);
define('ACCEPTED',1);
define('REJECTED',2);

//order reservation status
define('PROCESS',1);
define('COMPLETE',2);

//invoice payment 
//just have 2 NOT_PAID and PAID

//define type of user
define('ADMIN',1);
define('CASHIER',2);
define('CUSTOMER',3);

//define login method
define('USERNAME_PASSWORD',0);

define('ORDERED',1);

//define unit discount
define('PERCENT',2);


$config['order_status'] = array(
    NOT_PAID => array(
        'text' => 'UNPAID',
        'label' => '<label class="badge badge-danger">UNPAID</label>'
    ),
    HALF_PAID => array(
        'text' => 'HALF PAID',
        'label' => '<label class="badge badge-primary">HALF PAID</label>'
    ),
    PAID => array(
        'text' => 'PAID',
        'label' => '<label class="badge badge-success">PAID</label>'
    ),
    CANCELED => array(
        'text' => 'CANCELED',
        'label' => '<label class="badge badge-secondary">CANCELED</label>'
    ),
    REFUND => array(
        'text' => 'REFUND',
        'label' => '<label class="badge badge-dark">REFUND</label>'
    ),
);

$config['trs_status'] = array(
    WAITING => array(
        'text' => 'Menunggu Konfirmasi',
        'label' => '<label class="badge badge-warning">Menunggu Konfirmasi</label>'
    ),
    ACCEPTED => array(
        'text' => 'Terbayar',
        'label' => '<label class="badge badge-success">Diterima</label>'
    ),
    REJECTED => array(
        'text' => 'Dibatalkan',
        'label' => '<label class="badge badge-danger">Ditolak</label>'
    )
);

$config['invoice_status'] = array(
    NOT_PAID => array(
        'text' => 'UNPAID',
        'label' => '<label class="badge badge-danger">UNPAID</label>'
    ),
    PAID => array(
        'text' => 'PAID',
        'label' => '<label class="badge badge-success">PAID</label>'
    ),
    CANCELED => array(
        'text' => 'CANCELED',
        'label' => '<label class="badge badge-secondary">CANCELED</label>'
    ),
);

$config['type_payment'] = array(
    CASH => 'Cash',
    BANK_TRANSFER => 'Transfer bank'
)
?>