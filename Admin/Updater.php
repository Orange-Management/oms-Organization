<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\Organization\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Organization\Admin;

use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\UpdaterAbstract;
use phpOMS\System\File\Local\Directory;

/**
 * Navigation class.
 *
 * @package Modules\Organization\Admin
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class Updater extends UpdaterAbstract
{
    /**
     * {@inheritdoc}
     */
    public static function update(DatabasePool $dbPool, InfoManager $info) : void
    {
        Directory::delete(__DIR__ . '/Update');
        \mkdir('Update');
        parent::update($dbPool, $info);
    }
}
