<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/' . IDomainDataProvider::class . EXT;

/**
 * RunSDataProvider
 *
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 * @package   Domain
 */
class RunsDataProvider implements IDomainDataProvider
{
    /** @var array $items */
    private $items = [];

    /**
     * RunsDataProvider.
     *
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
        DomainLoader::model(RunDomainModel::class);
    }

    /**
     * @return RunDomainModel[]
     */
    public function toDomain($itemsSubKey = null): array
    {
        $items = $itemsSubKey
            ? current($this->items)->items ?? []
            : $this->items;

        $runs = [];
        foreach ($items as $item) {
            /** @var RunDomainModel $runDomainModel */
            $runDomainModel = (new RunDomainModel())
                ->setId($item->id)
                ->setSuiteId($item->suite_id ?? 0)
                ->setMilestoneId($item->milestone_id ?? 0)
                ->setCreatedOn(
                    (new DateTime())->setTimestamp($item->created_on)
                )
                ->setUserId($item->user_id)
                ->setName($item->name)
                ->setDescription($item->description ?? '')
                ->setPassedCount($item->passed_count ?? 0)
                ->setRetestCount($item->retest_count)
                ->setFailedCount($item->failed_count)
                ->setUntestedCount($item->untested_count)
                ->setBlockedCount($item->blocked_count)
                ->setCustomStatus1Count($item->custom_status1_count)
                ->setCustomStatus2Count($item->custom_status2_count)
                ->setCustomStatus3Count($item->custom_status3_count)
                ->setCustomStatus4Count($item->custom_status4_count)
                ->setCustomStatus5Count($item->custom_status5_count)
                ->setCustomStatus6Count($item->custom_status6_count)
                ->setCustomStatus7Count($item->custom_status7_count);

            if (isset($item->include_all)) {
                $runDomainModel->setIncludeAll($item->include_all);
            }

            if (isset($item->assignedto_id)) {
                $runDomainModel->setAssignedtoId($item->assignedto_id);
            }

            if (isset($item->project_id)) {
                $runDomainModel->setProjectId($item->project_id);
            }

            if (isset($item->is_completed)) {
                $runDomainModel->setIsCompleted((bool)$item->is_completed);
            }

            if (isset($item->completed_on)) {
                $runDomainModel->setCompletedOn(
                    (new DateTime())->setTimestamp($item->completed_on)
                );
            }

            if (isset($item->updated_on)) {
                $runDomainModel->setUpdatedOn(
                    (new DateTime())->setTimestamp($item->updated_on)
                );
            }

            $runs[] = $runDomainModel;
        }

        return $runs;
    }
}