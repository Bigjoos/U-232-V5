<?php
/*************************************************************************************
 * pascal.php
 * ----------
 * Author: Tux (tux@inamil.cz)
 * Copyright: (c) 2004 Tux (http://tux.a4.cz/), Nigel McNie (http://qbnz.com/highlighter)
 * Release Version: 1.0.8.3
 * Date Started: 2004/07/26
 *
 * Pascal language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/05/23 (1.0.7.22)
 *   -  Added description of extra language features (SF#1970248)
 * 2004/11/27 (1.0.2)
 *  -  Added support for multiple object splitters
 * 2004/10/27 (1.0.1)
 *   -  Added support for URLs
 * 2004/08/05 (1.0.0)
 *   -  Added support for symbols
 * 2004/07/27 (0.9.1)
 *   -  Pascal is OO language. Some new words.
 * 2004/07/26 (0.9.0)
 *   -  First Release
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
    'LANG_NAME' => 'Pascal',
    'COMMENT_SINGLE' => [1 => '//'],
    'COMMENT_MULTI' => ['{' => '}', '(*' => '*)'],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'HARDQUOTE' => ["'", "'"],
    'HARDESCAPE' => ["''"],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => [
            'absolute', 'asm', 'assembler', 'begin', 'break', 'case', 'catch', 'cdecl',
            'const', 'constructor', 'default', 'destructor', 'div', 'do', 'downto',
            'else', 'end', 'except', 'export', 'exports', 'external', 'far',
            'finalization', 'finally', 'for', 'forward', 'function', 'goto', 'if',
            'implementation', 'in', 'index', 'inherited', 'initialization', 'inline',
            'interface', 'interrupt', 'label', 'library', 'mod', 'name', 'not', 'of',
            'or', 'overload', 'override', 'private', 'procedure', 'program',
            'property', 'protected', 'public', 'published', 'raise', 'repeat',
            'resourcestring', 'shl', 'shr', 'stdcall', 'stored', 'switch', 'then',
            'to', 'try', 'type', 'unit', 'until', 'uses', 'var', 'while', 'xor'
        ],
        2 => [
            'nil', 'false', 'true',
        ],
        3 => [
            'abs', 'and', 'arc', 'arctan', 'blockread', 'blockwrite', 'chr', 'dispose',
            'cos', 'eof', 'eoln', 'exp', 'get', 'ln', 'new', 'odd', 'ord', 'ordinal',
            'pred', 'read', 'readln', 'sin', 'sqrt', 'succ', 'write', 'writeln'
        ],
        4 => [
            'ansistring', 'array', 'boolean', 'byte', 'bytebool', 'char', 'file',
            'integer', 'longbool', 'longint', 'object', 'packed', 'pointer', 'real',
            'record', 'set', 'shortint', 'smallint', 'string', 'union', 'word'
        ],
    ],
    'SYMBOLS' => [
        ',', ':', '=', '+', '-', '*', '/'
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
            1 => 'color: #000000; font-weight: bold;',
            2 => 'color: #000000; font-weight: bold;',
            3 => 'color: #000066;',
            4 => 'color: #000066; font-weight: bold;'
        ],
        'COMMENTS' => [
            1 => 'color: #666666; font-style: italic;',
            'MULTI' => 'color: #666666; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;',
            'HARD' => 'color: #000099; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #009900;'
        ],
        'STRINGS' => [
            0 => 'color: #ff0000;',
            'HARD' => 'color: #ff0000;'
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;'
        ],
        'METHODS' => [
            1 => 'color: #0066ee;'
        ],
        'SYMBOLS' => [
            0 => 'color: #339933;'
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
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => [
        1 => '.'
    ],
    'REGEXPS' => [
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 4
];
