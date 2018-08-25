<div id="_imageLoader">
  <div class="image-loader-wrapper row">
    <div class="_item">
      <input name="image" type="file" multiple/>
    </div>
<?php
$images = explode(',', $contentImage);
foreach( $images as $image ){
  if( $image ){
?>
    <div class="_item" data-url-image="<?=$image;?>">
      <img src="<?=$image;?>"/>
      <div class="_item-delete" onclick="ImageUploader.removeImageOnServer('<?=$image;?>', this, '<?=$TABLE;?>', '<?=$column_name;?>')"></div>
    </div>
<?php
  }
}
// SOME INFO BEFORE CONFIG UPLOAD
if( substr_count( $column_name, 'BANNER' ) ){
  $imageMaxWidth = 1440;
}else{
  $imageMaxWidth = 640;
}
?>
  </div>
</div>
<script>
!function(a, b) {
  'use strict';
  var c, f, el_image_loader, el_input_file, d = a.document;
  b = function() {
      return {
        addClass: function(el, className){
            if (el.classList)
              el.classList.add(className);
            else
              el.className += ' ' + className;
        },
        removeClass: function(el, className){
            if (el.classList)
              el.classList.remove(className);
            else
              el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
        },
        show: function(el){
            el.style.display = "block";
        },
        removeElement: function(el){
            el.parentNode.removeChild(el);
        }
      }
  }
  c = function() {
      var options = {
            imageMaxWidth: 640,
            "id_image_container": "_imageLoader",
            "class_image_loader": ".image-loader-wrapper"
          },
          queue = {}
      return {
        config: function(opt){
          for( var key in opt ){
            options[key] = opt[key];
          }
        },
        invokeNow: function(){
            // CONTAINER
            f = d.getElementById(options.id_image_container);
            el_image_loader = d.querySelector(options.class_image_loader);
            el_input_file = f.querySelector('input[type="file"]');
            el_input_file.addEventListener('change', function(event){
              ImageUploader.readFile(this.files);
            });
        },
        readFile: function(files) {
            //LOOP FOR READ EVERY
            for (var i = 0; i < files.length; i++) {
              (function(file, i) {
                // SIZE IMAGE < 4Mb (4*1024*1024)
                if ( file.size < 4194304 ){
                  var qualityJPEG = file.size > 500000 ? 0.8 : 0.9;
                  var fullname = file.name;
                  var nameImg = fullname.split(".");
                  var FR = new FileReader();
                  FR.onload = function(e) {
                    //CACHING DATA-BASE64 IMG
                    var dataBase64Origin = e.target.result;
                    var id = new Date().getTime() + i;
                    var id_item = ':ImageUploader_item' + id;
                    var id_canvas = ':ImageUploader_canvas' + id;
                    //PREVIEW TO GET WIDTH-HEIGHT FOR SET CANVAS W-H BEFORE UPLOAD : IMPORTANT
                    var el_canvasImage = d.createElement('canvas');
                        el_canvasImage.setAttribute('id', id_canvas);
                    var ctx = el_canvasImage.getContext("2d");

                    var el_Image = d.createElement('img');
                        el_Image.setAttribute('src', dataBase64Origin);

                    var el_Delete = d.createElement('div');
                        el_Delete.setAttribute('class', '_item-delete');
                        el_Delete.addEventListener('mousedown', function(){
                          var url_image= this.parentNode.getAttribute('data-url-image');
                          // ONLY REMOVE THIS ELEMENT, BECAUSE IT IS A LOADING VIEW
                          // SO WE DONT NEED REMOVE FILE ON SERVER
                          this.parentNode.remove();
                        });

                    var el_boundImage = d.createElement('div');
                        el_boundImage.classList.add('_item');
                        el_boundImage.setAttribute('id', id_item);
                        el_boundImage.setAttribute('data-name', nameImg[0]);

                        el_boundImage.appendChild(el_Image);
                        el_boundImage.appendChild(el_Delete);

                        el_image_loader.appendChild(el_boundImage);

                    //CANVAS INVOKE : RESET CANVAS FOR DRAW NEW
                    ctx.clearRect(0, 0, el_canvasImage.width, el_canvasImage.height);
                    /*
                    IMG: FOR GET WITH HEIGHT
                    or however you get a handle to the IMG
                    */
                    var width = 0;
                    var height = 0;
                    var img = new Image();
                        img.src = dataBase64Origin;
                    img.onload = function() {
                        width = this.width;
                        height = this.height;
                        console.log(width + ' x ' + height);
                        //RESET CANVAS WIDTH - HEIGHT
                        var standardWidthImg = options.imageMaxWidth ? options.imageMaxWidth : width;
                        if (width > standardWidthImg) {
                          var percentStandardWidth = Math.floor((standardWidthImg * 100) / width);
                          width = standardWidthImg;
                          height = Math.floor((percentStandardWidth * height) / 100);
                          var hasResizeInfo = 'Has Resize';
                        } else {
                          var hasResizeInfo = '';
                        }
                                      //::: EXTRA - SHOW INFO IMG
                                      /*$('#hasResizeInfo').text(hasResizeInfo);
                                      $('#sizeImgInfo').text('Size: '+width+' x '+height);*/
                        //DRAW CANVAS
                        el_canvasImage.width = width;
                        el_canvasImage.height = height;
                        ctx.drawImage(img, 0, 0, width, height);
                                      //::: EXTRA - IMG: WATERMARK
                                      /*if( $("#checkWTM").is(':checked') ){
                                          var imgWatermark = d.getElementById("watermark");
                                          ctx.drawImage(imgWatermark, width-210, height-20, 200, 22);
                                      }*/
                        //CHECK CANVAS THEN HIDE img#imagePreview
                        var dataBase64Canvas = el_canvasImage.toDataURL('image/jpeg', qualityJPEG); //(type-jpeg, quality)
                        if (dataBase64Canvas) {
                          // SET DATA INTO DIV ATTRIBUTE data-image
                          el_boundImage.setAttribute('data-image', dataBase64Canvas);
                        }
                        //ANOUNCEMENT
                        console.log('CANVAS-IMAGE HAS LOADED: ' + nameImg[0]);
                    }
                  }
                  //FR: Iterator :: DEFAULT BY BROWSER
                  FR.readAsDataURL(file);
                }else{
                  alert('REQUIRE: SIZE IMAGE MUST LESS THAN 1Mb');
                }
              })(files[i], i);
            }
        },
        getQueue: function(){
            return queue;
        },
        queueAjax: function(queueName, status){
            // PUSH INTO QUEUE OBJECT
            queue[queueName] = status;
            console.log('queue NOW:');
            console.log(queue);
            return queue;
        },
        sendToServer: function(streamInput){
            // streamInput: {QUEUE_NAME, ...}
            // PUSH QUEUE
            ImageUploader.queueAjax(streamInput['QUEUE_NAME'], 'waiting');
            // CALL AJAX POST
            ImageUploader.postAjax('repo/stack/_image/upload.php', JSON.stringify(streamInput), function(data){
              if( data ){
                // DATA RESPONSE : JSON {queue_name, url_mage}
                console.log('Upload complete!'+ data);
                // MAKE data is OBJECT (JSON DATA)
                data = JSON.parse(data);
                // SET @data-url-image ATTRIBUTE FOR DIV ITEM
                d.getElementById(data['QUEUE_NAME']).setAttribute('data-url-image', data['URL_IMAGE']);
                // UPDATE @queue
                ImageUploader.queueAjax(data['QUEUE_NAME'], 'done');
              }else{
                console.log('Upload failed!');
              }
            });
        },
        removeImageOnServer: function(url_image, el, table, column_name){
            // REMOVE THIS ELEMENT
            el.parentNode.remove();
            // MAKING DATA BEFORE SEND
            var dataQuery = {"URL_IMAGE": url_image, "TABLE": table, "COLUMN_NAME": column_name}
            // CALL AJAX POST
            ImageUploader.postAjax('repo/stack/_image/removeImage.php', JSON.stringify(dataQuery), function(data){
              if( data ){
                console.log('Remove complete!'+ data);
              }else{
                console.log('Remove failed!');
              }
            });
        },
        postAjax: function(serverFile, dataSuggest, callback){
            // console.log(dataSuggest);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open("POST", serverFile, true);
            // METHOD POST IS NEEDED: HEADER REQUEST
            xmlHttp.setRequestHeader("Content-type", "application/json");
            xmlHttp.onreadystatechange = function() {
                if ( xmlHttp.readyState == XMLHttpRequest.DONE ){
                    if(xmlHttp.status == 200){
                        console.log('Response: ' + xmlHttp.responseText );
                        callback(xmlHttp.responseText);
                    }else{
                        console.log('Error: ' + xmlHttp.statusText )
                    }
                }
            }
            xmlHttp.send(dataSuggest);
        }
      }
  }
  // Init: 'ImageUploader', 'BWE_f' Contructors as OBJECT OF WINDOW
  // MAIN THREADS
  a.ImageUploader = new c;
  // FUNCTIONS SUPPORT
  a.BWE_f = new b;
}(this);
// CONFIG OPTIONS
ImageUploader.config({
  imageMaxWidth : <?=$imageMaxWidth;?>
});
// INVOKE
ImageUploader.invokeNow();
</script>