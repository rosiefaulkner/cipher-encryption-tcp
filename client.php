<?php

function readDocument($filename) {
    return file_get_contents($filename);
}

function connectToServer($host, $port) {
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        die("socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
    }

    $result = socket_connect($socket, $host, $port);
    if ($result === false) {
        die("socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n");
    }

    return $socket;
}

function sendToServer($socket, $data) {
    socket_write($socket, $data, strlen($data));
}

function receiveFromServer($socket) {
    $response = '';
    while ($out = socket_read($socket, 2048)) {
        $response .= $out;
    }
    return $response;
}

function main() {
    $host = '127.0.0.1';
    $port = 9090;

    // Read the document and substitution alphabet
    $plaintext = readDocument('test.txt');
    $substitutionAlphabet = 'zyxwvutsrqponmlkjihgfedcba';

    // Connect to the server
    $socket = connectToServer($host, $port);

    // Send the plaintext and substitution alphabet to the server
    $data = json_encode(['plaintext' => $plaintext, 'substitution' => $substitutionAlphabet]);
    sendToServer($socket, $data);

    // Receive the ciphertext from the server
    $ciphertext = receiveFromServer($socket);
    echo "Ciphertext: " . $ciphertext . "\n";

    socket_close($socket);
}

main();
