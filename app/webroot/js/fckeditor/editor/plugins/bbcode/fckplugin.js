
FCK.DataProcessor =
{
	/*
	 * Returns a string representing the HTML format of "data". The returned
	 * value will be loaded in the editor.
	 * The HTML must be from <html> to </html>, eventually including
	 * the DOCTYPE.
	 *     @param {String} data The data to be converted in the
	 *            DataProcessor specific format.
	 */
	ConvertToHtml : function( data )
	{

		data = data.replace( /&/gi, '&amp;' ) ;
		data = data.replace( /"/gi, '&quot;' ) ;
		data = data.replace( /</gi, '&lt;' ) ;
		data = data.replace( />/gi, '&gt;' ) ;

		// Convert line breaks to <br>.
        data = data.replace( /(?:\r\n|\n|\r)/g, '<br />' ) ;

		// [quote]
        data = data.replace( /\[quote\](.+?)\[\/quote\]/gi, '<div class=\"quote\">$1</div>' ) ;
		data = data.replace( /\[quote=(.+?)\](.+?)\[\/quote\]/gi, '<div class=\"quote\">$2</div>' ) ;

		// [hide]
        data = data.replace( /\[hide\](.+?)\[\/hide\]/gi, '<div class=\"hide\">$1</div>' ) ;

		// [pre]
        data = data.replace( /\[pre\](.+?)\[\/pre\]/gi, '<pre>$1</pre>' ) ;

		// [code]
        data = data.replace( /\[code\](.+?)\[\/code\]/gi, '<pre name=\"code\" class=\"text\">$1</pre>' ) ;
		data = data.replace( /\[highlight=(.+?)\](.+?)\[\/highlight\]/gi, '<pre name=\"code\" class=\"$1\">$2</pre>' ) ;

		// [h1]
        data = data.replace( /\[h1\](.+?)\[\/h1\]/gi, '<h1>$1</h1>' ) ;

		// [h2]
        data = data.replace( /\[h2\](.+?)\[\/h2\]/gi, '<h2>$1</h2>' ) ;

		// [h3]
        data = data.replace( /\[h3\](.+?)\[\/h3\]/gi, '<h3>$1</h3>' ) ;

		// [h4]
        data = data.replace( /\[h4\](.+?)\[\/h4\]/gi, '<h4>$1</h4>' ) ;

		// [h5]
        data = data.replace( /\[h5\](.+?)\[\/h5\]/gi, '<h5>$1</h5>' ) ;

		// [h6]
        data = data.replace( /\[h6\](.+?)\[\/h6\]/gi, '<h6>$1</h6>' ) ;

		// [more]
        data = data.replace( /\[more]/gi, '&lt;--more--&gt;' ) ;

		// [spoiler]
        data = data.replace( /\[spoiler=(.+?)\](.+?)\[\/spoiler\]/gi, '<div class=\"spoiler\">$2</div>' ) ;

		// [size]
        data = data.replace( /\[size=(.+?)\](.+?)\[\/size\]/gi, '<span style=\"font-size:$1;\">$2</span>' ) ;

		// [font]
        data = data.replace( /\[font=(.+?)\](.+?)\[\/font\]/gi, '<span style=\"font-family:$1;\">$2</span>' ) ;

		// [color]
        data = data.replace( /\[color=(.+?)\](.+?)\[\/color\]/gi, '<span style=\"color:$1;\">$2</span>' ) ;

		// [background]
        data = data.replace( /\[background=(.+?)\](.+?)\[\/background\]/gi, '<span style=\"background-color:$1;\">$2</span>' ) ;

		// [align]
        data = data.replace( /\[align=(.+?)\](.+?)\[\/align\]/gi, '<div style=\"text-align: $1\">$2</div>' ) ;

		// [url]
		data = data.replace( /\[url=([^\]]+)\](.*?)\[\/url\]/gi, '<a href=\"$1\">$2</a>' ) ;
		data = data.replace( /\[url\](.*?)\[\/url\]/gi, '<a href=\"$1\">$1</a>' ) ;

		// [email]
		data = data.replace( /\[email=([^\]]+)\](.*?)\[\/email\]/gi, '<a href=\"mailto:$1\">$2</a>' ) ;
		data = data.replace( /\[email\](.*?)\[\/email\]/gi, '<a href=\"mailto:$1\">$1</a>' ) ;

		// [img]
		data = data.replace( /\[img\](.*?)\[\/img\]/gi, '<img src=\"$1\" />' ) ;

		// [table]
        data = data.replace( /\[table\](.+?)\[\/table\]/gi, '<table>$1</table>' ) ;

		// [caption]
        data = data.replace( /\[caption\](.+?)\[\/caption\]/gi, '<caption>$1</caption>' ) ;

		// [thead]
        data = data.replace( /\[thead\](.+?)\[\/thead\]/gi, '<thead>$1</thead>' ) ;

		// [tbody]
        data = data.replace( /\[tbody\](.+?)\[\/tbody\]/gi, '<tbody>$1</tbody>' ) ;

		// [tr]
        data = data.replace( /\[tr\](.+?)\[\/tr\]/gi, '<tr>$1</tr>' ) ;

		// [td]
        data = data.replace( /\[td\](.+?)\[\/td\]/gi, '<td>$1</td>' ) ;

		// [th]
        data = data.replace( /\[th\](.+?)\[\/th\]/gi, '<th>$1</th>' ) ;

		// [th]
        data = data.replace( /\[th scope=(.+?)\](.+?)\[\/th\]/gi, '<th scope=\"$1\">$2</th>' ) ;

		// [list]
        data = data.replace( /\[list\](.+?)\[\/list\]/gi, '<ul>$1</ul>' ) ;

		// [list=1]
        data = data.replace( /\[list=1\](.+?)\[\/list\]/gi, '<ol>$1</ol>' ) ;

		// [li]
        data = data.replace( /\[li\](.+?)\[\/li\]/gi, '<li>$1</li>' ) ;

        // [hr]
		data = data.replace( /\[hr]/gi, '<hr />' ) ;

        // [b]
        data = data.replace( /\[b\](.+?)\[\/b\]/gi, '<strong>$1</strong>' ) ;

        // [i]
        data = data.replace( /\[i\](.+?)\[\/i\]/gi, '<em>$1</em>' ) ;

        // [u]
        data = data.replace( /\[u\](.+?)\[\/u\]/gi, '<u>$1</u>' ) ;

        // [s]
        data = data.replace( /\[s\](.+?)\[\/s\]/gi, '<strike>$1</strike>' ) ;

        // [sub]
        data = data.replace( /\[sub\](.+?)\[\/sub\]/gi, '<sub>$1</sub>' ) ;

        // [sup]
        data = data.replace( /\[sup\](.+?)\[\/sup\]/gi, '<sup>$1</sup>' ) ;

		data = data.replace( /\[_]/gi, '&nbsp;' ) ;

		return '<html><head><title></title></head><body>' + data + '</body></html>' ;
	},

	/*
	 * Converts a DOM (sub-)tree to a string in the data format.
	 *     @param {Object} rootNode The node that contains the DOM tree to be
	 *            converted to the data format.
	 *     @param {Boolean} excludeRoot Indicates that the root node must not
	 *            be included in the conversion, only its children.
	 *     @param {Boolean} format Indicates that the data must be formatted
	 *            for human reading. Not all Data Processors may provide it.
	 */
	ConvertToDataFormat : function( rootNode, excludeRoot, ignoreIfEmptyParagraph, format )
	{
		// var data = rootNode.innerHTML ;
		var data = FCKXHtml.GetXHTML( rootNode, !excludeRoot, !format ) ;

        data = data.replace( /(?:\r\n|\n|\r)/g, '<br \/>' ) ;

		// [quote]
		data = data.replace( /<div class=\"quote\">(.*?)<\/div>/gi, '[quote]$1[/quote]') ;
		data = data.replace( /<blockquote>(.*?)<\/blockquote>/gi, '[quote]$1[/quote]') ;

		// [hide]
		data = data.replace( /<div class=\"hide\">(.*?)<\/div>/gi, '[hide]$1[/hide]') ;

		// [pre]
		data = data.replace( /<pre>(.*?)<\/pre>/gi, '[pre]$1[/pre]') ;

		// [code]
		data = data.replace( /<pre.*?class=\"text\".*?>(.*?)<\/pre>/gi, '[code]$1[/code]') ;
		data = data.replace( /<pre.*?class=\"(.*?)\".*?>(.*?)<\/pre>/gi, '[highlight=$1]$2[/highlight]') ;

		// [h1]
		data = data.replace( /<h1>(.*?)<\/h1>/gi, '[h1]$1[/h1]') ;

		// [h2]
		data = data.replace( /<h2>(.*?)<\/h2>/gi, '[h2]$1[/h2]') ;

		// [h3]
		data = data.replace( /<h3>(.*?)<\/h3>/gi, '[h3]$1[/h3]') ;

		// [h4]
		data = data.replace( /<h4>(.*?)<\/h4>/gi, '[h4]$1[/h4]') ;

		// [h5]
		data = data.replace( /<h5>(.*?)<\/h5>/gi, '[h5]$1[/h5]') ;

		// [h6]
		data = data.replace( /<h6>(.*?)<\/h6>/gi, '[h6]$1[/h6]') ;

		// [more]
		data = data.replace( /&lt;--more--&gt;/gi, '[more]') ;

		// [spoiler]
		data = data.replace( /<div class=\"spoiler\">(.*?)<\/div>/gi, '[spoiler=Spoiler]$1[/spoiler]' ) ;

		// [size]
		data = data.replace( /<span style=\"font-size:(.*?);\">(.*?)<\/span>/gi, '[size=$1]$2[/size]') ;

		// [font]
		data = data.replace( /<span style=\"font-family:(.*?);\">(.*?)<\/span>/gi, '[font=$1]$2[/font]') ;

		// [color]
		data = data.replace( /<span style=\"color:(.*?);\">(.*?)<\/span>/gi, '[color=$1]$2[/color]') ;

		// [background]
		data = data.replace( /<span style=\"background-color:(.*?);\">(.*?)<\/span>/gi, '[background=$1]$2[/background]') ;

		// [align]
		data = data.replace( /<div style=\"text-align: (.*?)\">(.*?)<\/div>/gi, '[align=$1]$2[/align]') ;

		// [email]
		data = data.replace( /<a href=\"mailto:(.*?)\">(.*?)<\/a>/gi, '[email=$1]$2[/email]' ) ;

		// [url]
		data = data.replace( /<a.*?href=\"(.*?)\".*?>(.*?)<\/a>/gi, '[url=$1]$2[/url]' ) ;

		// [img]
		data = data.replace( /<img.*?src=\"(.*?)\".*?>/gi, '[img]$1[/img]' ) ;

		// [table]
		data = data.replace( /<table.*?>/gi, '[table]') ;
		data = data.replace( /<\/table>/gi, '[/table]') ;

		// [caption]
		data = data.replace( /<caption>/gi, '[caption]') ;
		data = data.replace( /<\/caption>/gi, '[/caption]') ;

		// [thead]
		data = data.replace( /<thead>/gi, '[thead]') ;
		data = data.replace( /<\/thead>/gi, '[/thead]') ;

		// [tbody]
		data = data.replace( /<tbody>/gi, '[tbody]') ;
		data = data.replace( /<\/tbody>/gi, '[/tbody]') ;

		// [tr]
		data = data.replace( /<tr>/gi, '[tr]') ;
		data = data.replace( /<\/tr>/gi, '[/tr]') ;

		// [td]
		data = data.replace( /<td>/gi, '[td]') ;
		data = data.replace( /<\/td>/gi, '[/td]') ;

		// [th]
		data = data.replace( /<th>/gi, '[th]') ;
		data = data.replace( /<\/th>/gi, '[/th]') ;
		data = data.replace( /<th scope=\"(.*?)\">/gi, '[th scope=$1]') ;

		// [list]
		data = data.replace( /<ul>/gi, '[list]') ;
		data = data.replace( /<\/ul>/gi, '[/list]') ;

		// [list=1]
		data = data.replace( /<ol>/gi, '[list=1]') ;
		data = data.replace( /<\/ol>/gi, '[/list]') ;

		// [li]
		data = data.replace( /<li>/gi, '[li]') ;
		data = data.replace( /<\/li>/gi, '[/li]') ;

		// [hr]
		data = data.replace( /<hr \/>/gi, '[hr]') ;

		// [b]
		data = data.replace( /<strong>/gi, '[b]') ;
		data = data.replace( /<\/strong>/gi, '[/b]') ;

		// [i]
		data = data.replace( /<em>/gi, '[i]') ;
		data = data.replace( /<\/em>/gi, '[/i]') ;

		// [u]
		data = data.replace( /<u>/gi, '[u]') ;
		data = data.replace( /<\/u>/gi, '[/u]') ;

		// [s]
		data = data.replace( /<strike>/gi, '[s]') ;
		data = data.replace( /<\/strike>/gi, '[/s]') ;

		// [sub]
		data = data.replace( /<sub>/gi, '[sub]') ;
		data = data.replace( /<\/sub>/gi, '[/sub]') ;

		// [sup]
		data = data.replace( /<sup>/gi, '[sup]') ;
		data = data.replace( /<\/sup>/gi, '[/sup]') ;

		// Convert <br /> to line breaks.
		data = data.replace( /<br \/>/gi, '\r\n') ;

		// Convert &nbsp;
		data = data.replace( /&nbsp;/gi, '[_]' ) ;
		data = data.replace( /&#160;/gi, '[_]' ) ;

		data = data.replace( /&amp;/gi, '&' ) ;
		data = data.replace( /&quot;/gi, '"' ) ;
		data = data.replace( /&lt;/gi, '<' ) ;
		data = data.replace( /&gt;/gi, '>' ) ;

		// Remove remaining tags.
		// data = data.replace( /<[^>]+>/g, '') ;


		return data ;
	},

	/*
	 * Makes any necessary changes to a piece of HTML for insertion in the
	 * editor selection position.
	 *     @param {String} html The HTML to be fixed.
	 */
	FixHtml : function( html )
	{
		return html ;
	}
} ;

// To avoid pasting invalid markup (which is discarded in any case), let's
// force pasting to plain text.
FCKConfig.ForcePasteAsPlainText	= true ;

// Rename the "Source" buttom to "BBCode".
FCKToolbarItems.RegisterItem( 'Source', new FCKToolbarButton( 'Source', 'BBCode', null, FCK_TOOLBARITEM_ICONTEXT, true, true, 1 ) ) ;
