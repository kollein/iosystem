<?php
include '../config.php';
include '../function.php';
/** parameter in GET
** This list query is important to know your - request
** Special, form.php [this is structure so complex for check, focus at $_GET to know about]
*/
$curAdapter = $_GET['adapter']; // same as cates_id
$curId = $_GET['id']+0; // maybe: postid, catechild_id
$curCatechildid = $_GET['catechild_id']; // catechild_id : from URL
$curSTMT = $_GET['stmt'];// 'new' or 'edit', 'view'
$curBOOK_CASE = $_GET['book_case']; // 'PRODUCT, INFO, WHERE'
$nowId = 0;// SET: in case 'new'
// MAGIC LOAD
include '../autoload.php';
//insert Data into main Interface , html
//init Main Root Information from Autoload Technique
$cms = new Model_sqlDynamic($conn);

/******************************** CHOOSE TABLE ************************************/
$map_remove_column = [];
// CHECK ADAPTER
if( $curAdapter > 12 ){
    $TABLE = $curBOOK_CASE;
    $nowId = $curId;
    $map_remove_column = ['LAST_MODIFIED', 'TIMESTAMP', 'STATUS'];

} elseif( $curBOOK_CASE == 'TRADITIONAL' || $curBOOK_CASE == 'SHARE' || $curBOOK_CASE == 'PRODUCT' || $curBOOK_CASE == 'WHERE' || $curBOOK_CASE == 'INFO' ){

    $TABLE = 'BOOK_'.$curBOOK_CASE;
    $nowId = $curId;
    $map_remove_column = ['TIMESTAMP', 'ORDER_STATUS', 'STATUS'];
    // SEARCH: WE NEED RESET $curCatechildid
    if( $curAdapter == 'search' ){
        $cms->selectQuery("SELECT CATECHILD_ID FROM $TABLE WHERE id = $nowId");
        $curCatechildid = $cms->_rendata[0]['CATECHILD_ID'];
    }

} elseif( $curBOOK_CASE == 'CATECHILD' ){
    $TABLE = CATECHILD;
    $nowId = $curId;

} elseif( $curAdapter > 0 && $curCatechildid == 0 && $curId == 0 && $curBOOK_CASE == 'null' && $curSTMT == 'edit' ){
    $TABLE = CATES;
    $nowId = $curAdapter;

}

/******************************** END CHOOSE TABLE ************************************/

/* FORMAT FORM */
$query = 'SHOW COLUMNS FROM ' . $TABLE;
$cms->selectQuery($query);
$rowColumn = $cms->_rendata;
//REMOVE FIELDs: no need set value
$rowColumn = remove_element_with_value($rowColumn, 'Field', $map_remove_column);
/*
Fetch Data with STATEMENT:
'cates_id' , 'catechild_id' , 'postid'
*/
$where = 'WHERE id = ' . $nowId;
$cms->selectRow($TABLE, $where);
$rowTable = $cms->_rendata[0];
/* NEW STATMENT */
if ($curSTMT == 'new') {
    // REMOVE FIELD: ID
    array_shift($rowColumn); 
}
/* PHRASE STATMENT */
$phraseStatment = array('new'=>'Thêm', 'edit'=>'Sửa', 'view'=>'Xem', 'CATECHILD'=>'chuyên mục con','CATES'=>'chuyên mục chính', 'BOOKS'=>'bài viết', 'ORDER_STORE'=>'đơn hàng');
?>
<script type="text/javascript">
    console.log('<?=$TABLE;?>');
</script>
<div class="boxEdit">
    <div class="heading">
        <?= $phraseStatment[$curSTMT].' '.$phraseStatment[$TABLE]; ?> :: <?=$TABLE;?>
        <button class="uix-button close"><span class="icon gm-icon"></span></button>
    </div>
    <div class="content yt-scrollbar">
    
<?php
foreach ($rowColumn as $row) {
    $column_type = $row['Type'];
    $column_name = $row['Field'];
    if ($column_name == 'DESCRIPTION') {
        /* EDITOR SET HERE */
        $contentEditor = urldecode($rowTable[$column_name]);
        print '
    <div class="divEditor" id="' . $column_name . '">
';
        include 'repo/stack/editor.php';
        print '
    </div>
';
    } elseif ($column_name == 'CART' | $column_name == 'HISTORY') {
        /******************************** EDITOR SET HERE */
        $contentCART = json_decode($rowTable[$column_name], true);
        print '
    <div class="divEditor" id="_' . $column_name . '">
';
        include 'repo/stack/'.strtolower($column_name).'.php';
        print '
    </div>
';
    } elseif ( substr($column_name, -3, 3) == '_ID' && strlen($column_name) > 2 && $column_name !='USER_ID' ) {
        //CATSID , CATECHILD_ID
        print '
        <div class="divSlet">
<select id="' . $column_name . '" '.$selectCateChildisabled.'>
';

/******************************** CATEMAP: MAYBE CATES, CATECHILD WILL BE SHOW IN SELECT TAG*/
$tableCateSelection = str_replace( '_ID', '', $column_name );
$cms->selectRow($tableCateSelection, 'ORDER BY id');
$cateMap = $cms->_rendata;
    if($column_name == 'CATES_ID'){
        $cpSelect = ($curSTMT == 'new') ? $curAdapter : $rowTable[$column_name];

    }elseif($column_name == 'CATECHILD_ID'){
        // ALL CATES : HAS CATECHILD, IF NOT WE NEED CHECK TO SET $cpSelect = 0
        $cpSelect = ($curSTMT == 'new') ? $curCatechildid : $rowTable[$column_name];

    }else{
        // LIST_BOOK_CASE_ID, LIST_PROVINCE_VIETNAME_ID
        $cpSelect = $rowTable[$column_name] ? $rowTable[$column_name] : $cateMap[0]['ID'];
    }
    // SHOW CATEGORY WITH <SELECT>
    foreach ($cateMap as $cate) {
        if ($cate['ID'] == $cpSelect) {
            $selected = 'selected';
        } else {
            $selected = '';
        }

        if ($cpSelect == 0){
            $cate['ID'] = 0;
            $cate['NAME'] = 'NO CATECHILD';
        }else{
            $parentCATES_ID = $cate['CATES_ID'];
        }

        print '<option value="' . $cate['ID'] . '" data-cates-id="'.$parentCATES_ID.'" ' . $selected . '>' . $cate['NAME'] .'</option>';
        if ($cpSelect == 0){ break; }
    }
        print '
</select>
        </div>
';
    } elseif ( substr_count($column_name, 'IMAGE') ) {
        /* SET HERE */
        $contentImage = $rowTable[$column_name];
        print '
    <div class="divImage" id="' . $column_name . '">
        <div class="label">'. $column_name .'</div>
';
        include 'repo/stack/image.php';
        print '
    </div>
';
    } elseif ( substr_count($column_name, 'CONTENT') | $column_name == 'FEATURE' | $column_name == 'DETAILINFO') {
        $statusFormControl = strlen( $rowTable[$column_name] ) > 0 ? 'valued' : '';
        print '
        <div class="divTxr bound-form-control">
    <textarea id="' . $column_name . '" class="form-control '.$statusFormControl.'">' . urldecode($rowTable[$column_name]) . '</textarea>
    <label class="label-place-top">
        <span class="label-title">'.$column_name.'</span>
    </label>
        </div>
        <div id="JSON_CONTENT_ORDER_STORE">'. $rowTable[$column_name] .'</div>
';
    } else {
        if ($curId && $column_name == 'ID') {
            $disableIpt = 'disabled';
        } else {
            $disableIpt = '';
        }
	// auto generate TITLE for NEW item
	if ( $curSTMT === 'new' ) {
	    if ( $column_name === 'TITLE' ) {
	        $rowTable[$column_name] = alpha_numberic_hash(11);
	    } elseif ( $column_name === 'PRICE' ) {
	        $rowTable[$column_name] = 0;
	    } elseif ( $column_name === 'TAG' ) {
	        $rowTable[$column_name] = "jean, shoe, gucci, balenciaga, chanel, pullover, jacket, jumper, sneaker";
	    } elseif ( $column_name === 'HOT_STATUS_TIMESTAMP' ) {
	        $rowTable[$column_name] = _TIMESTAMP;
	    } elseif ( strpos($column_type, 'int') !== false ) {
	        $rowTable[$column_name] = 1;
	    } elseif ( $column_name === 'VIDEO' ) {
	        $rowTable[$column_name] = "";
	    } else {
	    	$rowTable[$column_name] = "...";
	    }
	    
	}
        $statusFormControl = strlen( $rowTable[$column_name] ) > 0 ? 'valued' : '';
        print '
        <div class="divIpt bound-form-control">
    <input id="' . $column_name . '" class="form-control '.$statusFormControl.'" value="' . $rowTable[$column_name] . '" ' . $disableIpt . ' spellcheck="false">
    <label class="label-place-top">
        <span class="label-title">'.$column_name.'</span>
    </label>
        </div>
';
    }
}
?>
    <div class="divActbtn row-nw">
<?php
if($curSTMT != 'view'){
?>
        <button id="submit" data-query='{"statment":"<?= $curSTMT; ?>","table":"<?= $TABLE; ?>"}' class="rc-button rc-green btnAct">SUBMIT</button>
        <button id="cancel" class="rc-button rc-red btnAct">CANCEL</button>
<?php
}
?>
    </div>
    </div>
</div>
<script>
// SET OVERFLOW SCROLL FOR @#panelEditor WHEN CLICK OUT OF @#bwe-WYSIWYG AND VICE VERSA
$('#PanelEditor').on('mousedown', function(event){
    // SCROLL @.content WHEN OUT EDITOR FOCUS
    $(this).find('.content').css('overflow', '');
    // HIDDEN @#bwe-WYSIWYG SCROLL WHEN OUT EDITOR FOCUS
    $('#bwe-WYSIWYG').css('overflow', 'hidden');
    // CLEAR ANCHOR HASH BY EDITOR FOCUS FOR NEXT CLICK AFTER
    location.hash = '';
});
// FORM-CONTROL: invoke
EffectiveComposer.restartFormControl();
// CHECK BEFORE POST TO SERVER
function submitToServer(dataqueryJSON){
    // DATA format: JSON
    var streamInput = {}, c = 0;
    // SYNCHRONOUS LOOP BY EACH JQUERY
    $('.divIpt input, .divSlet select, .divTxr textarea, .divEditor, .divImage').each(function(){c++;
       var name = $(this).attr('id');
       var value = $(this).val();
       // trim "space" or "breakline" at beginning and ending in string
       value = value.replace(/^[ \s]+|[ \s]+$/g, '');
       // replace: because encodeURIComponent still lacking single quote, so Important for MySQL force
        if( name == 'DESCRIPTION' ){
            value = BasicWordEditor.outputData().enOrdecodeQuoteChar('encode');
        }else if( name.substr(-5) == 'IMAGE' ){
            var url_images = '';
            $('._item[data-url-image]').each(function(){
                url_images += ',' + $(this).attr('data-url-image');
            });
            value = url_images.substr(1);
            console.log(value);
        }

        // remove double , single quote in input, textarea fields
        // value = value.replace(/['"]+/g,'');

        // PUSH INTO DATA
        streamInput[name] = value;
    });

    // Finished Json Data
    console.log(streamInput)
    console.log(dataqueryJSON);
    /* INVOKE SAVE & SQL */
    if(dataqueryJSON == 'save'){
        // RESTORE FOR SECURE
        localStorage.setItem( 'editorCMS', JSON.stringify(dataqueryJSON) );

    }else{
        // AJAX RUNNING!
        $.post('ajaxComposer.php', {dataQuery:JSON.parse(dataqueryJSON), suggest:streamInput}).done(function(data){
           console.log(data)
           var patt = /DIE/g;
           if( !patt.test(data) ){
                //REFRESH PAGE AFTER QUERY SQL
                window.location.reload();
                $('.snackMsg').text('Success: <?= $curSTMT; ?> = '+data).removeClass('warningBg successBg').addClass('successBg');
            }else{
                $('.snackMsg').text('Error: <?= $curSTMT; ?>!').removeClass('successBg warningBg').addClass('warningBg');
            }
        });
    }
}
// UPLOAD IMAGE BEFORE SUBMIT FUNCTION
function uploadImageToServer(dataQueryJSON){
    var timer, t = 0,
        items = $('._item[data-image]');
    if ( items.length > 0 ){
        // LOOP @._item : HAS DATA BASE64
        items.each(function(){
            var id_item = $(this).attr('id');
            // QUEUE_NAME = id
            var data_image_full = {"QUEUE_NAME": id_item, "IMAGE": $(this).attr('data-image'), "NAME": $(this).attr('data-name')}
            ImageUploader.sendToServer(data_image_full);
        });
        // RUNNING CHECK @queue in 20 miliseconds
        timer = setInterval( function(){
            t++;
            var state = checkQueueRunning();
            console.log('STATE: ' + state + ' : ' + t);
            if( state ){
                // STOP RUNNING CHECK @queue
                clearTimeout(timer);
                // NOW READY TO SUBMIT
                submitToServer(dataQueryJSON);
            }
        }, 20);
    }else{
        // NO IMAGE LOADING TO UPLOAD, SO DIRECT SUBMIT NOW
        submitToServer(dataQueryJSON);
    }
}
// HEART IN HEART : running check queue
function checkQueueRunning(){
    var queue = ImageUploader.getQueue(), state = false;
    for( var index in queue ){
        if( queue.hasOwnProperty(index) ){
            if( queue[index] == 'waiting' ){
                state = false;
                break;
            }else{
                state = true;
            }
        }
    }
    return state;
}
/* INVOKE FORM TO SQL */
$('#submit').click(function(){
    var dataQueryJSON = $(this).attr('data-query');
    uploadImageToServer(dataQueryJSON);
});
/* HIDE Editor */
function hideBoxEdit(){
    //FULL SCREEN EDITOR: stricted before then below invoke
    $('#PanelEditor,.snackMsg').removeClass('dpBlock');
}
// PRESS: ESC
$('body').keyup(function(event){
    if(event.keyCode == 27){
        hideBoxEdit();
    }
});
// PRESS: BUTTON @#cancel, @.heading
$('.boxEdit .heading, #cancel').click(function(){
    hideBoxEdit();
});
/* SELECT ON CHANGE */
$(function(){
    // INVOKE SELECTED
    selectOnchange();
    // ONCHANGE SELECT
    $('select#CATES_ID').change(function(){
        selectOnchange('change');
    });
});
/* GENERAL FUNCTIONS */
function selectOnchange(eventType){
    var cates_id = $('select#CATES_ID').val();
    var catechild_id = $('select#CATECHILD_ID').val();
    var count_in_case_show = 0;
    if(catechild_id != undefined){
        $('select#CATECHILD_ID option').each(function(){
            var dataCatesid = $(this).attr('data-cates-id');
            if(dataCatesid != cates_id){
                $(this).hide();
                if( eventType == 'change' ){
                    $(this).removeAttr('selected');
                }
            }else{
                $(this).show();
                if( eventType == 'change' && count_in_case_show == 0 ){
                    $(this).attr('selected', '');
                }
                count_in_case_show++;
            }
        });
    }
}
// ENCODE OR DECODE QUOTE CHAR
String.prototype.enOrdecodeQuoteChar = function (type){
    var strOutput = '';
    if(type == 'encode'){
        strOutput = this.replace(/'/g,'%27').replace(/"/g,'%22');
    }else{
        strOutput = this.replace(/%27/g,"'").replace(/%22/g,'"');
    }
    return strOutput;
}
// ENCODE TAG HTML
String.prototype.encodeTagChar = function (){
    var strOutput = this.replace(/</g,'&lt').replace(/>/g,'&gt');
    return strOutput;
}
// LOAD: VIEW ITEM ORDER STORE BY JSON
var $element_view_item_order_store = $('#JSON_CONTENT_ORDER_STORE');
var json_content = $element_view_item_order_store.html();
if( isJsonString(json_content) === true ){
    $.post( '/cms/xhr/_view_item_order_store_by_json.php', { suggest: json_content }).done(function(data){
        $element_view_item_order_store.html(data);
    });
}
</script>