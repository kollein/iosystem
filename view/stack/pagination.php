<div class="pagination">
<?php
$page = $mixPagi['page'];$numPage = $mixPagi['num_page'];

$myParamRequest = getParamRequest('p', $myUrl);

if($page > 1){
    $myUrlNow = str_replace($myParamRequest['full'], $myParamRequest['markparam'].'='.($page-1), $myParamRequest['url']);
    print'<a href="'.$myUrlNow.'" class="pagi-button rc-button yt-uix-button">« Trước</a>';
}
for($i=1;$i<=$numPage;$i++){
    $myUrlNow = str_replace($myParamRequest['full'], $myParamRequest['markparam'].'='.$i, $myParamRequest['url']);

    if($i==$page){
        $goPage = '<button class="pagi-button rc-button yt-uix-button" disabled>'.$i.'</button>';
    }else{
        $goPage = '<a href="'.$myUrlNow.'" class="pagi-button rc-button yt-uix-button">'.$i.'</a>';
    }
    echo $goPage;
}
if($page < $numPage){
    $myUrlNow = str_replace($myParamRequest['full'], $myParamRequest['markparam'].'='.($page+1), $myParamRequest['url']);
    print'<a href="'.$myUrlNow.'" class="pagi-button rc-button yt-uix-button">Tiếp theo »</a>';
}
?>
</div>