<?php

namespace Server;

class Server
{
    const HOST = '127.0.0.1';
    const PORT = 2525;

    private static function encrypt(string $plaintext, string $substitutionAlphabet): string
    {
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

    public static function startServer(): void
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            die("socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
        }

        if (socket_bind($socket, self::HOST, self::PORT) === false) {
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

            $input = '';
            while ($out = socket_read($client, 2048)) {
                $input .= $out;
                if (strlen($out) < 2048) {
                    break;
                }
            }

            $data = json_decode($input, true);
            $plaintext = $data['plaintext'];
            $substitutionAlphabet = $data['substitution'];

            $ciphertext = self::encrypt($plaintext, $substitutionAlphabet);

            socket_write($client, $ciphertext, strlen($ciphertext));
            socket_close($client);
        } while (true);
        socket_close($socket);
    }
}

Server::startServer();
