<?php
/**
 * Template helper functions.
 */

/**
 * Render an ACF image field as an <img> tag.
 *
 * @param array|false $image ACF image array.
 * @param string      $size  WordPress image size.
 * @param string      $class Additional CSS classes.
 */
function fc_image( $image, string $size = 'large', string $class = '' ) : void {
    if ( ! is_array( $image ) || empty( $image['url'] ) ) {
        return;
    }
    $src    = $image['sizes'][ $size ] ?? $image['url'];
    $alt    = esc_attr( $image['alt'] ?? $image['title'] ?? '' );
    $width  = $image['sizes'][ $size . '-width' ] ?? ( $image['width'] ?? '' );
    $height = $image['sizes'][ $size . '-height' ] ?? ( $image['height'] ?? '' );

    $width_attr  = $width ? sprintf( ' width="%s"', esc_attr( $width ) ) : '';
    $height_attr = $height ? sprintf( ' height="%s"', esc_attr( $height ) ) : '';

    printf(
        '<img src="%s" alt="%s"%s%s class="%s" loading="lazy">',
        esc_url( $src ),
        $alt,
        $width_attr,
        $height_attr,
        esc_attr( $class )
    );
}

/**
 * Return the primary CTA from theme options, merged with overrides.
 *
 * @param array $overrides Keys: text, url, style.
 * @return array{text: string, url: string, style: string}
 */
function fc_get_cta( array $overrides = [] ) : array {
    $defaults = [
        'text'  => function_exists( 'get_field' ) ? ( get_field( 'global_cta_text', 'option' ) ?: ( fc_setting( 'cta_text' ) ) ) : ( fc_setting( 'cta_text' ) ),
        'url'   => function_exists( 'get_field' ) ? ( get_field( 'global_cta_url', 'option' ) ?: ( fc_setting( 'cta_url' ) ) ) : ( fc_setting( 'cta_url' ) ),
        'style' => 'primary',
    ];
    return wp_parse_args( $overrides, $defaults );
}

/**
 * Render a button component.
 */
function fc_button( string $text, string $url = '#', string $style = 'primary', array $attrs = [] ) : void {
    $class = 'fc-btn fc-btn--' . esc_attr( $style );
    if ( ! empty( $attrs['class'] ) ) {
        $class .= ' ' . esc_attr( $attrs['class'] );
    }
    $target = ! empty( $attrs['target'] ) ? ' target="' . esc_attr( $attrs['target'] ) . '" rel="noopener noreferrer"' : '';
    printf(
        '<a href="%s" class="%s"%s>%s</a>',
        esc_url( $url ),
        $class,
        $target,
        esc_html( $text )
    );
}

/**
 * Estimate reading time for the current post.
 *
 * @return int Minutes (1 minimum).
 */
function fc_reading_time() : int {
    $content = get_post_field( 'post_content', get_the_ID() );
    $words   = str_word_count( wp_strip_all_tags( $content ) );
    return (int) max( 1, ceil( $words / 230 ) );
}

/**
 * Render pagination for archive/blog pages.
 */
function fc_pagination() : void {
    $links = paginate_links( [
        'prev_text' => '&larr; ' . __( 'Previous', 'flavour-clinic' ),
        'next_text' => __( 'Next', 'flavour-clinic' ) . ' &rarr;',
        'type'      => 'array',
    ] );

    if ( ! $links ) {
        return;
    }

    echo '<nav class="fc-pagination fc-reveal" aria-label="' . esc_attr__( 'Posts pagination', 'flavour-clinic' ) . '">';
    echo '<ul class="fc-pagination__list">';
    foreach ( $links as $link ) {
        echo '<li class="fc-pagination__item">' . $link . '</li>';
    }
    echo '</ul>';
    echo '</nav>';
}

/**
 * Generate a table of contents from post content headings.
 *
 * Only renders when the post has 3+ h2/h3 headings. Returns empty string
 * for short posts to avoid visual clutter on brief articles.
 *
 * @param string $content Post content HTML.
 * @return string TOC HTML or empty string.
 */
function fc_table_of_contents( string $content ) : string {
    if ( ! $content ) {
        return '';
    }

    // Extract h2 and h3 headings.
    preg_match_all( '/<h([23])[^>]*>(.*?)<\/h[23]>/i', $content, $matches, PREG_SET_ORDER );

    if ( count( $matches ) < 3 ) {
        return '';
    }

    $items = [];
    foreach ( $matches as $match ) {
        $level = (int) $match[1];
        $text  = wp_strip_all_tags( $match[2] );
        $id    = sanitize_title( $text );
        $items[] = [
            'level' => $level,
            'text'  => $text,
            'id'    => $id,
        ];
    }

    $html  = '<nav class="fc-toc fc-reveal" aria-label="' . esc_attr__( 'Table of contents', 'flavour-clinic' ) . '">';
    $html .= '<p class="fc-toc__heading">' . esc_html__( 'In this article', 'flavour-clinic' ) . '</p>';
    $html .= '<ol class="fc-toc__list">';

    foreach ( $items as $item ) {
        $indent = $item['level'] === 3 ? ' fc-toc__item--sub' : '';
        $html  .= '<li class="fc-toc__item' . $indent . '">';
        $html  .= '<a href="#' . esc_attr( $item['id'] ) . '" class="fc-toc__link">' . esc_html( $item['text'] ) . '</a>';
        $html  .= '</li>';
    }

    $html .= '</ol>';
    $html .= '</nav>';

    return $html;
}

/**
 * Filter post content to add IDs to h2/h3 headings for TOC anchor links.
 */
add_filter( 'the_content', function ( $content ) {
    if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    return preg_replace_callback(
        '/<(h[23])([^>]*)>(.*?)<\/h[23]>/i',
        function ( $match ) {
            $tag   = $match[1];
            $attrs = $match[2];
            $text  = $match[3];
            $id    = sanitize_title( wp_strip_all_tags( $text ) );

            // Don't overwrite existing id attributes.
            if ( preg_match( '/\bid\s*=/i', $attrs ) ) {
                return $match[0];
            }

            return sprintf( '<%s%s id="%s">%s</%s>', $tag, $attrs, esc_attr( $id ), $text, $tag );
        },
        $content
    );
}, 8 );

/**
 * Return a CTA tailored to the current post's category when available.
 *
 * Checks ACF options for category-specific CTA overrides stored as:
 *   cta_cat_{category_slug}_text / cta_cat_{category_slug}_url
 *
 * Falls back to the global CTA if no category-specific override exists
 * or ACF is not active.
 *
 * @return array{text: string, url: string}
 */
function fc_get_post_cta() : array {
    $global = fc_get_cta();

    if ( ! is_singular( 'post' ) || ! function_exists( 'get_field' ) ) {
        return $global;
    }

    $cats = get_the_category();
    if ( empty( $cats ) ) {
        return $global;
    }

    $slug = $cats[0]->slug;
    $text = get_field( 'cta_cat_' . $slug . '_text', 'option' );
    $url  = get_field( 'cta_cat_' . $slug . '_url', 'option' );

    return [
        'text' => $text ?: $global['text'],
        'url'  => $url ?: $global['url'],
    ];
}

/**
 * Escape a headline with accent word(s) wrapped in a span.
 * Returns safe HTML with only <span class="fc-accent-text"> allowed.
 *
 * @param string $headline Full headline text.
 * @param string $accent   Word(s) to highlight.
 * @return string Safe HTML.
 */
function fc_accent_headline( string $headline, string $accent = '' ) : string {
    $html = esc_html( $headline );
    if ( $accent ) {
        $html = str_replace(
            esc_html( $accent ),
            '<span class="fc-accent-text">' . esc_html( $accent ) . '</span>',
            $html
        );
    }
    return wp_kses( $html, [ 'span' => [ 'class' => [] ] ] );
}

/**
 * Render a contextual medical disclaimer.
 *
 * Uses a page-specific disclaimer when available, falls back to the global
 * medical disclaimer from ACF Options. Renders nothing when both are empty
 * or ACF is inactive.
 *
 * @param string $specific Optional page-specific disclaimer HTML.
 */
function fc_disclaimer( string $specific = '' ) : void {
    $has_acf = function_exists( 'get_field' );

    $text = $specific;
    if ( ! $text && $has_acf ) {
        $text = get_field( 'global_medical_disclaimer', 'option' ) ?: '';
    }
    if ( ! $text ) {
        $text = (string) fc_setting( 'global_medical_disclaimer', '' );
    }

    if ( ! $text ) {
        return;
    }

    echo '<aside class="fc-disclaimer fc-reveal" aria-label="' . esc_attr__( 'Medical disclaimer', 'flavour-clinic' ) . '">';
    echo '<div class="fc-container fc-container--narrow">';
    echo '<div class="fc-disclaimer__inner">';
    echo wp_kses_post( $text );
    echo '</div>';
    echo '</div>';
    echo '</aside>';
}
