<?php
/*************************************************************************************
 * gwbasic.php
 * ----------
 * Author: José Gabriel Moya Yangüela (josemoya@gmail.com)
 * Copyright: (c) 2010 José Gabriel Moya Yangüela (http://doc.apagada.com)
 * Release Version: 1.0.8.9
 * Date Started: 2010/01/30
 *
 * GwBasic language file for GeSHi.
 *
 * CHANGES
 * -------
 * REM was not classified as comment.
 * APPEND and RANDOM missing.
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
    'LANG_NAME' => 'GwBasic',
    'COMMENT_SINGLE' => [1 => "'", 2=> "REM"],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        /* Statements */
        1 => ['END', 'FOR', 'NEXT', 'DATA', 'INPUT', 'DIM', 'READ', 'LET',
            'GOTO', 'RUN', 'IF', 'RESTORE', 'GOSUB', 'RETURN', 'REM',
            'STOP', 'PRINT', 'CLEAR', 'LIST', 'NEW', 'ON', 'WAIT', 'DEF',
            'POKE', 'CONT', 'OUT', 'LPRINT', 'LLIST', 'WIDTH', 'ELSE',
            'TRON', 'TROFF', 'SWAP', 'ERASE', 'EDIT', 'ERROR', 'RESUME',
            'DELETE', 'AUTO', 'RENUM', 'DEFSTR', 'DEFINT', 'DEFSNG',
            'DEFDBL', 'LINE', 'WHILE', 'WEND', 'CALL', 'WRITE', 'OPTION',
            'RANDOMIZE', 'OPEN', 'CLOSE', 'LOAD', 'MERGE', 'SAVE',
            'COLOR', 'CLS', 'MOTOR', 'BSAVE', 'BLOAD', 'SOUND', 'BEEP',
            'PSET', 'PRESET', 'SCREEN', 'KEY', 'LOCATE', 'TO', 'THEN',
            'STEP', 'USR', 'FN', 'SPC', 'NOT', 'ERL', 'ERR', 'STRING',
            'USING', 'INSTR', 'VARPTR', 'CSRLIN', 'POINT', 'OFF',
            'FILES', 'FIELD', 'SYSTEM', 'NAME', 'LSET', 'RSET', 'KILL',
            'PUT', 'GET', 'RESET', 'COMMON', 'CHAIN', 'PAINT', 'COM',
            'CIRCLE', 'DRAW', 'PLAY', 'TIMER', 'IOCTL', 'CHDIR', 'MKDIR',
            'RMDIR', 'SHELL', 'VIEW', 'WINDOW', 'PMAP', 'PALETTE', 'LCOPY',
            'CALLS', 'PCOPY', 'LOCK', 'UNLOCK', 'RANDOM', 'APPEND',
        ],
        2 => [
            /* Functions */
            'CVI', 'CVS', 'CVD', 'MKI', 'MKS', 'MKD', 'ENVIRON',
            'LEFT', 'RIGHT', 'MID', 'SGN', 'INT', 'ABS',
            'SQR', 'SIN', 'LOG', 'EXP', 'COS', 'TAN', 'ATN',
            'FRE', 'INP', 'POS', 'LEN', 'STR', 'VAL', 'ASC',
            'CHR', 'PEEK', 'SPACE', 'OCT', 'HEX', 'LPOS',
            'CINT', 'CSNG', 'CDBL', 'FIX', 'PEN', 'STICK',
            'STRIG', 'EOF', 'LOC', 'LOF'
        ],
        3 => [
            /* alpha Operators */
            'AND', 'OR', 'XOR', 'EQV', 'IMP', 'MOD'
        ],
        4 => [
            /* parameterless functions */
            'INKEY', 'DATE', 'TIME', 'ERDEV', 'RND'
        ]
    ],
    'SYMBOLS' => [
        0 => [
            '>', '=', '<', '+', '-', '*', '/', '^', '\\'
        ],
        1 => [
            '?'
        ]
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        3 => false,
        4 => false
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #00a1a1;font-weight: bold',
            2 => 'color: #000066;font-weight: bold',
            3 => 'color: #00a166;font-weight: bold',
            4 => 'color: #0066a1;font-weight: bold'
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
        ],
        'SYMBOLS' => [
            /* Same as KEYWORDS[3] (and, or, not...) */
            0 => 'color: #00a166;font-weight: bold',
            1 => 'color: #00a1a1;font-weight: bold',
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099;'
        ],
        'SCRIPT' => [
        ],
        'REGEXPS' => [
            1 => 'color: #708090'
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
    'REGEXPS' => [
        1 => '^[0-9]+ '
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ]
];
