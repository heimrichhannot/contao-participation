<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package participation
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

System::loadLanguageFile('tl_participation_data');

/**
 * Table tl_participation_data
 */
$GLOBALS['TL_DCA']['tl_participation_data'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_participation',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
//		'onload_callback' => array
//		(
//			array('tl_participation_data', 'checkPermission'),
//		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid,published' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('createdOn DESC'),
			'headerFields'            => array('alias', 'type', 'tstamp', 'sourceID'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_callback'   => array('tl_participation_data', 'listRecords'),
			'child_record_class'      => 'no_padding'
		),
		'label' => array
		(
			'fields'                  => array('alias'),
			'format'                  => '%s'
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
				'label'               => &$GLOBALS['TL_LANG']['tl_participation_data']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_participation_data']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_participation_data', 'toggleIcon')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_participation_data']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},targetID;{date_legend},createdOn;{publish_legend},published'
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
			'foreignKey'              => 'tl_participation.title',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		// always store the type, as long as the parent targetType can be changed and data will become inconsistent
		'type' => array
		(
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'sourceID' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation_data']['sourceID'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_participation_data', 'getParticipators'),
			'eval'                    => array('chosen'=>true, 'mandatory' => true, 'includeBlankOption' => true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
		),
		'createdOn' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation_data']['createdOn'],
			'default'                 => time(),
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 5,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_participation_data']['published'],
			'inputType'               => 'checkbox',
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		)
	)
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_participation_data extends Backend
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
	 * Check permissions to edit table tl_news
	 */
	public function checkPermission()
	{
		// HOOK: comments extension required
		if (!in_array('comments', ModuleLoader::getActive()))
		{
			$key = array_search('allowComments', $GLOBALS['TL_DCA']['tl_participation_data']['list']['sorting']['headerFields']);
			unset($GLOBALS['TL_DCA']['tl_participation_data']['list']['sorting']['headerFields'][$key]);
		}

		if ($this->User->isAdmin)
		{
			return;
		}

		// Set the root IDs
		if (!is_array($this->User->news) || empty($this->User->news))
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->news;
		}

		$id = strlen(Input::get('id')) ? Input::get('id') : CURRENT_ID;

		// Check current action
		switch (Input::get('act'))
		{
			case 'paste':
				// Allow
				break;

			case 'create':
				if (!strlen(Input::get('pid')) || !in_array(Input::get('pid'), $root))
				{
					$this->log('Not enough permissions to create news items in news archive ID "'.Input::get('pid').'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'cut':
			case 'copy':
				if (!in_array(Input::get('pid'), $root))
				{
					$this->log('Not enough permissions to '.Input::get('act').' news item ID "'.$id.'" to news archive ID "'.Input::get('pid').'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
			// NO BREAK STATEMENT HERE

			case 'edit':
			case 'show':
			case 'delete':
			case 'toggle':
			case 'feature':
				$objArchive = $this->Database->prepare("SELECT pid FROM tl_news WHERE id=?")
					->limit(1)
					->execute($id);

				if ($objArchive->numRows < 1)
				{
					$this->log('Invalid news item ID "'.$id.'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				if (!in_array($objArchive->pid, $root))
				{
					$this->log('Not enough permissions to '.Input::get('act').' news item ID "'.$id.'" of news archive ID "'.$objArchive->pid.'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'select':
			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
			case 'cutAll':
			case 'copyAll':
				if (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access news archive ID "'.$id.'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				$objArchive = $this->Database->prepare("SELECT id FROM tl_news WHERE pid=?")
					->execute($id);

				if ($objArchive->numRows < 1)
				{
					$this->log('Invalid news archive ID "'.$id.'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				$session = $this->Session->getData();
				$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objArchive->fetchEach('id'));
				$this->Session->setData($session);
				break;

			default:
				if (strlen(Input::get('act')))
				{
					$this->log('Invalid command "'.Input::get('act').'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				elseif (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access news archive ID ' . $id, __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
		}
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
		if (!$this->User->hasAccess('tl_participation_data::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish tl_participation_data item ID "'.$intId.'"', __METHOD__, TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$objVersions = new Versions('tl_news', $intId);
		$objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_participation_data']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_participation_data']['fields']['published']['save_callback'] as $callback)
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
		$this->Database->prepare("UPDATE tl_participation_data SET tstamp=". time() .", published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
			->execute($intId);

		$objVersions->create();
		$this->log('A new version of record "tl_participation_data.id='.$intId.'" has been created'.$this->getParentEntries('tl_participation', $intId), __METHOD__, TL_GENERAL);

	}


	public function getParticipators(\DataContainer $dc)
	{
		$arrParticipators = array();

		$objParticipation = \HeimrichHannot\Participation\ParticipationModel::findByPk($dc->activeRecord->pid);

		if($objParticipation === null) return $arrParticipators;

		if($objParticipation->type == '') return $arrParticipators;

		return \HeimrichHannot\Participation\ParticipationController::getParticipationDataSources($objParticipation);
	}

	/**
	 * Return all participation types as array
	 *
	 * @return array
	 */
	public function getParticipationTypes()
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

	/**
	 * Add the type of input field
	 *
	 * @param array $arrRow
	 *
	 * @return string
	 */
	public function listRecords($arrRow)
	{
		$objMember = \HeimrichHannot\MemberPlus\MemberPlusMemberModel::findActiveByIdOrAlias($arrRow['sourceID']);
		return '<div class="tl_content_left">' . $objMember->firstname . ' ' . $objMember->lastname . ' <span style="color:#b3b3b3;padding-left:3px">[ID:' . $arrRow['sourceID'] . " | " . Date::parse(Config::get('datimFormat'), $arrRow['createdOn']) . ']</span></div>';
	}
}
