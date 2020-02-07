<?php
 
/**
 * PHP encrypt and decrypt example
 *
 * Simple method to encrypt or decrypt a plain text string initialization
 * vector(IV) has to be the same when encrypting and decrypting in PHP 5.4.9.
 *
 * @link http://naveensnayak.wordpress.com/2013/03/12/simple-php-encrypt-and-decrypt/
 *
 * @param string $action Acceptable values are `encrypt` or `decrypt`.
 * @param string $string The string value to encrypt or decrypt.
 * @return string
 */
function encrypt_decrypt($action, $string)
{
  $output = false;
 
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'This is my secret key';
  $secret_iv = 'This is my secret iv';
 
  // hash
  $key = hash('sha256', $secret_key);
 
  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a
  // warning
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
  if ($action == 'encrypt')
  {
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
  }
  else
  {
    if ($action == 'decrypt')
    {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
  }
 
  return $output;
}
 
 
//
// usage
//
 
$plain_txt = "HelloWorld!";
echo "Plain Text = $plain_txt\n";
 
$encrypted_txt = encrypt_decrypt('encrypt', $plain_txt);
echo "Encrypted Text = $encrypted_txt\n";
 
$decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
echo "Decrypted Text = $decrypted_txt\n";
 
if ($plain_txt === $decrypted_txt)
  echo "SUCCESS";
else
  echo "FAILED";
 
echo "\n";
 
?>
