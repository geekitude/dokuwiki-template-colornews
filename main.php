<?php
/**
 * DokuWiki ColorNews Template
 *
 * @link     http://dokuwiki.org/template:colornews
 * @author   Simon Delage <sdelage@gmail.com>
 * @license  GPL 3 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */
header('X-UA-Compatible: IE=edge,chrome=1');

global $colornews;
$colornews = array();
_colornews_init();
//dbg($colornews);

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang'] ?>"
  lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php //if (($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "include")) { include(tpl_incdir('colornews')."/debug/meta.html"); } else { tpl_includeFile('meta.html'); } ?>
    <?php _colornews_includeFile('meta.html') ?>
</head>
<body class="<?php echo _colornews_bodyclasses(); ?>">
    <div class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == "a11y")) ? "" : "a11y " ?>skip">
        <a href="#dokuwiki__content"><?php echo $lang['skip_to_content'] ?></a>
    </div>
    <?php _colornews_includeFile('header.html') ?>
    <?php /* with these Conditional Comments you can better address IE issues in CSS files,
             precede CSS rules by #IE8 for IE8 (div closes at the bottom) */ ?>
    <!--[if lte IE 8 ]><div id="IE8"><![endif]-->
    <?php /* the "dokuwiki__top" id is needed somewhere at the top, because that's where the "back to top" button/link links to */ ?>
    <?php /* tpl_classes() provides useful CSS classes; if you choose not to use it, the 'dokuwiki' class at least
             should always be in one of the surrounding elements (e.g. plugins and templates depend on it) */ ?>
    <div id="dokuwiki__site">
    <div id="page" class="hfeed site <?php echo tpl_classes(); ?> <?php echo (($colornews['show']['sidebar']) or ($colornews['show']['sidebarWidgets'])) ? 'hasSidebar' : ''; ?>">
        <!-- ********** HEADER ********** -->
        <header id="masthead" class="site-header" role="banner">
            <div class="top-header-wrapper clearfix">
                <div class="tg-container">
                    <div class="tg-inner-wrap">
                        <!-- options pour afficher ou non ce menu et choisir le contenu -->
                        <div class="category-toogle-wrap">
                            <div class="category-toggle-block">
                                <span class="toggle-bar"></span>
                                <span class="toggle-bar"></span>
                                <span class="toggle-bar"></span>
                            </div>
                        </div><!-- .category-toogle-wrap end -->
                        <div class="top-menu-wrap">
                            <div class="date-in-header">
                                <?php _colornews_date("long", null, false, true); ?>
                            </div>
                        </div>
                            <div id="dokuwiki__topbar" class="right-top-menu-wrap">
                                <?php //if ((($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "replace") or ($_GET['debug'] == "links")) and (file_exists(tpl_incdir('colornews')."debug/topbar.html"))) { include(tpl_incdir('colornews')."debug/topbar.html"); } else { tpl_include_page('topbar'); } ?>
                                <?php if (($_GET['debug'] == "replace") and (file_exists(tpl_incdir('colornews')."debug/topbar.html"))) { include(tpl_incdir('colornews')."debug/topbar.html"); } else { tpl_include_page('topbar'); } ?>
                            </div>
                    </div><!-- /.tg-inner-wrap -->
                </div><!-- /.tg-container -->
            </div><!-- /.top-header-wrapper  -->
            <div class="middle-header-wrapper clearfix">
                <div class="tg-container">
                    <div class="tg-inner-wrap">
                        <div class="logo">
                            <?php
                                $logoSize = array();
                                $logo = tpl_getMediaFile(array(':wiki:logo.png', ':logo.png', 'images/logo.png'), false, $logoSize);
                                //echo '<img src="'.$logo.'" '.$logoSize[3].' alt="" />';
                                // display logo as a link to the home page
                                tpl_link(
                                    wl(),
                                    '<img src="'.$logo.'" '.$logoSize[3].' alt="" />',
                                    'accesskey="h" title="'.tpl_getLang('wikihome').' [H]"'
                                );
                            ?>
                        </div><!-- #logo -->
                        <div id="header-text" class="">
                            <!-- <h1><?php //if ((($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "replace") or ($_GET['debug'] == "title")) and (file_exists(tpl_incdir('colornews')."debug/title.html"))) { include(tpl_incdir('colornews')."debug/title.html"); } else { tpl_link(wl(),$conf['title'],'accesskey="h" title="[H]"'); } ?></h1> -->
                            <h1>
                                <?php
                                    if (($_GET['debug'] == "replace") and (file_exists(tpl_incdir('colornews')."debug/title.html"))) {
                                        include(tpl_incdir('colornews')."debug/title.html");
                                    } else {
                                        tpl_link(wl(),$conf['title'],'accesskey="h" title="'.tpl_getLang('wikihome').' [H]"');
                                    }
                                ?>
                            </h1>
                            <?php /* how to insert logo instead (if no CSS image replacement technique is used):
                                upload your logo into the data/media folder (root of the media manager) and replace 'logo.png' accordingly:
                                tpl_link(wl(),'<img src="'.ml('logo.png').'" alt="'.$conf['title'].'" />','id="dokuwiki__top" accesskey="h" title="[H]"') */ ?>
                            <?php if ($conf['tagline']): ?>
                                <!-- <p class="claim"><?php //if ((($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "replace") or ($_GET['debug'] == "tagline")) and (file_exists(tpl_incdir('colornews')."debug/tagline.html"))) { include(tpl_incdir('colornews')."debug/tagline.html"); } else { echo $conf['tagline']; } ?></p> -->
                                <p class="claim">
                                    <?php
                                        if (($_GET['debug'] == "replace") and (file_exists(tpl_incdir('colornews')."debug/tagline.html"))) {
                                            include(tpl_incdir('colornews')."debug/tagline.html");
                                        } else {
                                            tpl_link(wl(),$conf['tagline'],'accesskey="h" title="'.tpl_getLang('wikihome').' [H]"');
                                        }
                                    ?>
                                </p>
                            <?php endif ?>
                        </div><!-- #header-text -->
                        <div class="header-advertise">
                            <?php _colornews_includeFile('bannerheader.html') ?>
                            <?php
                                //if ((($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "replace") or ($_GET['debug'] == "banner")) and (file_exists(tpl_incdir('colornews')."debug/banner.html"))) {
                                if (($_GET['debug'] == "replace") and (file_exists(tpl_incdir('colornews')."debug/banner.html"))) {
                                    include(tpl_incdir('colornews')."debug/banner.html");
                                } elseif ($colornews['images']['banner'] != null) {
                                    $link = null;
                                    $title = "Banner";
                                    if ($link != null) {
                                        if ($link['accesskey'] != null) {
                                            $link['label'] .= " [".strtoupper($link['accesskey'])."]";
                                            $accesskey = 'accesskey="'.$link['accesskey'].'" ';
                                        }
                                        tpl_link(
                                            $link['target'],
                                            '<img id="colormag__branding_banner_image" src="'.$colornews['images']['banner'].'" '.$accesskey.'title="'.$link['label'].'" alt="*'.$title.'*" '.$colornews['images']['bannersize'][3].' />'
                                        );
                                    } else {
                                        print '<img id="colormag__branding_banner_image" src="'.$colornews['images']['banner'].'" title="'.$title.'" alt="*'.$title.'*" '.$colornews['images']['bannersize'][3].' />';
                                    }
                                }
                            ?>
                            <?php _colornews_includeFile('bannerfooter.html') ?>
                        </div><!-- /.header-advertise -->
                    </div><!-- /.tg-inner-wrap -->
                </div><!-- /.tg-container -->
            </div><!-- /.middle-header-wrapper -->
            <?php _colornews_includeFile('brandingfooter.html') ?>
            <aside id="colornews__alerts">
                <!-- ALERTS -->
                <?php
                    html_msgarea();
                    // If in playground...
                    if (strpos($ID, 'playground') !== false) {
                        // ...and admin, show a link to managing page...
                        if ($INFO['isadmin']) {
                            msg(tpl_getLang('playground_admin'), 2);
                        // ...else, show a few hints on what it's for
                        } else {
                            msg(tpl_getLang('playground_user'), 0);
                        }
                    }
                ?>
            </aside>
            <?php _colornews_includeFile('navbarheader.html') ?>
            <div class="bottom-header-wrapper clearfix">
                <div class="bottom-arrow-wrap">
                    <div class="tg-container">
                        <div class="tg-inner-wrap">
                            <?php // option affichage icone home ?>
                                <div class="home-icon">
                                    <a title="*title*" href="<?php wl(); ?>"><i class="fa fa-home"></i>home</a>
                                </div><!-- /.home-icon -->
                            <?php // ?>
                            <nav id="site-navigation" class="main-navigation clearfix" role="navigation">
                                <div class="menu-toggle hide">*menu toggle*</div>
                                <?php //wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'nav', 'container' => false, ) ); ?>
                            </nav>
                            <div class="share-search-wrap autocomplete-<?php print tpl_getConf("searchAutoComplete") ? 'on' : 'off'; ?>">
                                <?php _colornews_searchform(true, tpl_getConf("searchAutoComplete")); ?>
                            </div>
                            <!-- RANDOM POST -->
                        </div><!-- /.tg-inner-wrap -->
                    </div><!-- /.tg-container -->
                </div><!-- /.bottom-arrow-wrap -->
            </div><!-- /.bottom-header-wrapper -->
            <?php _colornews_includeFile('navbarfooter.html') ?>
            <!-- BREADCRUMBS -->
            <div id="colornews__trace" class="<?php print (($conf['youarehere']) and ($conf['breadcrumbs'])) ? "split" : "" ?>">
                <?php if($conf['youarehere']){ ?>
                    <div class="youarehere"><?php tpl_youarehere() ?></div>
                <?php } ?>
                <?php if($conf['breadcrumbs']){ ?>
                    <div class="breadcrumbs"><?php tpl_breadcrumbs() ?></div>
                <?php } ?>
                <hr class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == "a11y")) ? "" : "a11y " ?>blue" />
            </div>
            <!-- BREAKING NEWS -->
        </header><!-- /#masthead -->
<div id="dokuwiki__header" style="background-color:linen;">
<div class="tools">
<!-- USER TOOLS -->
<?php if ($conf['useacl'] && $colornews['show']['tools']): ?>
<?php endif ?>
<!-- SITE TOOLS -->
<div id="dokuwiki__sitetools">
<h3 class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == "a11y")) ? "" : "a11y " ?>blue"><?php echo $lang['site_tools'] ?></h3>
<?php //tpl_searchform() ?>
<ul>
<?php tpl_toolsevent('sitetools', array(
'recent'    => tpl_action('recent', 1, 'li', 1),
'media'     => tpl_action('media', 1, 'li', 1),
'index'     => tpl_action('index', 1, 'li', 1),
)); ?>
</ul>
</div><!-- /.#dokuwiki__sitetools -->
</div><!-- /.tools -->
<hr class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == "a11y")) ? "" : "a11y " ?>blue" />
</div><!-- /#dokuwiki__header -->
        <main id="main" class="clearfix">
            <div class="tg-container">
                <div class="tg-inner-wrap clearfix">
                    <div id="main-content-section clearfix">
                        <div id="primary">
                            <!-- ********** CONTENT ********** -->
                            <section id="dokuwiki__content">
                                <?php tpl_flush() /* flush the output buffer */ ?>
                                <?php _colornews_includeFile('pageheader.html') ?>
                                <article class="page">
                                    <!-- wikipage start -->
                                    <?php tpl_content() /* the main content */ ?>
                                    <!-- wikipage stop -->
                                </article><!-- /.page -->
                                <?php tpl_flush() ?>
                                <?php _colornews_includeFile('pagefooter.html') ?>
                            </section><!-- /#dokuwiki__content -->
                            <hr class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == "a11y")) ? "" : "a11y " ?>blue" />
                            <!-- PAGE ACTIONS -->
                            <?php if ($colornews['show']['tools']): ?>
                                <aside id="dokuwiki__pagetools">
                                    <h3 class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == "a11y")) ? "" : "a11y " ?>blue"><?php echo $lang['page_tools'] ?></h3>
                                    <ul>
                                        <?php tpl_toolsevent('pagetools', array(
                                            'edit'      => tpl_action('edit', 1, 'li', 1),
                                            'discussion'=> _tpl_action('discussion', 1, 'li', 1),
                                            'revisions' => tpl_action('revisions', 1, 'li', 1),
                                            'backlink'  => tpl_action('backlink', 1, 'li', 1),
                                            'subscribe' => tpl_action('subscribe', 1, 'li', 1),
                                            'revert'    => tpl_action('revert', 1, 'li', 1),
                                            'top'       => tpl_action('top', 1, 'li', 1),
                                        )); ?>
                                    </ul>
                                </aside><!-- /#dokuwiki__pagetools -->
                            <?php endif; ?>
                        </div><!-- /#primary -->
                        <!-- ********** ASIDE ********** -->
                        <?php if ($colornews['show']['sidebar']): ?>
                            <div id="secondary">
                                <?php _colornews_includeFile('sidebarheader.html', true) ?>
                                <?php if (isset($colornews['images']['card'])) : ?>
                                    <!-- <aside id="colornews_300x250_advertisement_widget-3" class="widget widget_300x250_advertisement colornews_custom_widget"> -->
                                    <aside id="colornews__sidebar_card" class="widget colornews_custom_widget">
                                        <!-- <div class="magazine-block-medium-ad clearfix"> -->
                                            <div class="tg-block-wrapper">
                                                <div class="ad-image">
                                                    <!-- <a href="http://themegrill.com" target="_blank"><img src="https://demo.themegrill.com/colornews/wp-content/uploads/sites/37/2015/07/colornews-medium-advetise.jpg" width="300" height="250" rel="nofollow"></a> -->
                                                    <?php
                                                        echo '<img src="'.$colornews['images']['card'].'" '.$colornews['images']['cardsize'][3].' alt="" />';
                                                    ?>
                                                </div>
                                            </div>
                                        <!-- </div> -->
                                    </aside>
                                <?php endif; ?>
                                <?php
                                    if ($colornews['show']['sidebar'] > 0) {
                                        print '<aside id="dokuwiki__aside" class="widget">';
                                        if ($colornews['show']['sidebar'] === 2) {
                                            include(tpl_incdir('colornews')."debug/sidebar.html");
                                        } else {
                                            tpl_include_page($conf['sidebar'], 1, 1); /* includes the nearest sidebar page */
                                        }
                                        print '</aside>';
                                    }
                                ?>
                                <?php _colornews_widgets('sidebar'); ?>
                                <?php _colornews_includeFile('sidebarfooter.html', true) ?>
                            </div><!-- /#secondary -->
                        <?php endif; ?>
                    </div><!-- /#main-content-section -->
                </div><!-- /.tg-inner-wrap -->
            </div><!-- /.tg-container -->
        </main>
        <footer id="colophon">
            <div class="doc"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></div>
            <?php tpl_license(tpl_getConf('licenseVisual')) /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>
            <div id="top-footer">
                <div class="tg-container">
                    <div class="tg-inner-wrap">
                        <div class="top-footer-content-wrapper">
                            <div class="tg-column-wrapper">
                                <!-- USER TOOLS -->
                                <?php if ($ACT != "login") : ?>
                                    <div class="tg-footer-column-3 xl">
                                        <aside id="dokuwiki__usertools" class="widget">
                                            <?php
                                                //if (($conf['useacl']) and (empty($_SERVER['REMOTE_USER'])) and (strpos(tpl_getConf('widgets'), 'footer_login') !== false))
                                                if (($conf['useacl']) and (empty($_SERVER['REMOTE_USER']))) {
                                                    //<!-- LOGIN FORM -->
                                                    _colornews_loginform('widget');
                                                } else {
                                                    print '<h3 class="widget-title title-block-wrap clearfix"><span class="block-title"><span>'.$lang['user_tools'].'</span></span></h3>';
                                                    print '<p class="user">';
                                                        tpl_userinfo(); /* 'Logged in as ...' */
                                                    print '</p>';
                                                    print '<ul>';
                                                        /* the optional second parameter of tpl_action() switches between a link and a button,
                                                        e.g. a button inside a <li> would be: tpl_action('edit', 0, 'li') */
                                                        tpl_toolsevent('usertools', array(
                                                            'admin'     => tpl_action('admin', 1, 'li', 1),
                                                            'userpage'  => _tpl_action('userpage', 1, 'li', 1),
                                                            'profile'   => tpl_action('profile', 1, 'li', 1),
                                                            'register'  => tpl_action('register', 1, 'li', 1),
                                                            'login'     => tpl_action('login', 1, 'li', 1),
                                                        ));
                                                    print '</ul>';
                                                }
                                            ?>
                                        </aside><!-- /#dokuwiki__usertools -->
                                    </div><!-- /.tg-footer-column-3 -->
                                <?php endif; ?>
                                <div class="tg-footer-column-3">
                                    <aside id="colornews__about" class="widget widget_nav_menu">
                                        <h3 class="widget-title title-block-wrap clearfix"><span class="block-title"><span>About</span></span></h3>
                            <div class="buttons">
                                <a href="http://dokuwiki.org/" title="Driven by DokuWiki"<?php _colornews_external_target(); ?>><img src="<?php print tpl_basedir(); ?>images/button-dw.png" width="80" height="15" alt="Driven by DokuWiki" /></a>
                                <a href="http://www.dokuwiki.org/donate" title="Donate to DokuWiki"<?php _colornews_external_target(); ?>><img src="<?php print tpl_basedir(); ?>images/button-donate.png" width="80" height="15" alt="Donate to DokuWiki" /></a>
                                <a href="https://translate.dokuwiki.org/" title="Localized (you can help)"<?php _colornews_external_target(); ?>><img src="<?php print tpl_basedir(); ?>images/button-localized.png" width="80" height="15" alt="Localized" /></a>
                                <a href="http://php.net" title="Powered by PHP"<?php _colornews_external_target(); ?>><img src="<?php print tpl_basedir(); ?>images/button-php.png" width="80" height="15" alt="Powered by PHP" /></a>
                                <a href="http://validator.w3.org/check/referer" title="Check HTML5"<?php _colornews_external_target(); ?>><img src="<?php print tpl_basedir(); ?>images/button-html5.png" width="80" height="15" alt="Check HTML5" /></a>
                                <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3" title="Check CSS"<?php _colornews_external_target(); ?>><img src="<?php print tpl_basedir(); ?>images/button-css.png" width="80" height="15" alt="Check CSS" /></a>
                                <a href="https://github.com/geekitude/dokuwiki-template-spacious" title="Spacious template"<?php _colornews_external_target(); ?>><img src="<?php print tpl_basedir(); ?>images/button-spacious.png" width="80" height="15" alt="Spacious tmplate" /></a>
                            </div><!-- .buttons -->
                                    </aside><!-- /#nav_menu-2 -->
                                </div><!-- /.tg-footer-column-3 -->
                                <div class="tg-footer-column-3">
                                    <aside id="nav_menu-3" class="widget widget_nav_menu">
                                        <h3 class="widget-title title-block-wrap clearfix"><span class="block-title"><span>Other Themes</span></span></h3>
                                        <div class="menu-other-themes-container">
                                            <ul id="menu-other-themes" class="menu">
                                                <li id="menu-item-297" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-297"><a href="http://themegrill.com/themes/colormag">ColorMag</a></li>
                                                <li id="menu-item-298" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-298"><a href="http://themegrill.com/themes/accelerate/">Accelerate</a></li>
                                                <li id="menu-item-299" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-299"><a href="http://themegrill.com/themes/ample/">Ample</a></li>
                                                <li id="menu-item-300" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-300"><a href="http://themegrill.com/themes/esteem/">Esteem</a></li>
                                            </ul>
                                        </div><!-- /.menu-other-themes-container -->
                                    </aside><!-- /#nav_menu-3 -->
                                </div><!-- /.tg-footer-column-3 -->
                            </div><!-- /.tg-column-wrapper -->
                        </div><!-- /.top-footer-content-wrapper -->
                    </div><!-- /.tg-inner-wrap -->
                </div><!-- /.tg-container -->
            </div><!-- /#top-footer -->
            <div id="bottom-footer">
                <div class="tg-container">
                    <div class="tg-inner-wrap">
                        <div class="copy-right">
                            Copyright &copy; 2018 <a href="https://demo.themegrill.com/colornews/" title="ColorNews" ><span>ColorNews</span></a>.&nbsp;Theme: ColorNews by <a href="https://themegrill.com/themes/colornews" target="_blank" title="ThemeGrill" rel="author"><span>ThemeGrill</span></a>. Powered by <a href="http://wordpress.org" target="_blank" title="WordPress"><span>WordPress</span></a>.
                        </div><!-- /.copy-right -->
                    </div><!-- /.tg-inner-wrap -->
                </div><!-- /.tg-container -->
            </div><!-- /#bottom-footer -->
        </footer><!-- /#colophon -->
        <a href="#masthead" id="scroll-up"><span>TOP</span></a>
    </div><!-- /#page -->
    </div><!-- /#dokuwiki__site -->
    <?php _colornews_includeFile('footer.html') ?>
    <div id="housekeeper" class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    <!--[if lte IE 8 ]></div><![endif]-->
</body>
</html>
