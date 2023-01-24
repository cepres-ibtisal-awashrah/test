<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';

/**
 * MetaDomainModel
 *
 * @package   DomainModel
 */
class MetaDomainModel extends BaseDomainModel
{
    /** @var string $apiKey */
    protected $apiKey;

    /** @var string $apiUrl */
    protected $apiUrl;

    /** @var bool $apiMetaExportEnabled */
    protected $apiMetaExportEnabled;

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     *
     * @return MetaDomainModel
     */
    public function setApiKey(string $apiKey): MetaDomainModel
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @param string $apiUrl
     *
     * @return MetaDomainModel
     */
    public function setApiUrl(string $apiUrl): MetaDomainModel
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublicUrl(): string
    {
        return sprintf(
            'http://%s/testrail/index.php?/api/tasks/schedule&key=%s',
            $this->getApiUrl(),
            $this->getApiKey()
        );
    }

    /**
     * @return bool
     */
    public function isApiMetaExportEnabled(): bool
    {
        return $this->apiMetaExportEnabled;
    }

    /**
     * @param bool $apiMetaExportEnabled
     *
     * @return MetaDomainModel
     */
    public function setApiMetaExportEnabled(bool $apiMetaExportEnabled): MetaDomainModel
    {
        $this->apiMetaExportEnabled = $apiMetaExportEnabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getExportPublicUrl(): string
    {
        return 'http://' . $this->getApiUrl() . '/testrail/index.php?/api/tasks/schedule&key=' . $this->getApiKey();
    }
}