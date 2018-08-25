<style>
.toolbarExtra{
    opacity:1;
}
</style>
<div class="row-nw">
<?php
$mixCrazy = array(
    'en',
    'vn',
    'genus');
foreach ($mixCrazy as $v) {
    $n += 1;
    print '
<div class="z col-d3">
<div class="th row"><div class="rl rl' . $v . '">' . $v .
        '</div><div class="dl col-d"></div></div>
';
    $thisCache = json_decode(showCache($v), true);
    foreach ($thisCache as $key => $val) {

        $obj = $v . '__' . $key;
        if ($v == 'genus') {
            $rORt = pickIcache(LANGUAGE_COOKIE, $key);
        } else {
            $rORt = $key;
        }
        print '
<div class="lab row">
    <label>' . $rORt . '</label>
    <input id="' . $obj . '" value="' . $val . '"/>
    <button class="rc-button" onclick="doCache(\'' . $obj . '\')">' .
        pickIcache(LANGUAGE_COOKIE, 'save') . '</button>
</div>
';
    }
    print '
</div>
';
}
?>
</div>
<script>$('.z .lab input').keyup(function(){if(event.keyCode==13){doCache($(this).attr('id'))}});</script>