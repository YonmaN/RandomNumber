<?php
namespace RandomNumber;

class RandomNumber
{
    public function random() {
        return mt_rand(0, 1000);
    }
}