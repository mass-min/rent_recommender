<?php

namespace RentRecommender\Runner;

class RunnerBase implements RunnerInterface
{
    /**
     * RunnerBase constructor.
     */
    public function __construct()
    {
        echo "--- " . (string)static::class . " start ---\n";
    }

    /**
     * send finish message
     */
    public function __destruct()
    {
        echo "--- " . (string)static::class . " Finish ---\n";
    }

    /**
     * execute runner
     * @param array $args
     */
    public function execute(array $args): void
    {
        echo "...running...\n";
    }
}