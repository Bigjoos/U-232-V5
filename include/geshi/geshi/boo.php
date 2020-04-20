<?php
/*************************************************************************************
 * boo.php
 * --------
 * Author: Marcus Griep (neoeinstein+GeSHi@gmail.com)
 * Copyright: (c) 2007 Marcus Griep (http://www.xpdm.us)
 * Release Version: 1.0.8.3
 * Date Started: 2007/09/10
 *
 * Boo language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2004/09/10 (1.0.8)
 *  -  First Release
 *
 * TODO (updated 2007/09/10)
 * -------------------------
 * Regular Expression Literal matching
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
    'LANG_NAME' => 'Boo',
    'COMMENT_SINGLE' => [1 => '//', 2 => '#'],
    'COMMENT_MULTI' => ['/*' => '*/'],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'''", "'", '"""', '"'],
    'HARDQUOTE' => ['"""', '"""'],
    'HARDESCAPE' => ['\"""'],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => [//Namespace
            'namespace', 'import', 'from'
        ],
        2 => [//Jump
            'yield', 'return', 'goto', 'continue', 'break'
        ],
        3 => [//Conditional
            'while', 'unless', 'then', 'in', 'if', 'for', 'else', 'elif'
        ],
        4 => [//Property
            'set', 'get'
        ],
        5 => [//Exception
            'try', 'raise', 'failure', 'except', 'ensure'
        ],
        6 => [//Visibility
            'public', 'private', 'protected', 'internal'
        ],
        7 => [//Define
            'struct', 'ref', 'of', 'interface', 'event', 'enum', 'do', 'destructor', 'def', 'constructor', 'class'
        ],
        8 => [//Cast
            'typeof', 'cast', 'as'
        ],
        9 => [//BiMacro
            'yieldAll', 'using', 'unchecked', 'rawArayIndexing', 'print', 'normalArrayIndexing', 'lock',
            'debug', 'checked', 'assert'
        ],
        10 => [//BiAttr
            'required', 'property', 'meta', 'getter', 'default'
        ],
        11 => [//BiFunc
            'zip', 'shellp', 'shellm', 'shell', 'reversed', 'range', 'prompt',
            'matrix', 'map', 'len', 'join', 'iterator', 'gets', 'enumerate', 'cat', 'array'
        ],
        12 => [//HiFunc
            '__switch__', '__initobj__', '__eval__', '__addressof__', 'quack'
        ],
        13 => [//Primitive
            'void', 'ushort', 'ulong', 'uint', 'true', 'timespan', 'string', 'single',
            'short', 'sbyte', 'regex', 'object', 'null', 'long', 'int', 'false', 'duck',
            'double', 'decimal', 'date', 'char', 'callable', 'byte', 'bool'
        ],
        14 => [//Operator
            'not', 'or', 'and', 'is', 'isa',
        ],
        15 => [//Modifier
            'virtual', 'transient', 'static', 'partial', 'override', 'final', 'abstract'
        ],
        16 => [//Access
            'super', 'self'
        ],
        17 => [//Pass
            'pass'
        ]
    ],
    'SYMBOLS' => [
        '[|', '|]', '${', '(', ')', '[', ']', '{', '}', '!', '@', '%', '&', '*', '|', '/', '<', '>', '+', '-', ';'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => true,
        2 => true,
        3 => true,
        4 => true,
        5 => true,
        6 => true,
        7 => true,
        8 => true,
        9 => true,
        10 => true,
        11 => true,
        12 => true,
        13 => true,
        14 => true,
        15 => true,
        16 => true,
        17 => true
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color:green;font-weight:bold;',
            2 => 'color:navy;',
            3 => 'color:blue;font-weight:bold;',
            4 => 'color:#8B4513;',
            5 => 'color:teal;font-weight:bold;',
            6 => 'color:blue;font-weight:bold;',
            7 => 'color:blue;font-weight:bold;',
            8 => 'color:blue;font-weight:bold;',
            9 => 'color:maroon;',
            10 => 'color:maroon;',
            11 => 'color:purple;',
            12 => 'color:#4B0082;',
            13 => 'color:purple;font-weight:bold;',
            14 => 'color:#008B8B;font-weight:bold;',
            15 => 'color:brown;',
            16 => 'color:black;font-weight:bold;',
            17 => 'color:gray;'
        ],
        'COMMENTS' => [
            1 => 'color: #999999; font-style: italic;',
            2 => 'color: #999999; font-style: italic;',
            'MULTI' => 'color: #008000; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #0000FF; font-weight: bold;',
            'HARD' => 'color: #0000FF; font-weight: bold;',
        ],
        'BRACKETS' => [
            0 => 'color: #006400;'
        ],
        'STRINGS' => [
            0 => 'color: #008000;',
            'HARD' => 'color: #008000;'
        ],
        'NUMBERS' => [
            0 => 'color: #00008B;'
        ],
        'METHODS' => [
            0 => 'color: 000000;',
            1 => 'color: 000000;'
        ],
        'SYMBOLS' => [
            0 => 'color: #006400;'
        ],
        'REGEXPS' => [
            #0 => 'color: #0066ff;'
        ],
        'SCRIPT' => [
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
        6 => '',
        7 => '',
        8 => '',
        9 => '',
        10 => '',
        11 => '',
        12 => '',
        13 => '',
        14 => '',
        15 => '',
        16 => '',
        17 => ''
    ],
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => [
        0 => '.',
        1 => '::'
    ],
    'REGEXPS' => [
        #0 => '%(@)?\/(?:(?(1)[^\/\\\\\r\n]+|[^\/\\\\\r\n \t]+)|\\\\[\/\\\\\w+()|.*?$^[\]{}\d])+\/%'
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 4
];
