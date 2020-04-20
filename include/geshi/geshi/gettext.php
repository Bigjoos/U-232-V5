<?php
/*************************************************************************************
 * gettext.php
 * --------
 * Author: Milian Wolff (mail@milianw.de)
 * Copyright: (c) 2008 Milian Wolff
 * Release Version: 1.0.8.3
 * Date Started: 2008/05/25
 *
 * GNU Gettext .po/.pot language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/08/02 (1.0.8)
 *  -  New comments: flags and previous-fields
 *  -  New keywords: msgctxt, msgid_plural
 *  -  Msgstr array indices
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
    'LANG_NAME' => 'GNU Gettext',
    'COMMENT_SINGLE' => ['#:', '#.', '#,', '#|', '#'],
    'COMMENT_MULTI' => [],
    'COMMENT_REGEXP' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'", '"'],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => ['msgctxt', 'msgid_plural', 'msgid', 'msgstr'],
    ],
    'SYMBOLS' => [],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => true,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #000000; font-weight: bold;'
        ],
        'COMMENTS' => [
            0 => 'color: #000099;',
            1 => 'color: #000099;',
            2 => 'color: #000099;',
            3 => 'color: #006666;',
            4 => 'color: #666666; font-style: italic;',
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;'
        ],
        'STRINGS' => [
            0 => 'color: #ff0000;'
        ],
        'REGEXPS' => [],
        'SYMBOLS' => [],
        'NUMBERS' => [
            0 => 'color: #000099;'
        ],
        'METHODS' => [],
        'SCRIPT' => [],
        'BRACKETS' => [
            0 => 'color: #000099;'
        ],
    ],
    'URLS' => [
        1 => ''
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [],
    'REGEXPS' => [],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 4,
];
