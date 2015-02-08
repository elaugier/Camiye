<?php
require 'Camiye\Camiye.php';
\Camiye\Camiye::registerAutoloader();

if (!empty($app)) {
   $app = new \Camiye\Camiye();
}
