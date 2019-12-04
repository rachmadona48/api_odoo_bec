<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");


$data = $models->execute_kw($db, $uid, $password,
    'account.account', 'search_read',
    array(array(array('deprecated', '=', false)
            )),
    array('fields'=>array('id','code','name','user_type_id','id_simrs')));

// print_r($data);
echo json_encode($data)

?>