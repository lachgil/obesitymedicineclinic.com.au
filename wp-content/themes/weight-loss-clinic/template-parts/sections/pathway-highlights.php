<?php
/**
 * Section: Pathway Highlight Cards
 *
 * Four coloured cards immediately below the hero section.
 * Communicates the structured clinical pathway at a glance.
 * NOT product cards — these represent governance stages.
 *
 * COMPLIANCE: No drug names, no outcome guarantees, no medication references.
 */
$data  = $args['data'] ?? [];
$cards = $data['cards'] ?? [];

if ( empty( $cards ) ) return;
?>

<section class="fc-section fc-section--pathway-highlights">
    <div class="fc-highlight-cards">
        <?php foreach ( $cards as $i => $card ) :
            if ( empty( $card['title'] ) ) continue;
            $num = $i + 1;
        ?>
            <div class="fc-highlight-card fc-highlight-card--<?php echo esc_attr( $num ); ?> fc-reveal">
                <div class="fc-highlight-card__icon">
                    <?php if ( ! empty( $card['icon'] ) ) echo fc_icon( $card['icon'], '' ); ?>
                </div>
                <h3 class="fc-highlight-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
                <p class="fc-highlight-card__desc"><?php echo esc_html( $card['description'] ?? '' ); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
