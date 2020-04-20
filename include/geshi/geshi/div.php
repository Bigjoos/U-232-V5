<?php
/*************************************************************************************
 * div.php
 * ---------------------------------
 * Author: Gabriel Lorenzo (ermakina@gmail.com)
 * Copyright: (c) 2005 Gabriel Lorenzo (http://ermakina.gazpachito.net)
 * Release Version: 1.0.8.3
 * Date Started: 2005/06/19
 *
 * DIV language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2005/06/22 (1.0.0)
 *  -  First Release, includes "2nd gen" ELSEIF statement
 *
 * TODO (updated 2005/06/22)
 * -------------------------
 *  -  I'm pretty satisfied with this, so nothing for now... :P
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
    'LANG_NAME' => 'DIV',
    'COMMENT_SINGLE' => [1 => '//'],
    'COMMENT_MULTI' => ['/*' => '*/'],
    'CASE_KEYWORDS' => GESHI_CAPS_UPPER,
    'QUOTEMARKS' => ["'", '"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            'while', 'until', 'to', 'switch', 'step', 'return', 'repeat', 'loop', 'if', 'from', 'frame', 'for', 'end', 'elseif',
            'else', 'default', 'debug', 'continue', 'clone', 'case', 'break', 'begin'
        ],
        2 => [
            'xor', 'whoami', 'type', 'sizeof', 'pointer', 'or', 'offset', 'not', 'neg', 'mod', 'id', 'dup', 'and', '_ne', '_lt',
            '_le', '_gt', '_ge', '_eq'
        ],
        3 => [
            'setup_program', 'program', 'process', 'private', 'local', 'import', 'global', 'function', 'const',
            'compiler_options'
        ],
        4 => [
            'word', 'struct', 'string', 'int', 'byte'
        ],
    ],
    'SYMBOLS' => [
        '(', ')', '[', ']', '=', '+', '-', '*', '/', '!', '%', '^', '&', ':', ';', ',', '<', '>'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        3 => false,
        4 => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #0040b1;',
            2 => 'color: #000000;',
            3 => 'color: #000066; font-weight: bold;',
            4 => 'color: #993333;'
        ],
        'COMMENTS' => [
            1 => 'color: #808080; font-style: italic;',
            'MULTI' => 'color: #808080; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => ''
        ],
        'BRACKETS' => [
            0 => 'color: #44aa44;'
        ],
        'STRINGS' => [
            0 => 'color: #ff0000;'
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;'
        ],
        'METHODS' => [
            0 => 'color: #202020;',
        ],
        'SYMBOLS' => [
            0 => 'color: #44aa44;'
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
    'OBJECT_SPLITTERS' => [],
    'REGEXPS' => [
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ]
];
