<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 *
 * @package participation
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$dc = &$GLOBALS['TL_DCA']['tl_module'];

\Controller::loadLanguageFile('tl_participation');

/**
 * Selector
 */
$dc['palettes']['__selector__'][] = 'participation_addInfoMessage';

/**
 * Palettes
 */
$dc['palettes']['participation'] =
	'{title_legend},name,headline,type;
	{participation_info_legend},participation_addInfoMessage;
	{redirect_legend},jumpTo,participation_jumpToAfterLogin;
	{template_legend:hide},customTpl;
	{protected_legend:hide},protected;
	{expert_legend:hide},guests,cssID,space';

$dc['palettes']['participation_message'] =
	'{title_legend},name,headline,type;
	{template_legend:hide},customTpl;
	{protected_legend:hide},protected;
	{expert_legend:hide},guests,cssID,space';

/**
 * Subpalettes
 */

$dc['subpalettes']['participation_addInfoMessage'] = 'participation_infoMessageWith, participation_infoMessageWithout';

$arrFields = array
(
	'participation_addInfoMessage'     => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_module']['participation_addInfoMessage'],
		'exclude'   => true,
		'inputType' => 'checkbox',
		'eval'      => array('submitOnChange' => true),
		'sql'       => "char(1) NOT NULL default ''"
	),
	'participation_infoMessageWith'    => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_module']['participation_infoMessageWith'],
		'exclude'   => true,
		'inputType' => 'textarea',
		'eval'      => array('allowHtml' => true),
		'sql'       => "text NULL"
	),
	'participation_infoMessageWithout' => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_module']['participation_infoMessageWithout'],
		'exclude'   => true,
		'inputType' => 'textarea',
		'eval'      => array('allowHtml' => true),
		'sql'       => "text NULL"
	),
	'participation_jumpToAfterLogin'   => array
	(
		'label'      => &$GLOBALS['TL_LANG']['tl_module']['participation_jumpToAfterLogin'],
		'exclude'    => true,
		'inputType'  => 'pageTree',
		'foreignKey' => 'tl_page.title',
		'eval'       => array('fieldType' => 'radio'),
		'sql'        => "int(10) unsigned NOT NULL default '0'",
		'relation'   => array('type' => 'hasOne', 'load' => 'eager')
	)
);

$dc['fields'] = array_merge($arrFields, $dc['fields']);