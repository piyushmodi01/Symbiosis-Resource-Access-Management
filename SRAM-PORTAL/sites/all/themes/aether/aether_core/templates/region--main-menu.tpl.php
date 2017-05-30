<?php
/**
 * @file
 * Aether implementation to display the main menu in a template.
 * This is necessary to reduce markup in page.tpl.php
 *
 * Only the variables necessary to print this region are passed to
 * process_region.
 * Some may be blank but they are provided for consistency.
 *
 * @see template_process_region()
 * @see template_preprocess_page()
 */
?>
<div class="<?php print $classes; ?> clearfix"> 
  <div <?php print $content_attributes; ?>>
    <?php if ($main_menu): ?>
      <?php print $main_menu; ?>
    <?php endif; ?>
  </div>
  <?php print $content; ?>
</div>
