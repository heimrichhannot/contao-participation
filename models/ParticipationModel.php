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

class ParticipationModel extends \Model
{
	protected static $strTable = 'tl_participation';

	public static function findPublishedBySourceIDAndTypes($varID, array $arrTypes, array $arrOptions = array())
	{
		$t = static::$strTable;

		$arrColumns = array("($t.sourceID=? AND $t.type IN ('" . implode("','", $arrTypes) . "'))");

		if (!BE_USER_LOGGED_IN)
		{
			$time = \Date::floorToMinute();
			$arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
		}

		return static::findBy($arrColumns, $varID, $arrOptions);
	}

	public static function findPublishedByAlias($strAlias, array $arrOptions = array())
	{
		$t = static::$strTable;

		$arrColumns = array("($t.alias=?)");

		if (!BE_USER_LOGGED_IN)
		{
			$time = \Date::floorToMinute();
			$arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
		}

		return static::findBy($arrColumns, $strAlias, $arrOptions);
	}

	public static function findPublishedByPk($strAlias, array $arrOptions = array())
	{
		$t = static::$strTable;
		$pk = static::$strPk;

		$arrColumns = array("($t.$pk=?)");

		if (!BE_USER_LOGGED_IN)
		{
			$time = \Date::floorToMinute();
			$arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
		}

		return static::findBy($arrColumns, $strAlias, $arrOptions);
	}

	public static function findAllPublished(array $arrOptions = array())
	{
		$t = static::$strTable;

		$arrColumns = array("($t.published=?)");

		if (!BE_USER_LOGGED_IN)
		{
			$time = \Date::floorToMinute();
			$arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "')";
		}

		return static::findBy($arrColumns, '1', $arrOptions);
	}
}