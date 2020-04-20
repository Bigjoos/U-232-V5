<?php
/*************************************************************************************
 * cfdg.php
 * --------
 * Author: John Horigan <john@glyphic.com>
 * Copyright: (c) 2006 John Horigan http://www.ozonehouse.com/john/
 * Release Version: 1.0.8.3
 * Date Started: 2006/03/11
 *
 * CFDG language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2006/03/11 (1.0.0)
 *  -  First Release
 *
 * TODO (updated 2006/03/11)
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
    'LANG_NAME' => 'CFDG',
    'COMMENT_SINGLE' => [1 => '//', 2 => '#'],
    'COMMENT_MULTI' => ['/*' => '*/'],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'", '"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            'include', 'startshape', 'rule', 'background'
        ],
        2 => [
            'SQUARE', 'CIRCLE', 'TRIANGLE',
        ],
        3 => [
            'b', 'brightness', 'h', 'hue', 'sat', 'saturation',
            'a', 'alpha', 'x', 'y', 'z', 's', 'size',
            'r', 'rotate', 'f', 'flip', 'skew', 'xml_set_object'
        ]
    ],
    'SYMBOLS' => [
        '[', ']', '{', '}', '*', '|'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        3 => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #717100;',
            2 => 'color: #000000; font-weight: bold;',
            3 => 'color: #006666;'
        ],
        'COMMENTS' => [
            1 => 'color: #808080; font-style: italic;',
            2 => 'color: #808080; font-style: italic;',
            'MULTI' => 'color: #808080; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #66cc66;'
        ],
        'STRINGS' => [
            0 => 'color: #ff0000;'
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;'
        ],
        'METHODS' => [
            1 => 'color: #006600;',
            2 => 'color: #006600;'
        ],
        'SYMBOLS' => [
            0 => 'color: #66cc66;'
        ],
        'REGEXPS' => [
        ],
        'SCRIPT' => [
            0 => '',
            1 => '',
            2 => '',
            3 => ''
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => ''
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
