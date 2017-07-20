<?php

namespace oSoc\Summary\Filesystem;

use \League\Flysystem\Adapter\Local;
use \League\Flysystem\Filesystem;
use pietercolpaert\hardf\TriGParser;

Class FileSystemProcessor {
    protected $out_fs;
    protected $res_fs;
    protected $granularity;
    protected $file_interval;
    protected $writer;
    protected $graph_processor;
    protected $static_data_filename;
    protected $name;

    public function __construct($granularity, $name)
    {
        $out_dirname = __DIR__ . '/../../out/' . $name . '/' . $granularity . '/';
        $res_dirname = __DIR__ . '/../../resources/' . $name . '/' . $granularity . '/';
        $this->granularity = $granularity;
        date_default_timezone_set("Europe/Brussels");
        $out_adapter = new Local($out_dirname . "/" . $name);
        $this->out_fs = new Filesystem($out_adapter);
        $res_adapter = new Local($res_dirname);
        $this->res_fs = new Filesystem($res_adapter);
        $this->name = $name;
        $this->file_interval = $this->granularity * 12; // 12 measurements per file
    }

    // Get closest page (timestamp) for a given timestamp
    public function getClosestPage($timestamp) {
        $return_ts = $this->roundTimestamp($timestamp);
        if (!$this->hasFile($return_ts)) {
            // Exact file doesn't exist, get closest
            $prev = $this->getPreviousFromTimestamp($timestamp);
            if ($prev) {
                return $prev;
            }
        } else {
            return (string)$this->roundTimestamp($return_ts);
        }
        return false;
    }

    // Get UNIX timestamp of current page (this page is still forming, others are historic and don't change)
    public function getCurrentPage() {
        return $this->getClosestPage(time());
    }

    // Get measurements for current page
    // Returns hardf graph with measurements
    public function getCurrentMeasurements() {
        if ($this->res_fs->has('measurements')) {
            $raw = $this->res_fs->read('measurements');
            $parser = new TriGParser(['format' => 'trig']);
            return $parser->parse($raw);
        }
        return ['triples' => array()];
    }

    // PRIVATE METHODS

    // Round a timestamp to its respective file timestamp
    protected function roundTimestamp($timestamp) {
        $timestamp -= $timestamp % $this->granularity;
        return $timestamp;
    }

    // Get the oldest timestamp for which a file exists
    protected function getOldestTimestamp() {
        $filename = $this->name . "_oldest_timestamp";
        if ($this->res_fs->has($filename)) {
            return $this->res_fs->read($filename);
        }
        return false;
    }

    // Takes: UNIX timestamp
    // Returns: previous file for timestamp (also UNIX timestamp)
    protected function getPreviousFromTimestamp($timestamp) {
        $oldest = $this->getOldestTimestamp();
        if ($oldest) {
            $timestamp = $this->roundTimestamp($timestamp);
            while ($timestamp > $oldest) {
                $timestamp -= $this->granularity;
                $filename = $this->roundTimestamp($timestamp);
                if ($this->out_fs->has($filename)) {
                    return $timestamp;
                }
            }
        }
        return false;
    }

    // Takes: UNIX timestamp
    // Returns: next file for timestamp (also UNIX timestamp)
    protected function getNextFromTimestamp($timestamp) {
        $timestamp = $this->roundTimestamp($timestamp);
        $now = time();
        while($timestamp < $now) {
            $timestamp += $this->granularity;
            $filename = $this->roundTimestamp($timestamp);
            if ($this->out_fs->has($filename)) {
                return $timestamp;
            }
        }
        return false;
    }

    public function hasFile($filename) {
        return $this->out_fs->has($filename);
    }
}
