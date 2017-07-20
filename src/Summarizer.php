<?php

namespace oSoc\Summary;

use oSoc\Summary\Filesystem\FileReader;
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
            $filteredGraph = ["triples" => array()];
            foreach($graph->triples as $triple) {
                if ($triple->predicate === 'datex:parkingNumberOfVacantSpaces') {
                    if (!in_array($triple, $currentMeasurements)) {
                        array_push($filteredGraph["triples"], $triple);
                    }
                }
            }

            // Calculate new summarized data ($currentSummary)

            // Write to current summary file (use filesystem from smartflanders backend)

            // Write new triples to current measurements file
        }
    }
}