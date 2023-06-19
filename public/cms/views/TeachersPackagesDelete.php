<?php

namespace PHPMaker2023\hih71;

// Page object
$TeachersPackagesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { teachers_packages: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fteachers_packagesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fteachers_packagesdelete")
        .setPageId("delete")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fteachers_packagesdelete" id="fteachers_packagesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="teachers_packages">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_teachers_packages_id" class="teachers_packages_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->teacher_id->Visible) { // teacher_id ?>
        <th class="<?= $Page->teacher_id->headerCellClass() ?>"><span id="elh_teachers_packages_teacher_id" class="teachers_packages_teacher_id"><?= $Page->teacher_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
        <th class="<?= $Page->title_en->headerCellClass() ?>"><span id="elh_teachers_packages_title_en" class="teachers_packages_title_en"><?= $Page->title_en->caption() ?></span></th>
<?php } ?>
<?php if ($Page->title_ar->Visible) { // title_ar ?>
        <th class="<?= $Page->title_ar->headerCellClass() ?>"><span id="elh_teachers_packages_title_ar" class="teachers_packages_title_ar"><?= $Page->title_ar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->description_en->Visible) { // description_en ?>
        <th class="<?= $Page->description_en->headerCellClass() ?>"><span id="elh_teachers_packages_description_en" class="teachers_packages_description_en"><?= $Page->description_en->caption() ?></span></th>
<?php } ?>
<?php if ($Page->description_ar->Visible) { // description_ar ?>
        <th class="<?= $Page->description_ar->headerCellClass() ?>"><span id="elh_teachers_packages_description_ar" class="teachers_packages_description_ar"><?= $Page->description_ar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th class="<?= $Page->image->headerCellClass() ?>"><span id="elh_teachers_packages_image" class="teachers_packages_image"><?= $Page->image->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fees->Visible) { // fees ?>
        <th class="<?= $Page->fees->headerCellClass() ?>"><span id="elh_teachers_packages_fees" class="teachers_packages_fees"><?= $Page->fees->caption() ?></span></th>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
        <th class="<?= $Page->currency_id->headerCellClass() ?>"><span id="elh_teachers_packages_currency_id" class="teachers_packages_currency_id"><?= $Page->currency_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_teachers_packages_created_at" class="teachers_packages_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_teachers_packages_id" class="el_teachers_packages_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->teacher_id->Visible) { // teacher_id ?>
        <td<?= $Page->teacher_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_teachers_packages_teacher_id" class="el_teachers_packages_teacher_id">
<span<?= $Page->teacher_id->viewAttributes() ?>>
<?= $Page->teacher_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
        <td<?= $Page->title_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_teachers_packages_title_en" class="el_teachers_packages_title_en">
<span<?= $Page->title_en->viewAttributes() ?>>
<?= $Page->title_en->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->title_ar->Visible) { // title_ar ?>
        <td<?= $Page->title_ar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_teachers_packages_title_ar" class="el_teachers_packages_title_ar">
<span<?= $Page->title_ar->viewAttributes() ?>>
<?= $Page->title_ar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->description_en->Visible) { // description_en ?>
        <td<?= $Page->description_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_teachers_packages_description_en" class="el_teachers_packages_description_en">
<span<?= $Page->description_en->viewAttributes() ?>>
<?= $Page->description_en->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->description_ar->Visible) { // description_ar ?>
        <td<?= $Page->description_ar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_teachers_packages_description_ar" class="el_teachers_packages_description_ar">
<span<?= $Page->description_ar->viewAttributes() ?>>
<?= $Page->description_ar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <td<?= $Page->image->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_teachers_packages_image" class="el_teachers_packages_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->fees->Visible) { // fees ?>
        <td<?= $Page->fees->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_teachers_packages_fees" class="el_teachers_packages_fees">
<span<?= $Page->fees->viewAttributes() ?>>
<?= $Page->fees->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
        <td<?= $Page->currency_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_teachers_packages_currency_id" class="el_teachers_packages_currency_id">
<span<?= $Page->currency_id->viewAttributes() ?>>
<?= $Page->currency_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td<?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_teachers_packages_created_at" class="el_teachers_packages_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
