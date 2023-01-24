<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * IDomainModel
 *
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 * @package   Domain
 */
interface IDomainModel
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     *
     * @return BaseDomainModel
     */
    public function setId(int $id): BaseDomainModel;

    /**
     * Convert domain model to stdClass
     *
     * @return object
     */
    public function toObject(): object;
}
