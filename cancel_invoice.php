<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$id_invoice = 26; #id dari invoice yang akan di cancel

$data = $models->execute_kw($db, $uid, $password,'account.invoice', 'action_cancel', [$id_invoice]);


// $data_return = $models->execute_kw($db, $uid, $password,
//     'account.invoice', 'search_read',
//     array(array(array('id', '=', $id_invoice)
//             )),
//     array('fields'=>array('id','state')));
#jika return = Sukses maka baca number dari data_return

// echo $data;
echo json_encode($data); #jika state = open maka proses validate invoice berhasil

?>