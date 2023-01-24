<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * IPaginationDomainModel
 * @package   DomainModel Interface
 * @author    Sebastian Karpeta sebastian@assembla.com
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
interface IPaginationDomainModel
{
    /**
     * @return array
     */
    public function getElements(): array;

    /**
     * @param array $elements
     *
     * @return PaginationDomainModel
     */
    public function setElements(array $elements): PaginationDomainModel;

    /**
     * @return DisplayEnum
     */
    public function getDisplay(): DisplayEnum;

    /**
     * @param DisplayEnum $display
     *
     * @return PaginationDomainModel
     */
    public function setDisplay(DisplayEnum $display): PaginationDomainModel;

    /**
     * @return bool
     */
    public function isShowActions(): bool;

    /**
     * @param bool $show_actions
     *
     * @return PaginationDomainModel
     */
    public function setShowActions(bool $show_actions): PaginationDomainModel;

    /**
     * @return string
     */
    public function getGroupBy(): string;

    /**
     * @param string $group_by
     *
     * @return PaginationDomainModel
     */
    public function setGroupBy(string $group_by): PaginationDomainModel;

    /**
     * @return string
     */
    public function getOrderBy(): string;

    /**
     * @param string $order_by
     *
     * @return PaginationDomainModel
     */
    public function setOrderBy(string $order_by): PaginationDomainModel;

    /**
     * @return int
     */
    public function getLimit(): int;

    /**
     * @param int $limit
     *
     * @return PaginationDomainModel
     */
    public function setLimit(int $limit): PaginationDomainModel;

    /**
     * @return int
     */
    public function getOffset(): int;

    /**
     * @param int $offset
     *
     * @return PaginationDomainModel
     */
    public function setOffset(int $offset): PaginationDomainModel;

    /**
     * @return int
     */
    public function getProjectId(): int;


    /**
     * @param int $projectId
     *
     * @return PaginationDomainModel
     */
    public function setProjectId(int $projectId): PaginationDomainModel;
}
