<?php

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: application/json; charset=utf-8");

require_once("simple_html_dom.php");

if (!isset($_REQUEST["user"]) || empty($_REQUEST["user"])) {
    die(json_encode("No user specified."));
}

$user = basename($_REQUEST["user"]);
$user = htmlentities($user);
$user = trim($user);

$html = file_get_html("https://imgtagram.com/u/{$user}");

$imgs = array();

foreach($html->find("img") as $element) {
    if (isset($element->attr["data-src"])) {
        array_push($imgs, trim($element->attr["data-src"]));
    }
}

$o = new stdClass();
$o->imgs = $imgs;

echo json_encode($o);

?>
