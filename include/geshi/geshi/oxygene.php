<?php
/*************************************************************************************
 * oxygene.php
 * ----------
 * Author: Carlo Kok (ck@remobjects.com), J�rja Norbert (jnorbi@vipmail.hu), Benny Baumann (BenBE@omorphia.de)
 * Copyright: (c) 2004 J�rja Norbert, Benny Baumann (BenBE@omorphia.de), Nigel McNie (http://qbnz.com/highlighter)
 * Release Version: 1.0.8.9
 * Date Started: 2010/01/11
 *
 * Delphi Prism (Oxygene) language file for GeSHi.
 * Based on the original Delphi language file.
 *
 * CHANGES
 * -------
 * 2010/01/11 (1.0.0)
 *   -  First Release
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
    'LANG_NAME' => 'Oxygene (Delphi Prism)',
    'COMMENT_SINGLE' => [1 => '//'],
    'COMMENT_MULTI' => ['(*' => '*)', '{' => '}'],
    //Compiler directives
    'COMMENT_REGEXP' => [2 => '/{\\$.*?}|\\(\\*\\$.*?\\*\\)/U'],
    'CASE_KEYWORDS' => 0,
    'QUOTEMARKS' => ["'"],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            'and',   'begin', 'case', 'const',  'div', 'do', 'downto', 'else',
            'end',  'for',  'function', 'if', 'in', 'mod', 'not', 'of', 'or',
            'procedure', 'repeat', 'record', 'set', 'shl', 'shr', 'then', 'to',
            'type', 'until', 'uses', 'var', 'while', 'with', 'xor', 'exit', 'break',
            'class', 'constructor', 'inherited', 'private', 'public', 'protected',
            'property', 'As', 'Is', 'Unit', 'Continue', 'Try', 'Except', 'Forward',
            'Interface', 'Implementation', 'nil', 'out', 'loop', 'namespace', 'true',
            'false', 'new', 'ensure', 'require', 'on', 'event', 'delegate', 'method',
            'raise', 'assembly', 'module', 'using', 'locking', 'old', 'invariants', 'operator',
            'self', 'async', 'finalizer', 'where', 'yield', 'nullable', 'Future',
            'From',  'Finally', 'dynamic'
        ],
        2 => [
            'override', 'virtual', 'External', 'read', 'add', 'remove', 'final', 'abstract',
            'empty', 'global', 'locked', 'sealed', 'reintroduce', 'implements', 'each',
            'default', 'partial', 'finalize', 'enum', 'flags', 'result', 'readonly', 'unsafe',
            'pinned', 'matching', 'static', 'has', 'step', 'iterator', 'inline', 'nested',
            'Implies', 'Select', 'Order', 'By', 'Desc', 'Asc', 'Group', 'Join', 'Take',
            'Skip', 'Concat', 'Union', 'Reverse', 'Distinct', 'Into', 'Equals', 'params',
            'sequence', 'index', 'notify', 'Parallel', 'create', 'array', 'Queryable', 'Aspect',
            'volatile'
        ],
        3 => [
            'chr', 'ord', 'inc', 'dec', 'assert', 'iff', 'assigned', 'futureAssigned', 'length', 'low', 'high', 'typeOf', 'sizeOf', 'disposeAndNil', 'Coalesce', 'unquote'
        ],
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        3 => false,
        //        4 => false,
    ],
    'SYMBOLS' => [
        0 => ['(', ')', '[', ']'],
        1 => ['.', ',', ':', ';'],
        2 => ['@', '^'],
        3 => ['=', '+', '-', '*', '/']
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #000000; font-weight: bold;',
            2 => 'color: #000000; font-weight: bold;',
            3 => 'color: #000066;',
            //            4 => 'color: #000066; font-weight: bold;'
        ],
        'COMMENTS' => [
            1 => 'color: #808080; font-style: italic;',
            2 => 'color: #008000; font-style: italic;',
            'MULTI' => 'color: #808080; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #ff0000; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 => 'color: #000066;'
        ],
        'STRINGS' => [
            0 => 'color: #ff0000;'
        ],
        'NUMBERS' => [
            0 => 'color: #0000ff;'
        ],
        'METHODS' => [
            1 => 'color: #000000;'
        ],
        'REGEXPS' => [
            0 => 'color: #9ac;',
            1 => 'color: #ff0000;'
        ],
        'SYMBOLS' => [
            0 => 'color: #000066;',
            1 => 'color: #000066;',
            2 => 'color: #000066;',
            3 => 'color: #000066;'
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
        1 => '.'
    ],
    'REGEXPS' => [
        //Hex numbers
        0 => '\$[0-9a-fA-F]+',
        //Characters
        1 => '\#\$?[0-9]{1,3}'
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 2
];
