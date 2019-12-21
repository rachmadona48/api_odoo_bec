<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$payment_method_id = 1; #jangan di ganti

$id_invoice = 24; #id dari invoice yang akan di validate
$partner_id = 9; #id penjamin / pasien yang melakukan pembayaran
$payment_date = '2019-11-26';
$amount = 1080000;        
$journal_id = 7; #id jurnal (cash/bank)
$communication = 'pembayaran invoice'; #keterangan pembayaran
$payment_id = $models->execute_kw($db, $uid, $password, 'account.payment', 'create',
 	array(array(
    'payment_date' => $payment_date,
    'has_invoices' => True,
    'invoice_ids' =>array(array(6,0,array($id_invoice))),
    'amount' => $amount,
    'communication' => $communication,
    'journal_id' => $journal_id,
    'partner_type' => 'customer',
    'partner_id' => $partner_id,
    'payment_type' => 'inbound',
    'payment_method_id' => $payment_method_id,

    
    )));


$data_validate = $models->execute_kw($db, $uid, $password,'account.payment', 'action_validate_invoice_payment', [$payment_id]);
$data_return = $models->execute_kw($db, $uid, $password,
    'account.payment', 'search_read',
    array(array(array('id', '=', $payment_id)
            )),
    array('fields'=>array('id','state')));

echo json_encode($data_return); 
echo '<br/>';
echo json_encode($data_validate);

?>