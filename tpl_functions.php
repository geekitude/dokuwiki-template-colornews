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
//dbg($INFO);
    // New global variables initialized in Spacious' `main.php`
//    global $spacious, $editorAvatar, $userAvatar, $browserlang, $trs, $uhp;
    global $colornews;
    // More new global variables
//    global $translationHelper, $tags;





    // SIDEBAR WIDGETS
    $colornews['sidebarwidgets'] = array();
    // Load widgets from DOKU_CONF/sidebar-widgets.local.conf
    $widgetsFile = DOKU_CONF.'sidebar-widgets.local.conf';
    // If file exists...
    if (@file_exists($widgetsFile)) {
//dbg($socialFile);
        // ... read it's content
        $widgetsFile = confToHash($widgetsFile);
        // Sorting array in alphabetical order on keys
        ksort($widgetsFile);
        // Get actual wiki syntax from file content
//dbg($socialFile);
        foreach ($widgetsFile as $key => $value) {
            $colornews['sidebarwidgets'][$key] = $value;
//dbg($key." => ".$value);
        }
//dbg($colornews['sidebarwidgets']);
    }

    
    // DEBUG
    // Adding test alerts if debug is enabled
    if (($_GET['debug'] == 1) or ($_GET['debug'] == "alerts")) {
        msg("This is an error [-1] alert with a <a href='#'>dummy link</a>", -1);
        msg("This is an info [0] message with a <a href='#'>dummy link</a>", 0);
        msg("This is a success [1] message with a <a href='#'>dummy link</a>", 1);
        msg("This is a notification [2] with a <a href='#'>dummy link</a>", 2);
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
    if ($ACT=='show') {
        $sidebar = tpl_getConf('sidebarPos').'-sidebar';
    } else {
        $sidebar = 'no-sidebar';
    }
    $classes = array(
        tpl_getConf('layout').'-layout',
        $bgClass,
        $sidebar,
    );
    /* TODO: better home detection than core */
    return join(' ', $classes);
}

function _colornews_includeFile($file = '', $widget = false) {
    if ($file != null) {
        if ((($_GET['debug'] == 1) or ($_GET['debug'] == "hooks") or ($_GET['debug'] == "include")) and (file_exists(tpl_incdir('colornews')."debug/".$file))) {
            if ($widget == true) { print '<aside id="colornews_'.substr($file, 0, -5).'_widget" class="widget">'; }
            include(tpl_incdir('colornews')."debug/".$file);
            if ($widget == true) { print '</aside>'; }
        } elseif (file_exists(tpl_incdir().$file)) {
            if ($widget == true) { print '<aside id="colornews_'.substr($file, 0, -5).'_widget" class="widget">'; }
            tpl_includeFile($file);
            if ($widget == true) { print '</aside>'; }
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
        ->addClass('edit')
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