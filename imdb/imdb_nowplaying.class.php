<?php
#############################################################################
# IMDBPHP                              (c) Giorgos Giagas & Itzchak Rehberg #
# written by Giorgos Giagas                                                 #
# extended & maintained by Itzchak Rehberg <izzysoft AT qumran DOT org>     #
# http://www.izzysoft.de/                                                   #
# ------------------------------------------------------------------------- #
# IMDBPHP NOW PLAYING                   (c) Ricardo Silva & Itzchak Rehberg #
# written by Ricardo Silva (banzap) <banzap@gmail.com>                      #
# http://www.ricardosilva.pt.tl/                                            #
# ------------------------------------------------------------------------- #
# This program is free software; you can redistribute and/or modify it      #
# under the terms of the GNU General Public License (see doc/LICENSE)       #
#############################################################################
# $Id: imdb_nowplaying.class.php 690 2014-08-05 07:29:19Z izzy $

require_once(dirname(__FILE__) . "/mdb_base.class.php");

#=================================================[ The IMDB Person class ]===
/** Obtain the Now Playing Movies in theaters of USA, from IMDB
 * @package IMDB
 * @class imdb_nowplaying
 *
 * @author Ricardo Silva (banzap) <banzap@gmail.com>
 * @author Itzchak Rehberg
 *
 * @version $Revision: 690 $ $Date: 2014-08-05 08:29:19 +0100 (Tue, 05 Aug 2014) $
 */
class imdb_nowplaying
{
    public $nowplayingpage = "http://www.imdb.com/movies-in-theaters/";
    public $page = "";

    /**
     * Constructor: Obtain the raw data from IMDB site
     *
     * @param object mdb_config Optionally pass in the mdb_config object to use
     * @param null|mdb_config $iconf
     */
    public function __construct(mdb_config $iconf = null)
    {
        $req = new MDB_Request($this->nowplayingpage, $config);
        $req->sendRequest();
        $this->page=$req->getResponseBody();
        $this->revision = preg_replace('|^.*?(\d+).*$|', '$1', '$Revision: 690 $');
    }

    /** Retrieve the Now Playing Movies
     * @method getNowPlayingMovies
     *
     * @return array of IMDB IDs
     */
    public function getNowPlayingMovies()
    {
        $matchinit = '<h1 class="header">';
        $matchend = "<!-- begin TOP_RHS -->";
        $init_pos = strpos($this->page, $matchinit);
        $end_pos = strpos($this->page, $matchend);
        //$pattern = '!href="/title/tt(\d{7})/!';
        $pattern = '!rg/in-theaters/overview-title/images/b.gif\?link=/title/tt(\d+)!';
        if (preg_match_all($pattern, substr($this->page, $init_pos, $end_pos - $init_pos), $matches)) {
            $res = array_values(array_unique($matches[1]));
        } else {
            $res = [];
        }
        return $res;
    }

    /** Retrieve the Top 10 Box Office Movies
     * @method getTop10BoxOfficeMovies
     *
     * @return array[0..n] of IMDB IDs
     *
     * @author almathie
     * @author izzy
     */
    public function getTop10BoxOfficeMovies()
    {
        $matchinit = "<h3>In Theaters Now - Box Office Top Ten";
        $matchend = '<div class=" see-more">';
        $init_pos = strpos($this->page, $matchinit);
        $end_pos = strpos($this->page, $matchend, $init_pos);
        $pattern = '!rg/in-theaters/overview-title/images/b.gif\?link=/title/tt(\d+)!';
        if (preg_match_all($pattern, substr($this->page, $init_pos, $end_pos - $init_pos), $matches)) {
            $res = array_values(array_unique($matches[1]));
        } else {
            $res = [];
        }
        return $res;
    }
} // endOfClass
