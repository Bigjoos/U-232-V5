<?php
/*************************************************************************************
 * pike.php
 * --------
 * Author: Rick E. (codeblock@eighthbit.net)
 * Copyright: (c) 2009 Rick E.
 * Release Version: 1.0.8.9
 * Date Started: 2009/12/10
 *
 * Pike language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2009/12/25 (1.0.8.6)
 *  -  First Release
 *
 * TODO (updated 2009/12/25)
 * -------------------------
 *
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
    'LANG_NAME' => 'Pike',
    'COMMENT_SINGLE' => [1 => '//'],
    'COMMENT_MULTI' => ['/*' => '*/'],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => [
            'goto', 'break', 'continue', 'return', 'case', 'default', 'if',
            'else', 'switch', 'while', 'foreach', 'do', 'for', 'gauge',
            'destruct', 'lambda', 'inherit', 'import', 'typeof', 'catch',
            'inline', 'nomask', 'private', 'protected', 'public', 'static'
        ]
    ],
    'SYMBOLS' => [
        1 => [
            '(', ')', '{', '}', '[', ']', '+', '-', '*', '/', '%', '=', '!', '&', '|', '?', ';'
        ]
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => true
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #b1b100;'
        ],
        'COMMENTS' => [
            1 => 'color: #666666; font-style: italic;',
            'MULTI' => 'color: #666666; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #009900;'
        ],
        'STRINGS' => [
            0 => 'color: #0000ff;'
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;',
        ],
        'METHODS' => [
            0 => 'color: #004000;'
        ],
        'SYMBOLS' => [
            1 => 'color: #339933;'
        ],
        'REGEXPS' => [],
        'SCRIPT' => []
    ],
    'URLS' => [1 => ''],
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => [1 => '.'],
    'REGEXPS' => [],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [],
    'HIGHLIGHT_STRICT_BLOCK' => []
];
