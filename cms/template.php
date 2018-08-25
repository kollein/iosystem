<div id="container-fluid" class="row-dc">
  <div class="masthead-container">
    <div class="ct-header row-nw">
        <div class="leftCol">
            <a href="<?=URLBASE;?>/cms"><div class="logo">CMS &copy; v0.7.17</div></a>
        </div>
        <div class="bigCol">
            <div class="search">
                <form method="get">
                    <input name="adapter" type="hidden" value="search">
                    <input name="q" class="b-s" placeholder="Search anything...">
                </form>
            </div>
        </div>
    </div>
<?php
if( in_array( $curAdapter, array('search', 50, 60) ) ){
    $validAdd = 'disabled';
    if( $curAdapter != 'search' & $curAdapter != 50 ){
        $validEdit = 'disabled';
        $validDelete = 'disabled';
    }
}
?>
    <div class="ct-toolbarCMS row-nw">
        <div class="leftCol">
            <div class="toolbarCMS row-nw">
                <button id="add" <?=$validAdd;?> class="rc-button rc-red add" data-tooltip="Create new item">Add</button>
            </div>
        </div>
        <div class="bigCol row-nw">
            <div class="toolbarCMS col-d3 row-nw">
                <button id="edit" <?=$validEdit;?> class="rc-button" data-tooltip="Checked before edit (un-check meaning edit parent this)">Edit</button>
                <button id="delete" <?=$validDelete;?> class="rc-button" data-tooltip="Checked before delete"><span class="delete actionButton yt-uix-button-icon"></span></button>
            </div>
            <div class="toolbarExtra col-d3 row-nw">
                <input type="text" id="lang__" placeholder="System Cache"/>
                <button class="rc-button" onclick="reCache('lang__', 'add')">Add</button>
                <button class="rc-button" onclick="reCache('lang__', 'delete')">Delete</button>
            </div>
            <div class="infoExtra col-d3 row-nw">
                <div class="label" data-tooltip="Count number of this">All:</div>
                <div class="amount"></div>
            </div>
        </div>
    </div>
  </div>
<div class="ct-maincore row-nw">
    <div class="leftCol leftCol_content yt-scrollbar4">
        <ul class="list">
<?php
/* SHOW ALL CATES TO CREAT MENU LEFT */
$cms->selectRow(CATES, 'ORDER BY ord');
$rowCate = $cms->_rendata;
//LI.ACTIVE
foreach( $rowCate as $row ){
    if( $curAdapter == $row['ID'] ){
        $li_active = 'active';
    }else{
        $li_active = '';
    }
    print'<a href="'.URLBASE.'/cms/?adapter='.$row['ID'].'"><li class="'.$li_active.' "><p>'.$row['NAME'].'</p></li></a>';
}
?>
        </ul>
    </div>
    <div class="bigCol bigCol_content row-dc">
        <div class="bCol-scroll Tm">
<?php
/* $TABLE */
if( $curAdapter > 12 ){
    $TABLE = $thisCate['BOOK_CASE'];
    $BOOK_CASE = $TABLE;
}else{
    // SHOW BOOK OR CATECHILD
    if( $curCatechildid > 0 ){
        $TABLE = 'BOOK_'.$thisCate['BOOK_CASE'];
        $BOOK_CASE = $thisCate['BOOK_CASE'];
    }else{
        $TABLE = CATECHILD;
        $BOOK_CASE = $TABLE;
    }
}
/**************************************** MAIN REPO ****************************************/
include'repo/repository.php';

/**************************************** END MAIN REPO ****************************************/

?>
        </div>
    </div>
</div>
    <div id="PanelEditor"><div class="loader loading"></div></div>
    <div class="snackMsg"></div>
</div>
<script>
/* HIGHLIGHT : LINE TICKED */
var collection_checkbox_true = {};
function collectCheckboxTrue(el_container, status){
    // CHECK @status
    var checkbox_id = el_container.getAttribute('data-id'),
        book_case = el_container.getAttribute('data-book-case'),
        indexCollection = book_case + checkbox_id;
    if( status == 1 ){
        collection_checkbox_true[indexCollection] = {"id": checkbox_id, "book_case": book_case};
    }else{
        delete collection_checkbox_true[indexCollection];
        console.log('DEL' + indexCollection);
    }
    console.log(collection_checkbox_true);
}
// CHECKBOX : invoke
EffectiveComposer.checkStatusOnElement('.checkbox-container .checkbox', collectCheckboxTrue);
/* DELETE DIRECT TO AJAX */
$('#delete').click(function(){
    if(Object.keys(collection_checkbox_true).length > 0){
        var confirmDelete = confirm("Hãy bình tĩnh trước khi xóa!");
        if( confirmDelete ){

            var dataQueryJSON = {'statment':'delete','table':'<?=$TABLE?>'}
            $.post('ajaxComposer.php',{dataQuery:dataQueryJSON, suggest: collection_checkbox_true }).done(function(data){
               //console.log(data)
               if(data!=''){

                    window.location.reload();//REFRESH PAGE AFTER QUERY SQL

                    $('.snackMsg').text('Success: <?= $curSTMT; ?> = '+data).removeClass('warningBg successBg').addClass('successBg');
                }else{$('.snackMsg').text('Error: <?= $curSTMT; ?>!').removeClass('successBg warningBg').addClass('warningBg');}
            });
         }
     }else{
        alert("Hãy chọn một mẫu để xóa!");
     }
});
/* 
OPEN PANEL EDITOR 
*/
// EDIT, ADD
$('#add, #edit').click(function(){
    var id = 0, book_case = null, statment;
    if( $(this).attr('id') == 'edit' ){
        statment = 'edit';
        // FIRST ELEMENT IN @collection_checkbox_true, return -> INDEX
        var firstElementCheckBox_index = Object.keys(collection_checkbox_true)[0];
        if( firstElementCheckBox_index ){
            id = collection_checkbox_true[firstElementCheckBox_index]['id'];
            book_case = collection_checkbox_true[firstElementCheckBox_index]['book_case'];
        }
        
    }else{
        statment = 'new';
        id = 0;
        book_case = '<?=$BOOK_CASE;?>';
    }
    openPanelEditor(statment, id, book_case);
});
// VIEW
$('.cateChildLine').dblclick(function(){
    //PREVIEW
    var stmt = 'view', el_checkbox_container = $(this).find('.tick .checkbox-container');
    var id = el_checkbox_container.attr('data-id'),
        book_case = el_checkbox_container.attr('data-book-case');
    openPanelEditor(stmt, id, book_case);
});
// FUNCTION FOR INVOKE
function openPanelEditor(stmt, id, book_case){
    // RESET: for @form.php easily to check
    id = id ? id : 0;
    book_case = book_case ? book_case : null;
    var url = 'form.php?stmt=' + stmt + '&adapter=<?=$curAdapter;?>&catechild_id=<?=$curCatechildid;?>&id=' + id + '&book_case=' + book_case;
    console.log(url)
    $('#PanelEditor').addClass('dpBlock').load(url);
}
// SYSCACHE MySQL
function doCache(obj){
    var timer = 0;
    var mixCP = obj.split('__');//"__" is located by @cfg.php
    var nv = encodeURIComponent( $('#'+obj).val() );
    $('#recycle').load('process.php?opt=genyouset&crazy='+mixCP[0]+'&prop='+mixCP[1]+'&nv='+nv);
    $('#'+obj).next().addClass('atv-rl');
    clearTimeout(timer);
    timer = setTimeout(function(){
        $('#'+obj).next().removeClass('atv-rl');
    },2000);
}
function reCache(obj, action){
    var prop = encodeURIComponent( $('#'+obj).val() );
    console.log(prop+' '+action)
    $('#recycle').load('process.php?opt=genyouset&crazy=lang&prop='+prop+'&action='+action);
    setTimeout(function(){window.location.reload()}, 1000);
}
// Scroll: Invoke @header
var lastScrollTop = 0;
$('.bCol-scroll').scroll(function() {
	trackScrollTop = $(this).scrollTop();
	if( $(this).scrollTop() > 0 ){
        $('.ct-toolbarCMS').addClass('G-ct-toolbarCMS');
	}else{
		$('.ct-toolbarCMS').removeClass('G-ct-toolbarCMS');
	}
    // cached
    lastScrollTop = trackScrollTop;
});
// UPDATE: *STATUS
function updateStatusFromToggle(el_container, status){
    // GET DATA ATTRIBUTE ON ELEMENT CONTAINER
    var dataId = el_container.getAttribute('data-id');
    var dataField = el_container.getAttribute('data-field');
    // MAKING JSON BEFORE SEND
    //console.log(status+':'+dataId);
    var dataqueryJSON = {"statment":"edit","table":"<?=$TABLE;?>"}
    var streamInput = {"ID": dataId}
        // NOTE: 1 -> on , 0 -> off : Meaning in MySQL
        streamInput[dataField] = status == 1 ? 1 : 0;
    //console.log(JSON.stringify(streamInput)+':'+dataqueryJSON);
    $.post('ajaxComposer.php', {dataQuery:dataqueryJSON, suggest:streamInput} ).done(function(data){
       //console.log(data)
       if(data!=''){
            $('.snackMsg').text('Success: <?= $curSTMT; ?> = '+data).removeClass('warningBg successBg').addClass('successBg');
        }else{
            $('.snackMsg').text('Error: <?= $curSTMT; ?>!').removeClass('successBg warningBg').addClass('warningBg');
        }
        // HIDE @.snackMsg ALERT PANE
        /*setTimeout(function(){
            $('.snackMsg').removeClass('warningBg successBg');
        }, 3000);*/
    });
}
// TOOGLE-BUTTON : invoke
EffectiveComposer.checkStatusOnElement('.toggle-container .toggleBar', updateStatusFromToggle);
// TOOLTIP : invoke
EffectiveComposer.restartTooltip();
/*
This snippet process info from repo/name.php return value
APPEND number row into @.infoExtra
*/
$('.infoExtra .amount').text('<?=number_format($number_item);?>');
</script>