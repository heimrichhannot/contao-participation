<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package participation
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_participation_archive']['title'][0] = 'Title';
$GLOBALS['TL_LANG']['tl_participation_archive']['title'][1] = 'Please enter a participation archive title.';

$GLOBALS['TL_LANG']['tl_participation_archive']['jumpTo'][0] = 'Redirect page';
$GLOBALS['TL_LANG']['tl_participation_archive']['jumpTo'][1] = 'Please choose the page to which users will be redirected when they are not logged-in and participate.';

$GLOBALS['TL_LANG']['tl_participation_archive']['jumpToAfterLogin'][0] = 'Redirect page for logged-in users';
$GLOBALS['TL_LANG']['tl_participation_archive']['jumpToAfterLogin'][1] = 'Please choose the page to which users will be redirected when they are logged-in and participate.';

$GLOBALS['TL_LANG']['tl_participation_archive']['defineRoot'][0] = 'Set a reference page';
$GLOBALS['TL_LANG']['tl_participation_archive']['defineRoot'][1] = 'Define a custom source page for the participation.';

$GLOBALS['TL_LANG']['tl_participation_archive']['rootPage'][0] = 'Reference page';
$GLOBALS['TL_LANG']['tl_participation_archive']['rootPage'][1] = 'Please choose the reference page from the site structure.  A participation within this archive is only possible within this reference page.';

$GLOBALS['TL_LANG']['tl_participation_archive']['addInfoMessage'][0] = 'Add information message';
$GLOBALS['TL_LANG']['tl_participation_archive']['addInfoMessage'][1] = 'Shows the user an information.';

$GLOBALS['TL_LANG']['tl_participation_archive']['infoMessageWith'][0] = 'Information message with Participation';
$GLOBALS['TL_LANG']['tl_participation_archive']['infoMessageWith'][1] = 'Enter the message the users should see. %s will be replaced with the name of the participation.';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_participation_archive']['title_legend'] = 'Title';
$GLOBALS['TL_LANG']['tl_participation_archive']['message_legend'] = 'Messages';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_participation_archive']['new']    = array('New participation archive', 'Create a new participation archive.');
$GLOBALS['TL_LANG']['tl_participation_archive']['show']   = array('Participation archive details', 'Show details for participation archive ID %s');
$GLOBALS['TL_LANG']['tl_participation_archive']['edit']   = array('Edit participation archive', 'Edit participation archive ID %s');
$GLOBALS['TL_LANG']['tl_participation_archive']['copy']   = array('Copy participation archive', 'Copy participation archive ID %s');
$GLOBALS['TL_LANG']['tl_participation_archive']['delete'] = array('Delete participation archive', 'Delete participation archive ID %s');