<?php
header('Content-type:text/html; charset=UTF-8');
$request = file_get_contents('php://input');
$data = json_decode($request, true);

// 获取文件
if($data['action'] == 'getDir'){
    $path = $data['path'];
    if(is_dir($path)){
        $dir = opendir($path);
        $dirarr = array('CODE'=>'success', 'DIR'=>array() ,'FILES'=>array(), 'PATH'=>$path);
        while($name = readdir($dir)){
            if($name != '.' && $name != '..'){
                $wpath = $path.'/';
                $time = filemtime($wpath.$name);
                $group = filegroup($wpath.$name);
                $size = filesize($wpath.$name);
                $perms = fileperms($wpath.$name);
                $x = $name.';'.$size.';'.$time.';'.$perms.';'.$group;
                if(filetype($wpath.$name) == 'dir'){
                    array_push($dirarr['DIR'], $x);
                }else if(filetype($wpath.$name) == 'file'){
                    array_push($dirarr['FILES'], $x);
                }
            }
        }
        $json = json_encode($dirarr);
        echo $json;
        closedir($dir);
    }else{

        $json = json_encode(array('code'=>'error', 'msg'=>'path is no Dir'));
        echo $json;
    }
}

// 搜索文件
if($data['action'] == 'searchFiles'){
    $filename = $data['filename'];
    $json = array('CODE'=>'success', 'FILES'=>array(), 'DIR'=>array());
    foreach(glob($filename) as $key=>$value){
        $time = filemtime($value);
        $group = filegroup($value);
        $size = filesize($value);
        $perms = fileperms($value);
        $data = basename($value).';'.$size.';'.$time.';'.$perms.';'.$group;
        if(is_dir($value)){
            array_push($json['DIR'], $data);
        }else{
            array_push($json['FILES'], $data);
        }
    }
    echo json_encode($json);
}

// 删除文件
if($data['action'] == 'deleteFiles'){
    $filearr = $data['data'];
    $json = array('CODE'=>'success');
    foreach($filearr as $key=>$value){
        $result = [];
        $a = explode(';', $value);
        $type = $a[0];
        $file = $a[1];
        if($type == 'file'){
            if(!unlink($file)){
                array_push($result, $file);
            }
        }else if($type == 'dir'){
            if(!rmdir($file)){
                array_push($result, $file);
            }
        }
        if(!empty($result)){
            $json['CODE'] = 'error';
            $json['msg'] = $result;
        }
    }
    echo json_encode($json);
}

// 添加文件
if($data['action'] == 'addFile'){
    $filename = $data['name'];
    $filecontent = $data['content'];
    $path = $data['path'];
    $json = array('CODE'=>'success');
    $newfile = @fopen($path.'/'.$filename, 'x');
    if(!$newfile){
        $json['CODE'] = 'error';
        $json['msg'] = '添加文件'.$filename.'失败';
    }else{
        fwrite($newfile, $filecontent);
    }
    fclose($newfile);
    echo json_encode($json);
}

// 添加目录
if($data['action'] == 'addDir'){
    $dirname = $data['name'];
    $path = $data['path'];
    $json = array('CODE'=>'success');
    if(!@mkdir($path.'/'.$dirname)){
        $json['CODE'] = 'error';
        $json['msg'] = '新建目录'.$dirname.'失败';
    }
    echo json_encode($json);
}