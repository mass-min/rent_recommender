<?php

namespace RentRecommender\Runner;

interface RunnerInterface {
    /**
     * main function
     * @return void
     */
    public function execute(): void;
}