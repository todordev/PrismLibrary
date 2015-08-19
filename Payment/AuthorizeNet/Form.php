<?php
/**
 * @package      Prism
 * @subpackage   Payment\AuthorizeNet
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Payment\AuthorizeNet;

// no direct access
defined('JPATH_PLATFORM') or die;

/**
 * This class contains methods that generate AuthorizeNet hidden form fields.
 *
 * @package     Prism
 * @subpackage  Payment\AuthorizeNet
 */
class Form
{
    public $x_currency_code;
    public $x_address;
    public $x_amount;
    public $x_background_url;
    public $x_card_num;
    public $x_city;
    public $x_color_background;
    public $x_color_link;
    public $x_color_text;
    public $x_company;
    public $x_country;
    public $x_cust_id;
    public $x_customer_ip;
    public $x_description;
    public $x_delim_char = ",";
    public $x_delim_data = true;
    public $x_duplicate_window;
    public $x_duty;
    public $x_email;
    public $x_email_customer;
    public $x_fax;
    public $x_first_name;
    public $x_footer_email_receipt;
    public $x_footer_html_payment_form;
    public $x_footer_html_receipt;
    public $x_fp_hash;
    public $x_fp_sequence;
    public $x_fp_timestamp;
    public $x_freight;
    public $x_header_email_receipt;
    public $x_header_html_payment_form;
    public $x_header_html_receipt;
    public $x_invoice_num;
    public $x_last_name;
    public $x_line_item;
    public $x_login;
    public $x_logo_url;
    public $x_method;
    public $x_phone;
    public $x_po_num;
    public $x_receipt_link_method;
    public $x_receipt_link_text;
    public $x_receipt_link_url;
    public $x_recurring_billing;
    public $x_relay_response = false;
    public $x_relay_url;
    public $x_rename;
    public $x_ship_to_address;
    public $x_ship_to_company;
    public $x_ship_to_country;
    public $x_ship_to_city;
    public $x_ship_to_first_name;
    public $x_ship_to_last_name;
    public $x_ship_to_state;
    public $x_ship_to_zip;
    public $x_show_form;
    public $x_state;
    public $x_tax;
    public $x_tax_exempt;
    public $x_test_request;
    public $x_trans_id;
    public $x_type;
    public $x_version = "3.1";
    public $x_zip;

    /**
     * Initialize the object.
     *
     * <code>
     * $fields = array(
     *     "param1" => "...",
     *     "param2" => "...",
     * );
     *
     * $form = new Prism\Payment\AuthorizeNet\Form($fields);
     * </code>
     *
     * @param array $fields
     */
    public function __construct($fields = array())
    {
        if ($fields) {
            foreach ($fields as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Get a string of HTML hidden fields for use in a form.
     *
     * <code>
     * $fields = array(
     *     "param1" => "...",
     *     "param2" => "...",
     * );
     *
     * $form = new Prism\Payment\AuthorizeNet\Form($fields);
     * echo $form->getHiddenFieldsArray();
     * </code>
     *
     * @param array $excluded
     *
     * @return string
     */
    public function getHiddenFieldsArray($excluded = array())
    {
        $array  = get_object_vars($this);
        $output = array();

        foreach ($array as $key => $value) {

            if (in_array($key, $excluded)) {
                continue;
            }

            if (is_bool($value)) {

                $val      = (!$value) ? "FALSE" : "TRUE";
                $output[] = '<input type="hidden" name="' . $key . '" value="' . $val . '" />';

            } elseif (!empty($value)) {
                $output[] = '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
            }

        }

        return $output;
    }

    /**
     * Generate a fingerprint needed for a hosted order form or Direct Post Method.
     *
     * <code>
     * $fields = array(
     *     "param1" => "...",
     *     "param2" => "...",
     * );
     *
     * $transactionKey = "...";
     *
     * $form = new Prism\Payment\AuthorizeNet\Form($fields);
     * $form->generateFingerprint($transactionKey);
     * </code>
     *
     * @param string $transactionKey Transaction Key
     *
     * @return string The fingerprint.
     */
    public function generateFingerprint($transactionKey)
    {
        $fingerprint = $this->x_login . "^" . $this->x_fp_sequence . "^" . $this->x_fp_timestamp . "^" . $this->x_amount . "^";
        if (!empty($this->x_currency_code)) {
            $fingerprint .= $this->x_currency_code;
        }

        if (function_exists('hash_hmac')) {
            $this->x_fp_hash = hash_hmac("md5", $fingerprint, $transactionKey);
        } else {
            $this->x_fp_hash = bin2hex(mhash(MHASH_MD5, $fingerprint, $transactionKey));
        }

        return $this;
    }
}
