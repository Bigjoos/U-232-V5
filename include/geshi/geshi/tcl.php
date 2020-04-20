<?php
/*************************************************************************************
 * tcl.php
 * ---------------------------------
 * Author: Reid van Melle (rvanmelle@gmail.com)
 * Copyright: (c) 2004 Reid van Melle (sorry@nowhere)
 * Release Version: 1.0.8.3
 * Date Started: 2006/05/05
 *
 * TCL/iTCL language file for GeSHi.
 *
 * This was thrown together in about an hour so I don't expect
 * really great things.  However, it is a good start.  I never
 * got a change to try out the iTCL or object-based support but
 * this is not widely used anyway.
 *
 * CHANGES
 * -------
 * 2008/05/23 (1.0.7.22)
 *  -  Added description of extra language features (SF#1970248)
 * 2006/05/05 (1.0.0)
 *  -  First Release
 *
 * TODO (updated 2006/05/05)
 * -------------------------
 * - Get TCL built-in special variables highlighted with a new color..
 *   currently, these are listed in //special variables in the keywords
 *   section, but they get covered by the general REGEXP for symbols
 * - General cleanup, testing, and verification
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
    'LANG_NAME' => 'TCL',
    'COMMENT_SINGLE' => [1 => '#'],
    'COMMENT_MULTI' => [],
    'COMMENT_REGEXP' => [
        1 => '/(?<!\\\\)#(?:\\\\\\\\|\\\\\\n|.)*$/m',
        2 => '/{[^}\n]+}/'
    ],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"', "'"],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        /*
         * Set 1: reserved words
         * http://python.org/doc/current/ref/keywords.html
         */
        1 => [
            'proc', 'global', 'upvar', 'if', 'then', 'else', 'elseif', 'for', 'foreach',
            'break', 'continue', 'while', 'set', 'eval', 'case', 'in', 'switch',
            'default', 'exit', 'error', 'return', 'uplevel', 'loop',
            'for_array_keys', 'for_recursive_glob', 'for_file', 'unwind_protect',
            'expr', 'catch', 'namespace', 'rename', 'variable',
            // itcl
            'method', 'itcl_class', 'public', 'protected'],

        /*
         * Set 2: builtins
         * http://asps.activatestate.com/ASPN/docs/ActiveTcl/8.4/tcl/tcl_2_contents.htm
         */
        2 => [
            // string handling
            'append', 'binary', 'format', 're_syntax', 'regexp', 'regsub',
            'scan', 'string', 'subst',
            // list handling
            'concat', 'join', 'lappend', 'lindex', 'list', 'llength', 'lrange',
            'lreplace', 'lsearch', 'lset', 'lsort', 'split',
            // procedures and output
            'incr', 'close', 'eof', 'fblocked', 'fconfigure', 'fcopy', 'file',
            'fileevent', 'flush', 'gets', 'open', 'puts', 'read', 'seek',
            'socket', 'tell',
            // packages and source files
            'load', 'loadTk', 'package', 'pgk::create', 'pgk_mkIndex', 'source',
            // interpreter routines
            'bgerror', 'history', 'info', 'interp', 'memory', 'unknown',
            // library routines
            'enconding', 'http', 'msgcat',
            // system related
            'cd', 'clock', 'exec', 'glob', 'pid', 'pwd', 'time',
            // platform specified
            'dde', 'registry', 'resource',
            // special variables
            '$argc', '$argv', '$errorCode', '$errorInfo', '$argv0',
            '$auto_index', '$auto_oldpath', '$auto_path', '$env',
            '$tcl_interactive', '$tcl_libpath', '$tcl_library',
            '$tcl_pkgPath', '$tcl_platform', '$tcl_precision', '$tcl_traceExec',
        ],

        /*
         * Set 3: standard library
         */
        3 => [
            'comment', 'filename', 'library', 'packagens', 'tcltest', 'tclvars',
        ],

        /*
         * Set 4: special methods
         */
        //        4 => array(
        //            )

    ],
    'SYMBOLS' => [
        '(', ')', '[', ']', '{', '}', '$', '*', '&', '%', '!', ';', '<', '>', '?'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => true,
        2 => true,
        3 => true,
        //        4 => true
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #ff7700;font-weight:bold;',    // Reserved
            2 => 'color: #008000;',                        // Built-ins + self
            3 => 'color: #dc143c;',                        // Standard lib
            //            4 => 'color: #0000cd;'                        // Special methods
        ],
        'COMMENTS' => [
            1 => 'color: #808080; font-style: italic;',
            2 => 'color: #483d8b;',
            'MULTI' => 'color: #808080; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: black;'
        ],
        'STRINGS' => [
            0 => 'color: #483d8b;'
        ],
        'NUMBERS' => [
            0 => 'color: #ff4500;'
        ],
        'METHODS' => [
            1 => 'color: black;'
        ],
        'SYMBOLS' => [
            0 => 'color: #66cc66;'
        ],
        'REGEXPS' => [
            0 => 'color: #ff3333;'
        ],
        'SCRIPT' => [
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => '',
        //        4 => ''
    ],
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => [
        1 => '::'
    ],
    'REGEXPS' => [
        //Special variables
        0 => '[\\$]+[a-zA-Z_][a-zA-Z0-9_]*',
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'PARSER_CONTROL' => [
        'COMMENTS' => [
            'DISALLOWED_BEFORE' => '\\'
        ]
    ]
];
