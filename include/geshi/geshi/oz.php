<?php
/*************************************************************************************
 * oz.php
 * --------
 * Author: Wolfgang Meyer (Wolfgang.Meyer@gmx.net)
 * Copyright: (c) 2010 Wolfgang Meyer
 * Release Version: 1.0.8.9
 * Date Started: 2010/01/03
 *
 * Oz language file for GeSHi.
 *
 * CHANGES
 * -------
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
    'LANG_NAME' => 'OZ',
    'COMMENT_SINGLE' => [1 => '%'],
    'COMMENT_MULTI' => ['/*' => '*/'],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"', '\''],
    'ESCAPE_CHAR' => '\\',
    'NUMBERS' => [],
    'KEYWORDS' => [
        1 => [
            'declare', 'local', 'in', 'end', 'proc', 'fun', 'functor', 'require', 'prepare',
            'import', 'export', 'define', 'at', 'case', 'then', 'else', 'of', 'elseof',
            'elsecase', 'if', 'elseif', 'class', 'from', 'prop', 'attr', 'feat', 'meth',
            'self', 'true', 'false', 'unit', 'div', 'mod', 'andthen', 'orelse', 'cond', 'or',
            'dis', 'choice', 'not', 'thread', 'try', 'catch', 'finally', 'raise', 'lock',
            'skip', 'fail', 'for', 'do'
        ]
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => true
    ],
    'SYMBOLS' => [
        '@', '!', '|', '<-', ':=', '<', '>', '=<', '>=', '<=', '#', '~', '.',
        '*', '-', '+', '/', '<:', '>:', '=:', '=<:', '>=:', '\\=', '\\=:', ',',
        '!!', '...', '==', '::', ':::'
    ],
    'STYLES' => [
        'REGEXPS' => [
            1 => 'color: #0000ff;',
            2 => 'color: #00a030;',
            3 => 'color: #bc8f8f;',
            4 => 'color: #0000ff;',
            5 => 'color: #a020f0;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #bc8f8f;'
        ],
        'KEYWORDS' => [
            1 => 'color: #a020f0;'
        ],
        'COMMENTS' => [
            1 => 'color: #B22222;',
            'MULTI' => 'color: #B22222;'
        ],
        'STRINGS' => [
            0 => 'color: #bc8f8f;'
        ],
        'SYMBOLS' => [
            0 => 'color: #a020f0;'
        ],
        'BRACKETS' => [],
        'NUMBERS' => [],
        'METHODS' => [],
        'SCRIPT' => []
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [],
    'STRICT_MODE_APPLIES' => GESHI_MAYBE,
    'SCRIPT_DELIMITERS' => [],
    'HIGHLIGHT_STRICT_BLOCK' => [],
    'URLS' => [
        1 => ''
    ],
    'REGEXPS' => [
        // function and procedure definition
        1 => [
            GESHI_SEARCH => "(proc|fun)([^{}\n\)]*)(\\{)([\$A-Z\300-\326\330-\336][A-Z\300-\326\330-\336a-z\337-\366\370-\3770-9_.]*)",
            GESHI_REPLACE => '\4',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '\1\2\3',
            GESHI_AFTER => ''
        ],
        // class definition
        2 => [
            GESHI_SEARCH => "(class)([^A-Z\$]*)([\$A-Z\300-\326\330-\336][A-Z\300-\326\330-\336a-z\337-\366\370-\3770-9_.]*)",
            GESHI_REPLACE => '\3\4',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '\1\2',
            GESHI_AFTER => ''
        ],
        // single character
        3 => [
            GESHI_SEARCH => "&amp;.",
            GESHI_REPLACE => '\0',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        // method definition
        4 => [
            GESHI_SEARCH => "(meth)([^a-zA-Z]+)([a-zA-Z\300-\326\330-\336][A-Z\300-\326\330-\336a-z\337-\366\370-\3770-9]*)",
            GESHI_REPLACE => '\3',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '\1\2',
            GESHI_AFTER => ''
        ],
        // highlight "[]"
        // ([] is actually a keyword, but that causes problems in validation; putting it into symbols doesn't work.)
        5 => [
            GESHI_SEARCH => "\[\]",
            GESHI_REPLACE => '\0',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ]
    ]
];
