<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use oSoc\Summary\Summarizer;

$dotenv = new Dotenv(__DIR__ . '/../');
$dotenv->load();
$dotenv->required('GRANULARITIES');

$granularities = parse_grans($_ENV['GRANULARITIES']); // Intervals in seconds
$urls = [
    'Gent' => 'http://linked.open.gent/parking',
    'Kortrijk' => 'http://kortrijk.datapiloten.be/parking',
    'Leuven' => 'http://leuven.datapiloten.be/parking',
    'Sint-Niklaas' => 'http://sint-niklaas.datapiloten.be/parking'
];

$summarizer = new Summarizer($granularities, $urls);
$summarizer->summarizeAll();

function parse_grans($string) {
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