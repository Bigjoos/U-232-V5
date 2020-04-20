<?php
/*************************************************************************************
 * whitespace.php
 * ----------
 * Author: Benny Baumann (BenBE@geshi.org)
 * Copyright: (c) 2008 Benny Baumann (http://qbnz.com/highlighter/)
 * Release Version: 1.0.8.3
 * Date Started: 2009/10/31
 *
 * Whitespace language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/10/31 (1.0.8.1)
 *   -  First Release
 *
 * TODO
 * ----
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
    'LANG_NAME' => 'Whitespace',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [],
    'COMMENT_REGEXP' => [
        3 => "/[^\n\x20\x09]+/s"
    ],
    'CASE_KEYWORDS' => GESHI_CAPS_UPPER,
    'QUOTEMARKS' => [],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
    ],
    'SYMBOLS' => [
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
        ],
        'COMMENTS' => [
            3 => 'color: #666666; font-style: italic;'
        ],
        'BRACKETS' => [
            0 => 'color: #66cc66;'
        ],
        'STRINGS' => [
            0 => 'color: #ff0000;'
        ],
        'NUMBERS' => [
        ],
        'METHODS' => [
        ],
        'SYMBOLS' => [
        ],
        'ESCAPE_CHAR' => [
        ],
        'SCRIPT' => [
        ],
        'REGEXPS' => [
            2 => 'background-color: #FF9999;',
            3 => 'background-color: #9999FF;'
        ]
    ],
    'URLS' => [
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'REGEXPS' => [
        2 => [
            GESHI_SEARCH => "(?<!\\A)\x20",
            GESHI_REPLACE => "&#32;",
            GESHI_MODIFIERS => 's',
            GESHI_BEFORE => "",
            GESHI_AFTER => ""
        ],
        3 => [
            GESHI_SEARCH => "\x09",
            GESHI_REPLACE => "&#9;",
            GESHI_MODIFIERS => 's',
            GESHI_BEFORE => "",
            GESHI_AFTER => ""
        ],
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 4,
    'PARSER_CONTROL' => [
        'ENABLE_FLAGS' => [
            'KEYWORDS' => GESHI_NEVER,
            'SYMBOLS' => GESHI_NEVER,
            'STRINGS' => GESHI_NEVER,
            //            'REGEXPS' => GESHI_NEVER,
            'NUMBERS' => GESHI_NEVER
        ]
    ]
];
