<div class="inside nav-container">
  <div style="margin: 1rem 0;">
    <a class="js-add-form-tag button" data-type="col">50% kolom</a>
    <a class="js-add-form-tag button" data-type="hidden">Hidden</a>
    <a class="js-add-form-tag button" data-type="text">Tekst</a>
    <a class="js-add-form-tag button" data-type="url">URL</a>
    <a class="js-add-form-tag button" data-type="tel">Telefoonnummer</a>
    <a class="js-add-form-tag button" data-type="number">Nummer</a>
    <a class="js-add-form-tag button" data-type="email">Email</a>
    <a class="js-add-form-tag button" data-type="textarea">Bericht</a>
    <a class="js-add-form-tag button" data-type="select">Select</a>
    <a class="js-add-form-tag button" data-type="checkbox">Checkbox</a>
    <a class="js-add-form-tag button" data-type="radio">Radio</a>
    <a class="js-add-form-tag button" data-type="submit">Submit</a>
  </div>
  <?php
    wp_editor( $content['content'], 'form_editor', array(
      'textarea_name' => 'form[content]',
      'wpautop' => true,
      'media_buttons' => false,
      'editor_css' => '',
      'textarea_rows' => 40
    ) );
    ?>
</div>

<?php
// include thickboxes
foreach( glob( FB_PLUGIN_DIR . '/views/thickboxes/*.php' ) as $file ) {
  include $file;
}
?>
