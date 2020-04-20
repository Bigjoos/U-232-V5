<?php
/*************************************************************************************
 * ocaml.php
 * ----------
 * Author: Flaie (fireflaie@gmail.com)
 * Copyright: (c) 2005 Flaie, Nigel McNie (http://qbnz.com/highlighter)
 * Release Version: 1.0.8.3
 * Date Started: 2005/08/27
 *
 * OCaml (Objective Caml) language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2005/08/27 (1.0.0)
 *   -  First Release
 *
 * TODO (updated 2005/08/27)
 * -------------------------
 *
 *************************************************************************************
 *
 *   This file is part of GeSHi.
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
    'LANG_NAME' => 'OCaml (brief)',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => ['(*' => '*)'],
    'CASE_KEYWORDS' => 0,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => "",
    'KEYWORDS' => [
        /* main OCaml keywords */
        1 => [
            'and', 'as', 'asr', 'begin', 'class', 'closed', 'constraint', 'do', 'done', 'downto', 'else',
            'end', 'exception', 'external', 'failwith', 'false', 'flush', 'for', 'fun', 'function', 'functor',
            'if', 'in', 'include', 'inherit',  'incr', 'land', 'let', 'load', 'los', 'lsl', 'lsr', 'lxor',
            'match', 'method', 'mod', 'module', 'mutable', 'new', 'not', 'of', 'open', 'option', 'or', 'parser',
            'private', 'ref', 'rec', 'raise', 'regexp', 'sig', 'struct', 'stdout', 'stdin', 'stderr', 'then',
            'to', 'true', 'try', 'type', 'val', 'virtual', 'when', 'while', 'with'
        ]
    ],
    /* highlighting symbols is really important in OCaml */
    'SYMBOLS' => [
        ';', '!', ':', '.', '=', '%', '^', '*', '-', '/', '+',
        '>', '<', '(', ')', '[', ']', '&', '|', '#', "'"
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #06c; font-weight: bold;' /* nice blue */
        ],
        'COMMENTS' => [
            'MULTI' => 'color: #5d478b; font-style: italic;' /* light purple */
        ],
        'ESCAPE_CHAR' => [
        ],
        'BRACKETS' => [
            0 => 'color: #6c6;'
        ],
        'STRINGS' => [
            0 => 'color: #3cb371;' /* nice green */
        ],
        'NUMBERS' => [
            0 => 'color: #c6c;' /* pink */
        ],
        'METHODS' => [
            1 => 'color: #060;' /* dark green */
        ],
        'REGEXPS' => [
        ],
        'SYMBOLS' => [
            0 => 'color: #a52a2a;' /* maroon */
        ],
        'SCRIPT' => [
        ]
    ],
    'URLS' => [
        1 => '',
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
