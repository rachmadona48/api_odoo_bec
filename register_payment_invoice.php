<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$payment_method_id = 1; #jangan di ganti

$id_invoice = 23; #id dari invoice yang akan di validate
$partner_id = 105; #id penjamin / pasien yang melakukan pembayaran
$payment_date = '2019-11-26';
$amount = 1000000;
$journal_id = 19; #id jurnal (cash/bank)
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

#jika return = Sukses maka baca number dari data_return
$data_validate = $models->execute_kw($db, $uid, $password,'account.payment', 'action_validate_invoice_payment', [$payment_id]);

echo json_encode($payment_id); 
echo '<br/>';
echo json_encode($data_validate);

?>