<?php
namespace RandomNumber;

use ZendServer\Log\Log;
class RandomNumber
{
    public function random() {
        return mt_rand(0, 1000);
    }
}