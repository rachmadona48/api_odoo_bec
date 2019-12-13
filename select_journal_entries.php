<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$id_journal = 41;

$move = $models->execute_kw($db, $uid, $password,
    'account.move', 'search_read',
    array(array(
    			array('id', '=', $id_journal)
            )),
    array('fields'=>array('id','name','date','ref','line_ids','reverse_entry_id')));

$move_line = $models->execute_kw($db, $uid, $password,
    'account.move.line', 'search_read',
    array(array(
    			array('move_id', '=', $id_journal)
            )),
    array('fields'=>array('id','account_id','partner_id','debit','credit')));

// print_r($data);
echo json_encode($move);
echo '<br/>';
echo json_encode($move_line);

?>