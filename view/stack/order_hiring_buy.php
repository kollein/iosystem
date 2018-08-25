<section id="show-container" class="service-container block-container">
	<div class="color-box-container row row-grid-10">
		<div class="color-box-wrapper col-d2">
			<div class="box-wrapper ui-wrapper cr-card ">
				<div class="header">
					<h2>Dịch vụ: Mua đồ dùm</h2>
					<span class="note">Vui lòng dùng cho mục đích thiết thực</span>
				</div>
				<div class="content">
<form id="hiring-buy-service" class="form-wrapper form-submit">
    <div class="ui-wrapper cr-card">
        <div class="error-text"></div>
<div class="bound-form-control">
    <textarea class="form-control" data-require="1" name="content" spellcheck="false"></textarea>
    <label class="label-place-top">
        <span class="label-title">Nhập những gì bạn cần mua</span>
    </label>
</div>
<div class="bound-form-control">
    <input class="form-control" data-require="1" type="text" name="phone_number"/>
    <label class="label-place-top">
        <span class="label-title">Số điện thoại của bạn</span>
    </label>
</div>
<div class="bound-form-control">
    <input class="form-control" data-require="1" type="text" name="address"/>
    <label class="label-place-top">
        <span class="label-title">Địa chỉ của bạn</span>
    </label>
</div>
<div class="action-box">
    <button type="submit" class="_btn _btn-b" data-ripple>Gửi</button>
</div>
    </div>
</form>
	            </div>
			</div>
		</div>
		<div class="color-box-wrapper col-d2">
			<div class="box-wrapper ui-wrapper cr-card ">
				<div class="header"><h2>Thông báo:</h2></div>
				<div class="content">
					<div class="note-wrapper">
						<div class="distance-icon alert-icon"></div>
						<div class="text"><p>Dịch vụ mua đồ dùm áp dụng trong phạm vi bán kính 5km tính từ Bưu Điện Tỉnh Bạc Liêu.</p></div>
					</div>
					<div class="note-wrapper">
						<div class="transfer-car-icon alert-icon"></div>
						<div class="text"><p>Đơn hàng sẽ được nhận và 20 phút sau sẽ giao hàng đến tay bạn.</p></div>
					</div>
					<div class="note-wrapper">
						<div class="pen-icon alert-icon"></div>
						<div class="text"><p>Chỉ nhận những đơn hàng ghi đầy đủ: tên sản phẩm, số lượng(trọng lượng), mua ở đâu.</p></div>
					</div>
					<div class="note-wrapper">
						<div class="measure-weight-icon alert-icon"></div>
						<div class="text"><p>Trọng lượng hàng tối đa: 6kg. Không nhận mua hàng cồng kềnh.</p></div>
					</div>
					<div class="note-wrapper">
						<div class="deal-man-icon alert-icon"></div>
						<div class="text"><p>Chúng tôi giao hàng rồi mới nhận tiền. Không nhận mua những hàng trái phép quy định bới luật pháp nhà nước Việt Nam.</p></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
// BIND SUBMIT TO FORM
var hiring_buy_service_form = new Form_Invoke({
    containerID : 'service-container',
    formID : 'hiring-buy-service',
    xhrURL : url_base + '/xhr/_order_hiring_buy_service_store/',
    after_submit : {state : 'success', go_to_url: url_base, delay: 4000}
}).restart();
</script>