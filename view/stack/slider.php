<style>
#slider-container{
    position: relative;
}
#slider-wrapper {
    position: relative;
    width: 100%;
    padding-top: 37%;
    overflow: hidden;
}
#slide-holder,#slide-dotguide {
    width: inherit;
    position: absolute;
    top:0;
}
#slide-holder {
    height:100%;
    display: flex;
    display: -webkit-flex;
    flex-wrap: wrap;
    -webkit-flex-wrap: wrap
}
#slide-holder .slide {
    position:absolute;
    height:100%;
    width:100%;
    background-repeat: no-repeat;
    background-size: cover!important;
    order:1;
    -webkit-order:1;
    opacity:0;
    transition: 3s ease;
    -webkit-transition: 3s ease;
    cursor:pointer;
}
#slide-holder .slide img{
    width:100%;
    position: absolute;/*responsive*/
}
@media screen and (min-width: 1280px) {
#slider-container:hover .prev, #slider-container:hover .next{
    opacity:1;
}
}
#slider-container .prev,#slider-container .next{
    background: no-repeat url(image/skin.png);
    width:26px;
    height:46px;
    padding:4px;
    cursor:pointer;
    position:absolute;
    top:initial;
    bottom: calc(50% - 23px);
    opacity:0;
    transition: 1s cubic-bezier(0.39, 0.58, 0.57, 1);
    -webkit-transition: 1s cubic-bezier(0.39, 0.58, 0.57, 1);
}
#slider-container .prev{
    left:10px;
    background-position:-5px -2px;
}
#slider-container .next{
    right:10px;
    background-position:-159px -2px;
}
#slide-dotguide{
    top:initial;
    bottom:10px;
    left: 86px;
}
#slide-dotguide .dot{
    float:left;
    width:21px;
    height:21px;
    margin-right:14px;
    transition: transform 1s ease;
    -webkit-transition: -webkit-transform 1s ease;
    cursor:pointer;
}
#slide-dotguide .dot:first-child{
    margin-top: -4px;
    background:no-repeat url(slideimg/indicator_slide_on.png);
    background-size:contain;
    z-index:1;
}
#slide-dotguide .dot:not(:first-child):after{
    display: block;
    content: '';
    width: 13px;
    height: 13px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    background: #999;
    margin: auto;
}
#slide-dotguide .dot:not(:first-child):hover:after{
    background-color:coral;
}
</style>
  <div id="slider-container">
    <div id="slider-wrapper">
        <div id="slide-holder">
            <div class="slide" data-href="http://www.likeart.vn/danh-muc/handmade-5.html" style="background-image: url(slideimg/fr1.jpg);"></div>
            <div class="slide" data-href="http://www.likeart.vn/danh-muc/tranh-nghe-thuat-4.html" style="background-image: url(slideimg/fr2.jpg);"></div>
            <div class="slide" data-href="http://www.likeart.vn/danh-muc/go-nghe-thuat-3.html" style="background-image: url(slideimg/fr3.jpg);"></div>
            <div class="slide" data-href="http://www.likeart.vn/danh-muc/thu-cong-my-nghe-6.html" style="background-image: url(slideimg/fr4.jpg);"></div>
        </div>
    </div>

        <div class="prev"></div>
        <div class="next"></div>

    <div id="slide-dotguide">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
  </div>
<script src="http://hammerjs.github.io/dist/hammer.min.js"></script>
<script>
/**********BODY SWIPE ON INVOKING: MOBILE*************/
//Init Swipe for Slide @home.php
var mySlider = document.getElementById('slider-wrapper');
if(mySlider){
    var mc = new Hammer(mySlider);
    // listen to events...
    mc.on("swipeleft swiperight tap", function(ev) {
        if(ev.type == 'tap'){
            window.location.href = $('#slide-holder div.slide[order=0]').attr('data-href');
        }else{
            if(ev.type == 'swipeleft'){
                var mode = 'next';
            }else{
                var mode = 'prev';
            }
            modeCarousel(mode);
        }
        return false;
    });
}
</script>
<script>
var myIndex = 0, timerSlide = 0,timerBySecond = 3000;
var xSlide = $('#slide-holder .slide');
var xDot = $('#slide-dotguide .dot');
var dotXpx = parseInt(xDot.css('width')) + parseInt(xDot.css('margin-right'));
$('#slider-container .prev,#slider-container .next,#slide-dotguide .dot').click(function(event){
    event.preventDefault();
    var mode, objClickedDot;
    if( $(this).hasClass('prev') ){
        mode = 'prev';
    }else if( $(this).hasClass('next') ){
        mode = 'next';
    }else{
        objClickedDot = $(this);
    }
    modeCarousel(mode,objClickedDot);
});

function modeCarousel(mode,objClickedDot){
    clearTimeout(timerSlide);
    timerSlide = 0;
    var indexClickedDot;
    if(mode == 'prev'){
        var obj = $('.slide[order="0"]').prev();
        if(obj.attr('class') == undefined){/*PREV at first @.slide */
            obj = $('.slide:last');
        }
        indexClickedDot = mode;
    }else if(mode == 'next'){
        var obj = $('.slide[order="0"]').next();
        if(obj.attr('class') == undefined){/*NEXT at last @.slide */
            obj = $('.slide:first');
        }
        indexClickedDot = mode;
    }else{
        var dotObj = $('.dot');
        var curIndex = dotObj.index(objClickedDot);
        var obj = $($('.slide')[curIndex]);
        timerAtPrNx = 0;
        indexClickedDot = curIndex;
    }
    $('.slide[order="0"]').css({order:1,opacity:0}).attr('order',1);/*HIDE old @.slide*/
    obj.css({order:0,opacity:1}).attr('order',0);/*SHOW new @.slide*/
    carousel(indexClickedDot);/**RE-RUN AUTOSLIDE**/
}
/**DEFAULT-RUN AUTOSLIDE**/
carousel();
function carousel(indexClickedDot) {/*w3schools.com*/
    var i, subClickedDot = 0;
    for (i = 0; i < xSlide.length; i++) {
       $(xSlide[i]).css({opacity:0,order:1}).attr('order',1);
    }
    var myIndexOLD = myIndex - 1;
    if( indexClickedDot != undefined && indexClickedDot > 0 ){
        if ( indexClickedDot > myIndexOLD ) {
            subClickedDot = 1;
        }
        myIndex = indexClickedDot + subClickedDot;

    }else if(indexClickedDot == 'prev'){
        myIndex--;
    }else{
        myIndex++;
    }

    if (myIndex > xSlide.length) {myIndex = 1}
    else if(myIndex <= 0){myIndex = xSlide.length}
    $(xSlide[myIndex-1]).css({opacity: 1,order:0}).attr('order',0);
    /*ANIMATE @.dot*/
    var nowIndex = myIndex - 1;
    if(myIndex == 1){
        nowIndex = 0;
    }
    xDot.css('transform','translateX(0px)');
    var translateXpx = (nowIndex*dotXpx);
    setTimeout(function(){
        $(xDot[0]).css({'transform':'translateX('+translateXpx+'px)'});
        for(var d = 1; d < myIndex; d++ ){
            $(xDot[d]).css({'transform':'translateX(-'+dotXpx+'px)'});
        }
    },0);/*DELAY-TO-ANIMATE*/
    timerSlide = setTimeout(carousel, timerBySecond); // Change image by seconds
}
</script>