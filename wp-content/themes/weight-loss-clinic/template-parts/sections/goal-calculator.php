<?php
/**
 * Section: Interactive Goal Calculator
 *
 * Allows user to enter current weight and height.
 * Shows an illustrative weight range with mandatory disclaimer.
 * NO promises. NO guaranteed outcomes. Illustrative only.
 */
$data     = $args['data'] ?? [];
$eyebrow  = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$body     = $data['body'] ?? '';
$disclaimer = $data['disclaimer'] ?? '';
$cta_text = $data['cta_text'] ?? '';
$cta_url  = ( $data['cta_url'] ?? '' ) ?: '#';
?>

<section class="fc-section fc-section--goal-calc" id="goal-calculator">
    <div class="fc-container">
        <div class="fc-goal-calc fc-reveal">
            <div class="fc-goal-calc__content">
                <?php if ( $eyebrow ) : ?>
                    <p class="fc-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="fc-h2"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>
                <?php if ( $body ) : ?>
                    <p class="fc-goal-calc__body"><?php echo esc_html( $body ); ?></p>
                <?php endif; ?>
            </div>

            <div class="fc-goal-calc__form">
                <div class="fc-goal-calc__fields">
                    <div class="fc-goal-calc__field">
                        <label for="fc-calc-height" class="fc-goal-calc__label">Height (cm)</label>
                        <input type="number" id="fc-calc-height" class="fc-goal-calc__input" placeholder="170" min="120" max="220" step="1">
                    </div>
                    <div class="fc-goal-calc__field">
                        <label for="fc-calc-weight" class="fc-goal-calc__label">Current weight (kg)</label>
                        <input type="number" id="fc-calc-weight" class="fc-goal-calc__input" placeholder="95" min="40" max="250" step="0.1">
                    </div>
                    <button type="button" class="fc-btn fc-btn--primary fc-goal-calc__btn" id="fc-calc-btn">See illustrative range</button>
                </div>

                <div class="fc-goal-calc__result" id="fc-calc-result" aria-live="polite" style="display:none;">
                    <div class="fc-goal-calc__result-inner">
                        <p class="fc-goal-calc__bmi-label">Your current BMI</p>
                        <p class="fc-goal-calc__bmi-value" id="fc-calc-bmi"></p>
                        <p class="fc-goal-calc__range-label">Illustrative healthy weight range for your height</p>
                        <p class="fc-goal-calc__range-value" id="fc-calc-range"></p>
                    </div>
                    <?php if ( $cta_text ) : ?>
                        <a href="<?php echo esc_url( $cta_url ); ?>" class="fc-btn fc-btn--primary fc-goal-calc__cta"><?php echo esc_html( $cta_text ); ?></a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ( $disclaimer ) : ?>
                <p class="fc-goal-calc__disclaimer"><?php echo esc_html( $disclaimer ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
