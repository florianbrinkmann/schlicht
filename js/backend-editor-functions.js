/*
 * Adds button to the backend editor to create a side note.
 */
jQuery(document).on('tinymce-editor-setup', function (event, editor) {
	/**
	 * Wait until the editor is initialized before
	 * registering style.
	 *
	 * Original hint from http://archive.tinymce.com/forum/viewtopic.php?pid=92762#p92762
	 * onInit is deprecated, so https://www.tinymce.com/docs/advanced/migration-guide-from-3.x/#eventhandling
	 */
	editor.on('init', function () {
		/**
		 * Register the new format for the side note.
		 */
		editor.formatter.register('schlicht_side_note_format', {
			/**
			 * It is the block element aside.
			 */
			block: 'aside',

			/**
			 * The aside element gets the class side-note.
			 */
			classes: 'side-note',

			/**
			 * The aside is the wrapper for other block elements
			 * and does not replace them.
			 */
			wrapper: true
		});

		/**
		 * Register the new format for the drop cap.
		 */
		editor.formatter.register('schlicht_drop_cap_format', {
			/**
			 * It is the block element aside.
			 */
			block: 'p',

			/**
			 * Only make it work for paragraph elements.
			 */
			selector: 'p',

			/**
			 * The aside element gets the class side-note.
			 */
			classes: 'dropcap-paragraph',
		});

		/**
		 * Callback on drop cap format change.
		 */
		editor.formatter.formatChanged('schlicht_drop_cap_format', function (state, currentNodeObj) {
			schlicht_toggle_dropcap_markup(state, currentNodeObj);
		});
	});

	/**
	 * Add the id of the soon-to-create button to the
	 * toolbar settings.
	 *
	 * @type {string}
	 */
	editor.settings.toolbar1 += ',schlicht-formats';

	/**
	 * Create the button.
	 */
	editor.addButton('schlicht-formats', {
		/**
		 * It is a menubutton.
		 */
		type: 'menubutton',
		text: '»Schlicht« Formats',
		icon: false,

		/**
		 * Add the menu items.
		 */
		menu: [
			{
				text: 'Drop cap',
				onclick: function () {
					/**
					 * Toggle the custom drop cap format.
					 */
					editor.formatter.toggle('schlicht_drop_cap_format');
				},
			},
			{
				text: 'Side note',
				onclick: function () {
					/**
					 * Toggle the custom side note format.
					 */
					editor.formatter.toggle('schlicht_side_note_format');
				}
			}
		]
	});
});

/**
 * Function to handle toggling of drop cap markup.
 *
 * @param state true if drop cap option is active, false if not.
 * @param currentNodeObj object of currently selected node.
 */
function schlicht_toggle_dropcap_markup(state, currentNodeObj) {
	/**
	 * Empty string for parsed inner HTML.
	 */
	var paragraphInnerHTML = '';

	/**
	 * Initialize paragraph node variable.
	 */
	var paragraphNode;

	/**
	 * Check if we have a paragraph node.
	 */
	if ('P' === currentNodeObj.node.nodeName) {
		/**
		 * Parse the innerHTML
		 */
		paragraphInnerHTML = currentNodeObj.node.innerHTML;
		paragraphNode = currentNodeObj.node;
	} else {
		/**
		 * We need to get the innerHTML of the parent paragraph.
		 */

		/**
		 * get an array of the parent elements.
		 * @type {array}
		 */
		var parentNodes = currentNodeObj.parents;

		/**
		 * Loop them to find a paragraph.
		 */
		jQuery.each(parentNodes, function (index, value) {
			/**
			 * Check if it is a paragraph element.
			 */
			if ('P' === parentNodes[index].nodeName) {
				/**
				 * Parse the innerHTML
				 */
				paragraphInnerHTML = parentNodes[index].innerHTML;
				paragraphNode = parentNodes[index];
			}
		});
	}

	/**
	 * Check if we have parsedInnerHTML
	 */
	if ('' === paragraphInnerHTML) {
		return;
	}

	var paragraphParsedHTML = jQuery.parseHTML(paragraphInnerHTML);

	/**
	 * Check if the drop cap option is active.
	 * In that case, currentNodeObj is the paragraph element.
	 */
	if (true === state) {
		/**
		 * Check if the paragraph not already has a dropcap.
		 */
		if (0 === jQuery(paragraphParsedHTML).find('span.dropcap').length) {
			/**
			 * Get first word.
			 */
			var firstWordRegexp = /(?:<(?:[^>]*)>)*([^<\s]\w+)/;
			var matches = firstWordRegexp.exec(paragraphInnerHTML);
			var firstWord = matches[1];

			/**
			 * Explode first word.
			 *
			 * @link https://stackoverflow.com/a/24467067
			 */
			var firstWordArray = firstWord.split('');
			firstWordArray[0] = '<span class="dropcap">' + firstWordArray[0] + '</span>';
			var firstWord = firstWordArray.join('');

			/**
			 * Replace the first word from innerHTML with new markup.
			 */
			var innerHtml = currentNodeObj.node.innerHTML.replace(firstWordRegexp, '<span class="small-caps">' + firstWord + '</span>');

			/**
			 * Update the paragraph’s HTML.
			 */
			paragraphNode.innerHTML = innerHtml;
		}
	} else {
		/**
		 * Check if we have a dropcap span.
		 */
		if (0 !== jQuery(paragraphParsedHTML).find('span.dropcap').length) {
			/**
			 * Remove the drop cap span.
			 */
			var innerHtmlWithoutDroCap = paragraphInnerHTML.replace(/(<(?:[^>]*(?:class="dropcap"))>){1}([^<\s]\w*)(<\/span>)/, '$2');

			/**
			 * Remove the small-caps span.
			 */
			var cleanInnerHTML = innerHtmlWithoutDroCap.replace(/(<(?:[^>]*(?:class="small-caps"))>){1}([^<\s]\w*)(<\/span>)/, '$2');

			/**
			 * Update the paragraph’s HTML.
			 * @type {string}
			 */
			paragraphNode.innerHTML = cleanInnerHTML;
		}
	}
}
