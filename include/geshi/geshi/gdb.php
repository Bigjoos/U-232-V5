<?php
/*************************************************************************************
 * gdb.php
 * --------
 * Author: Milian Wolff (mail@milianw.de)
 * Copyright: (c) 2009 Milian Wolff
 * Release Version: 1.0.8.9
 * Date Started: 2009/06/24
 *
 * GDB language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2009/06/24 (1.0.0)
 *   -  First Release
 *
 * TODO (updated 2009/06/24)
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
    'LANG_NAME' => 'GDB',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        0 => [
            'Application',
            'signal',
        ],
        1 => [
            'Segmentation fault',
            '[KCrash Handler]',
        ],
    ],
    'NUMBERS' =>
        GESHI_NUMBER_INT_BASIC,
    'SYMBOLS' => [
    ],
    'CASE_SENSITIVE' => [
        0 => true,
        1 => true
    ],
    'STYLES' => [
        'KEYWORDS' => [
            0 => 'font-weight:bold;',
            1 => 'font-weight:bold; color: #ff0000;'
        ],
        'COMMENTS' => [
        ],
        'ESCAPE_CHAR' => [
            0 => ''
        ],
        'BRACKETS' => [
            0 => 'font-weight:bold;'
        ],
        'STRINGS' => [
            0 => 'color: #933;'
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;',
        ],
        'METHODS' => [
        ],
        'SYMBOLS' => [
        ],
        'REGEXPS' => [
            0 => 'color: #000066; font-weight:bold;',
            1 => 'color: #006600;',
            2 => 'color: #000066;',
            3 => 'color: #0066FF; text-style:italic;',
            4 => 'color: #80B5FF; text-style:italic;',
            5 => 'color: #A3007D;',
            6 => 'color: #FF00BF;',
            7 => 'font-weight: bold;'
        ],
        'SCRIPT' => [
        ]
    ],
    'URLS' => [
        0 => '',
        1 => ''
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'REGEXPS' => [
        //[Current Thread...], [KCrash Handler] etc.
        0 => [
            GESHI_SEARCH => '^\[.+\]',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //stack number
        1 => [
            GESHI_SEARCH => '^#\d+',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //Thread X (Thread...)
        2 => [
            GESHI_SEARCH => '^Thread \d.+$',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //Files with linenumbers
        3 => [
            GESHI_SEARCH => '(at )(.+)(:\d+\s*)$',
            GESHI_REPLACE => '\\2',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '\\1',
            GESHI_AFTER => '\\3'
        ],
        //Libs without linenumbers
        4 => [
            GESHI_SEARCH => '(from )(.+)(\s*)$',
            GESHI_REPLACE => '\\2',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '\\1',
            GESHI_AFTER => '\\3'
        ],
        //Hex mem address
        5 => '0x[a-f0-9]+',
        //Line numbers
        6 => [
            GESHI_SEARCH => '(:)(\d+)(\s*)$',
            GESHI_REPLACE => '\\2',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '\\1',
            GESHI_AFTER => '\\3'
        ],
        //Location
        7 => [
            GESHI_SEARCH => '( in )([^ \(\)]+)( \()',
            GESHI_REPLACE => '\\2',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '\\1',
            GESHI_AFTER => '\\3'
        ],
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ]
];
