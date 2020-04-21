<?php
/*************************************************************************************
 * xorg_conf.php
 * ----------
 * Author: Milian Wolff (mail@milianw.de)
 * Copyright: (c) 2008 Milian Wolff (http://milianw.de)
 * Release Version: 1.0.8.3
 * Date Started: 2008/06/18
 *
 * xorg.conf language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/06/18 (1.0.8)
 *  -  Initial import
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
    'LANG_NAME' => 'Xorg configuration',
    'COMMENT_SINGLE' => [1 => '#'],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        // sections
        1 => [
            'Section', 'EndSection', 'SubSection', 'EndSubSection'
        ],
        2 => [
            // see http://www.x.org/archive/X11R6.9.0/doc/html/xorg.conf.5.html
            'BiosBase', 'Black', 'Boardname', 'BusID', 'ChipID', 'ChipRev',
            'Chipset', 'ClockChip', 'Clocks', 'DacSpeed',
            'DefaultDepth', 'DefaultFbBpp', 'Depth', 'Device',
            'DisplaySize', 'Driver', 'FbBpp', 'Gamma',
            'HorizSync', 'IOBase', 'Identifier', 'InputDevice',
            'Load', 'MemBase', 'Mode', 'Modeline', 'Modelname',
            'Modes', 'Monitor', 'Option', 'Ramdac', 'RgbPath',
            'Screen', 'TextClockFreq', 'UseModes', 'VendorName',
            'VertRefresh', 'VideoAdaptor', 'VideoRam',
            'ViewPort', 'Virtual', 'Visual', 'Weight', 'White'
        ],
        3 => [
            // some sub-keywords
            // screen position
            'Above', 'Absolute', 'Below', 'LeftOf', 'Relative', 'RightOf',
            // modes
            'DotClock', 'Flags', 'HSkew', 'HTimings', 'VScan', 'VTimings'
        ],
    ],
    'REGEXPS' => [
    ],
    'SYMBOLS' => [
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        3 => false
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #b1b100;',
            2 => 'color: #990000;',
            3 => 'color: #550000;'
        ],
        'COMMENTS' => [
            1 => 'color: #adadad; font-style: italic;',
        ],
        'ESCAPE_CHAR' => [
        ],
        'BRACKETS' => [
        ],
        'STRINGS' => [
            0 => 'color: #0000ff;',
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;'
        ],
        'METHODS' => [
        ],
        'SYMBOLS' => [
        ],
        'REGEXPS' => [
        ],
        'SCRIPT' => [
        ]
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => ''
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH' => 4
];
