<?php
/**
 * Created by PhpStorm.
 * 大文件读取
 * User: zht
 * Date: 2017/12/20
 * Time: 13:43
 */

function formatBytes($bytes, $precision = 2) {
    $units = array("b", "kb", "mb", "gb", "tb");
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, $precision) . " " . $units[$pow];
}
//memory_get_peak_usage(); 返回分配给 PHP 内存的峰值

/**
 * 正常境况下单行读取文件 最后汇总内容
 * @param $path
 * @return array
 */
function read_file_lines_common($path){

    $hander=fopen($path,'r');
    $lines=[];
    while(!feof($hander)){
        $lines= trim(fgets($hander));
    }
    fclose($hander);
    return $lines;
}


/**
 * 使用迭代器，返回一个迭代器对象
 * 这种模式下每次内存中存储的内容为迭代器当前获取内容。相比一次性读取所有内容放置在内存中，这种很良心。
 * @param $path
 * @return Generator
 */
function read_file_lines_yeild($path){
    $handle = fopen($path,'r');
    while(!feof($handle)){
        yield trim(fgets($handle));
    }
    fclose($handle);
}

//在我们不需要处理数据的情况下，我们可以把文件数据传递到另一个文件。这种方式被称为“管道” stream

// from piping-files-2.php
$handle1 = fopen("XXXXXX.txt", "r");
$handle2 = fopen("XXXXXX.txt", "w");
stream_copy_to_stream($handle1, $handle2);
fclose($handle1);
fclose($handle2);

//除了可以写入文件中，还可以直接写入php相关的流中。
//php://stdin (只读)
//php://stderr (只写, 如php://stdout)
//php://input (只读) 这使我们能够访问原始请求体
//php://output (只写) 让我们写入输出缓冲区
//php://memory 和 php://temp (读-写) 是我们可以临时存储数据的地方。 不同之处在于一旦它变得足够大 php://temp 会将数据存储在文件系统中，而 php://memory 将一直持存储在内存中直到资源耗尽。