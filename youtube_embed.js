(function () {
	tinymce.create ( 'tinymce.plugins.YoutubeEmbedPlugin', {
		init: function ( ed, url ) {
			ed.addCommand ( 'mceYoutubeEmbed', function () {
				ed.windowManager.open ( {
					file: url + '/youtube_embed_dialog.php',
					width: 350 + ed.getLang ( 'youtube_embed.delta_width', 0 ),
					height: 300 + ed.getLang ( 'youtube_embed.delta_height', 0 ),
					inline: 1
				}, {
					plugin_url: url
				} );
			} );

			ed.addButton ( 'youtube_embed', {
				title: 'Embed Youtube Video',
				cmd: 'mceYoutubeEmbed',
				image: url + '/img/youtube.png'
			} );
		},

		createControl: function ( n, cm ) {
			return null;
		},

		getInfo: function () {
			return {
				longname: 'Youtube Embed',
				author: 'Mouad Debbar',
				authorurl: 'http://twitter.com/mdebbar',
				version: tinymce.majorVersion + '.' + tinymce.minorVersion
			};
		}
	} );

	tinymce.PluginManager.add ( 'youtube_embed', tinymce.plugins.YoutubeEmbedPlugin );
}) ();
