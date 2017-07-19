<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Summarizer\Summarizer;

$dotenv = new Dotenv(__DIR__ . '/../');
$dotenv->load();
$dotenv->required('INTERVALS');

$granularities = parse_grans($_ENV['GRANULARITIES']); // Intervals in seconds
$urls = [
    'Gent' => 'linked.open.gent/parking',
    'Kortrijk' => 'kortrijk.datapiloten.be/parking',
    'Leuven' => 'leuven.datapiloten.be/parking',
    'Sint-Niklaas' => 'sint-niklaas.datapiloten.be/parking'
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