<?php
/**
 * Template Name: Patient Portal
 *
 * Renders the full patient portal experience. The [wlc_dashboard]
 * shortcode handles BOTH logged-out (premium entry screen with sign-in
 * + new patient paths) AND logged-in (application shell with side
 * navigation and 8 sections: dashboard, care plan, check-ins,
 * appointments, messages, documents, billing, account).
 *
 * Page slug: /portal/
 *
 * @package WeightLossClinic
 */

get_header();
echo do_shortcode( '[wlc_dashboard]' );
get_footer();
