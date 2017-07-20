<?php
namespace oSoc\Summary\Filesystem;

use pietercolpaert\hardf\TriGParser;

class FileReader extends FileSystemProcessor {

    // Takes: a filename (UNIX timestamp)
    // Returns: the contents in Turtle/TriG format
    public function getGraphsFromFile($filename) {
        $raw = $this->out_fs->read($filename);
        $parser = new TriGParser(['format' => 'trig']);
        return $parser->parse($raw);
    }

    // Get current summary (the one that is being built)
    // Returns a hardf graph (or false if a new summary must be started)
    public function getCurrentSummary() {
        $now = time();
        $timestamp = $this->getClosestPage($now);
        if ($now - $timestamp > $this->file_interval) {
            return false;
        }
        return $this->getGraphsFromFile($timestamp);
    }

    // Get measurements for current summary
    // Returns hardf graph with measurements
    public function getCurrentMeasurements() {
        if ($this->res_fs->has('measurements')) {
            $raw = $this->res_fs->read('measurements');
            $parser = new TriGParser(['format' => 'trig']);
            return $parser->parse($raw);
        }
        return ['triples' => array()];
    }
}
