<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://abc.com
 * @since      1.0.0
 *
 * @package    Blog_Template
 * @subpackage Blog_Template/public/partials
 */

$args = array(
    'hide_empty'      => false,
);
$categories = get_categories( $args );

$query_arg = 'current_page';
$current_page = ( isset( $_GET[ $query_arg ] ) && $_GET[ $query_arg ] ) ? absint( $_GET[ $query_arg ] ) : 1;
$recent_args = array(
    'post_type'      => 'post',
    'orderby'        => 'post_modified', // Sorts by the date modified.
    'order'          => 'DESC',          // Sorts in descending order.
    'posts_per_page' => 3,
    'paged' => $current_page,
);
$recent_blog_query = new WP_Query( $recent_args );

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
            if (!empty($categories)) {
                echo '<select name="category-dropdown" id="category-dropdown">';
                echo '<option value="allcategory">All category</option>';
                foreach ($categories as $category) {
                    echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                }
                echo '</select>';
            } else {
                echo '<p>No categories found</p>';
            }
            ?>
            <div class="abhi-blog-area">
                <?php
                if ( $recent_blog_query->have_posts() ) {
                    while ( $recent_blog_query->have_posts() ) {
                        $recent_blog_query->the_post();
                        ?>
                        <div class="post abhi-blog-list">
                            <a href="<?php the_permalink(); ?>" target="_blank" rel="noopener" class="abhi-title">
                            
                            <h2><?php the_title(); ?></h2>
                            
                            </a>
                            <div class="post-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                            
                        
                        <?php
                    }
                    // Pagination
                    if( $recent_blog_query->max_num_pages > 1 ) {
                        echo paginate_links(
                            array(
                                'total' => $recent_blog_query->max_num_pages,
                                'current' => $current_page,
                                'base' => $page_url . '%_%',
                                'format' => '?' . $query_arg . '=%#%',
                                'prev_next' => false,
							    'next_text' => false,
                            )
                        );
                    }
                
                    
                }
                wp_reset_postdata();
                        
                ?>
            </div>
    </main>
</div>