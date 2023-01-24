<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';

/**
 * BannerDomainModel
 * @package   DomainModel
 * @author    Sebastian Karpeta sebastian@assembla.com
 * @copyright 2019
 */
class BannerDomainModel extends BaseDomainModel
{
    /** @var string $content */
    protected $content;

    /** @var \DateTime $startDate */
    protected $startDate;

    /** @var \DateTime $endDate */
    protected $endDate;

    /** @var bool $resetCookie */
    protected $resetCookie;

    /** @var \DateTime $lastResetCookieDate */
    protected $lastResetCookieDate;

    /** @var bool $active */
    protected $active;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return static
     */
    public function setContent(string $content): BaseDomainModel
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return static
     */
    public function setStartDate(\DateTime $startDate): BaseDomainModel
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     *
     * @return static
     */
    public function setEndDate(\DateTime $endDate): BaseDomainModel
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isForceResetCookieSet(): bool
    {
        return $this->resetCookie;
    }

    /**
     * @param bool $resetCookie
     *
     * @return BaseDomainModel
     */
    public function setForceResetCookie(bool $resetCookie): BaseDomainModel
    {
        $this->resetCookie = $resetCookie;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return BaseDomainModel
     */
    public function setActive(bool $active): BaseDomainModel
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastResetCookieDate()
    {
        return $this->lastResetCookieDate;
    }

    /**
     * @param \DateTime $lastResetCookieDate
     *
     * @return BannerDomainModel
     */
    public function setLastResetCookieDate(\DateTime $lastResetCookieDate): BannerDomainModel
    {
        $this->lastResetCookieDate = $lastResetCookieDate;

        return $this;
    }
}
