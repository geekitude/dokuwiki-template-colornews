<?php
/*
 * configuration metadata
 *
 */

$meta['discussionPage']     = array('string');
$meta['userPage']           = array('string');
$meta['hideTools']          = array('onoff');
$meta['layout']             = array('multichoice','_choices' => array('boxed','full-width')); /* boxed or not page layout */
$meta['bodyBg']             = array('multichoice','_choices' => array('pattern','color')); /* fill site background with pattern or color */
$meta['sidebarPos']         = array('multichoice','_choices' => array('left','right','no')); /* left or right sidebar (or none) */
$meta['textWrap']           = array('onoff'); /* force text to wrap or not within code or file sections */
$meta['dateLocale']         = array('string');
$meta['shortDateString']    = array('string');
$meta['longDateString']     = array('string');
$meta['banner']             = array('string');
$meta['searchAutoComplete'] = array('onoff');
$meta['sidebarCard']        = array('string');
$meta['sidebarWidgets']     = array('string');
$meta['licenseVisual']      = array('multichoice','_choices' => array('button','badge','0')); /* visual representation of wiki license */
$meta['avatar']             = array('string');
$meta['githubIssues']       = array('onoff'); /* collect Github issues number or not */

