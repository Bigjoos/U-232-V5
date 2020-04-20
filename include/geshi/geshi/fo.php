<?php
/*************************************************************************************
 * fo.php
 * --------
 * Author: Tan-Vinh Nguyen (tvnguyen@web.de)
 * Copyright: (c) 2009 Tan-Vinh Nguyen
 * Release Version: 1.0.8.9
 * Date Started: 2009/03/23
 *
 * fo language file for GeSHi.
 *
 * FO stands for "Flexible Oberflaechen" (Flexible Surfaces) and
 * is part of the abas-ERP.
 *
 * CHANGES
 * -------
 * 2009/03/23 (1.0.0)
 *   -  First Release
 *      Basic commands in German and English
 *
 *************************************************************************************
 *
 *     This file is part of GeSHi.
 *
 *   GeSHi is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   GeSHi is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with GeSHi; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ************************************************************************************/

$language_data = [
    'LANG_NAME' => 'FO (abas-ERP)',
    'COMMENT_SINGLE' => [1 => '..'],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'", '"'],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        //Control Flow
        1 => [
            /* see http://www.abas.de/sub_de/kunden/help/hd/html/9.html */

            /* fo keywords, part 1: control flow */
            '.weiter', '.continue'

            /* this language works with goto's only*/
        ],

        //FO Keywords
        2 => [
            /* fo keywords, part 2 */
            '.fo', '.formel', '.formula',
            '.zuweisen', '.assign',
            '.fehler', '.error',
            '.ende', '.end'
        ],

        //Java Keywords
        3 => [
            /* Java keywords, part 3: primitive data types */
            '.art', '.type',
            'integer', 'real', 'bool', 'text', 'datum', 'woche', 'termin', 'zeit',
            'mehr', 'MEHR'
        ],

        //Reserved words in fo literals
        4 => [
            /* other reserved words in fo literals */
            /* should be styled to look similar to numbers and Strings */
            'false', 'null', 'true',
            'OBJEKT',
            'VORGANG', 'PROCESS',
            'OFFEN', 'OPEN',
            'ABORT',
            'AN', 'ADDEDTO',
            'AUF', 'NEW',
            'BILDSCHIRM', 'TERMINAL',
            'PC',
            'MASKE', 'SCREEN',
            'ZEILE', 'LINE'
        ],

        // interpreter settings
        5 => [
            '..!INTERPRETER', 'DEBUG'
        ],

        // database commands
        6 => [
            '.hole', '.hol', '.select',
            '.lade', '.load',
            '.aktion', '.action',
            '.belegen', '.occupy',
            '.bringe', '.rewrite',
            '.dazu', '.add',
            '.löschen', '.delete',
            '.mache', '.make',
            '.merke', '.reserve',
            '.setze', '.set',
            'SPERREN', 'LOCK',
            'TEIL', 'PART',
            'KEINESPERRE',
            'AMASKE', 'ASCREEN',
            'BETRIEB', 'WORK-ORDER',
            'NUMERISCH', 'NUMERICAL',
            'VORSCHLAG', 'SUGGESTION',
            'OBLIGO', 'OUTSTANDING',
            'LISTE', 'LIST',
            'DRUCK', 'PRINT',
            'ÜBERNAHME', 'TAGEOVER',
            'ABLAGE', 'FILINGSYSTEM',
            'BDE', 'PDC',
            'BINDUNG', 'ALLOCATION',
            'BUCHUNG', 'ENTRY',
            'COLLI', 'SERIAL',
            'DATEI', 'FILE',
            'VERKAUF', 'SALES',
            'EINKAUF', 'PURCHASING',
            'EXEMPLAR', 'EXAMPLE',
            'FERTIGUNG', 'PRODUCTION',
            'FIFO',
            'GRUPPE', 'GROUP',
            'JAHR', 'YEAR',
            'JOURNAL',
            'KOPF', 'HEADER',
            'KOSTEN',
            'LIFO',
            'LMENGE', 'SQUANTITY',
            'LOHNFERTIGUNG', 'SUBCONTRACTING',
            'LPLATZ', 'LOCATION',
            'MBELEGUNG', 'MACHLOADING',
            'MONAT', 'MONTH', 'MZ',
            'NACHRICHT', 'MESSAGE',
            'PLAN', 'TARGET',
            'REGIONEN', 'REGIONS',
            'SERVICEANFRAGE', 'SERVICEREQUEST',
            'VERWENDUNG', 'APPLICATION',
            'WEITER', 'CONTINUE',
            'ABBRUCH', 'CANCEL',
            'ABLAGEKENNZEICHEN', 'FILLINGCODE',
            'ALLEIN', 'SINGLEUSER',
            'AUFZAEHLTYP', 'ENUMERATION-TYPE',
            'AUSGABE', 'OUTPUT',
            'DEZPUNKT', 'DECPOINT'
        ],

        // output settings
        7 => [
            '.absatz', '.para',
            '.blocksatz', '.justified',
            '.flattersatz', '.unjustified',
            '.format',
            '.box',
            '.drucken', '.print',
            '.gedruckt', '.printed',
            '.länge', '.length',
            '.links', '.left',
            '.rechts', '.right',
            '.oben', '.up',
            '.unten', '.down',
            '.seite', '.page',
            '.tabellensatz', '.tablerecord',
            '.trenner', '.separator',
            'ARCHIV'
        ],

        // text commands
        8 => [
            '.text',
            '.atext',
            '.println',
            '.uebersetzen', '.translate'
        ],

        // I/O commands
        9 => [
            '.aus', '.ausgabe', '.output',
            '.ein', '.eingabe', '.input',
            '.datei', '.file',
            '.lesen', '.read',
            '.sortiere', '.sort',
            '-ÖFFNEN', '-OPEN',
            '-TEST',
            '-LESEN', '-READ',
            'VON', 'FROM'
        ],

        //system
        10 => [
            '.browser',
            '.kommando', '.command',
            '.system', '.dde',
            '.editiere', '.edit',
            '.hilfe', '.help',
            '.kopieren', '.copy',
            '.pc.clip',
            '.pc.copy',
            '.pc.dll',
            '.pc.exec',
            '.pc.open',
            'DIAGNOSE', 'ERRORREPORT',
            'DOPPELPUNKT', 'COLON',
            'ERSETZUNG', 'REPLACEMENT',
            'WARTEN', 'PARALLEL'
        ],

        //fibu/accounting specific commands
        11 => [
            '.budget',
            '.chart',
            'VKZ',
            'KONTO', 'ACCOUNT',
            'AUSZUG', 'STATEMENT',
            'WAEHRUNG', 'CURRENCY',
            'WAEHRUNGSKURS', 'EXCHANGERATE',
            'AUSWAEHR', 'FORCURR',
            'BUCHUNGSKREIS', 'SET OF BOOKS'
        ],

        // efop - extended flexible surface
        12 => [
            '.cursor',
            '.farbe', '.colour',
            '.fenster', '.window',
            '.hinweis', '.note',
            '.menue', '.menu',
            '.schutz', '.protection',
            '.zeigen', '.view',
            '.zeile', '.line',
            'VORDERGRUND', 'FOREGROUND',
            'HINTERGRUND', 'BACKGROUND',
            'SOFORT', 'IMMEDIATELY',
            'AKTUALISIEREN', 'UPDATE',
            'FENSTERSCHLIESSEN', 'CLOSEWINDOWS'
        ],
    ],
    'SYMBOLS' => [
        0 => ['(', ')', '[', ']', '{', '}', '*', '&', '%', ';', '<', '>'],
        1 => ['?', '!']
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        /* all fo keywords are case sensitive, don't have to but I like this type of coding */
        1 => true, 2 => true, 3 => true, 4 => true,
        5 => true, 6 => true, 7 => true, 8 => true, 9 => true,
        10 => true, 11 => true, 12 => true
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #000000; font-weight: bold;',
            2 => 'color: #000000; font-weight: bold;',
            3 => 'color: #006600; font-weight: bold;',
            4 => 'color: #006600; font-weight: bold;',
            5 => 'color: #003399; font-weight: bold;',
            6 => 'color: #003399; font-weight: bold;',
            7 => 'color: #003399; font-weight: bold;',
            8 => 'color: #003399; font-weight: bold;',
            9 => 'color: #003399; font-weight: bold;',
            10 => 'color: #003399; font-weight: bold;',
            11 => 'color: #003399; font-weight: bold;',
            12 => 'color: #003399; font-weight: bold;'
        ],
        'COMMENTS' => [
            1 => 'color: #666666; font-style: italic;',
            //2 => 'color: #006699;',
            'MULTI' => 'color: #666666; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #009900;'
        ],
        'STRINGS' => [
            0 => 'color: #0000ff;'
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;'
        ],
        'METHODS' => [
            1 => 'color: #006633;',
            2 => 'color: #006633;'
        ],
        'SYMBOLS' => [
            0 => 'color: #339933;',
            1 => 'color: #000000; font-weight: bold;'
        ],
        'SCRIPT' => [
        ],
        'REGEXPS' => [
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
        6 => '',
        7 => '',
        8 => '',
        9 => '',
        10 => '',
        11 => '',
        12 => ''
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [],
    'REGEXPS' => [
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ]
];
