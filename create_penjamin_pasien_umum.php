<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$user               = $uid;
$supplier           = False;
$type               = 'contact';

// silakan sesuaikan
$id_simrs           = 10; /*id dari simrs untuk disimpan pada odoo*/
$name               = 'BPJS Kesehatan tes';

$street             = 'Ciseeng';
$street2            = 'Jampang';
$city               = 'Bogor';
$zip                = '12345';
$is_company         = True; /*True jika adalah penjamin dan False jika pasien umum*/
$customer           = True;
$phone              = '081111111';
$mobile             = '021-2222';
$email              = 'tes@simrs.com';



$customer_id = $models->execute_kw($db, $uid, $password,
    'res.partner', 'create',
    array(array('id_simrs'       => $id_simrs,
                'type'           => $type,
    			'supplier'       => $supplier,
                'name'           => $name,
                'street'         => $street,
                'street2'        => $street2,
                'city'           => $city,
                'zip'            => $zip,
                'is_company'     => $is_company,
                'customer'       => $customer,
                'phone'          => $phone,
                'mobile'         => $mobile,
                'email'          => $email,
				
	)));


echo json_encode($customer_id)

?>