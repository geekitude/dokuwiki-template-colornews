<?php
/*
 * configuration metadata
 *
 */

$meta['discussionPage']     = array('string');
$meta['userPage']           = array('string');
$meta['hideTools']          = array('onoff');
$meta['layout']             = array('multichoice','_choices' => array('boxed','wide')); /* boxed or not page layout */
$meta['bodyBg']             = array('multichoice','_choices' => array('pattern','color_primary_dark')); /* fill site background with pattern or color */
