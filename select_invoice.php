<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

#parameter id invoice odoo
// $id_invoice = 22;
// $data = $models->execute_kw($db, $uid, $password,
//     'account.invoice', 'search_read',
//     array(array(array('id', '=', $id_invoice)
//             )),
//     array('fields'=>array('id','number','partner_id','patient_id','state')));

#parameter no invoice odoo
$invoice_number = 'INV/2019/0021';
$data = $models->execute_kw($db, $uid, $password,
    'account.invoice', 'search_read',
    array(array(array('number', '=', $invoice_number)
            )),
    array('fields'=>array('id','number','partner_id','patient_id','state','account_hpp_id')));

echo json_encode($data)

?>