<?php
/**
 * User: zht
 * Date: 2017/12/26
 * Time: 13:46
 **/

/**
 * Created by PhpStorm.
 * ip地址转换成32位无符号整数形式
 * @param string $ip
 * @return array
 */

/**
 *
 * sprintf() 字符串格式化命令
 * sprintf(format,arg1,arg2,arg++)
 * format	必需。转换格式。
 * arg1	必需。规定插到 format 字符串中第一个 % 符号处的参数。
arg2	可选。规定插到 format 字符串中第二个 % 符号处的参数。
arg++	可选。规定插到 format 字符串中第三、四等等 % 符号处的参数。
 *
 *  %% - 返回百分比符号
%b - 二进制数
%c - 依照 ASCII 值的字符
%d - 带符号十进制数
%e - 可续计数法（比如 1.5e+3）
%u - 无符号十进制数
%f - 浮点数(local settings aware)
%F - 浮点数(not local settings aware)
%o - 八进制数
%s - 字符串
%x - 十六进制数（小写字母）
%X - 十六进制数（大写字母）
 */

function ipToArray(string $ip):array {
    return array_map(function($value){
        return sprintf("%08b",intval($value));
    },explode('.',$ip));
}

var_dump(implode(ipToArray('255.0.0.1'),''));



