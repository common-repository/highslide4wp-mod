<?php
/*
Plugin Name: Highslide4WP-mod
Plugin URI: http://wordpress.org/extend/plugins/highslide4wp-mod/
Description: This plugin allows you easily to make <a href="http://highslide.com/">Highslide</a> popups on WordPress and gallery slideshow with nextgen-gallery.
Version: 2.5
Highslide Version: 4.0.5
Author: benzon
Author URI: http://soeren.benzon.org/downloads/?did=1
*/

/** l10n */
load_plugin_textdomain('highslide4wp-mod', "/wp-content/plugins/highslide4wp-mod/languages/");

function highslide_head_admin() {
	if (function_exists('wp_list_comments')) {
		print('<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/highslide4wp-mod/css/admin_27.css" type="text/css" />');
	} else {
		print('<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/highslide4wp-mod/css/admin_26.css" type="text/css" />');
	}
	print('
<script type="text/javascript" src="'.get_bloginfo('wpurl').'/index.php?ak_action=highslide_js"></script>
<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/highslide4wp-mod/js/admin.js"></script>
	');
}

function highslide_head() {
	print('
<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/highslide4wp-mod/highslide/highslide.css" type="text/css" />
<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/highslide4wp-mod/highslide/highslide-with-html.packed.js"></script>
<script type="text/javascript">
	hs.graphicsDir = "'.get_bloginfo('wpurl').'/wp-content/plugins/highslide4wp-mod/highslide/graphics/";
	hs.outlineType = "rounded-white";
	hs.outlineWhileAnimating = true;
	hs.showCredits = false;
</script>
	');

echo "
<script type='text/javascript'>
//<![CDATA[

hs.showCredits = 0;
hs.padToMinWidth = true;
hs.lang.number = 'Image %1 of %2';

//hs.align = 'center';
if (hs.registerOverlay) {
	// The white controlbar overlay
	hs.registerOverlay({
		thumbnailId: 'thumb3',
    	overlayId: 'controlbar',
    	position: 'top right',
    	hideOnMouseOut: true
	});
	// The simple semitransparent close button overlay
	hs.registerOverlay({
		thumbnailId: 'thumb2',
		overlayId: 'closebutton',
		position: 'top right',
		fade: 2 // fading the semi-transparent overlay looks bad in IE
	});
}

// ONLY FOR THIS EXAMPLE PAGE!
// Initialize wrapper for rounded-white. The default wrapper (drop-shadow)
// is initialized internally.
if (hs.addEventListener && hs.Outline) hs.addEventListener(window, 'load', function () {
	new hs.Outline('rounded-white');
	new hs.Outline('glossy-dark');
});

// The gallery example on the front page
var galleryOptions = {
	slideshowGroup: 'gallery',
	captionEval: 'this.a.title',
	numberPosition: 'heading',
	wrapperClassName: 'glossy-dark',
	outlineType: 'glossy-dark',
	dimmingOpacity: 0.9,
	align: 'center',
	transitions: ['expand', 'crossfade']
};

if (hs.addSlideshow) hs.addSlideshow({
    slideshowGroup: 'gallery',
    interval: 3500,
    repeat: false,
    useControls: true,
	fixedControls: 'fit',
    overlayOptions: {
        opacity: .75,
        position: 'bottom center',
        hideOnMouseOut: true
	}
});

//]]>
</script>
";
}

function highslide_js() {

	if (isset($_GET['ak_action']) && $_GET['ak_action'] == 'highslide_js') {
		header("Content-type: text/javascript");

		/* image START */
		$highslide_image = '<div class="highslide-box">';
		$highslide_image .= '<div class="caption">' . __('Highslide Image', 'highslide4wp-mod') . '</div>';
		$highslide_image .= '<a class="close" href="javascript:void(0);" onclick="hideHighslideDialog();"><img src="'.get_bloginfo('wpurl').'/wp-content/plugins/highslide4wp-mod/images/tb-close.png" alt="Cancel" /></a>';
		$highslide_image .= '<div class="content">';
		$highslide_image .= '<div>';
		$highslide_image .= '<label class="highslide-label">' . __('Thumbnail URL: (required)', 'highslide4wp-mod') . '</label>';
		$highslide_image .= '<input id="highslide_thumbnail" class="highslide-textfield" type="text" />';
		$highslide_image .= '</div>';
		$highslide_image .= '<div>';
		$highslide_image .= '<label class="highslide-label">' . __('Fullsize URL: (required)', 'highslide4wp-mod') . '</label>';
		$highslide_image .= '<input id="highslide_fullsize" class="highslide-textfield" type="text" />';
		$highslide_image .= '</div>';
		$highslide_image .= '<div>';
		$highslide_image .= '<label class="highslide-label">' . __('Description:', 'highslide4wp-mod') . '</label>';
		$highslide_image .= '<textarea id="highslide_description" class="highslide-textfield" row="" col=""></textarea>';
		$highslide_image .= '<div class="bottom">';
		$highslide_image .= '<div class="buttons">';
		$highslide_image .= '<a class="button" href="javascript:void(0);" onclick="insertHighslide(\'image\');" title="Insert image with Highslide">' . __('Insert image', 'highslide4wp-mod') . '</a>';
		$highslide_image .= '</div>';
		$highslide_image .= '<div style="clear:both;"></div>';
		$highslide_image .= '</div>';
		$highslide_image .= '<div style="clear:both;"></div>';
		$highslide_image .= '</div>';
		$highslide_image .= '<div style="clear:both;"></div>';
		$highslide_image .= '</div>';
		$highslide_image .= '</div>';
		/* image START */

		/* emoticon START */
		global $wpsmiliestrans;
		$emoticons = '';
		$smiled = array();
		foreach ($wpsmiliestrans as $tag => $grin) {
			if (!in_array($grin, $smiled)) {
				$smiled[] = $grin;
				$tag = str_replace(' ', '', $tag);
				$emoticons .= '<img class="emoticon" src="'.get_bloginfo('wpurl').'/wp-includes/images/smilies/'.$grin.'" alt="'.$tag.'" onclick="insert(\' '.$tag.' \');" /> ';
			}
		}
		$user_id = (int)$user_id;
		$current_color = get_user_option('admin_color', $user_id);
		if (empty($current_color)) {
			$current_color = 'fresh';
		}
		/* emoticon END */

		$highslide_admin = '<iframe id="highslide-panel" frameborder="0" src="'.get_bloginfo('wpurl').'/wp-content/plugins/highslide4wp-mod/css/cushion.html"></iframe>';
		$highslide_admin .= '<div id="highslide-dialog">';
		$highslide_admin .= '<div id="highslide-image-dialog">'.$highslide_image.'</div>';
		$highslide_admin .= '</div>';
?>

function loadHighslide_26() {
	if((document.getElementById('postdiv') || document.getElementById('postdivrich')) && document.getElementById('wphead')) {

		var highslideDiv = document.createElement('div');
		highslideDiv.id = 'wp-highslide';
		var node = document.getElementById('wphead');

		highslideDiv.innerHTML = '<?php print(str_replace("'", "\'", $highslide_admin)); ?>';
		node.parentNode.insertBefore(highslideDiv, node);

		var mediaToolbar = document.getElementById('editor-toolbar');
		var mediaButtons = document.getElementById('media-buttons');

		if(mediaToolbar) {
			mediaToolbar.className = 'highslide-<?php print(str_replace("'", "\'", $current_color)); ?>';

			// image
			var image = document.createElement('a');
			var imageIcon = document.createElement('img');
			imageIcon.src = '<?php print(get_bloginfo('wpurl')); ?>/wp-content/plugins/highslide4wp-mod/images/image-x-generic.gif';
			imageIcon.alt = 'Image';
			image.id = 'highslide-image';
			image.href = 'javascript:void(0)';
			image.onclick = callHighslideDialog;
			image.title = 'Insert image with Highslide';
			image.appendChild(imageIcon);
			insertAfter(image, mediaButtons);

			// emoticon
			var emoticon = document.createElement('a');
			var emoticonIcon = document.createElement('img');
			emoticonIcon.src = '<?php print(get_bloginfo('wpurl')); ?>/wp-content/plugins/highslide4wp-mod/images/face-smile.gif';
			emoticonIcon.alt = 'Emoticon';
			emoticon.id = 'highslide-emoticon';
			emoticon.href = 'javascript:void(0)';
			emoticon.onclick = callEmoticonBar;
			emoticon.title = 'Select an emoticon';
			emoticon.appendChild(emoticonIcon);
			insertAfter(emoticon, mediaButtons);

			// title
			var title = document.createElement('div');
			var titleText = document.createTextNode('Highslide4WP-mod:');
			title.id = 'highslide-title';
			title.appendChild(titleText);
			insertAfter(title, image);

			// emoticon bar
			var emoticonBar = document.createElement('div');
			emoticonBar.id = 'highslide-emoticon-bar';
			emoticonBar.className = 'highslide-emoticon-bar-<?php print(str_replace("'", "\'", $current_color)); ?>';
			emoticonBar.innerHTML = '<?php print(str_replace("'", "\'", $emoticons)); ?>';
			insertAfter(emoticonBar, mediaToolbar);
		}

	} else {
		return;
	}
}

function loadHighslide_27() {
	if((document.getElementById('postdiv') || document.getElementById('postdivrich')) && document.getElementById('wphead')) {

		var highslideDiv = document.createElement('div');
		highslideDiv.id = 'wp-highslide';
		var node = document.getElementById('wphead');

		highslideDiv.innerHTML = '<?php print(str_replace("'", "\'", $highslide_admin)); ?>';
		node.parentNode.insertBefore(highslideDiv, node);

		var postStatus = document.getElementById('post-status-info');

		if(postStatus) {

			// highslide box
			var highslideBox = document.createElement('div');
			highslideBox.id = 'highslide-box';
			insertAfter(highslideBox, postStatus);

			// fixed box
			var fixedBox = document.createElement('div');
			fixedBox.style.clear = 'both';
			insertAfter(fixedBox, highslideBox);

			// title
			var title = document.createElement('div');
			var titleText = document.createTextNode('Highslide4WP-mod ');
			title.id = 'highslide-title';
			title.appendChild(titleText);
			highslideBox.appendChild(title);

			// image
			var image = document.createElement('a');
			var imageIcon = document.createElement('img');
			imageIcon.src = '<?php print(get_bloginfo('wpurl')); ?>/wp-content/plugins/highslide4wp-mod/images/image-x-generic.gif';
			imageIcon.alt = 'Image';
			image.id = 'highslide-image';
			image.href = 'javascript:void(0)';
			image.onclick = callHighslideDialog;
			image.title = 'Insert image with Highslide';
			image.appendChild(imageIcon);
			highslideBox.appendChild(image);

			// emoticon
			var emoticon = document.createElement('a');
			var emoticonIcon = document.createElement('img');
			emoticonIcon.src = '<?php print(get_bloginfo('wpurl')); ?>/wp-content/plugins/highslide4wp-mod/images/face-smile.gif';
			emoticonIcon.alt = 'Emoticon';
			emoticon.id = 'highslide-emoticon';
			emoticon.href = 'javascript:void(0)';
			emoticon.onclick = callEmoticonBar;
			emoticon.title = 'Select an emoticon';
			emoticon.appendChild(emoticonIcon);
			highslideBox.appendChild(emoticon);

			// fixed box
			var fixedBox = document.createElement('div');
			fixedBox.style.clear = 'both';
			insertAfter(fixedBox, emoticon);

			// emoticon bar
			var emoticonBar = document.createElement('div');
			emoticonBar.id = 'highslide-emoticon-bar';
			emoticonBar.innerHTML = '<?php print(str_replace("'", "\'", $emoticons)); ?>';
			highslideBox.appendChild(emoticonBar);
		}

	} else {
		return;
	}
}

function loadHighslide() {
<?php if (function_exists('wp_list_comments')) : ?>
	loadHighslide_27();
<?php else : ?>
	loadHighslide_26();
<?php endif; ?>
}

if (document.addEventListener) {
	document.addEventListener("DOMContentLoaded", loadHighslide, false);

} else if (/MSIE/i.test(navigator.userAgent)) {
	document.write('<script id="__ie_onload_for_highslide4wp" defer src="javascript:void(0);"></script>');
	var script = document.getElementById("__ie_onload_for_highslide4wp");
	script.onreadystatechange = function() {
		if (this.readyState == 'complete') {
			loadHighslide();
		}
	}

} else if (/WebKit/i.test(navigator.userAgent)) {
	var _timer = setInterval( function() {
		if (/loaded|complete/.test(document.readyState)) {
			clearInterval(_timer);
			loadHighslide();
		}
	}, 10);

} else {
	window.onload = function(e) {
		loadHighslide();
	}
}

<?php
		die();
	}
}

/** toys */
include ('toys.php');

add_action('init', 'highslide_js');
add_action('wp_head', 'highslide_head');
add_action('admin_head', 'highslide_head_admin');

?>
