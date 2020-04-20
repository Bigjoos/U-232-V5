<?php
/*************************************************************************************
 * bf.php
 * ----------
 * Author: Benny Baumann (BenBE@geshi.org)
 * Copyright: (c) 2008 Benny Baumann (http://qbnz.com/highlighter/)
 * Release Version: 1.0.8.3
 * Date Started: 2009/10/31
 *
 * Brainfuck language file for GeSHi.
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
    'LANG_NAME' => 'Brainfuck',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [],
    'COMMENT_REGEXP' => [1 => '/[^\n+\-<>\[\]\.\,Y]+/s'],
    'CASE_KEYWORDS' => GESHI_CAPS_UPPER,
    'QUOTEMARKS' => [],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
    ],
    'SYMBOLS' => [
        0 => ['+', '-'],
        1 => ['[', ']'],
        2 => ['<', '>'],
        3 => ['.', ','],
        4 => ['Y'] //Brainfork Extension ;-)
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
        ],
        'COMMENTS' => [
            1 => 'color: #666666; font-style: italic;'
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
            0 => 'color: #006600;',
            1 => 'color: #660000;',
            2 => 'color: #000066;',
            3 => 'color: #660066;',
            4 => 'color: #666600;'
        ],
        'ESCAPE_CHAR' => [
        ],
        'SCRIPT' => [
        ],
        'REGEXPS' => [
        ]
    ],
    'URLS' => [
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'REGEXPS' => [
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 4,
    'PARSER_CONTROL' => [
        'ENABLE_FLAGS' => [
            'STRINGS' => GESHI_NEVER,
            'NUMBERS' => GESHI_NEVER
        ],
        'KEYWORDS' => [
            'DISALLOW_BEFORE' => '',
            'DISALLOW_AFTER' => ''
        ]
    ]
];
