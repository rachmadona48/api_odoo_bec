<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$id_invoice = 233; 
$partner_id = 1738;

$payment_date = '2019-11-26';
$invoice_ids = 233; #id dari invoice yang akan di validate
$amount = 50000;
$journal_id = 19; #id jurnal
$communication = 'payment invoice';
$payment_id = $models.execute_kw($db, $uid, $password, 'account.payment', 'create',
 	array(array(
    'payment_date' => $payment_date,
    'has_invoices' => True,
    'invoice_ids' =>array(array(6,0,array($invoice_ids))),
    'amount' => $amount,
    'communication' => $communication,
    'journal_id' => $journal_id,
    'partner_type' => 'customer',
    'partner_id' => $partner_id,
    'payment_type' => 'inbound',

    
    )));

#jika return = Sukses maka baca number dari data_return
$data_validate = $models->execute_kw($db, $uid, $password,'account.payment', 'action_validate_invoice_payment', [$payment_id]);

echo json_encode($payment_id); 
echo '<br/>';
echo json_encode($data_validate);

?>