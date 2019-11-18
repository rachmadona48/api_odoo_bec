<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$type       = 'out_invoice';
$user               = $uid;

// silakan sesuaikan
$id_customer 		= 651;
$payment_term_id    = 1;
$date_invoice       = '2019-11-16';
$date_due           = '2019-11-16';


$invoice = $models->execute_kw($db, $uid, $password,
    'account.invoice', 'create',
    array(array('type'              => $type,
    			'partner_id'	    => $id_customer,
                'payment_term_id'   => $payment_term_id,
                'date_invoice'      => $date_invoice,
                'date_due'          => $date_due,
                'user_id'           => $user
				
	)));
// $invoice =193;

// line transaksi silakan di looping
$product_id         = 3241; #id product
$name               = 'Urban Farming - SD 4-6'; #nama product dari master product
$account_id         = 17; #Income Account dari master kategori produk atau master produk
$quantity           = 1;
$price_unit         = 1300000; #silakan ambil sell price dari master product
$discount           = 0;

$id_tax             = 3; #dari master tax

$line = $models->execute_kw($db, $uid, $password,
    'account.invoice.line', 'create',
    array(array('invoice_id'    => $invoice,
                'product_id'    => $product_id,
                'name'          => $name,
                'account_id'    => $account_id,
                'quantity'      => $quantity,
                'price_unit'    => $price_unit,
                'discount'      => $discount,
                'invoice_line_tax_ids'  =>array(array(6,0,array($id_tax)))
                
    )));

// akhir looping

echo json_encode($invoice)

?>