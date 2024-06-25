<?php

function encrypt($plaintext, $substitutionAlphabet) {
    $plaintext = strtolower($plaintext);
    $plaintext = preg_replace('/[^\w\s]/', ' ', $plaintext);

    $alphabet = 'abcdefghijklmnopqrstuvwxyz';
    $ciphertext = '';

    for ($i = 0; $i < strlen($plaintext); $i++) {
        $char = $plaintext[$i];
        if ($char === ' ') {
            $ciphertext .= ' ';
        } else {
            $pos = strpos($alphabet, $char);
            if ($pos !== false) {
                $ciphertext .= $substitutionAlphabet[$pos];
            }
        }
    }

    return $ciphertext;
}

function startServer($host, $port) {
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        die("socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
    }

    if (socket_bind($socket, $host, $port) === false) {
        die("socket_bind() failed: reason: " . socket_strerror(socket_last_error($socket)) . "\n");
    }

    if (socket_listen($socket, 5) === false) {
        die("socket_listen() failed: reason: " . socket_strerror(socket_last_error($socket)) . "\n");
    }

    do {
        $client = socket_accept($socket);
        if ($client === false) {
            echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($socket)) . "\n";
            continue;
        }

        $input = socket_read($client, 2048);
        $data = json_decode($input, true);
        $plaintext = $data['plaintext'];
        $substitutionAlphabet = $data['substitution'];

        $ciphertext = encrypt($plaintext, $substitutionAlphabet);

        socket_write($client, $ciphertext, strlen($ciphertext));
        socket_close($client);
    } while (true);

    socket_close($socket);
}

$host = '127.0.0.1';
$port = 9090;

startServer($host, $port);
