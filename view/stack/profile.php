<?php
if( $user_data ){
    if( $_GET['drive'] == 'lsd' ){
        $drive = 'lsd';
    }else{
        $drive = 'info';
    }
?>
<section id="show-container" class="block-container">
    <div class="profile-container col-mb">
        <div class="yt-card3">
            <div class="top-menu-profile">
                <ul>
                    <li aria-name="info"><a href="?drive=info">Thông tin cá nhân</a></li>
                    <li aria-name="lsd"><a href="?drive=lsd">Điểm thưởng</a></li>
                </ul>
            </div>
        </div>
<?php
include 'drive/'.$drive.'.php';
?>
    </div>
</section>
<?php
}else{
    // HASH EXPIRED : LOGOUT
?>
    <script>window.location.href = '<?=URLBASE.'/'.GO_USER.'/'.USER_LOGOUT.'/';?>';</script>
<?php
}
?>
<script>
// ACTIVE LI TOP MENU
$('li[aria-name="<?=$drive;?>"]').addClass('active');
</script>