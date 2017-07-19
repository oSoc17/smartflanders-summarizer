<?php

namespace Summarizer;


class Summarizer
{
    private $granularities;
    private $urls;

    public function __construct($granularities, $urls)
    {
        $this->granularities = $granularities;
        $this->urls = $urls;
    }

    public function summarizeAll() {
        // For each url

            // Get raw data

            // Parse into hardf graph

            // addToDatasetSummary($url)
    }

    public function addToDatasetSummary($url) {
        // For each interval

            // Find which data is not yet implemented in current summary

            // Calculate new summarized data

            // Write to current summary file (use filesystem from smartflanders backend)
    }
}