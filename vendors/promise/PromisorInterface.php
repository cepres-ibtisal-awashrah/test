<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

namespace React\Promise;

interface PromisorInterface
{
    /**
     * Returns the promise of the deferred.
     *
     * @return PromiseInterface
     */
    public function promise();
}
