/**
 * Leaflet map initialisation.
 *
 * Finds every .va-map element and reads data attributes to decide what to render:
 *
 *   data-gpx="<url>"           → Load GPX route, draw line, fit bounds, mark start/end.
 *   data-elevation="true"      → Also render elevation profile (requires leaflet-elevation).
 *   data-markers='<json>'      → Parse JSON array and place custom markers with styled popups.
 *   data-lat / data-lng        → Fallback single marker at these coords, zoom 15.
 *   (none)                     → Centre on Aylesbury (51.8157, -0.8114) at zoom 13.
 *
 * Custom branded pins use L.divIcon with inline SVG. Popups are styled via
 * .va-map-popup CSS class. Category colours map to the site's design tokens.
 *
 * All maps use OpenStreetMap tiles. Vanilla JS, no jQuery.
 *
 * @package VisitAylesbury
 */

( function () {
	'use strict';

	/* -----------------------------------------------------------------------
	 * Config
	 * -------------------------------------------------------------------- */

	var TILE_URL       = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var TILE_ATTR      = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
	var ACCENT         = '#E63946';
	var TEAL           = '#2A9D8F';
	var PRIMARY        = '#1D3557';
	var FALLBACK_LAT   = 51.8157;
	var FALLBACK_LNG   = -0.8114;
	var FALLBACK_ZOOM  = 13;
	var SINGLE_ZOOM    = 15;

	/* Category → colour mapping for multi-marker maps. */
	var CATEGORY_COLOURS = {
		'restaurants':       ACCENT,
		'cafes & coffee':    '#D4A574',
		'cafes':             '#D4A574',
		'pubs & bars':       '#C77D3A',
		'pubs':              '#C77D3A',
		'takeaways':         '#F4A261',
		'hotels & b&bs':     '#6A5ACD',
		'hotels':            '#6A5ACD',
		'shopping':          '#E07BE0',
		'health & beauty':   '#FF69B4',
		'services':          '#888888',
		'arts & culture':    '#9B59B6',
		'sports & fitness':  TEAL,
		'village':           TEAL,
		'town':              PRIMARY,
		'neighbourhood':     '#6A89CC',
	};

	/* -----------------------------------------------------------------------
	 * Custom pin icon builder
	 * -------------------------------------------------------------------- */

	/**
	 * Build an SVG map-pin icon as a Leaflet divIcon.
	 *
	 * @param {string} colour  Fill colour for the pin (hex).
	 * @return {L.DivIcon}
	 */
	function vaPin( colour ) {
		var svg = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" viewBox="0 0 30 40">' +
			'<path d="M15 0C6.716 0 0 6.716 0 15c0 10.65 13.28 23.92 13.84 24.48a1.62 1.62 0 0 0 2.32 0C16.72 38.92 30 25.65 30 15 30 6.716 23.284 0 15 0z" fill="' + colour + '"/>' +
			'<circle cx="15" cy="14" r="6" fill="#fff" opacity="0.95"/>' +
			'</svg>';

		return L.divIcon( {
			html:       svg,
			className:  'va-map-pin',
			iconSize:   [ 30, 40 ],
			iconAnchor: [ 15, 40 ],
			popupAnchor:[ 0, -36 ],
		} );
	}

	/**
	 * Get the pin colour for a given category string.
	 */
	function pinColour( category ) {
		if ( ! category ) {
			return ACCENT;
		}
		var key = category.toLowerCase().trim();
		return CATEGORY_COLOURS[ key ] || ACCENT;
	}

	/* -----------------------------------------------------------------------
	 * Popup builder
	 * -------------------------------------------------------------------- */

	/**
	 * Build styled popup HTML for a marker item.
	 *
	 * @param {Object} item  Marker data { title, url|link, category }
	 * @return {string}      HTML string
	 */
	function buildPopup( item ) {
		var url = item.url || item.link || '';
		var html = '<div class="va-map-popup">';

		if ( item.category ) {
			html += '<span class="va-map-popup__cat">' + escHtml( item.category ) + '</span>';
		}

		if ( item.title && url ) {
			html += '<a href="' + escAttr( url ) + '" class="va-map-popup__title">' + escHtml( item.title ) + '</a>';
		} else if ( item.title ) {
			html += '<strong class="va-map-popup__title va-map-popup__title--plain">' + escHtml( item.title ) + '</strong>';
		}

		if ( url ) {
			html += '<a href="' + escAttr( url ) + '" class="va-map-popup__link">View details &rarr;</a>';
		}

		html += '</div>';
		return html;
	}

	/**
	 * Basic HTML-escape for safe insertion.
	 */
	function escHtml( str ) {
		var div = document.createElement( 'div' );
		div.appendChild( document.createTextNode( str ) );
		return div.innerHTML;
	}

	function escAttr( str ) {
		return str.replace( /&/g, '&amp;' ).replace( /"/g, '&quot;' ).replace( /'/g, '&#39;' ).replace( /</g, '&lt;' ).replace( />/g, '&gt;' );
	}

	/* -----------------------------------------------------------------------
	 * Helpers
	 * -------------------------------------------------------------------- */

	/**
	 * Create a coloured circle marker for route start / end points.
	 */
	function circlePin( latlng, colour, label ) {
		return L.circleMarker( latlng, {
			radius:      8,
			fillColor:   colour,
			color:       '#fff',
			weight:      2,
			opacity:     1,
			fillOpacity: 0.9,
		} ).bindTooltip( label, { permanent: false, direction: 'top' } );
	}

	/**
	 * Extract all coordinate arrays from a GPX layer group, handling
	 * multi-segment tracks where getLatLngs() returns nested arrays.
	 */
	function extractCoords( gpxLayer ) {
		var coords = [];

		gpxLayer.getLayers().forEach( function ( layer ) {
			if ( typeof layer.getLatLngs !== 'function' ) {
				return;
			}
			var lls = layer.getLatLngs();
			if ( lls.length && Array.isArray( lls[0] ) ) {
				lls.forEach( function ( segment ) {
					coords = coords.concat( segment );
				} );
			} else {
				coords = coords.concat( lls );
			}
		} );

		return coords;
	}

	/* -----------------------------------------------------------------------
	 * GPX route handler
	 * -------------------------------------------------------------------- */

	function handleGpx( map, el, gpxUrl ) {
		if ( typeof L.GPX === 'undefined' ) {
			// Plugin not loaded — fall back to single marker.
			handleSingleMarker( map, el );
			return;
		}

		var lat = parseFloat( el.dataset.lat );
		var lng = parseFloat( el.dataset.lng );

		new L.GPX( gpxUrl, {
			async: true,
			polyline_options: {
				color:   ACCENT,
				opacity: 0.85,
				weight:  4,
			},
			marker_options: {
				startIconUrl: null,
				endIconUrl:   null,
				shadowUrl:    null,
				wptIconUrls:  {},
			},
		} )
		.on( 'loaded', function ( e ) {
			var gpx    = e.target;
			var coords = extractCoords( gpx );

			// Fit map to route with padding.
			map.fitBounds( gpx.getBounds().pad( 0.1 ) );

			// Place start (green) and end (red) circle markers.
			if ( coords.length >= 2 ) {
				circlePin( coords[0], TEAL, 'Start' ).addTo( map );
				circlePin( coords[ coords.length - 1 ], ACCENT, 'End' ).addTo( map );
			}

			// Elevation profile — requires leaflet-elevation plugin.
			if ( el.dataset.elevation === 'true' && typeof L.control.elevation !== 'undefined' ) {
				var elevationControl = L.control.elevation( {
					theme:           'va-elevation',
					collapsed:       false,
					detached:        true,
					elevationDiv:    '#va-elevation-' + el.id,
					polyline:        { color: ACCENT, weight: 0 },
					autohide:        false,
					imperial:        true,
					ruler:           false,
					legend:          false,
					almostOver:      true,
					distanceMarkers: false,
				} );
				elevationControl.addTo( map );
				elevationControl.addData( gpx );
			}
		} )
		.on( 'error', function () {
			// GPX failed — fall back to single marker if coords exist.
			if ( ! isNaN( lat ) && ! isNaN( lng ) ) {
				L.marker( [ lat, lng ], { icon: vaPin( ACCENT ) } ).addTo( map );
			}
		} )
		.addTo( map );
	}

	/* -----------------------------------------------------------------------
	 * Multiple markers handler  (data-markers JSON)
	 * -------------------------------------------------------------------- */

	function handleMarkers( map, markersJson ) {
		var items;
		try {
			items = JSON.parse( markersJson );
		} catch ( e ) {
			return;
		}

		if ( ! Array.isArray( items ) || ! items.length ) {
			return;
		}

		var bounds = L.latLngBounds();

		items.forEach( function ( item ) {
			var lat = parseFloat( item.lat );
			var lng = parseFloat( item.lng );

			if ( isNaN( lat ) || isNaN( lng ) ) {
				return;
			}

			var colour = pinColour( item.category );
			var icon   = vaPin( colour );
			var marker = L.marker( [ lat, lng ], { icon: icon } ).addTo( map );
			bounds.extend( [ lat, lng ] );

			var popupHtml = buildPopup( item );
			if ( popupHtml ) {
				marker.bindPopup( popupHtml, {
					className:  'va-map-popup-wrapper',
					maxWidth:   240,
					minWidth:   180,
					closeButton: true,
				} );
			}
		} );

		if ( bounds.isValid() ) {
			if ( items.length === 1 ) {
				map.setView( bounds.getCenter(), SINGLE_ZOOM );
			} else {
				map.fitBounds( bounds.pad( 0.15 ) );
			}
		}
	}

	/* -----------------------------------------------------------------------
	 * Single marker handler  (data-lat / data-lng)
	 * -------------------------------------------------------------------- */

	function handleSingleMarker( map, el ) {
		var lat = parseFloat( el.dataset.lat );
		var lng = parseFloat( el.dataset.lng );

		if ( isNaN( lat ) || isNaN( lng ) ) {
			return;
		}

		var title    = el.dataset.title    || '';
		var category = el.dataset.category || '';

		map.setView( [ lat, lng ], SINGLE_ZOOM );

		var colour = pinColour( category );
		var marker = L.marker( [ lat, lng ], { icon: vaPin( colour ) } ).addTo( map );

		if ( title ) {
			var popupHtml = buildPopup( { title: title, category: category } );
			marker.bindPopup( popupHtml, {
				className:  'va-map-popup-wrapper',
				maxWidth:   240,
				minWidth:   180,
				closeButton: true,
			} );
		}
	}

	/* -----------------------------------------------------------------------
	 * Main init — find every .va-map and wire up
	 * -------------------------------------------------------------------- */

	function init() {
		var els = document.querySelectorAll( '.va-map' );

		els.forEach( function ( el ) {
			// Determine initial centre.
			var lat  = parseFloat( el.dataset.lat )  || FALLBACK_LAT;
			var lng  = parseFloat( el.dataset.lng )  || FALLBACK_LNG;
			var zoom = ( el.dataset.lat && el.dataset.lng ) ? SINGLE_ZOOM : FALLBACK_ZOOM;

			// Create the map.
			var map = L.map( el, {
				scrollWheelZoom: false,
			} ).setView( [ lat, lng ], zoom );

			L.tileLayer( TILE_URL, { attribution: TILE_ATTR } ).addTo( map );

			// Decide what to render based on data attributes.
			var gpxUrl      = el.dataset.gpx     || '';
			var markersJson = el.dataset.markers  || '';

			if ( gpxUrl ) {
				handleGpx( map, el, gpxUrl );
			} else if ( markersJson ) {
				handleMarkers( map, markersJson );
			} else if ( el.dataset.lat && el.dataset.lng ) {
				handleSingleMarker( map, el );
			}
			// No data attributes at all → map stays at Aylesbury fallback centre.
		} );
	}

	/* -----------------------------------------------------------------------
	 * Boot
	 * -------------------------------------------------------------------- */

	document.addEventListener( 'DOMContentLoaded', function () {
		if ( typeof L === 'undefined' ) {
			return;
		}
		init();
	} );

} )();
