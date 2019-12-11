<?php

require_once('konek.php');

require_once('ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();

$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");
$user               = $uid;

$id_invoice_odoo       = 33; /*id invoice yang sudah validate*/
$data_invoice = $models->execute_kw($db, $uid, $password,
    'account.invoice', 'search_read',
    array(array(array('id', '=', $id_invoice_odoo)
            )),
    array('fields'=>array('id','number')));

$invoice = json_decode(json_encode($data_invoice));


$ref        = $invoice[0]->number; /*no invoice yang ada pada odoo*/
$journal_id = 24; /*id stock jurnal odoo di prod 24*/
// silakan sesuaikan
$date       = '2019-11-16';


$move = $models->execute_kw($db, $uid, $password,
    'account.move', 'create',
    array(array('ref'           => $ref,
                'journal_id'    => $journal_id,
                'date'          => $date
				
	)));


/*debit*/
$l1 = $models->execute_kw($db, $uid, $password,
    'account.move.line', 'create',
    array(array('move_id'    => $move,
                'account_id' => 6,
                'debit'      => 100000
                
    )),
    array('context' => array('check_move_validity' =>  False))
    );

/*credit*/
$l2 = $models->execute_kw($db, $uid, $password,
    'account.move.line', 'create',
    array(array('move_id'    => $move,
                'account_id' => 4,
                'credit'     => 100000
                
    )),
    array('context' => array('check_move_validity' =>  False))
    );

/*proses validasi journal entries*/
$validate_move = $models->execute_kw($db, $uid, $password,'account.move', 'action_post', [$move]);
$data_validate = $models->execute_kw($db, $uid, $password,
    'account.move', 'search_read',
    array(array(array('id', '=', $move)
            )),
    array('fields'=>array('id','number','state')));

echo json_encode($data_validate);
/*jika state = post maka update id move(jurnal inventory) ke invoice*/ 

$update_inventory_hpp = $models->execute_kw($db, $uid, $password, 'account.invoice', 'write',
    array(array($id_invoice_odoo), array('account_hpp_id'=>intval($move))));

$data_invoice_cek_hpp_id = $models->execute_kw($db, $uid, $password,
    'account.invoice', 'search_read',
    array(array(array('id', '=', $id_invoice_odoo)
            )),
    array('fields'=>array('id','number','account_hpp_id')));
echo json_encode($data_invoice_cek_hpp_id);
/*jika account_hpp_id sudah ada maka jurnal inventory dan invoice sudah terbentuk relationnya*/ 


?>