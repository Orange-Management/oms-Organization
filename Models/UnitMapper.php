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

use Modules\Media\Models\MediaMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;

/**
 * Organization unit mapper class.
 *
 * @package Modules\Organization\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class UnitMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    protected static array $columns = [
        'organization_unit_id'             => ['name' => 'organization_unit_id',             'type' => 'int',    'internal' => 'id'],
        'organization_unit_name'           => ['name' => 'organization_unit_name',           'type' => 'string', 'internal' => 'name', 'autocomplete' => true],
        'organization_unit_image'          => ['name' => 'organization_unit_image',          'type' => 'int',    'internal' => 'image'],
        'organization_unit_description'    => ['name' => 'organization_unit_description',    'type' => 'string', 'internal' => 'description'],
        'organization_unit_descriptionraw' => ['name' => 'organization_unit_descriptionraw', 'type' => 'string', 'internal' => 'descriptionRaw'],
        'organization_unit_parent'         => ['name' => 'organization_unit_parent',         'type' => 'int',    'internal' => 'parent'],
        'organization_unit_status'         => ['name' => 'organization_unit_status',         'type' => 'int',    'internal' => 'status'],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    protected static array $ownsOne = [
        'image'    => [
            'mapper'     => MediaMapper::class,
            'external'   => 'organization_unit_image',
        ],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:string, external:string}>
     * @since 1.0.0
     */
    protected static array $belongsTo = [
        'parent'  => [
            'mapper'     => self::class,
            'external'   => 'organization_unit_parent',
        ],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    protected static array $hasMany = [
        'files'           => [
            'mapper'   => MediaMapper::class,              /* mapper of the related object */
            'table'    => 'organization_unit_media',       /* table of the related object, null if no relation table is used (many->1) */
            'external' => 'organization_unit_media_dst',
            'self'     => 'organization_unit_media_src',
        ],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $model = Unit::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $table = 'organization_unit';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $primaryField = 'organization_unit_id';
}
