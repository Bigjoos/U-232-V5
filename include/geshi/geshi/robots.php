<?php
/*************************************************************************************
 * robots.php
 * --------
 * Author: Christian Lescuyer (cl@goelette.net)
 * Copyright: (c) 2006 Christian Lescuyer http://xtian.goelette.info
 * Release Version: 1.0.8.3
 * Date Started: 2006/02/17
 *
 * robots.txt language file for GeSHi.
 *
 * 2006/02/17 (1.0.0)
 *   -  First Release
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
    'LANG_NAME' => 'robots.txt',
    'COMMENT_SINGLE' => [1 => '#'],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => [],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            'User-agent', 'Disallow'
        ]
    ],
    'SYMBOLS' => [
        ':'
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
            1 => 'color: #808080; font-style: italic;',
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
        1 => 'http://www.robotstxt.org/wc/norobots.html'
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
    ]
];
