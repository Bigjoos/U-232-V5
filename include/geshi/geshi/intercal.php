<?php
/*************************************************************************************
 * intercal.php
 * ----------
 * Author: Benny Baumann (BenBE@geshi.org)
 * Copyright: (c) 2008 Benny Baumann (http://qbnz.com/highlighter/)
 * Release Version: 1.0.8.3
 * Date Started: 2009/10/31
 *
 * INTERCAL language file for GeSHi.
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
    'LANG_NAME' => 'INTERCAL',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [],
    'COMMENT_REGEXP' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_UPPER,
    'QUOTEMARKS' => [],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        //Politeness
        1 => [
            'DO', 'DOES', 'DONT', 'DON\'T', 'NOT', 'PLEASE', 'PLEASENT', 'PLEASEN\'T', 'MAYBE'
        ],
        //Statements
        2 => [
            'STASH', 'RETRIEVE', 'NEXT', 'RESUME', 'FORGET', 'ABSTAIN', 'ABSTAINING',
            'COME', 'FROM', 'CALCULATING', 'REINSTATE', 'IGNORE', 'REMEMBER',
            'WRITE', 'IN', 'READ', 'OUT', 'GIVE', 'UP'
        ]
    ],
    'SYMBOLS' => [
        '.', ',', ':', ';', '#',
        '~', '$', '&', '?',
        '\'', '"', '<-'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #000080; font-weight: bold;',
            2 => 'color: #000080; font-weight: bold;'
        ],
        'COMMENTS' => [
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
            0 => 'color: #66cc66;'
        ],
        'ESCAPE_CHAR' => [
        ],
        'SCRIPT' => [
        ],
        'REGEXPS' => [
            1 => 'color: #808080; font-style: italic;'
        ]
    ],
    'URLS' => [
        1 => '',
        2 => ''
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'REGEXPS' => [
        1 => '^\(\d+\)'
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 4,
    'PARSER_CONTROL' => [
        'ENABLE_FLAGS' => [
            'COMMENTS' => GESHI_NEVER,
            'STRINGS' => GESHI_NEVER,
            'NUMBERS' => GESHI_NEVER
        ]
    ]
];
