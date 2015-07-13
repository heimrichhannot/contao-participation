<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Models
	'HeimrichHannot\Participation\ParticipationModel'            => 'system/modules/participation/models/ParticipationModel.php',
	'HeimrichHannot\Participation\ParticipationArchiveModel'     => 'system/modules/participation/models/ParticipationArchiveModel.php',
	'HeimrichHannot\Participation\ParticipationDataModel'        => 'system/modules/participation/models/ParticipationDataModel.php',

	// Modules
	'HeimrichHannot\Participation\ModuleParticipationMessage'    => 'system/modules/participation/modules/ModuleParticipationMessage.php',

	// Classes
	'HeimrichHannot\Participation\ParticipationDataConfig'       => 'system/modules/participation/classes/ParticipationDataConfig.php',
	'HeimrichHannot\Participation\ParticipationController'       => 'system/modules/participation/classes/ParticipationController.php',
	'HeimrichHannot\Participation\ParticipationDataMemberConfig' => 'system/modules/participation/classes/ParticipationDataMemberConfig.php',
	'HeimrichHannot\Participation\Hooks'                         => 'system/modules/participation/classes/Hooks.php',
	'HeimrichHannot\Participation\ParticipationMessage'          => 'system/modules/participation/classes/ParticipationMessage.php',
	'HeimrichHannot\Participation\ParticipationConfig'           => 'system/modules/participation/classes/ParticipationConfig.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_participation'         => 'system/modules/participation/templates/modules',
	'mod_participation_message' => 'system/modules/participation/templates/modules',
));
