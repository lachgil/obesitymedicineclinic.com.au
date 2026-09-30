<?php
/**
 * SEO, Open Graph, Twitter Cards, and Structured Data.
 *
 * Provides baseline SEO coverage when no dedicated plugin is active.
 * Automatically defers to Yoast, Rank Math, or any plugin that defines
 * FLAVOUR_SEO_SKIP to avoid duplicate output.
 */

/**
 * Check whether a known SEO plugin is handling meta output.
 */
function fc_seo_plugin_active() : bool {
    return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'FLAVOUR_SEO_SKIP' );
}

/**
 * Build a description string for the current page.
 */
function fc_seo_description() : string {
    if ( is_front_page() ) {
        return get_bloginfo( 'description' );
    }

    if ( is_singular() ) {
        $post = get_queried_object();
        if ( $post && ! empty( $post->post_excerpt ) ) {
            return wp_strip_all_tags( $post->post_excerpt );
        }
        if ( $post && ! empty( $post->post_content ) ) {
            return wp_trim_words( wp_strip_all_tags( $post->post_content ), 25, '...' );
        }
    }

    if ( is_category() || is_tag() || is_tax() ) {
        $desc = term_description();
        if ( $desc ) {
            return wp_strip_all_tags( $desc );
        }
    }

    return get_bloginfo( 'description' );
}

/**
 * Meta description tag.
 */
add_action( 'wp_head', function () {
    if ( fc_seo_plugin_active() ) {
        return;
    }

    $desc = fc_seo_description();
    if ( $desc ) {
        printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
    }
}, 1 );

/**
 * Open Graph meta tags.
 */
add_action( 'wp_head', function () {
    if ( fc_seo_plugin_active() ) {
        return;
    }

    $title = wp_get_document_title();
    $url   = is_singular() ? get_permalink() : home_url( add_query_arg( [] ) );
    $desc  = fc_seo_description();

    // Determine OG type.
    $og_type = 'website';
    if ( is_singular( 'post' ) ) {
        $og_type = 'article';
    }

    printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $og_type ) );
    printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
    printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );

    if ( $desc ) {
        printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
    }

    // OG image.
    $image = '';
    if ( is_singular() && has_post_thumbnail() ) {
        $image = get_the_post_thumbnail_url( null, 'large' );
    } elseif ( has_custom_logo() ) {
        $logo_id = get_theme_mod( 'custom_logo' );
        $image   = $logo_id ? wp_get_attachment_image_url( $logo_id, 'large' ) : '';
    }

    if ( $image ) {
        printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
    }

    printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );

    // Article-specific OG tags for posts.
    if ( is_singular( 'post' ) ) {
        printf( '<meta property="article:published_time" content="%s">' . "\n", esc_attr( get_the_date( 'c' ) ) );
        printf( '<meta property="article:modified_time" content="%s">' . "\n", esc_attr( get_the_modified_date( 'c' ) ) );

        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            printf( '<meta property="article:section" content="%s">' . "\n", esc_attr( $categories[0]->name ) );
        }

        $tags = get_the_tags();
        if ( $tags ) {
            foreach ( $tags as $tag ) {
                printf( '<meta property="article:tag" content="%s">' . "\n", esc_attr( $tag->name ) );
            }
        }
    }

}, 2 );

/**
 * Twitter Card meta tags.
 */
add_action( 'wp_head', function () {
    if ( fc_seo_plugin_active() ) {
        return;
    }

    $title = wp_get_document_title();
    $desc  = fc_seo_description();

    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );

    if ( $desc ) {
        printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
    }

    if ( is_singular() && has_post_thumbnail() ) {
        printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( get_the_post_thumbnail_url( null, 'large' ) ) );
    } elseif ( has_custom_logo() ) {
        $logo_id = get_theme_mod( 'custom_logo' );
        $image   = $logo_id ? wp_get_attachment_image_url( $logo_id, 'large' ) : '';
        if ( $image ) {
            printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $image ) );
        }
    }

}, 3 );

/**
 * JSON-LD structured data for single posts (BlogPosting schema).
 */
add_action( 'wp_head', function () {
    if ( fc_seo_plugin_active() || ! is_singular( 'post' ) ) {
        return;
    }

    $post = get_queried_object();
    if ( ! $post ) {
        return;
    }

    $schema = [
        '@context'         => 'https://schema.org',
        '@type'            => 'BlogPosting',
        'headline'         => get_the_title( $post ),
        'datePublished'    => get_the_date( 'c', $post ),
        'dateModified'     => get_the_modified_date( 'c', $post ),
        'url'              => get_permalink( $post ),
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id'   => get_permalink( $post ),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name'  => get_bloginfo( 'name' ),
        ],
    ];

    // Description.
    $desc = ! empty( $post->post_excerpt )
        ? wp_strip_all_tags( $post->post_excerpt )
        : wp_trim_words( wp_strip_all_tags( $post->post_content ), 25, '...' );
    if ( $desc ) {
        $schema['description'] = $desc;
    }

    // Featured image.
    if ( has_post_thumbnail( $post ) ) {
        $img_id   = get_post_thumbnail_id( $post );
        $img_data = wp_get_attachment_image_src( $img_id, 'large' );
        if ( $img_data ) {
            $schema['image'] = [
                '@type'  => 'ImageObject',
                'url'    => $img_data[0],
                'width'  => $img_data[1],
                'height' => $img_data[2],
            ];
        }
    }

    // Publisher logo.
    if ( has_custom_logo() ) {
        $logo_id  = get_theme_mod( 'custom_logo' );
        $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
        if ( $logo_url ) {
            $schema['publisher']['logo'] = [
                '@type' => 'ImageObject',
                'url'   => $logo_url,
            ];
        }
    }

    // Word count.
    $word_count = str_word_count( wp_strip_all_tags( $post->post_content ) );
    if ( $word_count > 0 ) {
        $schema['wordCount'] = $word_count;
    }

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";

}, 4 );

/**
 * JSON-LD Organization + WebSite schema (front page only).
 */
add_action( 'wp_head', function () {
    if ( fc_seo_plugin_active() || ! is_front_page() ) {
        return;
    }

    $has_acf = function_exists( 'get_field' );
    $name    = get_bloginfo( 'name' );
    $url     = home_url( '/' );

    // Organization / MedicalBusiness.
    $org = [
        '@context' => 'https://schema.org',
        '@type'    => 'MedicalBusiness',
        'name'     => $name,
        'url'      => $url,
    ];

    // Logo.
    if ( has_custom_logo() ) {
        $logo_id  = get_theme_mod( 'custom_logo' );
        $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
        if ( $logo_url ) {
            $org['logo'] = $logo_url;
        }
    }

    // Contact info from footer settings.
    if ( $has_acf ) {
        $email   = get_field( 'footer_email', 'option' );
        $phone   = get_field( 'footer_phone', 'option' );
        $address = get_field( 'footer_address', 'option' );

        if ( $email ) {
            $org['email'] = $email;
        }
        if ( $phone ) {
            $org['telephone'] = $phone;
        }
        if ( $address ) {
            $org['address'] = [
                '@type'          => 'PostalAddress',
                'streetAddress'  => wp_strip_all_tags( $address ),
            ];
        }
    }

    $desc = get_bloginfo( 'description' );
    if ( $desc ) {
        $org['description'] = $desc;
    }

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode( $org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";

    // WebSite schema.
    $website = [
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        'name'     => $name,
        'url'      => $url,
    ];

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode( $website, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";

}, 5 );

/**
 * JSON-LD Person schema for clinician profiles.
 */
add_action( 'wp_head', function () {
    if ( fc_seo_plugin_active() || ! is_singular( 'fc_clinician' ) ) {
        return;
    }

    $post    = get_queried_object();
    $has_acf = function_exists( 'get_field' );

    if ( ! $post ) {
        return;
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'Person',
        'name'     => get_the_title( $post ),
        'url'      => get_permalink( $post ),
    ];

    // Job title.
    if ( $has_acf ) {
        $title = get_field( 'clinician_title', $post->ID );
        if ( $title ) {
            $schema['jobTitle'] = $title;
        }
    }

    // Description from excerpt or content.
    $desc = ! empty( $post->post_excerpt )
        ? wp_strip_all_tags( $post->post_excerpt )
        : wp_trim_words( wp_strip_all_tags( $post->post_content ), 30, '...' );
    if ( $desc ) {
        $schema['description'] = $desc;
    }

    // Image.
    if ( has_post_thumbnail( $post ) ) {
        $schema['image'] = get_the_post_thumbnail_url( $post, 'large' );
    }

    // Credentials.
    if ( $has_acf ) {
        $credentials = get_field( 'clinician_credentials', $post->ID );
        if ( $credentials ) {
            $cred_lines = array_filter( array_map( 'trim', explode( "\n", $credentials ) ) );
            if ( ! empty( $cred_lines ) ) {
                $schema['hasCredential'] = array_map( function ( $line ) {
                    return [
                        '@type'          => 'EducationalOccupationalCredential',
                        'credentialCategory' => $line,
                    ];
                }, $cred_lines );
            }
        }

        // Specialties as knowsAbout.
        $specialties = get_field( 'clinician_specialties', $post->ID );
        if ( $specialties ) {
            $spec_texts = array_filter( array_column( $specialties, 'text' ) );
            if ( ! empty( $spec_texts ) ) {
                $schema['knowsAbout'] = array_values( $spec_texts );
            }
        }
    }

    // Affiliated organization.
    $schema['worksFor'] = [
        '@type' => 'MedicalBusiness',
        'name'  => get_bloginfo( 'name' ),
        'url'   => home_url( '/' ),
    ];

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";

}, 6 );

/**
 * JSON-LD MedicalWebPage + Service schema for service pages.
 */
add_action( 'wp_head', function () {
    if ( fc_seo_plugin_active() ) {
        return;
    }

    if ( ! is_page_template( 'template-service.php' ) ) {
        return;
    }

    $post    = get_queried_object();
    $has_acf = function_exists( 'get_field' );

    if ( ! $post ) {
        return;
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'MedicalWebPage',
        'name'     => get_the_title( $post ),
        'url'      => get_permalink( $post ),
    ];

    // Description.
    $desc = '';
    if ( $has_acf ) {
        $desc = get_field( 'svc_hero_intro', $post->ID );
    }
    if ( ! $desc && ! empty( $post->post_excerpt ) ) {
        $desc = wp_strip_all_tags( $post->post_excerpt );
    }
    if ( $desc ) {
        $schema['description'] = wp_strip_all_tags( $desc );
    }

    // Featured image.
    if ( has_post_thumbnail( $post ) ) {
        $schema['primaryImageOfPage'] = get_the_post_thumbnail_url( $post, 'large' );
    }

    // Provider reference.
    $schema['mainEntity'] = [
        '@type'    => 'MedicalTherapy',
        'name'     => get_the_title( $post ),
        'provider' => [
            '@type' => 'MedicalBusiness',
            'name'  => get_bloginfo( 'name' ),
            'url'   => home_url( '/' ),
        ],
    ];

    if ( $desc ) {
        $schema['mainEntity']['description'] = wp_strip_all_tags( $desc );
    }

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";

}, 7 );

/**
 * JSON-LD BreadcrumbList schema (output in templates via fc_breadcrumbs()).
 * This function renders visual breadcrumbs AND injects BreadcrumbList schema.
 */
function fc_breadcrumbs() : void {
    if ( is_front_page() ) {
        return;
    }

    $crumbs = [];

    // Home.
    $crumbs[] = [
        'name' => __( 'Home', 'flavour-clinic' ),
        'url'  => home_url( '/' ),
    ];

    if ( is_singular( 'post' ) ) {
        // Blog index.
        $posts_page_id = (int) get_option( 'page_for_posts' );
        if ( $posts_page_id ) {
            $crumbs[] = [
                'name' => get_the_title( $posts_page_id ),
                'url'  => get_permalink( $posts_page_id ),
            ];
        } else {
            $crumbs[] = [
                'name' => __( 'Articles', 'flavour-clinic' ),
                'url'  => home_url( '/blog/' ),
            ];
        }

        // Category.
        $cats = get_the_category();
        if ( ! empty( $cats ) ) {
            $crumbs[] = [
                'name' => $cats[0]->name,
                'url'  => get_category_link( $cats[0]->term_id ),
            ];
        }

        // Current post (no link).
        $crumbs[] = [ 'name' => get_the_title() ];

    } elseif ( is_category() || is_tag() || is_tax() ) {
        $posts_page_id = (int) get_option( 'page_for_posts' );
        if ( $posts_page_id ) {
            $crumbs[] = [
                'name' => get_the_title( $posts_page_id ),
                'url'  => get_permalink( $posts_page_id ),
            ];
        }
        $term = get_queried_object();
        if ( $term ) {
            $crumbs[] = [ 'name' => $term->name ];
        }

    } elseif ( is_singular( 'fc_clinician' ) ) {
        $crumbs[] = [ 'name' => get_the_title() ];

    } elseif ( is_page() ) {
        $crumbs[] = [ 'name' => get_the_title() ];

    } elseif ( is_home() ) {
        $crumbs[] = [ 'name' => __( 'Articles', 'flavour-clinic' ) ];

    } elseif ( is_date() ) {
        $crumbs[] = [ 'name' => get_the_archive_title() ];
    }

    if ( count( $crumbs ) < 2 ) {
        return;
    }

    // Render visual breadcrumbs.
    echo '<nav class="fc-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'flavour-clinic' ) . '">';
    echo '<ol class="fc-breadcrumbs__list">';

    foreach ( $crumbs as $i => $crumb ) {
        $is_last = ( $i === count( $crumbs ) - 1 );

        echo '<li class="fc-breadcrumbs__item">';
        if ( ! $is_last && ! empty( $crumb['url'] ) ) {
            printf( '<a href="%s" class="fc-breadcrumbs__link">%s</a>', esc_url( $crumb['url'] ), esc_html( $crumb['name'] ) );
        } else {
            printf( '<span class="fc-breadcrumbs__current" aria-current="page">%s</span>', esc_html( $crumb['name'] ) );
        }
        echo '</li>';
    }

    echo '</ol>';
    echo '</nav>';

    // Emit BreadcrumbList schema inline (only when no SEO plugin).
    if ( ! fc_seo_plugin_active() ) {
        $items = [];
        foreach ( $crumbs as $i => $crumb ) {
            $item = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $crumb['name'],
            ];
            if ( ! empty( $crumb['url'] ) ) {
                $item['item'] = $crumb['url'];
            }
            $items[] = $item;
        }

        $schema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ];

        echo '<script type="application/ld+json">';
        echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        echo '</script>' . "\n";
    }
}
