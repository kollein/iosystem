/* SCROLL TO LOAD : GRID ITEM */
;(function ($, window, undefined) {
  'use strict';

  var pluginName = 'stl-grid-item',
    ele,
    opts,
    that,
    statusRequest = 'done',
    $cachedQuery, $contentWrapper, $loaderWrapper;


  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function () {
      ele = this.element;
      opts = this.options;
      that = this;
      $cachedQuery = ele.find(opts.cachedQuery);
      $contentWrapper = ele.find(opts.contentWrapper);
      $loaderWrapper = ele.find(opts.loaderWrapper);

      that.request('default');
      //Scroll
      var lastScrollTop = 0;

      $(window).on('load scroll', function (event) {
        var trackScrollTop = $(this).scrollTop();
        
        if (trackScrollTop > lastScrollTop) {
          //console.log("direction down");
          if( $(window).scrollTop() + $(window).height() >= $(document).height() - opts.minusHeight ) {
            that.request('loadmore');
          }
        }
        // update
        lastScrollTop = trackScrollTop;
      });
    },
    request: function (state) {
      
      if ( statusRequest === 'done' ) {
        statusRequest = 'pending';
        // SHOW LOADER ICON
        $loaderWrapper.addClass('active');
        $loaderWrapper.append(make_loader_icon_html('40px'));
        // CALL AJAX
        var data = {
          "state": state,
          "url": url_base + '/xhr/router/grid_item/',
          "query": $cachedQuery.val()
        }
        
        $.post(data.url, {
          query: data.query,
          state: data.state
        }).done(function(data) {
          data = JSON.parse(data);
          $cachedQuery.val(data.query);
          $loaderWrapper.removeClass('active');
          $loaderWrapper.html('');

          if ( data.items.length > 0 ) {
            var templateStr = that.buildTemplate(data.items);
            $contentWrapper.append(templateStr);
            statusRequest = 'done';
          } else {
            // No item to loadmore
            statusRequest = 'over';
          }
        });
      }
    },
    buildTemplate: function (items) {
      var str = '',
          itemsLength = items.length;

      for ( var i = 0; i < itemsLength; i++ ) {
        var item = items[i],
            multitab_icon = item.multitab > 1 ? '<span class="block-icon multitab-ig-icon ig-sprite"></span>' : '';
        str += '' +
          '<div class="grid-item" data-popup-item data-id="' + i + '">' +
            '<a href="' + item.link + '" class="link">' +
              '<img class="item-img imgCover" data-popup-item src="' + item.imgUrl + '">' +
              '<div class="grid-item-abs">' +
                '<div class="icon-box">' +
                  multitab_icon +
                '</div>' +
              '</div>' +
            '</a>' +
          '</div>';
      }
      return str;
    },
    destroy: function () {
      $.removeData(this.element[0], pluginName);
    }
  };

  $.fn[pluginName] = function (options, params) {
    return this.each(function () {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      }
    });
  };

  $.fn[pluginName].defaults = {
    contentWrapper: '[data-content]',
    loaderWrapper: '[data-loader]',
    cachedQuery: '[data-query]',
    minusHeight: 400
  };

  $(function () {
    $('[data-' + pluginName + ']')[pluginName]({

    });
  });

}(jQuery, window));