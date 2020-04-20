<?php
/*************************************************************************************
 * lolcode.php
 * ----------
 * Author: Benny Baumann (BenBE@geshi.org)
 * Copyright: (c) 2008 Benny Baumann (http://qbnz.com/highlighter/)
 * Release Version: 1.0.8.3
 * Date Started: 2009/10/31
 *
 * LOLcode language file for GeSHi.
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
    'LANG_NAME' => 'LOLcode',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [],
    'COMMENT_REGEXP' => [
        1 => "/\bBTW\b.*$/im",
        2 => "/(^|\b)(?:OBTW\b.+?\bTLDR|LOL\b.+?\/LOL)(\b|$)/si"
    ],
    'CASE_KEYWORDS' => GESHI_CAPS_UPPER,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '',
    'ESCAPE_REGEXP' => [
        1 => '/:[)>o":]/',
        2 => '/:\([\da-f]+\)/i',
        3 => '/:\{\w+\}/i',
        4 => '/:\[\w+\]/i',
    ],
    'KEYWORDS' => [
        //Statements
        1 => [
            'VISIBLE', 'HAI', 'KTHX', 'KTHXBYE', 'SMOOSH', 'GIMMEH', 'PLZ',
            'ON', 'INVISIBLE', 'R', 'ITZ', 'GTFO', 'COMPLAIN', 'GIMME',

            'OPEN', 'FILE', 'I HAS A', 'AWSUM THX', 'O NOES', 'CAN', 'HAS', 'HAZ',
            'HOW DOES I', 'IF U SAY SO', 'FOUND YR', 'BORROW', 'OWN', 'ALONG',
            'WITH', 'WIT', 'LOOK', 'AT', 'AWSUM', 'THX'
        ],
        //Conditionals
        2 => [
            'IZ', 'YARLY', 'NOWAI', 'WTF?', 'MEBBE', 'OMG', 'OMGWTF',
            'ORLY?', 'OF', 'NOPE', 'SO', 'IM', 'MAI',

            'O RLY?', 'SUM', 'BOTH SAEM', 'DIFFRINT', 'BOTH', 'EITHER', 'WON',
            'DIFF', 'PRODUKT', 'QUOSHUNT', 'MOD', 'MKAY', 'OK', 'THING',
            'BIGNESS'
        ],
        //Repetition
        3 => [
            'IN', 'OUTTA', 'LOOP', 'WHILE'
        ],
        //Operators \Math
        4 => [
            'AN', 'AND', 'NOT', 'UP', 'YR', 'UPPIN', 'NERF', 'NERFIN', 'NERFZ',
            'SMASHING', 'UR', 'KINDA', 'LIKE', 'SAEM', 'BIG', 'SMALL',
            'BIGGR', 'SMALLR', 'BIGGER', 'SMALLER', 'GOOD', 'CUTE', 'THAN'
        ]
    ],
    'SYMBOLS' => [
        '.', ',', '?',
        '!!'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        3 => false,
        4 => false
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #008000;',
            2 => 'color: #000080;',
            3 => 'color: #000080;',
            4 => 'color: #800000;'
        ],
        'COMMENTS' => [
            1 => 'color: #666666; style: italic;',
            2 => 'color: #666666; style: italic;'
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
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => '',
        4 => ''
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
    'PARSER_CONTROL' => [
        'KEYWORDS' => [
            'SPACE_AS_WHITESPACE' => true
        ]
    ],
    'TAB_WIDTH' => 4
];
