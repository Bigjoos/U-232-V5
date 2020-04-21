<?php
/*************************************************************************************
 * email.php
 * ---------------
 * Author: Benny Baumann (BenBE@geshi.org)
 * Copyright: (c) 2008 Benny Baumann (http://qbnz.com/highlighter/)
 * Release Version: 1.0.8.3
 * Date Started: 2008/10/19
 *
 * Email (mbox \ eml \ RFC format) language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/10/19 (1.0.8.1)
 *   -  First Release
 *
 * TODO (updated 2008/10/19)
 * -------------------------
 * * Better checks when a header field should be expected
 * * Fix the bound checks for kw groups 2 and 3, as well as rx group 1
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
    'LANG_NAME' => 'eMail (mbox)',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [
        1 => [
            'HTTP', 'SMTP', 'ASMTP', 'ESMTP'
        ],
        2 => [
            'Content-Type', 'Content-Transfer-Encoding', 'Content-Disposition',
            'Delivered-To', 'Dkim-Signature', 'Domainkey-Signature', 'In-Reply-To',
            'Message-Id', 'MIME-Version', 'Received', 'Received-SPF', 'References',
            'Resend-From', 'Resend-To', 'Return-Path'
        ],
        3 => [
            'Date', 'From', 'Subject', 'To',
        ],
        4 => [
            'by', 'for', 'from', 'id', 'with'
        ]
    ],
    'SYMBOLS' => [
        ':', ';', '<', '>', '[', ']'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => true,
        2 => false,
        3 => false,
        4 => true
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #0000FF; font-weight: bold;',
            2 => 'color: #000000; font-weight: bold;',
            3 => 'color: #800000; font-weight: bold;',
            4 => 'font-weight: bold;',
        ],
        'COMMENTS' => [
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;'
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
        'SCRIPT' => [
            0 => 'color: #000040;',
        ],
        'REGEXPS' => [
            1 => 'color: #000000; font-weight: bold;',
            2 => 'color: #0000FF;',
            3 => 'color: #008000;',
            4 => 'color: #0000FF; font-weight: bold;',
            5 => 'font-weight: bold;',
            6 => 'color: #400080;'
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => '',
        4 => ''
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'REGEXPS' => [
        // Non-Standard-Header
        1 => [
            GESHI_SEARCH => "(?<=\A\x20|\n)x-[a-z0-9\-]*(?=\s*:|\s*<)",
            GESHI_REPLACE => "\\0",
            GESHI_MODIFIERS => "smi",
            GESHI_BEFORE => "",
            GESHI_AFTER => ""
        ],
        //Email-Adresses or Mail-IDs
        2 => [
            GESHI_SEARCH => "\b[\w\.]+@\w+(?:(?:\.\w+)*\.\w{2,4})?",
            GESHI_REPLACE => "\\0",
            GESHI_MODIFIERS => "mi",
            GESHI_BEFORE => "",
            GESHI_AFTER => ""
        ],
        //Date values in RFC format
        3 => [
            GESHI_SEARCH => "\b(?:Mon|Tue|Wed|Thu|Fri|Sat|Sun),\s+\d\d?\s+" .
                "(?:Jan|Feb|Mar|apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s+" .
                "\d{4}\s+\d\d?:\d\d:\d\d\s+[+\-]\d{4}(?:\s+\(\w+\))?",
            GESHI_REPLACE => "\\0",
            GESHI_MODIFIERS => "mi",
            GESHI_BEFORE => "",
            GESHI_AFTER => ""
        ],
        //IP addresses
        4 => [
            GESHI_SEARCH => "(?<=\s)\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?=\s)|" .
                "(?<=\[)\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?=\])|" .
                "(?<==)\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?=<)",
            GESHI_REPLACE => "\\0",
            GESHI_MODIFIERS => "i",
            GESHI_BEFORE => "",
            GESHI_AFTER => ""
        ],
        //Field-Assignments
        5 => [
            GESHI_SEARCH => "(?<=\s)[A-Z0-9\-]+(?==(?!\s|$))",
            GESHI_REPLACE => "\\0",
            GESHI_MODIFIERS => "mi",
            GESHI_BEFORE => "",
            GESHI_AFTER => ""
        ],
        //MIME type
        6 => [
            GESHI_SEARCH => "(?<=\s)(?:audio|application|image|multipart|text|" .
                "video|x-[a-z0-9\-]+)\/[a-z0-9][a-z0-9\-]*(?=\s|<|$)",
            GESHI_REPLACE => "\\0",
            GESHI_MODIFIERS => "m",
            GESHI_BEFORE => "",
            GESHI_AFTER => ""
        ]
    ],
    'STRICT_MODE_APPLIES' => GESHI_ALWAYS,
    'SCRIPT_DELIMITERS' => [
        0 => "/(^)[A-Z][a-zA-Z0-9\-]*\s*:\s*(?:.|(?=\n\s)\n)*($)/m"
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
        0 => true,
    ],
    'TAB_WIDTH' => 4,
    'PARSER_CONTROL' => [
        'KEYWORDS' => [
            2 => [
                'DISALLOWED_BEFORE' => '(?<=\A\x20|\n)',
                'DISALLOWED_AFTER' => '(?=\s*:)',
            ],
            3 => [
                'DISALLOWED_BEFORE' => '(?<=\A\x20|\n)',
                'DISALLOWED_AFTER' => '(?=\s*:)',
            ],
            4 => [
                'DISALLOWED_BEFORE' => '(?<=\s)',
                'DISALLOWED_AFTER' => '(?=\s|\b)',
            ]
        ],
        'ENABLE_FLAGS' => [
            'BRACKETS' => GESHI_NEVER,
            'COMMENTS' => GESHI_NEVER,
            'NUMBERS' => GESHI_NEVER
        ]
    ]
];
