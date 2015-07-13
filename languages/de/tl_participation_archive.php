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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_participation_archive']['title'][0] = 'Titel';
$GLOBALS['TL_LANG']['tl_participation_archive']['title'][1] = 'Geben Sie einen Titel für das Teilnahmearchiv an.';

$GLOBALS['TL_LANG']['tl_participation_archive']['jumpTo'][0] = 'Weiterleitungsseite';
$GLOBALS['TL_LANG']['tl_participation_archive']['jumpTo'][1] = 'Bitte wählen Sie die Seite, zu welcher der Nutzer weitergeleitet werden soll, wenn er eine gültige Teilnahme-URL aufgerufen hat.';

$GLOBALS['TL_LANG']['tl_participation_archive']['jumpToAfterLogin'][0] = 'Weiterleitungsseite für eingeloggte Nutzer';
$GLOBALS['TL_LANG']['tl_participation_archive']['jumpToAfterLogin'][1] = 'Bitte wählen Sie die Seite, zu welcher der Nutzer weitergeleitet werden soll, wenn er eingeloggt ist und teilnimmt.';

$GLOBALS['TL_LANG']['tl_participation_archive']['defineRoot'][0] = 'Eine Referenzseite festlegen';
$GLOBALS['TL_LANG']['tl_participation_archive']['defineRoot'][1] = 'Dem Teilnahmearchiv eine individuelle Quellseite zuweisen.';

$GLOBALS['TL_LANG']['tl_participation_archive']['rootPage'][0] = 'Referenzseite';
$GLOBALS['TL_LANG']['tl_participation_archive']['rootPage'][1] = 'Bitte wählen Sie die Referenzseite aus der Seitenstruktur. Eine Teilnahme in diesem Archiv ist nur innerhalb der Referenzseite möglich.';

$GLOBALS['TL_LANG']['tl_participation_archive']['addInfoMessage'][0] = 'Informationsbenachrichtigung ausgeben';
$GLOBALS['TL_LANG']['tl_participation_archive']['addInfoMessage'][1] = 'Zeigt dem Nutzer Informationen.';

$GLOBALS['TL_LANG']['tl_participation_archive']['infoMessageWith'][0] = 'Informationsbenachrichtigung bei Teilnahme';
$GLOBALS['TL_LANG']['tl_participation_archive']['infoMessageWith'][1] = 'Zeigt dem Nutzer eine Nachricht an. ##participation## wird durch den Namen der Teilnahme ersetzt.';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_participation_archive']['title_legend'] = 'Titel';
$GLOBALS['TL_LANG']['tl_participation_archive']['message_legend'] = 'Meldungen';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_participation_archive']['new']    = array('Neues Teilnahmearchiv', 'Neues Teilnahmearchiv erstellen');
$GLOBALS['TL_LANG']['tl_participation_archive']['show']   = array('Teilnahmearchivdetails', 'Details für Teilnahmearchiv mit ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_participation_archive']['edit']   = array('Teilnahmen bearbeiten', 'Teilnahmen unter der ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_participation_archive']['editheader']   = array('Teilnahmearchiv bearbeiten', 'Teilnahmearchiv mit ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_participation_archive']['copy']   = array('Teilnahmearchiv duplizieren', 'Teilnahmearchiv mit ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_participation_archive']['delete'] = array('Teilnahmearchiv löschen', 'Teilnahmearchiv mit ID %s löschen');
