<?php
/*************************************************************************************
 * z80.php
 * -------
 * Author: Benny Baumann (BenBE@omorphia.de)
 * Copyright: (c) 2007-2008 Benny Baumann (http://www.omorphia.de/)
 * Release Version: 1.0.8.9
 * Date Started: 2007/02/06
 *
 * ZiLOG Z80 Assembler language file for GeSHi.
 * Syntax definition as commonly used with table assembler TASM32
 * This file will contain some undocumented opcodes.
 *
 * CHANGES
 * -------
 * 2008/05/23 (1.0.7.22)
 *   -  Added description of extra language features (SF#1970248)
 * 2007/06/03 (1.0.1)
 *   -  Fixed two typos in the language file
 * 2007/02/06 (1.0.0)
 *   -  First Release
 *
 * TODO (updated 2007/02/06)
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
    'LANG_NAME' => 'ZiLOG Z80 Assembler',
    'COMMENT_SINGLE' => [1 => ';'],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'", '"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        /*CPU*/
        1 => [
            'adc', 'add', 'and', 'bit', 'call', 'ccf', 'cp', 'cpd', 'cpdr', 'cpir', 'cpi',
            'cpl', 'daa', 'dec', 'di', 'djnz', 'ei', 'ex', 'exx', 'halt', 'im', 'in',
            'in0', 'inc', 'ind', 'indr', 'inir', 'ini', 'jp', 'jr', 'ld', 'ldd', 'lddr',
            'ldir', 'ldi', 'mlt', 'neg', 'nop', 'or', 'otdm', 'otdmr', 'otdr', 'otim',
            'otimr', 'otir', 'out', 'out0', 'outd', 'outi', 'pop', 'push', 'res', 'ret',
            'reti', 'retn', 'rl', 'rla', 'rlc', 'rlca', 'rld', 'rr', 'rra', 'rrc', 'rrca',
            'rrd', 'rst', 'sbc', 'scf', 'set', 'sla', 'sl1', 'sll', 'slp', 'sra', 'srl',
            'sub', 'tst', 'tstio', 'xor'
        ],
        /*registers*/
        2 => [
            'a', 'b', 'c', 'd', 'e', 'h', 'l',
            'af', 'bc', 'de', 'hl', 'ix', 'iy', 'sp',
            'af\'', 'ixh', 'ixl', 'iyh', 'iyl'
        ],
        /*Directive*/
        3 => [
            '#define', '#endif', '#else', '#ifdef', '#ifndef', '#include', '#undef',
            '.db', '.dd', '.df', '.dq', '.dt', '.dw', '.end', '.org', 'equ'
        ],
    ],
    'SYMBOLS' => [
        '[', ']', '(', ')', '?', '+', '-', '*', '/', '%', '$'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        3 => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #0000ff; font-weight:bold;',
            2 => 'color: #0000ff;',
            3 => 'color: #46aa03; font-weight:bold;'
        ],
        'COMMENTS' => [
            1 => 'color: #adadad; font-style: italic;',
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #0000ff;'
        ],
        'STRINGS' => [
            0 => 'color: #7f007f;'
        ],
        'NUMBERS' => [
            0 => 'color: #dd22dd;'
        ],
        'METHODS' => [
        ],
        'SYMBOLS' => [
            0 => 'color: #008000;'
        ],
        'REGEXPS' => [
            0 => 'color: #22bbff;',
            1 => 'color: #22bbff;',
            2 => 'color: #993333;'
        ],
        'SCRIPT' => [
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => ''
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'REGEXPS' => [
        //Hex numbers
        0 => '0[0-9a-fA-F]{1,32}[hH]',
        //Binary numbers
        1 => '\%[01]{1,64}|[01]{1,64}[bB]?(?![^<]*>)',
        //Labels
        2 => '^[_a-zA-Z][_a-zA-Z0-9]?\:'
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 8
];
