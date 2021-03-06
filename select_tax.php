<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");


$data = $models->execute_kw($db, $uid, $password,
    'account.tax', 'search_read',
    array(array(array('id', '=', 3)
            )),
    array('fields'=>array('id','name','price_include', 'amount')));

// print_r($data);
echo json_encode($data)

?>