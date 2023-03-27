<?php

namespace PHPMaker2023\hih71;

// Page object
$OrdersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { orders: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")

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
            "student_id": <?= $Page->student_id->toClientList($Page) ?>,
            "teacher_id": <?= $Page->teacher_id->toClientList($Page) ?>,
            "topic_id": <?= $Page->topic_id->toClientList($Page) ?>,
            "currency_id": <?= $Page->currency_id->toClientList($Page) ?>,
            "status": <?= $Page->status->toClientList($Page) ?>,
        })
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
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="forderssrch" id="forderssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="forderssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { orders: currentTable } });
var currentForm;
var forderssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("forderssrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["id", [], fields.id.isInvalid],
            ["student_id", [], fields.student_id.isInvalid],
            ["teacher_id", [], fields.teacher_id.isInvalid],
            ["topic_id", [], fields.topic_id.isInvalid],
            ["date", [], fields.date.isInvalid],
            ["time", [], fields.time.isInvalid],
            ["fees", [], fields.fees.isInvalid],
            ["currency_id", [], fields.currency_id.isInvalid],
            ["status", [], fields.status.isInvalid],
            ["meeting_id", [], fields.meeting_id.isInvalid],
            ["package_id", [], fields.package_id.isInvalid]
        ])
        // Validate form
        .setValidate(
            async function () {
                if (!this.validateRequired)
                    return true; // Ignore validation
                let fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
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
            "status": <?= $Page->status->toClientList($Page) ?>,
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->status->Visible) { // status ?>
<?php
if (!$Page->status->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_status" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->status->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_status" class="ew-search-caption ew-label"><?= $Page->status->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status" id="z_status" value="=">
</div>
        </div>
        <div id="el_orders_status" class="ew-search-field">
    <select
        id="x_status"
        name="x_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        <?php if (!$Page->status->IsNativeSelect) { ?>
        data-select2-id="forderssrch_x_status"
        <?php } ?>
        data-table="orders"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage(false) ?></div>
<?php if (!$Page->status->IsNativeSelect) { ?>
<script>
loadjs.ready("forderssrch", function() {
    var options = { name: "x_status", selectId: "forderssrch_x_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (forderssrch.lists.status?.lookupOptions.length) {
        options.data = { id: "x_status", form: "forderssrch" };
    } else {
        options.ajax = { id: "x_status", form: "forderssrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="forderssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="forderssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="forderssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="forderssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="orders">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_orders" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_orderslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_orders_id" class="orders_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->student_id->Visible) { // student_id ?>
        <th data-name="student_id" class="<?= $Page->student_id->headerCellClass() ?>"><div id="elh_orders_student_id" class="orders_student_id"><?= $Page->renderFieldHeader($Page->student_id) ?></div></th>
<?php } ?>
<?php if ($Page->teacher_id->Visible) { // teacher_id ?>
        <th data-name="teacher_id" class="<?= $Page->teacher_id->headerCellClass() ?>"><div id="elh_orders_teacher_id" class="orders_teacher_id"><?= $Page->renderFieldHeader($Page->teacher_id) ?></div></th>
<?php } ?>
<?php if ($Page->topic_id->Visible) { // topic_id ?>
        <th data-name="topic_id" class="<?= $Page->topic_id->headerCellClass() ?>"><div id="elh_orders_topic_id" class="orders_topic_id"><?= $Page->renderFieldHeader($Page->topic_id) ?></div></th>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <th data-name="date" class="<?= $Page->date->headerCellClass() ?>"><div id="elh_orders_date" class="orders_date"><?= $Page->renderFieldHeader($Page->date) ?></div></th>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
        <th data-name="time" class="<?= $Page->time->headerCellClass() ?>"><div id="elh_orders_time" class="orders_time"><?= $Page->renderFieldHeader($Page->time) ?></div></th>
<?php } ?>
<?php if ($Page->fees->Visible) { // fees ?>
        <th data-name="fees" class="<?= $Page->fees->headerCellClass() ?>"><div id="elh_orders_fees" class="orders_fees"><?= $Page->renderFieldHeader($Page->fees) ?></div></th>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
        <th data-name="currency_id" class="<?= $Page->currency_id->headerCellClass() ?>"><div id="elh_orders_currency_id" class="orders_currency_id"><?= $Page->renderFieldHeader($Page->currency_id) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_orders_status" class="orders_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->meeting_id->Visible) { // meeting_id ?>
        <th data-name="meeting_id" class="<?= $Page->meeting_id->headerCellClass() ?>"><div id="elh_orders_meeting_id" class="orders_meeting_id"><?= $Page->renderFieldHeader($Page->meeting_id) ?></div></th>
<?php } ?>
<?php if ($Page->package_id->Visible) { // package_id ?>
        <th data-name="package_id" class="<?= $Page->package_id->headerCellClass() ?>"><div id="elh_orders_package_id" class="orders_package_id"><?= $Page->renderFieldHeader($Page->package_id) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow()) &&
            $Page->RowAction != "hide"
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_id" class="el_orders_id"></span>
<input type="hidden" data-table="orders" data-field="x_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_id" class="el_orders_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="orders" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_id" class="el_orders_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="orders" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->student_id->Visible) { // student_id ?>
        <td data-name="student_id"<?= $Page->student_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_student_id" class="el_orders_student_id">
    <select
        id="x<?= $Page->RowIndex ?>_student_id"
        name="x<?= $Page->RowIndex ?>_student_id"
        class="form-select ew-select<?= $Page->student_id->isInvalidClass() ?>"
        <?php if (!$Page->student_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_student_id"
        <?php } ?>
        data-table="orders"
        data-field="x_student_id"
        data-value-separator="<?= $Page->student_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->student_id->getPlaceHolder()) ?>"
        <?= $Page->student_id->editAttributes() ?>>
        <?= $Page->student_id->selectOptionListHtml("x{$Page->RowIndex}_student_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->student_id->getErrorMessage() ?></div>
<?= $Page->student_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_student_id") ?>
<?php if (!$Page->student_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_student_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_student_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.student_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_student_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_student_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.student_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_student_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_student_id" id="o<?= $Page->RowIndex ?>_student_id" value="<?= HtmlEncode($Page->student_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_student_id" class="el_orders_student_id">
    <select
        id="x<?= $Page->RowIndex ?>_student_id"
        name="x<?= $Page->RowIndex ?>_student_id"
        class="form-select ew-select<?= $Page->student_id->isInvalidClass() ?>"
        <?php if (!$Page->student_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_student_id"
        <?php } ?>
        data-table="orders"
        data-field="x_student_id"
        data-value-separator="<?= $Page->student_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->student_id->getPlaceHolder()) ?>"
        <?= $Page->student_id->editAttributes() ?>>
        <?= $Page->student_id->selectOptionListHtml("x{$Page->RowIndex}_student_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->student_id->getErrorMessage() ?></div>
<?= $Page->student_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_student_id") ?>
<?php if (!$Page->student_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_student_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_student_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.student_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_student_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_student_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.student_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_student_id" class="el_orders_student_id">
<span<?= $Page->student_id->viewAttributes() ?>>
<?= $Page->student_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->teacher_id->Visible) { // teacher_id ?>
        <td data-name="teacher_id"<?= $Page->teacher_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_teacher_id" class="el_orders_teacher_id">
    <select
        id="x<?= $Page->RowIndex ?>_teacher_id"
        name="x<?= $Page->RowIndex ?>_teacher_id"
        class="form-select ew-select<?= $Page->teacher_id->isInvalidClass() ?>"
        <?php if (!$Page->teacher_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_teacher_id"
        <?php } ?>
        data-table="orders"
        data-field="x_teacher_id"
        data-value-separator="<?= $Page->teacher_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->teacher_id->getPlaceHolder()) ?>"
        <?= $Page->teacher_id->editAttributes() ?>>
        <?= $Page->teacher_id->selectOptionListHtml("x{$Page->RowIndex}_teacher_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->teacher_id->getErrorMessage() ?></div>
<?= $Page->teacher_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_teacher_id") ?>
<?php if (!$Page->teacher_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_teacher_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_teacher_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.teacher_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_teacher_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_teacher_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.teacher_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_teacher_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_teacher_id" id="o<?= $Page->RowIndex ?>_teacher_id" value="<?= HtmlEncode($Page->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_teacher_id" class="el_orders_teacher_id">
    <select
        id="x<?= $Page->RowIndex ?>_teacher_id"
        name="x<?= $Page->RowIndex ?>_teacher_id"
        class="form-select ew-select<?= $Page->teacher_id->isInvalidClass() ?>"
        <?php if (!$Page->teacher_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_teacher_id"
        <?php } ?>
        data-table="orders"
        data-field="x_teacher_id"
        data-value-separator="<?= $Page->teacher_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->teacher_id->getPlaceHolder()) ?>"
        <?= $Page->teacher_id->editAttributes() ?>>
        <?= $Page->teacher_id->selectOptionListHtml("x{$Page->RowIndex}_teacher_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->teacher_id->getErrorMessage() ?></div>
<?= $Page->teacher_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_teacher_id") ?>
<?php if (!$Page->teacher_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_teacher_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_teacher_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.teacher_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_teacher_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_teacher_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.teacher_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_teacher_id" class="el_orders_teacher_id">
<span<?= $Page->teacher_id->viewAttributes() ?>>
<?= $Page->teacher_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->topic_id->Visible) { // topic_id ?>
        <td data-name="topic_id"<?= $Page->topic_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_topic_id" class="el_orders_topic_id">
    <select
        id="x<?= $Page->RowIndex ?>_topic_id"
        name="x<?= $Page->RowIndex ?>_topic_id"
        class="form-select ew-select<?= $Page->topic_id->isInvalidClass() ?>"
        <?php if (!$Page->topic_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_topic_id"
        <?php } ?>
        data-table="orders"
        data-field="x_topic_id"
        data-value-separator="<?= $Page->topic_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->topic_id->getPlaceHolder()) ?>"
        <?= $Page->topic_id->editAttributes() ?>>
        <?= $Page->topic_id->selectOptionListHtml("x{$Page->RowIndex}_topic_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->topic_id->getErrorMessage() ?></div>
<?= $Page->topic_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_topic_id") ?>
<?php if (!$Page->topic_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_topic_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_topic_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.topic_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_topic_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_topic_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.topic_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_topic_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_topic_id" id="o<?= $Page->RowIndex ?>_topic_id" value="<?= HtmlEncode($Page->topic_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_topic_id" class="el_orders_topic_id">
    <select
        id="x<?= $Page->RowIndex ?>_topic_id"
        name="x<?= $Page->RowIndex ?>_topic_id"
        class="form-select ew-select<?= $Page->topic_id->isInvalidClass() ?>"
        <?php if (!$Page->topic_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_topic_id"
        <?php } ?>
        data-table="orders"
        data-field="x_topic_id"
        data-value-separator="<?= $Page->topic_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->topic_id->getPlaceHolder()) ?>"
        <?= $Page->topic_id->editAttributes() ?>>
        <?= $Page->topic_id->selectOptionListHtml("x{$Page->RowIndex}_topic_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->topic_id->getErrorMessage() ?></div>
<?= $Page->topic_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_topic_id") ?>
<?php if (!$Page->topic_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_topic_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_topic_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.topic_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_topic_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_topic_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.topic_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_topic_id" class="el_orders_topic_id">
<span<?= $Page->topic_id->viewAttributes() ?>>
<?= $Page->topic_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->date->Visible) { // date ?>
        <td data-name="date"<?= $Page->date->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_date" class="el_orders_date">
<input type="<?= $Page->date->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_date" id="x<?= $Page->RowIndex ?>_date" data-table="orders" data-field="x_date" value="<?= $Page->date->EditValue ?>" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->date->formatPattern()) ?>"<?= $Page->date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage() ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["<?= $Page->FormName ?>", "datetimepicker"], function () {
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
    ew.createDateTimePicker("<?= $Page->FormName ?>", "x<?= $Page->RowIndex ?>_date", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_date" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_date" id="o<?= $Page->RowIndex ?>_date" value="<?= HtmlEncode($Page->date->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_date" class="el_orders_date">
<input type="<?= $Page->date->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_date" id="x<?= $Page->RowIndex ?>_date" data-table="orders" data-field="x_date" value="<?= $Page->date->EditValue ?>" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->date->formatPattern()) ?>"<?= $Page->date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage() ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["<?= $Page->FormName ?>", "datetimepicker"], function () {
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
    ew.createDateTimePicker("<?= $Page->FormName ?>", "x<?= $Page->RowIndex ?>_date", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_date" class="el_orders_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->time->Visible) { // time ?>
        <td data-name="time"<?= $Page->time->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_time" class="el_orders_time">
<input type="<?= $Page->time->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_time" id="x<?= $Page->RowIndex ?>_time" data-table="orders" data-field="x_time" value="<?= $Page->time->EditValue ?>" placeholder="<?= HtmlEncode($Page->time->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->time->formatPattern()) ?>"<?= $Page->time->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->time->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="orders" data-field="x_time" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_time" id="o<?= $Page->RowIndex ?>_time" value="<?= HtmlEncode($Page->time->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_time" class="el_orders_time">
<input type="<?= $Page->time->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_time" id="x<?= $Page->RowIndex ?>_time" data-table="orders" data-field="x_time" value="<?= $Page->time->EditValue ?>" placeholder="<?= HtmlEncode($Page->time->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->time->formatPattern()) ?>"<?= $Page->time->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->time->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_time" class="el_orders_time">
<span<?= $Page->time->viewAttributes() ?>>
<?= $Page->time->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->fees->Visible) { // fees ?>
        <td data-name="fees"<?= $Page->fees->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_fees" class="el_orders_fees">
<input type="<?= $Page->fees->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_fees" id="x<?= $Page->RowIndex ?>_fees" data-table="orders" data-field="x_fees" value="<?= $Page->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fees->formatPattern()) ?>"<?= $Page->fees->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fees->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="orders" data-field="x_fees" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_fees" id="o<?= $Page->RowIndex ?>_fees" value="<?= HtmlEncode($Page->fees->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_fees" class="el_orders_fees">
<input type="<?= $Page->fees->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_fees" id="x<?= $Page->RowIndex ?>_fees" data-table="orders" data-field="x_fees" value="<?= $Page->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fees->formatPattern()) ?>"<?= $Page->fees->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fees->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_fees" class="el_orders_fees">
<span<?= $Page->fees->viewAttributes() ?>>
<?= $Page->fees->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->currency_id->Visible) { // currency_id ?>
        <td data-name="currency_id"<?= $Page->currency_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_currency_id" class="el_orders_currency_id">
    <select
        id="x<?= $Page->RowIndex ?>_currency_id"
        name="x<?= $Page->RowIndex ?>_currency_id"
        class="form-select ew-select<?= $Page->currency_id->isInvalidClass() ?>"
        <?php if (!$Page->currency_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_currency_id"
        <?php } ?>
        data-table="orders"
        data-field="x_currency_id"
        data-value-separator="<?= $Page->currency_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->currency_id->getPlaceHolder()) ?>"
        <?= $Page->currency_id->editAttributes() ?>>
        <?= $Page->currency_id->selectOptionListHtml("x{$Page->RowIndex}_currency_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->currency_id->getErrorMessage() ?></div>
<?= $Page->currency_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_currency_id") ?>
<?php if (!$Page->currency_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_currency_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_currency_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.currency_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_currency_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_currency_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.currency_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_currency_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_currency_id" id="o<?= $Page->RowIndex ?>_currency_id" value="<?= HtmlEncode($Page->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_currency_id" class="el_orders_currency_id">
    <select
        id="x<?= $Page->RowIndex ?>_currency_id"
        name="x<?= $Page->RowIndex ?>_currency_id"
        class="form-select ew-select<?= $Page->currency_id->isInvalidClass() ?>"
        <?php if (!$Page->currency_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_currency_id"
        <?php } ?>
        data-table="orders"
        data-field="x_currency_id"
        data-value-separator="<?= $Page->currency_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->currency_id->getPlaceHolder()) ?>"
        <?= $Page->currency_id->editAttributes() ?>>
        <?= $Page->currency_id->selectOptionListHtml("x{$Page->RowIndex}_currency_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->currency_id->getErrorMessage() ?></div>
<?= $Page->currency_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_currency_id") ?>
<?php if (!$Page->currency_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_currency_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_currency_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.currency_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_currency_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_currency_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.currency_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_currency_id" class="el_orders_currency_id">
<span<?= $Page->currency_id->viewAttributes() ?>>
<?= $Page->currency_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_status" class="el_orders_status">
    <select
        id="x<?= $Page->RowIndex ?>_status"
        name="x<?= $Page->RowIndex ?>_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        <?php if (!$Page->status->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_status"
        <?php } ?>
        data-table="orders"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x{$Page->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<?php if (!$Page->status->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_status", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.status?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_status", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_status", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="orders" data-field="x_status" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_status" id="o<?= $Page->RowIndex ?>_status" value="<?= HtmlEncode($Page->status->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_status" class="el_orders_status">
    <select
        id="x<?= $Page->RowIndex ?>_status"
        name="x<?= $Page->RowIndex ?>_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        <?php if (!$Page->status->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_status"
        <?php } ?>
        data-table="orders"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x{$Page->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<?php if (!$Page->status->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_status", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.status?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_status", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_status", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_status" class="el_orders_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->meeting_id->Visible) { // meeting_id ?>
        <td data-name="meeting_id"<?= $Page->meeting_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_meeting_id" class="el_orders_meeting_id">
<input type="<?= $Page->meeting_id->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_meeting_id" id="x<?= $Page->RowIndex ?>_meeting_id" data-table="orders" data-field="x_meeting_id" value="<?= $Page->meeting_id->EditValue ?>" placeholder="<?= HtmlEncode($Page->meeting_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->meeting_id->formatPattern()) ?>"<?= $Page->meeting_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->meeting_id->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="orders" data-field="x_meeting_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_meeting_id" id="o<?= $Page->RowIndex ?>_meeting_id" value="<?= HtmlEncode($Page->meeting_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_meeting_id" class="el_orders_meeting_id">
<input type="<?= $Page->meeting_id->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_meeting_id" id="x<?= $Page->RowIndex ?>_meeting_id" data-table="orders" data-field="x_meeting_id" value="<?= $Page->meeting_id->EditValue ?>" placeholder="<?= HtmlEncode($Page->meeting_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->meeting_id->formatPattern()) ?>"<?= $Page->meeting_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->meeting_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_meeting_id" class="el_orders_meeting_id">
<span<?= $Page->meeting_id->viewAttributes() ?>>
<?= $Page->meeting_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->package_id->Visible) { // package_id ?>
        <td data-name="package_id"<?= $Page->package_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_orders_package_id" class="el_orders_package_id">
<input type="<?= $Page->package_id->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_package_id" id="x<?= $Page->RowIndex ?>_package_id" data-table="orders" data-field="x_package_id" value="<?= $Page->package_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->package_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->package_id->formatPattern()) ?>"<?= $Page->package_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->package_id->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="orders" data-field="x_package_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_package_id" id="o<?= $Page->RowIndex ?>_package_id" value="<?= HtmlEncode($Page->package_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_orders_package_id" class="el_orders_package_id">
<input type="<?= $Page->package_id->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_package_id" id="x<?= $Page->RowIndex ?>_package_id" data-table="orders" data-field="x_package_id" value="<?= $Page->package_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->package_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->package_id->formatPattern()) ?>"<?= $Page->package_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->package_id->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_orders_package_id" class="el_orders_package_id">
<span<?= $Page->package_id->viewAttributes() ?>>
<?= $Page->package_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script data-rowindex="<?= $Page->RowIndex ?>">
loadjs.ready(["<?= $Page->FormName ?>","load"], () => <?= $Page->FormName ?>.updateLists(<?= $Page->RowIndex ?><?= $Page->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (
        $Page->Recordset &&
        !$Page->Recordset->EOF &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
    ) {
        $Page->Recordset->moveNext();
    }
    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } elseif ($Page->isMultiEdit()) { ?>
<input type="hidden" name="action" id="action" value="multiupdate">
<?php } ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
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
