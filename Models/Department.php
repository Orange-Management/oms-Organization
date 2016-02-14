<?php
/**
 * Orange Management
 *
 * PHP Version 7.0
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
namespace Modules\Organization\Models;

class Department
{
    protected $id = 0;

    protected $name = '';

    protected $parent = null;

    protected $unit = 1;

    protected $description = '';

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        return $this->name = $name;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(int $parent)
    {
        $this->parent = $parent;
    }

    public function getUnit() : int
    {
        return $this->unit;
    }

    public function setUnit(int $unit)
    {
        $this->unit = $unit;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $desc)
    {
        $this->description = $desc;
    }
}
