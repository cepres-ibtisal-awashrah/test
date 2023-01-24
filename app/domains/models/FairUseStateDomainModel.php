<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';

/**
 * FairUseStateDomainModel
 * @package   DomainModel
 * @author    TestRail
 * @copyright 2020
 */
class FairUseStateDomainModel extends BaseDomainModel
{
	/** @var bool $attachmentsUpload */
	protected $attachmentsUpload;

	/** @var bool $dataExport */
	protected $dataExport;

	/** @var bool $customFields */
	protected $customFields;

	/**
	 * @return bool
	 */
	public function isAttachmentsUploadAllowed(): bool
	{
		return $this->attachmentsUpload;
	}

	/**
	 * @param bool $attachmentsUpload
	 *
	 * @return static
	 */
	public function setAttachmentsUpload(bool $attachmentsUpload): BaseDomainModel
	{
		$this->attachmentsUpload = $attachmentsUpload;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isDataExportAllowed(): bool
	{
		return $this->dataExport;
	}

	/**
	 * @param bool $dataExport
	 *
	 * @return static
	 */
	public function setDataExport(bool $dataExport): BaseDomainModel
	{
		$this->dataExport = $dataExport;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isCustomFieldsAllowed(): bool
	{
		return $this->customFields;
	}

	/**
	 * @param bool $customFields
	 *
	 * @return static
	 */
	public function setCustomFields(bool $customFields): BaseDomainModel
	{
		$this->customFields = $customFields;

		return $this;
	}
}
