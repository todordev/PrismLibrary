<?php

class Rates {
    public function __construct(Blockchain $blockchain) {
        $this->blockchain = $blockchain;
    }

    public function get() {
        $rates = array();
        
        $json = $this->blockchain->get('ticker', array('format'=>'json'));
        foreach ($json as $cur => $data) {
            $rates[$cur] = new Ticker($cur, $data);
        }
        
        return $rates;
    }

    public function toBTC($amount, $symbol) {
        $params = array(
            'currency'=>$symbol,
            'value'=>$amount,
            'format'=>'json'
        );
        return $this->blockchain->get('tobtc', $params);
    }
}

class Ticker {
    public $m15;                                // float
    public $last;                               // float
    public $buy;                                // float
    public $sell;                               // float
    public $cur;                                // string
    public $symbol;                             // string

    public function __construct($cur, $json) {
        $this->cur = $cur;

        if(array_key_exists('15m', $json))
            $this->m15 = $json['15m'];
        if(array_key_exists('last', $json))
            $this->last = $json['last'];
        if(array_key_exists('buy', $json))
            $this->buy = $json['buy'];
        if(array_key_exists('sell', $json))
            $this->sell = $json['sell'];
        if(array_key_exists('symbol', $json))
            $this->symbol = $json['symbol'];
    }
}