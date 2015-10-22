<?php

class Receive {
    public function __construct(Blockchain $blockchain) {
        $this->blockchain = $blockchain;
    }

    public function generate($address, $callback=null) {
        $params = array(
            'method'=>'create',
            'address'=>$address
        );
        if(!is_null($callback)) {
            $params['callback'] = $callback;
        }

        return new ReceiveResponse($this->blockchain->post('api/receive', $params));
    }
}

class ReceiveResponse {
    public $address;                    // string
    public $fee_percent;                // int
    public $destination;                // string
    public $callback_url;               // string

    public function __construct($json) {
        if(array_key_exists('input_address', $json))
            $this->address = $json['input_address'];
        if(array_key_exists('fee_percent', $json))
            $this->fee_percent = $json['fee_percent'];
        if(array_key_exists('destination', $json))
            $this->destination = $json['destination'];
        if(array_key_exists('callback_url', $json))
            $this->callback_url = $json['callback_url'];
    }
}