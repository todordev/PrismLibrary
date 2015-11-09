<?php
/**
 * @package      Prism
 * @subpackage   Logs\Writers
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Log\Writer;

use Prism\Log\WriterInterface;

defined('JPATH_PLATFORM') or die;

jimport('joomla.filesystem.path');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

/**
 * This is a class that provides functionality for storing log data in a file.
 *
 * @package         Prism
 * @subpackage      Logs\Writers
 *
 * @deprecated since v1.10
 */
class File implements WriterInterface
{
    protected $file;

    protected $title;
    protected $type;
    protected $data;
    protected $recordDate;

    /**
     * Initialize the object.
     *
     * <code>
     * $file = "/logs/myfile.log";
     *
     * $writer = new Prism\Log\Writer\File($file);
     * </code>
     *
     * @param string $file
     *
     * @throws \RuntimeException
     * @throws \UnexpectedValueException
     */
    public function __construct($file)
    {
        $this->file = $this->validate($file);

        if (!$this->file) {
            throw new \UnexpectedValueException(\JText::_('LIB_PRISM_ERROR_INVALID_FILE'));
        }
    }

    protected function validate($file)
    {
        \JPath::clean($file);

        $folder = dirname($file);

        if (!\JFolder::exists($folder)) {
            throw new \RuntimeException(\JText::sprintf('LIB_PRISM_ERROR_FOLDER_DOES_NOT_EXIST', $folder));
        }

        // Create file
        if (!\JFile::exists($file)) {
            $buffer = "#<?php die('Forbidden.'); ?>\n";
            \JFile::write($file, $buffer);
        }

        return $file;
    }

    /**
     * Set a title of logged information.
     *
     * <code>
     * $file = "/logs/myfile.log";
     * $title = "Logged title...";
     *
     * $writer = new Prism\Log\Writer\File($file);
     * $writer->setTitle($title);
     * </code>
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set a type of logged information.
     *
     * <code>
     * $file = "/logs/myfile.log";
     * $type = "PAYMENT_PROCESS";
     *
     * $writer = new Prism\Log\Writer\File($file);
     * $writer->setType($type);
     * </code>
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set an additional information about logged information.
     *
     * <code>
     * $file = "/logs/myfile.log";
     * $data = array(
     *    "amount" => 100,
     *    "currency" => "USD"
     * );
     *
     * $writer = new Prism\Log\Writer\File($file);
     * $writer->setData($data);
     * </code>
     *
     * @param mixed $data
     *
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set date of logged information.
     *
     * <code>
     * $file = "/logs/myfile.log";
     * $date = "01-01-2014";
     *
     * $writer = new Prism\Log\Writer\File($file);
     * $writer->setDate($date);
     * </code>
     *
     * @param string $date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->recordDate = $date;

        return $this;
    }

    /**
     * Save the information in a file.
     *
     * <code>
     * $file = "/logs/myfile.log";
     *
     * $writer = new Prism\Log\Writer\File($file);
     * $writer->store();
     * </code>
     */
    public function store()
    {
        $logData = "=========================================\n";
        $logData .= 'Date Time: ' . $this->recordDate . "\n";
        $logData .= $this->title . ' (' . $this->type . ") \n";
        if (null !== $this->data) {
            $logData .= var_export($this->data, true) . "\n";
        }

        file_put_contents($this->file, stripslashes($logData), FILE_APPEND);
    }
}
