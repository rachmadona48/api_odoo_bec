<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$sale_ok    = false;
$purchase_ok= true;
$type       = 'service';
$categ_id   = 1;
$active     = true;
$lst_price  = 0;


// silakan sesuaikan
$id_simrs           = '10'; /*id dari simrs untuk disimpan pada odoo*/
$name 		        = 'Alat kesehatan';
// silakan sesuaikan

$product = $models->execute_kw($db, $uid, $password,
    'product.product', 'create',
    array(array('id_simrs'          => $id_simrs,
                'name'              => $name,
    			'sale_ok'           => $sale_ok,
                'purchase_ok'       => $purchase_ok,
                'lst_price'         => $lst_price,
    			'type'	            => $type,
                'taxes_id'          =>array(array(6,0,array())),
                'supplier_taxes_id' =>array(array(6,0,array())),
    			'categ_id'		    => $categ_id,
    			'active'	        => $active
				
	)));

// print_r($data);
echo json_encode($product)

?>