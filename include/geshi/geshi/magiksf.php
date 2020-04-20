<?php
/*************************************************************************************
 * magiksf.php
 * --------
 * Author: Sjoerd van Leent (svanleent@gmail.com)
 * Copyright: (c) 2010 Sjoerd van Leent
 * Release Version: 1.0.8.9
 * Date Started: 2010/02/15
 *
 * MagikSF language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2010/02/22 (1.0.0.2)
 *   - Symbols also accept the ! and ? characters properly
 *   - Labels (identifiers starting with !) are also coloured
 * 2010/02/17 (1.0.0.1)
 *   -  Parsing out symbols better
 *   -  Add package identifiers
 * 2010/02/15 (1.0.0)
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
    'ESCAPE_CHAR' => null,
    'LANG_NAME' => 'MagikSF',
    'COMMENT_SINGLE' => [1 => '##', 2 => '#%', 3 => '#'],
    'COMMENT_MULTI' => ["_pragma(" => ")"],
    //Multiline-continued single-line comments
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'", '"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            '_block', '_endblock', '_proc', '_endproc', '_loop', '_endloop',
            '_method', '_endmethod',
            '_protect', '_endprotect', '_protection', '_locking',
            '_continue',
        ],
        2 => [
            '_self', '_thisthread', '_pragma', '_private', '_abstract',
            '_local', '_global', '_dynamic', '_package', '_constant',
            '_import', '_iter', '_lock', '_optional', '_recursive', '_super'
        ],
        3 => [
            '_if', '_endif', '_then', '_else', '_elif', '_orif', '_andif', '_for', '_over',
            '_try', '_endtry', '_when', '_throw', '_catch', '_endcatch', '_handling',
            '_finally', '_loopbody', '_return', '_leave', '_with'
        ],
        4 => [
            '_false', '_true', '_maybe', '_unset', '_no_way'
        ],
        5 => [
            '_mod', '_div', '_or', '_and', '_cf', '_is', '_isnt', '_not', '_gather', '_scatter',
            '_allresults', '_clone', '_xor'
        ],
        6 => [
            'def_slotted_exemplar', 'write_string', 'write', 'condition',
            'record_transaction', 'gis_program_manager', 'perform', 'define_shared_constant',
            'property_list', 'rope', 'def_property', 'def_mixin'
        ],
    ],
    'SYMBOLS' => [
        '(', ')', '{', '}', '[', ']',
        '+', '-', '*', '/', '**',
        '=', '<', '>', '<<', '>>',
        ',', '$',
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        3 => false,
        4 => false,
        5 => false,
        6 => false
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #000000; font-weight: bold;',
            2 => 'color: #ff3f3f;',
            3 => 'color: #3f7f3f; font-weight: bold;',
            4 => 'color: #cc66cc;',
            5 => 'color: #ff3fff; font-weight: bold;',
            6 => 'font-weight: bold;',
        ],
        'COMMENTS' => [
            1 => 'color: #339933; font-weight: bold;',
            2 => 'color: #993333;',
            3 => 'color: #339933;',
            'MULTI' => 'color: #7f7f7f; font-style: italic',
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #ff3f3f;'
        ],
        'STRINGS' => [
            0 => 'color: #ff0000;'
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;'
        ],
        'METHODS' => [
            1 => 'color: #202020;',
            2 => 'color: #202020;'
        ],
        'SYMBOLS' => [
            0 => 'color: #ff3f3f;'
        ],
        'REGEXPS' => [
            1 => 'color: #3f3fff;',
            2 => 'color: #3f3fff;',
            3 => 'color: #cc66cc;',
            4 => 'color: #7f3f7f; font-style: italic;',
        ],
        'SCRIPT' => [
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
        6 => ''
    ],
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => [
        1 => '.'
    ],
    'REGEXPS' => [
        1 => [
            GESHI_SEARCH => '\b[a-zA-Z0-9_]+:', // package identifiers
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        2 => [
            GESHI_SEARCH => ':(?:[a-zA-Z0-9!?_]+|(?:[<pipe>].*?[<pipe>]))*', //symbols
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        3 => [
            GESHI_SEARCH => '%space|%tab|%newline|%.', //characters
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        4 => [
            GESHI_SEARCH => '@(?:[a-zA-Z0-9!?_]+|(?:[<pipe>].*?[<pipe>]))*', //symbols
            GESHI_REPLACE => '\\0',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 4
];
