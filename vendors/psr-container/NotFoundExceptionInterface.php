<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

namespace Psr\Container;

/**
 * No entry was found in the container.
 */
interface NotFoundExceptionInterface extends ContainerExceptionInterface
{
}
