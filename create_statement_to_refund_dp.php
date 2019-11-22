<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");

$user               = $uid;

// silakan sesuaikan
$journal_id         = 19;


$statement_id = $models->execute_kw($db, $uid, $password,
    'account.bank.statement', 'create',
    array(array(
    			'journal_id'	    => $journal_id
	)));
// $statement_id =343;

// line transaksi silakan di looping
$date           = '2019-11-30';
$name           = 'pengembalian dp';
$partner_id     = 651;
$amount         = -250000;

$line = $models->execute_kw($db, $uid, $password,
    'account.bank.statement.line', 'create',
    array(array('statement_id'  => $statement_id,
                'date'          => $date,
                'name'          => $name,
                'partner_id'    => $partner_id,
                'amount'        => $amount
                
    )));

// akhir looping

echo json_encode($statement_id)

?>