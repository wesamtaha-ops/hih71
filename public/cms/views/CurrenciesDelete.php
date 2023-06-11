<?php

namespace PHPMaker2023\hih71;

// Page object
$CurrenciesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { currencies: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcurrenciesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcurrenciesdelete")
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
<form name="fcurrenciesdelete" id="fcurrenciesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="currencies">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_currencies_id" class="currencies_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name_ar->Visible) { // name_ar ?>
        <th class="<?= $Page->name_ar->headerCellClass() ?>"><span id="elh_currencies_name_ar" class="currencies_name_ar"><?= $Page->name_ar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name_en->Visible) { // name_en ?>
        <th class="<?= $Page->name_en->headerCellClass() ?>"><span id="elh_currencies_name_en" class="currencies_name_en"><?= $Page->name_en->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rate->Visible) { // rate ?>
        <th class="<?= $Page->rate->headerCellClass() ?>"><span id="elh_currencies_rate" class="currencies_rate"><?= $Page->rate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->symbol->Visible) { // symbol ?>
        <th class="<?= $Page->symbol->headerCellClass() ?>"><span id="elh_currencies_symbol" class="currencies_symbol"><?= $Page->symbol->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_currencies_id" class="el_currencies_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name_ar->Visible) { // name_ar ?>
        <td<?= $Page->name_ar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_currencies_name_ar" class="el_currencies_name_ar">
<span<?= $Page->name_ar->viewAttributes() ?>>
<?= $Page->name_ar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name_en->Visible) { // name_en ?>
        <td<?= $Page->name_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_currencies_name_en" class="el_currencies_name_en">
<span<?= $Page->name_en->viewAttributes() ?>>
<?= $Page->name_en->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rate->Visible) { // rate ?>
        <td<?= $Page->rate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_currencies_rate" class="el_currencies_rate">
<span<?= $Page->rate->viewAttributes() ?>>
<?= $Page->rate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->symbol->Visible) { // symbol ?>
        <td<?= $Page->symbol->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_currencies_symbol" class="el_currencies_symbol">
<span<?= $Page->symbol->viewAttributes() ?>>
<?= $Page->symbol->getViewValue() ?></span>
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
