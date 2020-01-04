<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");


$data = $models->execute_kw($db, $uid, $password,
    'product.product', 'search_read',
    array(array(array('active', '=', true),
                array('product_tmpl_id.purchase_ok', '=', true)
            )),
    array('fields'=>array('id','product_tmpl_id','name', 'sale_ok', 'active','list_price','standard_price','uom_id','taxes_id','property_account_income_id','property_account_expense_id')));

// echo $data[0];
echo json_encode($data);


?>