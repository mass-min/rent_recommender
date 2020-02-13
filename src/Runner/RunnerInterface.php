<?php

namespace RentRecommender\Runner;

interface RunnerInterface {
    /**
     * main function
     * @param array $args
     * @return void
     */
    public function execute(array $args): void;
}