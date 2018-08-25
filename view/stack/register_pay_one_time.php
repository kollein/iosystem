<section id="show-container" class="service-container block-container">
	<div class="color-box-container row row-grid-10 orange">
		<div class="color-box-wrapper col-d2">
			<div class="box-wrapper ui-wrapper cr-card ">
				<div class="header">
					<h2>Đăng ký: Dịch vụ Mua đồ trả theo tháng</h2>
					<span class="note">Sau khi đăng ký xong bạn sẽ được hỗ trợ để sử dụng dịch vụ</span>
				</div>
				<div class="content">
<form id="pay-one-time-service" class="form-wrapper form-submit">
    <div class="ui-wrapper cr-card">
        <div class="error-text"></div>
<div class="bound-form-control">
    <textarea class="form-control" data-require="1" name="content" spellcheck="false"></textarea>
    <label class="label-place-top">
        <span class="label-title">Giới thiệu sơ về bạn (đi học, làm việc ở đâu, nội trợ?)</span>
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
						<div class="text"><p>Dịch vụ mua đồ trả theo tháng áp dụng trong phạm vi bán kính 8km tính từ Bưu Điện Tỉnh Bạc Liêu.</p></div>
					</div>
					<div class="note-wrapper">
						<div class="transfer-car-icon alert-icon"></div>
						<div class="text"><p>Chúng tôi giao hàng đến nơi miễn phí.</p></div>
					</div>
					<div class="note-wrapper">
						<div class="people-circle-icon alert-icon"></div>
						<div class="text"><p>Đối tượng cho phép: Học sinh, sinh viên, công nhân viên, hộ gia đình.</p></div>
					</div>
					<div class="note-wrapper">
						<div class="payment-icon alert-icon"></div>
						<div class="text"><p>Yêu cầu trả đủ số tiền chi tiêu vào cuối tháng.</p></div>
					</div>
					<div class="note-wrapper">
						<div class="deal-man-icon alert-icon"></div>
						<div class="text"><p>Chúng tôi mong muốn đem lại sự tiện nghi lâu dài cho khách hàng, rất mong được sự hợp tác từ các bạn.</p></div>
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
    formID : 'pay-one-time-service',
    xhrURL : url_base + '/xhr/_register_pay_one_time_service_store/',
    after_submit : {state : 'success', go_to_url: url_base, delay: 4000}
}).restart();
</script>