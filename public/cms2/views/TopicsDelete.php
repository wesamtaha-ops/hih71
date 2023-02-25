<?php

namespace PHPMaker2023\hih71;

// Page object
$TopicsDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { topics: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var ftopicsdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftopicsdelete")
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
<form name="ftopicsdelete" id="ftopicsdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="topics">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_topics_id" class="topics_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name_ar->Visible) { // name_ar ?>
        <th class="<?= $Page->name_ar->headerCellClass() ?>"><span id="elh_topics_name_ar" class="topics_name_ar"><?= $Page->name_ar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name_en->Visible) { // name_en ?>
        <th class="<?= $Page->name_en->headerCellClass() ?>"><span id="elh_topics_name_en" class="topics_name_en"><?= $Page->name_en->caption() ?></span></th>
<?php } ?>
<?php if ($Page->parent_id->Visible) { // parent_id ?>
        <th class="<?= $Page->parent_id->headerCellClass() ?>"><span id="elh_topics_parent_id" class="topics_parent_id"><?= $Page->parent_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th class="<?= $Page->image->headerCellClass() ?>"><span id="elh_topics_image" class="topics_image"><?= $Page->image->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_topics_id" class="el_topics_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name_ar->Visible) { // name_ar ?>
        <td<?= $Page->name_ar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_topics_name_ar" class="el_topics_name_ar">
<span<?= $Page->name_ar->viewAttributes() ?>>
<?= $Page->name_ar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name_en->Visible) { // name_en ?>
        <td<?= $Page->name_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_topics_name_en" class="el_topics_name_en">
<span<?= $Page->name_en->viewAttributes() ?>>
<?= $Page->name_en->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->parent_id->Visible) { // parent_id ?>
        <td<?= $Page->parent_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_topics_parent_id" class="el_topics_parent_id">
<span<?= $Page->parent_id->viewAttributes() ?>>
<?= $Page->parent_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <td<?= $Page->image->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_topics_image" class="el_topics_image">
<span>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
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
