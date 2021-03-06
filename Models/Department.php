<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\Organization\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Organization\Models;

use phpOMS\Contract\ArrayableInterface;

/**
 * Organization department class.
 *
 * @package Modules\Organization\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class Department implements \JsonSerializable, ArrayableInterface
{
    /**
     * Article ID.
     *
     * @var int
     * @since 1.0.0
     */
    protected int $id = 0;

    /**
     * Name.
     *
     * @var string
     * @since 1.0.0
     */
    public string $name = '';

    /**
     * Parent
     *
     * @var self
     * @since 1.0.0
     */
    public self $parent;

    /**
     * Status
     *
     * @var int
     * @since 1.0.0
     */
    protected int $status = Status::INACTIVE;

    /**
     * Unit this department belongs to
     *
     * @var Unit
     * @since 1.0.0
     */
    public Unit $unit;

    /**
     * Description.
     *
     * @var string
     * @since 1.0.0
     */
    public string $description = '';

    /**
     * Description.
     *
     * @var string
     * @since 1.0.0
     */
    public string $descriptionRaw = '';

    /**
     * Constructor
     *
     * @param string $name Department name
     *
     * @since 1.0.0
     */
    public function __construct(string $name = '')
    {
        $this->name   = $name;
        $this->parent = new NullDepartment();
        $this->unit   = new NullUnit();
    }

    /**
     * Get id
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get status
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param int $status Status
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setStatus(int $status) : void
    {
        $this->status = $status;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'status'         => $this->status,
            'description'    => $this->description,
            'descriptionRaw' => $this->descriptionRaw,
            'unit'           => $this->unit ?? new NullUnit(),
            'parent'         => $this->parent ?? new NullDepartment(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
