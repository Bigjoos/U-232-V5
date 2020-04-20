<?php
/*************************************************************************************
 * vala.php
 * ----------
 * Author: Nicolas Joseph (nicolas.joseph@valaide.org)
 * Copyright: (c) 2009 Nicolas Joseph
 * Release Version: 1.0.8.9
 * Date Started: 2009/04/29
 *
 * Vala language file for GeSHi.
 *
 * CHANGES
 * -------
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
    'LANG_NAME' => 'Vala',
    'COMMENT_SINGLE' => [1 => '//'],
    'COMMENT_MULTI' => ['/*' => '*/'],
    'COMMENT_REGEXP' => [
        //Using and Namespace directives (basic support)
        //Please note that the alias syntax for using is not supported
        3 => '/(?:(?<=using[\\n\\s])|(?<=namespace[\\n\\s]))[\\n\\s]*([a-zA-Z0-9_]+\\.)*[a-zA-Z0-9_]+[\n\s]*(?=[;=])/i'],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'", '"'],
    'HARDQUOTE' => ['"""'],
    'HARDESCAPE' => ['"'],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => [
            'as', 'abstract', 'base', 'break', 'case', 'catch', 'const',
            'construct', 'continue', 'default', 'delete', 'dynamic', 'do',
            'else', 'ensures', 'extern', 'false', 'finally', 'for', 'foreach',
            'get', 'if', 'in', 'inline', 'internal', 'lock', 'namespace',
            'null', 'out', 'override', 'private', 'protected', 'public', 'ref',
            'requires', 'return', 'set', 'static', 'switch', 'this', 'throw',
            'throws', 'true', 'try', 'using', 'value', 'var', 'virtual',
            'volatile', 'void', 'yield', 'yields', 'while'
        ],
        2 => [
            '#elif', '#endif', '#else', '#if'
        ],
        3 => [
            'is', 'new', 'owned', 'sizeof', 'typeof', 'unchecked', 'unowned', 'weak'
        ],
        4 => [
            'bool', 'char', 'class', 'delegate', 'double', 'enum',
            'errordomain', 'float', 'int', 'int8', 'int16', 'int32', 'int64',
            'interface', 'long', 'short', 'signal', 'size_t', 'ssize_t',
            'string', 'struct', 'uchar', 'uint', 'uint8', 'uint16', 'uint32',
            'ulong', 'unichar', 'ushort'
        ]
    ],
    'SYMBOLS' => [
        '+', '-', '*', '?', '=', '/', '%', '&', '>', '<', '^', '!', ':', ';',
        '(', ')', '{', '}', '[', ']', '|'
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
            1 => 'color: #0600FF;',
            2 => 'color: #FF8000; font-weight: bold;',
            3 => 'color: #008000;',
            4 => 'color: #FF0000;'
        ],
        'COMMENTS' => [
            1 => 'color: #008080; font-style: italic;',
            3 => 'color: #008080;',
            'MULTI' => 'color: #008080; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #008080; font-weight: bold;',
            'HARD' => 'color: #008080; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #000000;'
        ],
        'STRINGS' => [
            0 => 'color: #666666;',
            'HARD' => 'color: #666666;'
        ],
        'NUMBERS' => [
            0 => 'color: #FF0000;'
        ],
        'METHODS' => [
            1 => 'color: #0000FF;',
            2 => 'color: #0000FF;'
        ],
        'SYMBOLS' => [
            0 => 'color: #008000;'
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
    'TAB_WIDTH' => 4,
    'PARSER_CONTROL' => [
        'KEYWORDS' => [
            'DISALLOWED_BEFORE' => "(?<![a-zA-Z0-9\$_\|\#>|^])",
            'DISALLOWED_AFTER' => "(?![a-zA-Z0-9_<\|%\\-])"
        ]
    ]
];
