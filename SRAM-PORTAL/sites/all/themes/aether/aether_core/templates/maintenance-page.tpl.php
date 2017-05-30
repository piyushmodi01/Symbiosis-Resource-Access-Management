<?php
/**
 * @file
 * Aether's implementation to display a single Drupal page while offline.
 *
 * All the available variables are mirrored in html.tpl.php and page.tpl.php.
 * Some may be blank but they are provided for consistency.
 *
 * @see template_preprocess()
 * @see template_preprocess_maintenance_page()
 */
?><!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" <?php print $html_attributes; ?>><![endif]-->
<!--[if lte IE 6]><html class="lt-ie9 lt-ie8 lt-ie7" <?php print $html_attributes; ?>><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="lt-ie9 lt-ie8" <?php print $html_attributes; ?>><![endif]-->
<!--[if IE 8]><html class="lt-ie9" <?php print $html_attributes; ?>><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!--><html <?php print $html_attributes; ?>><!--<![endif]-->

<head>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>

  <?php if ($add_responsive_meta): ?>
    <meta name="viewport" content="width=device-width, target-densityDpi=160dpi, initial-scale=1">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
  <?php endif; ?>
  <meta http-equiv="cleartype" content="on">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <?php print $styles; ?>
  <?php print $scripts; ?>
  <?php if ($add_responsive_tables): ?>
    <script src="<?php print $base_path . $path_to_aether; ?>/js/responsive-tables.js"></script>
  <?php endif; ?>
  <?php if ($add_respond_js): ?>
    <!--[if lt IE 9]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
    <![endif]-->
  <?php endif; ?>
  <?php if ($add_html5_shim): ?>
    <!--[if lt IE 9]>
    <script src="<?php print $base_path . $path_to_aether; ?>/js/html5.js"></script>
    <![endif]-->
  <?php endif; ?>
  <?php if ($add_selectivizr_js): ?>
    <!--[if (gte IE 6)&(lte IE 8)]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
    <![endif]-->
  <?php endif; ?>
  <?php if ($add_imgsizer_js): ?>
    <!--[if lt IE 8]>
    <script src="<?php print $base_path . $path_to_aether; ?>/js/imgsizer.js"></script>
    <![endif]-->
  <?php endif; ?>
</head>
<body class="<?php print $classes; ?>">

<div id="page" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <header id="header" role="banner" class="clearfix">

      <div class="user-columns-wrapper clearfix">
        <div class="limiter">
          <div class="user-row g-all-row">
            <?php print $user_first; ?>
            <?php print $user_second; ?>
          </div> <!-- /.g-all-row -->
        </div> <!-- /.limiter -->
      </div> <!-- /.wrapper -->

    <div class="branding-wrapper clearfix">
      <div class="limiter">
        <div class="branding-row g-all-row">
          <?php if ($logo || $site_name || $site_slogan || $secondary_menu || $branding): ?>
            <?php print $branding; ?>
          <?php endif; ?>
        </div> <!-- /g-all-row -->
      </div> <!-- /limiter -->
    </div> <!-- /branding-wrapper -->

      <div class="header-columns-wrapper clearfix">
        <div class="limiter">
          <div class="header-row g-all-row">
            <?php print $header_first; ?>
            <?php print $header_second; ?>
            <?php print $header_third; ?>
          </div> <!-- /#header-columns -->
        </div> <!-- /.limiter -->
      </div> <!-- /.header-columns-wrapper -->

      <nav id="main-menu" class="main-menu menu">
        <div class="main-menu-wrapper clearfix">
          <div class="limiter">
            <div class="main-menu-row g-all-row">
              <?php if ($main_menu): ?>
                <?php print $main_menu; ?>
              <?php endif; ?>
            </div> <!-- /.limiter -->
          </div> <!-- /g-all-row -->
        </div> <!-- /.main-menu-wrapper -->
      </nav>

      <div class="navigation-columns-wrapper clearfix">
        <div class="limiter">
          <div class="navigation-row g-all-row">
              <?php print $navigation_first; ?>
              <?php print $navigation_second; ?>
          </div> <!-- /g-all-row -->
        </div> <!-- /limiter -->
      </div> <!-- /.navigation-columns-wrapper -->

  </header> <!-- /header -->

    <section id="feature" class="clearfix">
      <div class="feature-wrapper clearfix">
        <div class="limiter">
          <div class="feature-row g-all-row">
            <?php print $feature; ?>
          </div>
        </div>
      </div>
    </section>

  <section id="main">

      <div class="preface-wrapper clearfix">
        <div class="limiter">
          <div class="preface-row g-all-row">
            <?php print $preface_first; ?>
            <?php print $preface_second; ?>
            <?php print $preface_third; ?>
          </div> <!-- /#preface-columns -->
        </div>
      </div>

    <div class="content-wrapper clearfix">
      <div class="limiter">
        <div class="content-row g-all-row">
          <div id="content" <?php print $attributes; ?>>
            <div <?php print $content_attributes; ?>>
              <?php if ($breadcrumb || $title|| $messages || $tabs): ?>
              <div id="content-header">
                <?php print $breadcrumb; ?>
                <?php if ($highlight): ?>
                  <div id="highlight"><?php print $highlight ?></div>
                <?php endif; ?>
                <?php if ($title): ?>
                  <h1 class="title"><?php print $title; ?></h1>
                <?php endif; ?>
                <?php print $messages; ?>
                <?php if ($tabs): ?>
                  <div class="tabs"><?php print render($tabs); ?></div>
                <?php endif; ?>
              </div> <!-- /#content-header -->
              <?php endif; ?>
              <div id="content-area">
                <?php print $content; ?>
              </div>
              <?php print $feed_icons; ?>
            </div> <!-- /.content-inner -->
          </div> <!-- /content -->
          <?php print $sidebar_first; ?>
          <?php print $sidebar_second; ?>
        </div> <!-- /.g-all-row -->
      </div> <!-- /.limiter -->
    </div> <!-- /.content-wrapper -->

      <div class="postscript-wrapper clearfix">
        <div class="limiter">
          <div class="postscript-row g-all-row">
            <?php print $postscript_first; ?>
            <?php print $postscript_second; ?>
            <?php print $postscript_third; ?>
            <?php print $postscript_fourth; ?>
          </div> <!-- /#postscript-columns /.g-all-row -->
        </div> <!-- /.limiter -->
      </div> <!-- /.powerscript-wrapper -->

  </section> <!-- /main -->

  <div class="push"></div>
</div> <!-- /page -->

<footer id="footer">

    <div class="footer-columns-wrapper">
      <div class="limiter">
        <div class="footer-row g-all-row">
          <?php print $footer_first; ?>
          <?php print $footer_second; ?>
          <?php print $footer_third; ?>
          <?php print $footer_fourth; ?>
        </div> <!-- /#footer-columns /.g-all-row -->
      </div> <!-- /.limiter -->
    </div> <!-- /.footer-columns-wrapper -->

    <div class="footer-wrapper">
      <div class="limiter">
        <div class="footer-row g-all-row">
          <?php print $footer; ?>
        </div> <!-- /.g-all-row -->
      </div> <!-- /.limiter -->
    </div> <!-- /.footer-wrapper -->

</footer>
</body>
</html>
