<?php

namespace PHPMaker2023\hih71;

// Set up and run Grid object
$Grid = Container("OrdersGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fordersgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { orders: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fordersgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["student_id", [fields.student_id.visible && fields.student_id.required ? ew.Validators.required(fields.student_id.caption) : null], fields.student_id.isInvalid],
            ["teacher_id", [fields.teacher_id.visible && fields.teacher_id.required ? ew.Validators.required(fields.teacher_id.caption) : null], fields.teacher_id.isInvalid],
            ["topic_id", [fields.topic_id.visible && fields.topic_id.required ? ew.Validators.required(fields.topic_id.caption) : null], fields.topic_id.isInvalid],
            ["date", [fields.date.visible && fields.date.required ? ew.Validators.required(fields.date.caption) : null, ew.Validators.datetime(fields.date.clientFormatPattern)], fields.date.isInvalid],
            ["time", [fields.time.visible && fields.time.required ? ew.Validators.required(fields.time.caption) : null], fields.time.isInvalid],
            ["fees", [fields.fees.visible && fields.fees.required ? ew.Validators.required(fields.fees.caption) : null, ew.Validators.float], fields.fees.isInvalid],
            ["currency_id", [fields.currency_id.visible && fields.currency_id.required ? ew.Validators.required(fields.currency_id.caption) : null], fields.currency_id.isInvalid],
            ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
            ["meeting_id", [fields.meeting_id.visible && fields.meeting_id.required ? ew.Validators.required(fields.meeting_id.caption) : null], fields.meeting_id.isInvalid],
            ["package_id", [fields.package_id.visible && fields.package_id.required ? ew.Validators.required(fields.package_id.caption) : null, ew.Validators.integer], fields.package_id.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["student_id",false],["teacher_id",false],["topic_id",false],["date",false],["time",false],["fees",false],["currency_id",false],["status",false],["meeting_id",false],["package_id",false]];
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
            "student_id": <?= $Grid->student_id->toClientList($Grid) ?>,
            "teacher_id": <?= $Grid->teacher_id->toClientList($Grid) ?>,
            "topic_id": <?= $Grid->topic_id->toClientList($Grid) ?>,
            "currency_id": <?= $Grid->currency_id->toClientList($Grid) ?>,
            "status": <?= $Grid->status->toClientList($Grid) ?>,
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
<div id="fordersgrid" class="ew-form ew-list-form">
<div id="gmp_orders" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_ordersgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_orders_id" class="orders_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->student_id->Visible) { // student_id ?>
        <th data-name="student_id" class="<?= $Grid->student_id->headerCellClass() ?>"><div id="elh_orders_student_id" class="orders_student_id"><?= $Grid->renderFieldHeader($Grid->student_id) ?></div></th>
<?php } ?>
<?php if ($Grid->teacher_id->Visible) { // teacher_id ?>
        <th data-name="teacher_id" class="<?= $Grid->teacher_id->headerCellClass() ?>"><div id="elh_orders_teacher_id" class="orders_teacher_id"><?= $Grid->renderFieldHeader($Grid->teacher_id) ?></div></th>
<?php } ?>
<?php if ($Grid->topic_id->Visible) { // topic_id ?>
        <th data-name="topic_id" class="<?= $Grid->topic_id->headerCellClass() ?>"><div id="elh_orders_topic_id" class="orders_topic_id"><?= $Grid->renderFieldHeader($Grid->topic_id) ?></div></th>
<?php } ?>
<?php if ($Grid->date->Visible) { // date ?>
        <th data-name="date" class="<?= $Grid->date->headerCellClass() ?>"><div id="elh_orders_date" class="orders_date"><?= $Grid->renderFieldHeader($Grid->date) ?></div></th>
<?php } ?>
<?php if ($Grid->time->Visible) { // time ?>
        <th data-name="time" class="<?= $Grid->time->headerCellClass() ?>"><div id="elh_orders_time" class="orders_time"><?= $Grid->renderFieldHeader($Grid->time) ?></div></th>
<?php } ?>
<?php if ($Grid->fees->Visible) { // fees ?>
        <th data-name="fees" class="<?= $Grid->fees->headerCellClass() ?>"><div id="elh_orders_fees" class="orders_fees"><?= $Grid->renderFieldHeader($Grid->fees) ?></div></th>
<?php } ?>
<?php if ($Grid->currency_id->Visible) { // currency_id ?>
        <th data-name="currency_id" class="<?= $Grid->currency_id->headerCellClass() ?>"><div id="elh_orders_currency_id" class="orders_currency_id"><?= $Grid->renderFieldHeader($Grid->currency_id) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_orders_status" class="orders_status"><?= $Grid->renderFieldHeader($Grid->status) ?></div></th>
<?php } ?>
<?php if ($Grid->meeting_id->Visible) { // meeting_id ?>
        <th data-name="meeting_id" class="<?= $Grid->meeting_id->headerCellClass() ?>"><div id="elh_orders_meeting_id" class="orders_meeting_id"><?= $Grid->renderFieldHeader($Grid->meeting_id) ?></div></th>
<?php } ?>
<?php if ($Grid->package_id->Visible) { // package_id ?>
        <th data-name="package_id" class="<?= $Grid->package_id->headerCellClass() ?>"><div id="elh_orders_package_id" class="orders_package_id"><?= $Grid->renderFieldHeader($Grid->package_id) ?></div></th>
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
<span id="el<?= $Grid->RowCount ?>_orders_id" class="el_orders_id"></span>
<input type="hidden" data-table="orders" data-field="x_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_id" class="el_orders_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="orders" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_id" class="el_orders_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_id" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_id" id="fordersgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_id" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_id" id="fordersgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="orders" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->student_id->Visible) { // student_id ?>
        <td data-name="student_id"<?= $Grid->student_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_orders_student_id" class="el_orders_student_id">
    <select
        id="x<?= $Grid->RowIndex ?>_student_id"
        name="x<?= $Grid->RowIndex ?>_student_id"
        class="form-select ew-select<?= $Grid->student_id->isInvalidClass() ?>"
        <?php if (!$Grid->student_id->IsNativeSelect) { ?>
        data-select2-id="fordersgrid_x<?= $Grid->RowIndex ?>_student_id"
        <?php } ?>
        data-table="orders"
        data-field="x_student_id"
        data-value-separator="<?= $Grid->student_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->student_id->getPlaceHolder()) ?>"
        <?= $Grid->student_id->editAttributes() ?>>
        <?= $Grid->student_id->selectOptionListHtml("x{$Grid->RowIndex}_student_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->student_id->getErrorMessage() ?></div>
<?= $Grid->student_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_student_id") ?>
<?php if (!$Grid->student_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_student_id", selectId: "fordersgrid_x<?= $Grid->RowIndex ?>_student_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersgrid.lists.student_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_student_id", form: "fordersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_student_id", form: "fordersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.student_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_student_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_student_id" id="o<?= $Grid->RowIndex ?>_student_id" value="<?= HtmlEncode($Grid->student_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_student_id" class="el_orders_student_id">
    <select
        id="x<?= $Grid->RowIndex ?>_student_id"
        name="x<?= $Grid->RowIndex ?>_student_id"
        class="form-select ew-select<?= $Grid->student_id->isInvalidClass() ?>"
        <?php if (!$Grid->student_id->IsNativeSelect) { ?>
        data-select2-id="fordersgrid_x<?= $Grid->RowIndex ?>_student_id"
        <?php } ?>
        data-table="orders"
        data-field="x_student_id"
        data-value-separator="<?= $Grid->student_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->student_id->getPlaceHolder()) ?>"
        <?= $Grid->student_id->editAttributes() ?>>
        <?= $Grid->student_id->selectOptionListHtml("x{$Grid->RowIndex}_student_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->student_id->getErrorMessage() ?></div>
<?= $Grid->student_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_student_id") ?>
<?php if (!$Grid->student_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_student_id", selectId: "fordersgrid_x<?= $Grid->RowIndex ?>_student_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersgrid.lists.student_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_student_id", form: "fordersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_student_id", form: "fordersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.student_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_student_id" class="el_orders_student_id">
<span<?= $Grid->student_id->viewAttributes() ?>>
<?= $Grid->student_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_student_id" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_student_id" id="fordersgrid$x<?= $Grid->RowIndex ?>_student_id" value="<?= HtmlEncode($Grid->student_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_student_id" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_student_id" id="fordersgrid$o<?= $Grid->RowIndex ?>_student_id" value="<?= HtmlEncode($Grid->student_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->teacher_id->Visible) { // teacher_id ?>
        <td data-name="teacher_id"<?= $Grid->teacher_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_orders_teacher_id" class="el_orders_teacher_id">
    <select
        id="x<?= $Grid->RowIndex ?>_teacher_id"
        name="x<?= $Grid->RowIndex ?>_teacher_id"
        class="form-select ew-select<?= $Grid->teacher_id->isInvalidClass() ?>"
        <?php if (!$Grid->teacher_id->IsNativeSelect) { ?>
        data-select2-id="fordersgrid_x<?= $Grid->RowIndex ?>_teacher_id"
        <?php } ?>
        data-table="orders"
        data-field="x_teacher_id"
        data-value-separator="<?= $Grid->teacher_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->teacher_id->getPlaceHolder()) ?>"
        <?= $Grid->teacher_id->editAttributes() ?>>
        <?= $Grid->teacher_id->selectOptionListHtml("x{$Grid->RowIndex}_teacher_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->teacher_id->getErrorMessage() ?></div>
<?= $Grid->teacher_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_teacher_id") ?>
<?php if (!$Grid->teacher_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_teacher_id", selectId: "fordersgrid_x<?= $Grid->RowIndex ?>_teacher_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersgrid.lists.teacher_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_teacher_id", form: "fordersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_teacher_id", form: "fordersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.teacher_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_teacher_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_teacher_id" id="o<?= $Grid->RowIndex ?>_teacher_id" value="<?= HtmlEncode($Grid->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_teacher_id" class="el_orders_teacher_id">
    <select
        id="x<?= $Grid->RowIndex ?>_teacher_id"
        name="x<?= $Grid->RowIndex ?>_teacher_id"
        class="form-select ew-select<?= $Grid->teacher_id->isInvalidClass() ?>"
        <?php if (!$Grid->teacher_id->IsNativeSelect) { ?>
        data-select2-id="fordersgrid_x<?= $Grid->RowIndex ?>_teacher_id"
        <?php } ?>
        data-table="orders"
        data-field="x_teacher_id"
        data-value-separator="<?= $Grid->teacher_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->teacher_id->getPlaceHolder()) ?>"
        <?= $Grid->teacher_id->editAttributes() ?>>
        <?= $Grid->teacher_id->selectOptionListHtml("x{$Grid->RowIndex}_teacher_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->teacher_id->getErrorMessage() ?></div>
<?= $Grid->teacher_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_teacher_id") ?>
<?php if (!$Grid->teacher_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_teacher_id", selectId: "fordersgrid_x<?= $Grid->RowIndex ?>_teacher_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersgrid.lists.teacher_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_teacher_id", form: "fordersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_teacher_id", form: "fordersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.teacher_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_teacher_id" class="el_orders_teacher_id">
<span<?= $Grid->teacher_id->viewAttributes() ?>>
<?= $Grid->teacher_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_teacher_id" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_teacher_id" id="fordersgrid$x<?= $Grid->RowIndex ?>_teacher_id" value="<?= HtmlEncode($Grid->teacher_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_teacher_id" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_teacher_id" id="fordersgrid$o<?= $Grid->RowIndex ?>_teacher_id" value="<?= HtmlEncode($Grid->teacher_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->topic_id->Visible) { // topic_id ?>
        <td data-name="topic_id"<?= $Grid->topic_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_orders_topic_id" class="el_orders_topic_id">
    <select
        id="x<?= $Grid->RowIndex ?>_topic_id"
        name="x<?= $Grid->RowIndex ?>_topic_id"
        class="form-select ew-select<?= $Grid->topic_id->isInvalidClass() ?>"
        <?php if (!$Grid->topic_id->IsNativeSelect) { ?>
        data-select2-id="fordersgrid_x<?= $Grid->RowIndex ?>_topic_id"
        <?php } ?>
        data-table="orders"
        data-field="x_topic_id"
        data-value-separator="<?= $Grid->topic_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->topic_id->getPlaceHolder()) ?>"
        <?= $Grid->topic_id->editAttributes() ?>>
        <?= $Grid->topic_id->selectOptionListHtml("x{$Grid->RowIndex}_topic_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->topic_id->getErrorMessage() ?></div>
<?= $Grid->topic_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_topic_id") ?>
<?php if (!$Grid->topic_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_topic_id", selectId: "fordersgrid_x<?= $Grid->RowIndex ?>_topic_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersgrid.lists.topic_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_topic_id", form: "fordersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_topic_id", form: "fordersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.topic_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_topic_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_topic_id" id="o<?= $Grid->RowIndex ?>_topic_id" value="<?= HtmlEncode($Grid->topic_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_topic_id" class="el_orders_topic_id">
    <select
        id="x<?= $Grid->RowIndex ?>_topic_id"
        name="x<?= $Grid->RowIndex ?>_topic_id"
        class="form-select ew-select<?= $Grid->topic_id->isInvalidClass() ?>"
        <?php if (!$Grid->topic_id->IsNativeSelect) { ?>
        data-select2-id="fordersgrid_x<?= $Grid->RowIndex ?>_topic_id"
        <?php } ?>
        data-table="orders"
        data-field="x_topic_id"
        data-value-separator="<?= $Grid->topic_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->topic_id->getPlaceHolder()) ?>"
        <?= $Grid->topic_id->editAttributes() ?>>
        <?= $Grid->topic_id->selectOptionListHtml("x{$Grid->RowIndex}_topic_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->topic_id->getErrorMessage() ?></div>
<?= $Grid->topic_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_topic_id") ?>
<?php if (!$Grid->topic_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_topic_id", selectId: "fordersgrid_x<?= $Grid->RowIndex ?>_topic_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersgrid.lists.topic_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_topic_id", form: "fordersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_topic_id", form: "fordersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.topic_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_topic_id" class="el_orders_topic_id">
<span<?= $Grid->topic_id->viewAttributes() ?>>
<?= $Grid->topic_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_topic_id" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_topic_id" id="fordersgrid$x<?= $Grid->RowIndex ?>_topic_id" value="<?= HtmlEncode($Grid->topic_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_topic_id" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_topic_id" id="fordersgrid$o<?= $Grid->RowIndex ?>_topic_id" value="<?= HtmlEncode($Grid->topic_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->date->Visible) { // date ?>
        <td data-name="date"<?= $Grid->date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_orders_date" class="el_orders_date">
<input type="<?= $Grid->date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date" id="x<?= $Grid->RowIndex ?>_date" data-table="orders" data-field="x_date" value="<?= $Grid->date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->date->formatPattern()) ?>"<?= $Grid->date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date->getErrorMessage() ?></div>
<?php if (!$Grid->date->ReadOnly && !$Grid->date->Disabled && !isset($Grid->date->EditAttrs["readonly"]) && !isset($Grid->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fordersgrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i),
                    useTwentyfourHour: !!format.match(/H/)
                },
                theme: ew.isDark() ? "dark" : "auto"
            }
        };
    ew.createDateTimePicker("fordersgrid", "x<?= $Grid->RowIndex ?>_date", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_date" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_date" id="o<?= $Grid->RowIndex ?>_date" value="<?= HtmlEncode($Grid->date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_date" class="el_orders_date">
<input type="<?= $Grid->date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date" id="x<?= $Grid->RowIndex ?>_date" data-table="orders" data-field="x_date" value="<?= $Grid->date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->date->formatPattern()) ?>"<?= $Grid->date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date->getErrorMessage() ?></div>
<?php if (!$Grid->date->ReadOnly && !$Grid->date->Disabled && !isset($Grid->date->EditAttrs["readonly"]) && !isset($Grid->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fordersgrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i),
                    useTwentyfourHour: !!format.match(/H/)
                },
                theme: ew.isDark() ? "dark" : "auto"
            }
        };
    ew.createDateTimePicker("fordersgrid", "x<?= $Grid->RowIndex ?>_date", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_date" class="el_orders_date">
<span<?= $Grid->date->viewAttributes() ?>>
<?= $Grid->date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_date" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_date" id="fordersgrid$x<?= $Grid->RowIndex ?>_date" value="<?= HtmlEncode($Grid->date->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_date" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_date" id="fordersgrid$o<?= $Grid->RowIndex ?>_date" value="<?= HtmlEncode($Grid->date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->time->Visible) { // time ?>
        <td data-name="time"<?= $Grid->time->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_orders_time" class="el_orders_time">
<input type="<?= $Grid->time->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_time" id="x<?= $Grid->RowIndex ?>_time" data-table="orders" data-field="x_time" value="<?= $Grid->time->EditValue ?>" placeholder="<?= HtmlEncode($Grid->time->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->time->formatPattern()) ?>"<?= $Grid->time->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->time->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="orders" data-field="x_time" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_time" id="o<?= $Grid->RowIndex ?>_time" value="<?= HtmlEncode($Grid->time->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_time" class="el_orders_time">
<input type="<?= $Grid->time->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_time" id="x<?= $Grid->RowIndex ?>_time" data-table="orders" data-field="x_time" value="<?= $Grid->time->EditValue ?>" placeholder="<?= HtmlEncode($Grid->time->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->time->formatPattern()) ?>"<?= $Grid->time->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->time->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_time" class="el_orders_time">
<span<?= $Grid->time->viewAttributes() ?>>
<?= $Grid->time->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_time" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_time" id="fordersgrid$x<?= $Grid->RowIndex ?>_time" value="<?= HtmlEncode($Grid->time->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_time" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_time" id="fordersgrid$o<?= $Grid->RowIndex ?>_time" value="<?= HtmlEncode($Grid->time->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fees->Visible) { // fees ?>
        <td data-name="fees"<?= $Grid->fees->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_orders_fees" class="el_orders_fees">
<input type="<?= $Grid->fees->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fees" id="x<?= $Grid->RowIndex ?>_fees" data-table="orders" data-field="x_fees" value="<?= $Grid->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fees->formatPattern()) ?>"<?= $Grid->fees->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fees->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="orders" data-field="x_fees" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fees" id="o<?= $Grid->RowIndex ?>_fees" value="<?= HtmlEncode($Grid->fees->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_fees" class="el_orders_fees">
<input type="<?= $Grid->fees->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fees" id="x<?= $Grid->RowIndex ?>_fees" data-table="orders" data-field="x_fees" value="<?= $Grid->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fees->formatPattern()) ?>"<?= $Grid->fees->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fees->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_fees" class="el_orders_fees">
<span<?= $Grid->fees->viewAttributes() ?>>
<?= $Grid->fees->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_fees" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_fees" id="fordersgrid$x<?= $Grid->RowIndex ?>_fees" value="<?= HtmlEncode($Grid->fees->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_fees" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_fees" id="fordersgrid$o<?= $Grid->RowIndex ?>_fees" value="<?= HtmlEncode($Grid->fees->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->currency_id->Visible) { // currency_id ?>
        <td data-name="currency_id"<?= $Grid->currency_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_orders_currency_id" class="el_orders_currency_id">
    <select
        id="x<?= $Grid->RowIndex ?>_currency_id"
        name="x<?= $Grid->RowIndex ?>_currency_id"
        class="form-select ew-select<?= $Grid->currency_id->isInvalidClass() ?>"
        <?php if (!$Grid->currency_id->IsNativeSelect) { ?>
        data-select2-id="fordersgrid_x<?= $Grid->RowIndex ?>_currency_id"
        <?php } ?>
        data-table="orders"
        data-field="x_currency_id"
        data-value-separator="<?= $Grid->currency_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->currency_id->getPlaceHolder()) ?>"
        <?= $Grid->currency_id->editAttributes() ?>>
        <?= $Grid->currency_id->selectOptionListHtml("x{$Grid->RowIndex}_currency_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->currency_id->getErrorMessage() ?></div>
<?= $Grid->currency_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_currency_id") ?>
<?php if (!$Grid->currency_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_currency_id", selectId: "fordersgrid_x<?= $Grid->RowIndex ?>_currency_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersgrid.lists.currency_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_currency_id", form: "fordersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_currency_id", form: "fordersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.currency_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_currency_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_currency_id" id="o<?= $Grid->RowIndex ?>_currency_id" value="<?= HtmlEncode($Grid->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_currency_id" class="el_orders_currency_id">
    <select
        id="x<?= $Grid->RowIndex ?>_currency_id"
        name="x<?= $Grid->RowIndex ?>_currency_id"
        class="form-select ew-select<?= $Grid->currency_id->isInvalidClass() ?>"
        <?php if (!$Grid->currency_id->IsNativeSelect) { ?>
        data-select2-id="fordersgrid_x<?= $Grid->RowIndex ?>_currency_id"
        <?php } ?>
        data-table="orders"
        data-field="x_currency_id"
        data-value-separator="<?= $Grid->currency_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->currency_id->getPlaceHolder()) ?>"
        <?= $Grid->currency_id->editAttributes() ?>>
        <?= $Grid->currency_id->selectOptionListHtml("x{$Grid->RowIndex}_currency_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->currency_id->getErrorMessage() ?></div>
<?= $Grid->currency_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_currency_id") ?>
<?php if (!$Grid->currency_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_currency_id", selectId: "fordersgrid_x<?= $Grid->RowIndex ?>_currency_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersgrid.lists.currency_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_currency_id", form: "fordersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_currency_id", form: "fordersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.currency_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_currency_id" class="el_orders_currency_id">
<span<?= $Grid->currency_id->viewAttributes() ?>>
<?= $Grid->currency_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_currency_id" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_currency_id" id="fordersgrid$x<?= $Grid->RowIndex ?>_currency_id" value="<?= HtmlEncode($Grid->currency_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_currency_id" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_currency_id" id="fordersgrid$o<?= $Grid->RowIndex ?>_currency_id" value="<?= HtmlEncode($Grid->currency_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status"<?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_orders_status" class="el_orders_status">
    <select
        id="x<?= $Grid->RowIndex ?>_status"
        name="x<?= $Grid->RowIndex ?>_status"
        class="form-select ew-select<?= $Grid->status->isInvalidClass() ?>"
        <?php if (!$Grid->status->IsNativeSelect) { ?>
        data-select2-id="fordersgrid_x<?= $Grid->RowIndex ?>_status"
        <?php } ?>
        data-table="orders"
        data-field="x_status"
        data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>"
        <?= $Grid->status->editAttributes() ?>>
        <?= $Grid->status->selectOptionListHtml("x{$Grid->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
<?php if (!$Grid->status->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status", selectId: "fordersgrid_x<?= $Grid->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersgrid.lists.status?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status", form: "fordersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status", form: "fordersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_status" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_status" class="el_orders_status">
    <select
        id="x<?= $Grid->RowIndex ?>_status"
        name="x<?= $Grid->RowIndex ?>_status"
        class="form-select ew-select<?= $Grid->status->isInvalidClass() ?>"
        <?php if (!$Grid->status->IsNativeSelect) { ?>
        data-select2-id="fordersgrid_x<?= $Grid->RowIndex ?>_status"
        <?php } ?>
        data-table="orders"
        data-field="x_status"
        data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>"
        <?= $Grid->status->editAttributes() ?>>
        <?= $Grid->status->selectOptionListHtml("x{$Grid->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
<?php if (!$Grid->status->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status", selectId: "fordersgrid_x<?= $Grid->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersgrid.lists.status?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status", form: "fordersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status", form: "fordersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_status" class="el_orders_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_status" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_status" id="fordersgrid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_status" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_status" id="fordersgrid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->meeting_id->Visible) { // meeting_id ?>
        <td data-name="meeting_id"<?= $Grid->meeting_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_orders_meeting_id" class="el_orders_meeting_id">
<input type="<?= $Grid->meeting_id->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_meeting_id" id="x<?= $Grid->RowIndex ?>_meeting_id" data-table="orders" data-field="x_meeting_id" value="<?= $Grid->meeting_id->EditValue ?>" placeholder="<?= HtmlEncode($Grid->meeting_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->meeting_id->formatPattern()) ?>"<?= $Grid->meeting_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->meeting_id->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="orders" data-field="x_meeting_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_meeting_id" id="o<?= $Grid->RowIndex ?>_meeting_id" value="<?= HtmlEncode($Grid->meeting_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_meeting_id" class="el_orders_meeting_id">
<input type="<?= $Grid->meeting_id->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_meeting_id" id="x<?= $Grid->RowIndex ?>_meeting_id" data-table="orders" data-field="x_meeting_id" value="<?= $Grid->meeting_id->EditValue ?>" placeholder="<?= HtmlEncode($Grid->meeting_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->meeting_id->formatPattern()) ?>"<?= $Grid->meeting_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->meeting_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_meeting_id" class="el_orders_meeting_id">
<span<?= $Grid->meeting_id->viewAttributes() ?>>
<?= $Grid->meeting_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_meeting_id" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_meeting_id" id="fordersgrid$x<?= $Grid->RowIndex ?>_meeting_id" value="<?= HtmlEncode($Grid->meeting_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_meeting_id" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_meeting_id" id="fordersgrid$o<?= $Grid->RowIndex ?>_meeting_id" value="<?= HtmlEncode($Grid->meeting_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->package_id->Visible) { // package_id ?>
        <td data-name="package_id"<?= $Grid->package_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_orders_package_id" class="el_orders_package_id">
<input type="<?= $Grid->package_id->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_package_id" id="x<?= $Grid->RowIndex ?>_package_id" data-table="orders" data-field="x_package_id" value="<?= $Grid->package_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->package_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->package_id->formatPattern()) ?>"<?= $Grid->package_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->package_id->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="orders" data-field="x_package_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_package_id" id="o<?= $Grid->RowIndex ?>_package_id" value="<?= HtmlEncode($Grid->package_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_orders_package_id" class="el_orders_package_id">
<input type="<?= $Grid->package_id->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_package_id" id="x<?= $Grid->RowIndex ?>_package_id" data-table="orders" data-field="x_package_id" value="<?= $Grid->package_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->package_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->package_id->formatPattern()) ?>"<?= $Grid->package_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->package_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_orders_package_id" class="el_orders_package_id">
<span<?= $Grid->package_id->viewAttributes() ?>>
<?= $Grid->package_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="orders" data-field="x_package_id" data-hidden="1" name="fordersgrid$x<?= $Grid->RowIndex ?>_package_id" id="fordersgrid$x<?= $Grid->RowIndex ?>_package_id" value="<?= HtmlEncode($Grid->package_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_package_id" data-hidden="1" data-old name="fordersgrid$o<?= $Grid->RowIndex ?>_package_id" id="fordersgrid$o<?= $Grid->RowIndex ?>_package_id" value="<?= HtmlEncode($Grid->package_id->OldValue) ?>">
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
loadjs.ready(["fordersgrid","load"], () => fordersgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fordersgrid">
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
    ew.addEventHandlers("orders");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
