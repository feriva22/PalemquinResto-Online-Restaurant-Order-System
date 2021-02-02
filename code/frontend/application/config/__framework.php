<?php defined('BASEPATH') or exit('No direct script access allowed');

$config['site_info'] = 'Sistem Restoran Palemquinresto';
$config['backend_url'] = 'http://admin.palemquinresto.com/';
$config['upload_backend_path'] = '../';

define('DELETED', 0);
define('PUBLISH', 1);
define('DRAFT', 2);

//account 
define('ACTIVE', 1);
define('BLOCKED', 2);
define('NO_CREDENTIAL', 3);


//order status
define('NOT_PAID', 0);
define('HALF_PAID', 1);
define('PAID', 2);
define('CANCELED', 3);
define('REFUND', 4);

//transaction status
define('WAITING', 0);
define('ACCEPTED', 1);
define('REJECTED', 2);

//define delivery
define('DELIVERY', 1);
define('TAKEAWAY', 2);

//for order reservation
define('PROCESS', 1);
define('COMPLETE', 2);

define('GOOGLE_CLIENT_ID', '854830601699-j1sg1p3k1tbpt5mn1ur265mtb2mub1ju.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'YMqsffoziUHpFkk_OuQoNDi6');

define('GOOGLE_API_KEY', 'AIzaSyDhtaJaMoJ8HY_3XZ8dDWzsC896KIEZjCY');


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
