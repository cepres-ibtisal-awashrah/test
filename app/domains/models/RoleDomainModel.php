<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/BaseDomainModel.php';

/**
 * RoleDomainModel
 * @package   RoleDomainModel
 * @author    TestRail
 * @copyright 2020
 */
class RoleDomainModel extends BaseDomainModel
{
	/** @var int $id */
	protected $id;

	/** @var string $name */
	protected $name;

	/** @var int $permissions */
	protected $permissions;

	/** @var int $is_default */
	protected $is_default;

	/** @var int $is_project_admin */
	protected $is_project_admin;

	/** @var int $display_order */
	protected $display_order;

	/**
	 * @param int $id
	 *
	 * @return int
	 */
	public function setRoleId(int $id): RoleDomainModel
	{
	    $this->id = $id;

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
	 * @return static
	 */
	public function setName(string $name): RoleDomainModel
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getPermissions(): int
	{
		return $this->permissions;
	}

	/**
	 * @param int $permissions
	 *
	 * @return static
	 */
	public function setPermissions(int $permissions): RoleDomainModel
	{
		$this->permissions = $permissions;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getDefault(): int
	{
		return $this->is_default;
	}

	/**
	 * @param int $is_default
	 *
	 * @return static
	 */
	public function setDefault(int $is_default): RoleDomainModel
	{
		$this->is_default = $is_default;

		return $this;
    }

	/**
	 * @return int
	 */
	public function getProjectAdmin(): int
	{
		return $this->is_project_admin;
	}

	/**
	 * @param int $is_project_admin
	 *
	 * @return static
	 */
	public function setProjectAdmin(int $is_project_admin): RoleDomainModel
	{
		$this->is_project_admin = $is_project_admin;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getDisplayOrder(): int
	{
		return $this->display_order;
	}

	/**
	 * @param int $display_order
	 *
	 * @return static
	 */
	public function setDisplayOrder(int $display_order): RoleDomainModel
	{
		$this->display_order = $display_order;

		return $this;
	}
}
