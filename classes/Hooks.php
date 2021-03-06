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


class Hooks
{
	public static function getPageIdFromUrlHook($arrFragments)
	{
		$objParticipation = ParticipationModel::findPublishedByAlias(\Environment::get('request'));

		if ($objParticipation !== null)
		{
			$blnAddParticipation = true;

			// only one participation per alias is supported yet
			if ($objParticipation instanceof \Model\Collection)
			{
				$objParticipation = $objParticipation->current();
			}

			$objArchive = $objParticipation->getRelated('pid');

			if ($objArchive === null)
			{
				$blnAddParticipation = false;
			}

			// check if current page is in defined root
			if($objArchive->defineRoot && $objArchive->rootPage > 0)
			{
				$objCurrentRootPage = \Frontend::getRootPageFromUrl();

				$objRootPage = \PageModel::findByPk($objArchive->rootPage);

				if($objRootPage !== null && $objCurrentRootPage !== null)
				{
					if($objRootPage->domain != $objCurrentRootPage->domain)
					{
						$blnAddParticipation = false;
						ParticipationController::removeActiveParticipation();
					}
				}
			}

			if($blnAddParticipation)
			{
				ParticipationController::setActiveParticipation($objParticipation);

				if ($objArchive->addInfoMessage && $objArchive->infoMessageWith !== '')
				{
					ParticipationMessage::addInfo(
                        StringUtil::parseSimpleTokens(
							$objArchive->infoMessageWith,
							array('participation' => ParticipationController::getParticipationLabel($objParticipation, '', true))
						),
						PARTICIPATION_MESSAGEKEY_ACTIVE
					);
				}
			}

			if (($objConfig = ParticipationController::findParticipationDataConfigClass($objParticipation)) !== null)
			{
				global $objPage;

				$objJumpTo = $objConfig->getJumpToPage();

				// redirect first, otherwise participation process will run twice
				if($objJumpTo !== null && $objPage->id != $objJumpTo->id)
				{
					\Controller::redirect(\Controller::generateFrontendUrl($objJumpTo->row()));
				}
			}
		}

		return $arrFragments;
	}

	public function processMemberParticipation($objUser)
	{
		if (TL_MODE != 'FE')
		{
			return false;
		}

		$objParticipation = ParticipationController::getActiveParticipation();

		if ($objParticipation === null) {
			return false;
		}

		if (($objConfig = ParticipationController::findParticipationDataConfigClass($objParticipation)) !== null)
		{
			global $objPage;
			
			$objJumpTo = $objConfig->getJumpToPage();

			// redirect first, otherwise participation process will run twice
			if($objJumpTo !== null && $objPage->id != $objJumpTo->id)
			{
				\Controller::redirect(\Controller::generateFrontendUrl($objJumpTo->row()));
			}

			$objConfig->runAfterAuthentication($objUser);

			return true;
		}
	}

}
