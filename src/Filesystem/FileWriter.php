<?php

namespace oSoc\Summary\Filesystem;

use pietercolpaert\hardf\TriGWriter;
use pietercolpaert\hardf\TriGParser;
use oSoc\Smartflanders\Helpers;

class FileWriter extends FileSystemProcessor {

    // Takes: timestamp and measurement
    // Writes measurement to resources file
    // Updates aggregation in current file
    // Creates new file (deleting resources) if necessary
    public function writeMeasurement($timestamp, $graph) {
        // TODO
    }
}

