<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';

/**
 * DataAttributeDomainModel
 *
 * @package   DomainModel
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class DataAttributeDomainModel extends BaseDomainModel
{
    /** @var string $key */
    protected $key;

    /** @var string $value */
    protected $value;

    /** @var bool $isObfuscated */
    protected $isObfuscated = false;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return DataAttributeDomainModel
     */
    public function setKey(string $key): DataAttributeDomainModel
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return DataAttributeDomainModel
     */
    public function setValue(string $value): DataAttributeDomainModel
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isObfuscated(): bool
    {
        return $this->isObfuscated;
    }

    /**
     * @return DataAttributeDomainModel
     */
    public function enableObfuscated(): DataAttributeDomainModel
    {
        $this->isObfuscated = true;

        return $this;
    }
}
