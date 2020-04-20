<?php
/*************************************************************************************
 * 68000devpac.php
 * -------
 * Author: Warren Willmey
 * Copyright: (c) 2010 Warren Willmey.
 * Release Version: 1.0.8.9
 * Date Started: 2010/06/09
 *
 * Motorola 68000 - HiSoft Devpac ST 2 Assembler language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2010/07/22
 *  -  First Release
 *
 * TODO (updated 2010/07/22)
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
    'LANG_NAME' => 'Motorola 68000 - HiSoft Devpac ST 2 Assembler format',
    'COMMENT_SINGLE' => [1 => ';'],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'", '"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        /* Directives. */
        1 => [
            'end', 'include', 'incbin', 'opt', 'even', 'cnop', 'dc.b', 'dc.w',
            'dc.l', 'ds.b', 'ds.w', 'ds.l', 'dcb.b', 'dcb.w', 'dcb.l',
            'fail', 'output', '__g2', 'rept', 'endr', 'list', 'nolist', 'plen',
            'llen', 'ttl', 'subttl', 'spc', 'page', 'listchar', 'format',
            'equ', 'equr', 'set', 'reg', 'rs.b', 'rs.w', 'rs.l', 'rsreset',
            'rsset', '__rs', 'ifeq', 'ifne', 'ifgt', 'ifge', 'iflt', 'ifle', 'endc',
            'ifd', 'ifnd', 'ifc', 'ifnc', 'elseif', 'iif', 'macro', 'endm', 'mexit',
            'narg', '\@', 'section', 'text', 'data', 'bss', 'xdef', 'xref', 'org',
            'offset', '__lk', 'comment',
        ],
        /* 68000 Opcodes. */
        2 => [
            'abcd',    'add', 'adda', 'addi', 'addq', 'addx',  'and', 'andi',
            'asl',     'asr',  'bcc', 'bchg', 'bclr',  'bcs',  'beq',  'bge',
            'bgt',     'bhi',  'ble',  'bls',  'blt',  'bmi',  'bne',  'bpl',
            'bra',    'bset',  'bsr', 'btst',  'bvc',  'bvs',  'chk',  'clr',
            'cmp',    'cmpa', 'cmpi', 'cmpm', 'dbcc', 'dbcs', 'dbeq',  'dbf',
            'dbge',   'dbgt', 'dbhi', 'dble', 'dbls', 'dblt', 'dbmi', 'dbne',
            'dbpl',   'dbra',  'dbt', 'dbvc', 'dbvs', 'divs', 'divu',  'eor',
            'eori',    'exg',  'ext', 'illegal', 'jmp',  'jsr',  'lea', 'link',
            'lsl',     'lsr', 'move', 'movea', 'movem', 'movep', 'moveq', 'muls',
            'mulu',   'nbcd',  'neg', 'negx',  'nop',  'not',   'or',  'ori',
            'pea',   'reset',  'rol',  'ror', 'roxl', 'roxr',  'rte',  'rtr',
            'rts',    'sbcd',  'scc',  'scs',  'seq',   'sf',  'sge',  'sgt',
            'shi',     'sle',  'sls',  'slt',  'smi',  'sne',  'spl',   'st',
            'stop',    'sub', 'suba', 'subi', 'subq', 'subx',  'svc',  'svs',
            'swap',    'tas', 'trap', 'trapv',  'tst', 'unlk',
        ],
        /* oprand sizes. */
        3 => [
            'b', 'w', 'l' , 's'
        ],
        /* 68000 Registers. */
        4 => [
            'd0', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7',
            'a0', 'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'sp', 'usp', 'ssp',
            'pc', 'ccr', 'sr',
        ],
    ],
    'SYMBOLS' => [
        //        '[', ']', '(', ')', '{', '}',    // These are already defined by GeSHi as BRACKETS.
        '+', '-', '~', '<<', '>>', '&',
        '!', '^', '*', '/', '=', '<', '>',
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
            1 => 'color: #f08; font-weight:bold;',
            2 => 'color: #00f; font-weight:bold;',
            3 => 'color: #00f; font-weight:bold;',
            4 => 'color: #080; font-weight:bold;',
        ],
        'COMMENTS' => [
            1 => 'color: #999; font-style: italic;',
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #009; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #000;'
        ],
        'STRINGS' => [
            0 => 'color: #080;'
        ],
        'NUMBERS' => [
            GESHI_NUMBER_INT_BASIC          => 'color: #f00;',
            GESHI_NUMBER_HEX_PREFIX_DOLLAR  => 'color: #f00;',
            GESHI_NUMBER_BIN_PREFIX_PERCENT => 'color: #f00;',
            GESHI_NUMBER_OCT_PREFIX_AT      => 'color: #f00;',
        ],
        'METHODS' => [
        ],
        'SYMBOLS' => [
            0 => 'color: #080;'
        ],
        'REGEXPS' => [
            0 => 'color: #933;'
        ],
        'SCRIPT' => [
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => '',
        4 => '',
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'NUMBERS' =>
        GESHI_NUMBER_INT_BASIC |
        GESHI_NUMBER_HEX_PREFIX_DOLLAR |
        GESHI_NUMBER_OCT_PREFIX_AT |
        GESHI_NUMBER_BIN_PREFIX_PERCENT,
    'REGEXPS' => [
        //Labels may end in a colon.
        0 => '(?<=\A\x20|\r|\n|^)[\._a-zA-Z][\._a-zA-Z0-9]*[\:]?[\s]'
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 8,
    'PARSER_CONTROL' => [
        'NUMBERS' => [
            'PRECHECK_RX' => '/[\da-fA-F\.\$\%\@]/'
        ]
    ]
];
