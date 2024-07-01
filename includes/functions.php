<?php

function renderInputError( string $key ) : void {
    global $errors;

    if ( !isset( $errors[ $key ] ) )
        return;

    echo "<ul>";
    foreach( $errors[$key] as $error_msg ) {
        echo "<li>$error_msg</li>";
    }
    echo "</ul>";
}

function createNonce() : string {
    $nonce = bin2hex( random_bytes( 16 ) );
    $_SESSION['nonce'] = $nonce;
    return $nonce;
}

function getNonce() : string {

    return $_SESSION['nonce'] ?? '';
}