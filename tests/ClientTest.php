<?php

use PHPUnit\Framework\TestCase;
use Client\Client;

class ClientTest extends TestCase
{
    /**
     * Test readDocument method with sample file.
     */
    public function testReadDocument()
    {
        // Create test file for testing
        $filename = 'testfile.txt';
        $content = 'This is a test document.';
        file_put_contents($filename, $content);

        // Call readDocument method
        $result = $this->callReadDocument($filename);

        // Assert content matches the real result
        $this->assertEquals($content, $result);

        // Clean up test file
        unlink($filename);
    }

    /**
     * Test connectToServer method.
     */
    public function testConnectToServer()
    {
        // Mock socket_create and socket_connect functions
        $socket = $this->createMock(\Socket::class);
        $socket->expects($this->once())->method('socket_create')->willReturn($socket);
        $socket->expects($this->once())->method('socket_connect')->willReturn(true);

        // Call connectToServer method
        $result = $this->callConnectToServer();

        // Assert result is true
        $this->assertNotFalse($result);
    }

    /**
     * Test sendToServer method by mocking socket.
     */
    public function testSendToServer()
    {
        $socket = $this->createMock(\Socket::class);
        $socket->expects($this->once())->method('socket_write')->with($this->anything(), $this->anything())->willReturn(true);

        $this->callSendToServer($socket, 'test data');
    }

    /**
     * Test the receiveFromServer method by mocking socket.
     */
    public function testReceiveFromServer()
    {
        $socket = $this->createMock(\Socket::class);
        $socket->expects($this->once())->method('socket_read')->willReturn('test response');
        $result = $this->callReceiveFromServer($socket);
        $this->assertEquals('test response', $result);
    }

    /**
     * Helper method to call private readDocument method.
     */
    private function callReadDocument($filename)
    {
        $reflectionMethod = new \ReflectionMethod(Client::class, 'readDocument');
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod->invoke(null, $filename);
    }

   /**
     * Helper method to call private connectToServer method.
     */
    private function callConnectToServer()
    {
        $reflectionMethod = new \ReflectionMethod(Client::class, 'connectToServer');
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod->invoke(null);
    }

    /**
     * Helper method to call private sendToServer method.
     */
    private function callSendToServer($socket, $data)
    {
        $reflectionMethod = new \ReflectionMethod(Client::class, 'sendToServer');
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod->invoke(null, $socket, $data);
    }

    /**
     * Helper method to call private receiveFromServer method.
     */
    private function callReceiveFromServer($socket)
    {
        $reflectionMethod = new \ReflectionMethod(Client::class, 'receiveFromServer');
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod->invoke(null, $socket);
    }
}