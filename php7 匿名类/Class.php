<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/20
 * Time: 16:43
 */
class common{
    public $num;
    public function __construct($value){

      $this->num=$value;
    }
    public function getValue($com){

        $this->num +=$com;
        echo   $this->num;
    }
}

echo (new class(1)extends common{})->getValue(10);