<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/mdui.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="mdui-theme-primary-cyan mdui-theme-accent-pink">
    <header>
        <div class="menuBtn">
            <button id="open_drawer" class="mdui-btn mdui-btn-icon mdui-text-color-white" mdui-drawer="{target: '#drawer', overlay: true, swipe: true}">
                <i class="mdui-icon material-icons">menu</i>
            </button>
        </div>
        <div class="header mdui-color-theme">
            <div class="t mdui-valign">
                <div class="ht mdui-center">
                    <div class="title mdui-text-center mdui-typo-display-2 mdui-text-color-white">留言板</div>
                    <div class="subtitle mdui-text-center mdui-typo-subheading mdui-text-color-white">在下方输入用户名和内容提交</div>
                </div>
            </div>
        </div>
    </header>

    <div class="mdui-drawer mdui-drawer-close mdui-color-white" id="drawer">
        <ul class="mdui-list">
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">move_to_inbox</i>
                <div class="mdui-list-item-content">Inbox</div>
            </li>
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">star</i>
                <div class="mdui-list-item-content">Starred</div>
            </li>
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">send</i>
                <div class="mdui-list-item-content">Sent mail</div>
            </li>
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">drafts</i>
                <div class="mdui-list-item-content">Drafts</div>
            </li>
            <li class="mdui-subheader">Subheader</li>
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">email</i>
                <div class="mdui-list-item-content">All mail</div>
            </li>
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">delete</i>
                <div class="mdui-list-item-content">Trash</div>
            </li>
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">error</i>
                <div class="mdui-list-item-content">Spam</div>
            </li>
        </ul>
    </div>

    <main>
        <div class="settingsBtn">
            <button class="mdui-fab mdui-hidden-md-down mdui-ripple mdui-color-theme-accent" mdui-tooltip="{content: '上传设置'}" mdui-dialog="{target: '#dialog'}">
                <i class="mdui-icon material-icons">add</i>
            </button>
            <button class="mdui-fab mdui-hidden-lg-up mdui-fab-fixed mdui-ripple mdui-color-theme-accent" mdui-tooltip="{content: '上传设置'}"
                mdui-dialog="{target: '#dialog'}">
                <i class="mdui-icon material-icons">add</i>
            </button>
            <div id="dialog"></div>
        </div>
        <div class="card mdui-shadow-2">
            <div class="ccc mdui-valign">
                <div class="mdui-center">
                    <div class="mdui-textfield">
                        <input id="username" class="mdui-textfield-input" type="text" placeholder="用户名(可选)"/>
                    </div>
                    <div class="mdui-textfield">
                        <input id="avatar" class="mdui-textfield-input" type="text" placeholder="头像地址(可选)"/>
                    </div>
                    <div class="mdui-textfield">
                        <textarea id="content" class="mdui-textfield-input" placeholder="留言内容(必填)"></textarea>
                    </div>
                    <button id="submit" class="mdui-m-t-2 mdui-m-b-2 mdui-center mdui-btn mdui-color-theme-accent mdui-ripple">提交</button>
                </div>
            </div>
            <div class="mdui-divider"></div>
            <div class="list">
                <ul class="mdui-list">

<?php
$filepath = '_guestbook.json';
if(!file_exists($filepath)){
    $file = fopen($filepath, 'w');
    fclose($file);
}
$fileContent = file_get_contents('_guestbook.json');
if(!$fileContent) goto end;
$listArray = json_decode($fileContent, true);
foreach ($listArray['list'] as $key => $value) {
    echo '<li class="mdui-list-item mdui-ripple">';
    if($value['avatar'] != 'false'){
        echo '<div class="mdui-list-item-avatar"><img src="'.$value['avatar'].'"/></div>';
    }else{
        echo '<i class="mdui-list-item-avatar mdui-icon material-icons">person</i>';
    }

    if($value['username'] != 'false'){
        echo '<div class="mdui-list-item-content">'.$value['username'].': '.$value['content'].'</div>';
    }else{
        echo '<div class="mdui-list-item-content">匿名用户: '.$value['content'].'</div>';
    }
    echo '</li>';
}
end:
?>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <script src="js/mdui.min.js"></script>
        <script src="js/app.js"></script>
    </footer>
</body>
</html>