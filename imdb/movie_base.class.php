<?php
 #############################################################################
 # IMDBPHP.Movie                                         (c) Itzchak Rehberg #
 # written by Itzchak Rehberg <izzysoft AT qumran DOT org>                   #
 # http://www.izzysoft.de/                                                   #
 # ------------------------------------------------------------------------- #
 # This program is free software; you can redistribute and/or modify it      #
 # under the terms of the GNU General Public License (see doc/LICENSE)       #
 #############################################################################

 /* $Id: movie_base.class.php 691 2014-08-05 08:07:22Z izzy $ */

 require_once(dirname(__FILE__) . "/mdb_base.class.php");

#===================================================[ The Movie Base class ]===
/** Accessing Movie information
 * @package MDBApi
 *
 * @author Izzy (izzysoft AT qumran DOT org)
 * @copyright (c) 2009 by Itzchak Rehberg and IzzySoft
 *
 * @version $Revision: 691 $ $Date: 2014-08-05 09:07:22 +0100 (Tue, 05 Aug 2014) $
 */
class movie_base extends mdb_base
{
    protected $page = [];

    protected $akas = [];
    protected $awards = [];
    protected $countries = [];
    protected $castlist = []; // pilot only
    protected $crazy_credits = [];
    protected $credits_cast = [];
    protected $credits_composer = [];
    protected $credits_director = [];
    protected $credits_producer = [];
    protected $credits_writing = [];
    protected $extreviews = [];
    protected $goofs = [];
    protected $langs = [];
    protected $langs_full = [];
    protected $aspectratio = "";
    protected $main_comment = "";
    protected $main_genre = "";
    protected $main_keywords = [];
    protected $all_keywords = [];
    protected $main_language = "";
    protected $main_photo = "";
    protected $main_thumb = "";
    protected $main_pictures = [];
    protected $main_plotoutline = "";
    protected $main_rating = -1;
    protected $main_runtime = "";
    protected $main_movietype = "";
    protected $main_title = "";
    protected $original_title = "";
    protected $main_votes = -1;
    protected $main_year = -1;
    protected $main_endyear = -1;
    protected $main_yearspan = [];
    protected $main_creator = [];
    protected $main_tagline = "";
    protected $main_storyline = "";
    protected $main_prodnotes = [];
    protected $main_movietypes = [];
    protected $main_top250 = -1;
    protected $moviecolors = [];
    protected $movieconnections = [];
    protected $moviegenres = [];
    protected $moviequotes = [];
    protected $movierecommendations = [];
    protected $movieruntimes = [];
    protected $mpaas = [];
    protected $mpaas_hist = [];
    protected $mpaa_justification = "";
    protected $plot_plot = [];
    protected $synopsis_wiki = "";
    protected $release_info = [];
    protected $seasoncount = -1;
    protected $season_episodes = [];
    protected $sound = [];
    protected $soundtracks = [];
    protected $split_comment = [];
    protected $split_plot = [];
    protected $taglines = [];
    protected $trailers = [];
    protected $video_sites = [];
    protected $soundclip_sites = [];
    protected $photo_sites = [];
    protected $misc_sites = [];
    protected $trivia = [];
    protected $compcred_prod = [];
    protected $compcred_dist = [];
    protected $compcred_special = [];
    protected $compcred_other = [];
    protected $parental_guide = [];
    protected $official_sites = [];
    protected $locations = [];

    /**
     * Initialize class
     *
     * @constructor movie_base
     *
     * @param string id IMDBID to use for data retrieval
     * @param optional object mdb_config override default config
     * @param mixed           $id
     * @param null|mdb_config $config
     */
    public function __construct($id, mdb_config $config = null)
    {
        parent::__construct($config);
        $this->reset_vars();
    }

    /**
     * Reset all in object caching data e.g. page strings and parsed values
     *
     * @method reset_vars
     */
    protected function reset_vars()
    {
        $this->page["Title"] = "";
        $this->page["TitleFoot"] = ""; // IMDB only, as part of info was outsourced
        $this->page["Credits"] = "";
        $this->page["CrazyCredits"] = "";
        $this->page["Amazon"] = "";
        $this->page["Goofs"] = "";
        $this->page["Trivia"] = "";
        $this->page["Plot"] = "";
        $this->page["Synopsis"] = "";
        $this->page["Comments"] = "";
        $this->page["Quotes"] = "";
        $this->page["Taglines"] = "";
        $this->page["Plotoutline"] = "";
        $this->page["Trivia"] = "";
        $this->page["Directed"] = "";
        $this->page["Episodes"] = "";
        $this->page["Quotes"] = "";
        $this->page["Trailers"] = "";
        $this->page["MovieConnections"] = "";
        $this->page["ExtReviews"] = "";
        $this->page["ReleaseInfo"] = "";
        $this->page["CompanyCredits"] = "";
        $this->page["ParentalGuide"] = "";
        $this->page["OfficialSites"] = "";
        $this->page["Keywords"] = "";
        $this->page["Awards"] = "";
        $this->page["Locations"] = "";
        $this->page["VideoSites"] = "";

        $this->akas = [];
        $this->awards = [];
        $this->countries = [];
        $this->castlist = []; // pilot only
        $this->crazy_credits = [];
        $this->credits_cast = [];
        $this->credits_composer = [];
        $this->credits_director = [];
        $this->credits_producer = [];
        $this->credits_writing = [];
        $this->extreviews = [];
        $this->goofs = [];
        $this->langs = [];
        $this->langs_full = [];
        $this->aspectratio = "";
        $this->main_comment = "";
        $this->main_genre = "";
        $this->main_keywords = [];
        $this->all_keywords = [];
        $this->main_language = "";
        $this->main_photo = "";
        $this->main_thumb = "";
        $this->main_pictures = [];
        $this->main_plotoutline = "";
        $this->main_rating = -1;
        $this->main_runtime = "";
        $this->main_movietype = "";
        $this->main_title = "";
        $this->original_title = "";
        $this->main_votes = -1;
        $this->main_year = -1;
        $this->main_endyear = -1;
        $this->main_yearspan = [];
        $this->main_creator = [];
        $this->main_tagline = "";
        $this->main_storyline = "";
        $this->main_prodnotes = [];
        $this->main_movietypes = [];
        $this->main_top250 = -1;
        $this->moviecolors = [];
        $this->movieconnections = [];
        $this->moviegenres = [];
        $this->moviequotes = [];
        $this->movierecommendations = [];
        $this->movieruntimes = [];
        $this->mpaas = [];
        $this->mpaas_hist = [];
        $this->mpaa_justification = "";
        $this->plot_plot = [];
        $this->synopsis_wiki = "";
        $this->release_info = [];
        $this->seasoncount = -1;
        $this->season_episodes = [];
        $this->sound = [];
        $this->soundtracks = [];
        $this->split_comment = [];
        $this->split_plot = [];
        $this->taglines = [];
        $this->trailers = [];
        $this->video_sites = [];
        $this->soundclip_sites = [];
        $this->photo_sites = [];
        $this->misc_sites = [];
        $this->trivia = [];
        $this->compcred_prod = [];
        $this->compcred_dist = [];
        $this->compcred_special = [];
        $this->compcred_other = [];
        $this->parental_guide = [];
        $this->official_sites = [];
        $this->locations = [];
    }
}
