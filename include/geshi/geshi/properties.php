<?php
/*************************************************************************************
 * properties.php
 * --------
 * Author: Edy Hinzen
 * Copyright: (c) 2009 Edy Hinzen
 * Release Version: 1.0.8.9
 * Date Started: 2009/04/03
 *
 * Property language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/04/03 (1.0.0)
 *   -  First Release
 *
 * TODO
 * -------------------------
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
    'LANG_NAME' => 'PROPERTIES',
    'COMMENT_SINGLE' => [1 => '#'],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        /* Common used variables */
        1 => [
            '${user.home}'
        ],
    ],
    'SYMBOLS' => [
        '[', ']', '='
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => true
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'font-weight: bold;',
        ],
        'COMMENTS' => [
            1 => 'color: #808080; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => ''
        ],
        'BRACKETS' => [
            0 => ''
        ],
        'STRINGS' => [
            0 => 'color: #933;'
        ],
        'NUMBERS' => [
            0 => ''
        ],
        'METHODS' => [
            0 => ''
        ],
        'SYMBOLS' => [
            0 => 'color: #000000;'
        ],
        'REGEXPS' => [
            0 => 'color: #000080; font-weight:bold;',
            1 => 'color: #008000; font-weight:bold;'
        ],
        'SCRIPT' => [
            0 => ''
        ]
    ],
    'URLS' => [
        1 => ''
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'REGEXPS' => [
        //Entry names
        0 => [
            GESHI_SEARCH => '^(\s*)([.a-zA-Z0-9_\-]+)(\s*=)',
            GESHI_REPLACE => '\\2',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '\\1',
            GESHI_AFTER => '\\3'
        ],
        //Entry values
        1 => [
            // Evil hackery to get around GeSHi bug: <>" and ; are added so <span>s can be matched
            // Explicit match on variable names because if a comment is before the first < of the span
            // gets chewed up...
            GESHI_SEARCH => '([<>";a-zA-Z0-9_]+\s*)=(.*)',
            GESHI_REPLACE => '\\2',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '\\1=',
            GESHI_AFTER => ''
        ]
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ]
];
