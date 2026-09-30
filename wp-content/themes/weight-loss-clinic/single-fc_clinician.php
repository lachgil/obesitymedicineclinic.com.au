<?php
/**
 * Single Clinician Template
 *
 * Renders a polished profile page for individual clinicians.
 * Uses featured image, editor content, and ACF fields for structured data.
 */
get_header();

$has_acf = function_exists( 'get_field' );

$name        = get_the_title();
$title       = $has_acf ? get_field( 'clinician_title' ) : '';
$credentials = $has_acf ? get_field( 'clinician_credentials' ) : '';
$specialties = $has_acf ? get_field( 'clinician_specialties' ) : [];
$cta_text    = $has_acf ? get_field( 'clinician_cta_text' ) : '';
$cta_url     = $has_acf ? get_field( 'clinician_cta_url' ) : '';

// Fall back to global CTA when no profile-specific CTA is set.
if ( ! $cta_text || ! $cta_url ) {
    $global_cta = fc_get_cta();
    $cta_text   = $cta_text ?: $global_cta['text'];
    $cta_url    = $cta_url ?: $global_cta['url'];
}

$has_thumbnail  = has_post_thumbnail();
$has_content    = trim( get_the_content() ) !== '';
$has_credentials = ! empty( trim( $credentials ) );
$has_specialties = ! empty( $specialties ) && ! empty( array_filter( array_column( $specialties, 'text' ) ) );
$has_sidebar     = $has_credentials || $has_specialties;
?>

<article class="fc-clinician-profile" id="post-<?php the_ID(); ?>">

    <!-- ═══════════════ PROFILE HEADER ═══════════════ -->
    <section class="fc-section fc-section--clinician-header">
        <div class="fc-container">
            <div class="fc-clinician-header">
                <?php if ( $has_thumbnail ) : ?>
                    <div class="fc-clinician-header__photo fc-reveal">
                        <?php the_post_thumbnail( 'large', [
                            'class'   => 'fc-clinician-header__img',
                            'loading' => 'eager',
                        ] ); ?>
                    </div>
                <?php endif; ?>

                <div class="fc-clinician-header__info fc-reveal">
                    <h1 class="fc-clinician-header__name"><?php echo esc_html( $name ); ?></h1>

                    <?php if ( $title ) : ?>
                        <p class="fc-clinician-header__title"><?php echo esc_html( $title ); ?></p>
                    <?php endif; ?>

                    <?php if ( has_excerpt() ) : ?>
                        <p class="fc-clinician-header__intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
                    <?php endif; ?>

                    <?php if ( $cta_text ) : ?>
                        <div class="fc-clinician-header__actions">
                            <?php fc_button( $cta_text, $cta_url, 'primary' ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════ PROFILE BODY ═══════════════ -->
    <?php if ( $has_content || $has_sidebar ) : ?>
        <section class="fc-section fc-section--clinician-body">
            <div class="fc-container">
                <div class="fc-clinician-body <?php echo $has_sidebar ? 'fc-clinician-body--has-sidebar' : ''; ?>">

                    <?php if ( $has_content ) : ?>
                        <div class="fc-clinician-body__main fc-reveal">
                            <div class="fc-prose">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( $has_sidebar ) : ?>
                        <aside class="fc-clinician-body__sidebar fc-reveal">

                            <?php if ( $has_credentials ) : ?>
                                <div class="fc-clinician-sidebar-block">
                                    <h3 class="fc-clinician-sidebar-block__heading">Credentials</h3>
                                    <ul class="fc-clinician-sidebar-block__list">
                                        <?php foreach ( explode( "\n", $credentials ) as $line ) :
                                            $line = trim( $line );
                                            if ( ! $line ) continue;
                                        ?>
                                            <li><?php echo esc_html( $line ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if ( $has_specialties ) : ?>
                                <div class="fc-clinician-sidebar-block">
                                    <h3 class="fc-clinician-sidebar-block__heading">Focus Areas</h3>
                                    <div class="fc-clinician-tags">
                                        <?php foreach ( $specialties as $spec ) :
                                            if ( empty( $spec['text'] ) ) continue;
                                        ?>
                                            <span class="fc-clinician-tag"><?php echo esc_html( $spec['text'] ); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </aside>
                    <?php endif; ?>

                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ═══════════════ CTA BLOCK ═══════════════ -->
    <?php
    get_template_part( 'template-parts/sections/cta-banner', null, [
        'data' => [
            'headline'  => 'Ready to start your care journey?',
            'body'      => 'Connect with our clinical team and begin your personalized treatment plan today.',
            'cta_text'  => $cta_text ?: ( fc_setting( 'cta_text' ) ),
            'cta_url'   => $cta_url ?: '#',
            'cta2_text' => '',
            'cta2_url'  => '',
            'style'     => 'accent',
        ],
    ] );
    ?>

    <!-- ═══════════════ DISCLAIMER ═══════════════ -->
    <?php fc_disclaimer(); ?>

</article>

<?php get_footer(); ?>
