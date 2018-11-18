<?php
/**
 * Template Functions
 *
 * This file provides template specific custom functions that are
 * not provided by the DokuWiki core.
 * It is common practice to start each function with an underscore
 * to make sure it won't interfere with future core functions.
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

/**
 * Create link/button to discussion page and back
 *
 * @author Anika Henke <anika@selfthinker.org>
 */
function _tpl_discussion($discussionPage, $title, $backTitle, $link=0, $wrapper=0, $return=0) {
    global $ID;
    $output = '';

    $discussPage    = str_replace('@ID@', $ID, $discussionPage);
    $discussPageRaw = str_replace('@ID@', '', $discussionPage);
    $isDiscussPage  = strpos($ID, $discussPageRaw) !== false;
    $backID         = ':'.str_replace($discussPageRaw, '', $ID);

    if ($wrapper) $output .= "<$wrapper>";

    if ($isDiscussPage) {
        if ($link) {
            ob_start();
            tpl_pagelink($backID, $backTitle);
            $output .= ob_get_contents();
            ob_end_clean();
        } else {
            $output .= html_btn('back2article', $backID, '', array(), 'get', 0, $backTitle);
        }
    } else {
        if ($link) {
            ob_start();
            tpl_pagelink($discussPage, $title);
            $output .= ob_get_contents();
            ob_end_clean();
        } else {
            $output .= html_btn('discussion', $discussPage, '', array(), 'get', 0, $title);
        }
    }

    if ($wrapper) $output .= "</$wrapper>";
    if ($return) return $output;
    echo $output;
}

/**
 * Create link/button to user page
 *
 * @author Anika Henke <anika@selfthinker.org>
 */
function _tpl_userpage($userPage, $title, $link=0, $wrapper=0, $return=0) {
    if (empty($_SERVER['REMOTE_USER'])) return;

    global $conf;
    $output = '';
    $userPage = str_replace('@USER@', $_SERVER['REMOTE_USER'], $userPage);

    if ($wrapper) $output .= "<$wrapper>";

    if ($link) {
        ob_start();
        tpl_pagelink($userPage, $title);
        $output .= ob_get_contents();
        ob_end_clean();
    } else {
        $output .= html_btn('userpage', $userPage, '', array(), 'get', 0, $title);
    }

    if ($wrapper) $output .= "</$wrapper>";
    if ($return) return $output;
    echo $output;
}

/**
 * Wrapper around custom template actions
 *
 * @author Anika Henke <anika@selfthinker.org>
 */
function _tpl_action($type, $link=0, $wrapper=0, $return=0) {
    switch ($type) {
        case 'discussion':
            if (tpl_getConf('discussionPage')) {
                $output = _tpl_discussion(tpl_getConf('discussionPage'), tpl_getLang('discussion'), tpl_getLang('back_to_article'), $link, $wrapper, 1);
                if ($return) return $output;
                echo $output;
            }
            break;
        case 'userpage':
            if (tpl_getConf('userPage')) {
                $output = _tpl_userpage(tpl_getConf('userPage'), tpl_getLang('userpage'), $link, $wrapper, 1);
                if ($return) return $output;
                echo $output;
            }
            break;
    }
}

/**
 * copied to core (available since Detritus)
 */
if (!function_exists('tpl_toolsevent')) {
    function tpl_toolsevent($toolsname, $items, $view='main') {
        $data = array(
            'view'  => $view,
            'items' => $items
        );

        $hook = 'TEMPLATE_'.strtoupper($toolsname).'_DISPLAY';
        $evt = new Doku_Event($hook, $data);
        if($evt->advise_before()){
            foreach($evt->data['items'] as $k => $html) echo $html;
        }
        $evt->advise_after();
    }
}

/**
 * copied from core (available since Binky)
 */
if (!function_exists('tpl_classes')) {
    function tpl_classes() {
        global $ACT, $conf, $ID, $INFO;
        $classes = array(
            'dokuwiki',
            'mode_'.$ACT,
            'tpl_'.$conf['template'],
            !empty($_SERVER['REMOTE_USER']) ? 'loggedIn' : '',
            $INFO['exists'] ? '' : 'notFound',
            ($ID == $conf['start']) ? 'home' : '',
        );
        return join(' ', $classes);
    }
}

/**
 * COLORNEWS TEMPLATE FUNCTIONS
 *
 * @author Simon Delage <sdelage@gmail.com>
 */

/**
 * INITALIZE
 * 
 * Load usefull informations and plugins' helpers.
 */
function _colornews_init() {
//    global $conf, $ID, $INFO, $JSINFO, $lang;
    global $conf, $ACT;
//dbg($INFO);
    // New global variables initialized in colornews' `main.php`
//    global $colornews, $editorAvatar, $userAvatar, $browserlang, $trs, $uhp;
    global $colornews;
    // More new global variables
//    global $translationHelper, $tags;

    $colornews['show'] = array();
    $colornews['show']['tools'] = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );
    $colornews['widgets'] = array();
    $colornews['widgets']['sidebar'] = array();
    if ($_GET['debug'] == "replace") {
        $colornews['show']['sidebar'] = 2;
        $colornews['show']['sidebarWidgets'] = 2;
        $colornews['widgets']['sidebar'] = @file(tpl_incdir('colornews')."debug/sidebarwidgets.txt");
    } else {
        $colornews['show']['sidebar'] = page_findnearest($conf['sidebar']) && ($ACT=='show');
        $colornews['show']['sidebarWidgets'] = page_findnearest(tpl_getConf('sidebarWidgets')) && ($ACT=='show');
        $colornews['widgets']['sidebar'] = @file(wikiFN(page_findnearest(tpl_getConf('sidebarWidgets')),''));
    }
//dbg($colornews['widgets']['sidebar']);
//dbg($colornews['show']['sidebar']);

    // IMAGES
    $colornews['images'] = array();
    if ((tpl_getConf('banner') != null) or ($_GET['debug'] == 1) or ($_GET['debug'] == "images") or ($_GET['debug'] == "banner")) {
        $colornews['images']['bannersize'] = array();
        $colornews['images']['banner'] = tpl_getMediaFile(array(':wiki:'.tpl_getConf('banner').'.png', ':'.tpl_getConf('banner').'.png', 'debug/banner.png'), false, $colornews['images']['bannersize']);
        if ((strpos($colornews['images']['banner'], "debug") !== false) and (($_GET['debug'] != 1) and ($_GET['debug'] != "images") and ($_GET['debug'] != "banner"))) {
            $colornews['images']['banner'] = null;
        }
    }
    if ((tpl_getConf('sidebarCard') != null) or ($_GET['debug'] == 1) or ($_GET['debug'] == "images") or ($_GET['debug'] == "banner")) {
        $colornews['images']['cardsize'] = array();
        $colornews['images']['card'] = tpl_getMediaFile(array(':wiki:'.tpl_getConf('sidebarCard').'.png', ':'.tpl_getConf('sidebarCard').'.png', 'debug/sidebar.png'), false, $colornews['images']['cardsize']);
        if ((strpos($colornews['images']['card'], "debug") !== false) and (($_GET['debug'] != 1) and ($_GET['debug'] != "images") and ($_GET['debug'] != "card"))) {
            $colornews['images']['card'] = null;
        }
    }
//dbg($_SERVER['REMOTE_USER']);
//dbg(':user:'.$_SERVER['REMOTE_USER'].':'.tpl_getConf('avatar').'.png');
//dbg(':wiki:'.$_SERVER['REMOTE_USER'].'.png');
    if ((isset($_SERVER['REMOTE_USER'])) and (tpl_getConf('avatar') != null)) {
        $colornews['images']['avatarsize'] = array();
        //$colornews['images']['avatar'] = tpl_getMediaFile(array(':wiki:'.tpl_getConf('avatar').'.png', ':'.tpl_getConf('avatar').'.png', 'debug/sidebar.png'), false, $colornews['images']['avatarsize']);
        $colornews['images']['avatar'] = tpl_getMediaFile(array(':user:'.$_SERVER['REMOTE_USER'].':'.tpl_getConf('avatar').'.png', ':wiki:'.$_SERVER['REMOTE_USER'].'.png', 'debug/avatar.svg'), false, $colornews['images']['avatarsize']);
    //} elseif (((isset($_SERVER['REMOTE_USER'])) and (tpl_getConf('avatar') != null)) or ($_GET['debug'] == 1) or ($_GET['debug'] == "images") or ($_GET['debug'] == "avatar")) {
        if ((strpos($colornews['images']['avatar'], "debug") !== false) and (($_GET['debug'] != 1) and ($_GET['debug'] != "images") and ($_GET['debug'] != "avatar"))) {
            $colornews['images']['avatar'] = null;
        }
    }
//dbg($colornews['images']['avatar']);
//dbg($colornews['images']['avatarsize']);
//dbg($colornews['images']);

    // GLYPHS
    // Search for default or custum default SVG glyphs
    $colornews['glyphs']['about'] = 'help';
    $colornews['glyphs']['acl'] = 'key-variant';
    $colornews['glyphs']['admin'] = 'settings';
    $colornews['glyphs']['config'] = 'tune';
    $colornews['glyphs']['discussion'] = 'comment-text-multiple';
    $colornews['glyphs']['extensions'] = 'puzzle';
    $colornews['glyphs']['from-playground'] = 'shovel-off';
    $colornews['glyphs']['help'] = 'lifebuoy';
    $colornews['glyphs']['home'] = 'home';
    $colornews['glyphs']['menu'] = 'menu';
    $colornews['glyphs']['namespace-start'] = 'reply';
    $colornews['glyphs']['parent-namespace'] = 'reply-all';
    $colornews['glyphs']['playground'] = 'shovel';
    $colornews['glyphs']['popularity'] = 'star-half';
    $colornews['glyphs']['private-page'] = 'incognito';
    $colornews['glyphs']['public-page'] = 'comment-account';
    $colornews['glyphs']['recycle'] = 'recycle';
    $colornews['glyphs']['refresh'] = 'autorenew';
    $colornews['glyphs']['revert'] = 'step-backward';
    $colornews['glyphs']['search'] = 'magnify';
    $colornews['glyphs']['styling'] = 'palette';
    $colornews['glyphs']['translation'] = 'translate';
    $colornews['glyphs']['upgrade'] = 'cloud-download';
    $colornews['glyphs']['user'] = 'account';
    $colornews['glyphs']['unknown-user'] = 'account-alert';
    $colornews['glyphs']['usermanager'] = 'account-group';
    foreach ($colornews['glyphs'] as $key => $value) {
        /*if (is_file(DOKU_CONF."svg/".$key.".svg")) {*/
        if (is_file(tpl_incdir().'images/svg/custom/'.$key.'.svg')) {
            $colornews['glyphs'][$key] = inlineSVG(tpl_incdir().'images/svg/custom/'.$key.'.svg', 2048);
        } elseif (is_file('.'.tpl_basedir().'images/svg/'.$value.'.svg')) {
            $colornews['glyphs'][$key] = inlineSVG('.'.tpl_basedir().'images/svg/'.$value.'.svg', 2048);
        } else {
            $colornews['glyphs'][$key] = inlineSVG(DOKU_INC.'lib/images/menu/00-default_checkbox-blank-circle-outline.svg', 2048);
        }
    }

    // DEBUG
    // Adding test alerts if debug is enabled
    if (($_GET['debug'] == 1) or ($_GET['debug'] == "alerts")) {
        msg("This is an error [-1] alert with a <a href='#'>dummy link</a>", -1);
        msg("This is an info [0] message with a <a href='#'>dummy link</a>", 0);
        msg("This is a success [1] message with a <a href='#'>dummy link</a>", 1);
        msg("This is a notification [2] with a <a href='#'>dummy link</a>", 2);
    }

    // Github issues
    // Check and store template's current Github issues number
    if (tpl_getConf('githubIssues') == 1) {
        $url = "http://api.github.com/users/geekitude/repos";//github.com/geekitude/dokuwiki-template-colornews
        $headers = @get_headers($url);
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: PHP'
                ]
            ]
        ];
        if ($headers and $headers[0] != 'HTTP/1.1 404 Not Found') {
            $json = file_get_contents($url, false, stream_context_create($opts));
//dbg($json);
            $obj = json_decode($json);
            if (is_array($obj)) {
                foreach ($obj as $key => $repo) {
//dbg($obj[$key]->name);
                    if ($obj[$key]->name == "dokuwiki-template-colornews") {
                        if ((isset($obj[$key]->open_issues_count)) and ($obj[$key]->open_issues_count > 0)) {
                            $colornews['issues'] = $obj[$key]->open_issues_count;
//dbg($obj[$key]->open_issues_count);
                        } else {
                            $colornews['issues'] = 0;
                        }
                    }
                }
            }
        }
    } else {
        $colornews['issues'] = null;
    }
}

/**
 * Returns body classes according to settings
 */
function _colornews_bodyclasses() {
    global $conf, $ACT;
    //$pattern = tpl_getMediaFile(array(':wiki:logo.png', ':logo.png', 'images/logo.png'), false, $logoSize);
    if (tpl_getConf('bodyBg') == "pattern") {
        $pattern = tpl_getMediaFile(array(':wiki:pattern.png', 'images/pattern.png'), false, $patternSize);
        if ($pattern == "/lib/tpl/colornews/images/pattern.png") {
            $bgClass = "tpl-pattern-bg";
        } else {
            $bgClass = "wiki-pattern-bg";
        }
    } else {
        $bgClass = "color-bg";
    }
    if (tpl_getConf('textWrap')) {
        $textWrap = "wrap";
    } else {
        $textWrap = "";
    }
    if ($ACT=='show') {
        $sidebar = tpl_getConf('sidebarPos').'-sidebar';
    } else {
        $sidebar = 'no-sidebar';
    }
    $classes = array(
        tpl_getConf('layout').'-layout',
        $bgClass,
        $textWrap,
        $sidebar,
    );
    /* TODO: better home detection than core */
    return join(' ', $classes);
}

function _colornews_includeFile($file = '', $widget = false) {
    if ($file != null) {
        if ((($_GET['debug'] == 1) or ($_GET['debug'] == "include")) and (file_exists(tpl_incdir('colornews')."debug/".$file))) {
            if ($widget == true) { print '<aside id="colornews_'.explode(".", $file)[0].'_widget" class="widget"><div class="tg-block-wrapper clearfix">'; }
            include(tpl_incdir('colornews')."debug/".$file);
            if ($widget == true) { print '</div></aside>'; }
        } elseif (file_exists(tpl_incdir().$file)) {
            if ($widget == true) { print '<aside id="colornews_'.explode(".", $file)[0].'_widget" class="widget"><div class="tg-block-wrapper clearfix">'; }
            tpl_includeFile($file);
            if ($widget == true) { print '</div></aside>'; }
        }
    }
}

/**
 * RETURN A DATE
 * 
 * @param string    $type "long" for long date based on 'dateString' setting, "short" for numeric
 * @param integer   $timestamp timestamp to use (null for current server time)
 * @param bool      $clock if true, add hour to the result
 * @param bool      $print if true, print the result instead of returning it
 */
function _colornews_date($type, $timestamp = null, $clock = false, $printResult = false) {
    global $conf;
    $dateLocale = tpl_getConf('dateLocale');
    if ($dateLocale != null) {
        if (strpos($dateLocale, ',') !== false) {
            $dateLocale = explode(",", $dateLocale)[1];
        }
        setlocale(LC_TIME, $dateLocale);
    }
    if ($type == "short") {
        $format = tpl_getConf('shortDateString');
    } else {
        $format = tpl_getConf('longDateString');
    }
    if ($clock) {
        $format .= ' %H:%M';
    }
    if ($timestamp == null) {
        $result = utf8_encode(ucwords(strftime($format)));
    } else {
        $result = utf8_encode(ucwords(strftime($format, $timestamp)));
    }
    if ($printResult) {
        print $result;
        return true;
    } else {
        return $result;
    }
}

/**
  * Print the search form
  *
  * If the first parameter is given a div with the ID 'qsearch_out' will
  * be added which instructs the ajax pagequicksearch to kick in and place
  * its output into this div. The second parameter controls the propritary
  * attribute autocomplete. If set to false this attribute will be set with an
  * value of "off" to instruct the browser to disable it's own built in
  * autocompletion feature (MSIE and Firefox)
  *
  * @author Andreas Gohr <andi@splitbrain.org>
  *
  * @param bool $ajax
  * @param bool $autocomplete
  * @return bool
  */
function _colornews_searchform($ajax = true, $autocomplete = true) {
    global $lang;
    global $ACT;
    global $QUERY;
    global $ID;

    $qsearchinClasses = 'edit';
    if (is_file(tpl_incdir().'images/svg/custom/search.svg')) {
        $qsearchinClasses .= ' custom';
    }
    // don't print the search form if search action has been disabled
    if(!actionOK('search')) return false;
    $searchForm = new dokuwiki\Form\Form([
        'action' => wl(),
        'method' => 'get',
        'role' => 'search',
        'class' => 'search',
        'id' => 'dw__search',
    ], true);
    $searchForm->addTagOpen('div')->addClass('no');
    $searchForm->setHiddenField('do', 'search');
    $searchForm->setHiddenField('id', $ID);
    $searchForm->addTextInput('q')
        ->addClass($qsearchinClasses)
        ->attrs([
            //'title' => '[F]',
            //'accesskey' => 'f',
            'placeholder' => $lang['btn_search'],
            'autocomplete' => $autocomplete ? 'on' : 'off',
        ])
        ->id('qsearch__in')
        ->val($ACT === 'search' ? $QUERY : '')
        ->useInput(false)
    ;
    if ($ajax) {
        $searchForm->addTagOpen('div')->id('qsearch__out')->addClass('ajax_qsearch JSpopup');
        $searchForm->addTagClose('div');
    }
    $searchForm->addTagClose('div');
    trigger_event('FORM_QUICKSEARCH_OUTPUT', $searchForm);
    echo $searchForm->toHTML();
    return true;
}

function _colornews_widgets($context) {
    global $colornews;
    //if ($colornews['show']['sidebarWidgets'] > 0) {
        //if (count($colornews['widgets']['sidebar']) > 0) {
        //if ($colornews['widgets'][$context]) {
        if (count($colornews['widgets'][$context]) > 0) {
            foreach ($colornews['widgets'][$context] as $key => $line) {
                $widget = explode('&&', $line);
//dbg($widget);
                print "<aside id='colornews_".$context."_widget_".$key."' class='widget'>";
                        print "<div class='tg-block-wrapper clearfix'>";
                            print "<h3 class='widget-title title-block-wrap clearfix'><span class='block-title'><span>".$widget[0]."</span></span></h3>";
                            print p_render('xhtml',p_get_instructions($widget[1]), $info);
                        print "</div>";
                print "</aside>";
            }
        }
    //}
}


/**
 * The loginform
 * adapted from html_login() because colornews doesn't need autofocus on username input
 *
 * See original function in inc/html.php for details
 */
function _colornews_loginform($context = "null") {
    global $lang;
    global $conf;
    global $ID;
    global $INPUT;

    if ($context == "widget") {
        $tmp = explode("</h1>", p_locale_xhtml('login'));
        $title = explode(">", $tmp[0])[1];
        $tmp = str_replace("! ", "!<br />", $tmp[1]);
        $tmp = str_replace(". ", ".<br />", $tmp);
        print '<h3 class="widget-title title-block-wrap clearfix"><span class="block-title"><span>';
            print $title;
        print '</span></span></h3>';
        print $tmp;
    } else {
        print p_locale_xhtml('login');
    }
    print '<div>'.NL;
    if ($context == "widget") {
        $form = new Doku_Form(array('id' => 'colornews__login'));
    } else {
        $form = new Doku_Form(array('id' => 'dw__login'));
    }
    $form->startFieldset($lang['btn_login']);
    $form->addHidden('id', $ID);
    $form->addHidden('do', 'login');
    $form->addElement(form_makeTextField('u', ((!$INPUT->bool('http_credentials')) ? $INPUT->str('u') : ''), $lang['user'], 'username', 'block'));
    $form->addElement(form_makePasswordField('p', $lang['pass'], '', 'block'));
    if($conf['rememberme']) {
        $form->addElement(form_makeCheckboxField('r', '1', $lang['remember'], 'remember__me', 'simple'));
    }
    $form->addElement(form_makeButton('submit', '', $lang['btn_login']));
    $form->endFieldset();

    if(actionOK('register')){
        $form->addElement('<p>'.$lang['reghere'].': '.tpl_actionlink('register','','','',true).'</p>');
    }

    if (actionOK('resendpwd')) {
        $form->addElement('<p>'.$lang['pwdforget'].': '.tpl_actionlink('resendpwd','','','',true).'</p>');
    }

    html_form('login', $form);
    print '</div>'.NL;
}

function _colornews_external_target($ret = false) {
    global $conf;
    $output = null;

    if ($conf['target']['extern'] != null) {
        $output = " target='".$conf['target']['extern']."'";
    }

    if ($ret) {
        return $output;
    } else {
        print $output;
        return true;
    }
}
