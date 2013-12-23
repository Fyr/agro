<?
/**
 * Preloads images. 
 * @param array $images - images (full path) to preload
 * 
 */

foreach($images as &$image) {
	if (strpos($image, '/') === false) {
		$image = '/img/'.$image;
	}
}
?>

<script type="text/javascript"> 
/*
(function($) {
  var cache = [];
  $.preLoadImages = function() {
    var args_len = arguments.length;
    for (var i = args_len; i--;) {
      var cacheImage = document.createElement('img');
      cacheImage.src = arguments[i];
      cache.push(cacheImage);
    }
  }
})(jQuery)

jQuery.preLoadImages("<?=implode('", "', $images)?>");
*/
jQuery.preloadImages = function () {
    if (typeof arguments[arguments.length - 1] == 'function') {
        var callback = arguments[arguments.length - 1];
    } else {
        var callback = false;
    }
    if (typeof arguments[0] == 'object') {
        var images = arguments[0];
        var n = images.length;
    } else {
        var images = arguments;
        var n = images.length - 1;
    }
    var not_loaded = n;
    for (var i = 0; i < n; i++) {
        jQuery(new Image()).attr('src', images[i]).load(function() {
            if (--not_loaded < 1 && typeof callback == 'function') {
                callback();
            }
        });
    }
}
$(document).ready(function () {
    $.preloadImages(["<?=implode('", "', $images)?>"], function () {
         // alert('Load complete!');
    });
});
</script>
