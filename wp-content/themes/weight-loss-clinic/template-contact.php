<?php
/**
 * Template Name: Contact
 *
 * Lightweight contact page for the weight-loss funnel.
 * Also serves as the landing destination for quiz "unsuitable" results.
 *
 * All copy is editable in Customize → Theme Settings → Page — Contact;
 * defaults live in inc/options/page-contact.php.
 *
 * Create a WordPress page with slug "contact" and assign this template.
 */

get_header();

$support_email   = fc_setting( 'support_email' );
$brand_name      = fc_setting( 'brand_name' );
$specialist_name = fc_setting( 'specialist_name' );
$clinician_uri   = FC_URI . '/assets/images/clinician';

$contact_photo = fc_setting_image( 'contact_photo', $clinician_uri . '/dr-dolan-desk.jpg' );

// Empty intro falls back to a string generated from the specialist name.
$hero_intro = fc_setting( 'contact_hero_intro', '' )
    ?: 'Our care team responds within one business day. For specialist clinical questions, the team coordinates with ' . $specialist_name . ' directly.';
?>

<article class="fc-page fc-page--contact">

    <div class="fc-page__header-wrap fc-page__header-wrap--branded">
        <div class="fc-container">
            <header class="fc-page__header fc-page__header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'contact_hero_eyebrow' ) ); ?></p>
                <h1 class="fc-h1"><?php echo esc_html( fc_setting( 'contact_hero_headline' ) ); ?></h1>
                <p class="fc-page__intro"><?php echo esc_html( $hero_intro ); ?></p>
            </header>
        </div>
    </div>

    <div class="fc-section">
        <div class="fc-container fc-container--narrow">
            <div class="fc-contact-photo fc-reveal" aria-hidden="true">
                <img
                    src="<?php echo esc_url( $contact_photo ); ?>"
                    alt=""
                    loading="lazy">
            </div>
            <div class="fc-contact">

                <div class="fc-contact__block">
                    <h2 class="fc-h3"><?php echo esc_html( fc_setting( 'contact_email_title' ) ); ?></h2>
                    <p><?php echo esc_html( fc_setting( 'contact_email_body' ) ); ?></p>
                    <p>
                        <a href="mailto:<?php echo esc_attr( $support_email ); ?>" class="fc-contact__email">
                            <?php echo esc_html( $support_email ); ?>
                        </a>
                    </p>
                </div>

                <div class="fc-contact__block">
                    <h2 class="fc-h3"><?php echo esc_html( fc_setting( 'contact_include_title' ) ); ?></h2>
                    <p><?php echo esc_html( fc_setting( 'contact_include_intro' ) ); ?></p>
                    <ul class="fc-contact__list">
                        <?php foreach ( fc_setting_lines( 'contact_include_items' ) as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="fc-contact__block">
                    <h2 class="fc-h3"><?php echo esc_html( fc_setting( 'contact_response_title' ) ); ?></h2>
                    <p><?php echo wp_kses_post( fc_setting( 'contact_response_body' ) ); ?></p>
                </div>

                <div class="fc-contact__trust">
                    <p><?php echo esc_html( fc_setting( 'contact_trust_body' ) ); ?></p>
                </div>

            </div>
        </div>
    </div>

</article>

<?php get_footer(); ?>
