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

/**
 * Constants
 */
define('PARTICIPATION_ACTIVE_SESSION_KEY', 'PARTICIPATION_ACTIVE');
define('PARTICIPATION_RECENTLY_ADDED_SESSION_KEY', 'PARTICIPATION_RECENTLY_ADDED');


/**
 * Back end modules
 */
/**
 * Back end modules
 */
array_insert(
	$GLOBALS['BE_MOD']['content'],
	count($GLOBALS['BE_MOD']['content']),
	array
	(
		'participation' => array
		(
			'tables' => array('tl_participation_archive', 'tl_participation', 'tl_participation_data'),
			'icon'   => 'system/modules/participation/assets/img/icon.png',
		)
	)
);


/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['user']['participation']         = '\\HeimrichHannot\\Participation\\ModuleParticipation';
$GLOBALS['FE_MOD']['user']['participation_message'] = '\HeimrichHannot\Participation\ModuleParticipationMessage';


/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_participation_archive'] = '\\HeimrichHannot\\Participation\\ParticipationArchiveModel';
$GLOBALS['TL_MODELS']['tl_participation']         = '\\HeimrichHannot\\Participation\\ParticipationModel';
$GLOBALS['TL_MODELS']['tl_participation_data']    = '\\HeimrichHannot\\Participation\\ParticipationDataModel';


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getPageIdFromUrl'][] = array('\\HeimrichHannot\\Participation\\Hooks', 'getPageIdFromUrlHook');
$GLOBALS['TL_HOOKS']['postLogin'][] = array('\\HeimrichHannot\\Participation\\Hooks', 'processMemberParticipation');
$GLOBALS['TL_HOOKS']['postAuthenticate'][] = array('\\HeimrichHannot\\Participation\\Hooks', 'processMemberParticipation');

$GLOBALS['TL_PARTICIPATION'] = !is_array($GLOBALS['TL_PARTICIPATION']) ? array() : $GLOBALS['TL_PARTICIPATION'];

$GLOBALS['TL_PARTICIPATION_DATA'] = array
(
	'member' => array
	(
		'tl_member'   => '\\HeimrichHannot\\Participation\\ParticipationDataMemberConfig',
		'tl_formdata' => '\\HeimrichHannot\\Participation\\ParticipationDataFormdataConfig'
	)
);
