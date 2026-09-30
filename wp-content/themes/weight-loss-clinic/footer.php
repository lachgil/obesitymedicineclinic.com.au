</main><!-- #fc-main -->

<?php get_template_part( 'template-parts/footer/footer' ); ?>

<?php
// ── Floating CTA (homepage only) ──
if ( is_front_page() ) :
    $cta = fc_get_cta();
?>
<a href="<?php echo esc_url( $cta['url'] ); ?>"
   class="fc-floating-cta"
   id="fc-floating-cta"
   aria-label="<?php echo esc_attr( $cta['text'] ); ?>">
    <?php echo esc_html( $cta['text'] ); ?>
</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
