<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$type       = 'out_invoice'; //in_invoice
$user               = $uid;

// silakan sesuaikan
$id_simrs           = '10'; /*id dari simrs untuk disimpan pada odoo*/
$kd_t_simrs         = 'T1'; /*kode T dari simrs untuk disimpan pada odoo*/
$no_inv_simrs       = 'INV/SIMRS/1'; /*no invoice dari simrs untuk disimpan pada odoo*/
$no_tagihan_simrs   = 'Tag/1'; /*no tagihan dari simrs untuk disimpan pada odoo*/

$id_customer 		= 96;
$patient_id         = 96;
$payment_term_id    = 1;
$date_invoice       = '2020-01-23';
$date_due           = '2020-01-23';


$invoice = $models->execute_kw($db, $uid, $password,
    'account.invoice', 'create',
    array(array('id_simrs'          => $id_simrs,
                'kd_t_simrs'        => $kd_t_simrs,
                'no_inv_simrs'      => $no_inv_simrs,
                'no_tagihan_simrs'  => $no_tagihan_simrs,
                'type'              => $type,
    			'partner_id'	    => $id_customer,
                'patient_id'        => $patient_id,
                'payment_term_id'   => $payment_term_id,
                'date_invoice'      => $date_invoice,
                'date_due'          => $date_due,
                'user_id'           => $user
				
	)));
// $invoice =193;

// line transaksi silakan di looping
$product_id         = 25; #id product
$name               = 'PENDAPATAN TINDAKAN R. ANYELIR'; #nama product dari master product
$account_id         = 17; #COA income
$quantity           = 1;
$price_unit         = 850000.11; #silakan ambil sell price dari master product
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