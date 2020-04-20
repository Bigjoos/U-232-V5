<?php
/*************************************************************************************
 * vb.php
 * ------
 * Author: Roberto Rossi (rsoftware@altervista.org)
 * Copyright: (c) 2004 Roberto Rossi (http://rsoftware.altervista.org),
 *                     Nigel McNie (http://qbnz.com/highlighter)
 * Release Version: 1.0.8.3
 * Date Started: 2004/08/30
 *
 * Visual Basic language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/08/27 (1.0.8.1)
 *  -  changed keyword list for better Visual Studio compliance
 * 2008/08/26 (1.0.8.1)
 *  -  Fixed multiline comments
 * 2004/11/27 (1.0.1)
 *  -  Added support for multiple object splitters
 * 2004/08/30 (1.0.0)
 *  -  First Release
 *
 * TODO (updated 2004/11/27)
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
    'LANG_NAME' => 'Visual Basic',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [],
    'COMMENT_REGEXP' => [
        // Comments (either single or multiline with _
        1 => '/\'.*(?<! _)\n/sU',
    ],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            'AddressOf', 'Alias', 'And', 'Append', 'As', 'BF', 'Binary',
            'Boolean', 'ByRef', 'Byte', 'ByVal', 'Call', 'Case', 'CBool',
            'CByte', 'CCur', 'CDate', 'CDbl', 'CDec', 'CInt', 'CLng',
            'Close', 'Collection', 'Const', 'Control', 'CSng', 'CStr',
            'Currency', 'CVar', 'Date', 'Declare', 'Dim', 'Do', 'Double',
            'Each', 'Else', 'ElseIf', 'End', 'Enum', 'Erase', 'Error',
            'Event', 'Exit', 'Explicit', 'False', 'For', 'Friend',
            'Function', 'Get', 'GoSub', 'Goto', 'If', 'Implements', 'In',
            'Input', 'Integer', 'Is', 'LBound', 'Let', 'Lib', 'Like',
            'Line', 'Long', 'Loop', 'Mod', 'New', 'Next', 'Not',
            'Nothing', 'Object', 'On', 'Open', 'Option', 'Optional',
            'Or', 'Output', 'ParamArray', 'Preserve', 'Print', 'Private',
            'Property', 'Public', 'RaiseEvent', 'Random', 'ReDim',
            'Resume', 'Select', 'Set', 'Single', 'Static', 'Step',
            'Stop', 'String', 'Sub', 'Then', 'To', 'True', 'Type',
            'TypeOf', 'UBound', 'Until', 'Variant', 'While', 'With',
            'WithEvents', 'Xor'
        ]
    ],
    'SYMBOLS' => [
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #000080;'
        ],
        'COMMENTS' => [
            1 => 'color: #008000;'
        ],
        'BRACKETS' => [
        ],
        'STRINGS' => [
            0 => 'color: #800000;'
        ],
        'NUMBERS' => [
        ],
        'METHODS' => [
        ],
        'SYMBOLS' => [
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #800000; font-weight: bold;'
        ],
        'SCRIPT' => [
        ],
        'REGEXPS' => [
        ]
    ],
    'URLS' => [
        1 => ''
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
    ],
    'PARSER_CONTROL' => [
        'ENABLE_FLAGS' => [
            'BRACKETS' => GESHI_NEVER,
            'SYMBOLS' => GESHI_NEVER,
            'NUMBERS' => GESHI_NEVER
        ]
    ]
];
