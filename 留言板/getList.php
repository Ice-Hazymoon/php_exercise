<?php
header('Content-type:text/html; charset=UTF-8');
$request = $_REQUEST;
$filepath = './_guestbook.json';
if(!file_exists($filepath)){
    $file = fopen($filepath, 'w');
    fclose($file);
}
$content = file_get_contents($filepath);
$json = json_decode($content, true);
if(!$json){
    $arr = [
        'list'=>[
            [
                'username'=>trim($request['username']),
                'avatar'=>trim($request['avatar']),
                'content'=>trim($request['content'])
            ]
        ]
    ];
    file_put_contents($filepath, json_encode($arr));
}else{
    $arr = [
        'username'=>trim($request['username']),
        'avatar'=>trim($request['avatar']),
        'content'=>trim($request['content'])
    ];
    array_push($json['list'], $arr);
    file_put_contents($filepath, json_encode($json));
}

echo file_get_contents($filepath);
?>