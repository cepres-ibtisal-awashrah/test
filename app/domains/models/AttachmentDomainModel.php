<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/' . BaseDomainModel::class . EXT;

/**
 * Attachment Domain Model
 *
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 * @package   Domain
 */
class AttachmentDomainModel extends BaseDomainModel
{
    /** @var int $clientId */
    protected $clientId;

    /** @var int $projectId */
    protected $projectId;

    /** @var EntityTypeEnum $entityType */
    protected $entityType;

    /** @var string $attachmentId */
    protected $attachmentId;

    /** @var DateTime $createdOn */
    protected $createdOn;

    /** @var string $dataId */
    protected $dataId;

    /** @var int $entityId */
    protected $entityId;

    /** @var string $filename */
    protected $filename;

    /** @var string $fileType */
    protected $fileType;

    /** @var int $legacyId */
    protected $legacyId;

    /** @var string $name */
    protected $name;

    /** @var int $size */
    protected $size;

    /** @var int $userId */
    protected $userId;

    /** @var bool $isImage */
    protected $isImage;

    /** @var string $icon */
    protected $icon;

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @param int $clientId
     * @return AttachmentDomainModel
     */
    public function setClientId(int $clientId): AttachmentDomainModel
    {
        $this->clientId = $clientId;
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
     * @return AttachmentDomainModel
     */
    public function setProjectId(int $projectId): AttachmentDomainModel
    {
        $this->projectId = $projectId;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * @param EntityTypeEnum $entityType
     *
     * @return AttachmentDomainModel
     */
    public function setEntityType(EntityTypeEnum $entityType): AttachmentDomainModel
    {
        $this->entityType = $entityType;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttachmentId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return AttachmentDomainModel
     */
    public function setAttachmentId(string $id): AttachmentDomainModel
    {
        $this->id = $id;
        $this->attachmentId = $id;

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
     * @return AttachmentDomainModel
     */
    public function setCreatedOn(DateTime $createdOn): AttachmentDomainModel
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataId(): string
    {
        return $this->dataId;
    }

    /**
     * @param string $dataId
     * @return AttachmentDomainModel
     */
    public function setDataId(string $dataId): AttachmentDomainModel
    {
        $this->dataId = $dataId;
        return $this;
    }

    /**
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->entityId;
    }

    /**
     * @param int $entityId
     * @return AttachmentDomainModel
     */
    public function setEntityId(int $entityId): AttachmentDomainModel
    {
        $this->entityId = $entityId;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return AttachmentDomainModel
     */
    public function setFilename(string $filename): AttachmentDomainModel
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileType(): string
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     * @return AttachmentDomainModel
     */
    public function setFileType(string $fileType): AttachmentDomainModel
    {
        $this->fileType = $fileType;
        return $this;
    }

    /**
     * @return int
     */
    public function getLegacyId(): int
    {
        return $this->legacyId;
    }

    /**
     * @param int $legacyId
     * @return AttachmentDomainModel
     */
    public function setLegacyId(int $legacyId): AttachmentDomainModel
    {
        $this->legacyId = $legacyId;
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
     * @return AttachmentDomainModel
     */
    public function setName(string $name): AttachmentDomainModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return AttachmentDomainModel
     */
    public function setSize(int $size): AttachmentDomainModel
    {
        $this->size = $size;
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
     * @return AttachmentDomainModel
     */
    public function setUserId(int $userId): AttachmentDomainModel
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isImage(): bool
    {
        return $this->isImage;
    }

    /**
     * @param bool $isImage
     * @return AttachmentDomainModel
     */
    public function setIsImage(bool $isImage): AttachmentDomainModel
    {
        $this->isImage = $isImage;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return AttachmentDomainModel
     */
    public function setIcon(string $icon): AttachmentDomainModel
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getCombinedIdWithDataId(): array
    {
        return [
            'id' => $this->getAttachmentId(),
            'data_id' => $this->getDataId()
        ];
    }
}
