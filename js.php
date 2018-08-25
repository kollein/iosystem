<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="vi,en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0"/>
    <meta charset="utf-8"/>
    <link rel="shortcut icon" href="http://www.likeart.vn/logo.ico" type="image/x-icon"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://www.likeart.vn/js/main.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<textarea>
<?php

$provinces = explode(',', 'An Giang,Bà Rịa-Vũng Tàu,Bạc Liêu,Bắc Kạn,Bắc Giang,Bắc Ninh,Bến Tre,Bình Dương,Bình Định,Bình Phước,Bình Thuận,Cà Mau,Cao Bằng,Cần Thơ,Đà Nẵng,Đắk Lắk,Đắk Nông,Điện Biên,Đồng Nai,Đồng Tháp,Gia Lai,Hà Giang,Hà Nam,Hà Nội,Hà Tây,Hà Tĩnh,Hải Dương,Hải Phòng,Hòa Bình,Hồ Chí Minh,Hậu Giang,Hưng Yên,Khánh Hòa,Kiên Giang,Kon Tum,Lai Châu,Lào Cai,Lạng Sơn,Lâm Đồng,Long An,Nam Định,Nghệ An,Ninh Bình,Ninh Thuận,Phú Thọ,Phú Yên,Quảng Bình,Quảng Nam,Quảng Ngãi,Quảng Ninh,Quảng Trị,Sóc Trăng,Sơn La,Tây Ninh,Thái Bình,Thái Nguyên,Thanh Hóa,Thừa Thiên - Huế,Tiền Giang,Trà Vinh,Tuyên Quang,Vĩnh Long,Vĩnh Phúc,Yên Bái');



foreach($provinces as $value){
    $i++;
    $stmt = $conn->query("INSERT INTO LIST_PROVINCE_VIETNAM (ord, name) VALUES('$i', '$value') ") or die('FAILED!');
}
?>
</textarea>
<form id="form-getfree">
  First name: <input type="text" name="FirstName" value="Mickey"/><br/>
  Last name: <input type="text" name="LastName" value="Mouse"/><br/>
  
  <div class="g-recaptcha" data-sitekey="6Le_aBcUAAAAAF_szVJg6fvUGNpsXH22OdpYJ1ys"></div>
</form>
<button class="getFromServer">GET</button>
</body>
</html>