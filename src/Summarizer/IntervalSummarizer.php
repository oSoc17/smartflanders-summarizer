<?php

namespace Summarizer;


class IntervalSummarizer
{
    private $interval;

    public function __construct($interval) {
        $this->interval = $interval;
    }

    public function addToSummary($graph) {
        // Find out which triples of the graph haven't been implemented in summary yet

        // Calculate new summary data

        // Save to disk (use filesystem from smartflanders backend?)

    }
}