;
(function ($, window, undefined) {
  'use strict';

  var pluginName = 'popup',
    ele,
    opts,
    that,
    $body;


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
      $body = $('body');

      $body.on('click', function(event) {
        var $target = $(event.target);
        var $container = $target.closest(opts.container);
        var $item = $target.closest(opts.item);
        console.log($item);
        if ( $container.length ) {
          var $items = $container.find(opts.item);
          var strTemplate = that.compileTemplate($items);

          $body.append(strTemplate);
          $(opts.dissmiss).on('click', that.closePopup);

          var swiper = new Swiper('.popup-slider', {
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            }
          });
          var index = $item.data('id');
          swiper.slideTo(index, 0, false);
        }
      });
    },
    compileTemplate: function ($items) {
      var str = '<div class="popup-container">' +
                  '<div class="dissmiss" data-dissmiss><div class="icon-close"></div></div>' +
                  '<div class="popup-slider swiper-container">' +
                    '<div class="swiper-wrapper">';
          $items.each(function() {
            var item = $(this).find('img');
            str += '' +  
                '<div class="swiper-slide">' +
                  '<img class="item-img imgCover" src="' + item.attr('src') + '"/>' +
                '</div>';
          });          
                      
          str +=    '</div>' +
                    '<div class="swiper-button-next"></div>' +
                    '<div class="swiper-button-prev"></div>' +
                  '</div></div>';
      return str;
    },
    closePopup: function() {
      $(opts.popupContainer).remove();
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
    container: '[data-popup]',
    item: '[data-popup-item]',
    popupContainer: '.popup-container',
    dissmiss: '[data-dissmiss]'
  };

  $(function () {
    $('[data-' + pluginName + ']')[pluginName]({

    });
  });

}(jQuery, window));