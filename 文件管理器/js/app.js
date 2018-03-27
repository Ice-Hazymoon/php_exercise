/*
 * @Author: Ice-Hazymoon 
 * @Date: 2018-03-24 23:37:11 
 * @Last Modified by: Ice-Hazymoon
 * @Last Modified time: 2018-03-27 13:26:36
 */

var selectArray = new Array();
var _path = '.';
var interface = {
    file: 'getfile.php'
};
var App = {
    // 向服务器发送请求
    fileOperation: function(data, callback){
        var request = new XMLHttpRequest();
        request.open('POST', interface.file, true);
        request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
        request.onload = function(){
            if(request.status == 200){
                var data = JSON.parse(request.responseText);
                if(typeof callback == 'function') callback(data);
            }
        }
        request.send(data)
    },
    // 将表格中选中的文件存在数组中
    selected: function(){
        // 全选按钮
        var c = document.querySelector('thead input[type="checkbox"]');
        c.onclick = function(){
            if(c.checked){
                selectArray = [];
                var el = document.querySelectorAll('tbody input[type="checkbox"]');
                el.forEach(element => {
                    var p = element.parentNode.parentNode.parentNode.classList.contains('folder');
                    var filepath = 'file;'+_path+'/'+element.parentNode.parentNode.nextElementSibling.childNodes[1].nodeValue;
                    if(p){
                        filepath = 'dir;'+_path+'/'+element.parentNode.parentNode.nextElementSibling.childNodes[1].nodeValue;
                    }
                    selectArray.push(filepath);
                });
            }else{
                selectArray = [];
            }
        }

        // 单选按钮
        var el = document.querySelectorAll('tbody input[type="checkbox"]');
        el.forEach(element => {
            element.onclick = function(){
                selectArray = [];
                var a = document.querySelectorAll('tbody input[type="checkbox"]:checked');
                a.forEach(h => {
                    var p = h.parentNode.parentNode.parentNode.classList.contains('folder');
                    var filepath = 'file;'+_path+'/'+h.parentNode.parentNode.nextElementSibling.childNodes[1].nodeValue;
                    if(p){
                        filepath = 'dir;'+_path+'/'+h.parentNode.parentNode.nextElementSibling.childNodes[1].nodeValue;
                    }
                    selectArray.push(filepath);
                });
            }
        });
    },
    // 面包屑导航
    breadcrumb: {
        // 回退一格
        back: function(){
            var el = document.getElementsByClassName('breadcrumb')[0];
            if(el.children.length == 1) return false;
            var r = el.children[el.children.length-1];
            r.parentNode.removeChild(r);
            el.children[el.children.length-1].classList.add('mdui-text-color-theme');
        },
        // 增加一格
        add: function(name){
            var p = document.getElementsByClassName('breadcrumb')[0]
            var el = document.createElement('div');
            el.className = 'directory mdui-typo-subheading';
            el.innerHTML = '<i class="mdui-icon material-icons mdui-text-color-black-divider">chevron_right</i><span class="mdui-text-color-theme">'+name+'</span>';
            p.children[p.children.length-1].classList.remove('mdui-text-color-theme');
            p.appendChild(el);
            App.breadcrumb.path();
        },
        // 点击事件
        path: function(){
            var el = document.querySelectorAll('.directory');
            document.getElementsByClassName('rootDir')[0].onclick = function(){
                document.querySelectorAll('.directory').forEach(e=>{
                    e.parentNode.removeChild(e);
                })
                _path = '.';
                App.fileOperation(JSON.stringify({
                    action: 'getDir',
                    page: 1,
                    num: 10,
                    path: _path
                }), function(data){
                    App.addFiles(data);
                })
            }
            el.forEach(element => {
                element.onclick = function(){
                    var arr = Array.from(this.parentNode.querySelectorAll('.directory'));
                    arr.forEach((e, index)=>{
                        if(e == element){
                            var i = index+1;
                            arr = arr.slice(i);
                            return;
                        }
                    });
                    arr.forEach(e=>{
                        e.parentNode.removeChild(e);
                    })
                    _path = '.';
                    document.querySelectorAll('.breadcrumb .directory').forEach(element => {
                        _path += '/'+element.childNodes[1].textContent;
                    });

                    App.fileOperation(JSON.stringify({
                        action: 'getDir',
                        page: 1,
                        num: 10,
                        path: _path
                    }), function(data){
                        App.addFiles(data);
                    })
                }
            });
        }
    },
    // 点击文件夹时
    enterFolder:function(el){
        var el = el.children[1];
        el.onclick = function(){
            var name = el.childNodes[1].nodeValue;
            _path = '.';
            document.querySelectorAll('.breadcrumb .directory').forEach(element => {
                _path += '/'+element.childNodes[1].textContent;
            });
            _path+='/'+name;
            App.fileOperation(JSON.stringify({
                action: 'getDir',
                page: 1,
                num: 10,
                path: _path
            }), function(data){
                App.addFiles(data);
                App.breadcrumb.add(name);
            })
        }
    },
    // 向表格中添加文件
    addFiles: function(data){
        var el = document.getElementsByTagName('tbody')[0];
        el.innerHTML = '';
        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                const e = data[key];
                if(key == 'DIR' || key == 'FILES'){
                    e.forEach(element => {
                        var i = false;
                        var arr = element.split(';');
                        var tr = document.createElement('tr');
                        var size = (arr[1] / 1024).toFixed(2)+' KB';
                        var date = new Date(arr[2]*1000).toLocaleString();
                        if(key == 'DIR'){
                            i = true
                            tr.className = 'folder';
                        }
                        var ico = i?'folder_open':'insert_drive_file';
                        tr.innerHTML = '<td><i class="mdui-icon material-icons mdui-text-color-black-secondary">'+ico+'</i>'+arr[0]+'</td>'+
                        '<td>'+size+'</td>'+
                        '<td>'+date+'</td>'+
                        '<td>'+arr[3]+'</td>'+
                        '<td>'+arr[4]+'</td>'+
                        '<td><button class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></button></td>';
                        el.appendChild(tr);
                    });
                }
            }
        }
        mdui.updateTables(document.querySelector('table'));
        App.selected();
        document.querySelectorAll('.folder').forEach(element => {
            App.enterFolder(element);
        });
    }
}

!function(){
    // 首次获取文件
    App.fileOperation(JSON.stringify({
        action: 'getDir',
        path: '.',
        page: 1,
        num: 10
    }), function(data){
        if(data['CODE'] == 'success'){
            App.addFiles(data);
        }else{
            mdui.snackbar({
                message: data.msg
            });
        }
    })
    
    App.selected();
    App.breadcrumb.path();

    // 文件删除按钮
    document.getElementById('delete-file-btn').onclick = function(){
        App.fileOperation(JSON.stringify({
            action: 'deleteFiles',
            data: selectArray
        }), function(data){
            if(data['CODE'] == 'success'){
                mdui.snackbar({
                    message: '删除成功'
                });
            }else{
                mdui.snackbar({
                    message: '文件: '+data.msg+'删除失败'
                });
            }
            App.fileOperation(JSON.stringify({
                action: 'getDir',
                path: _path,
                page: 1,
                num: 10
            }), function(data){
                if(data['CODE'] == 'success'){
                    App.addFiles(data);
                }else{
                    mdui.snackbar({
                        message: data.msg
                    });
                }
            })
        })
    }

    document.getElementById('refresh-btn').onclick = function(){
        App.fileOperation(JSON.stringify({
            action: 'getDir',
            path: _path,
            page: 1,
            num: 10
        }), function(data){
            if(data['CODE'] == 'success'){
                App.addFiles(data);
            }else{
                mdui.snackbar({
                    message: data.msg
                });
            }
        })
    }

    // 搜索按钮
    document.getElementById('search-input').onkeypress = function(e){
        if(e.keyCode == 13){
            App.fileOperation(JSON.stringify({
                action: 'searchFiles',
                filename: _path+'/'+document.getElementById('search-input').value,
                page: 1,
                num: 10
            }), function(data){
                if(data['CODE'] == 'success'){
                    App.addFiles(data);
                }else{
                    mdui.snackbar({
                        message: data.msg
                    });
                }
            })
        }
    }

    // 添加文件
    document.getElementById('new-file-btn').onclick = function(){
        var newFileName = document.getElementById('new-file-name').value;
        var newFileContent = document.getElementById('new-file-content').value;
        var close = this;
        App.fileOperation(JSON.stringify({
            action: 'addFile',
            name: newFileName,
            path: _path,
            content: newFileContent
        }), function(data){
            if(data['CODE'] == 'success'){
                close.nextElementSibling.click();
                App.fileOperation(JSON.stringify({
                    action: 'getDir',
                    path: _path,
                    page: 1,
                    num: 10
                }), function(data){
                    App.addFiles(data);
                })
            }else if(data['CODE'] == 'error'){
                mdui.snackbar({
                    message: data.msg
                });
            }
        })
    }

    // 添加目录
    document.getElementById('new-dir-btn').onclick = function(){
        var close = this;
        var newDirName = document.getElementById('new-dir-name').value;
        App.fileOperation(JSON.stringify({
            action: 'addDir',
            name: newDirName,
            path: _path,
        }), function(data){
            if(data['CODE'] == 'success'){
                close.nextElementSibling.click();
                App.fileOperation(JSON.stringify({
                    action: 'getDir',
                    path: _path,
                    page: 1,
                    num: 10
                }), function(data){
                    App.addFiles(data);
                })
            }else if(data['CODE'] == 'error'){
                mdui.snackbar({
                    message: data.msg
                });
            }
        })
    }

    document.querySelectorAll('.folder').forEach(element => {
        App.enterFolder(element);
    });

}()