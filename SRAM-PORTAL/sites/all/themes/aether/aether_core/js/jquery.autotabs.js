$ = jQuery.noConflict();
/*!
 * jQuery autotabs
 */

/*!
 * forked from:
 * Copyright (c) 2010 Keywan Ghadami
 * jQuery autotabs Plugin
 *
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */
(function($) {
  $.fn.title_tabs = function(options) {

  return this.each(function() {
    var tabs = $(this);

    var ul = $('<ul></ul>');
    tabs.prepend(ul);
    tabs.find('.tab').each(function(index){
      var legend = $(this).attr('title');
      if (legend == ''){
        legend = 'tab_' + index;
      }
      var id = $(this).attr('id');
      if (id == ''){
        id = 'tab_' + index;
        $(this).attr("id",id);
      }
      var tab_code = '<li><a href="#' + id + '">'+legend+'</a></li>';
      ul.append(tab_code);
    });
    return tabs.tabs(options);
  });
  };

  $.fn.fieldset_tabs = function(options) {
    return this.each(function() {
      var tabs = $(this);
      var $ul = $('<ul></ul>');
      tabs.prepend($ul);
      tabs.find('.device-layouts').not(tabs.find('.device-layouts fieldset')).each(function(index){
        var legend = $(this).find('legend').not(tabs.find('.user-layouts legend, .header-layouts legend, .navigation-layouts legend, .preface-layouts legend, .sidebar-layouts legend, .main-layouts legend, .postscript-layouts legend, .footer-layouts legend')).text();
        $(this).find('legend').not(tabs.find('.user-layouts legend, .header-layouts legend, .navigation-layouts legend, .preface-layouts legend, .sidebar-layouts legend, .main-layouts legend, .postscript-layouts legend, .footer-layouts legend')).remove();
        index = index + 1;
        var id = 'tab_' + index;
        $(this).attr("id",id);
        var tab_code = '<li><a class="device-'+index+'" href="#' + id + '">'+legend+'</a></li>';
        $ul.append(tab_code);
      });
      return tabs.tabs({
        /**
         * @code
         * tabs animation that prevents screen from jumping
         * http://stackoverflow.com/questions/243794/jquery-ui-tabs-causing-screen-to-jump
         */
        fx: { opacity: 'toggle', duration: 100 },
        select: function(event, ui) {
                jQuery(this).css('height', jQuery(this).height());
                jQuery(this).css('overflow', 'hidden');
        },
        show: function(event, ui) {
                jQuery(this).css('height', 'auto');
                jQuery(this).css('overflow', 'visible');
        }
      });
    });
  }

})(jQuery);
