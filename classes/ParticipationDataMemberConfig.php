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


class ParticipationDataMemberConfig extends ParticipationDataConfig
{
	public function runAfterAuthentication(\User $objUser)
	{
		if(!ParticipationController::issetActiveParticipation())
		{
			return false;
		}

		if ($this->maxParticipations > 0)
		{
			$intParticipations = ParticipationDataModel::countPublishedByPid($this->id);
			
			if ($intParticipations >= $this->maxParticipations)
			{
				ParticipationMessage::clearMessages();

				ParticipationMessage::addInfo(
					sprintf(
						$GLOBALS['TL_LANG']['PARTICIPATION_MESSAGE']['maxParticipations'],
						ParticipationController::getParticipationLabel($this->getParticipation(), '', true)
					)
				);

				// Remove active participation
				ParticipationController::removeActiveParticipation();

				return false;
			}
		}

		if ($this->maxParticipationsPerMember > 0)
		{
			$intParticipations = ParticipationDataModel::countPublishedBySourceIDAndTypesAndPid($objUser->id, array($this->targetType), $this->id);

			if ($intParticipations >= $this->maxParticipationsPerMember)
			{
				ParticipationMessage::clearMessages();

				ParticipationMessage::addDanger(
					sprintf(
						$GLOBALS['TL_LANG']['PARTICIPATION_MESSAGE']['maxParticipationsPerMember'],
						ParticipationController::getParticipationLabel($this->getParticipation(), '', true)
					)
				);

				// Remove active participation
				ParticipationController::removeActiveParticipation();

				return false;
			}
		}

		ParticipationMessage::clearMessages();
		
		$this->createNewData($objUser->id);

		ParticipationMessage::addSuccess(
			sprintf(
				$GLOBALS['TL_LANG']['PARTICIPATION_MESSAGE']['newParticipationSuccess'],
				ParticipationController::getParticipationLabel($this->getParticipation(), '', true)
			)
		);
		
		// remove participation from session
		ParticipationController::removeActiveParticipation();
	}


	protected function getSourceOptionValue(\Model $objSource)
	{
		return $objSource->firstname . ' ' . $objSource->lastname . ' [ID: ' . $objSource->id . ']';
	}
}