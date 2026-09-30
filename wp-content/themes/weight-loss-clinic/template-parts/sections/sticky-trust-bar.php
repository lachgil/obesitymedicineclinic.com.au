<?php
/**
 * Section: Sticky Trust Bar
 *
 * Slim bar that sits below the header with clinical trust signals.
 * Stays visible on scroll to reinforce credibility throughout browsing.
 */
$data  = $args['data'] ?? [];
$items = $data['items'] ?? [];

if ( empty( $items ) ) return;
?>

<div class="fc-trust-bar" id="fc-trust-bar" role="complementary" aria-label="<?php esc_attr_e( 'Clinical trust indicators', 'flavour-clinic' ); ?>">
    <div class="fc-trust-bar__inner">
        <?php foreach ( $items as $item ) : ?>
            <span class="fc-trust-bar__item">
                <svg class="fc-trust-bar__icon" width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M8 0a8 8 0 100 16A8 8 0 008 0zm3.5 6.2l-4 4a.5.5 0 01-.7 0l-2-2a.5.5 0 11.7-.7L7.1 9.1l3.6-3.6a.5.5 0 01.7.7z" fill="currentColor"/>
                </svg>
                <?php echo esc_html( $item['text'] ?? '' ); ?>
            </span>
        <?php endforeach; ?>
    </div>
</div>
