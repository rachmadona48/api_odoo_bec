<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$id_invoice = 131; #id invoice yang akan dicancel

$data = $models->execute_kw($db, $uid, $password,'account.invoice', 'action_cancel_via_service', [$id_invoice]);
// echo json_encode($data); 

$data_payment_invoice_active = $models->execute_kw($db, $uid, $password,
    'account.invoice', 'search_read',
    array(array('&',array('id', '=', $id_invoice),
    			array('active', '=',False),
            )),
    array('fields'=>array('id','state','active')));

$data_payment_invoice_non_active = $models->execute_kw($db, $uid, $password,
    'account.invoice', 'search_read',
    array(array('&',array('id', '=', $id_invoice),
    			array('active', '=',True),
            )),
    array('fields'=>array('id','state','active')));
$return  = array('data_payment_invoice_active' => $data_payment_invoice_active,'data_payment_invoice_non_active' => $data_payment_invoice_non_active );

echo json_encode($return);
?>