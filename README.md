# cypher-encryption-tcp
Client/server cypher encryption application using socket programming with TCP via command-line

## Dependencies

1. Composer 2.7.6
2. PHP 8.3
3. PHPUnit 10*

## To Run
1. Open a terminal and navigate to the root directory which contains a src/ directory that contains `Client.php` and `Server.php` class files.
2. Open a second terminal and navigate to the root directory which contains a `src/` directory that contains `Client.php` and `Server.php` class files.
3. Run `composer install` to create vendor directory and install dependencies
4. In the first terminal, run the following command to start the socket server: `php src/Server.php`
5. In the second terminal, run the application with the filename and substitution alphabet as arguments. Run the following command: `php src/Client.php us-constitution.txt nmbvcxzasdfghjklpoiuytrewq`
6. You may also use the other test file in the root directory: `php src/Client.php test.txt nmbvcxzasdfghjklpoiuytrewq`
7. You will see in the command line interface that the command returns the encrypted text from within the file `us-constitution.txt` or the file `test.txt`. 
8. Run unit tests for Client Class by running `vendor/bin/phpunit --bootstrap vendor/autoload.php tests/ClientTest.php`
9. Run unit tests for Server Class by running `vendor/bin/phpunit --bootstrap vendor/autoload.php tests/ServerTest.php`
10. Add different text to current test.txt file or add additional txt files. You may also specify a different substitution alphabet in the CLI. 

## Note
All punctuations are replaced with spaces. Spaces are kept as spaces. Differences between uppercase and lowercase letters are ignored.

## Results

Encrypted input is returned in CLI:

<img width="799" alt="Screenshot 2024-06-29 at 00 16 14" src="https://github.com/rosiefaulkner/cypher-encryption-tcp/assets/54520871/641cadf3-daea-4182-b9b3-f6cd27240e6b">

