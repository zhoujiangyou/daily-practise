<?php
/**
 * Created by PhpStorm.
 * php实现文件下载，实现限流下载
 * User: zht
 * Date: 2017/12/16
 * Time: 13:28
 */

class FileDownLoad{

    private $path;
    private $saveName;

    public function __construct(string $path='', string $saveName='')
    {
        $this->path=$path;
        $this->saveName=$saveName;
    }

    public function setPath(string $path){
        $this->path=$path;
        return $this;
    }

    public function getPath(string $path){
        $this->path=$path;
    }

    public function setSaveName(string $saveName){
        $this->saveName=$saveName;
        return $this;
    }

    /**
     *检查当前路径下的文件是否存在
     * return bool
     */
    public function checkPathFile(string $path=''){

        $patha=$path?$path:$this->path;
        if(!file_exists($patha)){
            return false;
        }
        return true;

    }

    /**
     *
     * 普通下载文件
     */
    public function downLoad(){
        if($this->checkPathFile()){
            header("Content-type: application/octet-stream");
            header("Accept-Ranges: bytes");
            header("Accept-Length: " . filesize($this->path));
            header("Content-Disposition: filename=" .$this->saveName);
            $file = fopen($this->path, "r");
            echo fread($file, filesize($this->path));
            fclose($file);
        }
    }

    /**
     *
     * 限速下载文件
     * @param int $speed
     */
    public function downLoadLimit(int $speed){
        if (file_exists($this->path) && is_file($this->path)) {
            header('Cache-control: private');// 发送 headers
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . filesize($this->path));
            header('Content-Disposition: filename=' . $this->saveName);
            $tspeed =$speed * 1024;
            $downsize=filesize($this->path)<$tspeed?filesize($this->path):$tspeed;
            $file = fopen($this->path, "r");
            while (!feof($file)) {
                echo  fread($file, round($downsize));// 发送当前部分文件给浏览者
                ob_flush();
                flush();// flush 内容输出到浏览器端
            }
            fclose($file);// 关闭文件流
        } else {
            //文件不存在处理逻辑

        }
    }
    /**
     *断点续下
     * @param string $fileSavePath 保存的文件地址
     */
    public function downLoadBC(string $fileSavePath,$speed){

        //检查本地是否有该文件，且文件大于0 小于完全下载文件大小。
        $this->checkPathFile($fileSavePath);
        $fileSaveSize=filesize($fileSavePath);
        $range =$this->getRange($fileSaveSize);
        $fh =  fopen($this->path, "rb");
        header('Cache-control: public');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$this->saveName);
        if($range!=null){
            header('HTTP/1.1 206 Partial Content');
            header('Accept-Ranges: bytes');
            header(sprintf('Content-Length: %u',$range['end'] - $range['start']));
            header(sprintf('Content-Range: bytes %s-%s/%s', $range['start'],$range['end'], $fileSaveSize));
            fseek($fh,sprintf('%u',$range['start']));
        }else{
            header("HTTP/1.1 200 OK");
            header(sprintf('Content-Length:%s',filesize($this->path)));
        }

        while(!feof($fh))
        {
            echo  fread($fh, round($speed*1024, 0));
            ob_flush();
        }
        ($fh != null)&& fclose($fh);


    }


    /**
     * 获取http_range 资源范围
     * @param $file_size
     * @return array|bool|mixed|null
     */
    protected  function getRange($file_size){
        $range = isset($_SERVER['HTTP_RANGE'])?isset($_SERVER['HTTP_RANGE']):null;
        if(!empty($range)){
            $range =preg_replace('/[\s|,].*/', '', $range);
            $range =explode('-',substr($range,6));
            if(count($range) < 2 ) {
                $range[1] = $file_size;
            }
            $range =array_combine(array('start','end'),$range);
            if(empty($range['start'])) {
                $range['start'] = 0;
            }
            if (!isset($range['end']) || empty($range['end'])) {
                $range['end'] = $file_size;
            }
            return$range;
        }
        return null;
    }
}
//
//$file  = new FileDownLoad();
//$file->setPath('F:\video\activityvideo1.mp4')->setSaveName('video.mp4')->downLoad();
//$file->setPath('F:\video\activityvideo1.mp4')->setSaveName('video.mp4')->downLoadLimit(20);