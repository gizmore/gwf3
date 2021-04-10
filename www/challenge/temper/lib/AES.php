<?php
/**
 * Helper for AES-256 encryption.
 * @author gizmore
 * @version 6.10.1
 * @since 3.0.1
 */
final class AES
{
    const IV = 'MyHomeIsMyCastleIamhungrywhereisi'; # <-- 32 chars
    const CIPHER = 'aes-256-cbc';
    
    /**
     * Encrypt with AES256 using the default IV.
     * @param string $data
     * @param string $key
     */
    public static function encrypt($data, $key)
    {
        return self::encrypt4($data, $key, self::IV);
    }
    
    /**
     * Encrypt with AES256. Use sha256($iv) as IV. It is recommended to call this with a funny IV over the above.
     * @param string $data
     * @param string $key
     * @param string $iv
     * @return string data
     */
    public static function encrypt4($data, $key, $iv)
    {
        $iv_size = openssl_cipher_iv_length(self::CIPHER);
        $iv = substr($iv, 0, $iv_size);
        return openssl_encrypt($data, self::CIPHER, $key, null, $iv);
    }
    
    /**
     * Encrypt with AES256. Use sha256($password) as key. Use a random IV and prepend to the output.
     * This is probably the function you are looking for.
     * @param string $data
     * @param string $password
     * @return string data
     */
    public static function encryptIV($data, $password)
    {
        $iv_size = openssl_cipher_iv_length(self::CIPHER);
        $iv = openssl_random_pseudo_bytes($iv_size);
        $key = hash('SHA256', $password, true);
        $encrypted = base64_encode($iv).openssl_encrypt($data, self::CIPHER, $key, null, $iv);
        return $encrypted;
    }
    
    /**
     * Decrypt data encrypted with with the encryptIV function above.
     * @param string $data
     * @param string $password
     * @return string plaintext
     */
    public static function decryptIV($data, $password)
    {
        $iv_size = openssl_cipher_iv_length(self::CIPHER);
        $iv64 = ((4 * $iv_size / 3) + 3) & ~3;
        $key = hash('SHA256', $password, true);
        $iv = substr($data, 0, $iv64);
        $iv = base64_decode($iv);
        $data = substr($data, $iv64);
        return openssl_decrypt($data, self::CIPHER, $key, null, $iv);
    }
    
    /**
     * Decrypt with AES256 using the default IV.
     * @param string $data
     * @param string $key
     */
    public static function decrypt($data, $key)
    {
        return self::decrypt4($data, $key, self::IV);
    }
    
    /**
     * Decrypt with AES256. Use sha256($iv) as IV.
     * @param string $data
     * @param string $key
     * @param string $iv
     * @return string data
     */
    public static function decrypt4($data, $key, $iv)
    {
        $iv_size = openssl_cipher_iv_length(self::CIPHER);
        $iv = substr($iv, 0, $iv_size);
        return openssl_decrypt($data, self::CIPHER, $key, null, $iv);
    }
    
}

