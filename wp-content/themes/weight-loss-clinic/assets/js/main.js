/**
 * Digital Clinic – Main JS
 *
 * Handles:
 * - Sticky header with scroll state
 * - Mobile nav drawer with focus trap
 * - Announcement bar dismiss
 * - FAQ accordion (accessible)
 * - Scroll reveal animations (respects reduced motion)
 */

( function () {
    'use strict';

    /* ── Helpers ──────────────────────────────────────────────── */
    const prefersReducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

    /**
     * Get all focusable elements within a container.
     */
    function getFocusable( container ) {
        return container.querySelectorAll(
            'a[href], button:not([disabled]), textarea, input:not([type="hidden"]), select, [tabindex]:not([tabindex="-1"])'
        );
    }

    /* ── Sticky Header shadow on scroll ─────────────────────────
       Header is `position: sticky` in CSS, so it stacks naturally with
       the trust bar above and no JS offset gymnastics are needed.
       We only toggle `.is-scrolled` to add a soft shadow once the user
       has moved past the very top of the page. */
    const header = document.getElementById( 'fc-header' );

    if ( header ) {
        var scrollThreshold = 24;
        var updateHeader = function () {
            header.classList.toggle( 'is-scrolled', window.scrollY > scrollThreshold );
        };
        window.addEventListener( 'scroll', updateHeader, { passive: true } );
        updateHeader();
    }

    /* ── Mobile Nav ───────────────────────────────────────────── */
    const mobileNav   = document.getElementById( 'fc-mobile-nav' );
    const menuOpen    = document.getElementById( 'fc-menu-open' );
    const menuClose   = document.getElementById( 'fc-menu-close' );
    const navOverlay  = document.getElementById( 'fc-mobile-nav-overlay' );
    const navPanel    = mobileNav ? mobileNav.querySelector( '.fc-mobile-nav__panel' ) : null;

    function openNav() {
        if ( ! mobileNav ) return;
        mobileNav.classList.add( 'is-open' );
        mobileNav.setAttribute( 'aria-hidden', 'false' );
        if ( menuOpen ) menuOpen.setAttribute( 'aria-expanded', 'true' );
        document.body.style.overflow = 'hidden';

        // Move focus to close button
        if ( menuClose ) {
            requestAnimationFrame( function () {
                menuClose.focus();
            } );
        }
    }

    function closeNav() {
        if ( ! mobileNav ) return;
        mobileNav.classList.remove( 'is-open' );
        mobileNav.setAttribute( 'aria-hidden', 'true' );
        if ( menuOpen ) menuOpen.setAttribute( 'aria-expanded', 'false' );
        document.body.style.overflow = '';

        // Return focus to the menu toggle
        if ( menuOpen ) menuOpen.focus();
    }

    if ( menuOpen )   menuOpen.addEventListener( 'click', openNav );
    if ( menuClose )  menuClose.addEventListener( 'click', closeNav );
    if ( navOverlay ) navOverlay.addEventListener( 'click', closeNav );

    // Keyboard: Escape to close + focus trap
    document.addEventListener( 'keydown', function ( e ) {
        if ( ! mobileNav || ! mobileNav.classList.contains( 'is-open' ) ) return;

        if ( e.key === 'Escape' ) {
            closeNav();
            return;
        }

        // Focus trap within the nav panel
        if ( e.key === 'Tab' && navPanel ) {
            var focusable = getFocusable( navPanel );
            if ( focusable.length === 0 ) return;

            var first = focusable[0];
            var last  = focusable[ focusable.length - 1 ];

            if ( e.shiftKey ) {
                if ( document.activeElement === first ) {
                    e.preventDefault();
                    last.focus();
                }
            } else {
                if ( document.activeElement === last ) {
                    e.preventDefault();
                    first.focus();
                }
            }
        }
    } );

    /* ── Announcement Bar Dismiss ─────────────────────────────── */
    var dismissBtn   = document.getElementById( 'fc-dismiss-announcement' );
    var announcement = document.getElementById( 'fc-announcement' );

    if ( dismissBtn && announcement ) {
        dismissBtn.addEventListener( 'click', function () {
            announcement.style.display = 'none';
            try {
                sessionStorage.setItem( 'fc_announcement_dismissed', '1' );
            } catch ( e ) { /* silent */ }
        } );

        try {
            if ( sessionStorage.getItem( 'fc_announcement_dismissed' ) === '1' ) {
                announcement.style.display = 'none';
            }
        } catch ( e ) { /* silent */ }
    }

    /* ── Accordion ────────────────────────────────────────────── */
    document.querySelectorAll( '.fc-accordion__trigger' ).forEach( function ( trigger ) {
        trigger.addEventListener( 'click', function () {
            var item    = this.closest( '.fc-accordion__item' );
            var panel   = item.querySelector( '.fc-accordion__panel' );
            var content = panel.querySelector( '.fc-accordion__content' );
            var isOpen  = item.classList.contains( 'is-open' );

            // Close all siblings in same accordion
            var accordion = item.closest( '.fc-accordion' );
            accordion.querySelectorAll( '.fc-accordion__item.is-open' ).forEach( function ( openItem ) {
                if ( openItem !== item ) {
                    openItem.classList.remove( 'is-open' );
                    openItem.querySelector( '.fc-accordion__trigger' ).setAttribute( 'aria-expanded', 'false' );
                    var openPanel = openItem.querySelector( '.fc-accordion__panel' );
                    openPanel.style.maxHeight = '0';
                    openPanel.setAttribute( 'aria-hidden', 'true' );
                }
            } );

            if ( isOpen ) {
                item.classList.remove( 'is-open' );
                this.setAttribute( 'aria-expanded', 'false' );
                panel.style.maxHeight = '0';
                panel.setAttribute( 'aria-hidden', 'true' );
            } else {
                item.classList.add( 'is-open' );
                this.setAttribute( 'aria-expanded', 'true' );
                panel.style.maxHeight = content.scrollHeight + 'px';
                panel.setAttribute( 'aria-hidden', 'false' );
            }
        } );
    } );

    /* ── Goal Calculator ──────────────────────────────────────── */
    var calcBtn    = document.getElementById( 'fc-calc-btn' );
    var calcHeight = document.getElementById( 'fc-calc-height' );
    var calcWeight = document.getElementById( 'fc-calc-weight' );
    var calcResult = document.getElementById( 'fc-calc-result' );
    var calcBmi    = document.getElementById( 'fc-calc-bmi' );
    var calcRange  = document.getElementById( 'fc-calc-range' );

    if ( calcBtn && calcHeight && calcWeight && calcResult ) {
        calcBtn.addEventListener( 'click', function () {
            var h = parseFloat( calcHeight.value );
            var w = parseFloat( calcWeight.value );

            if ( ! h || ! w || h < 120 || h > 220 || w < 40 || w > 250 ) {
                calcResult.style.display = 'none';
                return;
            }

            var hm  = h / 100;
            var bmi = w / ( hm * hm );

            // Healthy BMI range: 18.5 – 24.9
            var lowWeight  = Math.round( 18.5 * hm * hm );
            var highWeight = Math.round( 24.9 * hm * hm );

            calcBmi.textContent   = bmi.toFixed( 1 );
            calcRange.textContent = lowWeight + ' – ' + highWeight + ' kg';
            calcResult.style.display = 'flex';
        } );
    }

    /* ── Floating CTA (scroll-triggered) ─────────────────────── */
    var floatingCta = document.getElementById( 'fc-floating-cta' );

    if ( floatingCta ) {
        var ctaScrollThreshold = 300;

        var updateFloatingCta = function () {
            if ( window.scrollY > ctaScrollThreshold ) {
                floatingCta.classList.add( 'is-visible' );
            } else {
                floatingCta.classList.remove( 'is-visible' );
            }
        };

        window.addEventListener( 'scroll', updateFloatingCta, { passive: true } );
        updateFloatingCta();
    }

    /* ── Pathway scroll-progress rail ─────────────────────────────
       The "How it works" 1-2-3 section has a green rail that fills as
       the user scrolls through it. Each card activates as it crosses
       the centre of the viewport. Reduced-motion users see the rail
       statically full and skip the dot-pulse animation. */
    var pathwaySection = document.querySelector( '[data-fc-pathway-progress]' );

    if ( pathwaySection ) {
        var isVertical = pathwaySection.classList.contains( 'fc-section--pathway-vertical' );
        var stepsWrap = pathwaySection.querySelector( isVertical ? '.fc-pathway-v__steps' : '.fc-pathway__steps' );
        var railHost  = isVertical ? pathwaySection.querySelector( '.fc-pathway-v__rail' ) : stepsWrap;
        var fill      = pathwaySection.querySelector( '[data-fc-pathway-fill]' );
        var cards     = pathwaySection.querySelectorAll( '[data-fc-pathway-step]' );
        var markerSel = isVertical ? '.fc-pathway-v__marker' : '.fc-pathway__dot';
        var progressVar = isVertical ? '--fc-pathway-v-progress' : '--fc-pathway-progress';
        var railTopVar  = isVertical ? '--fc-pathway-v-rail-top' : '--fc-pathway-rail-top';
        var railHeightVar = '--fc-pathway-v-rail-height';

        // Position the rail along the marker centres by measuring the
        // first and last markers' positions relative to the rail host.
        // - Horizontal variant: only on desktop (>= 901px), aligns
        //   the rail's top with the dot-marker row.
        // - Vertical variant: clips the rail to span from the first
        //   marker centre to the last marker centre, desktop only.
        function positionRail() {
            if ( ! stepsWrap || ! cards.length ) return;
            if ( window.innerWidth < 901 ) {
                stepsWrap.style.removeProperty( railTopVar );
                if ( isVertical && railHost ) {
                    railHost.style.removeProperty( railHeightVar );
                }
                return;
            }
            var firstMarker = cards[0].querySelector( markerSel );
            if ( ! firstMarker ) return;

            if ( isVertical ) {
                if ( ! railHost ) return;
                var lastMarker = cards[ cards.length - 1 ].querySelector( markerSel );
                if ( ! lastMarker ) return;
                var hostRect  = railHost.getBoundingClientRect();
                var firstRect = firstMarker.getBoundingClientRect();
                var lastRect  = lastMarker.getBoundingClientRect();
                var top    = ( firstRect.top - hostRect.top ) + ( firstRect.height / 2 );
                var bottom = ( lastRect.top  - hostRect.top ) + ( lastRect.height / 2 );
                var height = Math.max( 0, bottom - top );
                railHost.style.setProperty( railTopVar, top + 'px' );
                railHost.style.setProperty( railHeightVar, height + 'px' );
                return;
            }

            var wrapRect = stepsWrap.getBoundingClientRect();
            var dotRect  = firstMarker.getBoundingClientRect();
            // Centre of the dot, expressed in pixels relative to wrap top.
            var topPx = ( dotRect.top - wrapRect.top ) + ( dotRect.height / 2 ) - 1;
            stepsWrap.style.setProperty( railTopVar, topPx + 'px' );
        }

        // Reduced-motion: leave the rail full, no scroll listener.
        if ( prefersReducedMotion ) {
            cards.forEach( function ( c ) { c.classList.add( 'is-active' ); } );
            positionRail();
            window.addEventListener( 'resize', positionRail, { passive: true } );
        } else {
            // Activate cards as they enter the viewport.
            if ( cards.length && 'IntersectionObserver' in window ) {
                var cardObs = new IntersectionObserver(
                    function ( entries ) {
                        entries.forEach( function ( entry ) {
                            if ( entry.isIntersecting ) {
                                entry.target.classList.add( 'is-active' );
                            }
                        } );
                    },
                    { threshold: 0.45, rootMargin: '0px 0px -10% 0px' }
                );
                cards.forEach( function ( c ) { cardObs.observe( c ); } );
            }

            // Scroll-progress on the rail. We compute progress as the
            // section's centre crossing through the viewport, clamped
            // to [0, 1]. rAF keeps it cheap on busy scrolls.
            var rafId  = 0;
            var lastP  = -1;
            function updateProgress() {
                rafId = 0;
                if ( ! stepsWrap || ! fill ) return;
                var rect = stepsWrap.getBoundingClientRect();
                var vh   = window.innerHeight || document.documentElement.clientHeight;
                // Start filling when the top of the steps area reaches
                // 80% down the viewport; finish when the bottom hits 20%.
                var start = vh * 0.80;
                var end   = vh * 0.20;
                var raw;
                if ( rect.height < 1 ) {
                    raw = 0;
                } else {
                    // Distance from `start` line to the *bottom* of the
                    // section, normalised by the section height + travel.
                    var travelled = start - rect.top;
                    var total     = ( start - end ) + rect.height;
                    raw = travelled / total;
                }
                var p = Math.max( 0, Math.min( 1, raw ) );
                if ( Math.abs( p - lastP ) < 0.005 ) return;
                lastP = p;
                var host = isVertical && railHost ? railHost : stepsWrap;
                host.style.setProperty( progressVar, p.toFixed( 4 ) );
            }
            function scheduleProgress() {
                if ( rafId ) return;
                rafId = window.requestAnimationFrame( updateProgress );
            }

            window.addEventListener( 'scroll', scheduleProgress, { passive: true } );
            window.addEventListener( 'resize', function () {
                positionRail();
                scheduleProgress();
            }, { passive: true } );

            positionRail();
            // Run once after first paint, and once after images settle.
            scheduleProgress();
            window.addEventListener( 'load', function () {
                positionRail();
                scheduleProgress();
            }, { once: true } );
        }
    }

    /* ── CTA Starter — handoff to /quiz/ ──────────────────────────
       The bottom homepage CTA captures the first quiz answer inline.
       On submit we (a) write the answer to sessionStorage so the quiz
       can prefill / branch, and (b) let the form's native GET submit
       carry it as a querystring as a backup for environments where
       sessionStorage is unavailable (Safari private mode, etc.). */
    document.querySelectorAll( '.fc-cta-starter' ).forEach( function ( starter ) {
        var form    = starter.querySelector( '.fc-cta-starter__form' );
        var submit  = starter.querySelector( '.fc-cta-starter__submit' );
        var radios  = starter.querySelectorAll( '.fc-cta-starter__radio' );
        var field   = starter.getAttribute( 'data-field' ) || 'starter_intent';

        if ( ! form || ! submit ) return;

        // Pre-select the default option so the user can submit
        // immediately without forcing a click — matches the spec's
        // "frictionless entry point" intent.
        var hasChecked = false;
        radios.forEach( function ( r ) { if ( r.checked ) hasChecked = true; } );
        if ( ! hasChecked ) {
            var def = starter.querySelector( '.fc-cta-starter__radio[data-default="1"]' );
            if ( def ) def.checked = true;
        }

        form.addEventListener( 'submit', function () {
            var picked = starter.querySelector( '.fc-cta-starter__radio:checked' );
            var value  = picked ? picked.value : '';

            try {
                if ( value ) {
                    sessionStorage.setItem( 'fc_' + field, value );
                    sessionStorage.setItem( 'fc_starter_ts', String( Date.now() ) );
                }
            } catch ( e ) { /* storage blocked — querystring still carries it */ }

            if ( window.fcTrack ) {
                fcTrack( 'cta_starter_submitted', { intent: value } );
            }
            // Native GET submit takes the user to /quiz/?starter_intent=…
        } );
    } );

    /* ── Hero Carousel ────────────────────────────────────────────
       Three-slide premium hero. Auto-advances slowly (7s default),
       pauses on hover / focus / off-tab visibility, supports prev /
       next / dots, and respects prefers-reduced-motion (auto-rotate
       off, manual controls still work). All slides occupy the same
       grid cell in CSS, so height is locked and no layout shift
       occurs between transitions. */
    document.querySelectorAll( '[data-fc-hcar]' ).forEach( function ( hcar ) {
        var slides = hcar.querySelectorAll( '[data-fc-hcar-slide]' );
        var dots   = hcar.querySelectorAll( '[data-fc-hcar-dot]' );
        var prev   = hcar.querySelector( '[data-fc-hcar-prev]' );
        var next   = hcar.querySelector( '[data-fc-hcar-next]' );

        if ( slides.length < 2 ) return;

        var duration = parseInt( hcar.getAttribute( 'data-autoplay-ms' ), 10 );
        if ( ! duration || duration < 3000 ) duration = 7000;
        hcar.style.setProperty( '--fc-hcar-duration', duration + 'ms' );

        var index   = 0;
        var timerId = 0;
        var userInteracted = false;

        function show( newIndex ) {
            if ( newIndex === index ) return;
            newIndex = ( newIndex + slides.length ) % slides.length;

            slides[ index ].classList.remove( 'is-active' );
            slides[ index ].setAttribute( 'aria-hidden', 'true' );
            if ( dots[ index ] ) {
                dots[ index ].classList.remove( 'is-active' );
                dots[ index ].setAttribute( 'aria-selected', 'false' );
            }

            index = newIndex;

            slides[ index ].classList.add( 'is-active' );
            slides[ index ].setAttribute( 'aria-hidden', 'false' );
            if ( dots[ index ] ) {
                dots[ index ].classList.add( 'is-active' );
                dots[ index ].setAttribute( 'aria-selected', 'true' );
            }
        }

        function advance() {
            show( index + 1 );
        }

        function startTimer() {
            if ( prefersReducedMotion ) return;
            stopTimer();
            timerId = window.setTimeout( advance, duration );
        }
        function stopTimer() {
            if ( timerId ) {
                window.clearTimeout( timerId );
                timerId = 0;
            }
        }
        function pause() {
            hcar.classList.add( 'is-paused' );
            stopTimer();
        }
        function resume() {
            if ( userInteracted ) return; // honour manual control
            hcar.classList.remove( 'is-paused' );
            startTimer();
        }

        // Auto-advance — restart timer whenever a slide is shown.
        // (We tie the timer to the CSS progress animation length so
        // the bar and the slide change feel synchronised.)
        var origShow = show;
        show = function ( i ) {
            origShow( i );
            if ( ! userInteracted ) startTimer();
        };

        // Manual controls
        if ( prev ) {
            prev.addEventListener( 'click', function () {
                userInteracted = true;
                stopTimer();
                hcar.classList.add( 'is-paused' );
                origShow( index - 1 );
            } );
        }
        if ( next ) {
            next.addEventListener( 'click', function () {
                userInteracted = true;
                stopTimer();
                hcar.classList.add( 'is-paused' );
                origShow( index + 1 );
            } );
        }
        dots.forEach( function ( dot ) {
            dot.addEventListener( 'click', function () {
                var target = parseInt( dot.getAttribute( 'data-fc-hcar-dot' ), 10 );
                if ( isNaN( target ) ) return;
                userInteracted = true;
                stopTimer();
                hcar.classList.add( 'is-paused' );
                origShow( target );
            } );
        } );

        // Pause on hover / focus inside the carousel
        hcar.addEventListener( 'mouseenter', pause );
        hcar.addEventListener( 'mouseleave', resume );
        hcar.addEventListener( 'focusin',  pause );
        hcar.addEventListener( 'focusout', resume );

        // Pause when the tab is hidden — saves CPU and avoids the
        // carousel sprinting through slides while the user is away.
        document.addEventListener( 'visibilitychange', function () {
            if ( document.hidden ) {
                stopTimer();
            } else if ( ! userInteracted ) {
                startTimer();
            }
        } );

        // Kick off auto-rotation
        startTimer();
    } );

    /* ── Quiz CTA — force scroll-to-top on /quiz/ navigations ─────
       Belt-and-braces safety net: any link to /quiz/ should land at
       the top of the destination. The quiz template handles this on
       arrival, but we also clear any preserved scroll state on the
       *source* page before navigation so the browser has nothing to
       restore. */
    document.querySelectorAll( 'a[href]' ).forEach( function ( link ) {
        var href = link.getAttribute( 'href' ) || '';
        // Match "/quiz", "/quiz/", or "/quiz?…" (with or without
        // protocol + host).
        if ( ! /(^|\/)quiz\/?(\?|#|$)/i.test( href ) ) return;

        link.addEventListener( 'click', function () {
            try {
                if ( 'scrollRestoration' in history ) {
                    history.scrollRestoration = 'manual';
                }
            } catch ( e ) { /* silent */ }
        } );
    } );

    /* ── Scroll Reveal ────────────────────────────────────────── */
    var reveals = document.querySelectorAll( '.fc-reveal' );

    // Skip animations entirely for reduced-motion users
    if ( prefersReducedMotion ) {
        reveals.forEach( function ( el ) {
            el.classList.add( 'is-visible' );
        } );
    } else if ( reveals.length && 'IntersectionObserver' in window ) {
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

        reveals.forEach( function ( el ) {
            observer.observe( el );
        } );
    } else {
        reveals.forEach( function ( el ) {
            el.classList.add( 'is-visible' );
        } );
    }

} )();
