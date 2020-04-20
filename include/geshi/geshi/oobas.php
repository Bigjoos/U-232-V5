<?php
/*************************************************************************************
 * oobas.php
 * ---------
 * Author: Roberto Rossi (rsoftware@altervista.org)
 * Copyright: (c) 2004 Roberto Rossi (http://rsoftware.altervista.org), Nigel McNie (http://qbnz.com/highlighter)
 * Release Version: 1.0.8.3
 * Date Started: 2004/08/30
 *
 * OpenOffice.org Basic language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/05/23 (1.0.7.22)
 *  -  Added description of extra language features (SF#1970248)
 * 2004/11/27 (1.0.1)
 *  -  Added support for multiple object splitters
 * 2004/10/27 (1.0.0)
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
    'LANG_NAME' => 'OpenOffice.org Basic',
    'COMMENT_SINGLE' => [1 => "'"],
    'COMMENT_MULTI' => [],
    //Single-Line comments using REM keyword
    'COMMENT_REGEXP' => [2 => '/\bREM.*?$/i'],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            'dim', 'private', 'public', 'global', 'as', 'if', 'redim', 'true', 'set', 'byval',
            'false', 'bool', 'double', 'integer', 'long', 'object', 'single', 'variant',
            'msgbox', 'print', 'inputbox', 'green', 'blue', 'red', 'qbcolor',
            'rgb', 'open', 'close', 'reset', 'freefile', 'get', 'input', 'line',
            'put', 'write', 'loc', 'seek', 'eof', 'lof', 'chdir', 'chdrive',
            'curdir', 'dir', 'fileattr', 'filecopy', 'filedatetime', 'fileexists',
            'filelen', 'getattr', 'kill', 'mkdir', 'name', 'rmdir', 'setattr',
            'dateserial', 'datevalue', 'day', 'month', 'weekday', 'year', 'cdatetoiso',
            'cdatefromiso', 'hour', 'minute', 'second', 'timeserial', 'timevalue',
            'date', 'now', 'time', 'timer', 'erl', 'err', 'error', 'on', 'goto', 'resume',
            'and', 'eqv', 'imp', 'not', 'or', 'xor', 'mod', 'atn', 'cos', 'sin', 'tan', 'log',
            'exp', 'rnd', 'randomize', 'sqr', 'fix', 'int', 'abs', 'sgn', 'hex', 'oct',
            'it', 'then', 'else', 'select', 'case', 'iif', 'do', 'loop', 'for', 'next', 'to',
            'while', 'wend', 'gosub', 'return', 'call', 'choose', 'declare',
            'end', 'exit', 'freelibrary', 'function', 'rem', 'stop', 'sub', 'switch', 'with',
            'cbool', 'cdate', 'cdbl', 'cint', 'clng', 'const', 'csng', 'cstr', 'defbool',
            'defdate', 'defdbl', 'defint', 'deflng', 'asc', 'chr', 'str', 'val', 'cbyte',
            'space', 'string', 'format', 'lcase', 'left', 'lset', 'ltrim', 'mid', 'right',
            'rset', 'rtrim', 'trim', 'ucase', 'split', 'join', 'converttourl', 'convertfromurl',
            'instr', 'len', 'strcomp', 'beep', 'shell', 'wait', 'getsystemticks', 'environ',
            'getsolarversion', 'getguitype', 'twipsperpixelx', 'twipsperpixely',
            'createunostruct', 'createunoservice', 'getprocessservicemanager',
            'createunodialog', 'createunolistener', 'createunovalue', 'thiscomponent',
            'globalscope'
        ]
    ],
    'SYMBOLS' => [
        '(', ')', '='
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #b1b100;'
        ],
        'COMMENTS' => [
            1 => 'color: #808080;',
            2 => 'color: #808080;'
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
            1 => 'color: #006600;'
        ],
        'SYMBOLS' => [
            0 => 'color: #66cc66;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099;'
        ],
        'SCRIPT' => [
        ],
        'REGEXPS' => [
        ]
    ],
    'URLS' => [
        1 => ''
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
    ]
];
