<?php
use Cuisine\Wrappers\Field;
?>
<div class="inside nav-container hidden">
  <br/>
  <?php
  Field::checkbox( 'form[autoresponder][enabled]', 'Ingeschakeld', array(
    'defaultValue' => $content['autoresponder']['enabled'] ?? 'false'
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
  <p>Gebruik <code>|%VOORNAAM%|</code> om de voornaam in te voegen</p>
  <p>Gebruik <code>|%ACHTERNAAM%|</code> om de achternaam in te voegen</p>
  <p>Gebruik <code>|%DATUM%|</code> om de datum in te voegen</p>
  <p>Gebruik <code>|%LOCATIE%|</code> om de locatie in te voegen</p>
  <p>Gebruik <code>|%KEUZE%|</code> om de keuze in te voegen</p>
</div>
