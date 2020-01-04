<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$type       = 'in_invoice';
$journal_id = 2; /*journal vendor bill*/
$user       = $uid;

// silakan sesuaikan
$account_id      = 6164; /*coa AP*/
$id_simrs        = '10'; /*id dari simrs untuk disimpan pada odoo*/
$no_bapb_simrs   = 'BAPB/1'; /*no BAPB dari simrs untuk disimpan pada odoo*/
$no_faktur_simrs = 'Faktur/1'; /*no faktur dari simrs untuk disimpan pada odoo*/

$id_vendor 		    = 106;
$date_invoice       = '2020-01-04';
$date_due           = '2020-01-10';


$invoice = $models->execute_kw($db, $uid, $password,
    'account.invoice', 'create',
    array(array('id_simrs'          => $id_simrs,
                'no_bapb_simrs'     => $no_bapb_simrs,
                'no_faktur_simrs'   => $no_faktur_simrs,
                'type'              => $type,
    			'partner_id'	    => $id_vendor,
                'date_invoice'      => $date_invoice,
                'date_due'          => $date_due,
                'user_id'           => $user
				
	)));
// $invoice =193;

// line transaksi silakan di looping
$product_id         = 49; #id product
$name               = 'Alat kesehatan'; #nama product dari master product
$account_id         = 17; #COA expenses
$quantity           = 1;
$price_unit         = 100000; #silakan ambil sell price dari master product
$discount           = 0;

// $id_tax             = 0; #dari master tax

$line = $models->execute_kw($db, $uid, $password,
    'account.invoice.line', 'create',
    array(array('invoice_id'    => $invoice,
                'product_id'    => $product_id,
                'name'          => $name,
                'account_id'    => $account_id,
                'quantity'      => $quantity,
                'price_unit'    => $price_unit,
                'discount'      => $discount
                // 'invoice_line_tax_ids'  =>array(array(6,0,array($id_tax)))
                
    )));

// akhir looping

echo json_encode($invoice)

?>