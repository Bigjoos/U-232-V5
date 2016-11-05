<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                                            |
 |--------------------------------------------------------------------------|
 |   Licence Info: WTFPL                                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5                                            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
/**
 * Implements AES128 encryption/decryption.
 *
 * PBKDF2 is used for creation of encryption key.
 */
class McryptCipher
{
    const PBKDF2_HASH_ALGORITHM = 'SHA256';
    const PBKDF2_ITERATIONS = 64000;
    const PBKDF2_SALT_BYTE_SIZE = 24;
    // 24 is the maximum supported key size for the MCRYPT_RIJNDAEL_128
    const PBKDF2_HASH_BYTE_SIZE = 24;

    /**
     * @var string
     */
    private $password;

    function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
     *
     * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
     * This implementation of PBKDF2 was originally created by https://defuse.ca
     * With improvements by http://www.variations-of-shadow.com
     *
     * @param string $algorithm The hash algorithm to use. Recommended: SHA256
     * @param string $password The password
     * @param string $salt A salt that is unique to the password
     * @param int $count Iteration count. Higher is better, but slower. Recommended: At least 1000
     * @param int $key_length The length of the derived key in bytes
     * @param bool $raw_output If true, the key is returned in raw binary format. Hex encoded otherwise
     * @return string A $key_length-byte key derived from the password and salt
     *
     * @see https://defuse.ca/php-pbkdf2.htm
     */
    private function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
    {
        $algorithm = strtolower($algorithm);
        if (!in_array($algorithm, hash_algos(), true)) {
            trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
        }
        if ($count <= 0 || $key_length <= 0) {
            trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);
        }

        if (function_exists('hash_pbkdf2')) {
            // The output length is in NIBBLES (4-bits) if $raw_output is false!
            if (!$raw_output) {
                $key_length = $key_length * 2;
            }
            return hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
        }

        $hash_length = strlen(hash($algorithm, '', true));
        $block_count = ceil($key_length / $hash_length);

        $output = '';
        for ($i = 1; $i <= $block_count; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt . pack('N', $i);
            // first iteration
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $count; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }

        if ($raw_output) {
            return substr($output, 0, $key_length);
        } else {
            return bin2hex(substr($output, 0, $key_length));
        }
    }

    private function pbkfd2Hash($password, $salt) {
        return base64_encode(
            $this->pbkdf2(self::PBKDF2_HASH_ALGORITHM, $password, $salt, self::PBKDF2_ITERATIONS, self::PBKDF2_HASH_BYTE_SIZE, true)
        );
    }

    /**
     * Encrypt the input text
     *
     * @param string $input
     * @return string Format: pbkdf2Salt:iv:encryptedText
     */
    function encrypt($input)
    {
        // Create secure PBKDF2 derivative out of password.
        $pbkdf2Salt = base64_encode(
            mcrypt_create_iv(self::PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM)
        );
        $pbkdf2SecureKey = $this->pbkfd2Hash($this->password, $pbkdf2Salt);

        $mcryptIvSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

        // By default mcrypt_create_iv() function uses /dev/random as a source of random values.
        // If server has low entropy this source could be very slow.
        // That is why here /dev/urandom is used.
        $iv = mcrypt_create_iv($mcryptIvSize, MCRYPT_DEV_URANDOM);

        return implode(':', array(
            $pbkdf2Salt,
            base64_encode($iv),
            base64_encode(
                mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $pbkdf2SecureKey, $input, MCRYPT_MODE_CBC, $iv)
            )
        ));

    }

    /**
     * Decrypt the input text.
     *
     * @param string $input Format: pbkdf2Salt:iv:encryptedText
     * @return string
     */
    function decrypt($input)
    {
        list($pbkdf2Salt, $iv, $encryptedText) = explode(':', $input);

        $pbkdf2SecureKey = $this->pbkfd2Hash($this->password, $pbkdf2Salt);

        // mcrypt_decrypt() pads the *RETURN STRING* with nulls ('\0') to fill out to n * blocksize.
        // rtrim() is used to delete them.
        return rtrim(
            mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $pbkdf2SecureKey, base64_decode($encryptedText), MCRYPT_MODE_CBC, base64_decode($iv)),
            "\0"
        );
    }

}



$c = new McryptCipher($INSTALLER09['cipher_key']['key']);

function encrypt_ip($ip) {
 
         global $INSTALLER09, $c;
         $ip = $c -> encrypt($ip);
         return $ip;
}

function decrypt_ip($ip) {
 
         global $INSTALLER09, $c;
         $ip = $c -> decrypt($ip);
         return $ip;
         
}

function encrypt_email($email) {
 
         global $INSTALLER09, $c;
         $email = $c -> encrypt($email);
         return $email;
}

function decrypt_email($email) {
 
         global $INSTALLER09, $c;
         $email = $c -> decrypt($email);
         return $email;
         
}

?>
