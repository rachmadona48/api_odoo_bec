<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$id_payment = 82; #id payment dp
$id_invoice = 115; #id invoice yang akan dibayarkan dengan dp

$account_move_line = $models->execute_kw($db, $uid, $password,
    'account.move.line', 'search_read',
    array(array(array('payment_id', '=', $id_payment),
                array('debit', '=', 0)
            )),
    array('fields'=>array('id','name','partner_id')));

$move_line = json_decode(json_encode($account_move_line));
$id_move_line = $move_line[0]->id;

$data = $models->execute_kw($db, $uid, $password,'account.invoice', 'assign_outstanding_credit', [$id_invoice,$id_move_line ]);
// echo json_encode($data); 

$data_payment_invoice = $models->execute_kw($db, $uid, $password,
    'account.invoice', 'search_read',
    array(array(array('id', '=', $id_invoice)
            )),
    array('fields'=>array('id','payment_ids')));

echo json_encode($data_payment_invoice);
?>