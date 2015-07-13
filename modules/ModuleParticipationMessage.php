<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 *
 * @package participation
 * @author  Oliver Janke <o.janke@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Participation;


class ModuleParticipationMessage extends \Module
{

	protected $strTemplate = 'mod_participation_message';

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

		if(!ParticipationMessage::hasMessages())
		{
			return '';
		}

		return parent::generate();
	}

	protected function compile()
	{
		$this->Template->msg = \HeimrichHannot\Participation\ParticipationMessage::generate(false, false, array(PARTICIPATION_MESSAGEKEY_ACTIVE));
	}

}