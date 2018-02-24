<?php
/**
 * Created by PhpStorm.
 * 二叉树遍历
 * User: zht
 * Date: 2017/12/16
 * Time: 13:44
 */

class Node{
    public $values;
    public $leftNode;
    public $rightNode;
}

//前序遍历
// 先访问根节点然后在访问左右子节点，并且在遍历左右子树的时候，依然先遍历根节点，然后在访问左树，最后遍历右树

function preOrder($root){

    $stack=[];
    array_push($stack,$root);
    while(!empty($stack)){
        $center_node = array_pop($stack);
        echo $center_node->value;

        if($center_node->rightNOde!=null){ // 先将右节点导入 保证访问某个节点的左右节点时，左节点先出栈。
            array_push($stack,$center_node->rightNOde);
        }
        if($center_node->leftNode!=null){
            array_push($stack,$center_node->leftNode);
        }
    }
}


//中序遍历 :先访问左节点，然后根节点，最后右节点

function midOrder($root){

    $stack=[];
    $center_node=$root;
    while(!empty($stack) || $center_node!= null){
        while($center_node!=null){
            array_push($stack,$center_node);
            $center_node=$center_node->leftNode; //一直找寻左节点，并将左节点压入栈中
        }
        $center_node=array_pop($stack);
        echo $center_node->value;
        $center_node=$center_node->right;
    }
}


//后序遍历:先遍历左子树，然后遍历右子树，最后访问根节点；同样，在遍历左右子树的时候同样要先遍历左子树，然后遍历右子树，最后访问根节点
function endOrder($root){
    $push_stack = array();
    $visit_stack = array();
    array_push($push_stack, $root);

    while (!empty($push_stack)) {
        $center_node = array_pop($push_stack);
        array_push($visit_stack, $center_node);

        if ($center_node->leftNode != null) array_push($push_stack, $center_node->leftNode);
        if ($center_node->rightNode != null) array_push($push_stack, $center_node->rightNode);

    }

    while (!empty($visit_stack)) {
        $center_node = array_pop($visit_stack);
        echo $center_node->value . ' ';
    }
}

$a = new Node();
$b = new Node();
$c = new Node();
$d = new Node();
$e = new Node();
$f = new Node();
$g = new Node();
$h = new Node();
$i = new Node();

$a->value = 'A';
$b->value = 'B';
$c->value = 'C';
$d->value = 'D';
$e->value = 'E';
$f->value = 'F';
$g->value = 'G';
$h->value = 'H';
$i->value = 'I';

$a->leftNode = $b;
$a->rightNode = $c;
$b->leftNode = $d;
$b->rightNode = $g;
$c->leftNode = $e;
$c->rightNode = $f;
$d->leftNode = $h;
$d->rightNode = $i;

endOrder($a);

class TreeNode{
    var $val;
    var $left = NULL;
    var $right = NULL;
    function __construct($val){
        $this->val = $val;
    }
}

//输入某二叉树的前序遍历和中序遍历的结果，请重建出该二叉树。
//假设输入的前序遍历和中序遍历的结果中都不含重复的数字。
//例如输入前序遍历序列{1,2,4,7,3,5,6,8}和中序遍历序列{4,7,2,1,5,3,8,6}，则重建二叉树并返回。
function reConstructBinaryTree($pre, $vin)
{
    // write code here
    if($pre && $vin){
        $treeRoot = new TreeNode($pre[0]);
        $index = array_search($pre[0],$vin);
        $treeRoot->left = reConstructBinaryTree(array_slice($pre,1,$index),array_slice($vin,0,$index));
        $treeRoot->right = reConstructBinaryTree(array_slice($pre,$index+1),array_slice($vin,$index+1));
        return $treeRoot;
    }

}