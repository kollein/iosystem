<section id="show-container" class="block-container">
    <div class="user-container">
        <div class="yt-card login-wrapper">
            <div class="ui-wrapper">
                <div class="_title">
                    <div class="headerTitle">Tìm lại tài khoản</div>
                    <span class="noticeTitle">Hãy nhập chính xác thông tin bên dưới</span>
                </div>
                <div class="error-text"></div>
                <form id="forgotAccount">
                    <div class="bound-form-control">
                        <input class="form-control" type="text" name="email:phone_number"/>
                        <label class="label-place-top">
                            <span class="label-title">Số điện thoại hoặc Email</span>
                        </label>
                    </div>
                    <div class="bound-button">
                        <button type="submit" class="_login_btn _btn _btn-b" data-ripple>Gửi</button>
                    </div>
                </form>
                <div class="hr"><span>trở lại đăng nhập</span></div>
                <div class="signup-link-wrapper">
                    <a class="rc-button rc-red yt-uix-button" href="<?=generate_url_by_map([GO_USER, USER_LOGIN]);?>">Đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</section>