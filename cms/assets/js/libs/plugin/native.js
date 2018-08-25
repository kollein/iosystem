function current_timestamp() {
    var d = new Date();
    return d.getTime();
}
function isJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function doubleCharTime(x) {
    return (x < 10 ? '0' + x : x);
}
/**
 * Number.prototype.format(n, x, s, c)
 *
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
12345678.9.format(2, 3, '.', ',');  // "12.345.678,90"
123456.789.format(4, 4, ' ', ':');  // "12 3456:7890"
12345678.9.format(0, 3, '-');       // "12-345-679"
 */
Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
// COOKIE FLOOT: readCookie, deleteCookie
function readCookie(name){
  var nameEQ=name+"=";
  var ca=document.cookie.split(';');
  for(var i=0;i<=ca.length-1;i++){
    var c=ca[i];
        while(c.charAt(0)==' '){c=c.substring(1,c.length);}//Important in Many Cookies
    if(c.indexOf(nameEQ)==0){return c.substring(nameEQ.length,c.length);}
  }
  return null;
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function deleteCookie(name) {
  document.cookie = name + '=;path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}
// SHOW LOADER
function make_loader_icon_html(size, stroke_width){
  size = size ? size : '100%';
  stroke_width = stroke_width ? stroke_width : 6;
  // INIT HTML
  var loader_str_html  = '<div class="loader" style="width:' + size + '">';
      loader_str_html += '<svg class="circular" viewBox="25 25 50 50">';
      loader_str_html += '<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="' + stroke_width + '" stroke-miterlimit="10"/>';
      loader_str_html += '</svg>';
      loader_str_html += '</div>';
  return loader_str_html;
}
// BIND BUTTON ADD-CART : REQUIRE FORK:Cart_Invoke, INIT BEFORE
function bind_btn_add_cart(iterators){
    // BUTTON ADD CART
    var iterators = iterators ? iterators : '.__btn_add_cart';
    $(iterators).on('mousedown', function(event){
        event.stopPropagation();
        cart_side_box.addCart(this);
    });
}
/***
This is a Composer !function (JS+CSS)
Call method : Contructor.Method;
***/
!function(a, b) {
  'use strict';
  var c, d = a.document;
  c = function() {
    var options = {
            cls: {
              "tooltip_container": "tooltip-container",
              "tooltip_text": "tooltip-text",
              "tooltip_icon_wrapper": "tooltip-icon-wrapper",
              "tooltip_icon": "tooltip-icon"
            }
    }
    return {
      /* TOOLTIP */
      restartTooltip: function (){
          var el_tooltip = d.createElement('div'),
              el_body = d.getElementsByTagName('body')[0],
              offsetTooltip = {}, tooltipText, timeOut;
              el_tooltip.setAttribute('class', options.cls.tooltip_container);
              el_tooltip.innerHTML = '<div class="' + options.cls.tooltip_text + '"></div><div class="' + options.cls.tooltip_icon_wrapper + '"><div class="' + options.cls.tooltip_icon + '2 ' + options.cls.tooltip_icon + '"></div><div class="' + options.cls.tooltip_icon + '1 ' + options.cls.tooltip_icon + '"></div></div>';
          el_body.appendChild(el_tooltip);
          var elements_is_hover = d.querySelectorAll('[data-tooltip]');
          for (var i = 0; i < elements_is_hover.length; i++) {
            // get text to check
            tooltipText = elements_is_hover[i].getAttribute('data-tooltip');
            // console.log(tooltipText);
            if ( tooltipText ) {
              // MOUSE-LEAVE
              elements_is_hover[i].addEventListener('mouseleave', function(event){
                event.stopPropagation();
                event.preventDefault();
                // CLEAR OLD TIMEOUT
                clearTimeout(timeOut);
                el_tooltip.classList.remove('show');

              });
              // MOUSE-ENTER
              elements_is_hover[i].addEventListener('mouseenter', function(event){
                event.preventDefault();
                // event.stopPropagation();
                // Cache to @curThis to force inside setTimeout
                var curThis = this,
                    offset = this.getBoundingClientRect();
                // DELAY BEFORE SHOW TOOLTIP
                timeOut = setTimeout(function(){

                  tooltipText = curThis.getAttribute('data-tooltip');

                  // UPDATE TEXT : to get actual-width of TOOLTIP
                  var el_text = d.querySelector('.'+ options.cls.tooltip_text);
                      el_text.textContent = tooltipText;

                  // GET OFFSET OF HOVER-ELEMENT
                  offsetTooltip.x = offset.left;
                  offsetTooltip.y = offset.top;

                  // CALCULATE : exceed width of substraction between TOOLTIP & HOVER-ELEMENT
                  var el_tooltip_width = el_tooltip.offsetWidth;
                  var el_is_hover_width = offset.width;
                  offsetTooltip.x = offsetTooltip.x - (el_tooltip_width - el_is_hover_width ) / 2; 

                  // RESET & SHOW TOOLTIP
                  el_tooltip.style.left = offsetTooltip.x + 'px';
                  el_tooltip.style.top = (offsetTooltip.y + curThis.offsetHeight + 2) + 'px';
                  el_tooltip.classList.add('show');
                
                }, 350);

              });
            }
          }
      },
      /* RIPPLE WAVE */
      restartRippleWave: function(){
        var _iterator = d.querySelectorAll('[data-ripple]');
        for( var i in _iterator ){
          if( _iterator.hasOwnProperty(i) ){
            // MOUSEDOWN EVENT ON ELEMENT
            _iterator[i].addEventListener('mousedown', function(event){
              // ASSIGN LEXICAL @this
              var _self = this;
              // AVOID DUPLICATE CLICK ON @.ripple
              var old_el_ripple = _self.querySelector('.ripple');
              if( old_el_ripple ){
                _self.removeChild(old_el_ripple);
              }
              // FIND POSITION OF @this
              /*
                Note: clientX, clientY: get position with screen-captured as what you see on
              */
              var offs = _self.getBoundingClientRect(),
                  x = event.clientX - offs.left,
                  y = event.clientY - offs.top,
                  adjacent_side = (offs.width - x > offs.width / 2) ? offs.width - x : x,
                  opposite_side = (offs.height - y > offs.height / 2) ? offs.height - y : y,
                  hypothenuse_side = Math.sqrt(Math.pow(adjacent_side, 2) + Math.pow(opposite_side , 2)) + 1;
              // CREATE @.ripple WRAPPER
              var el_ripple = d.createElement('div');
                  el_ripple.setAttribute('class', 'ripple');
                  _self.appendChild(el_ripple);
              // Wrapped @.rippleWave inside @this
              _self.style.position = "relative";
              // CREATE @.rippleWave inside @.ripple
              var el_rippleWave = d.createElement('div');
                  el_rippleWave.setAttribute('class', 'rippleWave');
              // MAKING STYLE FOR ANIMATION
              var cssString = 'background: ' + _self.getAttribute('data-ripple') + ';width: ' + hypothenuse_side + 'px;height: ' + hypothenuse_side + 'px;left: ' + (x - (hypothenuse_side/2)) + 'px;top: ' + (y - (hypothenuse_side/2)) + 'px;transform: scale(2);';
              el_ripple.appendChild(el_rippleWave);
              // ANIMATION NOW!
              setTimeout(function(){
                // REWRITE ALL PROPERTY: STYLE INLINE
                el_rippleWave.style.cssText = cssString;
              }, 0);
              // REMOVE RIPPLE WHEN RIPPLEWAVE EFFECTIVE DONE!
              el_rippleWave.addEventListener("transitionend", function(event){
                // FADE OUT RIPPLE BEFORE REMOVE
                el_ripple.style.opacity = 0;
                el_ripple.style.transition = 'opacity 200ms linear';
                // REMOVE BY DELAY TO SEE EFFECT
                setTimeout(function(){
                    // RE-SELECTOR TO AVOID ERROR REMOVE ON DIFFERENT NODE 
                    var el_ripple_has_appended = _self.querySelector('.ripple');
                    if( el_ripple_has_appended ){
                      _self.removeChild(el_ripple_has_appended);
                    }
                }, 200);
              });
            });
          }
        }
      },
      /* FORM CONTROL */
      restartFormControl: function(){
        var iterator_form_control = d.querySelectorAll('.form-control');
        for( var i in iterator_form_control ){
          if( iterator_form_control.hasOwnProperty(i) ){
            // FOCUS
            iterator_form_control[i].addEventListener('focus', function(event){
              if( this.value ){
                this.classList.remove('error');
                this.classList.remove('valued');
              }
            });
            // FOCUSOUT
            iterator_form_control[i].addEventListener('focusout', function(event){
              if( this.value ){
                this.classList.remove('error');
                this.classList.add('valued');
              }else{
                this.classList.remove('valued');
              }
            });
          }
        }
      },
      /* EFFECT PAPER RIPPLE */
      showPaperRipple: function(el_container, status, eventType){
        var myRipple = el_container.querySelector('.paper-ripple'), timer = 0;
        // CHECK EVENT TO SHOW OR HIDE
        if( eventType == 'mousedown' ){
          clearTimeout(timer);
          timer = 0;
          myRipple.style.opacity = 1;
          // SET SCALE BY parentNode
          var myRipple_parent_height = myRipple.parentNode.getBoundingClientRect().height,
              scale_n = 1;
          if( myRipple_parent_height == 16 ){
            scale_n = 2.5; 
          }
          myRipple.style.transform = 'scale(' + scale_n + ')';
        }else{
          timer = setTimeout(function(){
            myRipple.style.opacity = 0;
            myRipple.style.transform = 'scale(0)';
          }, 100);
        }
      },
      /* CHECKBOX, RADIO, TOOGLE-BUTTON */
      checkStatusOnElement: function(strSelector, callback){
          var el_checkbox_container = d.querySelectorAll(strSelector);
          for( var index in el_checkbox_container ){
              // CHECK HAS PROP
              if ( el_checkbox_container.hasOwnProperty(index) ){
                  // MOUSEDOWN ON
                  el_checkbox_container[index].addEventListener('mousedown' , function(event){
                      event.preventDefault();
                      // WITH @status: 0 -> off, 1 -> on
                      var el_container = this.parentNode,
                    status = 0;
                      if( el_container.getAttribute('aria-check') == 'true' ){
                          status = 0;
                          el_container.setAttribute('aria-check', 'false');
                      }else{
                          status = 1;
                          el_container.setAttribute('aria-check', 'true');
                      }
                      // SHOW EFFECT RIPPLE
                      EffectiveComposer.showPaperRipple(el_container, status, event.type);
                      // INVOKE CALLBACK
                      if( callback ){
                          // TRANSFER : el_container, status TO CALLBACK
                          callback(el_container, status);
                      }
                  });
                  // MOUSEUP ON
                  el_checkbox_container[index].addEventListener('mouseup' , function(event){
                      EffectiveComposer.showPaperRipple(this.parentNode, status, event.type);
                  });
                  // MOUSELEAVE ON
                  el_checkbox_container[index].addEventListener('mouseleave' , function(event){
                      EffectiveComposer.showPaperRipple(this.parentNode, status, event.type);
                  });
              }
          }
      }

    }
  }
  // Init: Contructors as OBJECT OF WINDOW
  a.EffectiveComposer = new c;
}(this);
/*
PLUGIN : CART : AJAX JQUERY
NOTICE: NEED CONTENT LOADED BEFORE INVOKE BELOW METHOD
*/
!function(a, b) {
  'use strict';
  var c, d = a.document;
  c = function(opts) {
    var options = {
      containerID: "",
      xhrURL: "",
      snippetID: ""
    },
    data_cart, el_list_box, collection_cart_checkbox, pointer;
    // UPDATE OPTIONS
    for( var i in opts ){
      options[i] = opts[i]
    }
    // RETURN MAP
    return {
        restart: function(){
            // SET POINTER AS CONSTRUCTOR OF @c
            pointer = this;
            // SET CONTAINER AS DOM
            el_list_box = d.getElementById(options.containerID);
        },
        getDataCart: function(){
            // RETURN JSON
            return localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : {};
        },
        createScriptSnippet: function(snippet_content, id){
            var body = d.getElementsByTagName('body')[0],
                old_child = d.getElementById(id);
            if( old_child ){
                old_child.parentNode.removeChild(old_child);
            }
            var el_script_tag = d.createElement('script');
                el_script_tag.setAttribute('id', id);
                el_script_tag.text = snippet_content;
            body.appendChild(el_script_tag);
        },
        showCart: function(){
            // SHOW CART
            el_list_box.classList.add('block');
            el_list_box.innerHTML = make_loader_icon_html('32px');
            data_cart = pointer.getDataCart();
            if( data_cart ){
                $.post( options.xhrURL , {suggest: data_cart} ).done(function(data){
                    // UPDATE
                    pointer.update_number_item_cart();
                    // SHOW CART NOW!
                    el_list_box.innerHTML = data;
                    // CREATE SNIPPET FROM SERVER
                    var el_snippet = d.querySelector('[data-id="' + options.snippetID + '"]');
                    pointer.createScriptSnippet(el_snippet.innerHTML, options.snippetID);
                });
            }else{
                console.log(data_cart);
            }
        },
        addCart: function(el, statement){
            // @data_item : id=s_12|amount=1
            var data_item = el.getAttribute('data-cart'),
                data_item_ready = {},
                id_cached;
            var stack_data_item = data_item.split('|');
            for( var i in stack_data_item ){
                var stack_n_cached = stack_data_item[i].split('=');
                if( i == 0 ){
                    // CACHED ID ex: [s_12]
                    id_cached = stack_n_cached[1];
                }
                // FROM @id -> @amount -> ... END
                data_item_ready[stack_n_cached[0]] = stack_n_cached[1];
                
            }
            // FETCH DATA FROM @localStorage
            var data_cart = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : {"none":0};
            // CASE: ITEM HAS ADDED IN CART BEFORE, WE NEED INCREASE OR UPDATE AMOUNT ONLY
            if( data_cart[id_cached] ){
                var amount = parseInt(data_item_ready['amount']) + parseInt(data_cart[id_cached][0]['amount'])
                if( statement == 'update' ){
                    amount = parseInt(data_item_ready['amount']) ? parseInt(data_item_ready['amount']) : 1;
                }
                data_item_ready['amount'] = amount;
            }
            // PUSH INTO MAIN STORAGE
            data_cart[id_cached] = [data_item_ready];
            // DELETE NONE ELEMENT BY DEFAULT
            delete data_cart.none;
            // CACHED IN BROWSER
            localStorage.setItem('cart', JSON.stringify(data_cart));
            // CHECK IF CART BOX HAS SHOW BEFORE WE KEEP IT IN STATE: TRUE OR FALSE
            var showCart = el_list_box.classList.contains('block');
            // DELAY NEEDED FOR BROWSER CACHED DONE!
            setTimeout(function(){
              if( showCart ){
                // SHOW CART RIGHT SIDE
                pointer.showCart();
              }else{
                var el_open_btn = d.querySelector('#open-cart-right-side');
                    el_open_btn.classList.add('zoom-transit');
                    el_open_btn.addEventListener('transitionend', function(){
                      this.classList.remove('zoom-transit');
                    });
              }
              // UPDATE
              pointer.update_number_item_cart();
            }, 100);
        },
        update_number_item_cart: function(){
            // ADD INFO NUMBER ITEM INSIDE BUTTON OPEN-CART
            var data_cart = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : {};
            d.querySelector('#cart-container .plusAnim').textContent = Object.keys(data_cart).length;
        },
        tick_all_check_box_status: function(el_container, status){
            var aria_check = status ? 'true' : 'false';
            var el_containers = el_list_box.querySelectorAll('.body .checkbox-container');
            for( var i in el_containers ){
              if( el_containers.hasOwnProperty(i) ){
                el_containers[i].setAttribute('aria-check', aria_check);
              }
            }
            // COLLECTION FOR MANY UPDATE
            pointer.collection_cart_checkbox_status();
        },
        collection_cart_checkbox_status: function(){
            // RESET FOR NEW CHECK LOOP
            collection_cart_checkbox = {}
            var el_containers = el_list_box.querySelectorAll('.body .checkbox-container');
            var count_elements_number = Object.keys(el_containers).length;
            var temp_count_collection = 0;
            for( var i in el_containers ){
              if( el_containers.hasOwnProperty(i) ){
                  // CHECK @status
                  var el_container = el_containers[i];
                  var status = el_container.getAttribute('aria-check');
                  var checkbox_id = el_container.getAttribute('data-id');
                  // PUSH INTO COLLECTION
                  collection_cart_checkbox[checkbox_id] = {"id": checkbox_id, "status": status}
                  // TEMP TO COMPARE FOR CHECK-ALL OR NO
                  if( status == 'true' ){
                  temp_count_collection++;
                }
              }
            }
            // SELECTOR @#check-all-item-cart
            var check_all_item_cart = el_list_box.querySelector('.tick-all .checkbox-container');
            // UPDATE : CHECK-ALL OR NO
            if( count_elements_number == temp_count_collection ){
              check_all_item_cart.setAttribute('aria-check', 'true');
            }else{
              check_all_item_cart.setAttribute('aria-check', 'false');
            }
            // UPDATE NUMBER ITEM CHECKED
            el_list_box.querySelector('.number-item-cart-checked').textContent = '(' + temp_count_collection + ')';
        },
        clearCartItem: function(callback){
            var collection_cart_checkbox = pointer.getCollection();
              var data_cart = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : {};
              for( var i in collection_cart_checkbox ){
              if( collection_cart_checkbox[i]['status'] == 'true' ){
                  delete data_cart[collection_cart_checkbox[i]['id']];
              }
            }
            // UPDATE BROWSER CACHED DONE!
            localStorage.setItem('cart', JSON.stringify(data_cart));
            // REFRESH BY CALLBACK
            if( callback ){
              setTimeout(function(){
                callback();
              }, 100);
            }else{
              console.log('no callback when clear item');
            }
        },
        getCollection: function(){
            return collection_cart_checkbox;
        }
    }
  }
  // INIT: Constructor
  a.Cart_Invoke = c;
}(this);
/*
THIS PLUGIN NEED : LIBRARY /colorist2.js
HOW TO USE: set onload IMG: Image_Dominant_Color.getImageData(@idIMG)
*/
!function(a, b) {
    'use strict';
    var c, d = a.document;
    c = function() {
      var imgData, imre = 100, tyd = 20, nbpc = 1,
        rType = 'CC', cc3d = false, contour = false,
        axes = 'hsl', cs = 'YUV', accuracy = 10,
        idIMG, setAfter = false;
      return{
        getImageData: function(id_image, setAfter_bool) {
            // SET AFTER FOR EFFECT AFTER DONE COLLECT RGB COLOR
            idIMG = id_image;
            setAfter = setAfter_bool;
            // 
            var imgEl = d.getElementById(idIMG), width, height,
              canvas = d.createElement('canvas'),
              context = canvas.getContext('2d');
            // 
            height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
            width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;
            // 
            context.drawImage(imgEl, 0, 0);
            // 
            imgData = context.getImageData(0, 0, width, height).data;
            Image_Dominant_Color.calcBuckets(tyd, rType);
        },
        // SORT OBJECT
        firstKey: function(obj) {
            var tuples = [];

            for (var key in obj) tuples.push([key, obj[key]]);
            tuples.sort(function(a, b) { return a[1] < b[1] ? 1 : a[1] > b[1] ? -1 : 0 });

            return tuples[0][0];
        },
        // NUMBER DIFFERENT
        nr: function(bs) {
            for (i = 0; i < bs.length; i++) {
              if (bs[i].compte == 1) {
                return i;
              }
            }
            return bs.length;
        },
        // MEAN COLOR
        meanColor: function(bin) {
            var bl = bin.length;
            var ca = 0;
            var cb = 0;
            var cc = 0;
            for (var j = 0; j < bl; j++) {
              switch (cs) {
                case "YUV" :
                  ca += bin[j].y;
                  cb += bin[j].u;
                  cc += bin[j].v;
                  break;
              }
            }
            switch (cs) {
              case "YUV" :
                var mc = new cyuv(Math.round(ca / bl), Math.round(cb / bl), Math.round(cc / bl));
                break;
            }
            return mc;
        },
        // BINARY DATA
        classeBins2: function(bins) {
            var tb = new Array();
            for (var i = 1; i < bins.length; i++) {
              tb.push({couleur:Image_Dominant_Color.meanColor(bins[i]), compte:bins[i].length});
            }
            tb.sort(function(a,b) {return b.compte-a.compte;});
            return tb;
        },
        // CALCULATE BUCKETS BY DATA
        calcBuckets: function(thres, type) {
            var val = new Array();
            var maxCount = 0;
            var bins = Array();
            var step = 4;
            var n = imgData.length;
            // Remplissage tableau de couleurs en YUV
            for (var i = 0; i < n; i+= Math.round(step * (imre * step))) {
              var ct = new Object();
              ct.r = imgData[i];
              ct.g = imgData[i+1];
              ct.b = imgData[i+2];
              switch (cs) {
                case "YUV" :
                  var cy = rgb2yuv(ct);
                  break;
              }
              val.push(cy);
            }
            // Tri des valeurs
            switch (cs) {
              case "YUV" :
                val.sort(function (a,b) {return (a.y, b.y)});
                break;
            }
            // Calcul des buckets de valeur
            var nc = val.length;
            var nb = 1; //Num du dernier bucket;
            bins[1] = new Array();
            for (var i = 0; i < nc; i++) {
              if (bins[1].length == 0) {
                bins[1].push(val[i]);
              } else {
                var bt = new Array();
                var t = false;
                for (var j = 1; j <= nb; j++) {
                  var d = colorDifference(val[i], bins[j][Math.round((bins[j].length - 1)/ 2)]);
                  if (d < thres) {
                    bt[j] = d;
                    t = true;
                  }
                }
                if (t == true) {
                  var fk = Image_Dominant_Color.firstKey(bt);
                  bins[fk].push(val[i]);
                } else {
                  nb += 1;
                  bins[nb] = new Array();
                  bins[nb].push(val[i]);
                }
              }
            }
            if(type == "CC"){
              Image_Dominant_Color.collectRGB(bins);
            }
        },
        // FINISH CORE: COLLECTING RGB COLOR FROM BIN AND MORE...
        collectRGB: function (bins) {
            var bs = Image_Dominant_Color.classeBins2(bins);
            var bc = Math.sqrt(bs[0].compte);
            var l = Math.min(bs.length, (nbpc + 20));
            for (var i = nbpc; i < l; i++) {
              if (bs[i].couleur == undefined) {continue;}
              switch (cs) {
                case "YUV" :
                  var ce = yuv2rgb(bs[i].couleur);
                  break;
              }
              // RGB -> HEX color
              var cc = "#" + ((1 << 24) + (ce.r << 16) + (ce.g << 8) + ce.b).toString(16).slice(1);
              // RGB -> HSV color
              var hv = rgb2hsv(ce.r, ce.g, ce.b)[2];
              // text color: contrast
              var cci = (hv < 128) ? "#FFFFFF" : "#222222";
              // dominant color number by map: ORDER BY DESC
              var color_number_dominant = bs[i].compte;
              // WE NEED RGB COLOR OF PROPORTION COLOR OF IMAGE ONLY
              if( i == nbpc ){
                var rgb = ce;
              }
            }
            // setAfter or return RGB color
            if( setAfter == true ){
              Image_Dominant_Color.set_dominant_color(rgb, idIMG);
            }else{
              return rgb;
            }
        },
        // 
        set_dominant_color: function(rgb, idIMG){
            var el_needle = d.querySelectorAll('[data-dominant-query="' + idIMG + '"]');
            for( var i in el_needle ){
              if( el_needle.hasOwnProperty(i) ){
                var set_type_color = el_needle[i].getAttribute('data-dominant-set-type');
                if( set_type_color == 'color' ){
                  el_needle[i].style.color = 'rgba('+rgb.r+','+rgb.g+','+rgb.b+', 1)';
                }else{
                  el_needle[i].style.backgroundColor = 'rgba('+rgb.r+','+rgb.g+','+rgb.b+', .2)';
                }
              }
            }
            // HEADER:
            var el_header = d.querySelector('header');
            el_header.style.backgroundColor = 'rgba('+rgb.r+','+rgb.g+','+rgb.b+', 1)';
            el_header.classList.add('dominant-style');
        }
      }
  }
  // INIT: Constructor
    a.Image_Dominant_Color = new c;
}(this);
/*
::FORM SUBMIT::
THIS FORK REQUIRE: JQUERY
*/
!function(a, b) {
    'use strict';
    var c, d = a.document;
    // ERROR DESCRIPTION
    var map_error_after_submit = {
        'INSERT_FAILED': 'Tạo mới bị thất bại.',
        'EMAIL_HAS_USED_BEFORE': 'Email đã có người sử dụng.',
        'PHONE_NUMBER_HAS_USED_BEFORE': 'Số điện thoại đã có người sử dụng.',
        'UPDATE_FAILED': 'Cập nhật thất bại.',
        'CONTENT_CART_WRONG': 'Giỏ hàng rỗng.',
        'UPDATE_NO_CHANGE': 'Không có gì thay đổi',
        'HASH_EXPIRED': 'Phiên đăng nhập đã hết hạn',
        'password_not_isset': 'Mật khẩu không đúng.',
        'email_not_isset': 'Email không tồn tại.',
        'phone_number_not_isset': 'Số điện thoại không tồn tại.'
    }
    var map_error_before_submit = {
        'repassword_not_match': 'Nhập lại mật khẩu không khớp.',
        'email_invalid': 'Email không hợp lệ, vd: abc@gmail.com',
        'phone_number_invalid': 'Số điện thoại không hợp lệ',
        'password_invalid': 'Mật khẩu ít nhất 6 ký tự.',
        'repassword_invalid': 'Nhập lại mật khẩu không khớp.',
        'content_invalid': 'Nội dung quá ngắn.'
    }
    c = function(opts) {
        var options = {
            containerID: "",
            formID: "",
            xhrURL: "",
            pointer_filter: {type: "container", delay: 2600}
        },
        p, $container, $form, cached_$form, $filter;
        // UPDATE OPTIONS
        for( var i in opts ){
          options[i] = opts[i];
        }
        // RETURN MAP
        return {
            restart: function(map_extra_value){
                // SET POINTER AS CONSTRUCTOR OF @c
                p = this;
                // SET CONTAINER, FORM AS $DOMs
                $container = $('#' + options.containerID);
                $form = $('form#' + options.formID);

                //FORM : submit
                $form.submit(function(event){
                    cached_$form = $(this);
                    // STOP submit default by browser
                    event.preventDefault();
                    // DATA format with JSON
                    var streamInput = {}
                    // TEMPORARY FOR COMPARE AFTER
                    var repassword_value, password_value;
                    // Iterators
                    var $lis = $(this).find('input, textarea');
                    $lis.each(function(){
                        var name = $(this).attr('name');
                        var value = $(this).val().toString().trim();
                        var require = $(this).attr('data-require');
                        // CASE: new PASSWORD
                        if( name == 'password' ){
                            password_value = value;
                        }
                        if( name == 'repassword' ){
                            repassword_value = value;
                        }
                        // CHECKING:
                        // set default to avoid error : pattern always test return TRUE
                        var pattern = /\s*/g;
                        if( require ){

                            if( name == 'content' & value.length > 3 ||
                                name == 'name' & value.length > 2 ||
                                name == 'user_name' & value.length > 2 ||
                                name == 'address' & value.length > 5 ||
                                name == 'password' & value.length > 2 ||
                                name == 'repassword' & password_value == repassword_value
                            ){
                                //NOT USE REGX, check by length
                                //DONT DO HERE, ELSE case: will do for these
                            }else if( name == 'phone_number' ){
                                pattern = /[0-9 ]{9,14}/g;
                            }else if( name == 'email' ){
                                pattern = /^\w{3,}@\w+\.[a-z]{2,}/gi;
                            }else{
                                // Made pattern always test return FALSE
                                pattern = /^\s/g;
                            }
                        }
                        //CHECK BY @pattern
                        if( pattern.test(value) ){
                            $(this).removeClass('error');
                            //push VALUE to JSON DATA
                            streamInput[name] = value;
                        }else{
                            $(this).focus();
                            $(this).addClass('error');
                            cached_$form.find('.error-text').text(map_error_before_submit[name + '_invalid']);
                            cached_$form.find('.error-text').show().attr('style', 'opacity: 1;');
                            return false;
                        }
                        //FINAL SHOOT: send-to-server
                        if($(this)[0] === $lis.last()[0]) {
                            // STATEMENT ASSIGN
                            streamInput['statement'] = options.formID;
                            // PUSH EXTRA VALUE INTO STREAM
                            if( map_extra_value ){
                                for( var i in map_extra_value ){
                                    var extra_i_value = map_extra_value[i].value;
                                    if( map_extra_value[i].evaluate == true ){
                                        extra_i_value = eval(extra_i_value);
                                    }
                                    streamInput[i] = extra_i_value;
                                }
                            }
                            console.log(streamInput);
                            
                            // CHECK : BEFORE SEND TO SERVER
                            if( options.xhrURL ){
                                p.send_to_server_update_by_id_form(streamInput);
                            }
                        }
                    });
                });
            },
            // SEND TO SERVER FOR CHECK
            send_to_server_update_by_id_form: function(dataAuthorize){
                console.log(dataAuthorize);
                // POINTER FILTER
                if( options.pointer_filter.type == 'container' ){
                    p.filterContainer();
                }else{
                    console.log('no filter');
                }
                // SEND NOW
                $.post( options.xhrURL, {suggest: dataAuthorize} ).done(function(data){
                    data = JSON.parse(data);
                    cached_$form.find('.error-text').addClass('block');
                    console.log(data);
                    if( data.id ){
                        // EMPTY ERROR TEXT
                        cached_$form.find('.error-text').text('');
                        var success_alert = data.success_alert ? data.success_alert : 'Bạn đã gửi thành công.';
                        // SHOW TEXT ALERT
                        if( options.pointer_filter.type == 'container' ){
                            $filter.html(success_alert);
                        }else{
                            cached_$form.find('.error-text').text(success_alert).addClass('success');
                        }
                        // CALLBACK
                        if( options.after_submit ){
                            if( options.after_submit.hasOwnProperty('callback') ){
                                setTimeout(function(){
                                    options.after_submit.callback();
                                }, options.after_submit.delay);
                            }
                        }
                        // GO THEN
                        if( options.after_submit ){
                          if( options.after_submit.state == 'success' ){
                              setTimeout(function(){
                                  window.location.href = options.after_submit.go_to_url;
                              }, options.after_submit.delay);
                          }
                        }
                    }else{
                        cached_$form.find('.error-text').text(map_error_after_submit[data.error]);
                        console.log('Failed!');
                        $('input[name="' + data.error + '"').focus().addClass('error');
                    }
                    // DELAY FILTER THEN REMOVE IT
                    var delay = options.pointer_filter.delay;
                    if( options.after_submit ){
                        if( options.after_submit.hasOwnProperty('delay') ){
                            delay = options.after_submit.delay;
                        }
                    }
                    setTimeout(function(){
                        $filter.remove();
                    }, delay);
                });
            },
            filterContainer: function(){
                $filter = $('<div class="filter-container">');
                // SHOW LOADER ICON
                $filter.html(make_loader_icon_html('32px'));
                $form.append($filter);
            }
        }
    }
    // INIT: Constructor
    a.Form_Invoke = c;
}(this);
/*
::POPUP::
THIS FORK REQUIRE: AJAX JQUERY
*/
!function(a, b) {
    'use strict';
    var c, d = a.document;
    c = function(opts) {
        var options = {
            popupID: "popup",
            containerID: "",
            iterators: "",
            xhrURL: ""
        },
        p, body, popup, popup_content, popup_close_icon, container;
        // UPDATE OPTIONS
        for( var i in opts ){
          options[i] = opts[i];
        }
        // RETURN MAP
        return {
            restart: function(){
                // SET POINTER AS CONSTRUCTOR OF @c
                p = this;
                // SET CONTAINER AS $DOMs
                container = d.getElementById(options.containerID);
                body = d.getElementsByTagName('body')[0];
                // KEYBOARD EVENT:
                body.addEventListener('keyup', function(event){
                    event.keyCode == 27 ? body.removeChild(popup) & (body.style.overflow = 'auto') : false;
                });
                // BIND EVENT ITERATORS
                p.bindEventIter();
            },
            // BIND EVENT FOR ITERATORS
            bindEventIter: function(){
                var streamDATA = {},
                    el_iterators = d.querySelectorAll(options.iterators);
                for( var i in el_iterators ){
                    if( el_iterators.hasOwnProperty(i) ){
                        el_iterators[i].addEventListener('mousedown', function(){
                            // CREATE POPUP CONTAINER
                            p.createPopup();
                            // STATEMENT ASSIGN
                            streamDATA.statement = options.containerID;
                            streamDATA.id = this.getAttribute('data-id');
                            p.load_dom_from_server_by_id(streamDATA);
                        });
                    }
                }
                    
            },
            createPopup: function(){
                // CREATE NEW POPUP
                popup = d.createElement('div');
                popup.setAttribute('id', options.popupID);
                popup.setAttribute('class', 'popup-container');
                popup.addEventListener('mousedown', function(event){
                    body.removeChild(this);
                    // BODY SHOW SCROLL
                    body.style.overflow = 'auto';
                });
                body.appendChild(popup);
                // 
                popup_content = d.createElement('div');
                popup_content.setAttribute('class', 'popup-content');
                // SHOW LOADER ICON
                popup_content.innerHTML = make_loader_icon_html('32px');
                // APPEND TO POPUP CONTAINER
                popup.appendChild(popup_content);
                popup_content.addEventListener('mousedown', function(event){
                    event.stopPropagation();
                });
                // 
                popup_close_icon = d.createElement('div');
                popup_close_icon.setAttribute('class', 'popup-close-icon');
                popup.appendChild(popup_close_icon);
            },
            // SEND TO SERVER FOR CHECK
            load_dom_from_server_by_id: function(dataAuthorize){
                $.post( options.xhrURL, {suggest: dataAuthorize} ).done(function(data){
                    popup.classList.add('block');
                    popup_content.innerHTML = data;
                    // BODY HIDE SCROLL
                    body.style.overflow = 'hidden';
                });
            }
        }
    }
    // INIT: Constructor
    a.Popup_Invoke = c;
}(this);
/*
::Cache::
THIS FORK REQUIRE: AJAX JQUERY
*/
!function(a, b) {
    'use strict';
    var c, d = a.document;
    c = function(opts) {
        var options = {
            cache_name: "",
            xhrURL: "",
            auto_update_delay: 0
        },
        p, max_length_json = 50;
        // UPDATE OPTIONS
        for( var i in opts ){
          options[i] = opts[i];
        }
        // RETURN MAP
        return {
            restart: function(){
                // SET POINTER AS CONSTRUCTOR OF @c
                p = this;
                // GET STREAM DATA FROM LOCAL STORAGE
                var cache_data_json_str = p.get_cache_history(options.cache_name);
                var streamDATA = {};
                    streamDATA.content = cache_data_json_str ? cache_data_json_str : '';
                    streamDATA.statement = options.cache_name;
                // AUTO UDATE: DELAY
                setTimeout(function(){
                    p.send_to_server_by_id(streamDATA);
                }, options.auto_update_delay);
            },
            get_cache_history: function(cache_name, rt_json){
                var history_data = localStorage.getItem(cache_name) ? localStorage.getItem(cache_name) : '{}';
                return rt_json === true ? JSON.parse(history_data) : history_data;
            },
            set_cache_history: function(cache_name, item_name, item_value){
                var history_data = new c().get_cache_history(cache_name, true);
                // REMOVE OLD
                delete history_data[item_name];
                // ASSIGN
                history_data[item_name] = item_value ? item_value : current_timestamp();
                // LIMIT LENGTH OF CACHE
                var n = 0;
                for( var i in history_data ){
                    n++;
                    if( n <= Object.keys(history_data).length - max_length_json ){
                        // REMOVE OLDEST
                        delete history_data[i];
                    }
                }
                // UPDATE STORAGE
                localStorage.setItem(cache_name, JSON.stringify(history_data));
            },
            // SEND TO SERVER FOR CHECK
            send_to_server_by_id: function(dataAuthorize){
                $.post( options.xhrURL, {suggest: dataAuthorize} ).done(function(data){
                    // console.log(data);
                });
            }
        }
    }
    // INIT: Constructor
    a.Cache_Invoke = c;
}(this);
/*
::Search::
THIS FORK REQUIRE: AJAX JQUERY, FORK::Cache_Invoke
*/
!function(a, b) {
    'use strict';
    var c, d = a.document;
    c = function(opts) {
        var options = {
            inputID: "",
            autocomplete_containerID: "",
            xhrURL: "",
            delay: 200
        },
        p, el_input, autocomplete_container, fork_cache = new Cache_Invoke();
        // UPDATE OPTIONS
        for( var i in opts ){
          options[i] = opts[i];
        }
        // RETURN MAP
        return {
            restart: function(){
                // SET POINTER AS CONSTRUCTOR OF @c
                p = this;
                // INIT DOMs
                autocomplete_container = d.getElementById(options.autocomplete_containerID);
                el_input = d.getElementById(options.inputID);
                // BIND EVENT TO: INPUT
                p.bindEventInput();
                
            },
            get_search_history_data: function(){
                // GET STREAM DATA FROM LOCAL STORAGE
                var cache_data_json_str = fork_cache.get_cache_history('search_history');
                var streamDATA = {};
                    streamDATA.search_history = cache_data_json_str ? cache_data_json_str : '';
                return streamDATA;
            },
            bindEventInput: function(){
                el_input.addEventListener('focus', function(){
                    var key_search = this.value;
                    var streamDATA = p.get_search_history_data();
                        streamDATA.key_search = key_search;
                    // AUTO COMPLETE: SHOW
                    p.send_to_server_by_id(streamDATA);

                });
                el_input.addEventListener('keyup', function(){
                    var key_search = this.value;
                    var streamDATA = p.get_search_history_data();
                        streamDATA.key_search = key_search;
                    // AUTO COMPLETE: SHOW
                    setTimeout(function(){
                        p.send_to_server_by_id(streamDATA);
                    }, options.delay);

                });
            },
            // SEND TO SERVER FOR CHECK
            send_to_server_by_id: function(dataAuthorize){
                $.post( options.xhrURL, {suggest: dataAuthorize} ).done(function(data){
                    autocomplete_container.innerHTML = data;
                    // FOCUS INPUT
                    el_input.focus();
                });
            }
        }
    }
    // INIT: Constructor
    a.Search_Invoke = c;
}(this);
/*
::LOADMORE::
THIS FORK REQUIRE: JQUERY
*/
!function(a, b) {
    'use strict';
    var c, d = a.document;
    c = function(opts) {
        var options = {
            iterators: "",
            xhrURL: ""
        },
        p, cur_data_container_id;
        // UPDATE OPTIONS
        for( var i in opts ){
          options[i] = opts[i];
        }
        // RETURN MAP
        return {
            restart: function(){
                // SET POINTER AS CONSTRUCTOR OF @c
                p = this;
                // BIND EVENT ITERATORS
                p.bindEventIter();
            },
            // COLLECT ALL DATA ID COLLECTION FROM BUTTON LOAD MORE
            collect_all_id_collect: function(reference, el_button){
                var id_collection_data = '';
                // CHECK
                if( reference == 'home_page' ){
                    var $_loadmore_ = $(el_button).closest('._loadmore_');
                    var $el_buttons = $_loadmore_.find('.load-more button[data-id-collection]');

                }else{
                    // cates, p, t, s
                    var $el_buttons = $('.load-more button[data-id-collection]');
                }
                // COLLECT BY LOOP
                $el_buttons.each(function(){
                    id_collection_data += ',' + $(this).attr('data-id-collection');
                });
                // OMIT FIRST CHAR ','
                return id_collection_data.substr(1);
            },
            // BIND EVENT FOR ITERATORS
            bindEventIter: function(){
                var streamDATA = {},
                    el_iterators = d.querySelectorAll(options.iterators);
                for( var i in el_iterators ){
                    if( el_iterators.hasOwnProperty(i) ){
                        el_iterators[i].addEventListener('mousedown', function(){
                            // MAKE STREAM DATA
                            cur_data_container_id = this.getAttribute('data-container-id');
                            var data_book_case = this.getAttribute('data-book-case');
                            var data_reference = this.getAttribute('data-reference');
                            var data_query_where = this.getAttribute('data-query-where');
                            var data_id_collection = p.collect_all_id_collect(data_reference, this);
                            var data_suggest = this.getAttribute('data-suggest');
                            var streamDATA = {"reference": data_reference, "book_case": data_book_case, "query_where": data_query_where, "id_collection": data_id_collection, "suggest": data_suggest}
                            // CALL AJAX
                            p.load_dom_from_server_by_id(streamDATA, this);
                        });
                    }
                }
                    
            },
            // SEND TO SERVER FOR CHECK
            load_dom_from_server_by_id: function(dataAuthorize, cur_obj_click){
                var $cur_obj_click = $(cur_obj_click);
                var $parent_btn_loadmore = $cur_obj_click.parent();
                var $_loadmore_ = $parent_btn_loadmore.closest('._loadmore_');
                // HIDE BUTTON & SHOW LOADER ICON
                $cur_obj_click.hide();
                $parent_btn_loadmore.append(make_loader_icon_html('50%'));
                // SEND
                $.post( options.xhrURL, {suggest: dataAuthorize} ).done(function(data){
                    $_loadmore_.append(data);
                    // HIDE PARENT BUTTON LOAD MORE
                    $parent_btn_loadmore.addClass('hide');
                });
            }
        }
    }
    // INIT: Constructor
    a.Loadmore_Invoke = c;
}(this);