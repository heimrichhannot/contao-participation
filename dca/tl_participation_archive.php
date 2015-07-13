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


/**
 * Table tl_participation_archive
 */
$GLOBALS['TL_DCA']['tl_participation_archive'] = array
(
	
	// Config
	'config'      => array
	(
		'dataContainer'    => 'Table',
		'ctable'           => array('tl_participation'),
		'switchToEdit'     => true,
		'enableVersioning' => true,
		'onload_callback'  => array
		(
			array('tl_participation_archive', 'checkPermission'),
		),
		'sql'              => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),
	// List
	'list'        => array
	(
		'sorting'           => array
		(
			'mode'        => 1,
			'fields'      => array('title'),
			'flag'        => 1,
			'panelLayout' => 'filter;search,limit'
		),
		'label'             => array
		(
			'fields' => array('title'),
			'format' => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations'        => array
		(
			'edit'       => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_participation_archive']['edit'],
				'href'  => 'table=tl_participation',
				'icon'  => 'edit.gif'
			),
			'editheader' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_participation_archive']['editheader'],
				'href'            => 'act=edit',
				'icon'            => 'header.gif',
				'button_callback' => array('tl_participation_archive', 'editHeader')
			),
			'copy'       => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_participation_archive']['copy'],
				'href'            => 'act=copy',
				'icon'            => 'copy.gif',
				'button_callback' => array('tl_participation_archive', 'copyArchive')
			),
			'delete'     => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_participation_archive']['delete'],
				'href'            => 'act=delete',
				'icon'            => 'delete.gif',
				'attributes'      => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
									 . '\'))return false;Backend.getScrollOffset()"',
				'button_callback' => array('tl_participation_archive', 'deleteArchive')
			),
			'show'       => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_participation_archive']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif'
			)
		)
	),
	// Palettes
	'palettes'    => array
	(
		'__selector__' => array('addInfoMessage', 'defineRoot'),
		'default'      => '{title_legend},title,jumpTo,jumpToAfterLogin,defineRoot;{message_legend},addInfoMessage'
	),
	// Subpalettes
	'subpalettes' => array
	(
		'addInfoMessage' => 'infoMessageWith',
		'defineRoot'     => 'rootPage',
	),
	// Fields
	'fields'      => array
	(
		'id'                 => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp'             => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'title'              => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_participation_archive']['title'],
			'exclude'   => true,
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'maxlength' => 255),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'jumpTo'             => array
		(
			'label'      => &$GLOBALS['TL_LANG']['tl_participation_archive']['jumpTo'],
			'exclude'    => true,
			'inputType'  => 'pageTree',
			'foreignKey' => 'tl_page.title',
			'eval'       => array('fieldType' => 'radio', 'mandatory' => true),
			'sql'        => "int(10) unsigned NOT NULL default '0'",
			'relation'   => array('type' => 'hasOne', 'load' => 'eager')
		),
		'jumpToAfterLogin'   => array
		(
			'label'      => &$GLOBALS['TL_LANG']['tl_participation_archive']['jumpToAfterLogin'],
			'exclude'    => true,
			'inputType'  => 'pageTree',
			'foreignKey' => 'tl_page.title',
			'eval'       => array('fieldType' => 'radio'),
			'sql'        => "int(10) unsigned NOT NULL default '0'",
			'relation'   => array('type' => 'hasOne', 'load' => 'eager')
		),
		'defineRoot'         => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_participation_archive']['defineRoot'],
			'exclude'   => true,
			'inputType' => 'checkbox',
			'eval'      => array('submitOnChange' => true, 'tl_class' => 'clr'),
			'sql'       => "char(1) NOT NULL default ''"
		),
		'rootPage'           => array
		(
			'label'      => &$GLOBALS['TL_LANG']['tl_participation_archive']['rootPage'],
			'exclude'    => true,
			'inputType'  => 'pageTree',
			'foreignKey' => 'tl_page.title',
			'eval'       => array('fieldType' => 'radio', 'tl_class' => 'clr'),
			'sql'        => "int(10) unsigned NOT NULL default '0'",
			'relation'   => array('type' => 'hasOne', 'load' => 'lazy')
		),
		'addInfoMessage'     => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_participation_archive']['addInfoMessage'],
			'exclude'   => true,
			'inputType' => 'checkbox',
			'eval'      => array('submitOnChange' => true),
			'sql'       => "char(1) NOT NULL default ''"
		),
		'infoMessageWith'    => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_participation_archive']['infoMessageWith'],
			'exclude'   => true,
			'inputType' => 'textarea',
			'eval'      => array('allowHtml' => true),
			'sql'       => "text NULL"
		),
	)
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_participation_archive extends Backend
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
	 * Check permissions to edit table tl_participation_archive
	 */
	public function checkPermission()
	{
		if ($this->User->isAdmin) {
			return;
		}

		// Set root IDs
		if (!is_array($this->User->participation) || empty($this->User->participation)) {
			$root = array(0);
		} else {
			$root = $this->User->participation;
		}

		$GLOBALS['TL_DCA']['tl_participation']['list']['sorting']['root'] = $root;

		// Check permissions to add archives
		if (!$this->User->hasAccess('create', 'participationp')) {
			$GLOBALS['TL_DCA']['tl_participation']['config']['closed'] = true;
		}

		// Check current action
		switch (Input::get('act')) {
			case 'create':
			case 'select':
				// Allow
				break;

			case 'edit':
				// Dynamically add the record to the user profile
				if (!in_array(Input::get('id'), $root)) {
					$arrNew = $this->Session->get('new_records');

					if (is_array($arrNew['tl_participation']) && in_array(Input::get('id'), $arrNew['tl_participation'])) {
						// Add permissions on user level
						if ($this->User->inherit == 'custom' || !$this->User->groups[0]) {
							$objUser = $this->Database->prepare("SELECT participation, participationp FROM tl_user WHERE id=?")
								->limit(1)
								->execute($this->User->id);

							$arrParticipationp = deserialize($objUser->participationp);

							if (is_array($arrParticipationp) && in_array('create', $arrParticipationp)) {
								$arrParticipation   = deserialize($objUser->participation);
								$arrParticipation[] = Input::get('id');

								$this->Database->prepare("UPDATE tl_user SET participation=? WHERE id=?")
									->execute(serialize($arrParticipation), $this->User->id);
							}
						} // Add permissions on group level
						elseif ($this->User->groups[0] > 0) {
							$objGroup = $this->Database->prepare("SELECT participation, participationp FROM tl_user_group WHERE id=?")
								->limit(1)
								->execute($this->User->groups[0]);

							$arrParticipationp = deserialize($objGroup->participationp);

							if (is_array($arrParticipationp) && in_array('create', $arrParticipationp)) {
								$arrParticipation   = deserialize($objGroup->participation);
								$arrParticipation[] = Input::get('id');

								$this->Database->prepare("UPDATE tl_user_group SET participation=? WHERE id=?")
									->execute(serialize($arrParticipation), $this->User->groups[0]);
							}
						}

						// Add new element to the user object
						$root[]                    = Input::get('id');
						$this->User->participation = $root;
					}
				}
			// No break;

			case 'copy':
			case 'delete':
			case 'show':
				if (!in_array(Input::get('id'), $root) || (Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'participationp'))) {
					$this->log(
						'Not enough permissions to ' . Input::get('act') . ' participation archive ID "' . Input::get('id') . '"',
						__METHOD__,
						TL_ERROR
					);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
				$session = $this->Session->getData();
				if (Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'participationp')) {
					$session['CURRENT']['IDS'] = array();
				} else {
					$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
				}
				$this->Session->setData($session);
				break;

			default:
				if (strlen(Input::get('act'))) {
					$this->log('Not enough permissions to ' . Input::get('act') . ' participation archive', __METHOD__, TL_ERROR);
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
		return $this->User->canEditFieldsOf('tl_participation_archive') ?
			'<a href="' . $this->addToUrl($href . '&amp;id=' . $row['id']) . '" title="' . specialchars($title) . '"' . $attributes . '>'
			. Image::getHtml($icon, $label) . '</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)) . ' ';
	}
	
	
	/**
	 * Return the copy archive button
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
		return $this->User->hasAccess('create', 'participationp') ?
			'<a href="' . $this->addToUrl($href . '&amp;id=' . $row['id']) . '" title="' . specialchars($title) . '"' . $attributes . '>'
			. Image::getHtml($icon, $label) . '</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)) . ' ';
	}
	
	
	/**
	 * Return the delete archive button
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
		return $this->User->hasAccess('delete', 'participationp') ?
			'<a href="' . $this->addToUrl($href . '&amp;id=' . $row['id']) . '" title="' . specialchars($title) . '"' . $attributes . '>'
			. Image::getHtml($icon, $label) . '</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)) . ' ';
	}
}
