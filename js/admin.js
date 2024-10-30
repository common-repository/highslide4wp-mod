// String.replaceAll(arg0, arg1):String
String.prototype.replaceAll = function(pattern, replacement) {
	return this.split(pattern).join(replacement);
}

// String.trim():String
String.prototype.trim = function() {
	return this.replace(/(^\s+)|(\s+$)/g, "");
}

function insertAfter(node, referenceNode) {
	referenceNode.parentNode.insertBefore(node, referenceNode.nextSibling);
}

function checkHighslide(type) {
	var flag = true;
	if(type == "image") {
		if(document.getElementById("highslide_thumbnail").value.trim() == "") {
			alert("Thumbnail URL is required.");
			flag = false;
		} else if(document.getElementById("highslide_fullsize").value.trim() == "") {
			alert("Fullsize Image URL is required.");
			flag = false;
		}
	}
	return flag;
}

/* image START */
function callHighslideDialog() {
	var panel = document.getElementById("highslide-panel");
	panel.style.height = document.body.scrollHeight + "px";
	panel.style.display = "block";
	if (!window.ActiveXObject) {
		panel.style.position = "fixed";
	}

	var dialog = document.getElementById("highslide-dialog");
	dialog.style.top = "175px";
	dialog.style.left = (document.body.scrollWidth - 500) / 2 + "px";
	dialog.style.display = "block";
	if (!window.ActiveXObject) {
		dialog.style.position = "fixed";
	}

	var activeDialog = document.getElementById("highslide-image-dialog");
	activeDialog.style.visibility = "visible";
	activeDialog.style.display = "block";

	document.getElementById("highslide_thumbnail").value = "";
	document.getElementById("highslide_fullsize").value = "";
	document.getElementById("highslide_description").value = "";
}

function hideHighslideDialog() {
	var panel = document.getElementById("highslide-panel");
	panel.style.display = "none";

	var dialog = document.getElementById("highslide-dialog");
	dialog.style.display = "none";

	var activeDialog = document.getElementById("highslide-image-dialog");
	activeDialog.style.display = "none";
}

function insertHighslide(type) {
	// check input
	var flag = checkHighslide(type);
	if(!flag) {
		return;
	}

	// get the unique id.
	var content_id = 'content_' + new Date().getTime();
	var caption_id = 'caption_' + new Date().getTime();
	// this code will be insert into the textbox.

	if(type == 'image') {
		var code = '<a href="@@01" onclick="return hs.expand(this@@04);" class="highslide-image">';
		code += '<img src="@@02" alt="image" title="Click to enlarge" />';
		code += '</a>';
		code += '@@03';

		var f = document.getElementById('highslide_fullsize').value.trim();
		var t = document.getElementById('highslide_thumbnail').value.trim();
		var d = document.getElementById('highslide_description').value.trim();

		code = code.replace('@@01', f);
		code = code.replace('@@02', t);
		if(d != '') {
			code = code.replace('@@03', '<div class="highslide-caption" id="' + caption_id + '">' + d + '</div>');
			code = code.replace('@@04', ', {captionId:\'' + caption_id + '\'}');
		} else {
			code = code.replace('@@03', '');
			code = code.replace('@@04', '');
		}
	}

	insert(code);

	// reset
	if(type == 'image') {
		document.getElementById('highslide_fullsize').value = '';
		document.getElementById('highslide_thumbnail').value = '';
		document.getElementById('highslide_description').value = '';
	}

	// close the dialog
	hideHighslideDialog();
}
/* image END */

/* emoticon START */
function callEmoticonBar() {
	var emoticonButton = document.getElementById("highslide-emoticon");
	var emoticonBar = document.getElementById("highslide-emoticon-bar");
	var emoticonStatus = emoticonBar.style.display;
	if (emoticonStatus == "block") {
		emoticonButton.className = "";
		emoticonBar.style.display = "none";
	} else {
		emoticonButton.className = "highslide-active";
		emoticonBar.style.display = "block";
	}
}
/* emoticon END */

function insert(insertStr) {
	var myField;
	if (document.getElementById('content') && document.getElementById('content').type == 'textarea') {
		myField = document.getElementById('content');
		if (document.getElementById('postdivrich') && typeof tinyMCE != 'undefined' && !document.getElementById('edButtons') && document.getElementById('quicktags').style.display == 'none') {

			// for WordPress 2.5
			var w = window.dialogArguments || opener || parent || top;
			var tinymce = w.tinymce;
			var editor = tinymce.EditorManager.activeEditor;
			editor.execCommand('mceInsertContent', false, insertStr);

			// for WordPress 2.3, delete...
			//tinyMCE.execInstanceCommand('mce_editor_0', 'mceInsertContent', false, insertStr);
			//tinyMCE.selectedInstance.repaint();

			return;
		}
	} else {
		return false;
	}

	if(document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = insertStr;
		myField.focus();

	} else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var cursorPos = startPos;
		myField.value = myField.value.substring(0, startPos)
					  + insertStr
					  + myField.value.substring(endPos, myField.value.length);
		cursorPos += insertStr.length;
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;

	} else {
		myField.value += insertStr;
		myField.focus();
	}
}
