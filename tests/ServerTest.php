<?php

use PHPUnit\Framework\TestCase;
use Server\Server;

class ServerTest extends TestCase
{
    /**
     * Test encrypt method with plaintext and substitution alphabet.
     */
    public function testEncrypt()
    {
        // Sample plaintext and substitution alphabet
        $plaintext = "hello world";
        $substitutionAlphabet = "zyxwvutsrqponmlkjihgfedcba"; // Reversed alphabet
        
        // Expected ciphertext
        $expectedCiphertext = "svool dliow";
        
        // Call encrypt method
        $ciphertext = $this->callEncrypt($plaintext, $substitutionAlphabet);
        
        // Assert the expected ciphertext matches the real ciphertext
        $this->assertEquals($expectedCiphertext, $ciphertext);
    }

    /**
     * Test encrypt method with plaintext containing specal characters.
     */
    public function testEncryptWithPunctuation()
    {
        // Sample plaintext and substitution alphabet
        $plaintext = "Hello, World!";
        $substitutionAlphabet = "zyxwvutsrqponmlkjihgfedcba";
        
        // Expected ciphertext to ensure punctuation is replaced with spaces
        $expectedCiphertext = "svool  dliow ";
        
        // Call encrypt method
        $ciphertext = $this->callEncrypt($plaintext, $substitutionAlphabet);
        
        // Assert expected ciphertext matches real ciphertext
        $this->assertEquals($expectedCiphertext, $ciphertext);
    }

    /**
     * Test encrypt method with empty plaintext.
     */
    public function testEncryptWithEmptyPlaintext()
    {
        // Sample plaintext and substitution alphabet
        $plaintext = "";
        $substitutionAlphabet = "zyxwvutsrqponmlkjihgfedcba";
        
        // Expected ciphertext
        $expectedCiphertext = "";
        
        // Call encrypt method
        $ciphertext = $this->callEncrypt($plaintext, $substitutionAlphabet);
        
        // Assert expected ciphertext matches real ciphertext
        $this->assertEquals($expectedCiphertext, $ciphertext);
    }

    /**
     * Test Helper method to call the private encrypt method.
     */
    private function callEncrypt($plaintext, $substitutionAlphabet)
    {
        $reflectionMethod = new \ReflectionMethod(Server::class, 'encrypt');
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod->invoke(null, $plaintext, $substitutionAlphabet);
    }
}
