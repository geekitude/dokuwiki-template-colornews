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

_colornews_init();

$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );

//if (($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "replace") or ($_GET['debug'] == "sidebar")) {
if ($_GET['debug'] == "replace") {
    $showSidebar = 2;
} else {
    $showSidebar = page_findnearest($conf['sidebar']) && ($ACT=='show');
}

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
    <?php /* with these Conditional Comments you can better address IE issues in CSS files,
             precede CSS rules by #IE8 for IE8 (div closes at the bottom) */ ?>
    <!--[if lte IE 8 ]><div id="IE8"><![endif]-->
    <?php /* the "dokuwiki__top" id is needed somewhere at the top, because that's where the "back to top" button/link links to */ ?>
    <?php /* tpl_classes() provides useful CSS classes; if you choose not to use it, the 'dokuwiki' class at least
             should always be in one of the surrounding elements (e.g. plugins and templates depend on it) */ ?>
    <div id="dokuwiki__site">
        <div id="dokuwiki__top" class="site <?php echo tpl_classes(); ?> <?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
            <ul class="<?php print (($_GET['debug'] != 1) and ($_GET['debug'] != "a11y")) ? "a11y " : "" ?>blue skip">
                <li><a href="#dokuwiki__content"><?php echo $lang['skip_to_content'] ?></a></li>
            </ul>
            <?php html_msgarea() /* occasional error and info messages on top of the page */ ?>
            <?php _colornews_includeFile('header.html') ?>
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
                                <div class="links-in-header">
                                    <?php //if ((($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "replace") or ($_GET['debug'] == "links")) and (file_exists(tpl_incdir('colornews')."debug/topbar.html"))) { include(tpl_incdir('colornews')."debug/topbar.html"); } else { tpl_include_page('topbar'); } ?>
                                    <?php if (($_GET['debug'] == "replace") and (file_exists(tpl_incdir('colornews')."debug/topbar.html"))) { include(tpl_incdir('colornews')."debug/topbar.html"); } else { tpl_include_page('topbar'); } ?>
                                </div>
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
                                    echo '<img src="'.$logo.'" '.$logoSize[3].' alt="" />';
                                ?>
                            </div><!-- #logo -->
                            <div id="header-text" class="">
                                <!-- <h1><?php //if ((($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "replace") or ($_GET['debug'] == "title")) and (file_exists(tpl_incdir('colornews')."debug/title.html"))) { include(tpl_incdir('colornews')."debug/title.html"); } else { tpl_link(wl(),$conf['title'],'accesskey="h" title="[H]"'); } ?></h1> -->
                                <h1><?php if (($_GET['debug'] == "replace") and (file_exists(tpl_incdir('colornews')."debug/title.html"))) { include(tpl_incdir('colornews')."debug/title.html"); } else { tpl_link(wl(),$conf['title'],'accesskey="h" title="[H]"'); } ?></h1>
                                <?php /* how to insert logo instead (if no CSS image replacement technique is used):
                                    upload your logo into the data/media folder (root of the media manager) and replace 'logo.png' accordingly:
                                    tpl_link(wl(),'<img src="'.ml('logo.png').'" alt="'.$conf['title'].'" />','id="dokuwiki__top" accesskey="h" title="[H]"') */ ?>
                                <?php if ($conf['tagline']): ?>
                                    <!-- <p class="claim"><?php //if ((($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "replace") or ($_GET['debug'] == "tagline")) and (file_exists(tpl_incdir('colornews')."debug/tagline.html"))) { include(tpl_incdir('colornews')."debug/tagline.html"); } else { echo $conf['tagline']; } ?></p> -->
                                    <p class="claim"><?php if (($_GET['debug'] == "replace") and (file_exists(tpl_incdir('colornews')."debug/tagline.html"))) { include(tpl_incdir('colornews')."debug/tagline.html"); } else { echo $conf['tagline']; } ?></p>
                                <?php endif ?>
                            </div><!-- #header-text -->
                            <div class="header-advertise">
                                <?php _colornews_includeFile('bannerheader.html') ?>
                                <?php
                                    //if ((($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "replace") or ($_GET['debug'] == "banner")) and (file_exists(tpl_incdir('colornews')."debug/banner.html"))) {
                                    if (($_GET['debug'] == "replace") and (file_exists(tpl_incdir('colornews')."debug/banner.html"))) {
                                        include(tpl_incdir('colornews')."debug/banner.html");
                                    } elseif (($colornews['images']['banner'] != null) or ($_GET['debug'] == 1) or ($_GET['debug'] == "banner")) {
                                        if ($colormag['images']['banner']['mediaId'] != null) {
                                            $bannerImage = ml($colornews['images']['banner']['mediaId'],'',true);
                                        } else {
                                            $bannerImage = "/lib/tpl/colornews/debug/banner.png";
                                        }
                                        //$link = colormag_ui_link("bannerLink", substr($colormag['images']['banner']['mediaId'], 0, strrpos($colormag['images']['banner']['mediaId'], ':') + 1));
                                        $link = null;
                                        $title = "Banner";
                                        if ($link != null) {
                                            if ($link['accesskey'] != null) {
                                                $link['label'] .= " [".strtoupper($link['accesskey'])."]";
                                                $accesskey = 'accesskey="'.$link['accesskey'].'" ';
                                            }
                                            tpl_link(
                                                $link['target'],
                                                '<img id="colormag__branding_banner_image" src="'.$bannerImage.'" '.$accesskey.'title="'.$link['label'].'" alt="*'.$title.'*" '.$colormag['images']['banner']['imageSize'][3].' />'
                                            );
                                        } else {
                                            print '<img id="colormag__branding_banner_image" src="'.$bannerImage.'" title="'.$title.'" alt="*'.$title.'*" width="600" height="90" />';
                                        }
                                    }
                                ?>
                                <?php _colornews_includeFile('bannerfooter.html') ?>
                            </div><!-- /.header-advertise -->
                        </div><!-- /.tg-inner-wrap -->
                    </div><!-- /.tg-container -->
                </div><!-- /.middle-header-wrapper -->
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
                                <!-- SEARCH -->
                                <!-- RANDOM POST -->
                            </div><!-- /.tg-inner-wrap -->
                        </div><!-- /.tg-container -->
                    </div><!-- /.bottom-arrow-wrap -->
                </div><!-- /.bottom-header-wrapper -->
                <!-- BREAKING NEWS -->
            </header><!-- /#masthead -->











            <div id="dokuwiki__header" style="background-color:linen;">
                <div class="pad">
                    <div class="tools">
                        <!-- USER TOOLS -->
                        <?php if ($conf['useacl'] && $showTools): ?>
                            <div id="dokuwiki__usertools">
                                <h3 class="<?php print (($_GET['debug'] != 1) and ($_GET['debug'] != "a11y")) ? "a11y " : "" ?>blue"><?php echo $lang['user_tools'] ?></h3>
                                <ul>
                                    <?php
                                        if (!empty($_SERVER['REMOTE_USER'])) {
                                            echo '<li class="user">';
                                            tpl_userinfo(); /* 'Logged in as ...' */
                                            echo '</li>';
                                        }
                                    ?>
                                    <?php /* the optional second parameter of tpl_action() switches between a link and a button,
                                        e.g. a button inside a <li> would be: tpl_action('edit', 0, 'li') */ ?>
                                    <?php tpl_toolsevent('usertools', array(
                                        'admin'     => tpl_action('admin', 1, 'li', 1),
                                        'userpage'  => _tpl_action('userpage', 1, 'li', 1),
                                        'profile'   => tpl_action('profile', 1, 'li', 1),
                                        'register'  => tpl_action('register', 1, 'li', 1),
                                        'login'     => tpl_action('login', 1, 'li', 1),
                                    )); ?>
                                </ul>
                            </div><!-- /#dokuwiki__usertools -->
                        <?php endif ?>
                        <!-- SITE TOOLS -->
                        <div id="dokuwiki__sitetools">
                            <h3 class="<?php print (($_GET['debug'] != 1) and ($_GET['debug'] != "a11y")) ? "a11y " : "" ?>blue"><?php echo $lang['site_tools'] ?></h3>
                            <?php tpl_searchform() ?>
                            <ul>
                                <?php tpl_toolsevent('sitetools', array(
                                    'recent'    => tpl_action('recent', 1, 'li', 1),
                                    'media'     => tpl_action('media', 1, 'li', 1),
                                    'index'     => tpl_action('index', 1, 'li', 1),
                                )); ?>
                            </ul>
                        </div><!-- /.#dokuwiki__sitetools -->
                    </div><!-- /.tools -->
                    <div class="clearer"></div>
                    <!-- BREADCRUMBS -->
                    <?php if($conf['breadcrumbs']){ ?>
                        <div class="breadcrumbs"><?php tpl_breadcrumbs() ?></div>
                    <?php } ?>
                    <?php if($conf['youarehere']){ ?>
                        <div class="breadcrumbs"><?php tpl_youarehere() ?></div>
                    <?php } ?>
                    <div class="clearer"></div>
                    <hr class="<?php print (($_GET['debug'] != 1) and ($_GET['debug'] != "a11y")) ? "a11y " : "" ?>blue" />
                </div><!-- /.pad -->
            </div><!-- /#dokuwiki__header -->









            <main id="main" class="clearfix">
                <div class="tg-container">
                    <div class="tg-inner-wrap clearfix">
                        <div id="main-content-section clearfix">
                            <div id="primary">
                                <div class="wrapper">
                                    <!-- ********** CONTENT ********** -->
                                    <section id="dokuwiki__content">
                                        <div class="pad">
                                            <?php tpl_flush() /* flush the output buffer */ ?>
                                            <?php _colornews_includeFile('pageheader.html') ?>
                                            <article class="page">
                                                <!-- wikipage start -->
                                                <?php tpl_content() /* the main content */ ?>
                                                <!-- wikipage stop -->
                                                <div class="clearer"></div>
                                            </article><!-- /.page -->
                                            <?php tpl_flush() ?>
                                            <?php _colornews_includeFile('pagefooter.html') ?>
                                        </div><!-- /.pad -->
                                    </section><!-- /#dokuwiki__content -->
                                    <div class="clearer"></div>
                                    <hr class="<?php print (($_GET['debug'] != 1) and ($_GET['debug'] != "a11y")) ? "a11y " : "" ?>blue" />
                                    <!-- PAGE ACTIONS -->
                                    <?php if ($showTools): ?>
                                        <aside id="dokuwiki__pagetools">
                                            <h3 class="<?php print (($_GET['debug'] != 1) and ($_GET['debug'] != "a11y")) ? "a11y " : "" ?>blue"><?php echo $lang['page_tools'] ?></h3>
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
                                </div><!-- /.wrapper -->
                            </div><!-- /#primary -->
                            <!-- ********** ASIDE ********** -->
                            <?php if ($showSidebar): ?>
                                <div id="secondary">
                                    <div class="pad aside include group">
                                        <aside id="dokuwiki__aside">
                                            <?php _colornews_includeFile('sidebarheader.html') ?>
                                            <?php if ($showSidebar === 2) { include(tpl_incdir('colornews')."debug/sidebar.html"); } else { tpl_include_page($conf['sidebar'], 1, 1); /* includes the nearest sidebar page */ } ?>
                                            <?php _colornews_includeFile('sidebarfooter.html') ?>
                                            <div class="clearer"></div>
                                        </aside><!-- /#dokuwiki__aside -->
                                        <aside id="colornews_popular_posts_widget-2" class="widget colornews_popular_post colornews_custom_widget">
                                            <div class="magazine-block-3">
                                                <div class="tg-block-wrapper clearfix">
                                                    <h3 class="widget-title title-block-wrap clearfix"><span class="block-title"><span>Trending</span></span></h3>
                                                </div>
                                            </div>
                                        </aside>
                                        <aside id="colornews_300x250_advertisement_widget-3" class="widget widget_300x250_advertisement colornews_custom_widget">
                                            <div class="magazine-block-medium-ad clearfix">
                                                <div class="tg-block-wrapper">
                                                    <div class="ad-image">
                                                        <a href="http://themegrill.com" target="_blank"><img src="https://demo.themegrill.com/colornews/wp-content/uploads/sites/37/2015/07/colornews-medium-advetise.jpg" width="300" height="250" rel="nofollow"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </aside>
                                        <aside id="colornews_popular_posts_widget-2" class="widget colornews_popular_post colornews_custom_widget">
                                            <div class="magazine-block-3">
                                                <div class="tg-block-wrapper clearfix">
                                                    <h3 class="widget-title title-block-wrap clearfix"><span class="block-title"><span>Blah?</span></span></h3>
                                                </div>
                                            </div>
                                        </aside>
                                    </div><!-- /.pad -->
                                </div><!-- /#secondary -->
                            <?php endif; ?>
                        </div><!-- #main-content-section end -->
                    </div><!-- /.tg-inner-wrap -->
                </div><!-- /.tg-container -->
            </main>







            <!-- ********** FOOTER ********** -->
            <footer id="dokuwiki__footer">
                <div class="pad">
                    <div class="doc"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></div>
                    <?php tpl_license('button') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>
                </div><!-- /.pad -->
            </footer><!-- /#dokuwiki__footer -->
            <?php _colornews_includeFile('footer.html') ?>
        </div><!-- /#dokuwiki__top -->
    </div><!-- /dokuwiki__site -->
    <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    <!--[if lte IE 8 ]></div><![endif]-->
</body>
</html>
