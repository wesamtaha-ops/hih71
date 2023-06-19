<?php

namespace PHPMaker2023\hih71;

// Page object
$ReviewsDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { reviews: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var freviewsdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("freviewsdelete")
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
<form name="freviewsdelete" id="freviewsdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="reviews">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_reviews_id" class="reviews_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->from_user_id->Visible) { // from_user_id ?>
        <th class="<?= $Page->from_user_id->headerCellClass() ?>"><span id="elh_reviews_from_user_id" class="reviews_from_user_id"><?= $Page->from_user_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->to_user_id->Visible) { // to_user_id ?>
        <th class="<?= $Page->to_user_id->headerCellClass() ?>"><span id="elh_reviews_to_user_id" class="reviews_to_user_id"><?= $Page->to_user_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->points->Visible) { // points ?>
        <th class="<?= $Page->points->headerCellClass() ?>"><span id="elh_reviews_points" class="reviews_points"><?= $Page->points->caption() ?></span></th>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
        <th class="<?= $Page->approved->headerCellClass() ?>"><span id="elh_reviews_approved" class="reviews_approved"><?= $Page->approved->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_reviews_created_at" class="reviews_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_reviews_updated_at" class="reviews_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_reviews_id" class="el_reviews_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->from_user_id->Visible) { // from_user_id ?>
        <td<?= $Page->from_user_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_reviews_from_user_id" class="el_reviews_from_user_id">
<span<?= $Page->from_user_id->viewAttributes() ?>>
<?= $Page->from_user_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->to_user_id->Visible) { // to_user_id ?>
        <td<?= $Page->to_user_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_reviews_to_user_id" class="el_reviews_to_user_id">
<span<?= $Page->to_user_id->viewAttributes() ?>>
<?= $Page->to_user_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->points->Visible) { // points ?>
        <td<?= $Page->points->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_reviews_points" class="el_reviews_points">
<span<?= $Page->points->viewAttributes() ?>>
<?= $Page->points->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
        <td<?= $Page->approved->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_reviews_approved" class="el_reviews_approved">
<span<?= $Page->approved->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_approved_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->approved->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->approved->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_approved_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td<?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_reviews_created_at" class="el_reviews_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td<?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_reviews_updated_at" class="el_reviews_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
