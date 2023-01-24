<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/' . BaseDomainModel::class . EXT;
require_once APPPATH . 'domains/' . IPaginationDomainModel::class . EXT;

/**
 * Pagination DomainModel
 *
 * @package   DomainModel
 * @author    TestRail
 * @copyright 2020
 */
class PaginationDomainModel extends BaseDomainModel implements IPaginationDomainModel
{
    /** @var array $elements */
    protected $elements;

    /** @var DisplayEnum $display */
    protected $display;

    /** @var bool $showActions */
    protected $showActions;

    /** @var string $groupBy */
    protected $groupBy;

    /** @var string $orderBy */
    protected $orderBy;

    /** @var int $limit */
    protected $limit;

    /** @var int $offset */
    protected $offset;

    /** @var int $projectId */
    protected $projectId;

    /** @var int $totalRows */
    protected $totalRows;

    /** @var RunTypeEnum $type */
    protected $type;

    /** @var string $paginationCookieKey */
    protected $paginationCookieKey;

    /**
     * @inheritDoc
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * @inheritDoc
     */
    public function setElements(array $elements): PaginationDomainModel
    {
        $this->elements = $elements;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDisplay(): DisplayEnum
    {
        return $this->display;
    }

    /**
     * @inheritDoc
     */
    public function setDisplay(DisplayEnum $display): PaginationDomainModel
    {
        $this->display = $display;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isShowActions(): bool
    {
        return $this->showActions;
    }

    /**
     * @inheritDoc
     */
    public function setShowActions(bool $showActions): PaginationDomainModel
    {
        $this->showActions = $showActions;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getGroupBy(): string
    {
        return $this->groupBy;
    }

    /**
     * @inheritDoc
     */
    public function setGroupBy(string $groupBy): PaginationDomainModel
    {
        $this->groupBy = $groupBy;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @inheritDoc
     */
    public function setOrderBy(string $orderBy): PaginationDomainModel
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @inheritDoc
     */
    public function setLimit(int $limit): PaginationDomainModel
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @inheritDoc
     */
    public function setOffset(int $offset): PaginationDomainModel
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @inheritDoc
     */
    public function setProjectId(int $projectId): PaginationDomainModel
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalRows(): int
    {
        return $this->totalRows;
    }

    /**
     * @param int $totalRows
     *
     * @return PaginationDomainModel
     */
    public function setTotalRows(int $totalRows): PaginationDomainModel
    {
        $this->totalRows = $totalRows;

        return $this;
    }

    /**
     * @return RunTypeEnum
     */
    public function getType(): RunTypeEnum
    {
        return $this->type;
    }

    /**
     * @param RunTypeEnum $type
     *
     * @return PaginationDomainModel
     */
    public function setType(RunTypeEnum $type): PaginationDomainModel
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaginationCookieKey(): string
    {
        return $this->paginationCookieKey;
    }

    /**
     * @param string $paginationCookieKey
     *
     * @return PaginationDomainModel
     */
    public function setPaginationCookieKey(string $paginationCookieKey): PaginationDomainModel
    {
        $this->paginationCookieKey = $paginationCookieKey
            . SpecialCharsEnum::$UNDERLINE->value
            . $this->getProjectId();

        return $this;
    }
}
