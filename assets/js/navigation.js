/**
 * Navigation + interactions.
 *
 * - Desktop mega menu (hover with delays)
 * - Mobile drawer with accordion dropdowns
 * - Card fade-in via Intersection Observer
 * - Smooth scroll for anchor links
 * - Horizontal scroll arrow navigation
 *
 * @package VisitAylesbury
 */
( function () {
	'use strict';

	/* =========================================================
	   Desktop mega menu
	   ========================================================= */

	var OPEN_DELAY  = 100;  // ms before panel opens
	var CLOSE_DELAY = 200;  // ms before panel closes

	function initMegaMenu() {
		var navItems = document.querySelectorAll( '.va-nav__item--has-mega' );
		var activeMega = null;
		var openTimer  = null;
		var closeTimer = null;

		function openPanel( id ) {
			clearTimeout( closeTimer );
			clearTimeout( openTimer );

			// Close current panel if different.
			if ( activeMega && activeMega.id !== id ) {
				closePanel( activeMega, true );
			}

			openTimer = setTimeout( function () {
				var panel = document.getElementById( 'va-mega-' + id );
				if ( ! panel ) return;

				panel.classList.add( 'is-open' );
				panel.setAttribute( 'aria-hidden', 'false' );
				activeMega = panel;

				// Update aria on the trigger button.
				var trigger = document.querySelector( '[data-mega="' + id + '"] .va-nav__link--toggle' );
				if ( trigger ) trigger.setAttribute( 'aria-expanded', 'true' );
			}, OPEN_DELAY );
		}

		function closePanel( panel, immediate ) {
			clearTimeout( openTimer );
			clearTimeout( closeTimer );

			var doClose = function () {
				if ( ! panel ) return;
				panel.classList.remove( 'is-open' );
				panel.setAttribute( 'aria-hidden', 'true' );
				if ( activeMega === panel ) activeMega = null;

				// Find the matching trigger and reset aria.
				var id = panel.id.replace( 'va-mega-', '' );
				var trigger = document.querySelector( '[data-mega="' + id + '"] .va-nav__link--toggle' );
				if ( trigger ) trigger.setAttribute( 'aria-expanded', 'false' );
			};

			if ( immediate ) {
				doClose();
			} else {
				closeTimer = setTimeout( doClose, CLOSE_DELAY );
			}
		}

		function closeAll( immediate ) {
			document.querySelectorAll( '.va-mega.is-open' ).forEach( function ( panel ) {
				closePanel( panel, immediate );
			} );
		}

		navItems.forEach( function ( item ) {
			var megaId = item.dataset.mega;

			// Mouse events for desktop hover.
			item.addEventListener( 'mouseenter', function () {
				if ( window.innerWidth < 1024 ) return;
				openPanel( megaId );
			} );

			item.addEventListener( 'mouseleave', function () {
				if ( window.innerWidth < 1024 ) return;
				if ( activeMega ) closePanel( activeMega );
			} );

			// Click/keyboard toggle for the button.
			var btn = item.querySelector( '.va-nav__link--toggle' );
			if ( btn ) {
				btn.addEventListener( 'click', function ( e ) {
					e.preventDefault();
					if ( window.innerWidth < 1024 ) return;
					var panel = document.getElementById( 'va-mega-' + megaId );
					if ( panel && panel.classList.contains( 'is-open' ) ) {
						closePanel( panel, true );
					} else {
						openPanel( megaId );
					}
				} );
			}
		} );

		// Keep panel open when hovering over it.
		document.querySelectorAll( '.va-mega' ).forEach( function ( panel ) {
			panel.addEventListener( 'mouseenter', function () {
				if ( window.innerWidth < 1024 ) return;
				clearTimeout( closeTimer );
			} );

			panel.addEventListener( 'mouseleave', function () {
				if ( window.innerWidth < 1024 ) return;
				closePanel( panel );
			} );
		} );

		// Close on Escape key.
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' ) {
				closeAll( true );
			}
		} );

		// Close if clicking outside.
		document.addEventListener( 'click', function ( e ) {
			if ( ! e.target.closest( '.va-nav__item--has-mega' ) && ! e.target.closest( '.va-mega' ) ) {
				closeAll( true );
			}
		} );
	}

	/* =========================================================
	   Mobile drawer + accordion
	   ========================================================= */

	function initMobileMenu() {
		var burger  = document.getElementById( 'va-burger' );
		var drawer  = document.getElementById( 'va-mobile-menu' );
		var overlay = document.getElementById( 'va-mobile-overlay' );

		if ( ! burger || ! drawer ) return;

		function openDrawer() {
			burger.classList.add( 'is-open' );
			burger.setAttribute( 'aria-expanded', 'true' );
			drawer.classList.add( 'is-open' );
			drawer.setAttribute( 'aria-hidden', 'false' );
			if ( overlay ) {
				overlay.classList.add( 'is-open' );
				overlay.setAttribute( 'aria-hidden', 'false' );
			}
			document.body.style.overflow = 'hidden';
		}

		function closeDrawer() {
			burger.classList.remove( 'is-open' );
			burger.setAttribute( 'aria-expanded', 'false' );
			drawer.classList.remove( 'is-open' );
			drawer.setAttribute( 'aria-hidden', 'true' );
			if ( overlay ) {
				overlay.classList.remove( 'is-open' );
				overlay.setAttribute( 'aria-hidden', 'true' );
			}
			document.body.style.overflow = '';
		}

		burger.addEventListener( 'click', function () {
			var isOpen = drawer.classList.contains( 'is-open' );
			if ( isOpen ) {
				closeDrawer();
			} else {
				openDrawer();
			}
		} );

		if ( overlay ) {
			overlay.addEventListener( 'click', closeDrawer );
		}

		// Accordion toggles — only one open at a time.
		var parentBtns = drawer.querySelectorAll( '.va-mobile-nav__link--parent' );

		parentBtns.forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var isExpanded = btn.getAttribute( 'aria-expanded' ) === 'true';
				var subList    = btn.nextElementSibling;

				// Close all other open accordions.
				parentBtns.forEach( function ( other ) {
					if ( other !== btn ) {
						other.setAttribute( 'aria-expanded', 'false' );
						other.classList.remove( 'is-open' );
						var otherSub = other.nextElementSibling;
						if ( otherSub ) {
							otherSub.style.maxHeight = null;
							otherSub.classList.remove( 'is-open' );
						}
					}
				} );

				if ( isExpanded ) {
					btn.setAttribute( 'aria-expanded', 'false' );
					btn.classList.remove( 'is-open' );
					if ( subList ) {
						subList.style.maxHeight = null;
						subList.classList.remove( 'is-open' );
					}
				} else {
					btn.setAttribute( 'aria-expanded', 'true' );
					btn.classList.add( 'is-open' );
					if ( subList ) {
						subList.classList.add( 'is-open' );
						subList.style.maxHeight = subList.scrollHeight + 'px';
					}
				}
			} );
		} );

		// Close drawer on Escape.
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && drawer.classList.contains( 'is-open' ) ) {
				closeDrawer();
			}
		} );
	}

	/* =========================================================
	   Card fade-in on scroll (Intersection Observer)
	   ========================================================= */
	function initCardFadeIn() {
		var cards = document.querySelectorAll( '.va-grid .va-card' );

		if ( ! cards.length || ! ( 'IntersectionObserver' in window ) ) {
			return;
		}

		// Tag each card for animation with staggered delay
		cards.forEach( function ( card, index ) {
			card.setAttribute( 'data-animate', '' );
			card.style.transitionDelay = ( index % 6 ) * 50 + 'ms';
		} );

		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'is-visible' );
						observer.unobserve( entry.target );
					}
				} );
			},
			{
				threshold: 0.1,
				rootMargin: '0px 0px -40px 0px',
			}
		);

		cards.forEach( function ( card ) {
			observer.observe( card );
		} );
	}

	/* =========================================================
	   Smooth scroll for anchor links
	   ========================================================= */
	function initSmoothScroll() {
		document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( anchor ) {
			anchor.addEventListener( 'click', function ( e ) {
				var href = this.getAttribute( 'href' );
				if ( href === '#' ) {
					return;
				}
				var target = document.querySelector( href );
				if ( target ) {
					e.preventDefault();
					target.scrollIntoView( {
						behavior: 'smooth',
						block: 'start',
					} );
				}
			} );
		} );
	}

	/* =========================================================
	   Horizontal scroll arrow navigation
	   ========================================================= */
	function initScrollNavs() {
		document.querySelectorAll( '.va-xp-scroll' ).forEach( function ( wrapper ) {
			var track = wrapper.querySelector( '.va-xp-scroll__track' );
			var prev = wrapper.querySelector( '.va-xp-scroll__nav--prev' );
			var next = wrapper.querySelector( '.va-xp-scroll__nav--next' );
			if ( ! track ) return;

			var scrollAmount = 520;

			if ( prev ) {
				prev.addEventListener( 'click', function () {
					track.scrollBy( { left: -scrollAmount, behavior: 'smooth' } );
				} );
			}
			if ( next ) {
				next.addEventListener( 'click', function () {
					track.scrollBy( { left: scrollAmount, behavior: 'smooth' } );
				} );
			}
		} );
	}

	/* =========================================================
	   Init on DOM ready
	   ========================================================= */
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function () {
			initMegaMenu();
			initMobileMenu();
			initCardFadeIn();
			initSmoothScroll();
			initScrollNavs();
		} );
	} else {
		initMegaMenu();
		initMobileMenu();
		initCardFadeIn();
		initSmoothScroll();
		initScrollNavs();
	}
} )();
