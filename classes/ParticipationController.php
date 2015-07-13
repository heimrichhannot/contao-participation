<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package participation
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Participation;


class ParticipationController extends \Controller
{
	protected static $intTimeout = 2000; // 2 seconds spam timeout between submissions

	public static function getTimeout()
	{
		return static::$intTimeout;
	}

	public static function getParticipationLabel(\Model $objModel, $strLabel, $raw=false)
	{
		if(($objConfig = static::findParticipationConfigClass($objModel)) !== null)
		{
			return $objConfig->getParticipationLabel($strLabel, $raw);
		}
	}

	public static function getParticipationSources(\Model $objModel)
	{
		if(($objConfig = static::findParticipationConfigClass($objModel)) !== null)
		{
			return $objConfig->getSourceOptions();
		}
	}

	public static function getParticipationDataLabel(\Model $objModel, $strLabel, $raw=false)
	{
		if(($objConfig = static::findParticipationConfigClass($objModel)) !== null)
		{
			return $objConfig->getParticipatorLabel($strLabel, $raw);
		}
	}

	public static function getParticipationDataSources(\Model $objModel)
	{
		if(($objConfig = static::findParticipationDataConfigClass($objModel)) !== null)
		{
			return $objConfig->getSourceOptions();
		}
	}

	public static function findParticipationDataConfigClass($objModel)
	{
		if(!is_array($GLOBALS['TL_PARTICIPATION_DATA'])) return null;

		foreach($GLOBALS['TL_PARTICIPATION_DATA'] as $k => $v)
		{
			if(isset($v[$objModel->targetType]))
			{
				$strClass = $v[$objModel->targetType];
				
				if(!class_exists($strClass)) break;

				$objConfig = new $strClass($objModel);

				return $objConfig;
			}
		}

		return null;
	}

	public static function findParticipationConfigClass($objModel)
	{
		if(!is_array($GLOBALS['TL_PARTICIPATION'])) return null;

		foreach($GLOBALS['TL_PARTICIPATION'] as $k => $v)
		{
			if(isset($v[$objModel->type]))
			{
				$strClass = $v[$objModel->type];
				
				if(!class_exists($strClass)) break;

				$objConfig = new $strClass($objModel);

				return $objConfig;
			}
		}

		return null;
	}

	public static function setActiveParticipation($objParticipation)
	{
		$_SESSION[PARTICIPATION_ACTIVE_SESSION_KEY] = $objParticipation->id;
	}

	public static function issetActiveParticipation()
	{
		return (isset($_SESSION[PARTICIPATION_ACTIVE_SESSION_KEY]) && $_SESSION[PARTICIPATION_ACTIVE_SESSION_KEY] !== '');
	}

	public static function getActiveParticipation()
	{
		if(!isset($_SESSION[PARTICIPATION_ACTIVE_SESSION_KEY])) return null;

		$strSessionKey = $_SESSION[PARTICIPATION_ACTIVE_SESSION_KEY];

		return ParticipationModel::findPublishedByPk($strSessionKey);
	}

	public static function getActiveParticipationID()
	{
		if(!isset($_SESSION[PARTICIPATION_ACTIVE_SESSION_KEY])) return null;

		return $_SESSION[PARTICIPATION_ACTIVE_SESSION_KEY];
	}

	public static function removeActiveParticipation()
	{
		unset($_SESSION[PARTICIPATION_ACTIVE_SESSION_KEY]);
	}

	public static function setRecentlyAddedParticipation()
	{
		$_SESSION[PARTICIPATION_RECENTLY_ADDED_SESSION_KEY] = $_SESSION[PARTICIPATION_ACTIVE_SESSION_KEY];
	}

	public static function issetRecentlyAddedParticipation()
	{
		return (isset($_SESSION[PARTICIPATION_RECENTLY_ADDED_SESSION_KEY]) && $_SESSION[PARTICIPATION_RECENTLY_ADDED_SESSION_KEY] !== '');
	}

	public static function getRecentlyAddedParticipation()
	{
		if(!isset($_SESSION[PARTICIPATION_RECENTLY_ADDED_SESSION_KEY])) return null;

		$strSessionKey = $_SESSION[PARTICIPATION_RECENTLY_ADDED_SESSION_KEY];

		return ParticipationModel::findPublishedByPk($strSessionKey);
	}

	public static function getRecentlyAddedParticipationID()
	{
		if(!isset($_SESSION[PARTICIPATION_RECENTLY_ADDED_SESSION_KEY])) return null;

		return $_SESSION[PARTICIPATION_RECENTLY_ADDED_SESSION_KEY];
	}

	public static function removeRecentlyAddedParticipation()
	{
		unset($_SESSION[PARTICIPATION_RECENTLY_ADDED_SESSION_KEY]);
	}

	public static function getRecentlyAddedParticipationData()
	{
		if(!isset($_SESSION[PARTICIPATION_RECENTLY_ADDED_SESSION_KEY])) return null;

		$strSessionKey = $_SESSION[PARTICIPATION_RECENTLY_ADDED_SESSION_KEY];

		return ParticipationDataModel::findPublishedByPid($strSessionKey);
	}

}