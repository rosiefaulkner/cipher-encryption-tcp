<?php

namespace Client;

class Client {

    const HOST = '127.0.0.1';
    const PORT = 2525;
    protected ?string $filename;
    protected ?string $ciphertext;

    public function __construct(?string $filename = 'test.txt', ?string $ciphertext = '') {
        $this->filename = $filename;
        $this->ciphertext = $ciphertext;
    }

    private static function readDocument(string $filename): string
    {
        return file_get_contents($filename);
    }

    private static function connectToServer(): \Socket|false
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            die("socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
        }
    
        $result = socket_connect($socket, self::HOST, self::PORT);
        if ($result === false) {
            die("socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n");
        }
    
        return $socket;
    }

    private static function sendToServer($socket, $data) {
        socket_write($socket, $data, strlen($data));
    }

    private static function receiveFromServer($socket) {
        $response = '';
        while ($out = socket_read($socket, 2048)) {
            $response .= $out;
            if (strlen($out) < 2048) {
                break;
            }
        }
        return $response;
    }

    public static function main(string $filename, string $ciphertext): void
    {
        // Read the document and substitution alphabet
        $plaintext = self::readDocument($filename);
        //$substitutionAlphabet = 'zyxwvutsrqponmlkjihgfedcba';
    
        // Connect to the server
        $socket = self::connectToServer(self::HOST, self::PORT);
    
        // Send the plaintext and substitution alphabet to the server
        $data = json_encode(['plaintext' => $plaintext, 'substitution' => $ciphertext]);
        self::sendToServer($socket, $data);
    
        // Receive the ciphertext from the server
        $encryptedText = self::receiveFromServer($socket);
        echo "Ciphertext: " . $encryptedText . "\n";
    
        socket_close($socket);
    }

}

Client::main('test.txt', 'nmbvcxzasdfghjklpoiuytrewq');
