/**
 * Установка и инициализация плагина ввода.
 */
!(function($) {

  var $container = null;
  var $input = null;
  var $list = null;

  function init($properties) {
    $input = $properties.find('[type=hidden]');
    $list = $properties.find('ul');

    var json = $properties.attr('data-properties-input');
    var list = $.parseJSON(json);

    $list.tagit({
      availableTags: list,
      singleField: true,
      singleFieldNode: $input,
      allowDuplicates: true,
      singleFieldDelimiter: ';',
      allowSpaces: true
    });
  }

  function paste($node) {
    var text = $node.text();
    var $new = $list.find('input');

    $new.val(text);

    $new.trigger($.Event('keydown', {
      keyCode: 13,
      which: 13
    }));

    var v = $input.val();
    console.log(v);
  }

  $(document).ready(function() {
    $container = $('[data-properties-input]');
    init($container);
  });

  $(document).on('click', '[data-properties-paste]', function(e) {
    e.preventDefault();
    var $node = $(this);
    paste($node);
  });

})(window.jQuery);