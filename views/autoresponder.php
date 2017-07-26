<?php
use Cuisine\Wrappers\Field;
?>
<div class="inside nav-container hidden">
  <?php
  Field::checkbox( 'form[autoresponder][enabled]', 'Ingeschakeld', array(
    'defaultValue' => $content['autoresponder']['enabled'] ?? 'true'
  ) )->render();
  Field::text( 'form[autoresponder][subject]', '', array(
    'defaultValue' => $content['autoresponder']['subject'] ?? '',
    'placeholder' => 'Onderwerp'
  ) )->render();
  wp_editor( $content['autoresponder']['content'] ?? '', 'hash-' . uniqid(), array(
    'textarea_name' => 'form[autoresponder][content]'
  ) );
  ?>
  <p>Gebruik <code>|%AANHEF%|</code> om dhr/mevr te veranderen in heer/mevrouw</p>
  <p>Gebruik <code>|%ACHTERNAAM%|</code> om de achternaam in te voegen</p>
</div>
