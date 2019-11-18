<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$id_order = 350; #id dari sales order yang akan di create invoice

$invoice = $models->execute_kw($db, $uid, $password,'sale.order', 'action_invoice_create', [$id_order]);

echo json_encode($invoice);

?>