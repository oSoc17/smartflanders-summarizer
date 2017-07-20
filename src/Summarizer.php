<?php

namespace oSoc\Summary;

use pietercolpaert\hardf\TriGParser;

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
        foreach($this->urls as $name => $url) {
            echo "Getting data for " . $name . "\n";
            // Get raw data
            $raw = file_get_contents($url);

            // Parse into hardf graph
            $parser = new TriGParser();
            $graph = $parser->parse($raw);

            // pass to dataset summary
            $this->addToDatasetSummary($url, $graph);
        }


    }

    public function addToDatasetSummary($url, $graph) {
        // For each interval

            // Find which data is not yet implemented in current summary

            // Calculate new summarized data

            // Write to current summary file (use filesystem from smartflanders backend)
    }
}