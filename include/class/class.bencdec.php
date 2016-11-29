<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                                            |
 |--------------------------------------------------------------------------|
 |   Licence Info: WTFPL                                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5                                            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
/*
Author: djGrrr <djgrrr AT p2p-network DOT net>
Version: 1.2.5
Date: 2010-05-17
PHP Verion: 5.2.0 +

This is a new, faster, and easier to use b-encoding/decoding php library .
The b-encoding is slightly faster, and the b-decoding is exponentially faster
depending on how large the b-encoded data is; with your average torrent files
it is arround 2x - 3x faster, but on large torrents can be 100s of times faster.
The size of the arrays returned / used are also much smaller using less memory
because there is no need to define type/value keys. PHP Version 5.0.0 and up is
required.

Basic knowledge of how bencoding works is assumed. Details can be found
at http://wiki.theory.org/BitTorrentSpecification#bencoding

I borrowed a few ideas from the File_Bittorrent pear php package in order to
speedup the b-decoding process, but for the most part the code is completly
mine :)


Description of the functions:

string bencdec::encode(mixed $data);

Takes an associative array, numeric array, string, interger or NULL as argument
and returns the bencoded form of it as a string. Returns false on failure.

Numeric arrays return lists, associative arrays return dictionaries. Empty
arrays return an empty list, NULLs return an empty dictionary. Integers
are specified literally as a php integer without quotes.

Examples:
bencdec::encode('spam'); returns '4:spam'
bencdec::encode(3); returns 'i3e'
bencdec::encode(array('spam','eggs')); returns 'l4:spam4:eggse'

bencdec::encode(array(
'cow' => 'moo',
'spam' => 'eggs'
)); returns 'd3:cow3:moo4:spam4:eggse'

bencdec::encode(array()); returns 'le'
bencdec::encode(NULL); returns 'de'



mixed bencdec::decode(string $string [, int $options = 0 ]);

Returns an array, integer, string or NULL that results from bdecoding the given
string. There is now no need for these non-sense type / value keys, its now
much simpler. The examples should explain all you need to know :)
This function returns false on failure. The $options variable is a bitmask for
different decoding options, currently only bencdec::OPTION_EXTENDED_VALIDATION,
defaults to using no extra options.

Example:

bencdec::decode('d4:spaml11:spiced pork3:hamee');
returns this (not such a monster anymore):

array (
'spam' => array (
0 => 'spiced pork',
1 => 'ham'
)
)



mixed bencdec::decode_file(string $filename [, int $maxsize = 1048576 [, int $options = 0 ]]);

Opens the specified file, reads its contents (up to the specified length $maxsize),
and returns whatever bencdec::decode() returns for those contents. $options is the
same as above in bencdec::decode(). Returns false on error.



bool bencdec::encode_file(string $filename, mixed $data);

Creates the specified file, and writes the b-encoded version of $data returned
from bencdec::encode($data); to the file.
Returns false on error, true on sucess.


string bencdec::get_type(mixed $val);

Returns the type of decoded data; one of 'list','dictionary','integer','string'
This is to replace the old 'type' key.

Examples:

bencdec::get_type(50); returns 'integer'
bencdec::get_type(array(
'spam' => 'apples',
'pears' => 'oranges'
)); returns 'dictionary'



Last but not least, here are some speed tests:
First, this is with your average sized torrent (17kb .torrent with 52 files)
-----------------------
| Old Functions |
-----------------------
bdec took 0.01357s
benc took 0.00324s
-----------------------
| New Functions |
-----------------------
bencdec::decode took 0.00428s
speedup of 0.00929s
-----------------------
bencdec::encode took 0.00252s
speedup of 0.00072s
-----------------------

As you can see, the new functions are quite a bit faster even at small sizes
(especially decoding)

The real improvement comes with large torrents, the next test was done with a
large torrent (573kb .torrent with 2100 files)
-----------------------
| Old Functions |
-----------------------
bdec took 26.89945s
benc took 0.25493s
-----------------------
| New Functions |
-----------------------
bencdec::decode took 0.32813s
speedup of 26.57133s
-----------------------
bencdec::encode took 0.17533s
speedup of 0.0796s
-----------------------

As you can clearly see, the decoding is insanely faster than the old bdec
function, while the encoding still keeps its speed increase even with larger
files.

Another thing to note is that the new functions use a lot less ram than the old
ones, especially when dealing with large files :D


---------------------------------- Changelog ----------------------------------
0.9.0 - First completely working version, never released, decoding was actually
slower than the older functions at this point

1.0.0 - Complete rewrite of the decoding engine providing an insane speed
improvement.

1.0.1 - Added a get_type method to determine decoded data types (since type
keys are no longer used) :)

1.0.2 - Added documentation for get_type

1.0.3 - Changed [] to {} for character postion for slightly faster execution in
method char

1.1.0 - Fixed bug when dealing with 0 length strings
- Added in decoding debug custom php error messages that use E_USER_WARNING
error level

1.1.1 - Changed encoding so that a fully numeric array is needed to encode list
values, also, if an array is empty, it is considered a list, not a dictionary

1.2.0 - Added maximum recursion depth code to the decoding to prevent excessive
memory usage and possibly segfaults
- Fixed some bugs with looping code in decoding dictionaries and lists
- Added option to use extended validation in decoding to make sure the input
data is prefectly valid according to specs. This option will add additional
time to decoding so only use if nessasary.
- Added TYPE_* class constants and a function to determine the type of data
decoded, or the encoding type to use
- Changed the list type back to only checking [0] in the array, to speed up
things but still be accurate
- *NOTE* This version is slightly slower than the previous, but it handles
improperly bencoded data MUCH better, especially if you use extended validation

1.2.1 - Added in some additional checks when encoding lists and dictionaries,
returning false on errors
- Now its possible to have an empty dictionary by using NULL
- $val is now passed by reference in the method benc_type and casted where
its needed, this ruduces needless casts

1.2.2 - Fixed a bug dealing with integer values being outputed with scientific
notation.
- Adding options variable to decode_file function which simply passes the value
to the decode function

1.2.3 - Making a few optimizations in various places
- Use [] for stings offsets, {} has been depreciated in PHP 5.3

1.2.4 - Change the key sort order checking in decoding dictionaries with
extended validation to use strcmp instead of a direct < comparison
- Update some of the documentation.
- Change the sucessful check in encode_file function to make sure it writes the
complete contents of the bencdoded data.
- Add trigger_error to benc_type function if input type is invalid for b-encoding,
this will log a php error when trying to encode something that is invalid.
- Add error message in bdecode function if data ends unexpectedly.

1.2.5 - Fix input string '0:' for decoding, used to return false, now correctly
returns 0 length string ''
- Changed the initial input data check for decode() to give errors instwad of simply
returning false

*/
class bencdec
{
    const MAX_DEPTH = 16; // To prevent deep recursion which could potentially cause a very high ammount of memory
    // to be used
    const OPTION_EXTENDED_VALIDATION = 0x1; // Perform more validation. This will just make sure that all data being decoded
    // follows specifications. You won't get any invalid data when not using this option,
    // so only specify it if you need to make sure the data is perfectly valid as it will
    // slightly hurt decoding performance
    const TYPE_INT = 1;
    const TYPE_STR = 2;
    const TYPE_LIST = 3;
    const TYPE_DICT = 4;
    // initialize required variables for b-decoding
    private static $bdata = '';
    private static $bdata_length = 0;
    private static $bdata_position = 0;
    private static $bdata_depth = 0;
    private static $ext_valid = false;
    private static function decode_error($msg = '')
    {
        trigger_error('Badly B-Encoded data at position ' . self::$bdata_position . ($msg != '' ? ': ' . $msg : '') , E_USER_WARNING);
        self::$bdata_position = 0;
        self::$bdata_length = 0;
        self::$bdata = '';
        self::$bdata_depth = 0;
        self::$ext_valid = false;
        return false;
    }
    //////////////////////////////////////////////////////////
    // Decoding Functions //
    //////////////////////////////////////////////////////////
    public static function decode_file($fn, $maxsize = 1048576, $options = 0)
    {
        if (!is_string($fn) || !is_int($maxsize)) return false;
        if (!file_exists($fn) || !is_file($fn) || !is_readable($fn)) return false;
        $data = file_get_contents($fn, false, NULL, 0, $maxsize);
        return self::decode($data, $options);
    }
    public static function decode($str, $options = 0)
    {
        if (!is_string($str)) return self::decode_error('Input data must be string in order to decode, "' . gettype($str) . '" given');
        if (strlen($str) == 0) return self::decode_error('Input string empty');
        self::$bdata_position = 0;
        self::$bdata_depth = 0;
        self::$ext_valid = false;
        self::$bdata_length = strlen($str);
        self::$bdata = $str;
        unset($str);
        if ($options & self::OPTION_EXTENDED_VALIDATION) self::$ext_valid = true;
        $data = self::bdecode();
        if (self::$ext_valid) if (self::$bdata_position < self::$bdata_length) return self::decode_error('Garbage data at end');
        self::$bdata_position = 0;
        self::$bdata_length = 0;
        self::$bdata = '';
        self::$bdata_depth = 0;
        self::$ext_valid = false;
        return $data;
    }
    private static function char()
    {
        if (self::$bdata_position >= self::$bdata_length) return false;
        return self::$bdata[self::$bdata_position];
    }
    // Internal decoding function
    private static function bdecode()
    {
        $char = self::char();
        if ($char === false) return self::decode_error('B-encoded data ended unexpectedly');
        $ord = ord($char); // 1 function call and a comparison with integers is
        // faster than potentially 13 string comparisons
        switch ($ord) {
        case 105:
            return self::dec_int(); // i
            
        case 100:
            return self::dec_dict(); // d
            
        case 108:
            return self::dec_list(); // l
            
        case 48: // 0
            
        case 49: // 1
            
        case 50: // 2
            
        case 51: // 3
            
        case 52: // 4
            
        case 53: // 5
            
        case 54: // 6
            
        case 55: // 7
            
        case 56: // 8
            
        case 57: // 9
            return self::dec_str();
        default:
            return self::decode_error('Invalid data type (' . $ord . ')'); // invalid
            
        }
    }
    private static function dec_int()
    {
        $epos = @strpos(self::$bdata, 'e', ++self::$bdata_position);
        if ($epos === false) return self::decode_error('No ending "e" for integer');
        $lenuptoep = $epos - self::$bdata_position;
        $idata = @substr(self::$bdata, self::$bdata_position, $lenuptoep++);
        if (self::$ext_valid) {
            $ndata = $idata[0] === '-' ? @substr($idata, 1) : $idata;
            $len = strlen($ndata);
            if (!$len) return self::decode_error('Empty integer');
            if ($len > 1 && $ndata[0] === '0') return self::decode_error('Integer prefixed by 0');
            if (!ctype_digit($ndata)) return self::decode_error('Non-digit characters found in integer');
        }
        $int = 0 + $idata;
        self::$bdata_position+= $lenuptoep;
        return $int;
    }
    private static function dec_str($atleastone = false)
    {
        $colpos = @strpos(self::$bdata, ':', self::$bdata_position);
        if ($colpos === false) return self::decode_error('No ":" to separate string from length');
        $llen = $colpos - self::$bdata_position;
        $ldata = @substr(self::$bdata, self::$bdata_position, $llen++);
        if (self::$ext_valid) {
            if ($ldata[0] === '0' && strlen($ldata) > 1) return self::decode_error('String length prefixed by 0');
            if (!ctype_digit($ldata)) return self::decode_error('Non-digit characters found in string length');
        }
        $len = (int)$ldata;
        if ($atleastone) {
            if ($len < 1) return self::decode_error('String length must be at least 1');
        } elseif ($len < 0) return self::decode_error('String length cannot be negative');
        $string = @substr(self::$bdata, ++$colpos, $len);
        if (strlen($string) != $len) return self::decode_error('String was not expected length, data too short?');
        self::$bdata_position+= $llen + $len;
        return $string === false ? '' : $string;
    }
    private static function dec_list()
    {
        if (self::$bdata_depth >= self::MAX_DEPTH) return self::decode_error('B-Encoded data has exceeded the maximum recursion depth of ' . self::MAX_DEPTH);
        $list = array();
        self::$bdata_depth++;
        self::$bdata_position++;
        while (true) {
            $char = self::char();
            if ($char === false) return self::decode_error('Data ended before list terminated');
            if ($char === 'e') break;

            $data = self::bdecode();
            if ($data === false) return false;
            $list[] = $data;
            unset($data);
        }
        self::$bdata_position++;
        self::$bdata_depth--;
        return $list;
    }
    private static function dec_dict()
    {
        $dict = array();
        if (self::$bdata_depth >= self::MAX_DEPTH) return self::decode_error('B-Encoded data has exceeded the maximum recursion depth of ' . self::MAX_DEPTH);
        $last_name = '';
        self::$bdata_depth++;
        self::$bdata_position++;
        while (true) {
            $char = self::char();
            if ($char === false) return self::decode_error('Data ended before dictionary terminated');
            if ($char === 'e') break;

            $name = self::dec_str(true);
            if ($name === false) return false;
            if (self::$ext_valid) {
                if (isset($dict[$name])) return self::decode_error('Duplicate key "' . $name . '" in dictionary');
                if (strcmp($name, $last_name) < 1) return self::decode_error('Incorrect sort order in dictionary');
            }
            $data = self::bdecode();
            if ($data === false) return false;
            $dict[$name] = $data;
            $last_key = $name;
            unset($name, $data);
        }
        self::$bdata_position++;
        self::$bdata_depth--;
        return empty($dict) ? NULL : $dict;
    }
    //////////////////////////////////////////////////////////
    // Encoding Functions //
    //////////////////////////////////////////////////////////
    public static function encode_file($fn, $array)
    {
        if (!is_array($array) || !is_string($fn)) return false;
        $data = self::encode($array);
        unset($array);
        if ($data === false) return false;
        $d = file_put_contents($fn, $data);
        return ($d == strlen($data));
    }
    public static function encode($val)
    {
        $type = self::benc_type($val);
        switch ($type) {
        case self::TYPE_INT:
            return self::enc_int($val);
        case self::TYPE_STR:
            return self::enc_str($val);
        case self::TYPE_LIST:
            return self::enc_list($val);
        case self::TYPE_DICT:
            return self::enc_dict($val);
        default:
            return false;
        }
    }
    private static function enc_list($val)
    {
        ksort($val, SORT_NUMERIC);
        $list = 'l';
        foreach ($val as $value) {
            $data = self::encode($value);
            if ($data === false) return false;
            $list.= $data;
            unset($data);
        }
        $list.= 'e';
        return $list;
    }
    private static function enc_dict($val)
    {
        ksort($val, SORT_STRING);
        $dict = 'd';
        foreach ($val as $name => $value) {
            $data = self::encode($value);
            if ($data === false) return false;
            $dict.= self::enc_str((string)$name) . $data;
            unset($data);
        }
        $dict.= 'e';
        return $dict;
    }
    private static function enc_int($val)
    {
        return 'i' . $val . 'e';
    }
    private static function enc_str($val)
    {
        return strlen($val) . ':' . $val;
    }
    // internal function to determine type of encoding to use
    private static function benc_type(&$val)
    {
        if (is_array($val)) {
            if (empty($val) || isset($val[0])) return self::TYPE_LIST;
            return self::TYPE_DICT;
        }
        if (is_bool($val)) $val = (int)$val;
        if (is_int($val)) {
            $val = (string)$val;
            return self::TYPE_INT;
        }
        if (is_float($val)) {
            if (floor($val) == $val) {
                $val = (string)number_format($val, 0, '', '');
                return self::TYPE_INT;
            }
            $val = (string)$val;
            return self::TYPE_STR;
        }
        if (is_string($val)) return self::TYPE_STR;
        if (is_null($val)) {
            $val = array();
            return self::TYPE_DICT;
        }
        trigger_error('Bad input type for B-Encoding: ' . gettype($val) , E_USER_WARNING);
        return false;
    }
    public static function get_type($val)
    {
        $type = self::benc_type($val);
        switch ($type) {
        case self::TYPE_INT:
            return 'integer';
        case self::TYPE_STR:
            return 'string';
        case self::TYPE_LIST:
            return 'list';
        case self::TYPE_DICT:
            return 'dictionary';
        default:
            return false;
        }
    }
}
// vim: syntax=php ts=4

?>
