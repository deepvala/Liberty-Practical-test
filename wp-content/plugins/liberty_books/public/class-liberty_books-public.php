<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       deepvala
 * @since      1.0.0
 *
 * @package    Liberty_books
 * @subpackage Liberty_books/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Liberty_books
 * @subpackage Liberty_books/public
 * @author     Deep <deepvala339@gmail.com>
 */
class Liberty_books_Public {

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
		 * defined in Liberty_books_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Liberty_books_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/liberty_books-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'fontawsome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all' );

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
		 * defined in Liberty_books_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Liberty_books_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/liberty_books-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'wp_object',
	        array( 
	            'ajaxurl' => admin_url( 'admin-ajax.php' ),
	        )
	    );
		wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );

	}

	public function search_tool_liberty($atts = array()){
		try{
			global $wpdb;
			$html = '';

			$authors = get_terms([
			    'taxonomy' => 'author',
			    'hide_empty' => false,
			]);

			$publishers = get_terms([
			    'taxonomy' => 'publisher',
			    'hide_empty' => false,
			]);

			$html.= '<div class="container">
			  <h2>Book Search</h2>
			  <form action="javascript:;" method="post" name="form_search" id="form_search">
			    <div class="form-group">
			      <label for="book_name">Book Name:</label>
			      <input type="text" class="form-control" id="book_name" placeholder="Enter Book Name" name="book_name">
			    </div>
			    <div class="form-group">
			      <label for="author">Author:</label>
			      <select class="form-control" id="author" name="author">
			      	<option value="">Select Author</option>';
			      	foreach ($authors as $key => $author) {
			      		$html .= '<option value="'.$author->term_id.'">'.$author->name.'</option>';
			      	}
			    $html .= '</select>
			    </div>
			    <div class="form-group">
			      <label for="publisher">Publisher:</label>
			      <select class="form-control" id="publisher" name="publisher">
			      	<option value="">Select Publisher</option>';
			      	foreach ($publishers as $key => $publisher) {
			      		$html .= '<option value="'.$publisher->term_id.'">'.$publisher->name.'</option>';
			      	}
			    $html .= '</select>
			    </div>
			    <div class="form-group">
			      <label for="rating">Rating:</label>
			      <select class="form-control" id="rating" name="rating">
			      	<option value="">Select Rating</option>
			      	<option value="1">1</option>
			      	<option value="2">2</option>
			      	<option value="3">3</option>
			      	<option value="4">4</option>
			      	<option value="5">5</option>
			      </select>
			    </div>
			   	<div class="form-group">
			      <label for="price">Price:</label>
			      <input type="number" class="form-control" id="price" placeholder="Enter price" name="price">
			    </div>
			    <button type="submit" class="btn btn-default">Search</button>
			  </form>
			</div>';

			$args = array(
			    'post_type'  => 'book',
			    'posts_per_page' => 5,
			);
			$query = new WP_Query( $args );
			$found_posts = $query->found_posts;
			$max_num_pages = $query->max_num_pages;
			if ( $query->have_posts() ) {
			$html.= '<div class="container">
			  <h2>Books Table</h2>
			  <table class="table">
			    <thead>
			      <tr>
			        <th>No</th>
			        <th>Book Name</th>
			        <th>Price</th>
			        <th>Author</th>
			        <th>Publisher</th>
			        <th>Rating</th>
			      </tr>
			    </thead>
			    <tbody class="list_books">';
			    // The Loop
			    $sr = 1;
			    while ( $query->have_posts() ) {
			        $query->the_post();
			        $author = wp_get_object_terms( get_the_ID(), 'author', array( 'fields' => 'names' ) );
			        $publisher = wp_get_object_terms( get_the_ID(), 'publisher', array( 'fields' => 'names' ) );
			        $rating = get_post_meta(get_the_ID(), 'rating', true);
			        $_rating = '';
			        for($i=1;$i<=5;$i++) {
						$selected = "";
						if(!empty($rating) && $i<=$rating) {
							$selected = "selected";
							$_rating.= "<span class='fa fa-star ".$selected."'></span>";
						}
					}
			        $html.= '<tr>
				        <td>'.$sr.'</td>
				        <td><a href="'.get_permalink().'" target="_blank">'.get_the_title().'</a></td>
				        <td>'.get_post_meta(get_the_ID(), 'price', true).'</td>
				        <td>'.implode(', ', $author).'</td>
				        <td>'.implode(', ', $publisher).'</td>
				        <td>'.$_rating.'</td>
				    </tr>';
				    $sr++;
			    }
			$html .='</tbody>
			  </table>';
			  if($found_posts > 5){
				  $html .='<div>
				  	<button class="btn btn-default" id="load_more" data-paged="1">Load More</button>
				  </div>';
			  }
			$html .= '</div>';
			} else {
			    $html .='no books found';
			}
			return $html;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public function search_books(){
		try{
			$result = array();
			$book_name = esc_attr($_POST['book_name']);
			$author = esc_attr($_POST['author']);
			$publisher = esc_attr($_POST['publisher']);
			$rating = esc_attr($_POST['rating']);
			$price = esc_attr($_POST['price']);
			$paged = esc_attr($_POST['paged']);
			$html = '';
			$sr = (int) $paged * 5 + 1;
			$args = array(
			    'post_type'  => 'book',
			    'posts_per_page' => 5,
			);

			if(!empty($paged)){
				$paged = (int) $paged + 1;
				$args['paged'] = $paged;
			}

			if(!empty($author)){
				$args['tax_query'][] = array(
		            'taxonomy' => 'author',
		            'field'    => 'term_id',
		            'terms'    => $author,
				);
			}

			if(!empty($publisher)){
				$args['tax_query'][] = array(
		            'taxonomy' => 'publisher',
		            'field'    => 'term_id',
		            'terms'    => $publisher,
				);
			}

			if(!empty($author) && !empty($publisher)){
				$args['tax_query']['relation'] = 'AND';
			}

			if(!empty($rating)){
				$args['meta_query'][] = array(
		            'key'     => 'rating',
		            'value'   => $rating,
		            'compare' => '=',
		        );
			}

			if(!empty($price)){
				$args['meta_query'][] = array(
		            'key'     => 'price',
		            'value'   => $price,
		            'compare' => '=',
		        );
			}

			if(!empty($rating) && !empty($price)){
				$args['meta_query']['relation'] = 'AND';
			}

			if(!empty($book_name)){
				$args['post_title'] = $book_name;
				add_filter( 'posts_where', array($this, 'search_post_title'), 10, 2 );
				$query = new WP_Query( $args );
				remove_filter( 'posts_where', array($this, 'search_post_title'));
			}else{
				$query = new WP_Query( $args );
			}
			$found_posts = $query->found_posts;
			$max_num_pages = $query->max_num_pages;
			if ( $query->have_posts() ) {
				
				while ( $query->have_posts() ) {
			        $query->the_post();
			        $author = wp_get_object_terms( get_the_ID(), 'author', array( 'fields' => 'names' ) );
			        $publisher = wp_get_object_terms( get_the_ID(), 'publisher', array( 'fields' => 'names' ) );
			        $rating = get_post_meta(get_the_ID(), 'rating', true);
			        $_rating = '';
			        for($i=1;$i<=5;$i++) {
						$selected = "";
						if(!empty($rating) && $i<=$rating) {
							$selected = "selected";
							$_rating.= "<span class='fa fa-star ".$selected."'></span>";
						}
					}
			        $html.= '<tr>
				        <td>'.$sr.'</td>
				        <td><a href="'.get_permalink().'" target="_blank">'.get_the_title().'</a></td>
				        <td>'.get_post_meta(get_the_ID(), 'price', true).'</td>
				        <td>'.implode(', ', $author).'</td>
				        <td>'.implode(', ', $publisher).'</td>
				        <td>'.$_rating.'</td>
				    </tr>';
				    $sr++;
			    }
			}else{
				$html.= '<tr colspan="6">No books Found</tr>';
			}
			$result = array(
				'status' => 'success',
				'data' => $html,
				'max_num_pages' => $max_num_pages,
				'found_posts' => $found_posts,
				'paged' => $paged
			);
			echo json_encode($result);
			exit();
		}catch(Exception $e){
			echo json_encode(array('status' => 'error', 'data' => $e->getMessage()));
			exit();
		}
	}

	public function search_post_title( $where, $wp_query ) {
		$where .= " AND wp_posts.post_title LIKE '%".$wp_query->query['post_title']."%' ";
		return $where;
	}

}
