<?php
/********************************************************************************
 * bibtex.php
 * -----
 * Author: Quinn Taylor (quinntaylor@mac.com)
 * Copyright: (c) 2009 Quinn Taylor (quinntaylor@mac.com), Nigel McNie (http://qbnz.com/highlighter)
 * Release Version: 1.0.8.9
 * Date Started: 2009/04/29
 *
 * BibTeX language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2009/04/29 (1.0.8.4)
 *  -  First Release
 *
 * TODO
 * -------------------------
 *  - Add regex for matching and replacing URLs with corresponding hyperlinks
 *  - Add regex for matching more LaTeX commands that may be embedded in BibTeX
 *    (Someone who understands regex better than I should borrow from latex.php)
 ********************************************************************************
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
 *
 *******************************************************************************/

// http://en.wikipedia.org/wiki/BibTeX
// http://www.fb10.uni-bremen.de/anglistik/langpro/bibliographies/jacobsen-bibtex.html

$language_data = [
    'LANG_NAME' => 'BibTeX',
    'OOLANG' => false,
    'COMMENT_SINGLE' => [
        1 => '%%'
    ],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => [],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        0 => [
            '@comment', '@preamble', '@string'
        ],
        // Standard entry types
        1 => [
            '@article', '@book', '@booklet', '@conference', '@inbook',
            '@incollection', '@inproceedings', '@manual', '@mastersthesis',
            '@misc', '@phdthesis', '@proceedings', '@techreport', '@unpublished'
        ],
        // Custom entry types
        2 => [
            '@collection', '@patent', '@webpage'
        ],
        // Standard entry field names
        3 => [
            'address', 'annote', 'author', 'booktitle', 'chapter', 'crossref',
            'edition', 'editor', 'howpublished', 'institution', 'journal', 'key',
            'month', 'note', 'number', 'organization', 'pages', 'publisher', 'school',
            'series', 'title', 'type', 'volume', 'year'
        ],
        // Custom entry field names
        4 => [
            'abstract', 'affiliation', 'chaptername', 'cited-by', 'cites',
            'contents', 'copyright', 'date-added', 'date-modified', 'doi', 'eprint',
            'isbn', 'issn', 'keywords', 'language', 'lccn', 'lib-congress',
            'location', 'price', 'rating', 'read', 'size', 'source', 'url'
        ]
    ],
    'URLS' => [
        0 => '',
        1 => '',
        2 => '',
        3 => '',
        4 => ''
    ],
    'SYMBOLS' => [
        '{', '}', '#', '=', ','
    ],
    'CASE_SENSITIVE' => [
        1 => false,
        2 => false,
        3 => false,
        4 => false,
        GESHI_COMMENTS => false,
    ],
    // Define the colors for the groups listed above
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #C02020;', // Standard entry types
            2 => 'color: #C02020;', // Custom entry types
            3 => 'color: #C08020;', // Standard entry field names
            4 => 'color: #C08020;'  // Custom entry field names
        ],
        'COMMENTS' => [
            1 => 'color: #2C922C; font-style: italic;'
        ],
        'STRINGS' => [
            0 => 'color: #2020C0;'
        ],
        'SYMBOLS' => [
            0 =>  'color: #E02020;'
        ],
        'REGEXPS' => [
            1 => 'color: #2020C0;', // {...}
            2 => 'color: #C08020;',  // BibDesk fields
            3 => 'color: #800000;'   // LaTeX commands
        ],
        'ESCAPE_CHAR' => [
            0 =>  'color: #000000; font-weight: bold;'
        ],
        'BRACKETS' => [
            0 =>  'color: #E02020;'
        ],
        'NUMBERS' => [
        ],
        'METHODS' => [
        ],
        'SCRIPT' => [
        ]
    ],
    'REGEXPS' => [
        // {parameters}
        1 => [
            GESHI_SEARCH => "(?<=\\{)(?:\\{(?R)\\}|[^\\{\\}])*(?=\\})",
            GESHI_REPLACE => '\0',
            GESHI_MODIFIERS => 's',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        2 => [
            GESHI_SEARCH => "\bBdsk-(File|Url)-\d+",
            GESHI_REPLACE => '\0',
            GESHI_MODIFIERS => 'Us',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
        3 => [
            GESHI_SEARCH => "\\\\[A-Za-z0-9]*+",
            GESHI_REPLACE => '\0',
            GESHI_MODIFIERS => 'Us',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
        ],
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'OBJECT_SPLITTERS' => [
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'PARSER_CONTROL' => [
        'ENABLE_FLAGS' => [
            'NUMBERS' => GESHI_NEVER
        ],
        'KEYWORDS' => [
            3 => [
                'DISALLOWED_AFTER' => '(?=\s*=)'
            ],
            4 => [
                'DISALLOWED_AFTER' => '(?=\s*=)'
            ],
        ]
    ]
];
