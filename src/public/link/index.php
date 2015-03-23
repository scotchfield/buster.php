<?php

require_once( '../../config.php' );
require_once( '../../db.php' );

$count = isset( $_GET[ 'n' ] ) ? intval( $_GET[ 'n' ] ) : 1;
$count = $count <= 0 ? 1 : $count;
$count = $count > 10 ? 10 : $count;

$db = new BusterDb( DB_ADDRESS, DB_NAME, DB_USER, DB_PASSWORD );

// http://jan.kneschke.de/projects/mysql/order-by-rand/
$result = $db->fetch( 'SELECT *, t1.id AS oid FROM links AS t1 JOIN ' .
        '(SELECT (RAND() * (SELECT MAX(id) FROM links)) AS id) AS t2 ' .
        'WHERE t1.id >= t2.id ORDER BY t1.id ASC LIMIT ' . $count . ';' );

echo '[{"_id":"' . $result[ 'oid' ] . '","name":"' . $result[ 'name' ] .
     '","url":"' . $result[ 'url' ] . '","date":"' . $result[ 'date' ] . '"}]';
