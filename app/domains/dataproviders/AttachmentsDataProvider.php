<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/' . IDomainDataProvider::class . EXT;
require_once APPPATH . 'enums/' . EntityTypeEnum::class . EXT;

/**
 * AttachmentsDataProvider
 *
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 * @package   Domain
 */
class AttachmentsDataProvider implements IDomainDataProvider
{
    /** @var array $items */
    private $items;

    /**
     * RunsDataProvider.
     *
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
        DomainLoader::model(AttachmentDomainModel::class);
    }

    /**
     * @return AttachmentDomainModel[]
     */
    public function toDomain($itemsSubKey = null): array
    {
        $items = $itemsSubKey
            ? current($this->items)->items ?? []
            : $this->items;

        $attachments = [];
        foreach ($items as $item) {
            $attachments[] = (new AttachmentDomainModel)
                ->setClientId($item->client_id)
                ->setProjectId($item->project_id)
                ->setEntityType(EntityTypeEnum::tryParseFromValue($item->entity_type))
                ->setAttachmentId($item->id)
                ->setCreatedOn((new DateTime())->setTimestamp($item->created_on))
                ->setDataId($item->data_id)
                ->setEntityId($item->entity_id)
                ->setFileName($item->filename)
                ->setFileType($item->filetype)
                ->setLegacyId($item->legacy_id)
                ->setName($item->name)
                ->setSize($item->size)
                ->setUserId($item->user_id)
                ->setIsImage($item->is_image)
                ->setIcon($item->icon);
        }

        return $attachments;
    }

    /**
     * Extracting Id and Data id for attachments.
     *
     * @param AttachmentDomainModel[] $items
     *
     * @return string[]
     */
    public static function extractAttachmentsIdAndDataId(array $items): array
    {
        $attachments = [];
        foreach ($items as $item) {
            $attachments[] = [
                'id' => $item->getAttachmentId(),
                'data_id' => $item->getDataId(),
            ];
        }

        return $attachments;
    }
}