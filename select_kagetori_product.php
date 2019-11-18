<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());

$models = ripcord::client("$url/xmlrpc/2/object");
// $data = $models->execute_kw($db, $uid, $password,'product.category', 'search',
//     array('fields'=>array('name', 'parent_id')));

$data = $models->execute_kw($db, $uid, $password,
    'product.category', 'search_read',
    array(),
    array('fields'=>array('id','name', 'complete_name','property_account_income_categ_id','property_account_expense_categ_id')));

// print_r($data);
echo json_encode($data)

?>