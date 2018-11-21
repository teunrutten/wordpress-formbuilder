<?php
/**
 * FormPostType
 *
 * @package WordPress
 * @subpackage FormBuilder
 * @since 1.0.0
 */

namespace FormBuilder\Lib;
use \Cuisine\Wrappers\PostType;
// use \Cuisine\Wrappers\Metabox;

class FormPostType {

  public function __construct () {
    $args = array(
      'menu_icon' => 'dashicons-email',
      'public' => true,
      'menu_position' => 100,
      'publicly_queryable' => false,
      'supports' => array( 'title' ),
    );
    PostType::make( 'form', 'Formulieren', 'Formulier' )->set( $args );

    add_action( 'manage_form_posts_columns', array( $this, 'set_custom_edit_form_columns' ) );
    add_action( 'manage_form_posts_custom_column', array( $this, 'custom_form_column' ), 10, 2 );
  }

  public function set_custom_edit_form_columns($columns) {
    $columns['form_id'] = 'ID';
    return $columns;
  }

  public function custom_form_column($column, $post_id) {
    if ( $column == 'form_id') {
      echo $post_id;
    }
  }

}
