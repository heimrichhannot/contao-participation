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

define('PARTICIPATION_MESSAGE_DANGER', 'PARTICIPATION_DANGER');
define('PARTICIPATION_MESSAGE_WARNING', 'PARTICIPATION_WARNING');
define('PARTICIPATION_MESSAGE_INFO', 'PARTICIPATION_INFO');
define('PARTICIPATION_MESSAGE_SUCCESS', 'PARTICIPATION_SUCCESS');
define('PARTICIPATION_MESSAGE_RAW', 'PARTICIPATION_RAW');
define('PARTICIPATION_MESSAGEKEY_ACTIVE', 'PARTICIPATION_KEY_ACTIVE');
define('PARTICIPATION_MESSAGEKEY_PARTICIPATED', 'PARTICIPATION_KEY_PARTICIPATED');

class ParticipationMessage extends \Message
{
	/**
	 * Add an danger message
	 *
	 * @param string $strMessage The danger message
	 */
	public static function addDanger($strMessage, $strKey = '')
	{
		static::add($strMessage, PARTICIPATION_MESSAGE_DANGER, $strKey);
	}


	/**
	 * Add a warning message
	 *
	 * @param string $strMessage The warning message
	 */
	public static function addWarning($strMessage, $strKey = '')
	{
		static::add($strMessage, PARTICIPATION_MESSAGE_WARNING, $strKey);
	}


	/**
	 * Add a info message
	 *
	 * @param string $strMessage The info message
	 */
	public static function addInfo($strMessage, $strKey = '')
	{
		static::add($strMessage, PARTICIPATION_MESSAGE_INFO, $strKey);
	}


	/**
	 * Add an success message
	 *
	 * @param string $strMessage The success message
	 */
	public static function addSuccess($strMessage, $strKey = '')
	{
		static::add($strMessage, PARTICIPATION_MESSAGE_SUCCESS, $strKey);
	}


	/**
	 * Add a preformatted message
	 *
	 * @param string $strMessage The preformatted message
	 */
	public static function addRaw($strMessage, $strKey = '')
	{
		static::add($strMessage, PARTICIPATION_MESSAGE_RAW, $strKey);
	}


	/**
	 * Add a message
	 *
	 * @param string $strMessage The message text
	 * @param string $strType    The message type
	 *
	 * @throws \Exception If $strType is not a valid message type
	 */
	public static function add($strMessage, $strType, $strKey='')
	{
		if ($strMessage == '')
		{
			return;
		}

		if (!in_array($strType, static::getTypes()))
		{
			throw new \Exception("Invalid message type $strType");
		}

		if (!is_array($_SESSION[$strType]))
		{
			$_SESSION[$strType] = array();
		}

		if($strKey)
		{
			$_SESSION[$strType][$strKey] = $strMessage;
		}
		else {
			$_SESSION[$strType][] = $strMessage;
		}
	}

	/**
	 * Return all messages as HTML
	 *
	 * @param boolean $blnDcLayout If true, the line breaks are different
	 * @param boolean $blnNoWrapper If true, there will be no wrapping DIV
	 * @array array keys of messages that should per persistent until cleared manually
	 *
	 * @return string The messages HTML markup
	 */
	public static function generate($blnDcLayout=false, $blnNoWrapper=false, array $arrPersistKeys = array())
	{
		$strMessages = '';

		$arrPersistKeys = array_intersect(static::getKeys(), $arrPersistKeys);
		
		// Regular messages
		foreach (static::getTypes() as $strType)
		{
			if (!is_array($_SESSION[$strType]))
			{
				continue;
			}

			$strClass = strtolower(preg_replace('/participation_/i', '', $strType));
			$_SESSION[$strType] = array_unique($_SESSION[$strType]);

			foreach ($_SESSION[$strType] as $strKey => $strMessage)
			{
				if ($strType == PARTICIPATION_MESSAGE_RAW)
				{
					$strMessages .= $strMessage;
				}
				else
				{
					$strMessages .= sprintf('<p class="alert alert-%s">%s</p>%s', $strClass, $strMessage, "\n");
				}
				
				// unset non persistent keys only
				if(!empty($arrPersistKeys) && !in_array($strKey, $arrPersistKeys, true) && !$_POST && isset($_SESSION[$strType][$strKey]))
				{
					unset($_SESSION[$strType][$strKey]);
				}
			}

			if (!$_POST && empty($_SESSION[$strType]))
			{
				$_SESSION[$strType] = array();
			}
		}

		$strMessages = trim($strMessages);

		// Wrapping container
		if (!$blnNoWrapper && $strMessages != '')
		{
			$strMessages = sprintf('%s<div class="participation_message">%s%s%s</div>%s', ($blnDcLayout ? "\n\n" : "\n"), "\n", $strMessages, "\n", ($blnDcLayout ? '' : "\n"));
		}

		return $strMessages;
	}

	/**
	 * Clear all messages, or declared only
	 *
	 * @param array $arrTypes containing message valid types from getTypes that should be unset
	 */
	public static function clearMessages(array $arrTypes = array())
	{
		$arrTypes = array_intersect(static::getTypes(), $arrTypes);
		
		foreach (static::getTypes() as $strType)
		{
			if(!empty($arrTypes) && in_array($strType, $arrTypes, true))
			{
				unset($_SESSION[$strType]);
				continue;
			}

			unset($_SESSION[$strType]);
		}
	}


	/**
	 * Check if messages are present
	 *
	 * @return bool true if messages are present, otherwise false
	 */
	public static function hasMessages()
	{
		$hasMessages = false;

		foreach (static::getTypes() as $strType)
		{
			if (!is_array($_SESSION[$strType]))
			{
				continue;
			}

			$hasMessages = true;
			break;
		}

		return $hasMessages;
	}




	/**
	 * Return all available message types
	 *
	 * @return array An array of message types
	 */
	public static function getTypes()
	{
		return array(PARTICIPATION_MESSAGE_DANGER, PARTICIPATION_MESSAGE_WARNING, PARTICIPATION_MESSAGE_INFO, PARTICIPATION_MESSAGE_SUCCESS, PARTICIPATION_MESSAGE_RAW);
	}

	/**
	 * Return all available message keys
	 *
	 * @return array An array of message keys
	 */
	public static function getKeys()
	{
		return array(PARTICIPATION_MESSAGEKEY_ACTIVE, PARTICIPATION_MESSAGEKEY_PARTICIPATED);
	}
}