<?php
/*************************************************************************************
 * io.php
 * -------
 * Author: Nigel McNie (nigel@geshi.org)
 * Copyright: (c) 2006 Nigel McNie (http://qbnz.com/highlighter/)
 * Release Version: 1.0.8.3
 * Date Started: 2006/09/23
 *
 * Io language file for GeSHi. Thanks to Johnathan Wright for the suggestion and help
 * with this language :)
 *
 * CHANGES
 * -------
 * 2006/09/23(1.0.0)
 *  -  First Release
 *
 * TODO
 * -------------------------
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
    'LANG_NAME' => 'Io',
    'COMMENT_SINGLE' => [1 => '//', 2 => '#'],
    'COMMENT_MULTI' => ['/*' => '*/'],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => [
            'and', 'break', 'else', 'elseif', 'exit', 'for', 'foreach', 'if', 'ifFalse', 'ifNil',
            'ifTrue', 'or', 'pass', 'raise', 'return', 'then', 'try', 'wait', 'while', 'yield'
        ],
        2 => [
            'activate', 'activeCoroCount', 'asString', 'block', 'catch', 'clone', 'collectGarbage',
            'compileString', 'continue', 'do', 'doFile', 'doMessage', 'doString', 'forward',
            'getSlot', 'getenv', 'hasSlot', 'isActive', 'isNil', 'isResumable', 'list', 'message',
            'method', 'parent', 'pause', 'perform', 'performWithArgList', 'print', 'proto',
            'raiseResumable', 'removeSlot', 'resend', 'resume', 'schedulerSleepSeconds', 'self',
            'sender', 'setSchedulerSleepSeconds', 'setSlot', 'shallowCopy', 'slotNames', 'super',
            'system', 'thisBlock', 'thisContext', 'thisMessage', 'type', 'uniqueId', 'updateSlot',
            'write'
        ],
        3 => [
            'Array', 'AudioDevice', 'AudioMixer', 'Block', 'Box', 'Buffer', 'CFunction', 'CGI',
            'Color', 'Curses', 'DBM', 'DNSResolver', 'DOConnection', 'DOProxy', 'DOServer',
            'Date', 'Directory', 'Duration', 'DynLib', 'Error', 'Exception', 'FFT', 'File',
            'Fnmatch', 'Font', 'Future', 'GL', 'GLE', 'GLScissor', 'GLU', 'GLUCylinder',
            'GLUQuadric', 'GLUSphere', 'GLUT', 'Host', 'Image', 'Importer', 'LinkList', 'List',
            'Lobby', 'Locals', 'MD5', 'MP3Decoder', 'MP3Encoder', 'Map', 'Message', 'Movie',
            'NULL', 'Nil', 'Nop', 'Notifiction', 'Number', 'Object', 'OpenGL', 'Point', 'Protos',
            'Regex', 'SGMLTag', 'SQLite', 'Server', 'ShowMessage', 'SleepyCat', 'SleepyCatCursor',
            'Socket', 'SocketManager', 'Sound', 'Soup', 'Store', 'String', 'Tree', 'UDPSender',
            'UDPReceiver', 'URL', 'User', 'Warning', 'WeakLink'
        ]
    ],
    'SYMBOLS' => [
        '(', ')', '[', ']', '{', '}', '!', '@', '%', '&', '*', '|', '/', '<', '>'
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        3 => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #b1b100;',
            2 => 'color: #000000; font-weight: bold;',
            3 => 'color: #000066;'
        ],
        'COMMENTS' => [
            1 => 'color: #808080; font-style: italic;',
            2 => 'color: #808080; font-style: italic;',
            'MULTI' => 'color: #808080; font-style: italic;'
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
            1 => 'color: #006600;',
            2 => 'color: #006600;'
        ],
        'SYMBOLS' => [
            0 => 'color: #66cc66;'
        ],
        'REGEXPS' => [
        ],
        'SCRIPT' => [
            0 => ''
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
    'REGEXPS' => [
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ]
];
