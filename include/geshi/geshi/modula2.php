<?php
/****************************************************************************
 * modula2.php
 * -----------
 * Author: Benjamin Kowarsch (benjamin@modula2.net)
 * Copyright: (c) 2009 Benjamin Kowarsch (benjamin@modula2.net)
 * Release Version: 1.0.8.9
 * Date Started: 2009/11/05
 *
 * Modula-2 language file for GeSHi.
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
    'LANG_NAME' => 'Modula-2',
    'COMMENT_MULTI' => ['(*' => '*)'],
    'COMMENT_SINGLE' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'HARDQUOTE' => ["'", "'"],
    'HARDESCAPE' => ["''"],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => [ /* reserved words */
            'AND', 'ARRAY', 'BEGIN', 'BY', 'CASE', 'CONST', 'DEFINITION',
            'DIV', 'DO', 'ELSE', 'ELSIF', 'END', 'EXIT', 'EXPORT', 'FOR',
            'FROM', 'IF', 'IMPLEMENTATION', 'IMPORT', 'IN', 'LOOP', 'MOD',
            'MODULE', 'NOT', 'OF', 'OR', 'POINTER', 'PROCEDURE', 'QUALIFIED',
            'RECORD', 'REPEAT', 'RETURN', 'SET', 'THEN', 'TO', 'TYPE',
            'UNTIL', 'VAR', 'WHILE', 'WITH'
        ],
        2 => [ /* pervasive constants */
            'NIL', 'FALSE', 'TRUE',
        ],
        3 => [ /* pervasive types */
            'BITSET', 'CAP', 'CHR', 'DEC', 'DISPOSE', 'EXCL', 'FLOAT',
            'HALT', 'HIGH', 'INC', 'INCL', 'MAX', 'MIN', 'NEW', 'ODD', 'ORD',
            'SIZE', 'TRUNC', 'VAL'
        ],
        4 => [ /* pervasive functions and macros */
            'ABS', 'BOOLEAN', 'CARDINAL', 'CHAR', 'INTEGER',
            'LONGCARD', 'LONGINT', 'LONGREAL', 'PROC', 'REAL'
        ],
    ],
    'SYMBOLS' => [
        ',', ':', '=', '+', '-', '*', '/', '#', '~'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => true,
        2 => true,
        3 => true,
        4 => true,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #000000; font-weight: bold;',
            2 => 'color: #000000; font-weight: bold;',
            3 => 'color: #000066;',
            4 => 'color: #000066; font-weight: bold;'
        ],
        'COMMENTS' => [
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
            'HARD' => 'color: #ff0000;'
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;'
        ],
        'METHODS' => [
            1 => 'color: #0066ee;'
        ],
        'SYMBOLS' => [
            0 => 'color: #339933;'
        ],
        'REGEXPS' => [
        ],
        'SCRIPT' => [
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
        1 => ''
    ],
    'REGEXPS' => [
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 4
];
