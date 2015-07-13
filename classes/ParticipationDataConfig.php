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


abstract class ParticipationDataConfig
{
	/**
	 * ParticipationArchive
	 * @var \ParticipationArchiveModel
	 */
	protected $objParticipationArchive;

	/**
	 * Participation
	 * @var \ParticipationModel
	 */
	protected $objParticipation;

	/**
	 * ParticipationData
	 * @var \ParticipationDataModel
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
	 * @param \ParticipationModel $objParticipation
	 */
	public function __construct($objParticipation)
	{
		if ($objParticipation instanceof \Model)
		{
			$this->objParticipation = $objParticipation;
		}
		elseif ($objParticipation instanceof \Model\Collection)
		{
			$this->objParticipation = $objParticipation->current();
		}

		$this->objParticipationArchive = $this->objParticipation->getRelated('pid');

		$this->arrData = $objParticipation->row();

		\Controller::loadDataContainer($objParticipation->targetType);

		$this->strTable = $objParticipation->targetType;
		$this->ptable = $GLOBALS['TL_DCA'][$this->targetType]['config']['ptable'];
		$this->ctable = $GLOBALS['TL_DCA'][$this->targetType]['config']['ctable'];
	}

	protected function createNewData($sourceID)
	{
		$time = time();

		$objModel = new ParticipationDataModel();

		$objModel->pid = $this->objParticipation->id;
		$objModel->tstamp = $time;
		$objModel->createdOn = $time;
		$objModel->published = 1;
		$objModel->sourceID = $sourceID;
		$objModel->type = $this->objParticipation->targetType;

		$this->objModel = $objModel->save();

		// store this participation in recently added to prevent double submission
		ParticipationController::setRecentlyAddedParticipation($this->objParticipation->id);

		// remove participation from session
		ParticipationController::removeActiveParticipation();
	}

	public function getSourceOptions()
	{
		$arrOptions = array();

		$strModelClass = \Model::getClassFromTable($this->type);
		
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

	public function getJumpToPage()
	{
		$objJumpTo = null;

		// Redirect to the jumpTo page
		if ($this->objParticipationArchive->jumpTo && ($objTarget = $this->objParticipationArchive->getRelated('jumpTo')) !== null)
		{
			$objJumpTo = $objTarget;
		}

		// Redirect to the jumpTo after login page
		if(FE_USER_LOGGED_IN && $this->objParticipationArchive->jumpToAfterLogin && ($objTargetAfterLogin = $this->objParticipationArchive->getRelated('jumpToAfterLogin')) !== null)
		{
			$objJumpTo = $objTargetAfterLogin;
		}

		return $objJumpTo;
	}

	abstract public function runAfterAuthentication(\User $objUser);


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
	 * Return the participation archive model
	 *
	 * @return \Model
	 */
	public function getParticipationArchive()
	{
		return $this->objParticipationArchive;
	}

	/**
	 * Return the participation model
	 *
	 * @return \Model
	 */
	public function getParticipation()
	{
		return $this->objParticipation;
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