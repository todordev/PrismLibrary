<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Short File Description
 * 
 * PHP version 5
 * 
 * @category   aCategory
 * @package    aPackage
 * @subpackage aSubPackage
 * @author     anAuthor
 * @copyright  2014 a Copyright
 * @license    a License
 * @link       http://www.aLink.com
 */
namespace Blockchain\Explorer;

/**
 * Short Class Description
 * 
 * PHP version 5
 * 
 * @category   aCategory
 * @package    aPackage
 * @subpackage aSubPackage
 * @author     anAuthor
 * @copyright  2014 a Copyright
 * @license    a License
 * @link       http://www.aLink.com
 */
class InventoryData 
{
    /**
     * Properties
     */
    public $hash;                       // string
    public $type;                       // string
    public $initial_time;               // int
    public $initial_ip;                 // string
    public $nconnected;                 // int
    public $relayed_count;              // int
    public $relayed_percent;            // int

    /**
     * Methods
     */
    /**
     * @param $json
     */
    public function __construct($json) {
        if(array_key_exists('hash', $json))
            $this->hash = $json['hash'];
        if(array_key_exists('type', $json))
            $this->type = $json['type'];
        if(array_key_exists('initial_time', $json))
            $this->initial_time = $json['initial_time'];
        if(array_key_exists('initial_ip', $json))
            $this->initial_ip = $json['initial_ip'];
        if(array_key_exists('nconnected', $json))
            $this->nconnected = $json['nconnected'];
        if(array_key_exists('relayed_count', $json))
            $this->relayed_count = $json['relayed_count'];
        if(array_key_exists('relayed_percen', $json))
            $this->relayed_percen = $json['relayed_percen'];
    }
}