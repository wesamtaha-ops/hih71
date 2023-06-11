<?php

namespace PHPMaker2023\hih71;

// Set up and run Grid object
$Grid = Container("TransfersGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ftransfersgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { transfers: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftransfersgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid],
            ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null, ew.Validators.integer], fields.amount.isInvalid],
            ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null], fields.type.isInvalid],
            ["order_id", [fields.order_id.visible && fields.order_id.required ? ew.Validators.required(fields.order_id.caption) : null], fields.order_id.isInvalid],
            ["approved", [fields.approved.visible && fields.approved.required ? ew.Validators.required(fields.approved.caption) : null], fields.approved.isInvalid],
            ["verification_code", [fields.verification_code.visible && fields.verification_code.required ? ew.Validators.required(fields.verification_code.caption) : null], fields.verification_code.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["user_id",false],["amount",false],["type",false],["order_id",false],["approved",true],["verification_code",false]];
                if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
                    return false;
                return true;
            }
        )

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "user_id": <?= $Grid->user_id->toClientList($Grid) ?>,
            "type": <?= $Grid->type->toClientList($Grid) ?>,
            "order_id": <?= $Grid->order_id->toClientList($Grid) ?>,
            "approved": <?= $Grid->approved->toClientList($Grid) ?>,
        })
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<main class="list<?= ($Grid->TotalRecords == 0 && !$Grid->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-list">
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Grid->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Grid->TableGridClass ?>">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="ftransfersgrid" class="ew-form ew-list-form">
<div id="gmp_transfers" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_transfersgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_transfers_id" class="transfers_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->user_id->Visible) { // user_id ?>
        <th data-name="user_id" class="<?= $Grid->user_id->headerCellClass() ?>"><div id="elh_transfers_user_id" class="transfers_user_id"><?= $Grid->renderFieldHeader($Grid->user_id) ?></div></th>
<?php } ?>
<?php if ($Grid->amount->Visible) { // amount ?>
        <th data-name="amount" class="<?= $Grid->amount->headerCellClass() ?>"><div id="elh_transfers_amount" class="transfers_amount"><?= $Grid->renderFieldHeader($Grid->amount) ?></div></th>
<?php } ?>
<?php if ($Grid->type->Visible) { // type ?>
        <th data-name="type" class="<?= $Grid->type->headerCellClass() ?>"><div id="elh_transfers_type" class="transfers_type"><?= $Grid->renderFieldHeader($Grid->type) ?></div></th>
<?php } ?>
<?php if ($Grid->order_id->Visible) { // order_id ?>
        <th data-name="order_id" class="<?= $Grid->order_id->headerCellClass() ?>"><div id="elh_transfers_order_id" class="transfers_order_id"><?= $Grid->renderFieldHeader($Grid->order_id) ?></div></th>
<?php } ?>
<?php if ($Grid->approved->Visible) { // approved ?>
        <th data-name="approved" class="<?= $Grid->approved->headerCellClass() ?>"><div id="elh_transfers_approved" class="transfers_approved"><?= $Grid->renderFieldHeader($Grid->approved) ?></div></th>
<?php } ?>
<?php if ($Grid->verification_code->Visible) { // verification_code ?>
        <th data-name="verification_code" class="<?= $Grid->verification_code->headerCellClass() ?>"><div id="elh_transfers_verification_code" class="transfers_verification_code"><?= $Grid->renderFieldHeader($Grid->verification_code) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Grid->getPageNumber() ?>">
<?php
$Grid->setupGrid();
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Grid->RowAction != "delete" &&
            $Grid->RowAction != "insertdelete" &&
            !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow()) &&
            $Grid->RowAction != "hide"
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id"<?= $Grid->id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_id" class="el_transfers_id"></span>
<input type="hidden" data-table="transfers" data-field="x_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_id" class="el_transfers_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="transfers" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_id" class="el_transfers_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="transfers" data-field="x_id" data-hidden="1" name="ftransfersgrid$x<?= $Grid->RowIndex ?>_id" id="ftransfersgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_id" data-hidden="1" data-old name="ftransfersgrid$o<?= $Grid->RowIndex ?>_id" id="ftransfersgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="transfers" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->user_id->Visible) { // user_id ?>
        <td data-name="user_id"<?= $Grid->user_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->user_id->getSessionValue() != "") { ?>
<span<?= $Grid->user_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->user_id->getDisplayValue($Grid->user_id->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_user_id" name="x<?= $Grid->RowIndex ?>_user_id" value="<?= HtmlEncode($Grid->user_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_transfers_user_id" class="el_transfers_user_id">
    <select
        id="x<?= $Grid->RowIndex ?>_user_id"
        name="x<?= $Grid->RowIndex ?>_user_id"
        class="form-select ew-select<?= $Grid->user_id->isInvalidClass() ?>"
        <?php if (!$Grid->user_id->IsNativeSelect) { ?>
        data-select2-id="ftransfersgrid_x<?= $Grid->RowIndex ?>_user_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_user_id"
        data-value-separator="<?= $Grid->user_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->user_id->getPlaceHolder()) ?>"
        <?= $Grid->user_id->editAttributes() ?>>
        <?= $Grid->user_id->selectOptionListHtml("x{$Grid->RowIndex}_user_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->user_id->getErrorMessage() ?></div>
<?= $Grid->user_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_user_id") ?>
<?php if (!$Grid->user_id->IsNativeSelect) { ?>
<script>
loadjs.ready("ftransfersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_user_id", selectId: "ftransfersgrid_x<?= $Grid->RowIndex ?>_user_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftransfersgrid.lists.user_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_user_id", form: "ftransfersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_user_id", form: "ftransfersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.user_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_user_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_user_id" id="o<?= $Grid->RowIndex ?>_user_id" value="<?= HtmlEncode($Grid->user_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->user_id->getSessionValue() != "") { ?>
<span<?= $Grid->user_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->user_id->getDisplayValue($Grid->user_id->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_user_id" name="x<?= $Grid->RowIndex ?>_user_id" value="<?= HtmlEncode($Grid->user_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_transfers_user_id" class="el_transfers_user_id">
    <select
        id="x<?= $Grid->RowIndex ?>_user_id"
        name="x<?= $Grid->RowIndex ?>_user_id"
        class="form-select ew-select<?= $Grid->user_id->isInvalidClass() ?>"
        <?php if (!$Grid->user_id->IsNativeSelect) { ?>
        data-select2-id="ftransfersgrid_x<?= $Grid->RowIndex ?>_user_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_user_id"
        data-value-separator="<?= $Grid->user_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->user_id->getPlaceHolder()) ?>"
        <?= $Grid->user_id->editAttributes() ?>>
        <?= $Grid->user_id->selectOptionListHtml("x{$Grid->RowIndex}_user_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->user_id->getErrorMessage() ?></div>
<?= $Grid->user_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_user_id") ?>
<?php if (!$Grid->user_id->IsNativeSelect) { ?>
<script>
loadjs.ready("ftransfersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_user_id", selectId: "ftransfersgrid_x<?= $Grid->RowIndex ?>_user_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftransfersgrid.lists.user_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_user_id", form: "ftransfersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_user_id", form: "ftransfersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.user_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_user_id" class="el_transfers_user_id">
<span<?= $Grid->user_id->viewAttributes() ?>>
<?= $Grid->user_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="transfers" data-field="x_user_id" data-hidden="1" name="ftransfersgrid$x<?= $Grid->RowIndex ?>_user_id" id="ftransfersgrid$x<?= $Grid->RowIndex ?>_user_id" value="<?= HtmlEncode($Grid->user_id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_user_id" data-hidden="1" data-old name="ftransfersgrid$o<?= $Grid->RowIndex ?>_user_id" id="ftransfersgrid$o<?= $Grid->RowIndex ?>_user_id" value="<?= HtmlEncode($Grid->user_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->amount->Visible) { // amount ?>
        <td data-name="amount"<?= $Grid->amount->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_amount" class="el_transfers_amount">
<input type="<?= $Grid->amount->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_amount" id="x<?= $Grid->RowIndex ?>_amount" data-table="transfers" data-field="x_amount" value="<?= $Grid->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->amount->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->amount->formatPattern()) ?>"<?= $Grid->amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="transfers" data-field="x_amount" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_amount" id="o<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_amount" class="el_transfers_amount">
<input type="<?= $Grid->amount->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_amount" id="x<?= $Grid->RowIndex ?>_amount" data-table="transfers" data-field="x_amount" value="<?= $Grid->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->amount->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->amount->formatPattern()) ?>"<?= $Grid->amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_amount" class="el_transfers_amount">
<span<?= $Grid->amount->viewAttributes() ?>>
<?= $Grid->amount->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="transfers" data-field="x_amount" data-hidden="1" name="ftransfersgrid$x<?= $Grid->RowIndex ?>_amount" id="ftransfersgrid$x<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_amount" data-hidden="1" data-old name="ftransfersgrid$o<?= $Grid->RowIndex ?>_amount" id="ftransfersgrid$o<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->type->Visible) { // type ?>
        <td data-name="type"<?= $Grid->type->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_type" class="el_transfers_type">
<template id="tp_x<?= $Grid->RowIndex ?>_type">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="transfers" data-field="x_type" name="x<?= $Grid->RowIndex ?>_type" id="x<?= $Grid->RowIndex ?>_type"<?= $Grid->type->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_type" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_type"
    name="x<?= $Grid->RowIndex ?>_type"
    value="<?= HtmlEncode($Grid->type->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_type"
    data-target="dsl_x<?= $Grid->RowIndex ?>_type"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->type->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_type"
    data-value-separator="<?= $Grid->type->displayValueSeparatorAttribute() ?>"
    <?= $Grid->type->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->type->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="transfers" data-field="x_type" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_type" id="o<?= $Grid->RowIndex ?>_type" value="<?= HtmlEncode($Grid->type->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_type" class="el_transfers_type">
<template id="tp_x<?= $Grid->RowIndex ?>_type">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="transfers" data-field="x_type" name="x<?= $Grid->RowIndex ?>_type" id="x<?= $Grid->RowIndex ?>_type"<?= $Grid->type->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_type" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_type"
    name="x<?= $Grid->RowIndex ?>_type"
    value="<?= HtmlEncode($Grid->type->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_type"
    data-target="dsl_x<?= $Grid->RowIndex ?>_type"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->type->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_type"
    data-value-separator="<?= $Grid->type->displayValueSeparatorAttribute() ?>"
    <?= $Grid->type->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->type->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_type" class="el_transfers_type">
<span<?= $Grid->type->viewAttributes() ?>>
<?= $Grid->type->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="transfers" data-field="x_type" data-hidden="1" name="ftransfersgrid$x<?= $Grid->RowIndex ?>_type" id="ftransfersgrid$x<?= $Grid->RowIndex ?>_type" value="<?= HtmlEncode($Grid->type->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_type" data-hidden="1" data-old name="ftransfersgrid$o<?= $Grid->RowIndex ?>_type" id="ftransfersgrid$o<?= $Grid->RowIndex ?>_type" value="<?= HtmlEncode($Grid->type->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->order_id->Visible) { // order_id ?>
        <td data-name="order_id"<?= $Grid->order_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_order_id" class="el_transfers_order_id">
    <select
        id="x<?= $Grid->RowIndex ?>_order_id"
        name="x<?= $Grid->RowIndex ?>_order_id"
        class="form-select ew-select<?= $Grid->order_id->isInvalidClass() ?>"
        <?php if (!$Grid->order_id->IsNativeSelect) { ?>
        data-select2-id="ftransfersgrid_x<?= $Grid->RowIndex ?>_order_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_order_id"
        data-value-separator="<?= $Grid->order_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->order_id->getPlaceHolder()) ?>"
        <?= $Grid->order_id->editAttributes() ?>>
        <?= $Grid->order_id->selectOptionListHtml("x{$Grid->RowIndex}_order_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->order_id->getErrorMessage() ?></div>
<?= $Grid->order_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_order_id") ?>
<?php if (!$Grid->order_id->IsNativeSelect) { ?>
<script>
loadjs.ready("ftransfersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_order_id", selectId: "ftransfersgrid_x<?= $Grid->RowIndex ?>_order_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftransfersgrid.lists.order_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_order_id", form: "ftransfersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_order_id", form: "ftransfersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.order_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="transfers" data-field="x_order_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_order_id" id="o<?= $Grid->RowIndex ?>_order_id" value="<?= HtmlEncode($Grid->order_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_order_id" class="el_transfers_order_id">
    <select
        id="x<?= $Grid->RowIndex ?>_order_id"
        name="x<?= $Grid->RowIndex ?>_order_id"
        class="form-select ew-select<?= $Grid->order_id->isInvalidClass() ?>"
        <?php if (!$Grid->order_id->IsNativeSelect) { ?>
        data-select2-id="ftransfersgrid_x<?= $Grid->RowIndex ?>_order_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_order_id"
        data-value-separator="<?= $Grid->order_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->order_id->getPlaceHolder()) ?>"
        <?= $Grid->order_id->editAttributes() ?>>
        <?= $Grid->order_id->selectOptionListHtml("x{$Grid->RowIndex}_order_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->order_id->getErrorMessage() ?></div>
<?= $Grid->order_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_order_id") ?>
<?php if (!$Grid->order_id->IsNativeSelect) { ?>
<script>
loadjs.ready("ftransfersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_order_id", selectId: "ftransfersgrid_x<?= $Grid->RowIndex ?>_order_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftransfersgrid.lists.order_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_order_id", form: "ftransfersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_order_id", form: "ftransfersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.order_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_order_id" class="el_transfers_order_id">
<span<?= $Grid->order_id->viewAttributes() ?>>
<?= $Grid->order_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="transfers" data-field="x_order_id" data-hidden="1" name="ftransfersgrid$x<?= $Grid->RowIndex ?>_order_id" id="ftransfersgrid$x<?= $Grid->RowIndex ?>_order_id" value="<?= HtmlEncode($Grid->order_id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_order_id" data-hidden="1" data-old name="ftransfersgrid$o<?= $Grid->RowIndex ?>_order_id" id="ftransfersgrid$o<?= $Grid->RowIndex ?>_order_id" value="<?= HtmlEncode($Grid->order_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->approved->Visible) { // approved ?>
        <td data-name="approved"<?= $Grid->approved->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_approved" class="el_transfers_approved">
<template id="tp_x<?= $Grid->RowIndex ?>_approved">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="transfers" data-field="x_approved" name="x<?= $Grid->RowIndex ?>_approved" id="x<?= $Grid->RowIndex ?>_approved"<?= $Grid->approved->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_approved" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_approved"
    name="x<?= $Grid->RowIndex ?>_approved"
    value="<?= HtmlEncode($Grid->approved->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_approved"
    data-target="dsl_x<?= $Grid->RowIndex ?>_approved"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->approved->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_approved"
    data-value-separator="<?= $Grid->approved->displayValueSeparatorAttribute() ?>"
    <?= $Grid->approved->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->approved->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="transfers" data-field="x_approved" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_approved" id="o<?= $Grid->RowIndex ?>_approved" value="<?= HtmlEncode($Grid->approved->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_approved" class="el_transfers_approved">
<template id="tp_x<?= $Grid->RowIndex ?>_approved">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="transfers" data-field="x_approved" name="x<?= $Grid->RowIndex ?>_approved" id="x<?= $Grid->RowIndex ?>_approved"<?= $Grid->approved->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_approved" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_approved"
    name="x<?= $Grid->RowIndex ?>_approved"
    value="<?= HtmlEncode($Grid->approved->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_approved"
    data-target="dsl_x<?= $Grid->RowIndex ?>_approved"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->approved->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_approved"
    data-value-separator="<?= $Grid->approved->displayValueSeparatorAttribute() ?>"
    <?= $Grid->approved->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->approved->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_approved" class="el_transfers_approved">
<span<?= $Grid->approved->viewAttributes() ?>>
<?= $Grid->approved->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="transfers" data-field="x_approved" data-hidden="1" name="ftransfersgrid$x<?= $Grid->RowIndex ?>_approved" id="ftransfersgrid$x<?= $Grid->RowIndex ?>_approved" value="<?= HtmlEncode($Grid->approved->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_approved" data-hidden="1" data-old name="ftransfersgrid$o<?= $Grid->RowIndex ?>_approved" id="ftransfersgrid$o<?= $Grid->RowIndex ?>_approved" value="<?= HtmlEncode($Grid->approved->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->verification_code->Visible) { // verification_code ?>
        <td data-name="verification_code"<?= $Grid->verification_code->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_verification_code" class="el_transfers_verification_code">
<input type="<?= $Grid->verification_code->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_verification_code" id="x<?= $Grid->RowIndex ?>_verification_code" data-table="transfers" data-field="x_verification_code" value="<?= $Grid->verification_code->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->verification_code->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->verification_code->formatPattern()) ?>"<?= $Grid->verification_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->verification_code->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="transfers" data-field="x_verification_code" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_verification_code" id="o<?= $Grid->RowIndex ?>_verification_code" value="<?= HtmlEncode($Grid->verification_code->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_verification_code" class="el_transfers_verification_code">
<input type="<?= $Grid->verification_code->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_verification_code" id="x<?= $Grid->RowIndex ?>_verification_code" data-table="transfers" data-field="x_verification_code" value="<?= $Grid->verification_code->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->verification_code->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->verification_code->formatPattern()) ?>"<?= $Grid->verification_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->verification_code->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_transfers_verification_code" class="el_transfers_verification_code">
<span<?= $Grid->verification_code->viewAttributes() ?>>
<?= $Grid->verification_code->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="transfers" data-field="x_verification_code" data-hidden="1" name="ftransfersgrid$x<?= $Grid->RowIndex ?>_verification_code" id="ftransfersgrid$x<?= $Grid->RowIndex ?>_verification_code" value="<?= HtmlEncode($Grid->verification_code->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_verification_code" data-hidden="1" data-old name="ftransfersgrid$o<?= $Grid->RowIndex ?>_verification_code" id="ftransfersgrid$o<?= $Grid->RowIndex ?>_verification_code" value="<?= HtmlEncode($Grid->verification_code->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script data-rowindex="<?= $Grid->RowIndex ?>">
loadjs.ready(["ftransfersgrid","load"], () => ftransfersgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (
        $Grid->Recordset &&
        !$Grid->Recordset->EOF &&
        $Grid->RowIndex !== '$rowindex$' &&
        (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy") &&
        (!(($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0))
    ) {
        $Grid->Recordset->moveNext();
    }
    // Reset for template row
    if ($Grid->RowIndex === '$rowindex$') {
        $Grid->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0) {
        $Grid->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftransfersgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
</main>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("transfers");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
