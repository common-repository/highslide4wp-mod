<?php

function highslide_emoticons($static = false) {
	global $wpsmiliestrans;
	$closeAction = $static ? '' : 'return hs.close(\'emoticons\');';
	$emoticons = '';
	$smiled = array();
	foreach ($wpsmiliestrans as $tag => $grin) {
		if (!in_array($grin, $smiled)) {
			$smiled[] = $grin;
			$tag = str_replace(' ', '', $tag);
			$emoticons .= '<a href="javascript:void(0);" onclick="insertEmoticon(\' '.$tag.' \');' . $closeAction . '" style="margin-right:5px;"><img src="'.get_bloginfo('wpurl').'/wp-includes/images/smilies/'.$grin.'" alt="'.$tag.'"/></a>';
		}
	}

	$highslide_emoticon = '<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/highslide4wp/js/emoticons.js"></script>';
	$highslide_emoticon .= '<a title="Pick an Emote" href="javascript:void(0);" onclick="return hs.htmlExpand(this, { contentId: \'emoticons\' } )" class="highslide">';
	$highslide_emoticon .= '<img src="' . get_bloginfo('wpurl') . '/wp-includes/images/smilies/icon_smile.gif" alt="emoticons" />';
	$highslide_emoticon .= '</a>';
	$highslide_emoticon .= '<div class="highslide-html-content" id="emoticons" style="width:200px;">';
	$highslide_emoticon .= '<div class="highslide-body">';
	$highslide_emoticon .= $emoticons;
	$highslide_emoticon .= '</div>';
	$highslide_emoticon .= '<div class="highslide-header">';
	$highslide_emoticon .= '<ul>';
	$highslide_emoticon .= '<li class="highslide-close"><a href="#" onclick="return hs.close(this)">' . __('Close', 'highslide4wp') . '</a></li>';
	$highslide_emoticon .= '</ul>';
	$highslide_emoticon .= '</div>';
	$highslide_emoticon .= '</div>';

	echo $highslide_emoticon;
}

?>