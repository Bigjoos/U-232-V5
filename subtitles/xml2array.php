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
/**
 * xml2array Class
 * Uses PHP 5 DOM Functions
 *
 * This class converts XML data to array representation.
 *
 */
class Xml2Array
{
    /**
     * XML Dom instance
     *
     * @var XML DOM Instance
     */
    private $xml_dom;

    /**
     * Array representing xml
     *
     * @var array
     */
    private $xml_array;

    /**
     * XML data
     *
     * @var String
     */
    private $xml;


    public function __construct($xml = '')
    {
        $this->xml = $xml;
    }

    public function setXml($xml)
    {
        if (!empty($xml)) {
            $this->xml = $xml;
        }
    }

    /**
     * Change xml data-to-array
     *
     * @return Array
     */
    public function get_array()
    {
        if ($this->get_dom() === false) {
            return false;
        }

        $this->xml_array = [];
        $root_element = $this->xml_dom->firstChild;
        $this->xml_array[$root_element->tagName] = $this->node_2_array($root_element);

        return $this->xml_array;
    }

    private function node_2_array($dom_element)
    {
        if ($dom_element->nodeType != XML_ELEMENT_NODE) {
            return false;
        }

        $children = $dom_element->childNodes;

        foreach ($children as $child) {
            if ($child->nodeType != XML_ELEMENT_NODE) {
                continue;
            }

            $prefix = ($child->prefix) ? $child->prefix . ':' : '';

            if (!is_array($result[$prefix . $child->nodeName])) {
                $subnode = false;

                foreach ($children as $test_node) {
                    if ($child->nodeName == $test_node->nodeName && !$child->isSameNode($test_node)) {
                        $subnode = true;
                        break;
                    }
                }
            } else {
                $subnode = true;
            }

            if ($subnode) {
                $result[$prefix . $child->nodeName][] = $this->node_2_array($child);
            } else {
                $result[$prefix . $child->nodeName] = $this->node_2_array($child);
            }
        }

        if (!is_array($result)) {
            $result['#text'] = html_entity_decode(htmlentities($dom_element->nodeValue, ENT_COMPAT, 'UTF-8'), ENT_COMPAT, 'ISO-8859-15');
        }

        if ($dom_element->hasAttributes()) {
            foreach ($dom_element->attributes as $attrib) {
                $prefix = ($attrib->prefix) ? $attrib->prefix . ':' : '';
                $result["@" . $prefix . $attrib->nodeName] = $attrib->nodeValue;
            }
        }

        return $result;
    }

    /**
     * Generated XML Dom
     *
     */
    private function get_dom()
    {
        if (empty($this->xml)) {
            echo 'No XML found. Please set XML data using setXML($xml)';
            return false;
        }

        $this->xml_dom = @DOMDocument::loadXML($this->xml);

        if ($this->xml_dom) {
            return $this->xml_dom;
        }

        echo 'Invalid XML data';
        exit;
    }
}
