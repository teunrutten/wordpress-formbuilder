<?php
use Cuisine\Wrappers\Field;
?>
<div class="inside nav-container hidden">
  <br/>
  <?php
  Field::text( 'form[settings][form_class]', 'Form class', array(
    'defaultValue' => $content['settings']['form_class']
  ) )->render();
  Field::text( 'form[settings][action]', 'Form action (bedankt pagina url)', array(
    'defaultValue' => $content['settings']['action']
  ) )->render();
  Field::text( 'form[settings][enctype]', 'Form enctype', array(
    'defaultValue' => $content['settings']['enctype'] ?? ''
  ) )->render();
  Field::text( 'form[settings][receiver]', 'Mailen naar:', array(
    'defaultValue' => $content['settings']['receiver'] ?? ''
  ) )->render();
  ?>
</div>
