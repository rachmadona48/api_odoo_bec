<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$id_order = 350; #id dari sales order yang akan di confirm

$data = $models->execute_kw($db, $uid, $password,'sale.order', 'action_confirm', [$id_order]);

$data_return = [];
if ($data == 1){
	$return  = 'Sukses';
	$data_return = $models->execute_kw($db, $uid, $password,
    'sale.order', 'search_read',
    array(array(array('id', '=', $id_order)
            )),
    array('fields'=>array('id','name')));
}else{
	$return  = 'Gagal';
}

#jika return = Sukses maka baca dari data_return

echo $return;
echo json_encode($data_return);

?>