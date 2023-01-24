<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';

/**
 * SettingDomainModel
 * @package   DomainModel
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright 2020
 */
class SettingDomainModel extends BaseDomainModel
{
	/** @var string $name */
	protected $name;

	/** @var int $value */
	protected $value;

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
	 * @return static
	 */
	public function setName(string $name): SettingDomainModel
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getValue(): int
	{
		return $this->value;
	}

	/**
	 * @param int $value
	 *
	 * @return static
	 */
	public function setValue(int $value): SettingDomainModel
	{
		$this->value = $value;

		return $this;
	}
}
