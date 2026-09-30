<?php
/**
 * Section: How It Works
 */
$data     = $args['data'] ?? [];
$eyebrow  = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$steps    = $data['steps'] ?? [];

if ( empty( $steps ) ) return;
?>

<section class="fc-section fc-section--how-it-works" id="how-it-works">
    <div class="fc-container">
        <div class="fc-section-header fc-section-header--center fc-reveal">
            <?php if ( $eyebrow ) : ?>
                <p class="fc-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="fc-h2"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
        </div>

        <div class="fc-steps">
            <?php foreach ( $steps as $i => $step ) : ?>
                <div class="fc-step fc-reveal">
                    <div class="fc-step__number"><?php echo esc_html( $i + 1 ); ?></div>
                    <h3 class="fc-step__title"><?php echo esc_html( $step['title'] ?? '' ); ?></h3>
                    <?php if ( ! empty( $step['description'] ) ) : ?>
                        <p class="fc-step__desc"><?php echo esc_html( $step['description'] ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
