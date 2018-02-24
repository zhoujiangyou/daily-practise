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

function Find($target, $array)
{
    // write code here
    $len = count($array)-1;
    $i=0;
    $num=count($array[0]);
    while($len>=0 && $i<$num){
        if($target<$array[$len][$i]){
            $len--;
        }elseif($target>$array[$len][$i]){
            $i++;
        }else{
            return true;
        }
    }
    return false;
}
var_dump(Find(3,[[1,2,8,9],[2,4,9,12],[4,7,10,13],[6,8,11,15]]));

class TreeNode
{
    var $val;
    var $left = NULL;
    var $right = NULL;

    function __construct($val)
    {
        $this->val = $val;
    }
}
function reConstructBinaryTree($pre, $vin)
{
    // write code here
    if ($pre && $vin) {
        $treeRoot = new TreeNode($pre[0]);
        $index = array_search($pre[0], $vin);
        $treeRoot->left = reConstructBinaryTree(array_slice($pre, 1, $index), array_slice($vin, 0, $index));
        $treeRoot->right = reConstructBinaryTree(array_slice($pre, $index + 1), array_slice($vin, $index + 1));
        return $treeRoot;
    }
}

var_dump(reConstructBinaryTree([1,2,4,7,3,5,6,8],[4,7,2,1,5,3,8,6]));