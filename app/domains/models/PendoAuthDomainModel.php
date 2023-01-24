<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';

/**
 * PendoAuthDomainModel
 *
 * @package   DomainModel
 * @author    Sebastian Karpeta sebastian@assembla.com
 * @copyright 2020
 */
class PendoAuthDomainModel extends BaseDomainModel
{
    /** @var string $apiKey */
    protected $apiKey;

    /** @var string $integrationKey */
    protected $integrationKey;

    /** @var string $trackEventSecret */
    protected $trackEventSecret;

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
     * @return PendoAuthDomainModel
     */
    public function setApiKey(string $apiKey): PendoAuthDomainModel
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntegrationKey(): string
    {
        return $this->integrationKey;
    }

    /**
     * @param string $integrationKey
     *
     * @return PendoAuthDomainModel
     */
    public function setIntegrationKey(string $integrationKey): PendoAuthDomainModel
    {
        $this->integrationKey = $integrationKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getTrackEventSecret(): string
    {
        return $this->trackEventSecret;
    }

    /**
     * @param string $trackEventSecret
     *
     * @return PendoAuthDomainModel
     */
    public function setTrackEventSecret(string $trackEventSecret): PendoAuthDomainModel
    {
        $this->trackEventSecret = $trackEventSecret;
        return $this;
    }
}
