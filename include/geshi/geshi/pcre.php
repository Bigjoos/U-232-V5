<?php
/*************************************************************************************
 * pcre.php
 * --------
 * Author: Benny Baumann (BenBE@geshi.org)
 * Copyright: (c) 2010 Benny Baumann (http://qbnz.com/highlighter/)
 * Release Version: 1.0.8.9
 * Date Started: 2010/05/22
 *
 * PCRE language file for GeSHi.
 *
 * NOTE: This language file handles plain PCRE expressions without delimiters.
 * If you want to highlight PCRE with delimiters you should use the
 * Perl language file instead.
 *
 * CHANGES
 * -------
 * 2010/05/22 (1.0.8.8)
 *   -  First Release
 *
 * TODO (updated 2010/05/22)
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
    'LANG_NAME' => 'PCRE',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [
    ],
    'COMMENT_REGEXP' => [
        // Non-matching groups
        1 => "/(?<=\()\?(?::|(?=\())/",

        // Modifier groups
        2 => "/(?<=\()\?[cdegimopsuxUX\-]+(?::|(?=\)))/",

        // Look-Aheads
        3 => "/(?<=\()\?[!=]/",

        // Look-Behinds
        4 => "/(?<=\()\?<[!=]/",

        // Forward Matching
        5 => "/(?<=\()\?>/",

        // Recursive Matching
        6 => "/(?<=\()\?R(?=\))/",

        // Named Subpattern
        7 => "/(?<=\()\?(?:P?<\w+>|\d+(?=\))|P[=>]\w+(?=\)))/",

        // Back Reference
        8 => "/\\\\(?:[1-9]\d?|g\d+|g\{(?:-?\d+|\w+)\}|k<\w+>|k'\w+'|k\{\w+\})/",

        // Byte sequence: Octal
        9 => "/\\\\[0-7]{2,3}/",

        // Byte sequence: Hex
        10 => "/\\\\x[0-9a-fA-F]{2}/",

        // Byte sequence: Hex
        11 => "/\\\\u[0-9a-fA-F]{4}/",

        // Byte sequence: Hex
        12 => "/\\\\U[0-9a-fA-F]{8}/",

        // Byte sequence: Unicode
        13 => "/\\\\[pP]\{[^}\n]+\}/",

        // One-Char Escapes
        14 => "/\\\\[abdefnrstvwzABCDGSWXZ\\\\\\.\[\]\(\)\{\}\^\\\$\?\+\*]/",

        // Byte sequence: Control-X sequence
        15 => "/\\\\c./",

        // Quantifier
        16 => "/\{(?:\d+,?|\d*,\d+)\}/",

        // Comment Subpattern
        17 => "/(?<=\()\?#[^\)]*/",
    ],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => [],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
    ],
    'SYMBOLS' => [
        0 => ['.'],
        1 => ['(', ')'],
        2 => ['[', ']', '|'],
        3 => ['^', '$'],
        4 => ['?', '+', '*'],
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
        ],
        'COMMENTS' => [
            1 => 'color: #993333; font-weight: bold;',
            2 => 'color: #cc3300; font-weight: bold;',
            3 => 'color: #cc0066; font-weight: bold;',
            4 => 'color: #cc0066; font-weight: bold;',
            5 => 'color: #cc6600; font-weight: bold;',
            6 => 'color: #cc00cc; font-weight: bold;',
            7 => 'color: #cc9900; font-weight: bold; font-style: italic;',
            8 => 'color: #cc9900; font-style: italic;',
            9 => 'color: #669933; font-style: italic;',
            10 => 'color: #339933; font-style: italic;',
            11 => 'color: #339966; font-style: italic;',
            12 => 'color: #339999; font-style: italic;',
            13 => 'color: #663399; font-style: italic;',
            14 => 'color: #999933; font-style: italic;',
            15 => 'color: #993399; font-style: italic;',
            16 => 'color: #333399; font-style: italic;',
            17 => 'color: #666666; font-style: italic;',
            'MULTI' => 'color: #666666; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;',
            'HARD' => 'color: #000099; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #009900;'
        ],
        'STRINGS' => [
            0 => 'color: #ff0000;',
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;'
        ],
        'METHODS' => [
            1 => 'color: #006600;',
            2 => 'color: #006600;'
        ],
        'SYMBOLS' => [
            0 => 'color: #333399; font-weight: bold;',
            1 => 'color: #993333; font-weight: bold;',
            2 => 'color: #339933; font-weight: bold;',
            3 => 'color: #333399; font-weight: bold;',
            4 => 'color: #333399; font-style: italic;'
        ],
        'REGEXPS' => [
        ],
        'SCRIPT' => [
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
    'PARSER_CONTROL' => [
        'ENABLE_FLAGS' => [
            'BRACKETS' => GESHI_NEVER,
            'NUMBERS' => GESHI_NEVER
        ]
    ]
];
