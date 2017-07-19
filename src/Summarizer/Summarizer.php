<?php

namespace Summarizer;


class Summarizer
{
    private $intervals;

    public function __construct($intervals)
    {
        $this->intervals = $intervals;
    }

    public function summarizeData($graph) {
        // Instantiate IntervalSummarizers for each interval

        // Pass graph to these IntervalSummarizers

    }
}