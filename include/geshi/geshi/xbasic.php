<?php
/*************************************************************************************
 * xbasic.php
 * ----------
 * Author: José Gabriel Moya Yangüela (josemoya@gmail.com)
 * Copyright: (c) 2005 José Gabriel Moya Yangüela (http://aprenderadesaprender.6te.net)
 * Release Version: 1.0.8.9
 * Date Started: 2005/11/23
 * Last Modified: $Date: 2010/01/30 00:42:00 $
 *
 * XBasic language file for GeSHi.
 *
 * CHANGES
 * -------
 *  - Removed duplicate keywords
 *  - Tabs converted in spaces.
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
    'LANG_NAME' => 'XBasic',
    'COMMENT_SINGLE' => [1 => "'"],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            'WHILE', 'UNTIL', 'TRUE', 'TO', 'THEN', 'SUB', 'STOP', 'STEP',
            'SELECT', 'RETURN', 'PROGRAM', 'NEXT', 'LOOP', 'IFZ',
            'IFT', 'IFF', 'IF', 'GOTO', 'GOSUB', 'FOR', 'FALSE', 'EXIT',
            'ENDIF', 'END', 'ELSE', 'DO', 'CASE', 'ALL'
        ],
        2 => [
            'XMAKE', 'XLONGAT', 'XLONG', 'WRITE', 'VOID', 'VERSION$', 'VERSION',
            'USHORTAT', 'USHORT', 'UNION', 'ULONGAT', 'ULONG', 'UCASE$',
            'UBYTEAT', 'UBYTE', 'UBOUND', 'TYPE', 'TRIM$', 'TAB', 'SWAP',
            'SUBADDRESS', 'SUBADDR', 'STUFF$', 'STRING', 'STRING$', 'STR$',
            'STATIC', 'SSHORTAT', 'SSHORT', 'SPACE$', 'SMAKE', 'SLONGAT', 'SLONG',
            'SIZE', 'SINGLEAT', 'SINGLE', 'SIGNED$', 'SIGN', 'SHELL', 'SHARED',
            'SGN', 'SFUNCTION', 'SET', 'SEEK', 'SCOMPLEX', 'SBYTEAT', 'SBYTE',
            'RTRIM$', 'ROTATER', 'ROTATEL', 'RJUST$', 'RINSTRI', 'RINSTR',
            'RINCHRI', 'RINCHR', 'RIGHT$', 'REDIM', 'READ', 'RCLIP$', 'QUIT',
            'PROGRAM$', 'PRINT', 'POF', 'OPEN', 'OCTO$', 'OCT$', 'NULL$', 'MIN',
            'MID$', 'MAX', 'MAKE', 'LTRIM$', 'LOF', 'LJUST$', 'LIBRARY', 'LEN',
            'LEFT$', 'LCLIP$', 'LCASE$', 'INTERNAL', 'INT', 'INSTRI', 'INSTR',
            'INLINE$', 'INFILE$', 'INCHRI', 'INCHR', 'INC', 'IMPORT', 'HIGH1',
            'HIGH0', 'HEXX$', 'HEX$', 'GOADDRESS', 'GOADDR', 'GMAKE', 'GLOW',
            'GIANTAT', 'GIANT', 'GHIGH', 'FUNCTION', 'FUNCADDRESS', 'FUNCADDR',
            'FORMAT$', 'FIX', 'EXTU', 'EXTS', 'EXTERNAL', 'ERROR', 'ERROR$',
            'EOF', 'DOUBLEAT', 'DOUBLE', 'DMAKE', 'DLOW', 'DIM', 'DHIGH',
            'DECLARE', 'DEC', 'DCOMPLEX', 'CSTRING$', 'CSIZE', 'CSIZE$', 'CLR',
            'CLOSE', 'CLEAR', 'CJUST$', 'CHR$', 'CFUNCTION', 'BITFIELD', 'BINB$',
            'BIN$', 'AUTOX', 'AUTOS', 'AUTO', 'ATTACH', 'ASC', 'ABS'
        ],
        3 => [
            'XOR', 'OR', 'NOT', 'MOD', 'AND'
        ],
        4 => [
            'TANH', 'TAN', 'SQRT', 'SINH', 'SIN', 'SECH', 'SEC', 'POWER',
            'LOG10', 'LOG', 'EXP10', 'EXP', 'CSCH', 'CSC', 'COTH', 'COT', 'COSH',
            'COS', 'ATANH', 'ATAN', 'ASINH', 'ASIN', 'ASECH', 'ASEC', 'ACSCH',
            'ACSC', 'ACOSH', 'ACOS'
        ]
    ],
    'SYMBOLS' => [
        '(', ')', '[', ']', '!', '@', '%', '&', '*', '|', '/', '<', '>',
        '=', '+', '-'
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
            1 => 'color: #808080;'
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
        'ESCAPE_CHAR' => [
            0 => 'color: #000099;'
        ],
        'SCRIPT' => [
        ],
        'REGEXPS' => [
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => 'http://www.xbasic.org',
        4 => 'http://www.xbasic.org'
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
    ]
];
