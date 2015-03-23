<?php

require_once( 'config.php' );
require_once( 'db.php' );

$db = new BusterDb( DB_ADDRESS, DB_NAME, DB_USER, DB_PASSWORD );

function addLink( $db, $name, $url ) {
    $result = $db->fetch( 'SELECT * FROM links WHERE name = ? AND url = ?',
                          array( $name, $url ) );

    if ( count( $result ) == 0 ) {
        $db->execute( 'INSERT INTO links (name, url) VALUES ( ?, ? )',
                      array( $name, $url ) );
        echo( 'Added: ' . $name . "\n" );
    } else {
        echo( 'Duplicate: ' . $name . "\n" );
    }
}

function getUrl( $url ) {
    $curl = curl_init();

    curl_setopt( $curl, CURLOPT_HEADER, 0 );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $curl, CURLOPT_URL, $url );
    curl_setopt( $curl, CURLOPT_USERAGENT,
                 'Buster/1.0.0 (by /u/scotchfield)' );

    $data = curl_exec( $curl );

    curl_close( $curl );

    return $data;
}

function getDataReddit( $db ) {
    $url = 'http://api.reddit.com/hot.json';
    $data = getUrl( $url );
    $result = json_decode( $data, $assoc = true );

    if (! isset( $result[ 'data' ][ 'children' ] ) ) {
        echo( 'Warning: Malformed data in ' . __FUNCTION__ );
        return;
    }

    foreach ( $result[ 'data' ][ 'children' ] as $v ) {
        addLink( $db, $v[ 'data' ][ 'title' ], $v[ 'data' ][ 'url' ] );
    }
};

getDataReddit( $db );
