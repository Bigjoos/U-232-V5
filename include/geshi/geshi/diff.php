<?php
/*************************************************************************************
 * diff.php
 * --------
 * Author: Conny Brunnkvist (conny@fuchsia.se), W. Tasin (tasin@fhm.edu)
 * Copyright: (c) 2004 Fuchsia Open Source Solutions (http://www.fuchsia.se/)
 * Release Version: 1.0.8.3
 * Date Started: 2004/12/29
 *
 * Diff-output language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/05/23 (1.0.7.22)
 *  -  Added description of extra language features (SF#1970248)
 * 2006/02/27
 *  -  changing language file to use matching of start (^) and end ($) (wt)
 * 2004/12/29 (1.0.0)
 *  -  First Release
 *
 * TODO (updated 2006/02/27)
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
    'LANG_NAME' => 'Diff',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => [],
    'ESCAPE_CHAR' => ' ',
    'KEYWORDS' => [
        1 => [
            '\ No newline at end of file'
        ],
        //            2 => array(
        //                '***************' /* This only seems to works in some cases? */
        //            ),
    ],
    'SYMBOLS' => [
    ],
    'CASE_SENSITIVE' => [
        1 => false,
        //        2 => false
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #aaaaaa; font-style: italic;',
            //            2 => 'color: #dd6611;',
        ],
        'COMMENTS' => [
        ],
        'ESCAPE_CHAR' => [
            0 => ''
        ],
        'BRACKETS' => [
            0 => ''
        ],
        'STRINGS' => [
            0 => ''
        ],
        'NUMBERS' => [
            0 => ''
        ],
        'METHODS' => [
            0 => ''
        ],
        'SYMBOLS' => [
            0 => ''
        ],
        'SCRIPT' => [
            0 => ''
        ],
        'REGEXPS' => [
            0 => 'color: #440088;',
            1 => 'color: #991111;',
            2 => 'color: #00b000;',
            3 => 'color: #888822;',
            4 => 'color: #888822;',
            5 => 'color: #0011dd;',
            6 => 'color: #440088;',
            7 => 'color: #991111;',
            8 => 'color: #00b000;',
            9 => 'color: #888822;',
        ],
    ],
    'URLS' => [
        1 => '',
        //        2 => ''
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [],
    'REGEXPS' => [
        0 => "[0-9,]+[acd][0-9,]+",
        //Removed lines
        1 => [
            GESHI_SEARCH => '^\\&lt;.*$',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //Inserted lines
        2 => [
            GESHI_SEARCH => '^\\&gt;.*$',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //Location line
        3 => [
            GESHI_SEARCH => '^[\\-]{3}\\s.*$',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //Inserted line
        4 => [
            GESHI_SEARCH => '^(\\+){3}\\s.*$',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //Modified line
        5 => [
            GESHI_SEARCH => '^\\!.*$',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //File specification
        6 => [
            GESHI_SEARCH => '^[\\@]{2}.*$',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //Removed line
        7 => [
            GESHI_SEARCH => '^\\-.*$',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //Inserted line
        8 => [
            GESHI_SEARCH => '^\\+.*$',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        //File specification
        9 => [
            GESHI_SEARCH => '^(\\*){3}\\s.*$',
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ]
];
