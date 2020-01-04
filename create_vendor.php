<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$user               = $uid;
$supplier           = True;
$customer           = False;
$type               = 'contact';

// silakan sesuaikan
$id_simrs           = 10; /*id dari simrs untuk disimpan pada odoo*/
$name               = 'Vendor 1';

$street             = 'Ciseeng';
$street2            = 'Jampang';
$city               = 'Bogor';
$zip                = '12345';
$is_company         = True; /*True jika vendor adalah perusahaan*/
$phone              = '081111111';
$mobile             = '021-2222';
$email              = 'vendor@gmail.com';



$vendor_id = $models->execute_kw($db, $uid, $password,
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
                'supplier'       => $supplier,
                'customer'       => $customer,
                'phone'          => $phone,
                'mobile'         => $mobile,
                'email'          => $email,
				
	)));


echo json_encode($vendor_id)

?>