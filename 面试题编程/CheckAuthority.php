<?php
/**
 * Created by PhpStorm.
 * User: zht
 * Date: 2018/1/8
 * Time: 14:53
 * 判断文件夹或者文件是否可写
 * 如果是文件夹，就看看能不能在文件夹中新建文件
 * 如果是文件，那就看看能不能读。
 */

function MyIsWrited($file){

    if(is_dir($file)){
        if($fp =fopen("$file/test.text",'w')){
            fclose($fp);
            unlink("$file/test.txt");
            $writeable = 1;
        }else{
            $writeable = 0;
        }
    }else{
        if($fp =fopen("$file",'a+')){
            fclose($fp);
            $writeable = 1;
        }else{
            $writeable = 0;
        }
    }
    return $writeable;
}