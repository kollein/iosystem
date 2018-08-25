<section id="show-container" class="block-container">
    <div class="user-container">
        <div class="yt-card login-wrapper">
            <div class="ui-wrapper">
                <div class="_title">
                    <div class="headerTitle">Đăng nhập tài khoản</div>
                    <span class="noticeTitle">Sử dụng cho tất cả</span>
                </div>
                <div class="error-text"></div>
                <form id="login">
                    <div class="bound-form-control">
                        <input class="form-control" type="text" name="email:phone_number"/>
                        <label class="label-place-top">
                            <span class="label-title">Số điện thoại hoặc Email</span>
                        </label>
                    </div>
                    <div class="bound-form-control">
                        <input class="form-control" type="password" name="password"/>
                        <label class="label-place-top">
                            <span class="label-title">Mật khẩu</span>
                        </label>
                    </div>
                    <div class="forgot-account">
                        <a href="<?=generate_url_by_map([GO_USER, USER_FORGOT_ACCOUNT]);?>">Tìm tài khoản của bạn</a>
                    </div>
                    <div class="bound-button">
                        <button type="submit" class="_login_btn _btn _btn-b" data-ripple>Tiếp theo</button>
                    </div>
                </form>
                <div class="hr"><span>nhanh hơn hãy</span></div>
                <div class="social-sdk-login-wrapper">
                    <button class="_login_btn yt-uix-button-primary yt-uix-button" onclick="loginWithFB()">Đăng nhập thông qua Facebook</button>
                </div>
                <div class="hr"><span>hoặc</span></div>
                <div class="signup-link-wrapper">
                    <a class="rc-button rc-red yt-uix-button" href="<?=generate_url_by_map([GO_USER, USER_SIGNUP]);?>">Đăng ký nhanh</a>
                </div>
            </div>
        </div>
    </div>
</section>