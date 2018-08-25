<script>
!function(a, b) {
  'use strict';
  var c, e, f, d = a.document;
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
        },
        arrayChunk: function(inputArr, lenGroup){
            var output_arr = [], i, j, temp_arr, chunk = lenGroup;
            for ( i = 0, j = inputArr.length; i < j; i += chunk ) {
              temp_arr = inputArr.slice(i, i+chunk);
              output_arr[i] = temp_arr;
            }
            return output_arr;
        },
        hexToRgb: function(hex){
          // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
          var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
          hex = hex.replace(shorthandRegex, function(m, r, g, b) {
              return r + r + g + g + b + b;
          });
          var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
          return result ? 'rgb(' + parseInt(result[1], 16) + ',' + parseInt(result[2], 16) + ',' + parseInt(result[3], 16) + ')' : null;
        }
      }
  }
  c = function() {
      var options = {
            formatBlockParagraph: "p",
            delay_btn_cmd: 150,
            imageMaxWidth: 640,
            cls : {
              "button_cmd": ".bwe-btn",
              "dropdown_container": ".bwe-dropdown-container",
              "table_color_cmd": ".bwe-table-color-cmd",
              "font_name_cmd": ".bwe-font-name-cmd",
              "font_type_text_container": ".bwe-text-font-name",
              "font_size_cmd": ".bwe-font-size-cmd",
              "heading_size_cmd": ".bwe-heading-size-cmd",
              "popup_container": ".bwe-popup-container",
              "popup_image_loader": ".bwe-popup-image-loader",
              "popup_button_action": ".bwe-popup-button-action"
            },
            cls_no_dot: {
              "editor": "bwe-wysiwyg-container",
              "dropdown_icon": "bwe-icon-arrow-down",
              "button_cmd_icon": "bwe-icon",
              "button_cmd_icon_sprite": "bwe-icon-sprite",
              "v_line": "bwe-v-line",
              "button_cmd_is_true": "bwe-is-true",
              "button_cmd_is_hit_true": "bwe-is-hit-true",
              "tooltip_text": "bwe-tooltip-text",
              "tooltip_icon_wrapper": "bwe-tooltip-icon-wrapper",
              "tooltip_icon": "bwe-tooltip-icon",
              "popup_wrapper": "bwe-popup-wrapper",
              "popup_input_box": "bwe-popup-input-box"
            },
            ids : {
              "container": "bwe-container",
              "editor": "bwe-WYSIWYG",
              "table_color_map_cmd": ['backColor', 'foreColor'],
              "tooltip": "bwe-tooltip-container"
            }
          },
          layouts = {
            "container_gene": {
                "tag_name": "div",
                "attrs": {"id": "bwe-container"},
                "child": [
                  {
                    "tag_name": "div",
                    "attrs": {"class": "bwe-cmd-container"},
                    "child": [
                      {
                        "tag_name": "div",
                        "attrs": {"class": "bwe-cmd-wrapper"},
                        "child": function(daddy_container){
                          return BasicWordEditor._buildButtonCommand(daddy_container);
                        }
                      },
                      {
                        "tag_name": "div",
                        "attrs": {"class": "bwe-down-pointer"},
                        "child": null
                      }
                    ]
                  },
                  {
                    "tag_name": "div",
                    "attrs": {"id": "bwe-WYSIWYG", "class": options.cls_no_dot.editor, "contenteditable": true, "spellcheck": false},
                    "child": [
                      {
                        "tag_name": options.formatBlockParagraph,
                        "html_content": "<br>"
                      }
                    ]
                  }
                ],
            },
            "button_command": {
              "+fontName":["bwe-text-font-name", "Font Type"],
              "vline1":"div",
              "+fontSize":["bwe-icon-txt-size"],
              "+headingSize":["bwe-icon-heading-size"],
              "vline2":"div",
              "bold":["bwe-icon-bold"],
              "italic":["bwe-icon-italic"],
              "underline":["bwe-icon-underline"],
              "+colorMenu":["bwe-icon-color"],
              "vline3":"div",
              "justifyLeft":["bwe-icon-jusleft"],
              "justifyCenter":["bwe-icon-juscenter"],
              "justifyRight":["bwe-icon-jusright"],
              "vline4":"div","insertOrderedList":["bwe-icon-ordlist"],
              "insertUnorderedList":["bwe-icon-unordlist"],
              "outdent":["bwe-icon-outdent"],
              "indent":["bwe-icon-indent"],
              "BLOCKQUOTE":["bwe-icon-blockquote"],
              "ANCHOR":["bwe-icon-anchor"],
              "IMAGE":["bwe-icon-image"],
              "vline5":"div",
              "removeFormat":["bwe-icon-removeformat"]
            }
          },
          palette = {
            table_color: {
              "colorDark8": ["0, 0, 0","68, 68, 68","102, 102, 102","153, 153, 153","204, 204, 204","238, 238, 238","243, 243, 243","255, 255, 255"],
              "colorRic8": ["255, 0, 0","255, 153, 0","255, 255, 0","0, 255, 0","0, 255, 255","0, 0, 255","153, 0, 255","255, 0, 255"],
              "colorMix48": ["244, 204, 204","252, 229, 205","255, 242, 204","217, 234, 211","208, 224, 227","207, 226, 243","217, 210, 233","234, 209, 220","234, 153, 153","249, 203, 156","255, 229, 153","182, 215, 168","162, 196, 201","159, 197, 232","180, 167, 214","213, 166, 189","224, 102, 102","246, 178, 107","255, 217, 102","147, 196, 125","118, 165, 175","111, 168, 220","142, 124, 195","194, 123, 160","204, 0, 0","230, 145, 56","241, 194, 50","106, 168, 79","69, 129, 142","61, 133, 198","103, 78, 167","166, 77, 121","153, 0, 0","180, 95, 6","191, 144, 0","56, 118, 29","19, 79, 92","11, 83, 148","53, 28, 117","116, 27, 71","102, 0, 0","120, 63, 4","127, 96, 0","39, 78, 19","12, 52, 61","7, 55, 99","32, 18, 77","76, 17, 48"]
            },
            font_type: {
              "fontName": {
                "value": ["arial, helvetica, sans-serif", "times new roman, serif", "monospace, monospace", "arial black, sans-serif", "arial narrow, sans-serif", "comic sans ms, sans-serif", "garamond, serif", "georgia, serif", "tahoma, sans-serif", "trebuchet ms, sans-serif", "verdana, sans-serif"],
                "name_display": ["Arial", "Times New Roman", "Monospace", "Arial Black", "Arial Narrow", "Comic Sans MS", "Garamond", "Georgia", "Tahoma", "Trebuchet MS", "Verdana"]
              },
              "fontSize": {
                "value": ["1", "2", "4", "6"],
                "value_onStyle": ["x-small", "small", "large", "xx-large"],
                "name_display": ["Nhỏ", "Thường", "Lớn", "Rất lớn"]
              }
            },
            heading_size: {
              "tag_name": ["h1", "h2", "h3", "h4", "h5", "h6"],
              "value": ["32px", "24px", "19px", "16px", "14px", "11px"]
            }
          },
          infoCurrentRange = {
            'FONTNAME': palette.font_type.fontName.value[0],
            'FONTSIZE': palette.font_type.fontSize.value[1]
          };

      return {
        invokeNow: function(){
            // CALL CONTAINER EDITOR
            f = d.getElementById(layouts.container_gene.attrs.id);
            // CONTAINER EDITOR AND DOCUMENT READY TO START!!!
            if( f ){
              BasicWordEditor.buildLayout(layouts.container_gene, f);
              /*
              HOW KNOW BUILD LAYOUT COMPLETE, WE MUST setTimeout to VALID WORKS REALLY AFTER BUILD!
              WHY NOT USE DOMcontentLoaded EVENT, BECAUSE SNIPPET IS INCLUDED BY AJAX BEFORE
              SO DOM HAS LOAD BEFORE CHECK!
              */
              setTimeout(function(){
                // SETUP : editor as OBJECT HTML
                e = d.getElementById(options.ids.editor);
                ( d.getElementById('_BWE-temp').value ? (e.innerHTML = d.getElementById('_BWE-temp').value) : false );
                // BIND EVENT!
                BasicWordEditor.bindEvent('mousedown');
                BasicWordEditor.bindEvent('keydown');
                // button_cmd : bindEvent
                BasicWordEditor.bindEvent('mousedown', options.cls.button_cmd);
                // restart: TOOLTIP
                // BasicWordEditor.restartTooltip();
              }, 0);
            }
        },
        buildLayout: function(gene, daddy_container){
            if( typeof gene.child == "function" ){
              gene.child(daddy_container);
            }else if( gene.child ){
              for(var i in gene.child ){
                var gene_i = gene.child[i];
                var el_i = BasicWordEditor.createElement_by_layouts(gene_i);
                daddy_container.appendChild(el_i);
                //BUILD NEXT -> GENERTATIONS
                BasicWordEditor.buildLayout(gene_i, el_i);
              }
            }
        },
        createElement_by_layouts: function(resource){
            var el = d.createElement(resource.tag_name);
            if( resource.attrs ){
              for( var attr in resource.attrs ){
                el.setAttribute(attr, resource.attrs[attr]);
              }
            }
            if( resource.html_content ){
              el.innerHTML = resource.html_content;
            }
            return el;
        },
        _buildButtonCommand: function(daddy_container){
            // console.log(daddy_container);
            var content = '';
            for( var key in layouts.button_command ){
              if( key.indexOf('vline') != -1 ){
                content += '<div class="' + options.cls_no_dot.v_line +'"></div>';
              }else{
                //NOTE: cmd has (+) sign is A DROP-DOWN
                var content_drop_down_container = '', content_drop_down_icon ='';
                if( key.indexOf('+') == 0 ){
                  content_drop_down_container += '<div class="' + options.cls.dropdown_container.substr(1) + '"></div>';
                  content_drop_down_icon = '<div class="' + options.cls_no_dot.dropdown_icon + '"></div>';
                }
                var textContent = layouts.button_command[key][1] ? layouts.button_command[key][1] : '';
                content += '<div data-tooltip="' + key + '" command="' + key + '" class="' + options.cls.button_cmd.substr(1) + '">';
                content += '<div class="' + options.cls_no_dot.button_cmd_icon +'">';
                content += '<div class="' + options.cls_no_dot.button_cmd_icon_sprite +' ' + layouts.button_command[key][0] + '">' + textContent + '</div>';
                content += content_drop_down_icon;
                content += '</div>';
                content += content_drop_down_container;
                content += '</div>';
              }
            }
            //APPEND BUTTONS
            daddy_container.innerHTML = content;
        },
        bindEvent: function(evt, elements_iterator){

            if( elements_iterator ){
              //BUTTON, TD, DIV-fontType, DIV-headingSize : Iterator Object
              var showUI, value;
              console.log('bindEvent: Iterator: ' + elements_iterator);
              var el_btn_cmd = d.querySelectorAll(elements_iterator);
              for (var i = 0; i < el_btn_cmd.length; i++) {
                el_btn_cmd[i].addEventListener( evt, function(event){
                  //prevent DIV steals the focus, stop Bubble from Parent-same-Event
                  event.preventDefault();
                  event.stopPropagation();
                  //ADD CLASS ACTIVE FOR BUTTON_CMD
                  BWE_f.addClass( this, options.cls_no_dot.button_cmd_is_hit_true );
                  var cmd = this.getAttribute('command');

                  //COMMAND ON BUTTON-CMD
                  if( elements_iterator == options.cls.button_cmd ){
                    // REMOVE BUBBLE ON CHILDREN DROP-DOWN OF THIS
                    var el_child_dropdown = this.querySelector(options.cls.dropdown_container);
                        if( el_child_dropdown ){
                          el_child_dropdown.addEventListener('mousedown', function(event){
                            event.stopPropagation();
                          });
                        }

                  }else{
                    //COMMAND INSIDE DROP-DOWN
                    var value;
                    if( elements_iterator == options.cls.table_color_cmd ){
                      // CMD ITERATORS INCLUDE: FORECOLOR, BACKCOLOR
                      value = 'rgb(' + this.getAttribute('data-color').replace(/ /g, '') + ')';

                    }else if( elements_iterator == options.cls.heading_size_cmd ){
                      // CMD ITERATORS : HEADING-SIZE
                      value = this.getAttribute('data-tag-name');
                    }else{
                      // CMD ITERATORS INCLUDE: FONTNAME , FONTSIZE
                      value = this.getAttribute('data-value');
                      if( elements_iterator == options.cls.font_name_cmd ){
                        //SET textContent: inside @.bwe-text-font-name
                        BasicWordEditor._setTextFontName(value);
                      }
                      
                    }
                    //UPDATE => BACK- or FORE-:COLOR & FONT:-NAME or -SIZE
                    infoCurrentRange[cmd.toUpperCase()] = value;
                    //HIDE ALL DROP-DOWN
                    BasicWordEditor.forceEffect(options.cls.dropdown_container);
                  }
                  //INVOKE COMMAND NOW! @this = objects inside DROPDOWN-CONTAINER
                  BasicWordEditor.forceCommand(cmd, showUI, value, this);
                });
              }
            }else{

              console.log('bindEvent: DIV-CONTENTEDITALE : ' + evt);
              // MOUSEDOWN , KEYUP : DIV-CONTENTEDITALE events
              e.addEventListener( evt, function(event){
                
                if( evt == 'keydown' ){
                  /*
                    EVENT KEYDOWN: to custom something and prevent!
                  */
                  // console.log(e.innerHTML + ' : ' + event.keyCode);
                  if( event.keyCode == 13 ){
                    //EVENT ENTER -> BLOCKQUOTE
                    var hasTagName_break_line = infoCurrentRange['HAS_PARENT_BLOCKQUOTE'] ? 'BLOCKQUOTE' : null;
                    BasicWordEditor._isBreakLine(hasTagName_break_line, infoCurrentRange['TAG_NAME_SELF']);
                    console.log('Enter at: ' + infoCurrentRange['TAG_NAME_SELF']);

                  }else if( event.keyCode === 8 && e.innerHTML == '<p><br></p>'){
                    //case: first-line is empty by default browser will remove p TAG so.. below to prevent
                    event.preventDefault();
                    console.log('Prevented Removing <P>');
                  }

                }else{
                  // STOP BUBBLE WHEN PARENT @#panelEditor invoke mousedown such as this editor...
                  event.stopPropagation();
                  // EDITOR SCROLL WHEN FOCUS
                  e.style.overflow = 'auto';
                  // AUTO FIT SCREEN WITH EDITOR-CONTAINER ON TOP
                  location.hash = '#' + options.ids.container;
                  // UN-SCROLL PARENT EDITBOX AVOID SCROLL MAKE ANNOY
                  d.querySelector('.boxEdit .content').style.overflow = 'hidden';
                  /*
                    EVENT MOUSEDOWN: to reset and update anything!
                  */
                  //delay to check at current-range, because [event-mousedown] fires before CARET place on editor
                  setTimeout(function(){
                    // RESET : @infoCurrentRange
                    infoCurrentRange = {}
                    // FOCUS EDITOR THEN UPDATE BY CARET: @infoCurrentRange
                    BasicWordEditor.focusEditor(true, 'mousedown');
                    //HIDE DROPDOWN, REMOVE BUTTON_CMD ACTIVE
                    BasicWordEditor.forceEffect(options.cls.dropdown_container);
                    BasicWordEditor.forceEffect(options.cls.button_cmd);
                  }, 0);

                }
              });

            }
        },
        focusEditor: function(checkIsFocus, fromWhere){
            //FOCUS EDITOR NOW!
            e.focus();
            console.log('Focus: checkIsFocus[' + checkIsFocus + ']' + ', fromWhere[' + fromWhere + ']');
            // CHECK CURRENT RANGE
            if( checkIsFocus == true ) BasicWordEditor.isFocus();
        },
        isFocus: function(){
            //Check current-range is what in use
            var map_check_CMD_is_USE = ['bold','italic','underline','insertOrderedList','insertUnorderedList'];
            for( var i in map_check_CMD_is_USE ){
              var CMD_i = map_check_CMD_is_USE[i];
              var state = d.queryCommandState( CMD_i );
              // console.log(state);
              var el_btn = d.querySelector('.bwe-btn[command="'+CMD_i+'"]');
              if( state == true ){
                BWE_f.addClass(el_btn, options.cls_no_dot.button_cmd_is_true);
              }else{
                BWE_f.removeClass(el_btn, options.cls_no_dot.button_cmd_is_true);
              }
            }
            //GET INFO CURRENT RANGE TO CHECK: fontName, fontSize, colorMenu, Blockquote
            BasicWordEditor.getInforCurrentRange();
            BasicWordEditor._setTextFontName(infoCurrentRange['FONTNAME']);

        },
        getInforCurrentRange: function(){
            // VERY IMPORTANT: BEFORE GET SELECTION-RANGE
            BasicWordEditor.focusEditor(false, 'getInforCurrentRange');
            // RESET [FONT-TYPE] inside : @infoCurrentRange
            infoCurrentRange['FONTNAME'] = undefined;
            infoCurrentRange['FONTSIZE'] = undefined;

            var fontFace, fontSize,
                colorRgb = infoCurrentRange['FORECOLOR'],
                backColorRgb = infoCurrentRange['BACKCOLOR'],
                tagNameSelf, ancestorTagName;
            var selection = d.getSelection();
            var range = selection.getRangeAt(0);

            if( selection.rangeCount > 0 ){
              var curRange_atStartContainer_XparentNode = range.startContainer;
              /*
                RANGE LIMIT:
                - @.bwe-wysiwyg-container: from CARET to EDITOR DIV-CONTENTEDITABLE 
                - MAX LIMIT: BODY TAG
                  MAX LIMIT: WHEN EDITOR UNFOCUS -> justifyLeft: out of range, so we must EXCEED RANGE TO BODY TAG
              */
              while( curRange_atStartContainer_XparentNode.className !== options.cls_no_dot.editor &
                     curRange_atStartContainer_XparentNode.tagName !== 'BODY' ){
                  //get Current: object HTML
                  var curObj = curRange_atStartContainer_XparentNode;
                  if( curObj.tagName ){
                    //Push into map
                    if( fontFace == undefined ){
                      fontFace = curObj.getAttribute('face') ? curObj.getAttribute('face') : undefined;
                      infoCurrentRange['FONTNAME'] = fontFace;
                    }
                    if( fontSize == undefined ){
                      fontSize = curObj.getAttribute('size') ? curObj.getAttribute('size') : undefined;
                      infoCurrentRange['FONTSIZE'] = fontSize;
                    }
                    if( colorRgb == undefined ){
                      // CASE: FONT COLOR
                      colorRgb =  curObj.getAttribute('color') ? curObj.getAttribute('color') : undefined;
                      // CASE: STYLE COLOR 
                      colorRgb = colorRgb ? colorRgb : curObj.style.color;
                      // MAKE READY COLOR
                      colorRgb = colorRgb ? BasicWordEditor._readyColorCompare(colorRgb) : undefined;
                      infoCurrentRange['FORECOLOR'] = colorRgb;
                    }
                    if( backColorRgb == undefined ){
                      backColorRgb = curObj.style.backgroundColor ? curObj.style.backgroundColor : undefined;
                      // MAKE READY COLOR
                      backColorRgb = backColorRgb ? BasicWordEditor._readyColorCompare(backColorRgb) : undefined;
                      infoCurrentRange['BACKCOLOR'] = backColorRgb;
                    }
                    if( tagNameSelf == undefined ){
                      tagNameSelf = curObj.tagName;
                      infoCurrentRange['TAG_NAME_SELF'] = tagNameSelf;
                    }
                    ancestorTagName = curObj.tagName;
                    console.log('parentNode at: ' + curObj.tagName);
                    //CHECK PARENT HAS BLOCKQUOTE TAG
                    if( curObj.tagName == 'BLOCKQUOTE' ){
                      infoCurrentRange['HAS_PARENT_BLOCKQUOTE'] = true;
                    }
                  }
                  //Increase: parentNode
                  curRange_atStartContainer_XparentNode = curRange_atStartContainer_XparentNode.parentNode;
              }
              //SET: ANCESTOR_TAG
              infoCurrentRange['ANCESTOR_TAG'] = ancestorTagName;
            }
            //DEFAULT: SET
            if( fontFace == undefined ){
              infoCurrentRange['FONTNAME'] = palette.font_type.fontName.value[0];
            }
            if( fontSize == undefined ){
              infoCurrentRange['FONTSIZE'] = palette.font_type.fontSize.value[1];
            }
            console.log('UPDATE => infoCurrentRange: ');
            console.log(infoCurrentRange);
        },
        forceCommand: function(cmd, showUI, value, self){

            if( cmd.indexOf("+") == 0 ){
              if( cmd == '+colorMenu'){
                //UPDATE @infoCurrentRange
                BasicWordEditor.isFocus();
              }
              //CREATE DROP-DOWN for @.bwe-btn WITH ATTRIBUTE [command=^+] VERY IMPORTANT
              BasicWordEditor.createDropDownMenu(cmd, self);

            }else{
              //HIDE ALL : DROPDOWN; REMOVE BUTTON_CMD ACTIVE
              BasicWordEditor.forceEffect(options.cls.dropdown_container);
              BasicWordEditor.forceEffect(options.cls.button_cmd, options.delay_btn_cmd);
              // CHECK BY CMD
              if( cmd == 'IMAGE'){
                BasicWordEditor.createPopUp(cmd);
              }else if( cmd == 'BLOCKQUOTE' ){
                BasicWordEditor._fragmentCmd(cmd);
              }else if( cmd == 'outdent'){
                BasicWordEditor._fragmentCmd('ESCAPE_BLOCK');
              }else if( cmd == 'headingSize'){
                BasicWordEditor._fragmentCmd('TAG_NAME', value);
              }else if( cmd == 'ANCHOR'){
                var url = prompt("Please enter a link", "");
                if( url ){
                  BasicWordEditor._fragmentCmd('ANCHOR', url);
                }
              }else{
                showUI = (showUI == undefined)? false : showUI;
                value = (value == undefined)? null : value;
                //ONLY executing when DIV-contenteditable is focused
                BasicWordEditor.focusEditor(false, cmd + '|FOCUS-BEFORE');
                d.execCommand( cmd, showUI, value );
                // SUPPORT FOR REMOVE HEADING SIZE BY @removeFormat CMD
                if( cmd == 'removeFormat' ){
                  console.log('HIT ME');
                  setTimeout(function(){
                    d.execCommand('outdent');
                  }, 0);
                }
              }
            }
            //CHECK INFO CURRENT RANGE WITH CMD:
            var checkIsFocus;
            if( cmd.indexOf('font') != -1 | cmd.indexOf('olor') != -1 | cmd.indexOf('justifyLeft') != -1 ){
              checkIsFocus = false;
            }else{
              checkIsFocus = true;
            }
            //FOCUS EDITOR
            BasicWordEditor.focusEditor(checkIsFocus, cmd + '|FOCUS-AFTER');
        },
        _fragmentCmd: function(tagName, value){
            if( tagName == 'BLOCKQUOTE' ){
              d.execCommand('formatBlock', false, tagName);
            }else if( tagName == 'ANCHOR' ){
              d.execCommand('CreateLink', false, value);
            }else if( tagName == 'TAG_NAME' ){
              d.execCommand('formatBlock', false, value);
            }else if( tagName == 'ESCAPE_BLOCK'){
              //ESCAPE BLOCK
              d.execCommand('outdent');
              //ADD p TAG after: ESCAPE BLOCKQUOTE, because Browser not adding
              d.execCommand('formatBlock', false, options.formatBlockParagraph);
            }else{
              //FUNCTION INSERT HANDLE WITH TAG
              var selection = d.getSelection();
              if( selection.rangeCount > 0 ){
                var range = d.getSelection().getRangeAt(0);
                // content: as DOM FRAGMENT
                var content = range.extractContents();
                //CREATE tag as Node Object
                var node = d.createElement(tagName);
                    node.appendChild(content);
                    range.insertNode(node);
              }else{
                //DONT DO HERE because un-selected text
              }
            }
        },
        _isBreakLine: function(hasTagName, tagNameSelf){
            if( hasTagName == 'BLOCKQUOTE' ){
              // CMD: outdent [nested-left-div] is escapse current-range TAG then add new-line
              BasicWordEditor._fragmentCmd('ESCAPE_BLOCK');
            }else{
              var tagNameForNewLine = options.formatBlockParagraph;
              if(tagNameSelf.indexOf('H') == 0 ){
                tagNameForNewLine = tagNameSelf.toLowerCase();
                console.log(tagNameForNewLine);
              }
              /*
              WHY DELAY? BECAUSE BROWSER DEFAULT ONLY EXCEPT P, DIV TAG FOR NEW LINE
              SO, IN-CASE H1-H6 IS EJECTED SO WE MUST DELAY TO FORCE HEADING TAG AFTER BROWSER DONE!
              */
              setTimeout(function(){
                d.execCommand('formatBlock', false, tagNameForNewLine);
              }, 0);
            }

        },
        createPopUp: function(cmd){
          var el_popup = d.createElement('div');
              el_popup.setAttribute('class', options.cls.popup_container.substr(1));
          // WRAPPER
          var fullContent = '<div class="' + options.cls_no_dot.popup_wrapper + '">';
              fullContent += '<div class="' + options.cls_no_dot.popup_input_box + '">';
              fullContent += '<input type="file" name="image-upload" onchange="BasicWordEditor.readFile(this.files)"/>';
              fullContent += '</div>';
              fullContent += '<div class="' + options.cls.popup_button_action.substr(1) + '">';
              fullContent += '<button class="rc-button" name="upload" onclick="BasicWordEditor.sendToServer()">Upload</button>';
              fullContent += '<button class="rc-button" name="cancel" onclick="BasicWordEditor.closePopup()">Cancel</button>';
              fullContent += '</div>';
              fullContent += '<div class="' + options.cls.popup_image_loader.substr(1) + '"></div>';
              fullContent += '</div>';
              el_popup.innerHTML = fullContent;
          // WRAPPER END
          f.appendChild(el_popup);
        },
        createDropDownMenu: function(cmd, self){
            var el_container = self.querySelector(options.cls.dropdown_container);
            if( el_container.style.display == "block" ){
              //HIDE ALL : DROPDOWN
              BasicWordEditor.forceEffect(options.cls.button_cmd);
              //HIDE : self
              el_container.style.display = "none";
              return false;
            }else{
              //HIDE ALL : DROPDOWN; REMOVE BUTTON_CMD ACTIVE
              BasicWordEditor.forceEffect(options.cls.dropdown_container);
              //So use callback to Force [self] after Asynchronous{@forceEffect}
              BasicWordEditor.forceEffect(options.cls.button_cmd, 0, function(){BWE_f.addClass(self, options.cls_no_dot.button_cmd_is_hit_true);});
              //SHOW : self
              el_container.style.display = "block";

              if( cmd == '+fontName' | cmd == '+fontSize' ){
                var el_cmd_class_name = options.cls.font_name_cmd;
                if( cmd == '+fontSize' ){
                    el_cmd_class_name = options.cls.font_size_cmd;
                }
                var cmd_rule_valid = cmd.substr(1);
                var fullContent = '<div class="bwe-font-type bwe-line">';
                    fullContent += BasicWordEditor._createFontType_by_pallete(cmd_rule_valid, el_cmd_class_name);
                    fullContent +='</div>';
                    //innerHTML TO SHOW
                el_container.innerHTML = fullContent;
                //bindEvent : td with command
                BasicWordEditor.bindEvent('mousedown', el_cmd_class_name);

              }else if( cmd == '+headingSize' ){
                var fullContent = '<div class="bwe-heading-size bwe-line">';
                    fullContent += BasicWordEditor._createHeadingSize_by_pallete(cmd.substr(1), options.cls.heading_size_cmd);
                    fullContent +='</div>';
                    //innerHTML TO SHOW
                el_container.innerHTML = fullContent;
                //bindEvent : td with command
                BasicWordEditor.bindEvent('mousedown', options.cls.heading_size_cmd);

              }else if( cmd == '+colorMenu' ){

                var fullContent = '<table class="bwe-table-color" cellspacing="0" cellpadding="0">';
                    //HEADING
                    fullContent += '<tr>';
                    fullContent += '<td class="bwe-tb-cl-td-v1">Màu nền</td>';
                    fullContent += '<td class="bwe-tb-cl-td-v1">Màu văn bản</td>';
                    fullContent += '</tr>';
                    //BOX COLOR
                    fullContent += '<tr>';
                    for( var i in options.ids.table_color_map_cmd ){
                      var cmd = options.ids.table_color_map_cmd[i];
                      fullContent += '<td>';
                      var content_dark8 = BasicWordEditor._createTableColor_by_pallete(palette.table_color.colorDark8, cmd);
                      var content_ric8 = BasicWordEditor._createTableColor_by_pallete(palette.table_color.colorRic8, cmd);
                      var content_mix48 = BasicWordEditor._createTableColor_by_pallete(palette.table_color.colorMix48, cmd);
                      fullContent += '<div>'+ content_dark8 +'</div>';
                      fullContent += '<div>'+ content_ric8 +'</div>';
                      fullContent += '<div>'+ content_mix48 +'</div>';
                      fullContent +='</td>';
                    }
                    fullContent += '</tr>';
                    fullContent += '</table>';
                  //innerHTML TO SHOW
                  el_container.innerHTML = fullContent;
                  //bindEvent : td with command
                  BasicWordEditor.bindEvent('mousedown', options.cls.table_color_cmd);
              }
            }
        },
        _createFontType_by_pallete: function(cmd, el_cmd_class_name){
            console.log(cmd + ' _createFontType_by_pallete');
            var content = '', fontType_checked_class = '',
                prop_font_type = (cmd == 'fontName') ? 'family' : 'size',
                fontType_value_onStyle;
            //cmd: fontName or fontSize
            var collection_this_fontType = palette.font_type[cmd];
            for( var i in collection_this_fontType.value ){
              var fontType_value = collection_this_fontType.value[i];
              var fontType_name_display = collection_this_fontType.name_display[i];
              if( cmd == 'fontName' ){
                fontType_value_onStyle = fontType_value;
              }else{
                fontType_value_onStyle = collection_this_fontType.value_onStyle[i];
              }
              if( infoCurrentRange[cmd.toUpperCase()] == fontType_value ){
                fontType_checked_class = 'bwe-line-cmd-checked';
              }else{
                fontType_checked_class = '';
              }
              content += '<div class="bwe-line-cmd bwe-font-type-cmd ' + el_cmd_class_name.substr(1) + ' ' + fontType_checked_class + '" command="' + cmd + '" data-value="' + fontType_value + '" style="font-' + prop_font_type + ': '+ fontType_value_onStyle +';">' + fontType_name_display + '</div>';
            }
            return content;
        },
        _createHeadingSize_by_pallete: function(cmd, el_cmd_class_name){
            console.log(cmd + ' _createHeadingSize_by_pallete');
            var content = '', checked_class = '';
            //cmd: fontName or fontSize
            var headingSize = palette.heading_size;
            for( var i in headingSize.value ){
              var headingSize_value = headingSize.value[i];
              var headingSize_tag_name = headingSize.tag_name[i];

              if( infoCurrentRange['TAG_NAME_SELF'] == headingSize_tag_name.toUpperCase() ){
                checked_class = 'bwe-line-cmd-checked';
              }else{
                checked_class = '';
              }

              content += '<div class="bwe-line-cmd ' + el_cmd_class_name.substr(1) + ' ' + checked_class + '" command="' + cmd + '" data-tag-name="' + headingSize_tag_name + '" style="font-size: '+ headingSize_value +';">' + headingSize_tag_name + '</div>';
            }
            return content;
        },
        _createTableColor_by_pallete: function(palette_idx, cmd){
            var colorGroup = BWE_f.arrayChunk(palette_idx, 8);
            var content = '', color_checked_class = '', rgbFullSyntaxAndTrimSpace, A_PROP_TYPE_COLOR = cmd.toUpperCase();
            content += '<table class="bwe-table-color-inside" cellspacing="0" cellpadding="0">';

            //COMPARE [index] TO SET DEFAULT CHECKED ICON: to set @.bwe-color-checked
            var compare_i = ( A_PROP_TYPE_COLOR == 'BACKCOLOR' ) ? 7 : 0;

            for( var n in colorGroup ){
              content += '<tr>';
              for( var i in colorGroup[n] ){
                var rgb = colorGroup[n][i];
                rgbFullSyntaxAndTrimSpace = 'rgb(' + rgb.replace(/ /g, '') + ')';
                //SELECTED COMPARE COLOR-TABLE | SET DEFAULT
                if( infoCurrentRange[A_PROP_TYPE_COLOR] == rgbFullSyntaxAndTrimSpace || 
                    infoCurrentRange[A_PROP_TYPE_COLOR] == undefined & 
                    palette_idx == palette.table_color.colorDark8 & 
                    i == compare_i ){
                  color_checked_class = ' bwe-color-checked';
                }else{
                  color_checked_class = '';
                }

                content += '<td class="bwe-table-color-cmd' + color_checked_class + '" command="' + cmd + '" data-color="' + rgb + '"><div title="RGB (' + rgb + ')" style="background-color:rgb('+ rgb +');"></div></td>';
              }
              content += '</tr>';
            }
            content += '</table>';
            return content;
        },
        forceEffect: function(type, delay, callback){
            if( type == options.cls.dropdown_container ){
              //@.bwe-dropdown-container:
              var els_dropdown = d.querySelectorAll(options.cls.dropdown_container);
              for( var i = 0; i < els_dropdown.length; i++ ){
                els_dropdown[i].style.display = "none";
              }
            }else if( type == options.cls.button_cmd ){
              //@.bwe-btn:
              setTimeout(function(){
                var els_btn_cmd = d.querySelectorAll(options.cls.button_cmd);
                for( var i = 0; i < els_btn_cmd.length; i++ ){
                  BWE_f.removeClass(els_btn_cmd[i], options.cls_no_dot.button_cmd_is_hit_true);
                }
                if( callback ){
                  callback();
                }
              }, delay ? delay : 0);
            }
        },
        _setTextFontName: function(text){
            text = text ? text : palette.font_type.fontName.value[0];
            d.querySelector(options.cls.font_type_text_container).textContent = text;
        },
        _readyColorCompare: function(iColor){
          if( iColor.indexOf('#') != -1 ){
            iColor = BWE_f.hexToRgb(iColor);
          }else{
            iColor = iColor.replace(/ /g, '');
          }
          return iColor;
        },
        restartTooltip: function(){
            var el_tooltip = d.createElement('div'),
            el_body = d.getElementsByTagName('body')[0],
            offsetTooltip = {}, tooltipText, timeOut;
                el_tooltip.setAttribute('id', options.ids.tooltip);
                el_tooltip.innerHTML = '<div class="' + options.cls_no_dot.tooltip_text + '"></div><div class="' + options.cls_no_dot.tooltip_icon_wrapper + '"><div class="' + options.cls_no_dot.tooltip_icon + '2 ' + options.cls_no_dot.tooltip_icon + '"></div><div class="' + options.cls_no_dot.tooltip_icon + '1 ' + options.cls_no_dot.tooltip_icon + '"></div></div>';
            el_body.appendChild(el_tooltip);
            var elements_is_hover = d.querySelectorAll('[data-tooltip]');
            for (var i = 0; i < elements_is_hover.length; i++) {

              tooltipText = elements_is_hover[i].getAttribute('data-tooltip');
              // console.log(tooltipText);
              if ( tooltipText ) {
                // MOUSE-LEAVE
                elements_is_hover[i].addEventListener('mouseleave', function(event){
                  event.stopPropagation();
                  event.preventDefault();
                  // CLEAR OLD TIMEOUT
                  clearTimeout(timeOut);
                  el_tooltip.style.visibility = 'hidden';
                });
                // MOUSE-ENTER
                elements_is_hover[i].addEventListener('mouseenter', function(event){
                  event.preventDefault();
                  // event.stopPropagation();
                  // Cache to @curThis to force inside setTimeout
                  var curThis = this;
                  // DELAY BEFORE SHOW TOOLTIP
                  timeOut = setTimeout(function(){

                    tooltipText = curThis.getAttribute('data-tooltip');
                    // UPDATE TEXT : to get actual-width of TOOLTIP
                    console.log('DATA TOOLTIP :' + tooltipText);
                    var el_text = d.querySelector('.'+ options.cls_no_dot.tooltip_text);
                        el_text.textContent = tooltipText;
                    // GET OFFSET OF HOVER-ELEMENT
                    offsetTooltip.x = curThis.offsetLeft + curThis.offsetParent.offsetLeft;
                    offsetTooltip.y = curThis.offsetTop + curThis.offsetParent.offsetTop;
                    console.log('OFFSET= ' + offsetTooltip.x + ' : ' + offsetTooltip.y );
                    // CALCULATE : exceed width of substraction between TOOLTIP & HOVER-ELEMENT
                    var el_tooltip_width = el_tooltip.offsetWidth;
                    var el_is_hover_width = curThis.offsetWidth;
                    offsetTooltip.x = offsetTooltip.x - (el_tooltip_width - el_is_hover_width ) / 2; 
                    console.log(el_tooltip_width + ' : '+ el_is_hover_width);
                    // RESET & SHOW TOOLTIP
                    el_tooltip.style.left = offsetTooltip.x + 'px';
                    el_tooltip.style.top = (offsetTooltip.y + curThis.offsetHeight + 2) + 'px';
                    el_tooltip.style.visibility = 'visible';
                  
                  }, 500);

                });
              }
            }
        },
        readFile: function(files) {
            //Reset container wrapped images to zero when input on change
            var el_image_loader = d.querySelector(options.cls.popup_image_loader);
                el_image_loader.innerHTML = '';
            //LOOP FOR READ EVERY
            for (var i = 0; i < files.length; i++) {
              (function(file, i) {
                // SIZE IMAGE < 1Mb
                if ( file.size < (1024*1024) ){
                  var fullname = file.name;
                  var nameImg = fullname.split(".");
                  var FR = new FileReader();
                  FR.onload = function(e) {
                    //CACHING DATA-BASE64 IMG
                    var dataBase64Origin = e.target.result;
                    var idIMGpreview = 'imagePreview' + i;
                    var idCANVASpreview = 'canvasPreview' + i;
                    //PREVIEW TO GET WIDTH-HEIGHT FOR SET CANVAS W-H BEFORE UPLOAD : IMPORTANT
                    var el_canvasImage = d.createElement('canvas');
                        el_canvasImage.setAttribute('id', idCANVASpreview);
                    var ctx = el_canvasImage.getContext("2d");

                    var el_Image = d.createElement('img');
                        el_Image.setAttribute('src', dataBase64Origin);

                    var el_boundImage = d.createElement('div');
                        el_boundImage.classList.add('imageWrap');
                        el_boundImage.setAttribute('id', idIMGpreview);
                        el_boundImage.setAttribute('data-name', nameImg[0]);

                        el_boundImage.appendChild(el_canvasImage);
                        el_boundImage.appendChild(el_Image);
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
                        var dataBase64Canvas = el_canvasImage.toDataURL('image/jpeg', 0.8); //(type-jpeg, quality)
                        if (dataBase64Canvas) {
                            //REAL BASE64 FOR UPLOAD TO SERVER SIDE: IMPORTANT
                            el_boundImage.setAttribute('data-base64', dataBase64Canvas);
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
        sendToServer: function(serverFile, destinate){
            var el_image_loader = d.querySelector(options.cls.popup_image_loader);
            var el_image_loader_child_div = el_image_loader.querySelectorAll(':scope > div');
            if( el_image_loader_child_div.length > 0 ){
              // console.log(el_image_loader_child_div);
              //::: EXTRA - SHOW LOADER
              // $('.loader').show();
              //OBJECT DATA WILL SENT TO SERVER
              var streamInput = {}
              for( var key in el_image_loader_child_div ){

                if( el_image_loader_child_div.hasOwnProperty(key) ){
                  var curDiv = el_image_loader_child_div[key];
                  var name = curDiv.getAttribute('data-name');
                  var base64 = curDiv.getAttribute('data-base64');
                  // PUSH CONTENT INTO OBJECT
                  streamInput['DESTINATE'] = destinate;
                  streamInput['NAME'] = name;
                  streamInput['IMAGE'] = base64;
                  // CALL AJAX POST
                  var dataResponse = BasicWordEditor.postAjax('repo/stack/_editor/upload.php', JSON.stringify(streamInput), function(data){
                    if( data ){
                      console.log('Upload complete!'+ data);
                      BasicWordEditor.forceCommand('insertImage', null, data);
                      BasicWordEditor.closePopup();
                    }else{
                      console.log('Upload failed!');
                    }
                  });
                }
              }
            }else{
                alert('Hãy chọn ảnh từ máy tính trước!');
            }
        },
        postAjax: function(serverFile, dataSuggest, callback){
            // console.log(dataSuggest);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open("POST", serverFile, true);
            // METHOD POST IS NEEDED
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
        },
        closePopup: function(){
            BWE_f.removeElement( d.querySelector( options.cls.popup_container ) );
        },
        outputData: function(){
          return e.innerHTML;
        }

      }
  }
  // Init: 'BasicWordEditor', 'BWE_f' Contructors as OBJECT OF WINDOW
  // MAIN THREADS
  a.BasicWordEditor = new c;
  // FUNCTIONS SUPPORT
  a.BWE_f = new b;
  // AUTO INVOKE WITHOUT OPTIONS
  BasicWordEditor.invokeNow();
}(this);
</script>
<div id="bwe-container"></div>
<textarea id="_BWE-temp" style="display: none;"><?=$contentEditor;?></textarea>