<?php
/*************************************************************************************
 * xml.php
 * -------
 * Author: Nigel McNie (nigel@geshi.org)
 * Copyright: (c) 2004 Nigel McNie (http://qbnz.com/highlighter/)
 * Release Version: 1.0.8.3
 * Date Started: 2004/09/01
 *
 * XML language file for GeSHi. Based on the idea/file by Christian Weiske
 *
 * CHANGES
 * -------
 * 2008/05/23 (1.0.7.22)
 *   -  Added description of extra language features (SF#1970248)
 * 2005/12/28 (1.0.2)
 *   -  Removed escape character for strings
 * 2004/11/27 (1.0.1)
 *   -  Added support for multiple object splitters
 * 2004/10/27 (1.0.0)
 *   -  First Release
 *
 * TODO (updated 2004/11/27)
 * -------------------------
 * * Check regexps work and correctly highlight XML stuff and nothing else
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
    'LANG_NAME' => 'XML',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'", '"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
    ],
    'SYMBOLS' => [
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
        ],
        'COMMENTS' => [
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
        'SCRIPT' => [
            -1 => 'color: #808080; font-style: italic;', // comments
            0 => 'color: #00bbdd;',
            1 => 'color: #ddbb00;',
            2 => 'color: #339933;',
            3 => 'color: #009900;'
        ],
        'REGEXPS' => [
            0 => 'color: #000066;',
            1 => 'color: #000000; font-weight: bold;',
            2 => 'color: #000000; font-weight: bold;'
        ]
    ],
    'URLS' => [
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'REGEXPS' => [
        0 => [//attribute names
            GESHI_SEARCH => '([a-z_:][\w\-\.:]*)(=)',
            GESHI_REPLACE => '\\1',
            GESHI_MODIFIERS => 'i',
            GESHI_BEFORE => '',
            GESHI_AFTER => '\\2'
        ],
        1 => [//Initial header line
            GESHI_SEARCH => '(&lt;[\/?|(\?xml)]?[a-z_:][\w\-\.:]*(\??&gt;)?)',
            GESHI_REPLACE => '\\1',
            GESHI_MODIFIERS => 'i',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        2 => [//Tag end markers
            GESHI_SEARCH => '(([\/|\?])?&gt;)',
            GESHI_REPLACE => '\\1',
            GESHI_MODIFIERS => 'i',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
    ],
    'STRICT_MODE_APPLIES' => GESHI_ALWAYS,
    'SCRIPT_DELIMITERS' => [
        -1 => [
            '<!--' => '-->'
        ],
        0 => [
            '<!DOCTYPE' => '>'
        ],
        1 => [
            '&' => ';'
        ],
        2 => [
            '<![CDATA[' => ']]>'
        ],
        3 => [
            '<' => '>'
        ]
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
        -1 => false,
        0 => false,
        1 => false,
        2 => false,
        3 => true
    ],
    'TAB_WIDTH' => 2,
    'PARSER_CONTROL' => [
        'ENABLE_FLAGS' => [
            'NUMBERS' => GESHI_NEVER
        ]
    ]
];
