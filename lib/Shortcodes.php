<?php
/**
 * Shortcodes
 *
 * @package WordPress
 * @subpackage FormBuilder
 * @since 1.0.0
 */

namespace FormBuilder\Lib;
use Timber\Timber;
class Shortcodes {

  public function __construct () {
    add_shortcode( 'form', array( $this, 'form' ) );
    add_shortcode( 'input_hidden', array( $this, 'inputHidden' ) );
    add_shortcode( 'input', array( $this, 'input' ) );
    add_shortcode( 'radio', array( $this, 'radio' ) );
    add_shortcode( 'checkbox', array( $this, 'checkbox' ) );
    add_shortcode( 'select', array( $this, 'select' ) );
    add_shortcode( 'textarea', array( $this, 'textarea' ) );
    add_shortcode( 'col', array( $this, 'col' ) );
    add_shortcode( 'submit', array( $this, 'submit' ) );
  }

  public function form ($atts, $content = '') {
    if ( ! isset( $atts['id'] ) || empty( $atts['id'] ) ) return;

    // Get form
    $form = get_post_meta( $atts['id'], '_form', true );
    $enctype = $form['settings']['enctype'] ?? '';
    $html = apply_filters( 'formbuilder_before_opening_form', '' );
    $html .= '<form method="post" enctype="' . $enctype . '"  class="' . $form['settings']['form_class'] . '" ' . ( ! empty( $form['settings']['action'] ) ? 'action="' . $form['settings']['action'] . '"' : '' ) .  '>';
    $html .= $this->inputHidden( array( 'name' => 'form_id', 'value' => $atts['id'] ) );
    $html .= $this->inputHidden( array( 'name' => 'form_title', 'value' => get_the_title( $atts['id'] ) ) );
    $html .= apply_filters( 'formbuilder_after_opening_form', '' );
    $html .= do_shortcode( $form['content'] );
    $html .= apply_filters( 'formbuilder_before_closing_form', '' );
    $html .= '</form>';
    $html .= apply_filters( 'formbuilder_after_closing_form', '' );

    return $html;
  }

  /**
   * Hidden input
   */
  public function inputHidden( $atts, $content = '' ) {
    return '<input type="hidden" name="' . $atts['name'] . '" value="' . $atts['value'] . '">';
  }

  /**
   * Input
   */
  public function input( $atts, $content = '' ) {
    $width = isset( $atts['width'] ) ? $atts['width'] : false;
    $html = '';

    if( $atts['type'] !== 'hidden' ) {
      $html .= $this->getOpeningInputContainer( $width, 'c-input--default' );
    }

    if ( isset( $atts['label'] ) && ! empty( $atts['label'] ) ) {
      $html .= '<label class="c-input__label">' . $atts['label'] . '</label>';
    }

    if ( isset( $atts['title'] ) && ! empty( $atts['title'] ) ) {
      $html .= '<div class="c-input__container c-input__container--has-title">';
    } else {
      $html .= '<div class="c-input__container">';
    }

    $html .= '<input class="c-input__input" ';
    if ( isset( $atts['type'] ) ) { $html .= 'type="' . $atts['type'] . '" '; }
    if ( isset( $atts['name'] ) ) { $html .= 'name="' . $atts['name'] . '" '; }
    if ( isset( $atts['placeholder'] ) ) { $html .= 'placeholder="' . $atts['placeholder'] . '" '; }
    if ( isset( $atts['pattern'] ) ) { $html .= 'pattern="' . urldecode($atts['pattern']) . '" '; }
    if ( isset( $atts['required'] ) ) { $html .= 'required '; }
    if ( isset( $atts['value'] ) ) { $html .= 'value="' . $atts['value'] . '" '; }
    if ( isset( $atts['maxlength'] ) ) { $html .= 'maxlength="' . $atts['maxlength'] . '" '; }
    $html .= '/>';

    if ( isset( $atts['title'] ) && ! empty( $atts['title'] ) ) {
      $html .= '<span class="c-input__title">' . $atts['title'] . '</span>';
    }

    if ( isset( $atts['error'] ) ) { 
      $html .= '<div class="c-input__error">' . $atts['error'] . '</div>';
    }

    if ( isset( $atts['required'] ) && $atts['required'] === 'required' ) {
      $html .= $this->getInputValidationStatus( 'c-input__status--default' );
    }

    $html .= '</div>'; // end .c-input__container

    if( $atts['type'] !== 'hidden' ) {
      $html .= $this->getClosingInputContainer();
    }

    return $html;
  }

  /**
   * Radio
   */
  public function radio ( $atts, $content ) {  
    if ( ! isset( $atts['values'] ) || ! isset( $atts['labels'] ) ) return;

    $values = explode( ',', $atts['values'] );
    $labels = explode( ',', $atts['labels'] );
    $width = isset( $atts['width'] ) ? $atts['width'] : false;
    $float = isset( $atts['float'] );
    $additionalClass = !isset( $atts['float'] ) ? 'c-input--radio' : 'c-input--radio c-input__radio-group c-input__radio-group--'.count($values); 

    $html = $this->getOpeningInputContainer( $width, $additionalClass );

    if ( isset( $atts['label'] ) && ! empty( $atts['label'] ) ) {
      $html .= '<label class="c-input__label c-radio__group-label">' . $atts['label'] . '</label>';
    }

    foreach ( $values as $key => $value ) {
      $id = 'hash-' . uniqid() . '-' . $key;

      if ( $float ) {
        $html .= '<div class="c-radio">';
      } else {
        $html .= '<span class="c-radio">';
      }

      $html .= '<input type="radio" name="' . $atts['name'] . '" value="' . $value . '" id="' . $id . '" class="c-radio__element" ' . ( $key === 0 ? 'checked' : '' )  . '/>';
      
      if ( $labels[$key] ) {
        $html .= '<label class="c-radio__label" for="' . $id . '">' . $labels[$key] . '</label>';
      }

      if ( $float ) {
        $html .= '</div>';
      } else {
        $html .= '</span>';
      }
    }

    $html .= $this->getClosingInputContainer();

    return $html;
  }
  /**
   * Returns a checkbox
   */
  public function checkbox ( $atts, $content ) {
    if ( ! isset( $atts['value'] ) || ! isset( $atts['label'] ) || ! isset( $atts['name'] )  ) return;

    $width = isset( $atts['width'] ) ? $atts['width'] : false;
    $float = isset( $atts['float'] );
    $additionalClass = !isset( $atts['float'] ) ? 'c-input--checkbox' : 'c-input--checkbox c-input__checkbox-group';

    $html = $this->getOpeningInputContainer( $width, $additionalClass );

    $required  = '';
    if( isset( $atts['required'] ) ) {
      $required = 'required';
    }

    $id = sanitize_title( $atts['name'] );
    
    $html .= '<div class="c-checkbox">';
    $html .= '<input type="checkbox" name="' . $atts['name'] . '" ' . $required . '  value="' . $atts['value'] . '" id="' . $id . '" class="c-checkbox__element" ' . ( isset( $atts['checked'] ) && $atts['checked'] === 'checked' ? 'checked' : '' )  . '/>';
    $html .= '<label class="c-checkbox__label" for="' . $id . '">' . $atts['label'] . '</label>';

    if ( isset( $atts['error'] ) ) { 
      $html .= '<div class="c-checkbox__error">' . $atts['error'] . '</div>'; 
    }

    $html .= '</div>';

    $html .= $this->getClosingInputContainer( 'c-input__status--default' );
    return $html;
  }

  /**
   * Returns a select box
   */
  public function select ( $atts, $content ) {
    if ( ! isset( $atts['values'] ) || ! isset( $atts['labels'] ) ) return;

    $html = $this->getOpeningInputContainer( $atts['width'] ?? false, 'c-input--select' );
    $values = explode( ',', $atts['values'] );
    $labels = explode( ',', $atts['labels'] );

    $html .= isset( $atts['label'] ) ? '<label class="c-input__label c-input__label--select">' . $atts['label']  .'</label>' : '';

    $html .= '<div class="c-input__container c-input__container--select">';

    $html .= '<select class="c-select" name="' . $atts['name'] . '" ' . ( isset( $atts['required'] ) ? 'required': '' ) . '>';
    foreach ( $values as $key => $value ) {
      if ( isset($atts['required']) ) {
        $option_value = ( $value !== '#' ) ? 'value="' . $value . '"' : 'value="" disabled selected';
      } else {
        $option_value = ( $value !== '#' ) ? 'value="' . $value . '"' : 'disabled selected';
      }
    
      $html .= '<option '.$option_value.'>';
      $html .= $labels[$key];
      $html .= '</option>';
    }
    $html .= '</select>';

    if ( isset( $atts['error'] ) ) { 
      $html .= '<div class="c-input__error c-input__error--select">' . $atts['error'] . '</div>'; 
    }

    if ( isset( $atts['required'] ) && $atts['required'] === 'required' ) {
      $html .= $this->getInputValidationStatus( 'c-input__status--select' );
    }

    $html .= '</div>'; // end .c-input__container

    $html .= $this->getClosingInputContainer();
    return $html;
  }

  /**
   * Textarea
   */
  public function textarea ( $atts, $content ) {
    $width = isset( $atts['width'] ) ? $atts['width'] : false;
    $html = $this->getOpeningInputContainer( $width, 'c-input--textarea' );

    if ( isset( $atts['label'] ) && ! empty( $atts['label'] ) ) {
      $html .= '<label class="c-input__label c-input__label--textarea">' . $atts['label'] . '</label>';
    }

    $html .= '<div class="c-input__container c-input__container--textarea">';

    $html .= '<textarea class="c-input__input c-textarea" ';
    if ( isset( $atts['name'] ) ) { $html .= 'name="' . $atts['name'] . '" '; }
    if ( isset( $atts['placeholder'] ) ) { $html .= 'placeholder="' . $atts['placeholder'] . '" '; }
    if ( isset( $atts['maxlength'] ) ) { $html .= 'maxlength="' . $atts['maxlength'] . '" '; }
    if ( isset( $atts['required'] ) ) { $html .= 'required '; }
    $html .= '></textarea>';

    if ( isset( $atts['title'] ) && ! empty( $atts['title'] ) ) {
      $html .= '<span class="c-input__title c-input__title--textarea">' . $atts['title'] . '</span>';
    }

    if ( isset( $atts['error'] ) ) { 
      $html .= '<div class="c-input__error c-input__error--textarea">' . $atts['error'] . '</div>'; 
    }

    if ( isset( $atts['required'] ) && $atts['required'] === 'required' ) {
      $html .= $this->getInputValidationStatus( 'c-input__status--textarea' );
    }

    $html .= '</div>'; // end .c-input__container

    $html .= $this->getClosingInputContainer();
    return $html;
  }

  public function col ( $atts, $content ) {
    $html = '<div class="u-flex u-flex-sb u-1/2@m">';
    $html .= do_shortcode( $content );
    $html .= '</div>';

    return $html;
  }

  public function submit ($atts, $content = '') {
    $width = isset( $atts['width'] ) ? $atts['width'] : false;

    $html = $this->getOpeningInputContainer( $width, 'c-input--submit' );

    $html .= Timber::compile( '/views/shared/loading-button.twig', array(
      'style' => $atts['style'] ?? '',
      'additionalClass' => '',
      'content' => $atts['content'] ?? '',
      'size' => $atts['size'] ?? '',
      'type' => 'submit'
    ) );

    $html .= $this->getClosingInputContainer();

    return $html;
  }

  private function getOpeningInputContainer ( $size = false , $additionalClass = '' ) {
    $class = 'c-input';
    if ($size) { $class .= ' ' . $size; }
    if ($additionalClass) { $class .= ' ' . $additionalClass; }
    return '<div class="' . $class . '">';
  }

  private function getClosingInputContainer () {
    return '</div>';
  }

  private function getInputValidationStatus ( $additionalClass = '' ) {
    return '
    <div class="c-input__status '.$additionalClass.'">
      <svg class="c-icon c-icon--small c-input__status-icon c-input__status-icon--success"><use xlink:href="#form-success"></use></svg>
      <svg class="c-icon c-icon--small c-input__status-icon c-input__status-icon--error"><use xlink:href="#form-error"></use></svg>
    </div>';
  }

}
