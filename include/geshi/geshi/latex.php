<?php
/*************************************************************************************
 * latex.php
 * -----
 * Author: efi, Matthias Pospiech (matthias@pospiech.eu)
 * Copyright: (c) 2006 efi, Matthias Pospiech (matthias@pospiech.eu), Nigel McNie (http://qbnz.com/highlighter)
 * Release Version: 1.0.8.3
 * Date Started: 2006/09/23
 *
 * LaTeX language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/08/18 (1.0.8.1)
 *  - Changes in color and some additional command recognition
 *  - No special Color for Brackets, it is only distracting
 *    if color should be reintroduced it should be less bright
 *  - Math color changed from green to violett, since green is now used for comments
 *  - Comments are now colored and the only green. The reason for coloring the comments
 *    is that often important information is in the comments und was merely unvisible before.
 *  - New Color for [Options]
 *  - color for labels not specialised anymore. It makes sence in large documents but less in
 *    small web examples.
 *  - \@keyword introduced
 *  - Fixed \& escaped ampersand
 * 2006/09/23 (1.0.0)
 *  -  First Release
 *
 * TODO
 * -------------------------
 * *
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
    'LANG_NAME' => 'LaTeX',
    'COMMENT_SINGLE' => [
        1 => '%'
    ],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => [],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            'appendix', 'backmatter', 'caption', 'captionabove', 'captionbelow',
            'def', 'documentclass', 'edef', 'equation', 'flushleft', 'flushright',
            'footnote', 'frontmatter', 'hline', 'include', 'input', 'item', 'label',
            'let', 'listfiles', 'listoffigures', 'listoftables', 'mainmatter',
            'makeatletter', 'makeatother', 'makebox', 'mbox', 'par', 'raggedleft',
            'raggedright', 'raisebox', 'ref', 'rule', 'table', 'tableofcontents',
            'textbf', 'textit', 'texttt', 'today'
        ]
    ],
    'SYMBOLS' => [
        "&", "\\", "{", "}", "[", "]"
    ],
    'CASE_SENSITIVE' => [
        1 => true,
        GESHI_COMMENTS => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #800000; font-weight: bold;',
        ],
        'COMMENTS' => [
            1 => 'color: #2C922C; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 =>  'color: #000000; font-weight: bold;'
        ],
        'BRACKETS' => [
        ],
        'STRINGS' => [
            0 =>  'color: #000000;'
        ],
        'NUMBERS' => [
        ],
        'METHODS' => [
        ],
        'SYMBOLS' => [
            0 =>  'color: #E02020; '
        ],
        'REGEXPS' => [
            1 => 'color: #8020E0; font-weight: normal;',  // Math inner
            2 => 'color: #C08020; font-weight: normal;', // [Option]
            3 => 'color: #8020E0; font-weight: normal;', // Maths
            4 => 'color: #800000; font-weight: normal;', // Structure: Labels
            5 => 'color: #00008B; font-weight: bold;',  // Structure (\section{->x<-})
            6 => 'color: #800000; font-weight: normal;', // Structure (\section)
            7 => 'color: #0000D0; font-weight: normal;', // Environment \end or \begin{->x<-} (brighter blue)
            8 => 'color: #C00000; font-weight: normal;', // Structure \end or \begin
            9 => 'color: #2020C0; font-weight: normal;', // {...}
            10 => 'color: #800000; font-weight: normal;', // \%, \& etc.
            11 => 'color: #E00000; font-weight: normal;', // \@keyword
            12 => 'color: #800000; font-weight: normal;', // \keyword
        ],
        'SCRIPT' => [
        ]
    ],
    'URLS' => [
        1 => 'http://www.golatex.de/wiki/index.php?title=\\{FNAME}',
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'REGEXPS' => [
        // Math inner
        1 => [
            GESHI_SEARCH => "(\\\\begin\\{(equation|displaymath|eqnarray|subeqnarray|math|multline|gather|align|alignat|flalign)\\})(.*)(\\\\end\\{\\2\\})",
            GESHI_REPLACE => '\3',
            GESHI_MODIFIERS => 'Us',
            GESHI_BEFORE => '\1',
            GESHI_AFTER => '\4'
        ],
        // [options]
        2 => [
            GESHI_SEARCH => "(?<=\[).+(?=\])",
            GESHI_REPLACE => '\0',
            GESHI_MODIFIERS => 'Us',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        // Math mode with $ ... $
        3 => [
            GESHI_SEARCH => "\\$.+\\$",
            GESHI_REPLACE => '\0',
            GESHI_MODIFIERS => 'Us',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        // Structure: Label
        4 => "\\\\(?:label|pageref|ref|cite)(?=[^a-zA-Z])",
        // Structure: sections
        5 => [
            GESHI_SEARCH => "(\\\\(?:part|chapter|(?:sub){0,2}section|(?:sub)?paragraph|addpart|addchap|addsec)\*?\\{)(.*)(?=\\})",
            GESHI_REPLACE => '\\2',
            GESHI_MODIFIERS => 'U',
            GESHI_BEFORE => '\\1',
            GESHI_AFTER => ''
        ],
        // Structure: sections
        6 => "\\\\(?:part|chapter|(?:sub){0,2}section|(?:sub)?paragraph|addpart|addchap|addsec)\*?(?=[^a-zA-Z])",
        // environment \begin{} and \end{} (i.e. the things inside the {})
        7 => [
            GESHI_SEARCH => "(\\\\(?:begin|end)\\{)(.*)(?=\\})",
            GESHI_REPLACE => '\\2',
            GESHI_MODIFIERS => 'U',
            GESHI_BEFORE => '\\1',
            GESHI_AFTER => ''
        ],
        // Structure \begin and \end
        8 => "\\\\(?:end|begin)(?=[^a-zA-Z])",
        // {parameters}
        9 => [
            GESHI_SEARCH => "(?<=\\{)(?!<\|!REG3XP5!>).*(?=\\})",
            GESHI_REPLACE => '\0',
            GESHI_MODIFIERS => 'Us',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        // \%, \& usw.
        10 => "\\\\(?:[_$%]|&amp;)",
        //  \@keywords
        11 => "(?<!<\|!REG3XP[8]!>)\\\\@[a-zA-Z]+\*?",
        // \keywords
        12 => "(?<!<\|!REG3XP[468]!>)\\\\[a-zA-Z]+\*?",

        // ---------------------------------------------
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'PARSER_CONTROL' => [
        'COMMENTS' => [
            'DISALLOWED_BEFORE' => '\\'
        ],
        'KEYWORDS' => [
            'DISALLOWED_BEFORE' => "(?<=\\\\)",
            'DISALLOWED_AFTER' => "(?=\b)(?!\w)"
        ],
        'ENABLE_FLAGS' => [
            'NUMBERS' => GESHI_NEVER,
            'BRACKETS' => GESHI_NEVER
        ]
    ]
];
