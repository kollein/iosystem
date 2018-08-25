;
(function ($, window, undefined) {
  'use strict';

  var pluginName = 'header-scroll',
    ele,
    opts,
    that;


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
      // 
      //Scroll: Invoke @header
      var lastScrollTop = 0,
        headerHeight = $('header').outerHeight();
      $(window).on('load scroll', function () {
        var trackScrollTop = $(this).scrollTop();

        if (trackScrollTop > lastScrollTop) {
          //console.log("direction down");
          if (trackScrollTop > headerHeight) {
            $('header').addClass('hasScroll');
          }
        } else {
          //console.log("direction up");
          if (trackScrollTop < headerHeight) {
            $('header').removeClass('hasScroll');
          }
        }
        // update
        lastScrollTop = trackScrollTop;
      });
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

  };

  $(function () {
    $('[data-' + pluginName + ']')[pluginName]({

    });
  });

}(jQuery, window));