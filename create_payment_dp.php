<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$payment_type       = 'inbound'; //repayment_ar
$partner_type       = 'customer';
$payment_method_id  = 1;


// silakan sesuaikan
$id_simrs           = 10; /*id dari simrs untuk disimpan pada odoo*/
$id_customer 		= 104; /*id penjamin*/
$patient_id        = 90; /*id pasien*/
$amount 			= 600000;
$id_journal_payment = 10;
$payment_date 		= '29/11/2019';
$memo				= 'pelunasan invoice';
// silakan sesuaikan

$data = $models->execute_kw($db, $uid, $password,
    'account.payment', 'create',
    array(array('id_simrs'      => $id_simrs,
                'payment_type'	=> $payment_type,
    			'partner_type'	=> $partner_type,
    			'partner_id'	=> $id_customer,
                'patient_id'    => $patient_id,
    			'amount'		=> $amount,
    			'journal_id'	=> $id_journal_payment,
    			'payment_date'	=> $payment_date,
    			'communication' => $memo,
    			'payment_method_id' => $payment_method_id
				
	)));

// print_r($data);
echo json_encode($data)

?>