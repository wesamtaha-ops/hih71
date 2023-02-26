<?php

namespace PHPMaker2023\hih71;

// Page object
$OrdersDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { orders: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fordersdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fordersdelete")
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
<form name="fordersdelete" id="fordersdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="orders">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_orders_id" class="orders_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->student_id->Visible) { // student_id ?>
        <th class="<?= $Page->student_id->headerCellClass() ?>"><span id="elh_orders_student_id" class="orders_student_id"><?= $Page->student_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->teacher_id->Visible) { // teacher_id ?>
        <th class="<?= $Page->teacher_id->headerCellClass() ?>"><span id="elh_orders_teacher_id" class="orders_teacher_id"><?= $Page->teacher_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->topic_id->Visible) { // topic_id ?>
        <th class="<?= $Page->topic_id->headerCellClass() ?>"><span id="elh_orders_topic_id" class="orders_topic_id"><?= $Page->topic_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <th class="<?= $Page->date->headerCellClass() ?>"><span id="elh_orders_date" class="orders_date"><?= $Page->date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
        <th class="<?= $Page->time->headerCellClass() ?>"><span id="elh_orders_time" class="orders_time"><?= $Page->time->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fees->Visible) { // fees ?>
        <th class="<?= $Page->fees->headerCellClass() ?>"><span id="elh_orders_fees" class="orders_fees"><?= $Page->fees->caption() ?></span></th>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
        <th class="<?= $Page->currency_id->headerCellClass() ?>"><span id="elh_orders_currency_id" class="orders_currency_id"><?= $Page->currency_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_orders_status" class="orders_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->meeting_id->Visible) { // meeting_id ?>
        <th class="<?= $Page->meeting_id->headerCellClass() ?>"><span id="elh_orders_meeting_id" class="orders_meeting_id"><?= $Page->meeting_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->package_id->Visible) { // package_id ?>
        <th class="<?= $Page->package_id->headerCellClass() ?>"><span id="elh_orders_package_id" class="orders_package_id"><?= $Page->package_id->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_orders_id" class="el_orders_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->student_id->Visible) { // student_id ?>
        <td<?= $Page->student_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_student_id" class="el_orders_student_id">
<span<?= $Page->student_id->viewAttributes() ?>>
<?= $Page->student_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->teacher_id->Visible) { // teacher_id ?>
        <td<?= $Page->teacher_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_teacher_id" class="el_orders_teacher_id">
<span<?= $Page->teacher_id->viewAttributes() ?>>
<?= $Page->teacher_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->topic_id->Visible) { // topic_id ?>
        <td<?= $Page->topic_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_topic_id" class="el_orders_topic_id">
<span<?= $Page->topic_id->viewAttributes() ?>>
<?= $Page->topic_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <td<?= $Page->date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_date" class="el_orders_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
        <td<?= $Page->time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_time" class="el_orders_time">
<span<?= $Page->time->viewAttributes() ?>>
<?= $Page->time->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fees->Visible) { // fees ?>
        <td<?= $Page->fees->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_fees" class="el_orders_fees">
<span<?= $Page->fees->viewAttributes() ?>>
<?= $Page->fees->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
        <td<?= $Page->currency_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_currency_id" class="el_orders_currency_id">
<span<?= $Page->currency_id->viewAttributes() ?>>
<?= $Page->currency_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_status" class="el_orders_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->meeting_id->Visible) { // meeting_id ?>
        <td<?= $Page->meeting_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_meeting_id" class="el_orders_meeting_id">
<span<?= $Page->meeting_id->viewAttributes() ?>>
<?= $Page->meeting_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->package_id->Visible) { // package_id ?>
        <td<?= $Page->package_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_package_id" class="el_orders_package_id">
<span<?= $Page->package_id->viewAttributes() ?>>
<?= $Page->package_id->getViewValue() ?></span>
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
