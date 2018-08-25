<?php
if($_GET['log']){
$msg = $_GET['msg'];
if($_GET['log']=='register'){
?>
<div class="heading">Đăng kí&nbsp;<span class="snackMsg"><?=$msg;?></span></div>
<div class="content">
    <input type="hidden" id="log" value="register"/>
    <p>Email</p>
    <input id="email" class="fwIpt" required/>
    <p>Mật khẩu</p>
    <input id="password" type="password" class="fwIpt" required/>
    <button id="ok" class="fwIpt">Đăng kí</button>
</div>
<?php
}else{
?>
<div class="heading">Đăng nhập&nbsp;<span class="snackMsg"><?=$msg;?></span></div>
<div class="content">

    <input type="hidden" id="log" value="login"/>
    <p>Email</p>
    <input id="email" class="fwIpt" required/>
    <p>Mật khẩu</p>
    <input id="password" type="password" class="fwIpt" required/>
    <button id="ok" class="fwIpt">Đăng nhập</button>
    <a data-id="register" onclick="logshowPanel(this.getAttribute('data-id'))">Tạo tài khoản</a>
</div>
<?php
}
?>
<script>
//CHECK SIGNUP
function checkSignup(){
    var streamInput='{';//data format with JSON
    var c=0;
    $('#panelBox .box .content input').each(function(){c++;
           var name=$(this).attr('id');
           var value=$(this).val();
           //trim "space" or "breakline" at beginning and ending in string
           value=value.replace(/^[ \s]+|[ \s]+$/g,'');

           //remove double , single quote in title , tag
           value=value.replace(/['"]+/g,'');

          //CHECK to make JSON
          if(name){
           if(c==1){streamInput+='"'+name+'":"'+value+'"';}
           else{
           streamInput+=',"'+name+'":"'+value+'"';
           }
          }
          if(!value){$(this).addClass('invalid');}else{$(this).removeClass('invalid');}
    });

    streamInput+='}';//Finished Json Data String
    //console.log(streamInput);

    var parseJSON = JSON.parse(streamInput);
    //console.log(parseJSON);
    if(parseJSON['email'].length > 3 && parseJSON['password'].length >= 3){

        $.post('../log.php',{suggest:streamInput}).done(function(data){
           //console.log(data)
           if(data.length > 10){
                //data return users : ID, GROUPID
                data = JSON.parse(data);
                document.cookie = 'userid='+data['userid']+';path=/';
                document.cookie = 'groupid='+data['groupid']+';path=/';
                document.cookie = 'email='+data['email']+';path=/';
                window.location.reload();
                $('.snackMsg').text('Success:'+data);
            }else{
                errorTxt = 'Lỗi xảy ra!';
                if(data==-1){
                    errorTxt = 'Email này đã có người sử dụng!';
                }else{
                    errorTxt = 'Tài khoản hoặc mật khẩu không đúng!';
                }
                $('.snackMsg').text(errorTxt);
            }
        });

    }
}
//GET DATA INPUT
$('#ok').click(function(){
    checkSignup();
});


$('#panelBox .box .heading').click(function(){
    $('#panelBox').hide();
});
</script>
<?php
}
?>