<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__ . '/../');
$dotenv->load();
$dotenv->required('INTERVALS');

$intervals = parse_intervals($_ENV['INTERVALS']); // Intervals in seconds

// Get data from entry point

// Parse into hardf graph

// Pass interval list and graph to Summarizer

function parse_intervals($string) {
    $arr = explode(',', $string);
    $result = array();
    $multiply = [
        'h' => 60*60,
        'd' => 60*60*24
    ];
    foreach ($arr as $interval_string) {
        preg_match('/([0-9]*)(\w)/', $interval_string, $matches);
        $num = $matches[1];
        $unit = $matches[2];
        array_push($result, $num*$multiply[$unit]);
    }
    return $result;
}