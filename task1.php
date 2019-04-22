<?php
    class fibo {
        private $queue;
        private $number;
        
        public function __construct() {
            $this->queue = ['PrevPrev' => 0, 'Prev' => 1];
        }

        public function push($n) {
            $this->shift();
            $this->queue['Prev'] = $n;
        }

        private function shift() {
            $this->queue['PrevPrev'] = $this->queue['Prev'];
        }

        public function getNumber() {
            $number = $this->queue['Prev'];

            $this->push($this->queue['PrevPrev'] + $this->queue['Prev']);

            return $number;
        }
    }

    $fibo = new fibo();
 
    for ($i = 0; $i < 60; $i++) 
        echo $fibo->getNumber() . "<br>";