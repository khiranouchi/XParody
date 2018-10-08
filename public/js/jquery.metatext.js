/*
 * Metadata - jQuery plugin for parsing metadata from elements
 *
 * Copyright (c) 2006 John Resig, Yehuda Katz, J�örn Zaefferer, Paul McLanahan
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Revision: $Id$
 *
 */

/**
 * Sets the type of metatext to use. Metatext is encoded in JSON, and each property
 * in the JSON will become a property of the element itself.
 *
 * There are three supported types of metatext storage:
 *
 *   attr:  Inside an attribute. The name parameter indicates *which* attribute.
 *          
 *   class: Inside the class attribute, wrapped in curly braces: { }
 *   
 *   elem:  Inside a child element (e.g. a script tag). The
 *          name parameter indicates *which* element.
 *          
 * The metatext for an element is loaded the first time the element is accessed via jQuery.
 *
 * As a result, you can define the metatext type, use $(expr) to load the metatext into the elements
 * matched by expr, then redefine the metatext type and run another $(expr) for other elements.
 * 
 * @name $.metatext.setType
 *
 * @example <p id="one" class="some_class {item_id: 1, item_label: 'Label'}">This is a p</p>
 * @before $.metatext.setType("class")
 * @after $("#one").metatext().item_id == 1; $("#one").metatext().item_label == "Label"
 * @desc Reads metatext from the class attribute
 * 
 * @example <p id="one" class="some_class" data="{item_id: 1, item_label: 'Label'}">This is a p</p>
 * @before $.metatext.setType("attr", "data")
 * @after $("#one").metatext().item_id == 1; $("#one").metatext().item_label == "Label"
 * @desc Reads metatext from a "data" attribute
 * 
 * @example <p id="one" class="some_class"><script>{item_id: 1, item_label: 'Label'}</script>This is a p</p>
 * @before $.metatext.setType("elem", "script")
 * @after $("#one").metatext().item_id == 1; $("#one").metatext().item_label == "Label"
 * @desc Reads metatext from a nested script element
 * 
 * @param String type The encoding type
 * @param String name The name of the attribute to be used to get metatext (optional)
 * @cat Plugins/Metatext
 * @descr Sets the type of encoding to be used when loading metatext for the first time
 * @type undefined
 * @see metatext()
 */

(function($) {

$.extend({
	metatext : {
		defaults : {
			type: 'class',
			name: 'metatext',
			cre: /({.*})/,
			single: 'metatext'
		},
		setType: function( type, name ){
			this.defaults.type = type;
			this.defaults.name = name;
		},
		get: function( elem, opts ){
			var settings = $.extend({},this.defaults,opts);
			// check for empty string in single property
			if ( !settings.single.length ) settings.single = 'metatext';
			
			var data = $.data(elem, settings.single);
			// returned cached data if it already exists
			if ( data ) return data;
			
			data = "{}";
			
			if ( settings.type == "class" ) {
				var m = settings.cre.exec( elem.className );
				if ( m )
					data = m[1];
			} else if ( settings.type == "elem" ) {
				if( !elem.getElementsByTagName )
					return undefined;
				var e = elem.getElementsByTagName(settings.name);
				if ( e.length )
					data = $.trim(e[0].innerHTML);
			} else if ( elem.getAttribute != undefined ) {
				var attr = elem.getAttribute( settings.name );
				if ( attr )
					data = attr;
			}
			
			if ( data.indexOf( '{' ) <0 )
			data = "{" + data + "}";
			
			data = eval("(" + data + ")");
			
			$.data( elem, settings.single, data );
			return data;
		}
	}
});

/**
 * Returns the metatext object for the first member of the jQuery object.
 *
 * @name metatext
 * @descr Returns element's metatext object
 * @param Object opts An object contianing settings to override the defaults
 * @type jQuery
 * @cat Plugins/Metatext
 */
$.fn.metatext = function( opts ){
	return $.metatext.get( this[0], opts );
};

})(jQuery);