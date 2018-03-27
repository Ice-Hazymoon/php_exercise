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
                    <div class="title mdui-text-center mdui-typo-display-2 mdui-text-color-white">文件管理器</div>
                    <div class="subtitle mdui-text-center mdui-typo-subheading mdui-text-color-white">基于PHP的文件管理器</div>
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
            <div class="operating mdui-valign">
                <button class="mdui-btn mdui-ripple mdui-color-theme-accent" id="refresh-btn">刷新</button>
                <button class="mdui-btn mdui-ripple mdui-color-theme-accent" id="delete-file-btn">刪除</button>
                <button class="mdui-btn mdui-ripple mdui-color-theme-accent" id="add-file-btn" mdui-menu="{target: '#add-file-list', covered: false}">新建</button>
                <div class="search mdui-clearfix">
                    <div class="mdui-textfield mdui-textfield-expandable mdui-float-right">
                        <button class="mdui-textfield-icon mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">search</i></button>
                        <input id="search-input" class="mdui-textfield-input" type="text" placeholder="Search"/>
                        <button class="mdui-textfield-close mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">close</i></button>
                    </div>
                </div>
                <ul class="mdui-menu" id="add-file-list">
                    <li class="mdui-menu-item" id="add-file" mdui-dialog="{target: '#new-file-dialog'}">
                        <a href="javascript:;" class="mdui-ripple">新建文件</a>
                    </li>
                    <li class="mdui-menu-item" id="new-dir" mdui-dialog="{target: '#new-dir-dialog'}">
                        <a href="javascript:;" class="mdui-ripple">新建目录</a>
                    </li>
                </ul>
                <div class="mdui-dialog" id="new-file-dialog">
                    <div class="mdui-dialog-title">新建文件</div>
                    <div class="mdui-dialog-content">
                        <div class="mdui-textfield">
                            <input class="mdui-textfield-input" id="new-file-name" type="text" placeholder="文件名"/>
                        </div>
                        <div class="mdui-textfield">
                            <textarea class="mdui-textfield-input" id="new-file-content" type="text" placeholder="文件内容"/></textarea>
                        </div>
                    </div>
                    <div class="mdui-dialog-actions">
                        <button class="mdui-btn mdui-ripple" id="new-file-btn">添加</button>
                        <button class="mdui-btn mdui-ripple" mdui-dialog-close>cancel</button>
                    </div>
                </div>
                <div class="mdui-dialog" id="new-dir-dialog">
                    <div class="mdui-dialog-title">新建目录</div>
                    <div class="mdui-dialog-content">
                        <div class="mdui-textfield">
                            <input class="mdui-textfield-input" id="new-dir-name" type="text" placeholder="目录名"/>
                        </div>
                    </div>
                    <div class="mdui-dialog-actions">
                        <button class="mdui-btn mdui-ripple" id="new-dir-btn">添加</button>
                        <button class="mdui-btn mdui-ripple" mdui-dialog-close>cancel</button>
                    </div>
                </div>
            </div>
            <div class="mdui-divider"></div>
            <div class="breadcrumb mdui-valign">
                <div class="mdui-typo-subheading rootDir">根目录</div>
            </div>
            <div class="mdui-divider"></div>
            <div class="files">
                <div class="mdui-table-fluid mdui-shadow-0">
                    <table class="mdui-table mdui-table-selectable mdui-table-hoverable">
                        <thead>
                            <tr>
                                <th>文件名</th>
                                <th>文件大小</th>
                                <th>修改时间</th>
                                <th>权限</th>
                                <th>所有者</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <script src="js/mdui.min.js"></script>
        <script src="js/app.js"></script>
    </footer>
</body>

</html>