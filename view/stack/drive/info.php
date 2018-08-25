        <div class="content-profile">
            <div class="notice-box ui-wrapper cr-card">
                <h2>Thông tin cá nhân?</h2>
                <p>Khi mua hàng hóa trên Website chúng tôi sẽ liên hệ với bạn qua thông tin bạn cung cấp.</p><br>
                <p><i>Chúng tôi tuyệt đối giữ bí mật thông tin của bạn.</i></p><br>
                <p>Nếu thông tin bạn cung cấp không chính xác hãy liên hệ để được hỗ trợ:</p>
                <p>HOTLINE: <b><?=HOTLINE;?></b></p>
                <p>Chúng tôi hân hạnh được phục vụ bạn.</p>
            </div>
            <h2 class="title">Sửa thông tin cơ bản</h2>
            <form id="basic-info" class="form-wrapper form-submit">
<?php
    $map_key_val_column = [
        'name'=>'Họ tên', 'address'=>'Địa chỉ giao hàng, vd: 46 Cao Van Lau, Bac Lieu'
    ];

?>
                <div class="ui-wrapper cr-card">
                    <div class="error-text"></div>
<?php
foreach( $map_key_val_column as $column_name => $title){
    $column_value = $user_data[strtoupper($column_name)];
    $statusFormControl = $column_value ? 'valued' : '';
    $require_bool = ( $column_name == 'phone_number' ) ? true : false;
?>
<div class="bound-form-control">
    <input class="form-control <?=$statusFormControl;?>" data-require="<?=$require_bool;?>" type="text" name="<?=$column_name;?>" value="<?=$column_value;?>" />
    <label class="label-place-top">
        <span class="label-title"><?=$title;?></span>
    </label>
</div>
<?php
}
?>
<div class="action-box">
    <button type="submit" class="_btn _btn-b" data-ripple>Lưu</button>
</div>
                </div>
            </form>
            <h2 class="title">Đổi số điện thoại</h2>
            <form id="phone-number" class="form-wrapper form-submit">
                <div class="ui-wrapper cr-card">
                    <div class="error-text"></div>
<?php
$statusFormControl_phone_number = $user_data['PHONE_NUMBER'] ? 'valued' : '';
?>
<div class="bound-form-control">
    <input class="form-control <?=$statusFormControl_phone_number;?>" data-require="1" type="text" name="phone_number" value="<?=$user_data['PHONE_NUMBER'];?>"/>
    <label class="label-place-top">
        <span class="label-title">Số điện thoại</span>
    </label>
</div>
<div class="action-box">
    <button type="submit" class="_btn _btn-b" data-ripple>Lưu</button>
</div>
                </div>
            </form>
            <h2 class="title">Thay đổi Email</h2>
            <form id="email" class="form-wrapper form-submit">
                <div class="ui-wrapper cr-card">
                    <div class="error-text"></div>
<?php
$statusFormControl_email = $user_data['EMAIL'] ? 'valued' : '';
?>
<div class="bound-form-control">
    <input class="form-control <?=$statusFormControl_email;?>" data-require="1" type="text" name="email" value="<?=$user_data['EMAIL'];?>"/>
    <label class="label-place-top">
        <span class="label-title">Địa chỉ Email</span>
    </label>
</div>
<div class="action-box">
    <button type="submit" class="_btn _btn-b" data-ripple>Lưu</button>
</div>
                </div>
            </form>
            <h2 class="title">Thay đổi mật khẩu</h2>
            <form id="password" class="form-wrapper form-submit">
                <div class="ui-wrapper cr-card">
                    <div class="error-text"></div>
<div class="bound-form-control">
    <input class="form-control" data-require="1" type="password" name="password"/>
    <label class="label-place-top">
        <span class="label-title">Mật khẩu mới</span>
    </label>
</div>
<div class="bound-form-control">
    <input class="form-control" data-require="1" type="password" name="repassword"/>
    <label class="label-place-top">
        <span class="label-title">Nhập lại mật khẩu mới</span>
    </label>
</div>
<div class="action-box">
    <button type="submit" class="_btn _btn-b" data-ripple>Lưu</button>
</div>
                </div>
            </form>
        </div>
<script>
// BIND SUBMIT TO MULTI-FORM
var basic_info_form = new Form_Invoke({
    containerID : 'content-profile',
    formID : 'basic-info',
    xhrURL : url_base + '/xhr/_user_update/',
}).restart();
var phone_number_form = new Form_Invoke({
    containerID : 'content-profile',
    formID : 'phone-number',
    xhrURL : url_base + '/xhr/_user_update/',
}).restart();
var email_form = new Form_Invoke({
    containerID : 'content-profile',
    formID : 'email',
    xhrURL : url_base + '/xhr/_user_update/',
}).restart();
var password_form = new Form_Invoke({
    containerID : 'content-profile',
    formID : 'password',
    xhrURL : url_base + '/xhr/_user_update/',
}).restart();
</script>