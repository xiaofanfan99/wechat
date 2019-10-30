<?php
namespace App\Tools;
class Aes{//对称加密
    //偏移量
    private $hex_iv = ''; # converted JAVA byte code in to HEX and placed it here

    private $key; #Same as in JAVA

    public function __construct($key,$hex_iv="") {
        $this->key = $key;//秘钥
        $this->hex_iv = $hex_iv;//偏移量
        //$this->key = hash('sha256', $this->key, true);
    }

    /*
    function encrypt($str) {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->key, $this->hexToStr($this->hex_iv));
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $pad = $block - (strlen($str) % $block);
        $str .= str_repeat(chr($pad), $pad);
        $encrypted = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($encrypted);
    }
    function decrypt($code) {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->key, $this->hexToStr($this->hex_iv));
        $str = mdecrypt_generic($td, base64_decode($code));
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $this->strippadding($str);
    }*/
    //加密
    public function encrypt($input,$method="AES-128-ECB")
    {
        $data = openssl_encrypt($input, $method, $this->key, OPENSSL_RAW_DATA, $this->hexToStr($this->hex_iv));
        //$data = base64_encode($data);
        $data = bin2hex($data);  //普通编码转成16进制
        return $data;
    }
    //解密
    public function decrypt($input,$method="AES-128-ECB")
    {
//        $input = base64_decode($input);
        $input = hex2bin($input);  //16进制转为普通编码
        $decrypted = openssl_decrypt($input, $method, $this->key, OPENSSL_RAW_DATA, $this->hexToStr($this->hex_iv));
        return $decrypted;
    }

    /*
      For PKCS7 padding
     */
    private function addpadding($string, $blocksize = 16) {

        $len = strlen($string);

        $pad = $blocksize - ($len % $blocksize);

        $string .= str_repeat(chr($pad), $pad);

        return $string;

    }

    private function strippadding($string) {

        $slast = ord(substr($string, -1));

        $slastc = chr($slast);

        $pcheck = substr($string, -$slast);

        if (preg_match("/$slastc{" . $slast . "}/", $string)) {

            $string = substr($string, 0, strlen($string) - $slast);

            return $string;

        } else {
            return false;
        }
    }

    function hexToStr($hex)
    {
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2)
        {
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }

}

//$key="0987654321987654";//秘钥
////$hex_iv="12345678901234567890123456789012";//偏移量
//$obj = new Aes($key);
////明文
//$data = "加油，你是最棒的！";
//$method="AES-128-CBC";
//echo $eStr = $obj->encrypt($data,$method);  //加密后的密文
//echo "<hr>";
//echo $obj->decrypt($eStr,$method);//解密后的明文
//57902A2EF7897E101E5F7CBCEF98BAC9
//
// str:aabbcc
// key:1234567890123456
// result:
// 8263AB6D6DB5BE41C098B27CBB1D6A39
// 8263AB6D6DB5BE41C098B27CBB1D6A39
