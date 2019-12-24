<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$payment_type       = 'transfer';
$payment_method_id  = 2;


// silakan sesuaikan
$id_simrs           = 10; /*id dari simrs untuk disimpan pada odoo*/
$no_setoran_simrs 	= 'NO_STR_01'; /*id penjamin*/
$amount 			= 150000;
$id_journal_from    = 25; /*jurnal pengirim (bank/cash)*/
$id_journal_to      = 11; /*jurnal penerima (bank/cash)*/
$payment_date 		= '24/12/2019';
$memo				= 'Pindah buku 2';
// silakan sesuaikan

$data = $models->execute_kw($db, $uid, $password,
    'account.payment', 'create',
    array(array('id_simrs'                  => $id_simrs,
                'no_setoran_simrs'          => $no_setoran_simrs,
                'payment_type'	            => $payment_type,
    			'amount'		            => $amount,
    			'journal_id'	            => $id_journal_from,
                'destination_journal_id'    => $id_journal_to,
    			'payment_date'	            => $payment_date,
    			'communication'             => $memo,
    			'payment_method_id'         => $payment_method_id
				
	)));

$data_return = $models->execute_kw($db, $uid, $password,
    'account.payment', 'search_read',
    array(array(array('id', '=', intval($data))
            )),
    array('fields'=>array('id','no_setoran_simrs','amount','journal_id','destination_journal_id')));

// print_r($data);
echo json_encode($data_return)

?>