<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$id_payment = 530; #id dari invoice yang akan di validate

$data = $models->execute_kw($db, $uid, $password,'account.payment', 'post', [$id_payment]);

$data_return = [];
if ($data == 1){
	$return  = 'Sukses';
	$data_return = $models->execute_kw($db, $uid, $password,
    'account.payment', 'search_read',
    array(array(array('id', '=', $id_payment)
            )),
    array('fields'=>array('id','name')));
}else{
	$return  = 'Gagal';
}

#jika return = Sukses maka baca number dari data_return

echo $return;
echo json_encode($data_return);

?>