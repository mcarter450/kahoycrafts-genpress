<?php
/**
 * Kahoy Crafts Product Categories Widget
 */
class kahoycrafts_product_categories_widget extends WP_Widget {
  
	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'kahoycrafts_product_categories_widget',
			  
			// Widget name will appear in UI
			__('KC Product Categories Widget', 'kc_widget_domain'),
			  
			// Widget description
			[ 'description' => __( 'Display a list of WooCommerce product categories', 'kc_widget_domain' ), ]
		);
	}
  
	// Creating widget front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		  
		// This is where you run the code and display the output
		echo __( $this->content(), 'kc_widget_domain' );
		echo $args['after_widget'];
	}

	/**
	 * @return string 	HTML markup for widget
	 */
	protected function content() {

		$orderby = 'name';
		$order = 'asc';
		$hide_empty = true;
		$cat_args = array(
		    'orderby'    => $orderby,
		    'order'      => $order,
		    'hide_empty' => $hide_empty,
		);
		 
		$product_categories = get_terms('product_cat', $cat_args);

		$content = '';
		 
		if (! empty($product_categories) ) {
		    $content .= '
		 
		<ul>';
		    foreach ($product_categories as $key => $category) {
		        $content .= '
		 
		<li>';
		        $content .= '<a href="'.get_term_link($category).'">';
		        $content .= $category->name;
		        $content .= '</a>';
		        $content .= ' ('. $category->count .')';
		        $content .= '</li>';
		    }
		    $content .= '</ul>
		 
		 
		';
		}

		return $content;
	}
          
	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Product Categories', 'kc_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}
 
 }

