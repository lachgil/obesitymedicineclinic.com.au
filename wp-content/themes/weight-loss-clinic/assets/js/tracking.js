/**
 * Weight Loss Clinic — Funnel Event Tracking
 *
 * Lightweight abstraction layer for tracking funnel events.
 * Dispatches custom DOM events and pushes to dataLayer (GTM/GA4)
 * when available. If no analytics is connected, events are logged
 * to console in development.
 *
 * Events are fired via:
 *   1. data-fc-track="event_name" attributes (auto-wired on DOMContentLoaded)
 *   2. Direct calls: fcTrack('event_name', { key: value })
 *
 * To connect GA4 via GTM:
 *   - Install GTM container on the site
 *   - Create custom event triggers matching the event names below
 *   - Map dataLayer variables as needed
 *
 * Event catalogue (patient journey):
 *   Assessment
 *     assessment_started       — first quiz interaction
 *     assessment_step_completed — each question answered { step_id, step_index, total_steps }
 *     assessment_abandoned     — page hidden/unloaded before submission
 *     assessment_submitted     — all questions answered, result computed
 *     quiz_started / quiz_completed — legacy aliases (kept for backwards compatibility)
 *
 *   Routing
 *     routed_likely_suitable   — likely-suitable outcome shown
 *     routed_needs_review      — needs-review outcome shown
 *     routed_not_suitable      — safety-flag outcome shown
 *     pathway_viewed           — { state, bmi } when pathway preview rendered
 *
 *   Booking
 *     booking_viewed           — booking page loaded
 *     booking_started          — primary booking CTA clicked from pathway preview
 *     booking_completed        — booking placeholder action clicked (intake start)
 *     follow_up_clicked        — follow-up CTA clicked (needs-review pathway)
 *
 *   Confirmation
 *     confirmation_viewed      — thank-you / confirmation page loaded
 *     add_to_calendar_clicked  — calendar block interaction
 *     contact_clicked          — generic contact CTA clicked
 */

( function () {
    'use strict';

    // Push to GTM dataLayer if available
    function pushDataLayer( eventName, data ) {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push( Object.assign( { event: eventName }, data || {} ) );
    }

    // Main tracking function — exposed globally as fcTrack
    function fcTrack( eventName, data ) {
        var payload = data || {};

        // 1. GTM / GA4 dataLayer
        pushDataLayer( eventName, payload );

        // 2. Custom DOM event (for any other listeners)
        try {
            document.dispatchEvent( new CustomEvent( 'fc:track', {
                detail: { event: eventName, data: payload }
            } ) );
        } catch ( e ) {
            // IE11 fallback — not critical
        }

        // 3. Dev console logging (non-production only)
        if ( window.location.hostname === 'localhost' || window.location.hostname.indexOf( '.local' ) !== -1 ) {
            console.log( '[fc:track]', eventName, payload );
        }
    }

    // Expose globally
    window.fcTrack = fcTrack;

    // Auto-wire data-fc-track attributes
    document.addEventListener( 'DOMContentLoaded', function () {

        // View events: fire immediately for elements present on load
        // Event names ending in any of these suffixes are wired as click
        // events. Everything else (e.g. `*_viewed`) fires on load.
        var clickSuffixes = [ '_clicked', '_started', '_completed', '_continue' ];
        function isClickEvent( name ) {
            return clickSuffixes.some( function ( s ) {
                return name.indexOf( s ) !== -1;
            } );
        }

        document.querySelectorAll( '[data-fc-track]' ).forEach( function ( el ) {
            var eventName = el.getAttribute( 'data-fc-track' );

            if ( isClickEvent( eventName ) ) {
                el.addEventListener( 'click', function () {
                    fcTrack( eventName, { url: el.href || '' } );
                } );
            } else {
                // View events: fire on page load
                fcTrack( eventName );
            }
        } );

    } );

} )();
