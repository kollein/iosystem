            <ul class="menu">
<?php
foreach($cateMap as $k => $rowCate){
    if($rowCate['ID']==$curId[0] & $curAdapter == str_replace('-','',GOPOST)){
        $openULChild = 'open';
    }else{
        $openULChild = '';
    }
    $urlCatename = convertAlias($rowCate['NAME'],true);
    $urlGoCATE = URLBASE.'/'.GOCATE.'/'.$urlCatename.'-'.$rowCate['ID'];

    print'<li class="'.$openULChild.'"><a href="'.$urlGoCATE.HTML_EXT.'" title="'.$rowCate['NAME'].'">'.$rowCate['NAME'].'</a>';
    $where = 'WHERE cates_id='.$rowCate['ID'];
    $mainRi->selectRow(CATECHILD,$where);
    $rowCatechild=$mainRi->_rendata;
    if($rowCatechild){
        print'<ul class="menuChild">';
        foreach($rowCatechild as $mk => $rowCatechild){
            print'<li><a href="'.$urlGoCATE.'-'.$rowCatechild['ID'].HTML_EXT.'" title="'.$rowCatechild['NAME'].'">'.$rowCatechild['NAME'].'</a></li>';
        }
        print'</ul>';
    }
    print'</li>';

}

?>
            </ul>
