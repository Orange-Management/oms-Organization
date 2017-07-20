<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
/**
 * @var \phpOMS\Views\View $this
 */

$footerView = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');

$footerView->setPages(1 / 25);
$footerView->setPage(1);
$footerView->setResults(1);

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getText('Units'); ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getText('ID', 0, 0); ?>
                    <td class="wf-100"><?= $this->getText('Name'); ?>
                    <td><?= $this->getText('Parent'); ?>
                        <tfoot>
                <tr><td colspan="3"><?= $footerView->render(); ?>
                        <tbody>
                        <?php foreach ($this->getData('list:elements') as $key => $value) :
                        $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/organization/unit/profile?{?}&id=' . $value->getId()); ?>
                <tr data-href="<?= $url; ?>">
                    <td data-label="<?= $this->getText('ID', 0, 0); ?>"><a href="<?= $url; ?>"><?= $value->getId(); ?></a>
                    <td data-label="<?= $this->getText('Name'); ?>"><a href="<?= $url; ?>"><?= $value->getName(); ?></a>
                    <td data-label="<?= $this->getText('Parent'); ?>"><a href="<?= $url; ?>"><?= $value->getParent(); ?></a>
                        <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
