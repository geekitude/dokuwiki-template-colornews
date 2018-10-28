<?php
/*
 * configuration metadata
 *
 */

$meta['discussionPage']     = array('string');
$meta['userPage']           = array('string');
$meta['hideTools']          = array('onoff');
$meta['layout']             = array('multichoice','_choices' => array('boxed','wide')); /* boxed or not page layout */
$meta['bodyBg']             = array('multichoice','_choices' => array('pattern','color')); /* fill site background with pattern or color */
$meta['bodyBgColor']        = array('string');
$meta['sidebarPos']         = array('multichoice','_choices' => array('left','right','no')); /* left or right sidebar (or none) */
$meta['dateLocale']         = array('string');
$meta['shortDateString']    = array('string');
$meta['longDateString']     = array('string');
