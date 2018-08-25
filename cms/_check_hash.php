<?php
$administrator = false;
if( $user_data['GROUP_ID'] !== 6 ){
?>
<!-- <script>deleteCookie('u');</script> -->
<?php
}else{
	$administrator = true;
}
?>