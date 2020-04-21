<?php
/*************************************************************************************
 * mxml.php
 * -------
 * Author: David Spurr
 * Copyright: (c) 2007 David Spurr (http://www.defusion.org.uk/)
 * Release Version: 1.0.8.3
 * Date Started: 2007/10/04
 *
 * MXML language file for GeSHi. Based on the XML file by Nigel McNie
 *
 * CHANGES
 * -------
 * 2007/10/04 (1.0.7.22)
 *   -  First Release
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
    'LANG_NAME' => 'MXML',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => ['<!--' => '-->'],
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
        ],
        'SYMBOLS' => [
            0 => 'color: #66cc66;'
        ],
        'SCRIPT' => [
            0 => 'color: #00bbdd;',
            1 => 'color: #ddbb00;',
            2 => 'color: #339933;',
            3 => 'color: #000000;'
        ],
        'REGEXPS' => [
            0 => 'font-weight: bold; color: black;',
            1 => 'color: #7400FF;',
            2 => 'color: #7400FF;'
        ]
    ],
    'URLS' => [
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'REGEXPS' => [
        // xml declaration
        0 => [
            GESHI_SEARCH => '(&lt;[\/?|(\?xml)]?[a-z0-9_\-:]*(\?&gt;))',
            GESHI_REPLACE => '\\1',
            GESHI_MODIFIERS => 'i',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        // opening tags
        1 => [
            GESHI_SEARCH => '(&lt;\/?[a-z]+:[a-z]+)',
            GESHI_REPLACE => '\\1',
            GESHI_MODIFIERS => 'i',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        // closing tags
        2 => [
            GESHI_SEARCH => '(\/?&gt;)',
            GESHI_REPLACE => '\\1',
            GESHI_MODIFIERS => 'i',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ]
    ],
    'STRICT_MODE_APPLIES' => GESHI_ALWAYS,
    'SCRIPT_DELIMITERS' => [
        0 => [
            '<!DOCTYPE' => '>'
        ],
        1 => [
            '&' => ';'
        ],
        2 => [
            //'<![CDATA[' => ']]>'
            '<mx:Script>' => '</mx:Script>'
        ],
        3 => [
            '<' => '>'
        ]
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
        0 => false,
        1 => false,
        2 => false,
        3 => true
    ],
    'TAB_WIDTH' => 4
];
