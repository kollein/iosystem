<?php
if( in_array($you_need_know_alias, ['t', 'p']) ){
?>
<div class="terms-store-wrapper">
    <div class="_title">Bạn cần biết?</div>
    <div class="_content">
        <ul>
            <li>Dịch vụ giao hàng, mua đồ dùm là miễn phí.</li>
            <li>10 ngàn đồng/(1 hóa đơn mua hàng): sẽ tiết kiệm được 1 LSD.</li>
            <li><i>1 LSD = 1 ngàn đồng</i>. Tiền này là tiền tiết kiệm của bạn.</li>
            <li><b>Và bạn có thể dùng để mua hàng hóa.</b></li>
        </ul>
    </div>
</div>
<?php
}elseif( in_array($you_need_know_alias, ['s']) ){
?>
<div class="terms-store-wrapper">
    <div class="_title">Bạn cần biết?</div>
    <div class="_content">
        <ul>
            <li>Chia sẽ và nhận lại là nơi trao tặng những món đồ mà bạn không dùng nữa.</li>
            <li>Đến những ai cần.</li>
            <li><i>Dựa trên sự tự chia sẽ của bạn</i>.</li>
            <li><b>Xin vui lòng không nhận khi bạn không thật sự cần.</b></li>
        </ul>
    </div>
</div>
<?php
}elseif( $you_need_know == 'feed_contact' ){
?>
<div class="you-need-know">
    <h2>MỌI THẮC MẮC XIN GỬI VỀ</h2>
    <ul>
        <li><?=CARE_EMAIL;?></li>
        <li>Hotline: <?=HOTLINE;?></li>
        <li>Đ/c: <?=COMPANY_ADDRESS;?></li>
    </ul>
</div>
<?php
}
?>