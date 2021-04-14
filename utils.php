<?php

function json($array) {
  header('content-type: application/json');
  return json_encode($array);
}

function base_url() {
  $currentPath = $_SERVER['PHP_SELF'];
  $pathInfo = pathinfo($currentPath);
  $hostName = $_SERVER['HTTP_HOST'];
  $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) === 'https' ? 'https' : 'http';

  return $protocol . '://' . $hostName . $pathInfo['dirname'];
}

function get_url($path) {
  $path = str_replace(dirname(__FILE__), '', $path);
  return trim(base_url(), '/') . $path;
}
