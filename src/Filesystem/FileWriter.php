<?php

namespace oSoc\Summary\Filesystem;

use pietercolpaert\hardf\TriGWriter;
use pietercolpaert\hardf\TriGParser;
use oSoc\Smartflanders\Helpers;

class FileWriter extends FileSystemProcessor {

    // Takes: timestamp and graph (measurements that need to be added)
    // Writes measurements to resources file
    // Creates new file (deleting resources) if necessary
    public function writeToCurrentMeasurements($timestamp, $graph) {
        // TODO
    }

    // Takes: timestamp and graph (summarized data)
    // Writes summary to correct file based on timestamp
    // Creates new file if necessary
    public function writeSummary($timestamp, $graph) {
        // TODO
    }
}

