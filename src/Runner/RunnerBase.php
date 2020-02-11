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
     */
    public function execute(): void
    {
        echo "...running...\n";
    }
}