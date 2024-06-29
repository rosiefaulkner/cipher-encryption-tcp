# cypher-encryption-tcp
Client/server cypher encryption application using socket programming with TCP via command-line

## Dependencies

1. Composer 2.7.6
2. PHP 8.3

## To Run
1. Open a terminal and navigate to the root directory which contains a src/ directory that contains `Client.php` and `Server.php` class files.
2. Run composer install to install dependencies
3. Open a second terminal and navigate to the root directory which contains a `src/` directory that contains `Client.php` and `Server.php` class files.
4. In the first terminal, run the following command to start the socket server: `php src/Server.php`
5. In the second terminal, run the application with the filename and substitution alphabet as arguments. Run the following command: `php src/Client.php us-constitution.txt nmbvcxzasdfghjklpoiuytrewq`
6. You may also use the other test file in the root directory: `php src/Client.php test.txt nmbvcxzasdfghjklpoiuytrewq`
7. You will see in the command line interface that the command returns the encrypted text from within the file `us-constitution.txt` or the file `test.txt`. 

### Note
All punctuations are replaced with spaces. Spaces are kept as spaces. Differences between uppercase and lowercase letters are ignored.

<img width="792" alt="Screenshot 2024-06-28 at 23 17 35" src="https://github.com/rosiefaulkner/cypher-encryption-tcp/assets/54520871/a8c8c9f0-c56f-4bcf-8720-604443a81a97">


