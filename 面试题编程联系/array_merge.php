<?php
/**
 * Created by PhpStorm.
 * User: zht
 * Date: 2018/1/8
 * Time: 11:03
 * 数组合并
 */

$arr1 = [0=>0,1=>1,2=>2,3=>3];
$arr2 = [4=>4,5=>5,6=>6,7=>7];
$arr3 = [0=>'00000',1=>'111111',2=>2,3=>3];
//合并方式1  + 号 在遇到相同key值的时候 前数组的值会覆盖后数组的值
//var_dump($arr1+$arr2);

//合并方式2 array_merge 相同key值不会管 相当于在第一个数组后面追加
var_dump(array_merge($arr1,$arr2));
var_dump(array_merge($arr1,$arr3));