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

namespace HeimrichHannot\Participation;


class ModuleParticipation extends \Module
{
	protected $strTemplate = 'mod_participation';

	protected $arrParticipation = array();

	public function generate()
	{
		if (TL_MODE == 'BE') {
			$objTemplate           = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD'][$this->type][0]) . ' ###';
			$objTemplate->title    = $this->headline;
			$objTemplate->id       = $this->id;
			$objTemplate->link     = $this->name;
			$objTemplate->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
		
		$objParticipations = ParticipationModel::findPublishedByAlias(\Environment::get('request'));

		if($objParticipations !== null)
		{
			ParticipationMessage::clearMessages();
			ParticipationController::setActiveParticipation($objParticipations);
		}

		global $objPage;

		$strRedirect = $this->generateFrontendUrl($objPage->row());

		if(!FE_USER_LOGGED_IN)
		{
			// Redirect to the jumpTo page
			if ($this->jumpTo && ($objTarget = $this->objModel->getRelated('jumpTo')) !== null)
			{
				$strRedirect = $this->generateFrontendUrl($objTarget->row());
			}
		}
		else
		{
			// Redirect to the jumpTo page
			if($this->participation_jumpToAfterLogin && ($objTarget = $this->objModel->getRelated('participation_jumpToAfterLogin')) !== null)
			{
				$strRedirect = $this->generateFrontendUrl($objTarget->row());
			}
		}

		// Always redirect to the jumpTo Page
		if(\Environment::get('request') !== $strRedirect)
		{
			$this->redirect($strRedirect);
		}

		return parent::generate();
	}

	protected function compile()
	{
		if(ParticipationController::issetActiveParticipation())
		{
			if($this->participation_addInfoMessage && $this->participation_infoMessageWith !== '')
			{
				$objParticipations = ParticipationController::getActiveParticipation();

				ParticipationMessage::addInfo(\String::parseSimpleTokens($this->participation_infoMessageWith, array('participation' => ParticipationController::getParticipationLabel($objParticipations[0], '', true))));

				$this->Template->msg = ParticipationMessage::generate(false, false, array(PARTICIPATION_MESSAGE_ACTIVE));
			}
		}
		else
		{
			if($this->participation_addInfoMessage && $this->participation_infoMessageWithout !== '')
				$this->Template->msg = $this->participation_infoMessageWithout;
		}
	}

}