<?php
/*************************************************************************************
 * modula3.php
 * ----------
 * Author: mbishop (mbishop@esoteriq.org)
 * Copyright: (c) 2009 mbishop (mbishop@esoteriq.org)
 * Release Version: 1.0.8.3
 * Date Started: 2009/01/21
 *
 * Modula-3 language file for GeSHi.
 *
 * CHANGES
 * -------
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
    'LANG_NAME' => 'Modula-3',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => ['(*' => '*)'],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'HARDQUOTE' => ["'", "'"],
    'HARDESCAPE' => ["''"],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => [
            'AND', 'ANY', 'ARRAY', 'AS', 'BEGIN', 'BITS', 'BRANDED', 'BY', 'CASE',
            'CONST', 'DIV', 'DO', 'ELSE', 'ELSIF', 'END', 'EVAL', 'EXCEPT', 'EXCEPTION',
            'EXIT', 'EXPORTS', 'FINALLY', 'FOR', 'FROM', 'GENERIC', 'IF', 'IMPORT', 'IN',
            'INTERFACE', 'LOCK', 'LOOP', 'METHODS', 'MOD', 'MODULE', 'NOT', 'OBJECT', 'OF',
            'OR', 'OVERRIDE', 'PROCEDURE', 'RAISE', 'RAISES', 'READONLY', 'RECORD', 'REF',
            'REPEAT', 'RETURN', 'REVEAL', 'ROOT', 'SET', 'THEN', 'TO', 'TRY', 'TYPE', 'TYPECASE',
            'UNSAFE', 'UNTIL', 'UNTRACED', 'VALUE', 'VAR', 'WHILE', 'WITH'
        ],
        2 => [
            'NIL', 'NULL', 'FALSE', 'TRUE',
        ],
        3 => [
            'ABS', 'ADR', 'ADRSIZE', 'BITSIZE', 'BYTESIZE', 'CEILING', 'DEC', 'DISPOSE',
            'EXTENDED', 'FIRST', 'FLOAT', 'FLOOR', 'INC', 'ISTYPE', 'LAST', 'LOOPHOLE', 'MAX', 'MIN',
            'NARROW', 'NEW', 'NUMBER', 'ORD', 'ROUND', 'SUBARRAY', 'TRUNC', 'TYPECODE', 'VAL'
        ],
        4 => [
            'ADDRESS', 'BOOLEAN', 'CARDINAL', 'CHAR', 'INTEGER',
            'LONGREAL', 'MUTEX', 'REAL', 'REFANY', 'TEXT'
        ],
    ],
    'SYMBOLS' => [
        ',', ':', '=', '+', '-', '*', '/', '#'
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
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => [
        1 => '.'
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
