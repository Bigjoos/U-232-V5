<?php
/*************************************************************************************
 * make.php
 * --------
 * Author: Neil Bird <phoenix@fnxweb.com>
 * Copyright: (c) 2008 Neil Bird
 * Release Version: 1.0.8.3
 * Date Started: 2008/08/26
 *
 * make language file for GeSHi.
 *
 * (GNU make specific)
 *
 * CHANGES
 * -------
 * 2008/09/05 (1.0.0)
 *  -  First Release
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
    'LANG_NAME' => 'GNU make',
    'COMMENT_SINGLE' => [1 => '#'],
    'COMMENT_REGEXP' => [
        //Escaped String Starters
        2 => "/\\\\['\"]/siU"
    ],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ["'", '"'],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => [
            // core
            'ifeq', 'else', 'endif', 'ifneq', 'ifdef', 'ifndef',
            'include', 'vpath', 'export', 'unexport', 'override',
            'info', 'warning', 'error'
        ],
        2 => [
            // macros, literals
            '.SUFFIXES', '.PHONY', '.DEFAULT', '.PRECIOUS', '.IGNORE', '.SILENT', '.EXPORT_ALL_VARIABLES', '.KEEP_STATE',
            '.LIBPATTERNS', '.NOTPARALLEL', '.DELETE_ON_ERROR', '.INTERMEDIATE', '.POSIX', '.SECONDARY'
        ],
        /*
        3 => array(
            // funcs - see regex
            //'subst', 'addprefix', 'addsuffix', 'basename', 'call', 'dir', 'error', 'eval', 'filter-out', 'filter',
            //'findstring', 'firstword', 'foreach', 'if', 'join', 'notdir', 'origin', 'patsubst', 'shell', 'sort', 'strip',
            //'suffix', 'warning', 'wildcard', 'word', 'wordlist', 'words'
            )*/
    ],
    'SYMBOLS' => [
        '(', ')', '[', ']', '{', '}',
        '!', '@', '%', '&', '|', '/',
        '<', '>',
        '=', '-', '+', '*',
        '.', ':', ',', ';',
        '$'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        //3 => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #666622; font-weight: bold;',
            2 => 'color: #990000;',
            //3 => 'color: #000000; font-weight: bold;'
        ],
        'COMMENTS' => [
            1 => 'color: #339900; font-style: italic;',
            2 => 'color: #000099; font-weight: bold;',
            'MULTI' => ''
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;'
        ],
        'BRACKETS' => [  # keep same as symbols so as to make ${} and $() equiv.
            0 => 'color: #004400;'
        ],
        'STRINGS' => [
            0 => 'color: #CC2200;'
        ],
        'NUMBERS' => [
            0 => 'color: #CC2200;'
        ],
        'SYMBOLS' => [
            0 => 'color: #004400;'
        ],
        'REGEXPS' => [
            0 => 'color: #000088; font-weight: bold;',
            1 => 'color: #0000CC; font-weight: bold;',
            2 => 'color: #000088;'
        ],
        'SCRIPT' => [],
        'METHODS' => []
    ],
    'URLS' => [
        1 => '',
        2 => '',
        //3 => ''
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [],
    'REGEXPS' => [
        //Simple variables
        0 => "\\$(?:[^{(&]|&(?:amp|lt|gt);)",
        //Complex variables/functions [built-ins]
        1 => [
            GESHI_SEARCH => '(\\$[({])(subst|addprefix|addsuffix|basename|call|dir|error|eval|filter-out|filter,|findstring|firstword|foreach|if|join|notdir|origin|patsubst|shell|sort|strip,|suffix|warning|wildcard|word|wordlist|words)([ })])',
            GESHI_REPLACE => '\\2',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '\\1',
            GESHI_AFTER => '\\3'
        ],
        //Complex variables/functions [others]
        2 => [
            GESHI_SEARCH => '(\\$[({])([A-Za-z_][A-Za-z_0-9]*)([ })])',
            GESHI_REPLACE => '\\2',
            GESHI_MODIFIERS => '',
            GESHI_BEFORE => '\\1',
            GESHI_AFTER => '\\3'
        ],
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [],
    'HIGHLIGHT_STRICT_BLOCK' => [],
    'TAB_WIDTH' => 8
    // vim: set sw=4 sts=4 :
];
