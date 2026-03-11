/**
 * Navigation + interactions.
 *
 * - Mobile menu toggle
 * - Card fade-in via Intersection Observer
 * - Smooth scroll for anchor links
 *
 * @package VisitAylesbury
 */
( function () {
	'use strict';

	/* =========================================================
	   Mobile menu toggle
	   ========================================================= */
	const toggle = document.querySelector( '.va-site-header__toggle' );
	const mobileMenu = document.querySelector( '.va-mobile-menu' );

	if ( toggle && mobileMenu ) {
		toggle.addEventListener( 'click', function () {
			const isOpen = mobileMenu.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );
	}

	/* =========================================================
	   Card fade-in on scroll (Intersection Observer)
	   ========================================================= */
	function initCardFadeIn() {
		const cards = document.querySelectorAll( '.va-grid .va-card' );

		if ( ! cards.length || ! ( 'IntersectionObserver' in window ) ) {
			return;
		}

		// Tag each card for animation with staggered delay
		cards.forEach( function ( card, index ) {
			card.setAttribute( 'data-animate', '' );
			card.style.transitionDelay = ( index % 6 ) * 50 + 'ms';
		} );

		const observer = new IntersectionObserver(
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
				const href = this.getAttribute( 'href' );
				if ( href === '#' ) {
					return;
				}
				const target = document.querySelector( href );
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
			initCardFadeIn();
			initSmoothScroll();
			initScrollNavs();
		} );
	} else {
		initCardFadeIn();
		initSmoothScroll();
		initScrollNavs();
	}
} )();
