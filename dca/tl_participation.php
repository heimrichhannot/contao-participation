<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package participation
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

/**
 * Table tl_participation
 */
$GLOBALS['TL_DCA']['tl_participation'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'					  => 'tl_participation_archive',
		'ctable'                      => array('tl_participation_data'),
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'onload_callback' => array
		(
			array('tl_participation', 'checkPermission'),
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid,alias' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('alias DESC'),
			'headerFields'            => array('title'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_callback'   => array('tl_participation', 'listRecords'),
			'child_record_class'      => 'no_padding',
			'disableGrouping'		  => true
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_participation']['edit'],
				'href'                => 'table=tl_participation_data',
				'icon'                => 'edit.gif'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_participation']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_participation', 'editHeader')
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_participation']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
				'button_callback'     => array('tl_participation', 'copyArchive')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_participation']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				'button_callback'     => array('tl_participation', 'deleteArchive')
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_participation']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_participation', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_participation']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('type', 'targetType', 'published'),
		'default'                     => '{type_legend},type;',
	),

	// Subpalettes
	'subpalettes' => array
	(
		'published'                   => 'start,stop',
		'targetType_tl_formdata'      => 'maxParticipations',
		'targetType_tl_member'        => 'maxParticipations, maxParticipationsPerMember'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_participation_archive.title',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation']['type'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_participation', 'getParticipationTypes'),
			'reference'               => &$GLOBALS['TL_LANG']['PARTICIPATION'],
			'eval'                    => array('chosen'=>true, 'submitOnChange'=>true, 'mandatory' => true, 'includeBlankOption' => true),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>128, 'tl_class'=>'long', 'mandatory' => true),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),
		'sourceID' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation']['sourceID'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_participation', 'getParticipationSources'),
			'eval'                    => array('chosen'=>true, 'mandatory' => true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'targetType' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation']['targetType'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_participation', 'getParticipationTargetTypes'),
			'reference'               => &$GLOBALS['TL_LANG']['PARTICIPATION_DATA'],
			'eval'                    => array('chosen'=>true, 'submitOnChange'=>true, 'mandatory' => true, 'includeBlankOption' => true),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'maxParticipations' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation']['maxParticipations'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'mandatory' => false, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'maxParticipationsPerMember' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation']['maxParticipationsPerMember'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'mandatory' => false, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '1'"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'stop' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation']['stop'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		)
	)
);


/**
 * Class tl_participation
 */
class tl_participation extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * Check permissions to edit table tl_participation
	 */
	public function checkPermission()
	{
		if ($this->User->isAdmin)
		{
			return;
		}

		// Set root IDs
		if (!is_array($this->User->participation) || empty($this->User->participation))
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->participation;
		}
		
		

		$GLOBALS['TL_DCA']['tl_participation']['list']['sorting']['root'] = $root;

		// Check permissions to add archives
		if (!$this->User->hasAccess('create', 'participationp'))
		{
			$GLOBALS['TL_DCA']['tl_participation']['config']['closed'] = true;
		}

		// Check current action
		switch (Input::get('act'))
		{
			case 'create':
			case 'select':
				// Allow
				break;

			case 'edit':
				// Dynamically add the record to the user profile
				if (!in_array(Input::get('id'), $root))
				{
					$arrNew = $this->Session->get('new_records');

					if (is_array($arrNew['tl_participation']) && in_array(Input::get('id'), $arrNew['tl_participation']))
					{
						// Add permissions on user level
						if ($this->User->inherit == 'custom' || !$this->User->groups[0])
						{
							$objUser = $this->Database->prepare("SELECT participation, participationp FROM tl_user WHERE id=?")
								->limit(1)
								->execute($this->User->id);

							$arrParticipationp = deserialize($objUser->participationp);

							if (is_array($arrParticipationp) && in_array('create', $arrParticipationp))
							{
								$arrParticipation = deserialize($objUser->participation);
								$arrParticipation[] = Input::get('id');

								$this->Database->prepare("UPDATE tl_user SET participation=? WHERE id=?")
									->execute(serialize($arrParticipation), $this->User->id);
							}
						}

						// Add permissions on group level
						elseif ($this->User->groups[0] > 0)
						{
							$objGroup = $this->Database->prepare("SELECT participation, participationp FROM tl_user_group WHERE id=?")
								->limit(1)
								->execute($this->User->groups[0]);

							$arrParticipationp = deserialize($objGroup->participationp);

							if (is_array($arrParticipationp) && in_array('create', $arrParticipationp))
							{
								$arrParticipation = deserialize($objGroup->participation);
								$arrParticipation[] = Input::get('id');

								$this->Database->prepare("UPDATE tl_user_group SET participation=? WHERE id=?")
									->execute(serialize($arrParticipation), $this->User->groups[0]);
							}
						}

						// Add new element to the user object
						$root[] = Input::get('id');
						$this->User->participation = $root;
					}
				}
			// No break;

			case 'copy':
			case 'delete':
			case 'show':
				if (!in_array(Input::get('id'), $root) || (Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'participationp')))
				{
					$this->log('Not enough permissions to '.Input::get('act').' participation ID "'.Input::get('id').'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
				$session = $this->Session->getData();
				if (Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'participationp'))
				{
					$session['CURRENT']['IDS'] = array();
				}
				else
				{
					$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
				}
				$this->Session->setData($session);
				break;

			default:
				if (strlen(Input::get('act')))
				{
					$this->log('Not enough permissions to '.Input::get('act').' participation', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
		}
	}


	/**
	 * Return the edit header button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		return $this->User->canEditFieldsOf('tl_participation') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}


	/**
	 * Return the copy button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function copyArchive($row, $href, $label, $title, $icon, $attributes)
	{
		return $this->User->hasAccess('create', 'participationp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}


	/**
	 * Return the delete button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function deleteArchive($row, $href, $label, $title, $icon, $attributes)
	{
		return $this->User->hasAccess('delete', 'participationp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}

	/**
	 * Return the "toggle visibility" button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->hasAccess('tl_participation::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}


	/**
	 * Disable/enable a user group
	 *
	 * @param integer       $intId
	 * @param boolean       $blnVisible
	 * @param DataContainer $dc
	 */
	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{
		// Check permissions to edit
		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');
		$this->checkPermission();

		// Check permissions to publish
		if (!$this->User->hasAccess('tl_participation::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish participation item ID "'.$intId.'"', __METHOD__, TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$objVersions = new Versions('tl_news', $intId);
		$objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_participation']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_participation']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, ($dc ?: $this));
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, ($dc ?: $this));
				}
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_participation SET tstamp=". time() .", published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
			->execute($intId);

		$objVersions->create();
		$this->log('A new version of record "tl_participation.id='.$intId.'" has been created'.$this->getParentEntries('tl_participation', $intId), __METHOD__, TL_GENERAL);

	}


	/**
	 * Return all participation types as array
	 *
	 * @return array
	 */
	public function getParticipationTypes()
	{
		$groups = array();
		
		foreach ($GLOBALS['TL_PARTICIPATION'] as $k=>$v)
		{
			foreach (array_keys($v) as $kk)
			{
				$groups[$k][] = $kk;
			}
		}

		return $groups;
	}

	public function getParticipationSources(\DataContainer $dc)
	{
		$arrTargets = array();

		if($dc->activeRecord->type == '') return $arrTargets;

		$strClass = \Model::getClassFromTable($dc->activeRecord->type);

		if(!class_exists($strClass)) return $arrTargets;

		return \HeimrichHannot\Participation\ParticipationController::getParticipationSources(new $strClass($dc->activeRecord));
	}

	/**
	 * Return all participation target types as array
	 *
	 * @return array
	 */
	public function getParticipationTargetTypes()
	{
		$groups = array();

		foreach ($GLOBALS['TL_PARTICIPATION_DATA'] as $k=>$v)
		{
			foreach (array_keys($v) as $kk)
			{
				$groups[$k][] = $kk;
			}
		}

		return $groups;
	}

	public function listRecords($row)
	{
		$strLabel = $row['alias'];

		if($row['type'] == '') return $strLabel;

		$strClass = \Model::getClassFromTable($row['type']);

		if(!class_exists($strClass)) return $strLabel;

		$objModel = new $strClass();
		$objModel->setRow($row);

		return \HeimrichHannot\Participation\ParticipationController::getParticipationLabel($objModel, $strLabel);
	}
}
