<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$user               = $uid;

// silakan sesuaikan
$id_customer 		= 651;
$payment_term_id    = 1;
$date_invoice       = '2019-11-30';
$date_due           = '2019-11-30';


$order = $models->execute_kw($db, $uid, $password,
    'sale.order', 'create',
    array(array(
    			'partner_id'	    => $id_customer
	)));
// $order =343;

// line transaksi silakan di looping
$product_id         = 3241; #id product
$quantity           = 3;
$discount           = 0;

$line = $models->execute_kw($db, $uid, $password,
    'sale.order.line', 'create',
    array(array('order_id'          => $order,
                'product_id'        => $product_id,
                'product_uom_qty'   => $quantity,
                'discount'          => $discount
                
    )));

// akhir looping

echo json_encode($order)

?>