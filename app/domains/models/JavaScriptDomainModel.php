<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';

/**
 * JavaScriptDomainModel
 *
 * @package   DomainModel
 * @author    Sebastian Karpeta sebastian@assembla.com
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class JavaScriptDomainModel extends BaseDomainModel
{
    /** @var string $name */
    protected $name;

    /** @var JavaScriptRegionEnum $scriptRegion */
    protected $scriptRegion;

    /** @var bool $isCacheEnabled */
    protected $isCacheEnabled;

    /** @var DataAttributeDomainModel[] $params */
    protected $params = [];

    public function __construct()
    {
        $this->disableCache();
    }

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return JavaScriptDomainModel
     */
    public function setScript(string $name): JavaScriptDomainModel
    {
        $this->name = str_replace(
            JavaScriptDataProvider::JAVASCRIPT_EXTENSION,
            '',
            $name
        );

        return $this;
    }

    /**
     * @return JavaScriptRegionEnum
     */
    public function getRegion(): JavaScriptRegionEnum
    {
        return $this->scriptRegion;
    }

    /**
     * @param JavaScriptRegionEnum $scriptRegion
     *
     * @return JavaScriptDomainModel
     */
    public function setRegion(JavaScriptRegionEnum $scriptRegion): JavaScriptDomainModel
    {
        $this->scriptRegion = $scriptRegion;

        return $this;
    }

    /**
     * @return JavaScriptDomainModel
     */
    public function disableCache(): JavaScriptDomainModel
    {
        $this->isCacheEnabled = false;

        return $this;
    }

    /**
     * @return JavaScriptDomainModel
     */
    public function enableCache(): JavaScriptDomainModel
    {
        $this->isCacheEnabled = true;

        return $this;
    }

    /**
     * Checking that loaded file should be updated by random suffix or no.
     *
     * @return bool
     */
    public function isCacheEnabled(): bool
    {
        return $this->isCacheEnabled;
    }

    /**
     * @return DataAttributeDomainModel[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param DataAttributeDomainModel[] $params
     *
     * @return JavaScriptDomainModel
     */
    public function setParams(array $params): JavaScriptDomainModel
    {
        $this->params = array_merge(
            $this->params,
            $params
        );

        return $this;
    }
}
