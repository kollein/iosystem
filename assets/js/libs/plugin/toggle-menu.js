;
(function ($, window, undefined) {
  'use strict';

  var pluginName = 'toggle-menu',
    ele,
    opts,
    that,
    body;


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
      body = $('body');
      // open
      $(opts.bars).on('click', function () {
        ele.addClass('show');
        that.stopBodyScrolling(true);
      });
      // close
      $(opts.dissmiss).on('mousedown touchstart', function () {
        ele.removeClass('show');
        that.stopBodyScrolling(false);
      });
      // ESC to close
      $(window).keyup(function (e) {
        e.preventDefault();
        e.keyCode === 27 && ele.removeClass('show') && that.stopBodyScrolling(false);
      });
      // active item
      var list = ele.find(opts.list);
      list.find('[' + opts.dtId + '="' + list.attr(opts.dtActiveId) + '"] ' + opts.link).addClass('active');
    },
    stopBodyScrolling: function (bool) {
      if (bool === true) {
        body.css('overflow', 'hidden');
      } else {
        body.css('overflow', '');
      }
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
    bars: '.bar3line-wrapper',
    dissmiss: '[data-action-dissmiss]',
    list: '.list-wrapper',
    link: '.link',
    dtActiveId: 'data-active-id',
    dtId: 'data-id'
  };

  $(function () {
    $('[data-' + pluginName + ']')[pluginName]({

    });
  });

}(jQuery, window));