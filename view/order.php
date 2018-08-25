<section id="show-container" class="block-container">
    <div id="order-container" class="order-container row">
        <div class="store-content yt-card col-d107">
            <div class="ui-wrapper">
                <div class="heading">Đơn hàng của bạn</div>
                <div id="order-table" class="content-wrapper"></div>
            </div>
        </div>
        <div class="store-sidebar col-d103">
            <div class="ui-wrapper yt-card3">
<?php
include 'stack/recent_order.php';
?>
            </div>
            <div class="ui-wrapper yt-card3">
<?php
$you_need_know = 'feed_contact';
include 'stack/you_need_know.php';
?>
            </div>
        </div>
    </div>
</section>
<script>
// NEW INSTANCE FROM Cart_Invoke
var cart_order_page = new Cart_Invoke({
    containerID: 'order-table',
    xhrURL: url_base + '/xhr/_view_cart_order/',
    snippetID: '_view_cart_order'
});
cart_order_page.restart();
cart_order_page.showCart();
</script>