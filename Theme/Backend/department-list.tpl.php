<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\Organization
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View                        $this
 * @var \Modules\Organization\Models\Department[] $departments
 */
$departments = $this->getData('departments') ?? [];

$previous = empty($departments) ? '{/prefix}organization/department/list' : '{/prefix}organization/department/list?{?}&id=' . \reset($departments)->getId() . '&ptype=p';
$next     = empty($departments) ? '{/prefix}organization/department/list' : '{/prefix}organization/department/list?{?}&id=' . \end($departments)->getId() . '&ptype=n';

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Departments'); ?><i class="fa fa-download floatRight download btn"></i></div>
            <table id="departmentList" class="default sticky">
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                        <label for="departmentList-sort-1">
                            <input type="radio" name="departmentList-sort" id="departmentList-sort-1">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="departmentList-sort-2">
                            <input type="radio" name="departmentList-sort" id="departmentList-sort-2">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                    <td class="wf-100"><?= $this->getHtml('Name'); ?>
                        <label for="departmentList-sort-3">
                            <input type="radio" name="departmentList-sort" id="departmentList-sort-3">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="departmentList-sort-4">
                            <input type="radio" name="departmentList-sort" id="departmentList-sort-4">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                    <td><?= $this->getHtml('Parent'); ?>
                        <label for="departmentList-sort-5">
                            <input type="radio" name="departmentList-sort" id="departmentList-sort-5">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="departmentList-sort-6">
                            <input type="radio" name="departmentList-sort" id="departmentList-sort-6">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                    <td><?= $this->getHtml('Unit'); ?>
                        <label for="departmentList-sort-7">
                            <input type="radio" name="departmentList-sort" id="departmentList-sort-7">
                            <i class="sort-asc fa fa-chevron-up"></i>
                        </label>
                        <label for="departmentList-sort-8">
                            <input type="radio" name="departmentList-sort" id="departmentList-sort-8">
                            <i class="sort-desc fa fa-chevron-down"></i>
                        </label>
                        <label>
                            <i class="filter fa fa-filter"></i>
                        </label>
                <tbody>
                <?php $c     = 0; foreach ($departments as $key => $value) : ++$c;
                    $url     = UriFactory::build('{/prefix}organization/department/profile?{?}&id=' . $value->getId()); ?>
                <tr tabindex="0" data-href="<?= $url; ?>">
                    <td data-label="<?= $this->getHtml('ID', '0', '0'); ?>"><a href="<?= $url; ?>"><?= $value->getId(); ?></a>
                    <td data-label="<?= $this->getHtml('Name'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->name); ?></a>
                    <td data-label="<?= $this->getHtml('Parent'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->parent->name); ?></a>
                    <td data-label="<?= $this->getHtml('Name'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->unit->name); ?></a>
                        <?php endforeach; ?>
                <?php if ($c === 0) : ?>
                <tr>
                    <td colspan="4" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
            <div class="portlet-foot">
                <a tabindex="0" class="button" href="<?= UriFactory::build($previous); ?>"><?= $this->getHtml('Previous', '0', '0'); ?></a>
                <a tabindex="0" class="button" href="<?= UriFactory::build($next); ?>"><?= $this->getHtml('Next', '0', '0'); ?></a>
            </div>
        </div>
    </div>
</div>