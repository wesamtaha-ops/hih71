<?php

namespace PHPMaker2023\hih71;

// Page object
$TeachersPackagesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<form name="fteachers_packagesview" id="fteachers_packagesview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { teachers_packages: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fteachers_packagesview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fteachers_packagesview")
        .setPageId("view")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="teachers_packages">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_teachers_packages_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_teachers_packages_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->teacher_id->Visible) { // teacher_id ?>
    <tr id="r_teacher_id"<?= $Page->teacher_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_teachers_packages_teacher_id"><?= $Page->teacher_id->caption() ?></span></td>
        <td data-name="teacher_id"<?= $Page->teacher_id->cellAttributes() ?>>
<span id="el_teachers_packages_teacher_id">
<span<?= $Page->teacher_id->viewAttributes() ?>>
<?= $Page->teacher_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
    <tr id="r_title_en"<?= $Page->title_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_teachers_packages_title_en"><?= $Page->title_en->caption() ?></span></td>
        <td data-name="title_en"<?= $Page->title_en->cellAttributes() ?>>
<span id="el_teachers_packages_title_en">
<span<?= $Page->title_en->viewAttributes() ?>>
<?= $Page->title_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->title_ar->Visible) { // title_ar ?>
    <tr id="r_title_ar"<?= $Page->title_ar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_teachers_packages_title_ar"><?= $Page->title_ar->caption() ?></span></td>
        <td data-name="title_ar"<?= $Page->title_ar->cellAttributes() ?>>
<span id="el_teachers_packages_title_ar">
<span<?= $Page->title_ar->viewAttributes() ?>>
<?= $Page->title_ar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description_en->Visible) { // description_en ?>
    <tr id="r_description_en"<?= $Page->description_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_teachers_packages_description_en"><?= $Page->description_en->caption() ?></span></td>
        <td data-name="description_en"<?= $Page->description_en->cellAttributes() ?>>
<span id="el_teachers_packages_description_en">
<span<?= $Page->description_en->viewAttributes() ?>>
<?= $Page->description_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description_ar->Visible) { // description_ar ?>
    <tr id="r_description_ar"<?= $Page->description_ar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_teachers_packages_description_ar"><?= $Page->description_ar->caption() ?></span></td>
        <td data-name="description_ar"<?= $Page->description_ar->cellAttributes() ?>>
<span id="el_teachers_packages_description_ar">
<span<?= $Page->description_ar->viewAttributes() ?>>
<?= $Page->description_ar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <tr id="r_image"<?= $Page->image->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_teachers_packages_image"><?= $Page->image->caption() ?></span></td>
        <td data-name="image"<?= $Page->image->cellAttributes() ?>>
<span id="el_teachers_packages_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fees->Visible) { // fees ?>
    <tr id="r_fees"<?= $Page->fees->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_teachers_packages_fees"><?= $Page->fees->caption() ?></span></td>
        <td data-name="fees"<?= $Page->fees->cellAttributes() ?>>
<span id="el_teachers_packages_fees">
<span<?= $Page->fees->viewAttributes() ?>>
<?= $Page->fees->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
    <tr id="r_currency_id"<?= $Page->currency_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_teachers_packages_currency_id"><?= $Page->currency_id->caption() ?></span></td>
        <td data-name="currency_id"<?= $Page->currency_id->cellAttributes() ?>>
<span id="el_teachers_packages_currency_id">
<span<?= $Page->currency_id->viewAttributes() ?>>
<?= $Page->currency_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_teachers_packages_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at"<?= $Page->created_at->cellAttributes() ?>>
<span id="el_teachers_packages_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
