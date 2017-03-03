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

  }

}

?>
