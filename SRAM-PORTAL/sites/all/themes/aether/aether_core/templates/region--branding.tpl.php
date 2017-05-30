<?php
/**
 * @file
 * Aether implementation to display the branding hgroup in a template.
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
    <?php if ($secondary_menu): ?>
      <nav class="menu">
        <?php print theme('links', array('links' => $secondary_menu,'attributes' => array('id' => 'secondary','class' => array('links','secondary-links','clearfix','sub-menu')))); ?>
      </nav>
    <?php endif; ?>

    <?php if ($logo): ?>
      <div class="logo">
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/>
        </a>
      </div>
    <?php endif; ?>

    <?php if ($site_name || $site_slogan): ?>
      <hgroup class="name-and-slogan">
        <?php if ($site_name): ?>
          <h1 class="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $linked_site_name; ?></span></a>
          </h1>
        <?php endif; ?>
        <?php if ($site_slogan): ?>
          <div class="site-slogan"><?php print $site_slogan; ?></div>
        <?php endif; ?>
      </hgroup>
    <?php endif; ?>
  </div>
  <?php print $content; ?>
</div>
