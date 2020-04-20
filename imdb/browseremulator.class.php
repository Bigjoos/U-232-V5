<?php
###############################################################################
# Browser Emulating file functions v2.0
# (c) Kai Blankenhorn
# www.bitfolge.de/en
# kaib@bitfolge.de
# -----------------------------------------------------------------------------
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
###############################################################################

/** BrowserEmulator class. Provides methods for opening urls and emulating
 *  a web browser request.
 *
 * @package MDBApi
 * @class BrowserEmulator
 *
 * @author Kai Blankenhorn (kai AT bitfolge DOT de)
 */
class BrowserEmulator
{
    public $headerLines = [];
    public $postData = [];
    public $authUser = "";
    public $authPass = "";
    public $port;
    public $lastResponse = [];

    public function __construct()
    {
        $this->resetHeaderLines();
        $this->resetPort();
    }

    /** Add a single header field to the HTTP request header. The resulting
     *   header line will have the format "$name: $value\n"
     *
     * @method addHeaderLine
     *
     * @param string name
     * @param string value
     * @param mixed $name
     * @param mixed $value
     */
    public function addHeaderLine($name, $value)
    {
        $this->headerLines[$name] = $value;
    }

    /** Delete all custom header lines. This will not remove the User-Agent
     *   header field, which is necessary for correct operation.
     *
     * @method resetHeaderLines
     */
    public function resetHeaderLines()
    {
        $this->headerLines = [];
        if (in_array('HTTP_USER_AGENT', array_keys($_SERVER))) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $user_agent = 'Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3';
        }
        $this->headerLines["User-Agent"] = $user_agent;
    }

    /** Add a post parameter. Post parameters are sent in the body of an HTTP POST request.
     * @method addPostData
     *
     * @param string name
     * @param string value
     * @param mixed $name
     * @param mixed $value
     */
    public function addPostData($name, $value)
    {
        $this->postData[$name] = $value;
    }

    /** Delete all custom post parameters.
     * @method resetPostData
     */
    public function resetPostData()
    {
        $this->postData = [];
    }

    /** Set an auth user and password to use for the request.
     *  Set both as empty strings to disable authentication.
     *
     * @method setAuth
     *
     * @param string user
     * @param string pass
     * @param mixed $user
     * @param mixed $pass
     */
    public function setAuth($user, $pass)
    {
        $this->authUser = $user;
        $this->authPass = $pass;
    }

    /** Select a custom port to use for the request.
     * @method setPort
     *
     * @param int portNumber
     * @param mixed $portNumber
     */
    public function setPort($portNumber)
    {
        $this->port = $portNumber;
    }

    /** Reset the port used for request to the HTTP default (80).
     * @method resetPort
     */
    public function resetPort()
    {
        $this->port = 80;
    }

    /** Make an fopen call to $url with the parameters set by previous member
     *  method calls. Send all set headers, post data and user authentication data.
     *
     * @method fopen
     *
     * @param string url
     * @param mixed $url
     *
     * @return mixed file handle on success, FALSE otherwise
     */
    public function fopen($url)
    {
        $debug = false;

        $this->lastResponse = [];

        preg_match("~([a-z]*://)?([^:^/]*)(:([0-9]{1,5}))?(/.*)?~i", $url, $matches);
        if ($debug) {
            var_dump($matches);
        }
        $protocol = $matches[1];
        $server = $matches[2];
        $port = $matches[4];
        $path = $matches[5];
        if ($port != "") {
            $this->setPort($port);
        }
        if ($path == "") {
            $path = "/";
        }
        $socket = false;
        $socket = @fsockopen($server, $this->port);
        if ($socket) {
            $this->headerLines["Host"] = $server;

            if ($this->authUser != "" and $this->authPass != "") {
                $headers["Authorization"] = "Basic " . base64_encode($this->authUser . ":" . $this->authPass);
            }

            if (count($this->postData) == 0) {
                $request = "GET $path HTTP/1.0\r\n";
            } else {
                $request = "POST $path HTTP/1.0\r\n";
            }

            if ($debug) {
                echo $request;
            }
            fputs($socket, $request);

            if (count($this->postData) > 0) {
                $PostStringArray = [];
                foreach ($this->postData as $key => $value) {
                    $PostStringArray[] = "$key=$value";
                }
                $PostString = join("&", $PostStringArray);
                $this->headerLines["Content-Length"] = strlen($PostString);
            }

            foreach ($this->headerLines as $key => $value) {
                if ($debug) {
                    echo "$key: $value\n";
                }
                fputs($socket, "$key: $value\r\n");
            }
            if ($debug) {
                echo "\n";
            }
            fputs($socket, "\r\n");
            if (count($this->postData) > 0) {
                if ($debug) {
                    echo "$PostString";
                }
                fputs($socket, $PostString . "\r\n");
            }
        }
        if ($debug) {
            echo "\n";
        }
        if ($socket) {
            $line = fgets($socket, 1000);
            if ($debug) {
                echo $line;
            }
            $this->lastResponse[] = $line;
            $status = substr($line, 9, 3);
            while (trim($line = fgets($socket, 1000)) != "") {
                if ($debug) {
                    echo "$line";
                }
                $this->lastResponse[] = $line;
                if ($status == "401" and strpos($line, "WWW-Authenticate: Basic realm=\"")  === 0) {
                    fclose($socket);
                    return false;
                }
            }
        }
        return $socket;
    }

    /** Make an file call to $url with the parameters set by previous member
     *  method calls. Send all set headers, post data and user authentication data.
     *
     * @method file
     *
     * @param string url
     * @param mixed $url
     *
     * @return mixed array file on success, FALSE otherwise
     */
    public function file($url)
    {
        $file = [];
        $socket = $this->fopen($url);
        if ($socket) {
            $file = [];
            while (!feof($socket)) {
                $file[] = fgets($socket, 10000);
            }
        } else {
            return false;
        }
        return $file;
    }

    /** Get the latest server response
     * @method getLastResponseHeaders
     *
     * @return array lastResponse <ul>
     *               <li>0: HTTP response (e.g. "HTTP/1.1 404 Not Found")</li>
     *               <li>1: Date (e.g. "Date: Sun, 08 Jun 2008 16:36:37 GMT")</li>
     *               <li>2: ServerInfo (e.g. "Server: Apache/2.2.3 (Ubuntu) PHP/5.2.1"</li>
     *               <li>3: Content length (e.g. "Content-Length: 214"</li>
     *               <li>4: Connection (e.g. "Connection: close")</li>
     *               <li>5: Content type (e.g. "Content-Type: text/html; charset=iso-8859-1")</li></ul>
     */
    public function getLastResponseHeaders()
    {
        return $this->lastResponse;
    }
} // end class
