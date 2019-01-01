<?php

namespace App;

/**
* Application common
*
* PHP version 5.6
*/
class Common
{
    /**
    * 打包返回信息
    * 正常status=1，异常status=0，错误status=-1
    *
    * @param string $msg 信息
    * @param string $data 数据
    * @param int    $status 状态
    *
    * @return string
    */
    public static function packData($msg, $data, $status) {
        $obj = new \stdClass();
        $obj->message = $msg;
        $obj->data = $data;
        $obj->status = $status;
        if (version_compare(PHP_VERSION, '5.4.0', '>')) {
            return json_encode($obj, JSON_UNESCAPED_UNICODE);
        }
        return json_encode($obj);
    }

    /**
    * 解密Android端信息
    *
    * @param string $str 密文
    * @param string $key 密钥
    *
    * @return string
    */
    public static function decrypt($str, $key) {
        
        $midstr = hex2bin(strtolower($str));

        //第二个参数$key就是三个重点中的$key，而最后一个参数$key是iv，只是java加密时采用了与第二个参数相同的字符串，根据具体情况来定
        $str = mcrypt_decrypt(MCRYPT_DES, $key, $midstr, MCRYPT_MODE_CBC, $key); 
        $pad = ord($str[($len = strlen($str)) - 1]); 

        return substr($str, 0, strlen($str) - $pad);
    }
}