<?php
$user_data_display_name = $user_data['NAME'] ? $user_data['NAME'] : (!$user_data['EMAIL'] ? '' : $user_data['EMAIL']);
?>
<section id="show-container" class="block-container">
    <div class="col-d107 ui-wrapper yt-card">
        <div class="guiding-container">
            <div class="box-guide">
                <span>Xin chào, <span class="username"><?=$user_data_display_name;?></span></span>
                <div class="content">
                    <div class="cover">
                        <img class="imgScaledown" src="<?=URLBASE;?>/image/guiding/bussiness-man-speech.png"/>
                    </div>
                    <div class="text">
    Bạn hiện là thành viên tại lamsaode.com <br>
    hiện bạn có thể mua hàng và được giao tại nơi miễn phí <br>
    và được tích điểm thưởng: <br>
    10 ngàn (cho 1 đơn hàng) = 1 điểm tích lũy <br>
    1 điểm tích lũy (1LSD) = 1 ngàn đồng <br>
    * LSD : là tiền thưởng của bạn <br>
    <br>
    Nếu bạn là một cửa hàng kinh doanh có thể bày bán <br>
    lamsaode: hỗ trợ mở quầy hàng cho bạn miễn phí.<br>
    Dịch vụ giao hàng miễn phí trong nội ô thành phố Bạc Liêu.
                    </div>
                </div>
                <div class="link">
                    <a class="a-btn-quare yt-uix-button-primary yt-uix-button" href="<?=URLBASE;?>">Mua và được giao miễn phí</a>
                    <a class="a-btn-quare yt-uix-button-primary yt-uix-button" href="<?=generate_url_by_map([GO_USER, USER_PROFILE, '?'.USER_PROFILE_QUERY_ALIAS.'='.USER_PROFILE_LSD]);?>">Tiền tiết kiệm</a>
                </div>
            </div>
        </div>
    </div>
</section>