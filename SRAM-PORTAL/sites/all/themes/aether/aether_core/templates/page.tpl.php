<?php
/**
 * @file
 * Aether theme's implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $secondary_menu_heading: The title of the menu used by the secondary links.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['header_first']: Items for the header first region.
 * - $page['header_second']: Items for the header second region.
 * - $page['header_third']: Items for the header third region.
 * - $page['header']: Items for the header region.
 * - $page['navigation']: Items for the navigation region, below the main menu.
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['footer']: Items for the footer region.
 * - $page['footer_first']: Items for the footer first region.
 * - $page['footer_second']: Items for the footer first region.
 * - $page['footer_third']: Items for the footer first region.
 * - $page['footer_fourth']: Items for the footer first region.
 * - $page['bottom']: Items to appear at the bottom of the page.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see aether_preprocess_page()
 * @see template_process()
 */
?>

<div id="page" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <header id="header" role="banner" class="clearfix">

    <?php if ($page['user_first'] || $page['user_second']): ?>
      <div class="user-columns-wrapper clearfix">
        <div class="limiter">
          <div class="user-row g-all-row">
            <?php print render($page['user_first']); ?>
            <?php print render($page['user_second']); ?>
          </div> <!-- /.g-all-row -->
        </div> <!-- /.limiter -->
      </div> <!-- /.wrapper -->
    <?php endif; ?>

    <div class="branding-wrapper clearfix">
      <div class="limiter">
        <div class="branding-row g-all-row">
          <?php if ($logo || $site_name || $site_slogan || $secondary_menu || $page['branding']): ?>
            <?php print render($page['branding']); ?>
          <?php endif; ?>
        </div> <!-- /g-all-row -->
      </div> <!-- /limiter -->
    </div> <!-- /branding-wrapper -->

    <?php if ($page['header_first'] || $page['header_second'] || $page['header_third']): ?>
      <div class="header-columns-wrapper clearfix">
        <div class="limiter">
          <div class="header-row g-all-row">
            <?php print render($page['header_first']); ?>
            <?php print render($page['header_second']); ?>
            <?php print render($page['header_third']); ?>
          </div> <!-- /#header-columns -->
        </div> <!-- /.limiter -->
      </div> <!-- /.header-columns-wrapper -->
    <?php endif; ?>

  </header> <!-- /header -->

  <?php if ($main_menu): ?>
    <nav id="main-menu" class="main-menu menu">
      <div class="main-menu-wrapper clearfix">
        <div class="limiter">
          <div class="main-menu-row g-all-row">
            <?php if ($main_menu): ?>
              <?php print render($page['main_menu']); ?>
            <?php endif; ?>
          </div> <!-- /.limiter -->
        </div> <!-- /g-all-row -->
      </div> <!-- /.main-menu-wrapper -->
    </nav>
  <?php endif; ?>

  <?php if ($page['navigation_first'] || $page['navigation_second']): ?>
    <div class="navigation-columns-wrapper clearfix">
      <div class="limiter">
        <div class="navigation-row g-all-row">
          <?php if ($page['navigation_first']): ?>
            <?php print render($page['navigation_first']); ?>
          <?php endif; ?>
          <?php if ($page['navigation_second']): ?>
            <?php print render($page['navigation_second']); ?>
          <?php endif; ?>
        </div> <!-- /g-all-row -->
      </div> <!-- /limiter -->
    </div> <!-- /.navigation-columns-wrapper -->
  <?php endif; ?>

  <?php if ($page['feature']): ?>
    <section id="feature" class="clearfix">
      <div class="feature-wrapper clearfix">
        <div class="limiter">
          <div class="feature-row g-all-row">
            <?php print render($page['feature']); ?>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <section id="main">

    <?php if ($page['preface_first'] || $page['preface_second'] || $page['preface_third']): ?>
      <div class="preface-wrapper clearfix">
        <div class="limiter">
          <div class="preface-row g-all-row">
            <?php print render($page['preface_first']); ?>
            <?php print render($page['preface_second']); ?>
            <?php print render($page['preface_third']); ?>
          </div> <!-- /#preface-columns -->
        </div>
      </div>
    <?php endif; ?>

    <div class="content-wrapper clearfix">
      <div class="limiter">
        <div class="content-row g-all-row">
          <div id="content" <?php print $attributes; ?>>
            <div <?php print $content_attributes; ?>>
              <div class="content-block">
                <?php if ($breadcrumb || $title|| $messages || $tabs || $action_links): ?>
                <div id="content-header">
                  <?php print $breadcrumb; ?>
                  <?php if ($page['highlight']): ?>
                    <div id="highlight"><?php print render($page['highlight']) ?></div>
                  <?php endif; ?>
                  <?php if ($title): ?>
                    <h1 class="title"><?php print $title; ?></h1>
                  <?php endif; ?>
                  <?php print $messages; ?>
                  <?php print render($page['help']); ?>
                  <?php if ($tabs): ?>
                    <div class="tabs"><?php print render($tabs); ?></div>
                  <?php endif; ?>
                  <?php if ($action_links): ?>
                    <ul class="action-links"><?php print render($action_links); ?></ul>
                  <?php endif; ?>
                </div> <!-- /#content-header -->
                <?php endif; ?>
                <div id="content-area">
                  <?php print render($page['content']) ?>
                </div>
                <?php print $feed_icons; ?>
              </div> <!-- /.block -->
            </div> <!-- /.content-inner -->
          </div> <!-- /content -->
          <?php print render($page['sidebar_first']); ?>
          <?php print render($page['sidebar_second']); ?>
        </div> <!-- /.g-all-row -->
      </div> <!-- /.limiter -->
    </div> <!-- /.content-wrapper -->

    <?php if ($page['postscript_first'] || $page['postscript_second'] || $page['postscript_third'] || $page['postscript_fourth']): ?>
      <div class="postscript-wrapper clearfix">
        <div class="limiter">
          <div class="postscript-row g-all-row">
            <?php print render($page['postscript_first']); ?>
            <?php print render($page['postscript_second']); ?>
            <?php print render($page['postscript_third']); ?>
            <?php print render($page['postscript_fourth']); ?>
          </div> <!-- /#postscript-columns /.g-all-row -->
        </div> <!-- /.limiter -->
      </div> <!-- /.powerscript-wrapper -->
    <?php endif; ?>

  </section> <!-- /main -->

  <div id="page-footer"></div>
</div> <!-- /page -->

<footer id="footer">

  <?php if ($page['footer_first'] || $page['footer_second'] || $page['footer_third'] || $page['footer_fourth']): ?>
    <div class="footer-columns-wrapper">
      <div class="limiter">
        <div class="footer-columns-row g-all-row">
          <?php print render($page['footer_first']); ?>
          <?php print render($page['footer_second']); ?>
          <?php print render($page['footer_third']); ?>
          <?php print render($page['footer_fourth']); ?>
        </div> <!-- /#footer-columns /.g-all-row -->
      </div> <!-- /.limiter -->
    </div> <!-- /.footer-columns-wrapper -->
  <?php endif; ?>

  <?php if ($page['footer']): ?>
    <div class="footer-wrapper">
      <div class="limiter">
        <div class="footer-row g-all-row">
          <?php print render($page['footer']); ?>
        </div> <!-- /.g-all-row -->
      </div> <!-- /.limiter -->
    </div> <!-- /.footer-wrapper -->
  <?php endif; ?>

</footer>
