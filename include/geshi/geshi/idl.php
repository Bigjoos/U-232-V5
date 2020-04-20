<?php
/*************************************************************************************
 * idl.php
 * -------
 * Author: Cedric Bosdonnat (cedricbosdo@openoffice.org)
 * Copyright: (c) 2006 Cedric Bosdonnat
 * Release Version: 1.0.8.3
 * Date Started: 2006/08/20
 *
 * Unoidl language file for GeSHi.
 *
 * 2006/08/20 (1.0.0)
 *  -  First Release
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
    'LANG_NAME' => 'Uno Idl',
    'COMMENT_SINGLE' => [1 => '//', 2 => '#'],
    'COMMENT_MULTI' => ['/*' => '*/'],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'", '"'],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => [
            'published', 'get', 'set', 'service', 'singleton', 'type', 'module', 'interface', 'struct',
            'const', 'constants', 'exception', 'enum', 'raises', 'typedef'
        ],
        2 => [
            'bound', 'maybeambiguous', 'maybedefault', 'maybevoid', 'oneway', 'optional',
            'readonly', 'in', 'out', 'inout', 'attribute', 'transient', 'removable'
        ],
        3 => [
            'True', 'False', 'TRUE', 'FALSE'
        ],
        4 => [
            'string', 'long', 'byte', 'hyper', 'boolean', 'any', 'char', 'double',
            'void', 'sequence', 'unsigned'
        ],
    ],
    'SYMBOLS' => [
        '(', ')', '{', '}', '[', ']', '=', '+', '-', '*', '/', '!', '%', '^', '&', ':', ';', '...'
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
            1 => 'color: #990078; font-weight: bold',
            2 => 'color: #36dd1c;',
            3 => 'color: #990078; font-weight: bold',
            4 => 'color: #0000ec;'
        ],
        'COMMENTS' => [
            1 => 'color: #3f7f5f;',
            2 => 'color: #808080;',
            'MULTI' => 'color: #4080ff; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #666666; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #808080;'
        ],
        'STRINGS' => [
            0 => 'color: #ff0000;'
        ],
        'NUMBERS' => [
            0 => 'color: #0000dd;'
        ],
        'METHODS' => [
        ],
        'SYMBOLS' => [
            0 => 'color: #66cc66;'
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
        1 => '::'
    ],
    'REGEXPS' => [
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ]
];
