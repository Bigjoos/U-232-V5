<?php
/*************************************************************************************
 * cmake.php
 * -------
 * Author: Daniel Nelson (danieln@eng.utah.edu)
 * Copyright: (c) 2009 Daniel Nelson
 * Release Version: 1.0.8.9
 * Date Started: 2009/04/06
 *
 * CMake language file for GeSHi.
 *
 * Keyword list generated using CMake 2.6.3.
 *
 * CHANGES
 * -------
 * <date-of-release> (<GeSHi release>)
 *  -  First Release
 *
 * TODO (updated <date-of-release>)
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
    'LANG_NAME' => 'CMake',
    'COMMENT_SINGLE' => [1 => '#'],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"'],
    'ESCAPE_CHAR' => '\\',
    'ESCAPE_REGEXP' => [
        // Quoted variables ${...}
        1 => "/\\$(ENV)?\\{[^\\n\\}]*?\\}/i",
        // Quoted registry keys [...]
        2 => "/\\[HKEY[^\n\\]]*?]/i"
    ],
    'KEYWORDS' => [
        1 => [
            'add_custom_command', 'add_custom_target', 'add_definitions',
            'add_dependencies', 'add_executable', 'add_library',
            'add_subdirectory', 'add_test', 'aux_source_directory', 'break',
            'build_command', 'cmake_minimum_required', 'cmake_policy',
            'configure_file', 'create_test_sourcelist', 'define_property',
            'else', 'elseif', 'enable_language', 'enable_testing',
            'endforeach', 'endfunction', 'endif', 'endmacro',
            'endwhile', 'execute_process', 'export', 'file', 'find_file',
            'find_library', 'find_package', 'find_path', 'find_program',
            'fltk_wrap_ui', 'foreach', 'function', 'get_cmake_property',
            'get_directory_property', 'get_filename_component', 'get_property',
            'get_source_file_property', 'get_target_property',
            'get_test_property', 'if', 'include', 'include_directories',
            'include_external_msproject', 'include_regular_expression',
            'install', 'link_directories', 'list', 'load_cache',
            'load_command', 'macro', 'mark_as_advanced', 'math', 'message',
            'option', 'output_required_files', 'project', 'qt_wrap_cpp',
            'qt_wrap_ui', 'remove_definitions', 'return', 'separate_arguments',
            'set', 'set_directory_properties', 'set_property',
            'set_source_files_properties', 'set_target_properties',
            'set_tests_properties', 'site_name', 'source_group', 'string',
            'target_link_libraries', 'try_compile', 'try_run', 'unset',
            'variable_watch', 'while'
        ],
        2 => [
            // Deprecated commands
            'build_name', 'exec_program', 'export_library_dependencies',
            'install_files', 'install_programs', 'install_targets',
            'link_libraries', 'make_directory', 'remove', 'subdir_depends',
            'subdirs', 'use_mangled_mesa', 'utility_source',
            'variable_requires', 'write_file'
        ],
        3 => [
            // Special command arguments, this list is not comprehesive.
            'AND', 'APPEND', 'ASCII', 'BOOL', 'CACHE', 'COMMAND', 'COMMENT',
            'COMPARE', 'CONFIGURE', 'DEFINED', 'DEPENDS', 'DIRECTORY',
            'EQUAL', 'EXCLUDE_FROM_ALL', 'EXISTS', 'FALSE', 'FATAL_ERROR',
            'FILEPATH', 'FIND', 'FORCE', 'GET', 'GLOBAL', 'GREATER',
            'IMPLICIT_DEPENDS', 'INSERT', 'INTERNAL', 'IS_ABSOLUTE',
            'IS_DIRECTORY', 'IS_NEWER_THAN', 'LENGTH', 'LESS',
            'MAIN_DEPENDENCY', 'MATCH', 'MATCHALL', 'MATCHES', 'MODULE', 'NOT',
            'NOTFOUND', 'OFF', 'ON', 'OR', 'OUTPUT', 'PARENT_SCOPE', 'PATH',
            'POLICY', 'POST_BUILD', 'PRE_BUILD', 'PRE_LINK', 'PROPERTY',
            'RANDOM', 'REGEX', 'REMOVE_AT', 'REMOVE_DUPLICATES', 'REMOVE_ITEM',
            'REPLACE', 'REVERSE', 'SEND_ERROR', 'SHARED', 'SORT', 'SOURCE',
            'STATIC', 'STATUS', 'STREQUAL', 'STRGREATER', 'STRING', 'STRIP',
            'STRLESS', 'SUBSTRING', 'TARGET', 'TEST', 'TOLOWER', 'TOUPPER',
            'TRUE', 'VERBATIM', 'VERSION', 'VERSION_EQUAL', 'VERSION_GREATOR',
            'VERSION_LESS', 'WORKING_DIRECTORY',
        ]
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => false,
        2 => false,
        3 => true
    ],
    'SYMBOLS' => [
        0 => ['(', ')']
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #1f3f81; font-style: bold;',
            2 => 'color: #1f3f81;',
            3 => 'color: #077807; font-sytle: italic;'
        ],
        'BRACKETS' => [],
        'COMMENTS' => [
            1 => 'color: #666666; font-style: italic;'
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;',
            1 => 'color: #b08000;',
            2 => 'color: #0000cd;'
        ],
        'STRINGS' => [
            0 => 'color: #912f11;',
        ],
        'SYMBOLS' => [
            0 => 'color: #197d8b;'
        ],
        'NUMBERS' => [],
        'METHODS' => [],
        'REGEXPS' => [
            0 => 'color: #b08000;',
            1 => 'color: #0000cd;'
        ],
        'SCRIPT' => []
    ],
    'URLS' => [
        1 => 'http://www.cmake.org/cmake/help/cmake2.6docs.html#command:{FNAMEL}',
        2 => 'http://www.cmake.org/cmake/help/cmake2.6docs.html#command:{FNAMEL}',
        3 => '',
    ],
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => [],
    'REGEXPS' => [
        // Unquoted variables
        0 => "\\$(ENV)?\\{[^\\n}]*?\\}",
        // Unquoted registry keys
        1 => "\\[HKEY[^\n\\]]*?]"
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [],
    'HIGHLIGHT_STRICT_BLOCK' => [],
    'TAB_WIDTH' => 4,
    'PARSER_CONTROL' => [
        'KEYWORDS' => [
            // These keywords cannot come after a open paren
            1 => [
                'DISALLOWED_AFTER' =>  '(?= *\()'
            ],
            2 => [
                'DISALLOWED_AFTER' =>  '(?= *\()'
            ]
        ],
        'ENABLE_FLAGS' => [
            'BRACKETS' => GESHI_NEVER,
            'METHODS' => GESHI_NEVER,
            'NUMBERS' => GESHI_NEVER
        ]
    ]
];
