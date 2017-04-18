<?php
/**
 * Admin class
 *
 * @package WordPress
 * @subpackage FormBuilder
 * @since 1.0.0
 */

namespace FormBuilder\Lib;
use \Cuisine\Wrappers\Metabox;

class Admin {

  public function __construct () {

    // PostType::make( 'form', 'Projects', 'Project' )->set();
    Metabox::make( 'Formulier', 'form' )->set( '\\FormBuilder\Lib\\Admin::metabox' );

    add_action( 'admin_enqueue_scripts', function () {
      wp_enqueue_script( 'admin-tabs', FB_PLUGIN_URL . '/assets/admin-tabs.js', array( 'jquery' ) );
      wp_enqueue_script( 'add-tag', FB_PLUGIN_URL . '/assets/add-tag.js', array( 'jquery' ) );
    } );

    // Remove Yoast support
    add_action( 'add_meta_boxes', function () {
      remove_meta_box('wpseo_meta', 'form', 'normal');
    }, 11 );

    add_action( 'save_post_form', function ( $post_id ) {
      if ( ! isset( $_POST['save_form_nonce'] ) || ! wp_verify_nonce( $_POST['save_form_nonce'], 'save_form' ) ) {
        return $post_id;
      }

      if ( isset( $_POST['form'] ) ) {
        update_post_meta( $post_id, '_form', $_POST['form'] );
      } else {
        die('not set');
      }
    });

  }

  public static function metabox () {
    // Add thickbox
    add_thickbox();

    $defaults = array(
      'content' => '',
      'settings' => array(
        'form_class' => 'c-form u-flex u-flex-sb',
        'action' => '',
      )
    );

    if ( isset( $_GET['post'] ) ) {
      $form = get_post_meta( $_GET['post'], '_form', true );
      $content = wp_parse_args( $form, $defaults );
    } else {
      $content = $defaults;
    }

    ?>
    <h2 class="nav-tab-wrapper current">
     <a class="nav-tab nav-tab-active" href="javascript:;">Formulier</a>
     <a class="nav-tab" href="javascript:;">Instellingen</a>
    </h2>
      <?php
      echo wp_nonce_field( 'save_form', 'save_form_nonce' );
      include ( FB_PLUGIN_DIR . '/views/form.php' );
      include ( FB_PLUGIN_DIR . '/views/settings.php' );
      ?>
    <?php if ( isset( $_GET['post'] ) ): ?>
      <div class="shortcode-wrapper">
        <i>Gebruik deze tag om het formulier weer te geven:</i>
        <input type="text" class="large-text" readonly onfocus="this.select();" value='[form id="<?php echo $_GET['post'] ?>"]'>
      </div>
    <?php endif; ?>
    <?php
  }

}

?>
