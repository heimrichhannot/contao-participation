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
$GLOBALS['TL_LANG']['tl_participation']['type'][0] = 'Type';
$GLOBALS['TL_LANG']['tl_participation']['type'][1] = 'Select a participation type.';

$GLOBALS['TL_LANG']['tl_participation']['alias'][0] = 'Trigger-Alias';
$GLOBALS['TL_LANG']['tl_participation']['alias'][1] = 'Enter an valid alias, where the participation should be triggered on.';

$GLOBALS['TL_LANG']['tl_participation']['sourceID'][0] = 'Source';
$GLOBALS['TL_LANG']['tl_participation']['sourceID'][1] = 'Enter a source item from the list below, that should be participated if the alias was triggered.';

$GLOBALS['TL_LANG']['tl_participation']['targetType'][0] = 'Target type';
$GLOBALS['TL_LANG']['tl_participation']['targetType'][1] = 'Select a target type, on which the participation should be linked to.';

$GLOBALS['TL_LANG']['tl_participation']['maxParticipations'][0] = 'Maximum number of participants';
$GLOBALS['TL_LANG']['tl_participation']['maxParticipations'][1] = 'Set maximum number of participants. Enter 0 for unlimited number of participants.';

$GLOBALS['TL_LANG']['tl_participation']['maxParticipationsPerMember'][0] = 'Maximum number of participations per Member';
$GLOBALS['TL_LANG']['tl_participation']['maxParticipationsPerMember'][1] = 'Set maximum number of participations per Members. Enter 0 for unlimited number of participations.';

$GLOBALS['TL_LANG']['tl_participation']['published'][0] = 'Publish participation';
$GLOBALS['TL_LANG']['tl_participation']['published'][1] = 'Publish participation on the website.';

$GLOBALS['TL_LANG']['tl_participation']['start'][0] = 'Show from';
$GLOBALS['TL_LANG']['tl_participation']['start'][1] = 'Do not show the participation on the website before this day.';

$GLOBALS['TL_LANG']['tl_participation']['stop'][0] = 'Show until';
$GLOBALS['TL_LANG']['tl_participation']['stop'][1] = 'Do not show the participation on the website on and after this day.';


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_participation']['type_legend'] = 'Type';
$GLOBALS['TL_LANG']['tl_participation']['alias_legend'] = 'Alias';
$GLOBALS['TL_LANG']['tl_participation']['source_legend'] = 'Source config';
$GLOBALS['TL_LANG']['tl_participation']['target_legend'] = 'Target config';
$GLOBALS['TL_LANG']['tl_participation']['publish_legend'] = 'Publication';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_participation']['new']    = array('New participation', 'Create a new participation.');
$GLOBALS['TL_LANG']['tl_participation']['show']   = array('Participation details', 'Show details for participation ID %s');
$GLOBALS['TL_LANG']['tl_participation']['edit']   = array('Edit participation ', 'Edit participation ID %s');
$GLOBALS['TL_LANG']['tl_participation']['cut']    = array('Move participation', 'Move participation ID %s');
$GLOBALS['TL_LANG']['tl_participation']['copy']   = array('Copy participation ', 'Copy participation ID %s');
$GLOBALS['TL_LANG']['tl_participation']['delete'] = array('Delete participation', 'Delete participation ID %s');