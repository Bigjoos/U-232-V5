<?php
/*************************************************************************************
 * hicest.php
 * --------
 * Author: Georg Petrich (spt@hicest.com)
 * Copyright: (c) 2010 Georg Petrich (http://www.HicEst.com)
 * Release Version: 1.0.8.9
 * Date Started: 2010/03/15
 *
 * HicEst language file for GeSHi.
 *
 * CHANGES
 * -------
 * yyyy/mm/dd (v.v.v.v)
 *  -  First Release
 *
 * TODO (updated yyyy/mm/dd)
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
    'LANG_NAME' => 'HicEst',
    'COMMENT_SINGLE' => [1 => '!'],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"', '\''],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            '$cmd_line', 'abs', 'acos', 'alarm', 'alias', 'allocate', 'appendix', 'asin', 'atan', 'axis', 'beep',
            'call', 'ceiling', 'char', 'character', 'com', 'continue', 'cos', 'cosh', 'data', 'diffeq', 'dimension', 'dlg', 'dll',
            'do', 'edit', 'else', 'elseif', 'end', 'enddo', 'endif', 'exp', 'floor', 'function', 'fuz', 'goto', 'iand', 'ichar',
            'ieor', 'if', 'index', 'init', 'int', 'intpol', 'ior', 'key', 'len', 'len_trim', 'line', 'lock', 'log', 'max', 'maxloc',
            'min', 'minloc', 'mod', 'nint', 'not', 'open', 'pop', 'ran', 'read', 'real', 'return', 'rgb', 'roots', 'sign', 'sin',
            'sinh', 'solve', 'sort', 'subroutine', 'sum', 'system', 'tan', 'tanh', 'then', 'time', 'use', 'window', 'write', 'xeq'
        ]
    ],
    'SYMBOLS' => [
        1 => [
            '(', ')', '+', '-', '*', '/', '=', '<', '>', '!', '^', ':', ','
        ],
        2 => [
            '$', '$$'
        ]
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #ff0000;'
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
            1 => 'color: #339933;',
            2 => 'color: #ff0000;'
        ],
        'REGEXPS' => [],
        'SCRIPT' => []
    ],
    'URLS' => [1 => ''],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [],
    'REGEXPS' => [],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [],
    'HIGHLIGHT_STRICT_BLOCK' => []
];
