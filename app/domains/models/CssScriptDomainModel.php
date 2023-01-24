<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';

/**
 * CssScriptDomainModel
 *
 * @package   DomainModel
 * @author    Sebastian Karpeta sebastian@assembla.com
 * @copyright Copyright 2003-2022 Gurock Software GmbH. All rights reserved.
 */
class CssScriptDomainModel extends BaseDomainModel
{
    /** @var string $name */
    protected $name;

    /** @var bool $isCacheEnabled */
    protected $isCacheEnabled;

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
     * @return CssScriptDomainModel
     */
    public function setScript(string $name): CssScriptDomainModel
    {
        $this->name = str_replace(
            CssScriptDataProvider::CSS_EXTENSION,
            '',
            $name
        );

        return $this;
    }

    /**
     * @return CssScriptDomainModel
     */
    public function disableCache(): CssScriptDomainModel
    {
        $this->isCacheEnabled = false;

        return $this;
    }

    /**
     * @return CssScriptDomainModel
     */
    public function enableCache(): CssScriptDomainModel
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
}
