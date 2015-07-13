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

class ParticipationDataModel extends \Model
{
	protected static $strTable = 'tl_participation_data';

	public static function findPublishedBySourceID($varId, array $arrOptions = array())
	{
		$t = static::$strTable;

		$arrColumns = array("$t.sourceID=?");

		if (!BE_USER_LOGGED_IN)
		{
			$arrColumns[] = "$t.published='1'";
		}

		return static::findBy($arrColumns, $varId, $arrOptions);
	}

    public static function findPublishedBySourceIDAndTypesAndPid($varId, array $arrTypes, $varPid, array $arrOptions = array())
	{
		$t = static::$strTable;

		$arrColumns = array("($t.sourceID=? AND $t.type IN ('" . implode("','", $arrTypes) . "')) AND $t.pid=$varPid");

		if (!BE_USER_LOGGED_IN)
		{
			$arrColumns[] = "$t.published='1'";
		}

		return static::findBy($arrColumns, $varId, $arrOptions);
	} 

	public static function countPublishedBySourceIDAndTypesAndPid($varId, array $arrTypes, $varPid, array $arrOptions = array())
	{
		$t = static::$strTable;

		$arrColumns = array("($t.sourceID=? AND $t.type IN ('" . implode("','", $arrTypes) . "')) AND $t.pid=$varPid");

		if (!BE_USER_LOGGED_IN)
		{
			$arrColumns[] = "$t.published='1'";
		}

		return static::countBy($arrColumns, $varId, $arrOptions);
	}

	public static function findPublishedBySourceIDAndTypes($varId, array $arrTypes, array $arrOptions = array())
	{
		$t = static::$strTable;

		$arrColumns = array("($t.sourceID=? AND $t.type IN ('" . implode("','", $arrTypes) . "'))");

		if (!BE_USER_LOGGED_IN)
		{
			$arrColumns[] = "$t.published='1'";
		}

		return static::findBy($arrColumns, $varId, $arrOptions);
	}

	public static function countPublishedBySourceIDAndTypes($varId, array $arrTypes, array $arrOptions = array())
	{
		$t = static::$strTable;

		$arrColumns = array("($t.sourceID=? AND $t.type IN ('" . implode("','", $arrTypes) . "'))");

		if (!BE_USER_LOGGED_IN)
		{
			$arrColumns[] = "$t.published='1'";
		}

		return static::countBy($arrColumns, $varId, $arrOptions);
	}


	public static function findPublishedByPid($varId, array $arrOptions = array())
	{
		$t = static::$strTable;

		$arrColumns = array("($t.pid=?)");

		if (!BE_USER_LOGGED_IN)
		{
			$arrColumns[] = "$t.published='1'";
		}

		return static::findBy($arrColumns, $varId, $arrOptions);
	}

	public static function countPublishedByPid($varId, array $arrOptions = array())
	{
		$t = static::$strTable;

		$arrColumns = array("($t.pid=?)");

		if (!BE_USER_LOGGED_IN)
		{
			$arrColumns[] = "$t.published='1'";
		}

		return static::countBy($arrColumns, $varId, $arrOptions);
	}

}