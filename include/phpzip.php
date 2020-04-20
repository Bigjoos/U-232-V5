<?php
/**
 * |--------------------------------------------------------------------------|
 * |   https://github.com/Bigjoos/                                            |
 * |--------------------------------------------------------------------------|
 * |   Licence Info: WTFPL                                                    |
 * |--------------------------------------------------------------------------|
 * |   Copyright (C) 2010 U-232 V5                                            |
 * |--------------------------------------------------------------------------|
 * |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 * |--------------------------------------------------------------------------|
 * |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 * |--------------------------------------------------------------------------|
 * _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 * / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
 * ( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 * \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
//
// PHPZip v1.2 by Sext (sext@neud.net) 2002-11-18
// 	(Changed: 2003-03-01)
//
// Makes zip archive
//
// Based on "Zip file creation class", uses zLib
//
// Examples in sample1.php, sample2.php and sample3.php
//
class PHPZip
{
    public function Zip($dir, $zipfilename)
    {
        if (@function_exists('gzcompress')) {
            $curdir = getcwd();
            if (is_array($dir)) {
                $filelist = $dir;
            } else {
                $filelist = $this->GetFileList($dir);
            }
            if ((!empty($dir)) && (!is_array($dir)) && (file_exists($dir))) {
                chdir($dir);
            } else {
                chdir($curdir);
            }
            if (count($filelist) > 0) {
                foreach ($filelist as $filename) {
                    if (is_file($filename)) {
                        $fd = fopen($filename, "r");
                        $content = fread($fd, filesize($filename));
                        fclose($fd);
                        if (is_array($dir)) {
                            $filename = basename($filename);
                        }
                        $this->addFile($content, $filename);
                    }
                }
                $out = $this->file();
                chdir($curdir);
                $fp = fopen($zipfilename, "w");
                fwrite($fp, $out, strlen($out));
                fclose($fp);
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function GetFileList($dir)
    {
        if (file_exists($dir)) {
            $args = func_get_args();
            $pref = $args[1];
            $dh = opendir($dir);
            while ($files = readdir($dh)) {
                if (($files != ".") && ($files != "..")) {
                    if (is_dir($dir . $files)) {
                        $curdir = getcwd();
                        chdir($dir . $files);
                        $file = array_merge($file, $this->GetFileList("", "$pref$files/"));
                        chdir($curdir);
                    } else {
                        $file[] = $pref . $files;
                    }
                }
            }
            closedir($dh);
        }
        return $file;
    }
    public $datasec = [];
    public $ctrl_dir = [];
    public $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    public $old_offset = 0;
    /**
     * Converts an Unix timestamp to a four byte DOS date and time format (date
     * in high two bytes, time in low two bytes allowing magnitude comparison).
     *
     * @param  int  the current Unix timestamp
     * @param mixed $unixtime
     *
     * @return int the current date in a four byte DOS format
     *
     * @access private
     */
    public function unix2DosTime($unixtime = 0)
    {
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);
        if ($timearray['year'] < 1980) {
            $timearray['year'] = 1980;
            $timearray['mon'] = 1;
            $timearray['mday'] = 1;
            $timearray['hours'] = 0;
            $timearray['minutes'] = 0;
            $timearray['seconds'] = 0;
        } // end if
        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) | ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    } // end of the 'unix2DosTime()' method
    /**
     * Adds "file" to archive
     *
     * @param  string   file contents
     * @param  string   name of the file in the archive (may contains the path)
     * @param  int  the current timestamp
     * @param mixed $data
     * @param mixed $name
     * @param mixed $time
     *
     * @access public
     */
    public function addFile($data, $name, $time = 0)
    {
        $name = str_replace('\\', '/', $name);
        $dtime = dechex($this->unix2DosTime($time));
        $hexdtime = '\x' . $dtime[6] . $dtime[7] . '\x' . $dtime[4] . $dtime[5] . '\x' . $dtime[2] . $dtime[3] . '\x' . $dtime[0] . $dtime[1];
        eval('$hexdtime = "' . $hexdtime . '";');
        $fr = "\x50\x4b\x03\x04";
        $fr.= "\x14\x00"; // ver needed to extract
        $fr.= "\x00\x00"; // gen purpose bit flag
        $fr.= "\x08\x00"; // compression method
        $fr.= $hexdtime; // last mod time and date
        // "local file header" segment
        $unc_len = strlen($data);
        $crc = crc32($data);
        $zdata = gzcompress($data);
        $c_len = strlen($zdata);
        $zdata = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug
        $fr.= pack('V', $crc); // crc32
        $fr.= pack('V', $c_len); // compressed filesize
        $fr.= pack('V', $unc_len); // uncompressed filesize
        $fr.= pack('v', strlen($name)); // length of filename
        $fr.= pack('v', 0); // extra field length
        $fr.= $name;
        // "file data" segment
        $fr.= $zdata;
        // "data descriptor" segment (optional but necessary if archive is not
        // served as file)
        $fr.= pack('V', $crc); // crc32
        $fr.= pack('V', $c_len); // compressed filesize
        $fr.= pack('V', $unc_len); // uncompressed filesize
        // add this entry to array
        $this->datasec[] = $fr;
        $new_offset = strlen(implode('', $this->datasec));
        // now add to central directory record
        $cdrec = "\x50\x4b\x01\x02";
        $cdrec.= "\x00\x00"; // version made by
        $cdrec.= "\x14\x00"; // version needed to extract
        $cdrec.= "\x00\x00"; // gen purpose bit flag
        $cdrec.= "\x08\x00"; // compression method
        $cdrec.= $hexdtime; // last mod time & date
        $cdrec.= pack('V', $crc); // crc32
        $cdrec.= pack('V', $c_len); // compressed filesize
        $cdrec.= pack('V', $unc_len); // uncompressed filesize
        $cdrec.= pack('v', strlen($name)); // length of filename
        $cdrec.= pack('v', 0); // extra field length
        $cdrec.= pack('v', 0); // file comment length
        $cdrec.= pack('v', 0); // disk number start
        $cdrec.= pack('v', 0); // internal file attributes
        $cdrec.= pack('V', 32); // external file attributes - 'archive' bit set
        $cdrec.= pack('V', $this->old_offset); // relative offset of local header
        $this->old_offset = $new_offset;
        $cdrec.= $name;
        // optional extra field, file comment goes here
        // save to central directory
        $this->ctrl_dir[] = $cdrec;
    } // end of the 'addFile()' method
    /**
     * Dumps out file
     *
     * @return string the zipped file
     *
     * @access public
     */
    public function file()
    {
        $data = implode('', $this->datasec);
        $ctrldir = implode('', $this->ctrl_dir);
        return $data . $ctrldir . $this->eof_ctrl_dir . pack('v', sizeof($this->ctrl_dir)) . // total # of entries "on this disk"
        pack('v', sizeof($this->ctrl_dir)) . // total # of entries overall
        pack('V', strlen($ctrldir)) . // size of central dir
        pack('V', strlen($data)) . // offset to start of central dir
        "\x00\x00"; // .zip file comment length
    } // end of the 'file()' method
    public function forceDownload($archiveName)
    {
        $headerInfo = '';
        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }
        // Security checks
        if ($archiveName == "") {
            echo "<html><title>Public Photo Directory - Download </title><body><br /><b>ERROR:</b> The download file was NOT SPECIFIED.</body></html>";
            exit;
        } elseif (!file_exists($archiveName)) {
            echo "<html><title>Public Photo Directory - Download </title><body><br /><b>ERROR:</b> File not found.</body></html>";
            exit;
        }
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/zip");
        //header("Content-Encoding: zlib,deflate,gzip");
        header("Content-Disposition: attachment; filename=" . basename($archiveName) . ";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($archiveName));
        readfile("$archiveName");
    }
} // end of the 'PHPZip' class
