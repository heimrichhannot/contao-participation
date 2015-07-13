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
$GLOBALS['TL_LANG']['tl_participation']['type'][0] = 'Typ';
$GLOBALS['TL_LANG']['tl_participation']['type'][1] = 'Wählen Sie einen Teilnahme-Typ.';

$GLOBALS['TL_LANG']['tl_participation']['alias'][0] = 'Auslöser-Alias';
$GLOBALS['TL_LANG']['tl_participation']['alias'][1] = 'Geben Sie einen gültigen Alias an, der die Teilnahme auslöst';

$GLOBALS['TL_LANG']['tl_participation']['defineRoot'][0] = 'Referenzseite wählen';
$GLOBALS['TL_LANG']['tl_participation']['defineRoot'][1] = 'Wählen Sie eine Referenzseite, auf welcher die Teilnahmen gültig sind.';

$GLOBALS['TL_LANG']['tl_participation']['rootPage'][0] = 'Referenzseite';
$GLOBALS['TL_LANG']['tl_participation']['rootPage'][1] = 'Wählen Sie eine Referenzseite aus der Seitenstruktur.';

$GLOBALS['TL_LANG']['tl_participation']['sourceID'][0] = 'Quelle';
$GLOBALS['TL_LANG']['tl_participation']['sourceID'][1] = 'Wählen Sie eine Quelle aus der Liste, an welcher der Nutzer teilnimmt, wenn der Alias ausgelöst wird.';

$GLOBALS['TL_LANG']['tl_participation']['targetType'][0] = 'Ziel-Typ';
$GLOBALS['TL_LANG']['tl_participation']['targetType'][1] = 'Wählen Sie einen Ziel-Typ, auf welchen die Teilnahme verweisen soll.';

$GLOBALS['TL_LANG']['tl_participation']['maxParticipations'][0] = 'Maximale Anzahl von Teilnehmern';
$GLOBALS['TL_LANG']['tl_participation']['maxParticipations'][1] = 'Bestimmt die maximale Anzahl von Teilnehmern. Geben Sie 0 für unbegrenze Teilnahmen ein.';

$GLOBALS['TL_LANG']['tl_participation']['maxParticipationsPerMember'][0] = 'Maximale Anzahl von Teilnahmen pro Mitglied';
$GLOBALS['TL_LANG']['tl_participation']['maxParticipationsPerMember'][1] = 'Bestimmt die maximale Anzahl von Teilnahmen pro Mitglied. Geben Sie 0 für unbegrenze Teilnahmen ein.';

$GLOBALS['TL_LANG']['tl_participation']['published'][0] = 'Teilnahme veröffentlichen';
$GLOBALS['TL_LANG']['tl_participation']['published'][1] = 'Teilnahme auf der Seite veröffentlichen.';

$GLOBALS['TL_LANG']['tl_participation']['start'][0] = 'Von';
$GLOBALS['TL_LANG']['tl_participation']['start'][1] = 'Versteckt die Teilnahme auf der Seite vor diesem Tag.';

$GLOBALS['TL_LANG']['tl_participation']['stop'][0] = 'Bis';
$GLOBALS['TL_LANG']['tl_participation']['stop'][1] = 'Versteckt die Teilnahme auf der Seite nach diesem Tag.';


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_participation']['type_legend'] = 'Typ';
$GLOBALS['TL_LANG']['tl_participation']['alias_legend'] = 'Alias';
$GLOBALS['TL_LANG']['tl_participation']['source_legend'] = 'Quellen-Konfiguration';
$GLOBALS['TL_LANG']['tl_participation']['target_legend'] = 'Ziel-Konfiguration';
$GLOBALS['TL_LANG']['tl_participation']['publish_legend'] = 'Veröffentlichung';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_participation']['new']    = array('Neue Teilnahme', 'Neue Teilnahme erstellen');
$GLOBALS['TL_LANG']['tl_participation']['show']   = array('Teilnahmedetails', 'Details für Teilnahme mit ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_participation']['edit']   = array('Teilnahmen bearbeiten', 'Teilnahmen unter der ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_participation']['editheader']   = array('Teilnahme bearbeiten', 'Teilnahme mit ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_participation']['cut']    = array('Teilnahme verschieben', 'Teilnahme mit ID %s verschieben');
$GLOBALS['TL_LANG']['tl_participation']['copy']   = array('Teilnahme duplizieren', 'Teilnahme mit ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_participation']['toggle'] = array('Teilnahme (un)sichtbar machen', 'Teilnahme mit ID %s ausblenden');
$GLOBALS['TL_LANG']['tl_participation']['delete'] = array('Teilnahme löschen', 'Teilnahme mit ID %s löschen');