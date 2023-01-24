<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
namespace GuzzleHttp\Ring\Exception;

class CancelledFutureAccessException extends RingException implements CancelledException {}
