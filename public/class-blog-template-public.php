<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://abc.com
 * @since      1.0.0
 *
 * @package    Blog_Template
 * @subpackage Blog_Template/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Blog_Template
 * @subpackage Blog_Template/public
 * @author     Abhishek Tripathi <abhisheksaurabh78663@gmail.com>
 */
class Blog_Template_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Blog_Template_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Blog_Template_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/blog-template-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Blog_Template_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Blog_Template_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/blog-template-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'abhi_blog_param', array(
			'ajax_url' => admin_url('admin-ajax.php'),
		));

	}
	/**
	 * Filter post based on category selection.
	 */
	public function filter_posts_by_category() {
		$cat_slug = isset( $_POST['cat_slug'] ) ? $_POST['cat_slug'] : array();
		
		if ( isset( $cat_slug ) && ! empty( $cat_slug ) ) {
			
			$category_slug = $cat_slug;
			$query_arg = 'current_page';
			$current_page = ( isset( $_GET[ $query_arg ] ) && $_GET[ $query_arg ] ) ? absint( $_GET[ $query_arg ] ) : 1;
			
			if ( $cat_slug === 'allcategory' ) {
				$args = array(
					'post_type'      => 'post',
					'orderby'        => 'post_modified',
					'order'          => 'DESC',
					'posts_per_page' => 3,
				);
			} else {

				$args = array(
					'post_type'      => 'post',
					'category_name'  => $category_slug,
					'posts_per_page' => 3,
				);
			}
	
	
			$recent_blog_query = new WP_Query( $args );
			
	
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
            
                
            } else {
	
				echo '<h3 class="">No match found</h3>';
			}
			wp_reset_postdata();
			wp_die();
		} 
	
	}

	/**
	 * Pagination for post as per category.
	 */
	public function category_pagination() {
		$cat_slug = isset( $_POST['cat_slug'] ) ? $_POST['cat_slug'] : array();
		$paged = isset( $_POST['page_no'] ) ? $_POST['page_no'] : array();

		if ( isset( $cat_slug ) && ! empty( $cat_slug ) ) {
			
			$category_slug = $cat_slug; // Replace 'custom' with your actual category slug
			$query_arg = 'current_page';
			$current_page = ( isset( $_GET[ $query_arg ] ) && $_GET[ $query_arg ] ) ? absint( $_GET[ $query_arg ] ) : 1;

			if ( $cat_slug === 'allcategory' ) {
				$args = array(
					'post_type'      => 'post',
					'orderby'        => 'post_modified',
					'order'          => 'DESC',
					'posts_per_page' => 3,
					'paged'          => $paged
				);
			} else {

				$args = array(
					'post_type'      => 'post',
					'category_name'  => $category_slug,
					'posts_per_page' => 3,
					'paged'          => $paged
				);
			}
	
	
			$recent_blog_query = new WP_Query( $args );
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
            
                
            } else {
	
				echo '<h3 class="">No match found</h3>';
			}


			wp_reset_postdata();
			wp_die();
		} 
	
	}	

}
