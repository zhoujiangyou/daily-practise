<?php
/**
 * Created by PhpStorm.
 * KMP 字符串查找算法
 * User: Administrator
 * Date: 2017/12/26
 * Time: 16:37
 * @param string $str
 * @param array $arr
 */


/**
 * "部分匹配值"就是"前缀"和"后缀"的最长的共有元素的长度。以"ABCDABD"为例，
 * －"A"的前缀和后缀都为空集，共有元素的长度为0；
 * －"AB"的前缀为[A]，后缀为[B]，共有元素的长度为0；
 * －"ABC"的前缀为[A, AB]，后缀为[BC, C]，共有元素的长度0；
 * －"ABCD"的前缀为[A, AB, ABC]，后缀为[BCD, CD, D]，共有元素的长度为0；
 * －"ABCDA"的前缀为[A, AB, ABC, ABCD]，后缀为[BCDA, CDA, DA, A]，共有元素为"A"，长度为1；
 * －"ABCDAB"的前缀为[A, AB, ABC, ABCD,ABCDA]，后缀为[BCDAB, CDAB, DAB, AB, B]，共有元素为"AB"，长度为2；
 * －"ABCDABD"的前缀为[A, AB, ABC, ABCD, ABCDA, ABCDAB]，后缀为[BCDABD,CDABD, DABD, ABD, BD, D]，共有元素的长度为0。
 * @param string $Pstring
 * @return mixed
 * @internal param array $next
 */
function makeNext(string $Pstring){

    $m = strlen($Pstring);
    $next[0] = 0;
    for ($q = 1, $k = 0; $q < $m; ++$q)
    {
        while($k > 0 && $Pstring[$q] != $Pstring[$k]){
            $k = $next[$k-1];
        }
        if ($Pstring[$q] == $Pstring[$k])
        {
            $k++;
        }
        $next[$q] = $k;
    }
//    for ($i = 0; $i < strlen($Pstring); ++$i) {
//        printf("%d ", $next[$i]);
//    }
    return $next;
}

////生成位移表
//makeNext('abcdabd');

/**
 * @param $Tstring
 * @param $Pstring
 */
function kmp($Tstring, $Pstring){

    $n = strlen($Tstring); // 字符串
    $m = strlen($Pstring);
    $next= makeNext($Pstring); // 计算模式匹配表


    for ($i=0,$q = 0; $i < $n; ++$i)
    {
        while($q > 0 && $Pstring[$q] != $Tstring[$i]){
            $q = $next[$q-1];
        }
        if ($Pstring[$q] == $Tstring[$i])
        {
            $q++;
        }
        if ($q == $m)
        {
            printf("Pattern occurs with shift:%d ",($i - $m + 1));
            printf(" You find string is:%s\n", $Pstring);
        }
    }
}

kmp('qweqweasdabcdabdasddfgdfgerterxgxv','abcdabd');