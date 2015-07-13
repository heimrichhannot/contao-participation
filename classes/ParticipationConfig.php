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


abstract class ParticipationConfig extends \Controller
{
	/**
	 * Model
	 * @var \ParticipationModel
	 */
	protected $objModel;

	/**
	 * Current record
	 * @var array
	 */
	protected $arrData = array();


	/**
	 * DCA config
	 * @var array
	 */
	protected $arrDca = array();


	/**
	 * Name of the parent table
	 * @var string
	 */
	protected $ptable;

	/**
	 * Names of the child tables
	 * @var array
	 */
	protected $ctable;


	/**
	 * Names of the model table
	 * @var string
	 */
	protected $strTable;

	/**
	 * Name of the source option field name column
	 * @var string
	 */
	protected $strSourceField = 'title';

	/**
	 * Name of the source option field group name column
	 * @var string
	 */
	protected $strSourceParentField = 'title';

	/**
	 * Initialize the object
	 *
	 * @param \ParticipationModel $objConfig
	 */
	public function __construct($objConfig)
	{
		parent::__construct();

		if ($objConfig instanceof \Model)
		{
			$this->objModel = $objConfig;
		}
		elseif ($objConfig instanceof \Model\Collection)
		{
			$this->objModel = $objConfig->current();
		}

		$this->arrData = $objConfig->row();

		\Controller::loadDataContainer($objConfig->type);
		\Controller::loadLanguageFile('default');

		$this->strTable = $objConfig->type;
		$this->ptable = $GLOBALS['TL_DCA'][$this->strTable]['config']['ptable'];
		$this->ctable = $GLOBALS['TL_DCA'][$this->strTable]['config']['ctable'];
	}

	public function getParticipationLabel($strLabel, $raw=false)
	{
		$strModelClass = \Model::getClassFromTable($this->strTable);

		if(!class_exists($strModelClass)) return $strLabel;

		$objSource = $strModelClass::findByPK($this->sourceID);
		
		if($objSource === null) return $strLabel;

		if($this->ptable && ($objParent = ($objSource->getRelated('pid'))) !== null)
		{
			$strParent = $this->getSourceGroupValue($objParent);
		}

		if(($strSuffix = static::getSourceOptionValue($objSource)) !== '')
		{
			$strLabel .= (strlen($strLabel) > 0 ? ' ' : '');

			if($raw)
			{
				$strLabel .= (($strParent ? ($strParent . " : ") : "") . $strSuffix);
			}
			else
			{
				$strLabel .= '&rarr; <span style="color:#b3b3b3;padding-left:3px;">[' . (($strParent ? ($strParent . " : ") : "") . $strSuffix) . ']</span>';
			}
		}

		return $strLabel;
	}

	public function getSourceOptions()
	{
		$arrOptions = array();

		$strModelClass = \Model::getClassFromTable($this->strTable);

		if(!class_exists($strModelClass)) return $arrOptions;

		$objSources = $strModelClass::findAll();

		if($objSources === null) return $arrOptions;
		
		while($objSources->next())
		{
			$key = $objSources->{$strModelClass::getPk()};
			$value = $this->getSourceOptionValue($objSources->current());

			if($this->ptable && ($objParent = ($objSources->getRelated('pid'))) !== null)
			{
				$strParent = $this->getSourceGroupValue($objParent);
				$arrOptions[$strParent ][$key] = $value;
				continue;
			}

			$arrOptions[$key] = $value;
		}
		
		return $arrOptions;
	}

	protected function getSourceOptionValue(\Model $objSource)
	{
		return $objSource->{$this->strSourceField};
	}

	protected function getSourceGroupValue(\Model $objParent)
	{
		return $objParent->{$this->strSourceParentField};
	}


	/**
	 * Set an object property
	 *
	 * @param string $strKey
	 * @param mixed  $varValue
	 */
	public function __set($strKey, $varValue)
	{
		$this->arrData[$strKey] = $varValue;
	}


	/**
	 * Return an object property
	 *
	 * @param string $strKey
	 *
	 * @return mixed
	 */
	public function __get($strKey)
	{
		if (isset($this->arrData[$strKey]))
		{
			return $this->arrData[$strKey];
		}

		return null;
	}


	/**
	 * Check whether a property is set
	 *
	 * @param string $strKey
	 *
	 * @return boolean
	 */
	public function __isset($strKey)
	{
		return isset($this->arrData[$strKey]);
	}


	/**
	 * Return the model
	 *
	 * @return \Model
	 */
	public function getModel()
	{
		return $this->objModel;
	}
}