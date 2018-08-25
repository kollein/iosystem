<div class="row">
<?php
if($contentCART){
    foreach($contentCART as $id => $v){
        $sumCash += str_replace(',', '', $v[0]['price'])*$v[0]['amount'];
        $idItem = str_replace('_','',$id);
?>
<div class="col-d41 frame-sideutm row-nw">
    <div class="cart-cover cover">
        <a target="_blank" href="<?=URLBASE.'/'.GOPOST.'/'.$idItem;?>"><img src="<?=$v[0]['image'];?>"></a>
    </div>
    <div class="cart-info info">
        <div class="title">
            <a target="_blank" href="<?=URLBASE.'/'.GOPOST.'/'.$idItem;?>"><?=$v[0]['title'];?></a>
        </div>
        <div class="price"><span><?=$v[0]['price'];?></span><span class="m-unit-currency"><?=pickIcache('genus', 'unit_currency');?></span></div>
        <div class="price"><span>Số lượng: </span><span><?=$v[0]['amount'];?></span></div>
    </div>
</div>
<?php
    }
    print'<div class="col-d41 frame-sideutm"><span class="sum-cash"><span>Tổng cộng: </span>'.number_format($sumCash).pickIcache('genus', 'unit_currency').'</span></div>';
}else{
    print'<p style="line-height: 42px;color:#ccc;">...CART is empty!</p>';
}
?>
</div>