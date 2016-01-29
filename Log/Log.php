<?php
/**
 * @package      Prism
 * @subpackage   Logs
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Log;

use Prism\Log\Adapter\AdapterInterface;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality that manages logs.
 *
 * @package      Prism
 * @subpackage   Logs
 */
class Log
{
    protected $title;
    protected $type;
    protected $data;
    protected $recordDate;

    /**
     * @var array
     *
     * @deprecated since v1.10
     */
    protected $writers = array();

    protected $adapters = array();

    /**
     * Initialize the object.
     *
     * <code>
     * $title = "My title...";
     * $type  = "MY_TYPE";
     * $data  = array(
     *     "amount" => 100,
     *     "currency" => "USD"
     * );
     *
     * $file   = "/logs/com_crowdfunding.log";
     * $writer = new Prism\Log\Adapter\File($file);
     *
     * $log = new Prism\Log($title, $type, $data);
     * $log->addWriter($writer);
     * $log->store();
     * </code>
     *
     * @param string $title
     * @param string $type
     * @param mixed  $data
     */
    public function __construct($title = '', $type = '', $data = null)
    {
        $this->setTitle($title);
        $this->setType($type);
        $this->setData($data);
    }

    /**
     * Initialize the object.
     *
     * <code>
     * $file   = "/logs/com_crowdfunding.log";
     * $writer = new Prism\Log\Adapter\File($file);
     *
     * $log = new Prism\Log();
     * $log->addWriter($writer);
     * </code>
     *
     * @param WriterInterface $writer
     *
     * @deprecated since v1.10
     */
    public function addWriter(WriterInterface $writer)
    {
        $this->writers[] = $writer;
    }

    /**
     * Initialize the object.
     *
     * <code>
     * $file   = "/logs/com_crowdfunding.log";
     * $writer = new Prism\Log\Adapter\File($file);
     *
     * $log = new Prism\Log();
     * $log->addWriter($writer);
     * </code>
     *
     * @param AdapterInterface $adapter
     */
    public function addAdapter(AdapterInterface $adapter)
    {
        $this->adapters[] = $adapter;
    }

    /**
     * Get a title that is going to be stored.
     *
     * <code>
     * $log   = new Prism\Log();
     * $title = $log->getTitle();
     * </code>
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get a type of the logged information.
     *
     * <code>
     * $log   = new Prism\Log();
     * $type  = $log->getType();
     * </code>
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the data that is going to be logged.
     *
     * <code>
     * $log   = new Prism\Log();
     * $data  = $log->getData();
     * </code>
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the date of the log record.
     *
     * <code>
     * $log   = new Prism\Log();
     * $date  = $log->getRecordDate();
     * </code>
     *
     * @return string
     */
    public function getRecordDate()
    {
        return $this->recordDate;
    }

    /**
     * Set a title of the logged data.
     *
     * <code>
     * $title = "My title...";
     *
     * $log   = new Prism\Log();
     * $log->setTitle($title);
     * </code>
     *
     * @param $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set a type of the logged data.
     *
     * <code>
     * $type = "MY_TYPE";
     *
     * $log   = new Prism\Log();
     * $log->setType($type);
     * </code>
     *
     * @param $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set data that should be stored.
     *
     * <code>
     * $data  = array(
     *     "amount" => 100,
     *     "currency" => "USD"
     * );
     *
     * $log   = new Prism\Log();
     * $log->setData($data);
     * </code>
     *
     * @param array $data
     *
     * @return self
     */
    public function setData($data)
    {
        if (!is_scalar($data)) {
            $data = var_export($data, true);
        }

        $this->data = $data;

        return $this;
    }

    /**
     * Set a date of the record.
     *
     * <code>
     * $date  = "30-01-2014";
     *
     * $log   = new Prism\Log();
     * $log->setRecordDate($date);
     * </code>
     *
     * @param string $date
     *
     * @return self
     */
    public function setRecordDate($date)
    {
        $this->recordDate = $date;

        return $this;
    }

    /**
     * Set a data that is going to be stored and save it.
     *
     * <code>
     * $title = "My title...";
     * $type  = "MY_TYPE";
     * $data  = array(
     *     "amount" => 100,
     *     "currency" => "USD"
     * );
     *
     * $file   = "/logs/com_crowdfunding.log";
     * $writer = new Prism\Log\Adapter\File($file);
     *
     * $log   = new Prism\Log();
     * $log->addWriter($writer);
     *
     * $log->add($title, $type, $data);
     * </code>
     *
     * @param string $title
     * @param string $type
     * @param mixed  $data
     */
    public function add($title, $type, $data = null)
    {
        $this->setTitle($title);
        $this->setType($type);
        $this->setData($data);

        $date = new \JDate();
        $this->setRecordDate((string)$date);

        $this->store();
    }

    /**
     * Store the information.
     *
     * <code>
     * $title = "My title...";
     * $type  = "MY_TYPE";
     * $data  = array(
     *     "amount" => 100,
     *     "currency" => "USD"
     * );
     *
     * $file   = "/logs/com_crowdfunding.log";
     * $writer = new Prism\Log\Adapter\File($file);
     *
     * $log = new Prism\Log($title, $type, $data);
     * $log->addWriter($writer);
     *
     * $log->store();
     * </code>
     */
    public function store()
    {
        /** @var $adapter AdapterInterface */
        foreach ($this->adapters as $adapter) {
            $adapter->setTitle($this->getTitle());
            $adapter->setType($this->getType());
            $adapter->setData($this->getData());
            $adapter->setDate($this->getRecordDate());
            $adapter ->store();
        }
    }
}
