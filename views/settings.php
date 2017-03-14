<?php
use Cuisine\Wrappers\Field;
?>
<div class="inside nav-container hidden">
  <?php
  Field::text( 'form[settings][form_class]', 'Form class', array(
    'defaultValue' => $content['settings']['form_class']
  ) )->render();
  Field::text( 'form[settings][action]', 'Form action (bedankt pagina url)', array(
    'defaultValue' => $content['settings']['action']
  ) )->render();
  ?>
</div>
