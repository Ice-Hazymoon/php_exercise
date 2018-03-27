document.getElementById('submit').onclick = function(){
    var usernmae = document.getElementById('username').value.trim(),
        avatar = document.getElementById('avatar').value.trim(),
        content = document.getElementById('content').value.trim();
    if(content){
        var formData = new FormData();
        formData.append('username', usernmae?usernmae:'false');
        formData.append('avatar', avatar?avatar:'false');
        formData.append('content',content)
        ajax(formData, function(data){
            var el = document.querySelector('.list .mdui-list');
            el.innerHTML = '';
            data.list.forEach(e => {
                var li = document.createElement('li');
                li.className = 'mdui-list-item mdui-ripple';
                var img = b(e.avatar)?'<img src="'+e.avatar+'"/>':'<i class="mdui-icon material-icons">person</i>';
                var username = b(e.username)?e.username:'匿名用户';
                console.log(e.username)
                li.innerHTML = '<div class="mdui-list-item-avatar">'+img+'</div>'+
                '<div class="mdui-list-item-content">'+username+': '+e.content+'</div>';
                el.appendChild(li);
            });
        })
    }else{
        alert('请输入信息瞄~');
        return false;
    }
}

function ajax(data, callback){
    var request = new XMLHttpRequest();
    request.open('post', './getList.php', true);
    request.onload = function(){
        if(request.status == 200){
            if(typeof callback == 'function'){
                var c = JSON.parse(request.responseText);
                callback(c);
                return true;
            }
        }else{
            alert('后台炸了');
            return false;
        }
    }
    request.onerror = function(){
        alert('后台炸了');
        return false;
    }
    request.send(data)
}

function b(e){
    if(e == 'false'){
        return false;
    }else{
        return true;
    }
}