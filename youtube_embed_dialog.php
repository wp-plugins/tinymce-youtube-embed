<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Embed a YouTube video</title>

	<script type="text/javascript" src="../../../wp-includes/js/jquery/jquery.js"></script>
	<script type="text/javascript" src="tiny_mce_popup.js?v=3211"></script>
	<script type="text/javascript">

		<?php
		$sizes = array (
			'normal' => array ( 'width'  => 420,
			                    'height' => 315 ),
			'large'  => array ( 'width'  => 640,
			                    'height' => 480 ),
		);
		?>

		patterns = [
			/youtube\.com\/watch?.*v=([^&]{8,})/,
			/youtu\.be\/(.{8,})/,
			/youtube\.com\/embed\/(.{8,})/
		];
		function getEmbedURL ( url ) {
			for ( var i in patterns ) {
				if ( m = url.match ( patterns[i] ) ) {
					return 'http://www.youtube.com/embed/' + m[1];
				}
			}
			throw 'Incorrect URL!';
		}

		function getSize () {
			var val = jQuery ( 'form input[name="size"]:checked' ).val ();
			if ( 'custom' == val ) {
				width = parseInt ( jQuery ( 'form input#custom_width' ).val () );
				height = parseInt ( jQuery ( 'form input#custom_height' ).val () );
			}
			else {
				size = val.split ( ',' );
				width = parseInt ( size[0].trim () );
				height = parseInt ( size[1].trim () );
			}

			if ( width <= 0 || height <= 0 ) {
				throw "Incorrect width/height!";
			}
			else if ( width < 100 || height < 100 ) {
				throw "Too small width/height";
			}
			return [width, height];
		}

		var YoutubeEmbedDialog = {
			local_ed: 'ed',
			init: function ( ed ) {
				YoutubeEmbedDialog.local_ed = ed;
				tinyMCEPopup.resizeToInnerSize ();
			},
			insert: function insertHighlightSection ( ed ) {
				try {
					var size = getSize ();
					var output = '<iframe width="' + size[0] + '" height="' + size[1] + '" src="' + getEmbedURL ( jQuery ( 'input#url' ).val () ) + '" frameborder="0" allowfullscreen="true"></iframe>';

					console.log ( output );
					YoutubeEmbedDialog.local_ed.selection.setContent ( output );

					tinyMCEPopup.close ();
				}
				catch ( e ) {
					alert ( e );
				}
			}
		};
		tinyMCEPopup.onInit.add ( YoutubeEmbedDialog.init, YoutubeEmbedDialog );
		document.write ( '<base href="' + tinymce.baseURL + '" />' );
	</script>

	<style>
		a {
			text-decoration: none;
			font-weight: bold;
		}

		body {
			font-size: 10pt;
		}

		div#form {
			margin-top: 5px;
			padding-top: 10px;
			font-family: Arial, serif;
		}

		input {
			font-family: Arial, serif;
			font-size: 11px;
		}

		input[type="submit"] {
			padding: 3px 8px;
			background: url("img/button-grad.png") repeat-x scroll left top #21759B;
			border: 1px solid #298CBA;
			border-radius: 11px 11px 11px 11px;
			cursor: pointer;
			line-height: 13px;
			color: #FFFFFF;
			font-weight: bold;
			font-size: 12px !important;
			text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.3);
		}

		input[type="submit"]:hover {
			background: url("img/button-grad-active.png") repeat-x scroll left top #21759B;
		}
	</style>
	<base target="_self" />
</head>
<body>
<div align="left" id="youtube-dialog">
	<?php
	$url = ( ! empty( $_SERVER['HTTPS'] ) ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	?>
	<a href="http://www.youtube.com" title="YouTube" target="_blank">
		<img src="<?php echo dirname( $url ); ?>/img/big_youtube.png" alt="YouTube.com" />
	</a>

	<form action="/" method="get" accept-charset="utf-8">
		<div id="form">
			<fieldset>
				<legend>URL</legend>
				<input type="text" name="url" value="" id="url" size="50" />
			</fieldset>
			<br />
			<fieldset>
				<legend>Size</legend>
				<?php $first = true; ?>
				<?php foreach ( $sizes as $k => $size ) : ?>
				<input type="radio" id="<?php echo $k; ?>" name="size"
				       value="<?php echo "{$size['width']},{$size['height']}" ?>"
					<?php if ( $first ) {
					echo 'checked="checked"';
					$first = false;
				} ?> />
				<label
					for="<?php echo $k; ?>"><strong><?php echo ucfirst( $k ), " ({$size['width']} x {$size['height']})"; ?></strong></label>
				<br />
				<?php endforeach; ?>
				<input type="radio" id="custom" name="size" value="custom" />
				<label for="custom"><strong>Custom:</strong></label>
				<label for="custom_width">Width:</label><input type="text" id="custom_width" size="4"
				                                               onfocus="jQuery('input[name=\'size\']').attr('checked','checked')" />px
				<label for="custom_height">Height:</label><input type="text" id="custom_height" size="4"
				                                                 onfocus="jQuery('input[name=\'size\']').attr('checked','checked')" />px
			</fieldset>
			<br />
			<input type="submit" value="Embed &rarr;"
			       onclick="YoutubeEmbedDialog.insert(YoutubeEmbedDialog.local_ed);return false;" />
		</div>
		<br />
		<!--		<a href="javascript:YoutubeEmbedDialog.insert(YoutubeEmbedDialog.local_ed)" title="Embed the YouTube video">Embed &rarr;</a>
		-->
	</form>
</div>
</body>
</html>