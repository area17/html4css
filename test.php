<?php
// kill errors - DOMDocument doesn't like HTML5 pages...
error_reporting(E_ERROR | E_PARSE);
// what URL do we want?
if(!isset($_GET['url'])) die();
$url = $_GET['url'];
// if the url is url encoded, decode it
$url = urldecode($url);
// make some new DOMDocuments
$dom = new DOMDocument;
$html = new DOMDocument;
// stick the html from our site into one
$http_opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36"
  )
);
$http_context = stream_context_create($http_opts);
$dom->loadHTML(file_get_contents($url, false, $http_context));
// grab the body
$body = $dom->getElementsByTagName('body')->item(0);
// add the body to the new html
foreach ($body->childNodes as $child){
  $html->appendChild($html->importNode($child, true));
}
// lets find and remove the script tags
$script = $html->getElementsByTagName('script');
$remove = [];
foreach($script as $item) {
  $remove[] = $item;
}
foreach ($remove as $item) {
  $item->parentNode->removeChild($item);
}
// and find and remove any random style tags
$style = $html->getElementsByTagName('style');
$remove = [];
foreach($style as $item) {
  $remove[] = $item;
}
foreach ($remove as $item) {
  $item->parentNode->removeChild($item);
}
// update images if src starts with /
$images = $html->getElementsByTagName('img');
foreach ($images as $image) {
  $src = $image->attributes->getNamedItem('src')->nodeValue;
  if (0 === strpos($src, '/')) {
    $image->setAttribute('src',$url.$src);
  }
}
// save the html
$html = $html->saveHTML();
// add our header - with links to the html4css and legacypicturefill
$header = '<!DOCTYPE html><html dir="ltr" lang="en-US" class="no-js"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"><title>HTML4CSS | Demo</title><!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]--><script src="//legacypicturefill.s3.amazonaws.com/legacypicturefill.min.js"></script><link rel="stylesheet" href="../html4.css"></head>';
// need to close the document
$footer = '</html>';
// combine
$html = $header.$html.$footer;
// print
print_r($html);
?>
