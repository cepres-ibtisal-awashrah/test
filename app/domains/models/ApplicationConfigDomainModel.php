<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';
require_once APPPATH . 'domains/models/' . PendoAuthDomainModel::class . EXT;

/**
 * ApplicationConfigDomainModel
 * @package   DomainModel
 * @author    Sebastian Karpeta sebastian@assembla.com
 * @copyright 2020
 */
class ApplicationConfigDomainModel extends BaseDomainModel
{
    /** @var PendoAuthDomainModel */
    protected $pendoAuth;

	/** @var MetaDomainModel $metaDomainModel */
	protected $metaDomainModel;

    /**
     * @return PendoAuthDomainModel
     */
    public function getPendoAuth(): PendoAuthDomainModel
    {
        return $this->pendoAuth;
    }

    /**
     * @param PendoAuthDomainModel $pendoAuth
     *
     * @return ApplicationConfigDomainModel
     */
    public function setPendoAuth(PendoAuthDomainModel $pendoAuth): ApplicationConfigDomainModel
    {
        $this->pendoAuth = $pendoAuth;
        return $this;
    }

	/**
	 * @return MetaDomainModel
	 */
	public function getMeta(): MetaDomainModel
	{
		return $this->metaDomainModel;
	}

	/**
	 * @param MetaDomainModel $metaDomainModel
	 *
	 * @return ApplicationConfigDomainModel
	 */
	public function setMeta(MetaDomainModel $metaDomainModel): ApplicationConfigDomainModel
	{
		$this->metaDomainModel = $metaDomainModel;

		return $this;
	}
}
