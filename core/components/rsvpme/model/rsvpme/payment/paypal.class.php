<?php
/**
 * RSVPMe
 *
 * Copyright 2010 by Josh Tambunga <josh+rsvpme@joshsmind.com>
 *
 * RSVPMe is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * RSVPMe is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * RSVPMe; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package rsvpme
 */
/**
 * Handles communications with PayPal
 *
 * @package rsvpme
 * @subpackage paypal
 */
class PayPal {
    /* an instance of the modx object */
    public $modx = null;

    /* additional configuration options */
    public $config = array();

    /* PayPal API version in use */
    private $_version = '51.0';

    private $_curl;

    /**
     * Construct a new PayPal instance
     *
     * @param modX &$modx An instance of modx
     * @param array $options
     * @return PayPal A new PayPal instance
     */
    public function __construct(modX &$modx, array $options = array()) {
        $this->modx =& $modx;
        $this->options = $options;
    }

    /**
     * Initialize instance of PayPal
     */
    public function initialize() {
        $this->_curl = curl_init();
        
        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($this->_curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->_curl, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_curl, CURLOPT_POST, 1);

        $this->config = array_merge(array(
            'paypal_username'       => $this->modx->getOption('rsvpme.paypal_username',null,''),
            'paypal_password'       => $this->modx->getOption('rsvpme.paypal_password',null,''),
            'paypal_signature'      => $this->modx->getOption('rsvpme.paypal_signature',null,''),
            'paypal_environment'    => $this->modx->getOption('rsvpme.paypal_environment',null,''),
            'paypal_cert_chain'     => $this->modx->getOption('rsvpme.paypal_cert_chain',null,''),
            'paypal_cert'           => $this->modx->getoption('rsvpme.paypal_cert',null,''),
        ),$this->config);

       $this->_buildUrl();
    }

    public function doDirectPayment($request, $card, $address, $details, $payer = array(), $payername = array(), $details_items = array(), $ship = array()) {
        $params = array();
        $params = array_merge($request, $params);
        $params = array_merge($card, $params);
        $params = array_merge($address, $params);
        $params = array_merge($details, $params);
        $params = array_merge($payer, $params);
        $params = array_merge($payername, $params);
        $params = array_merge($details, $params);
        $params = array_merge($ship, $params);

        return $this->call('DoDirectPayment', $params);
    }

    public function setExpressCheckout($request, $details, $address = array(), $details_items = array()) {
        $params = array();
        $params = array_merge($request, $params);
        $params = array_merge($address, $params);
        $params = array_merge($details, $params);
        $params = array_merge($details_items, $params);
        $return = $this->call('SetExpressCheckout', $params);

        $this->modx->log(modX::LOG_LEVEL_DEBUG, 'Building PayPal url from: ' . print_r($return, true));

        $url = 'https://www.';
        if ($this->config['paypal_environment'] === 'sandbox' || $this->config['paypal_environment'] === 'beta-sandbox') {
            $url .= 'sandbox.';
        }
        $url .= 'paypal.com/webscr&cmd=_express-checkout&token=';
        if (isset($return['TOKEN'])) {
            $url .= urldecode($return['TOKEN']);
        }

        $return['PayPalURL'] = $url;
        
        return $return;
    }

    public function getExpressCheckoutDetails($request) {
        return $this->call('GetExpressCheckoutDetails', $request);
    }

    public function doExpressCheckoutPayment($request, $details, $address = array(), $details_items = array(), $user_opt = array()) {
        $params = array();
        $params = array_merge($request, $params);
        $params = array_merge($details, $params);
        $params = array_merge($address, $params);
        $params = array_merge($details_items, $params);
        $params = array_merge($user_opt, $params);

        return $this->call('DoExpressCheckoutPayment', $params);
    }

    /**
     * Handles making the actual connection to PayPal and formatting and returning the results
     *
     * @param string $method Represents the PayPal API call to be made
     * @param array $params Parameters to be passed to PayPal
     * @return array Error/Success codes/message returned by PayPal
     */
    private function call($method, $params) {
        $this->modx->log(modX::LOG_LEVEL_INFO, 'Starting PayPal payment: ' . $method);

        $required_params = array(
            'USER'      => $this->config['paypal_username'],
            'PWD'       => $this->config['paypal_password'],
            'VERSION'   => $this->_version,
            'SIGNATURE' => $this->config['paypal_signature'],
            'METHOD'    => $method,
        );

        /* f we have defined a certificate, we should add it to the request */
        if (!empty($this->config['paypal_cert'])) {
            curl_setopt($this->_curl, CURLOPT_CAINFO, $this->config['paypal_cert_chain']);
            curl_setopt($this->_curl, CURLOPT_SSLCERT, $this->config['paypal_cert']);
        }

        $fields = array_merge($required_params, $params);

        $this->modx->log(modX::LOG_LEVEL_INFO, 'Setting PayPal url: ' . $this->config['url']);
        curl_setopt($this->_curl, CURLOPT_URL, $this->config['url']);
        $this->modx->log(modX::LOG_LEVEL_INFO, 'Setting PayPal query: ' . http_build_query($fields));
        curl_setopt($this->_curl, CURLOPT_POSTFIELDS, http_build_query($fields));

        /* get response from server */
        $response = curl_exec($this->_curl);
        $this->modx->log(modX::LOG_LEVEL_DEBUG, 'PayPal response recieved: ' . print_r($response, true));

        if (!$response) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $method . '_ failed: ' . curl_error($this->_curl) . '(' . curl_errno($this->_curl).')');
            if (!empty($this->config['paypal_cert'])) {
                $this->modx->log(modX::LOG_LEVEL_ERROR, 'Failed while using:: cert: ' . $this->config['cert']);
            }
        }

        // Extract the response and details
        $response = explode('&', $response);

        curl_close($this->_curl);

        $httpParsedResponse = array();

        foreach ($response as $i => $value) {
            $tmpAr = explode('=', $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponse[$tmpAr[0]] = urldecode($tmpAr[1]);
            }
        }

        if ((0 == sizeof($httpParsedResponse)) || !array_key_exists('ACK', $httpParsedResponse)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Invalid HTTP Response for POST request.');
        }

        return $httpParsedResponse;
    }

    private function _buildUrl() {
        // if no signature is defined, then we are using a certificate
        if (empty($this->config['paypal_signature'])) {
            $url = 'https://api.';
        } else {
            $url = 'https://api-3t.';
        }

        if ($this->config['paypal_environment'] === 'sandbox' || $this->config['paypal_environment'] === 'beta-sandbox') {
            $url .= 'sandbox.';
        }

        $url .= 'paypal.com/nvp/';

        $this->config['url'] = $url;
    }
}