<?php
/**
 * Section: Clinical Governance
 *
 * Communicates the clinical decision framework:
 * - Doctor-led decisions
 * - When patients are declined
 * - Safety-first positioning
 */
$data     = $args['data'] ?? [];
$eyebrow  = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$body     = $data['body'] ?? '';
$points   = $data['points'] ?? [];
$compact  = ! empty( $data['compact'] );

if ( empty( $points ) ) return;

if ( $compact ) : ?>
<section class="fc-section fc-section--governance fc-section--governance-compact" id="clinical-governance" aria-label="<?php esc_attr_e( 'Clinical governance', 'weight-loss-clinic' ); ?>">
    <div class="fc-container">
        <ul class="fc-governance-strip" role="list">
            <?php foreach ( $points as $point ) :
                if ( empty( $point['title'] ) ) continue;
                $icon = $point['icon'] ?? 'shield';
            ?>
                <li class="fc-governance-strip__item">
                    <span class="fc-governance-strip__icon"><?php echo fc_icon( $icon ); ?></span>
                    <span class="fc-governance-strip__label"><?php echo esc_html( $point['title'] ); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
<?php else : ?>
<section class="fc-section fc-section--governance" id="clinical-governance">
    <div class="fc-container">
        <div class="fc-governance fc-reveal">
            <div class="fc-governance__header">
                <?php if ( $eyebrow ) : ?>
                    <p class="fc-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="fc-h2"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>
                <?php if ( $body ) : ?>
                    <p class="fc-governance__body"><?php echo esc_html( $body ); ?></p>
                <?php endif; ?>
            </div>

            <div class="fc-governance__grid">
                <?php foreach ( $points as $point ) :
                    if ( empty( $point['title'] ) ) continue;
                    $icon = $point['icon'] ?? 'shield';
                ?>
                    <div class="fc-governance__card">
                        <div class="fc-governance__card-icon">
                            <?php echo fc_icon( $icon, 'fc-icon--md' ); ?>
                        </div>
                        <h3 class="fc-governance__card-title"><?php echo esc_html( $point['title'] ); ?></h3>
                        <?php if ( ! empty( $point['description'] ) ) : ?>
                            <p class="fc-governance__card-desc"><?php echo esc_html( $point['description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
