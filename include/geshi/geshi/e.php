<?php
/*************************************************************************************
 * e.php
 * --------
 * Author: Kevin Reid (kpreid@switchb.org)
 * Copyright: (c) 2010 Kevin Reid (http://switchb.org/kpreid/)
 * Release Version: 1.0.8.9
 * Date Started: 2010/04/16
 *
 * E language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2010-04-21 (1.0.8.8)
 *  -  Fixing langcheck-reported bugs.
 * 2010-04-14 (0.1)
 *  -  First Release
 *
 * TODO (updated 2010-04-21)
 * -------------------------
 *  -  Do something useful with the keyword groups. Since RC uses CSS classes named
 *     by the group numbers, either
 *     - change the numbering to match conventional uses by other languages,
 *     - or find or create some way to produce usefully named classes.
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
    'LANG_NAME' => 'E',
    'COMMENT_SINGLE' => [1 => '#'],
    'COMMENT_MULTI' => ['/**' => '*/'], // Note: This is method doc, not a general comment syntax.
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,

    // FIXME: The escaping inside ` is actually doubling of any interior `, $, or @ -- backslash is NOT special
    'QUOTEMARKS' => ['\'', '"', '`'],
    'ESCAPE_CHAR' => '\\',

    'KEYWORDS' => [
        // builtin control structures
        1 => [
            'accum', 'break', 'try', 'continue', 'if', 'while', 'for', 'switch'
        ],

        // control structures subsidiary keywords
        2 => [
            'catch', 'else', 'finally', 'in', 'exit'
        ],

        // named operators
        3 => [
            'fn', 'via'
        ],

        // variable/function/object definers
        4 => [
            'def', 'bind', 'var'
        ],

        // object definition subsidiary keywords
        5 => [
            'extends', 'as', 'implements', 'guards', 'match', 'to', 'method'
        ],

        // builtin nouns in safeEnv
        6 => [
            'null', 'false', 'true', 'throw', '__loop', '__makeList',
            '__makeMap', '__makeProtocolDesc', '__makeMessageDesc',
            '__makeParamDesc', 'any', 'void', 'boolean', '__makeOrderedSpace',
            'ValueGuard', '__MatchContext', 'require', '__makeVerbFacet', 'NaN',
            'Infinity', '__identityFunc', '__makeInt', '__makeFinalSlot',
            '__makeVarSlot', '__makeGuardedSlot', '__makeGuard', '__makeTwine',
            '__makeSourceSpan', '__auditedBy', 'Guard', 'near', 'pbc',
            'PassByCopy', 'DeepPassByCopy', 'Data', 'Persistent', 'DeepFrozen',
            'int', 'float64', 'char', 'String', 'Twine', 'TextWriter', 'List',
            'Map', 'nullOk', 'Tuple', '__Portrayal', 'notNull', 'vow', 'rcvr',
            'SturdyRef', 'simple__quasiParser', 'twine__quasiParser',
            'rx__quasiParser', 'e__quasiParser', 'epatt__quasiParser',
            'sml__quasiParser', 'term__quasiParser', 'traceln', '__equalizer',
            '__comparer', 'Ref', 'E', 'promiseAllFulfilled', 'EIO', 'help',
            'safeScope', '__eval', 'resource__uriGetter', 'type__uriGetter',
            'import__uriGetter', 'elib__uriGetter', 'elang__uriGetter',
            'opaque__uriGetter'
        ],

        // builtin nouns in privilegedEnv
        7 => [
            'file__uriGetter', 'fileURL__uriGetter', 'jar__uriGetter',
            'http__uriGetter', 'ftp__uriGetter', 'gopher__uriGetter',
            'news__uriGetter', 'cap__uriGetter', 'makeCommand', 'stdout',
            'stderr', 'stdin', 'print', 'println', 'interp', 'entropy', 'timer',
            'introducer', 'identityMgr', 'makeSturdyRef', 'timeMachine',
            'unsafe__uriGetter', 'currentVat', 'rune', 'awt__uriGetter',
            'swing__uriGetter', 'JPanel__quasiParser', 'swt__uriGetter',
            'currentDisplay', 'swtGrid__quasiParser', 'swtGrid`',
            'privilegedScope'
        ],

        // reserved keywords
        8 => [
            'abstract', 'an', 'assert', 'attribute', 'be', 'begin', 'behalf',
            'belief', 'believe', 'believes', 'case', 'class', 'const',
            'constructor', 'declare', 'default', 'define', 'defmacro',
            'delicate', 'deprecated', 'dispatch', 'do', 'encapsulate',
            'encapsulated', 'encapsulates', 'end', 'ensure', 'enum', 'eventual',
            'eventually', 'export', 'facet', 'forall', 'function', 'given',
            'hidden', 'hides', 'inline', 'is', 'know', 'knows', 'lambda', 'let',
            'methods', 'module', 'namespace', 'native', 'obeys', 'octet',
            'oneway', 'operator', 'package', 'private', 'protected', 'public',
            'raises', 'reliance', 'reliant', 'relies', 'rely', 'reveal', 'sake',
            'signed', 'static', 'struct', 'suchthat', 'supports', 'suspect',
            'suspects', 'synchronized', 'this', 'transient', 'truncatable',
            'typedef', 'unsigned', 'unum', 'uses', 'using', 'utf8', 'utf16',
            'virtual', 'volatile', 'wstring'
        ]
    ],
    'SYMBOLS' => [
        1 => [
            '(', ')', '{', '}', '[', ']', '+', '-', '*', '/', '%', '=', '<', '>', '!', '^', '&', '|', '?', ':', ';', ','
        ]
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => true,
        2 => true,
        3 => true,
        4 => true,
        5 => true,
        6 => true,
        7 => true,
        8 => true
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #b1b100;',
            2 => 'color: #b1b100;',
            3 => 'color: #b1b100;',
            4 => 'color: #b1b100;',
            5 => 'color: #b1b100;',
            6 => 'color: #b1b100;',
            7 => 'color: #b1b100;',
            8 => 'color: #b1b100;'
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
            1 => 'color: #339933;'
        ],
        'REGEXPS' => [],
        'SCRIPT' => []
    ],
    'URLS' => [
        1 => 'http://wiki.erights.org/wiki/{FNAME}',
        2 => 'http://wiki.erights.org/wiki/{FNAME}',
        3 => 'http://wiki.erights.org/wiki/{FNAME}',
        4 => 'http://wiki.erights.org/wiki/{FNAME}',
        5 => 'http://wiki.erights.org/wiki/{FNAME}',
        6 => 'http://wiki.erights.org/wiki/{FNAME}',
        7 => 'http://wiki.erights.org/wiki/{FNAME}',
        8 => 'http://wiki.erights.org/wiki/{FNAME}'
    ],
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => [
        1 => '.',
        2 => '<-',
        3 => '::'
    ],
    'REGEXPS' => [],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [],
    'HIGHLIGHT_STRICT_BLOCK' => []
];
