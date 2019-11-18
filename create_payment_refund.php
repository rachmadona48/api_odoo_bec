<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$payment_type       = 'outbound';
$partner_type       = 'customer';
$payment_method_id  = 2;

// silakan sesuaikan
$id_customer 		= 651;
$amount 			= 1090909.09;
$id_journal_payment = 10;
$payment_date 		= '30/11/2019';
$memo				= 'Refund sisa';

$data = $models->execute_kw($db, $uid, $password,
    'account.payment', 'create',
    array(array('payment_type'	=> $payment_type,
    			'partner_type'	=> $partner_type,
    			'partner_id'	=> $id_customer,
    			'amount'		=> $amount,
    			'journal_id'	=> $id_journal_payment,
    			'payment_date'	=> $payment_date,
    			'communication' => $memo,
    			'payment_method_id' => $payment_method_id
				
	)));

// print_r($data);
echo json_encode($data)

?>