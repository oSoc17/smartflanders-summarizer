<?php

namespace oSoc\Summary;

use oSoc\Summary\Filesystem\FileReader;
use pietercolpaert\hardf\TriGParser;
use pietercolpaert\hardf\Util;

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
        foreach($this->urls as $name => $url) {
            echo "Getting data for " . $name . "\n";
            // Get raw data
            $raw = file_get_contents($url);

            // Parse into hardf graph
            $parser = new TriGParser();
            $graph = $parser->parse($raw);

            // pass to dataset summary
            $this->addToDatasetSummary($name, $graph);
        }


    }

    public function addToDatasetSummary($name, $graph) {
        foreach($this->granularities as $granularity) {
            // Get current file + resources file for name
            $reader = new FileReader($granularity, $name);
            $currentMeasurements = $reader->getCurrentMeasurements();
            $currentSummary = $reader->getCurrentSummary();

            // Find which data is not yet implemented in current summary
            $filteredGraph = ["triples" => array(), "prefixes" => $graph['prefixes']];
            if ($currentSummary) {
                foreach($graph['triples'] as $triple) {
                    if ($triple['predicate'] === 'datex:parkingNumberOfVacantSpaces') {
                        if (!in_array($triple, $currentMeasurements)) {
                            array_push($filteredGraph["triples"], $triple);
                        }
                    }
                }
            } else {
                $filteredGraph = $graph;
            }


            // Calculate new summarized data
            if ($currentSummary) {
                // Update
            } else {
                $literals = array();
                foreach($filteredGraph['triples'] as $triple) {
                    array_push($literals, Util::getLiteralValue($triple['object']));
                }
                $avg = array_sum($literals) / count($literals);
                $max = max($literals);
                $min = min($literals);

            }

            // Write to current summary file (use filesystem from smartflanders backend)

            // Write new triples to current measurements file
        }
    }
}