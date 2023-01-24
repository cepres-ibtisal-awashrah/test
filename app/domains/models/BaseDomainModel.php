<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/IDomainModel.php';

/**
 * BaseDomainModel
 *
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright 2019
 */
class BaseDomainModel implements IDomainModel
{
    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return static
     */
    public function setId(int $id): BaseDomainModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Convert any domain model to a basic PHP model.
     *
     * @return object
     */
    public function toObject(): object
    {
        $objectToArray = [];

        foreach ($this as $key => $value) {
            $objectToArray[$key] = $value;
        }

        return (object) $objectToArray;
    }
}
