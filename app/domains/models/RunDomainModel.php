<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/' . BaseDomainModel::class . EXT;

/**
 * Run Domain Model
 *
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 * @package   Domain
 */
class RunDomainModel extends BaseDomainModel
{
    /** @var int $suiteId */
    protected $suiteId;

    /** @var int $milestoneId */
    protected $milestoneId;

    /** @var DateTime $createdOn */
    protected $createdOn;

    /** @var int $userId */
    protected $userId;

    /** @var int $projectId */
    protected $projectId;

    /** @var bool $isCompleted */
    protected $isCompleted;

    /** @var DateTime $completedOn */
    protected $completedOn;

    /** @var int $includeAll */
    protected $includeAll;

    /** @var string $name */
    protected $name;

    /** @var string $description */
    protected $description;

    /** @var int $passedCount */
    protected $passedCount;

    /** @var int $retestCount */
    protected $retestCount;

    /** @var int $failedCount */
    protected $failedCount;

    /** @var int $untestedCount */
    protected $untestedCount;

    /** @var int $assignedtoId */
    protected $assignedtoId;

    /** @var int $isPlan */
    protected $isPlan;

    /** @var int $planId */
    protected $planId;

    /** @var int $entryId */
    protected $entryId;

    /** @var int $entries */
    protected $entries;

    /** @var int $config */
    protected $config;

    /** @var int $configIds */
    protected $configIds;

    /** @var int $entryIndex */
    protected $entryIndex;

    /** @var int $blockedCount */
    protected $blockedCount;

    /** @var int $isEditable */
    protected $isEditable;

    /** @var int $contentId */
    protected $contentId;

    /** @var int $customStatus1Count */
    protected $customStatus1Count;

    /** @var int $customStatus2Count */
    protected $customStatus2Count;

    /** @var int $customStatus3Count */
    protected $customStatus3Count;

    /** @var int $customStatus4Count */
    protected $customStatus4Count;

    /** @var int $customStatus5Count */
    protected $customStatus5Count;

    /** @var int $customStatus6Count */
    protected $customStatus6Count;

    /** @var int $customStatus7Count */
    protected $customStatus7Count;

    /** @var int $updatedBy */
    protected $updatedBy;

    /** @var DateTime $updatedOn */
    protected $updatedOn;

    /** @var string $refs */
    protected $refs;

    /**
     * @return int
     */
    public function getSuiteId(): int
    {
        return $this->suiteId;
    }

    /**
     * @param int $suiteId
     *
     * @return RunDomainModel
     */
    public function setSuiteId(int $suiteId): RunDomainModel
    {
        $this->suiteId = $suiteId;

        return $this;
    }

    /**
     * @return int
     */
    public function getMilestoneId(): int
    {
        return $this->milestoneId;
    }

    /**
     * @param int $milestoneId
     *
     * @return RunDomainModel
     */
    public function setMilestoneId(int $milestoneId): RunDomainModel
    {
        $this->milestoneId = $milestoneId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }

    /**
     * @param DateTime $createdOn
     *
     * @return RunDomainModel
     */
    public function setCreatedOn(DateTime $createdOn): RunDomainModel
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return RunDomainModel
     */
    public function setUserId(int $userId): RunDomainModel
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @param int $projectId
     *
     * @return RunDomainModel
     */
    public function setProjectId(int $projectId): RunDomainModel
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * @return int
     */
    public function getIsCompleted(): bool
    {
        return $this->isCompleted;
    }

    /**
     * @param int $isCompleted
     *
     * @return RunDomainModel
     */
    public function setIsCompleted(bool $isCompleted): RunDomainModel
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCompletedOn(): DateTime
    {
        return $this->completedOn;
    }

    /**
     * @param DateTime $completedOn
     *
     * @return RunDomainModel
     */
    public function setCompletedOn(DateTime $completedOn): RunDomainModel
    {
        $this->completedOn = $completedOn;

        return $this;
    }

    /**
     * @return int
     */
    public function getIncludeAll(): int
    {
        return $this->includeAll;
    }

    /**
     * @param int $includeAll
     *
     * @return RunDomainModel
     */
    public function setIncludeAll(int $includeAll): RunDomainModel
    {
        $this->includeAll = $includeAll;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return RunDomainModel
     */
    public function setName(string $name): RunDomainModel
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return RunDomainModel
     */
    public function setDescription(string $description): RunDomainModel
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getPassedCount(): int
    {
        return $this->passedCount;
    }

    /**
     * @param int $passedCount
     *
     * @return RunDomainModel
     */
    public function setPassedCount(int $passedCount): RunDomainModel
    {
        $this->passedCount = $passedCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getRetestCount(): int
    {
        return $this->retestCount;
    }

    /**
     * @param int $retestCount
     *
     * @return RunDomainModel
     */
    public function setRetestCount(int $retestCount): RunDomainModel
    {
        $this->retestCount = $retestCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getFailedCount(): int
    {
        return $this->failedCount;
    }

    /**
     * @param int $failedCount
     *
     * @return RunDomainModel
     */
    public function setFailedCount(int $failedCount): RunDomainModel
    {
        $this->failedCount = $failedCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getUntestedCount(): int
    {
        return $this->untestedCount;
    }

    /**
     * @param int $untestedCount
     *
     * @return RunDomainModel
     */
    public function setUntestedCount(int $untestedCount): RunDomainModel
    {
        $this->untestedCount = $untestedCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getAssignedtoId(): int
    {
        return $this->assignedtoId;
    }

    /**
     * @param int $assignedtoId
     *
     * @return RunDomainModel
     */
    public function setAssignedtoId(int $assignedtoId): RunDomainModel
    {
        $this->assignedtoId = $assignedtoId;

        return $this;
    }

    /**
     * @return int
     */
    public function getIsPlan(): int
    {
        return $this->isPlan;
    }

    /**
     * @param int $isPlan
     *
     * @return RunDomainModel
     */
    public function setIsPlan(int $isPlan): RunDomainModel
    {
        $this->isPlan = $isPlan;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlanId(): int
    {
        return $this->planId;
    }

    /**
     * @param int $planId
     *
     * @return RunDomainModel
     */
    public function setPlanId(int $planId): RunDomainModel
    {
        $this->planId = $planId;

        return $this;
    }

    /**
     * @return int
     */
    public function getEntryId(): int
    {
        return $this->entryId;
    }

    /**
     * @param int $entryId
     *
     * @return RunDomainModel
     */
    public function setEntryId(int $entryId): RunDomainModel
    {
        $this->entryId = $entryId;

        return $this;
    }

    /**
     * @return int
     */
    public function getEntries(): int
    {
        return $this->entries;
    }

    /**
     * @param int $entries
     *
     * @return RunDomainModel
     */
    public function setEntries(int $entries): RunDomainModel
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * @return int
     */
    public function getConfig(): int
    {
        return $this->config;
    }

    /**
     * @param int $config
     *
     * @return RunDomainModel
     */
    public function setConfig(int $config): RunDomainModel
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return int
     */
    public function getConfigIds(): int
    {
        return $this->configIds;
    }

    /**
     * @param int $configIds
     *
     * @return RunDomainModel
     */
    public function setConfigIds(int $configIds): RunDomainModel
    {
        $this->configIds = $configIds;

        return $this;
    }

    /**
     * @return int
     */
    public function getEntryIndex(): int
    {
        return $this->entryIndex;
    }

    /**
     * @param int $entryIndex
     *
     * @return RunDomainModel
     */
    public function setEntryIndex(int $entryIndex): RunDomainModel
    {
        $this->entryIndex = $entryIndex;

        return $this;
    }

    /**
     * @return int
     */
    public function getBlockedCount(): int
    {
        return $this->blockedCount;
    }

    /**
     * @param int $blockedCount
     *
     * @return RunDomainModel
     */
    public function setBlockedCount(int $blockedCount): RunDomainModel
    {
        $this->blockedCount = $blockedCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getIsEditable(): int
    {
        return $this->isEditable;
    }

    /**
     * @param int $isEditable
     *
     * @return RunDomainModel
     */
    public function setIsEditable(int $isEditable): RunDomainModel
    {
        $this->isEditable = $isEditable;

        return $this;
    }

    /**
     * @return int
     */
    public function getContentId(): int
    {
        return $this->contentId;
    }

    /**
     * @param int $contentId
     *
     * @return RunDomainModel
     */
    public function setContentId(int $contentId): RunDomainModel
    {
        $this->contentId = $contentId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomStatus1Count(): int
    {
        return $this->customStatus1Count;
    }

    /**
     * @param int $customStatus1Count
     *
     * @return RunDomainModel
     */
    public function setCustomStatus1Count(int $customStatus1Count): RunDomainModel
    {
        $this->customStatus1Count = $customStatus1Count;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomStatus2Count(): int
    {
        return $this->customStatus2Count;
    }

    /**
     * @param int $customStatus2Count
     *
     * @return RunDomainModel
     */
    public function setCustomStatus2Count(int $customStatus2Count): RunDomainModel
    {
        $this->customStatus2Count = $customStatus2Count;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomStatus3Count(): int
    {
        return $this->customStatus3Count;
    }

    /**
     * @param int $customStatus3Count
     *
     * @return RunDomainModel
     */
    public function setCustomStatus3Count(int $customStatus3Count): RunDomainModel
    {
        $this->customStatus3Count = $customStatus3Count;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomStatus4Count(): int
    {
        return $this->customStatus4Count;
    }

    /**
     * @param int $customStatus4Count
     *
     * @return RunDomainModel
     */
    public function setCustomStatus4Count(int $customStatus4Count): RunDomainModel
    {
        $this->customStatus4Count = $customStatus4Count;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomStatus5Count(): int
    {
        return $this->customStatus5Count;
    }

    /**
     * @param int $customStatus5Count
     *
     * @return RunDomainModel
     */
    public function setCustomStatus5Count(int $customStatus5Count): RunDomainModel
    {
        $this->customStatus5Count = $customStatus5Count;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomStatus6Count(): int
    {
        return $this->customStatus6Count;
    }

    /**
     * @param int $customStatus6Count
     *
     * @return RunDomainModel
     */
    public function setCustomStatus6Count(int $customStatus6Count): RunDomainModel
    {
        $this->customStatus6Count = $customStatus6Count;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomStatus7Count(): int
    {
        return $this->customStatus7Count;
    }

    /**
     * @param int $customStatus7Count
     *
     * @return RunDomainModel
     */
    public function setCustomStatus7Count(int $customStatus7Count): RunDomainModel
    {
        $this->customStatus7Count = $customStatus7Count;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedBy(): int
    {
        return $this->updatedBy;
    }

    /**
     * @param int $updatedBy
     *
     * @return RunDomainModel
     */
    public function setUpdatedBy(int $updatedBy): RunDomainModel
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedOn(): DateTime
    {
        return $this->updatedOn;
    }

    /**
     * @param DateTime $updatedOn
     *
     * @return RunDomainModel
     */
    public function setUpdatedOn(DateTime $updatedOn): RunDomainModel
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * @return string
     */
    public function getRefs(): string
    {
        return $this->refs;
    }

    /**
     * @param string $refs
     *
     * @return RunDomainModel
     */
    public function setRefs(string $refs): RunDomainModel
    {
        $this->refs = $refs;

        return $this;
    }
}
