<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
namespace GuzzleHttp\Ring\Future;

/**
 * Future that provides array-like access.
 */
interface FutureArrayInterface extends
    FutureInterface,
    \ArrayAccess,
    \Countable,
    \IteratorAggregate {};
