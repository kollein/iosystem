<?php
// GET THIS CATE
$thisCate = getThisCate($cateMap, $curAdapterOrigin, 'name');
//DEFAULT : FIXED
$description = 'Fashion branch.';
$keywords = 'phan official, clothes, watch, shoes, bags';
if( $row ){
    //$row : is fetched by @template.php
    $title = $row['TITLE'];
    $keywords = $row['TAG'].',';
    $description = decodeURI($row['METADESCRIPT'], 0, 0).'phan official, clothes, watch, shoes, bags';
}else{
    $title = 'Phan Official';
}
?>
<!doctype html>
  <html lang="vi,en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0" />
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="<?= URLBASE; ?>/logo.ico" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css?family=Libre+Franklin:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="<?= URLBASE; ?>/css/220418e.css" type="text/css" />
    <script src="<?= URLBASE; ?>/js/220418e.js"></script>
    <title><?=$title;?></title>
    <meta name="description" content="<?=$description;?>" />
    <meta name="keywords" content="<?=$keywords;?>" />
    <link rel="canonical" href="<?=$myUrl;?>" />
    <script>
      //GENERAL VARIABLES
      var url_base = '<?=URLBASE;?>', myUrl = '<?=$myUrl;?>';
      var windowWidth = window.innerWidth,
          windowHeight = window.innerHeight;
    </script>
  </head>
  <body>
    <header data-header-scroll>
      <div class="linear-header-bg"></div>
      <div class="head-container container row">
        <div class="bar3line-wrapper">
          <button class="icon icon-svg bar3line-icon"></button>
        </div>
        <div class="logo-wrapper">
          <a href="<?=URLBASE;?>" class="icon-svg logo-img"></a>
          <div class="thank-you">
            <span class="line">Everything Clothes/shoes/bags/watches 1:1</span>
            <span class="line">Contact us via whatsapp +84 904880708</span>
            <span class="line">Email: phanofficial2014@gmail.com</span>
          </div>
        </div>
        <div class="contact-wrapper">
          <a href="<?=WHATSAPP_PAGE_URL;?>" class="icon icon-svg whatsapp-icon"></a>
        </div>
      </div>
    </header>
    <div class="menu-container" data-toggle-menu>
      <div class="dissmiss-wrapper" data-action-dissmiss></div>
      <div class="menu-wrapper scrolling-content">
        <button class="icon-svg close-btn" title="Close" data-action-dissmiss></button>
        <form class="form-wrapper">
          <input type="text" name="query" class="form-control">
          <button class="search-btn _btn" title="Search">
            <span class="icon-search"></span>
          </button>
        </form>
        <ul class="list-wrapper" data-active-id="<?=$thisCate['ID'];?>">
<?php
foreach ($cateMapRoot as $cate) {

  $urlGoCATE = $cate['DEFINE_URL'] ? $cate['DEFINE_URL'] : URLBASE.'/'.convertAlias($cate['NAME'], true).'/';

?>
          <li class="item" data-id="<?=$cate['ID'];?>">
            <a href="<?=$urlGoCATE;?>" class="link"><?=$cate['NAME'];?></a>
          </li>
<?php
}
?>
        </ul>
      </div>
    </div>
    <div class="minus-header"></div>