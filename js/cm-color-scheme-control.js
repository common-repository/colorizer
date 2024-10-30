/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 *
 */

 
( function( api ) {
	var cssTemplate = wp.template( 'mm-cm-color-scheme' );
	// wp.template corresponds to _.template underscore java function
	// Read _.template underscore JS function for more details 
		        
	api.controlConstructor.select = api.Control.extend( {   
	
	ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {
				
				// Here colorSetting and colorScheme are new objects created by wp_localize_script function
				// in file 'mm-cm-customizer.php'.
				
				for ( var i =0; i < colorSetting.length; i++ ) {
					api( colorSetting[i] ).set( colorScheme[value].colors[i] );
					api.control( colorSetting[i] ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[i] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[i] );
					}
				} );
			}
		}
	} );

	// Generate  CSS for current Color Scheme.Base color
	function updateCSS() {
		
		var scheme = api( 'color_scheme' )(), css;
			colors = _.object( colorSample, colorScheme[ scheme ].colors );
			// This _object underscore function converts 2 arrays 'colorSample' and 'colorScheme' into one object.
			// this object will be used as an argument in js template variable below.
				
		_.each( colorSetting, function( setting ) {
			colors[ setting ] = api( setting )();
			
		});

		css = cssTemplate( colors );
		// colors is an object from above that is passed as an argument to this template variable
		
		api.previewer.send( 'update-color-scheme-css', css );
	}

		_.each( colorSetting, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );
} )( wp.customize );
