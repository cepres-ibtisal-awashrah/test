<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';

/**
 * Statistics to do DomainModel
 * @package   DomainModel
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright 2021
 */
class StatsToDoDomainModel extends BaseDomainModel
{
    /** @var string $name */
    protected $name;

    /** @var int $activeCount */
    protected $activeCount;

    /** @var int $upcomingCount */
    protected $upcomingCount;

    /** @var int $completionPendingCount */
    protected $completionPendingCount;

    /** @var int $assignedCases */
    protected $assignedCases;

    /** @var int $assignedRuns */
    protected $assignedRuns;

    /** @var int $assignedTests */
    protected $assignedTests;

    /** @var int $todoCount */
    protected $todoCount;

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
     * @return StatsToDoDomainModel
     */
    public function setName(string $name): StatsToDoDomainModel
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getActiveCount(): int
    {
        return $this->activeCount;
    }

    /**
     * @param int $activeCount
     *
     * @return StatsToDoDomainModel
     */
    public function setActiveCount(int $activeCount): StatsToDoDomainModel
    {
        $this->activeCount = $activeCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpcomingCount(): int
    {
        return $this->upcomingCount;
    }

    /**
     * @param int $upcomingCount
     *
     * @return StatsToDoDomainModel
     */
    public function setUpcomingCount(int $upcomingCount): StatsToDoDomainModel
    {
        $this->upcomingCount = $upcomingCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getCompletionPendingCount(): int
    {
        return $this->completionPendingCount;
    }

    /**
     * @param int $completionPendingCount
     *
     * @return StatsToDoDomainModel
     */
    public function setCompletionPendingCount(int $completionPendingCount): StatsToDoDomainModel
    {
        $this->completionPendingCount = $completionPendingCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getAssignedCases(): int
    {
        return $this->assignedCases;
    }

    /**
     * @param int $assignedCases
     *
     * @return StatsToDoDomainModel
     */
    public function setAssignedCases(int $assignedCases): StatsToDoDomainModel
    {
        $this->assignedCases = $assignedCases;

        return $this;
    }

    /**
     * @return int
     */
    public function getAssignedRuns(): int
    {
        return $this->assignedRuns;
    }

    /**
     * @param int $assignedRuns
     *
     * @return StatsToDoDomainModel
     */
    public function setAssignedRuns(int $assignedRuns): StatsToDoDomainModel
    {
        $this->assignedRuns = $assignedRuns;

        return $this;
    }

    /**
     * @return int
     */
    public function getAssignedTests(): int
    {
        return $this->assignedTests;
    }

    /**
     * @param int $assignedTests
     *
     * @return StatsToDoDomainModel
     */
    public function setAssignedTests(int $assignedTests): StatsToDoDomainModel
    {
        $this->assignedTests = $assignedTests;

        return $this;
    }

    /**
     * @return int
     */
    public function getTodoCount(): int
    {
        return $this->todoCount;
    }

    /**
     * @param int $todoCount
     *
     * @return StatsToDoDomainModel
     */
    public function setTodoCount(int $todoCount): StatsToDoDomainModel
    {
        $this->todoCount = $todoCount;

        return $this;
    }
}
