<?php
/*************************************************************************************
 * text.php
 * --------
 * Author: Sean Hanna (smokingrope@gmail.com)
 * Copyright: (c) 2006 Sean Hanna
 * Release Version: 1.0.8.3
 * Date Started: 04/23/2006
 *
 * Standard Text File (No Syntax Highlighting).
 * Plaintext language file for GeSHi.
 *
 * CHANGES
 * -------
 * 04/23/2006 (0.5.0)
 * - Syntax File Created
 *
 * 04/27/2006 (1.0.0)
 * - Documentation Cleaned Up
 * - First Release
 *
 * TODO (updated 04/27/2006)
 * -------------------------
 *
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
    'LANG_NAME' => 'Text',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => [],
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => [],
    'SYMBOLS' => [],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false
    ],
    'STYLES' => [
        'KEYWORDS' => [],
        'COMMENTS' => [],
        'ESCAPE_CHAR' => [],
        'BRACKETS' => [],
        'STRINGS' => [],
        'NUMBERS' => [],
        'METHODS' => [],
        'SYMBOLS' => [],
        'SCRIPT' => [],
        'REGEXPS' => []
    ],
    'URLS' => [],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [],
    'REGEXPS' => [],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [],
    'HIGHLIGHT_STRICT_BLOCK' => [],
    'PARSER_CONTROL' => [
        'ENABLE_FLAGS' => [
            'ALL' => GESHI_NEVER
        ],
    ]
];
