<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       deepvala
 * @since      1.0.0
 *
 * @package    Liberty_books
 * @subpackage Liberty_books/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Liberty_books
 * @subpackage Liberty_books/admin
 * @author     Deep <deepvala339@gmail.com>
 */
class Liberty_books_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/liberty_books-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/liberty_books-admin.js', array( 'jquery' ), $this->version, false );

	}

	// Register Custom Post Type
	public function register_books() {

		$labels = array(
			'name'                  => _x( 'Books', 'Post Type General Name', 'book' ),
			'singular_name'         => _x( 'Book', 'Post Type Singular Name', 'book' ),
			'menu_name'             => __( 'Books', 'book' ),
			'name_admin_bar'        => __( 'Post Type', 'book' ),
			'archives'              => __( 'Item Archives', 'book' ),
			'attributes'            => __( 'Item Attributes', 'book' ),
			'parent_item_colon'     => __( 'Parent Item:', 'book' ),
			'all_items'             => __( 'All Items', 'book' ),
			'add_new_item'          => __( 'Add New Item', 'book' ),
			'add_new'               => __( 'Add New Book', 'book' ),
			'new_item'              => __( 'New Item', 'book' ),
			'edit_item'             => __( 'Edit Item', 'book' ),
			'update_item'           => __( 'Update Item', 'book' ),
			'view_item'             => __( 'View Item', 'book' ),
			'view_items'            => __( 'View Items', 'book' ),
			'search_items'          => __( 'Search Item', 'book' ),
			'not_found'             => __( 'Not found', 'book' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'book' ),
			'featured_image'        => __( 'Featured Image', 'book' ),
			'set_featured_image'    => __( 'Set featured image', 'book' ),
			'remove_featured_image' => __( 'Remove featured image', 'book' ),
			'use_featured_image'    => __( 'Use as featured image', 'book' ),
			'insert_into_item'      => __( 'Insert into item', 'book' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'book' ),
			'items_list'            => __( 'Items list', 'book' ),
			'items_list_navigation' => __( 'Items list navigation', 'book' ),
			'filter_items_list'     => __( 'Filter items list', 'book' ),
		);
		$args = array(
			'label'                 => __( 'Book', 'book' ),
			'description'           => __( 'Book Custom Post Type', 'book' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'custom-fields' ),
			'taxonomies'            => array( 'author', 'publisher' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'book', $args );

	}

	// Register Custom Taxonomy
	function author_taxonomy() {

		$labels = array(
			'name'                       => _x( 'authors', 'Taxonomy General Name', 'authors' ),
			'singular_name'              => _x( 'author', 'Taxonomy Singular Name', 'authors' ),
			'menu_name'                  => __( 'Authors', 'authors' ),
			'all_items'                  => __( 'All Items', 'authors' ),
			'parent_item'                => __( 'Parent Item', 'authors' ),
			'parent_item_colon'          => __( 'Parent Item:', 'authors' ),
			'new_item_name'              => __( 'New Item Name', 'authors' ),
			'add_new_item'               => __( 'Add New Item', 'authors' ),
			'edit_item'                  => __( 'Edit Item', 'authors' ),
			'update_item'                => __( 'Update Item', 'authors' ),
			'view_item'                  => __( 'View Item', 'authors' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'authors' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'authors' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'authors' ),
			'popular_items'              => __( 'Popular Items', 'authors' ),
			'search_items'               => __( 'Search Items', 'authors' ),
			'not_found'                  => __( 'Not Found', 'authors' ),
			'no_terms'                   => __( 'No items', 'authors' ),
			'items_list'                 => __( 'Items list', 'authors' ),
			'items_list_navigation'      => __( 'Items list navigation', 'authors' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'author', array( 'book' ), $args );

	}

	// Register Custom Taxonomy
	function publisher_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Publishers', 'Taxonomy General Name', 'publisher' ),
			'singular_name'              => _x( 'Publisher', 'Taxonomy Singular Name', 'publisher' ),
			'menu_name'                  => __( 'Publishers', 'publisher' ),
			'all_items'                  => __( 'All Items', 'publisher' ),
			'parent_item'                => __( 'Parent Item', 'publisher' ),
			'parent_item_colon'          => __( 'Parent Item:', 'publisher' ),
			'new_item_name'              => __( 'New Item Name', 'publisher' ),
			'add_new_item'               => __( 'Add New Item', 'publisher' ),
			'edit_item'                  => __( 'Edit Item', 'publisher' ),
			'update_item'                => __( 'Update Item', 'publisher' ),
			'view_item'                  => __( 'View Item', 'publisher' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'publisher' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'publisher' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'publisher' ),
			'popular_items'              => __( 'Popular Items', 'publisher' ),
			'search_items'               => __( 'Search Items', 'publisher' ),
			'not_found'                  => __( 'Not Found', 'publisher' ),
			'no_terms'                   => __( 'No items', 'publisher' ),
			'items_list'                 => __( 'Items list', 'publisher' ),
			'items_list_navigation'      => __( 'Items list navigation', 'publisher' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'publisher', array( 'book' ), $args );

	}

}
