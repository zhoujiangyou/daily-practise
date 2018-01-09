<?php
/**
 * Created by PhpStorm.
 * User: zht
 * Date: 2018/1/8
 * Time: 13:39
 * 实现兼容Unicode文字的字符串大小写转换
 */


//自定义函数

/**
 * 单个字符转换成大写，兼容中文
 * @param string $str 单个字符，小写英文
 * @return string
 */
function myStrToLower(string $str){
        $val = ord($str);
        if($val>96 && $val <123){
            $val-=32;
            return chr($val);
        }else{
            return $str;
        }

}

/**
 * 大写转小写 兼容中文
 * @param string $str
 * @return string
 */
function myStrToUpper(string $str){
    $val = ord($str);
    if($val>64 && $val <91){
        $val+=32;
        return chr($val);
    }else{
        return $str;
    }
}
