<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{stylesheet_legend},showSingleStyles'; 

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['showSingleStyles'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['showSingleStyles'],
	'inputType'               => 'checkbox'
);

?>