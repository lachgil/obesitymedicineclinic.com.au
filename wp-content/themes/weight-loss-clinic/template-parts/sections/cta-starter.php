<?php
/**
 * Section: CTA Starter (inline assessment opener)
 *
 * Bottom-of-page conversion block. Replaces the passive "Take the first
 * step" CTA banner. Captures the user's first-question answer inline and
 * hands it off to /quiz/ via sessionStorage + querystring.
 *
 * Inputs (via $args['data']):
 *   - eyebrow      string
 *   - headline     string
 *   - body         string
 *   - quiz_url     string (defaults to BRAND_CTA_URL)
 *   - cta_text     string
 *   - microcopy    string
 *   - question     string (the inline first question)
 *   - field_name   string (sessionStorage / querystring key)
 *   - options      array of [ 'label' => '', 'value' => '' ]
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

$data = $args['data'] ?? [];

$eyebrow   = $data['eyebrow']   ?? 'Eligibility check';
$headline  = $data['headline']  ?? 'Start with a short eligibility check';
$body      = $data['body']      ?? 'Answer the first question now. It takes about 2 minutes, and your answers are reviewed before any next steps are confirmed.';
$quiz_url  = $data['quiz_url']  ?? ( fc_setting( 'cta_url' ) );
$cta_text  = $data['cta_text']  ?? 'Continue assessment';
$microcopy = $data['microcopy'] ?? 'Private and secure. Not all patients are approved. Final suitability is determined by a registered Australian clinician.';
$question  = $data['question']  ?? 'What is your main reason for seeking support?';
$field     = $data['field_name'] ?? 'starter_intent';
$options   = $data['options']   ?? [
    [ 'label' => 'I want to lose weight safely',                 'value' => 'lose-safely' ],
    [ 'label' => 'I have struggled to maintain weight loss',      'value' => 'maintain' ],
    [ 'label' => 'I want clinician-led guidance',                 'value' => 'clinician-led' ],
    [ 'label' => 'I want to understand whether I may be suitable','value' => 'eligibility' ],
];

if ( empty( $options ) ) {
    return;
}
?>
<section class="fc-section fc-section--cta-starter" aria-label="<?php esc_attr_e( 'Start a short eligibility check', 'weight-loss-clinic' ); ?>">
    <div class="fc-container">
        <div class="fc-cta-starter fc-reveal"
             data-quiz-url="<?php echo esc_attr( $quiz_url ); ?>"
             data-field="<?php echo esc_attr( $field ); ?>">
            <header class="fc-cta-starter__header">
                <p class="fc-cta-starter__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <h2 class="fc-cta-starter__headline"><?php echo esc_html( $headline ); ?></h2>
                <p class="fc-cta-starter__body"><?php echo esc_html( $body ); ?></p>
            </header>

            <form class="fc-cta-starter__form"
                  action="<?php echo esc_url( $quiz_url ); ?>"
                  method="get"
                  novalidate>
                <fieldset class="fc-cta-starter__fieldset">
                    <legend class="fc-cta-starter__legend"><?php echo esc_html( $question ); ?></legend>
                    <ul class="fc-cta-starter__options" role="list">
                        <?php foreach ( $options as $i => $opt ) :
                            $label = $opt['label'] ?? '';
                            $value = $opt['value'] ?? '';
                            if ( ! $label || ! $value ) continue;
                            $id = 'fc-starter-' . sanitize_html_class( $value );
                        ?>
                            <li class="fc-cta-starter__option">
                                <input type="radio"
                                       name="<?php echo esc_attr( $field ); ?>"
                                       id="<?php echo esc_attr( $id ); ?>"
                                       value="<?php echo esc_attr( $value ); ?>"
                                       class="fc-cta-starter__radio"
                                       <?php echo 0 === $i ? 'data-default="1"' : ''; ?>>
                                <label for="<?php echo esc_attr( $id ); ?>" class="fc-cta-starter__label">
                                    <span class="fc-cta-starter__pip" aria-hidden="true"></span>
                                    <span class="fc-cta-starter__label-text"><?php echo esc_html( $label ); ?></span>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </fieldset>

                <div class="fc-cta-starter__actions">
                    <button type="submit" class="fc-btn fc-btn--primary fc-cta-starter__submit">
                        <span><?php echo esc_html( $cta_text ); ?></span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                    <span class="fc-cta-starter__time" aria-hidden="true">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        About 2 minutes
                    </span>
                </div>

                <p class="fc-cta-starter__microcopy"><?php echo esc_html( $microcopy ); ?></p>
            </form>
        </div>
    </div>
</section>
