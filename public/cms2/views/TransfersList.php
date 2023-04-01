<?php

namespace PHPMaker2023\hih71;

// Page object
$TransfersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { transfers: currentTable } });
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
            "user_id": <?= $Page->user_id->toClientList($Page) ?>,
            "type": <?= $Page->type->toClientList($Page) ?>,
            "order_id": <?= $Page->order_id->toClientList($Page) ?>,
            "approved": <?= $Page->approved->toClientList($Page) ?>,
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "users") {
    if ($Page->MasterRecordExists) {
        include_once "views/UsersMaster.php";
    }
}
?>
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="ftransferssrch" id="ftransferssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="ftransferssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { transfers: currentTable } });
var currentForm;
var ftransferssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("ftransferssrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["id", [], fields.id.isInvalid],
            ["user_id", [], fields.user_id.isInvalid],
            ["amount", [], fields.amount.isInvalid],
            ["type", [], fields.type.isInvalid],
            ["order_id", [], fields.order_id.isInvalid],
            ["approved", [], fields.approved.isInvalid],
            ["verification_code", [], fields.verification_code.isInvalid]
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
            "type": <?= $Page->type->toClientList($Page) ?>,
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
<?php if ($Page->type->Visible) { // type ?>
<?php
if (!$Page->type->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_type" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->type->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->type->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_type" id="z_type" value="=">
</div>
        </div>
        <div id="el_transfers_type" class="ew-search-field">
<template id="tp_x_type">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="transfers" data-field="x_type" name="x_type" id="x_type"<?= $Page->type->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_type" class="ew-item-list"></div>
<selection-list hidden
    id="x_type"
    name="x_type"
    value="<?= HtmlEncode($Page->type->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_type"
    data-target="dsl_x_type"
    data-repeatcolumn="5"
    class="form-control<?= $Page->type->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_type"
    data-value-separator="<?= $Page->type->displayValueSeparatorAttribute() ?>"
    <?= $Page->type->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage(false) ?></div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ftransferssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ftransferssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ftransferssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ftransferssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="transfers">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "users" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="users">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->user_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_transfers" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_transferslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_transfers_id" class="transfers_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
        <th data-name="user_id" class="<?= $Page->user_id->headerCellClass() ?>"><div id="elh_transfers_user_id" class="transfers_user_id"><?= $Page->renderFieldHeader($Page->user_id) ?></div></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div id="elh_transfers_amount" class="transfers_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th data-name="type" class="<?= $Page->type->headerCellClass() ?>"><div id="elh_transfers_type" class="transfers_type"><?= $Page->renderFieldHeader($Page->type) ?></div></th>
<?php } ?>
<?php if ($Page->order_id->Visible) { // order_id ?>
        <th data-name="order_id" class="<?= $Page->order_id->headerCellClass() ?>"><div id="elh_transfers_order_id" class="transfers_order_id"><?= $Page->renderFieldHeader($Page->order_id) ?></div></th>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
        <th data-name="approved" class="<?= $Page->approved->headerCellClass() ?>"><div id="elh_transfers_approved" class="transfers_approved"><?= $Page->renderFieldHeader($Page->approved) ?></div></th>
<?php } ?>
<?php if ($Page->verification_code->Visible) { // verification_code ?>
        <th data-name="verification_code" class="<?= $Page->verification_code->headerCellClass() ?>"><div id="elh_transfers_verification_code" class="transfers_verification_code"><?= $Page->renderFieldHeader($Page->verification_code) ?></div></th>
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
<span id="el<?= $Page->RowCount ?>_transfers_id" class="el_transfers_id"></span>
<input type="hidden" data-table="transfers" data-field="x_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_transfers_id" class="el_transfers_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="transfers" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_transfers_id" class="el_transfers_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="transfers" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->user_id->Visible) { // user_id ?>
        <td data-name="user_id"<?= $Page->user_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->user_id->getSessionValue() != "") { ?>
<span<?= $Page->user_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->user_id->getDisplayValue($Page->user_id->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_user_id" name="x<?= $Page->RowIndex ?>_user_id" value="<?= HtmlEncode($Page->user_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_transfers_user_id" class="el_transfers_user_id">
    <select
        id="x<?= $Page->RowIndex ?>_user_id"
        name="x<?= $Page->RowIndex ?>_user_id"
        class="form-select ew-select<?= $Page->user_id->isInvalidClass() ?>"
        <?php if (!$Page->user_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_user_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_user_id"
        data-value-separator="<?= $Page->user_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_id->getPlaceHolder()) ?>"
        <?= $Page->user_id->editAttributes() ?>>
        <?= $Page->user_id->selectOptionListHtml("x{$Page->RowIndex}_user_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->user_id->getErrorMessage() ?></div>
<?= $Page->user_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_user_id") ?>
<?php if (!$Page->user_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_user_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_user_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.user_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_user_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_user_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.user_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_user_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_user_id" id="o<?= $Page->RowIndex ?>_user_id" value="<?= HtmlEncode($Page->user_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->user_id->getSessionValue() != "") { ?>
<span<?= $Page->user_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->user_id->getDisplayValue($Page->user_id->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_user_id" name="x<?= $Page->RowIndex ?>_user_id" value="<?= HtmlEncode($Page->user_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_transfers_user_id" class="el_transfers_user_id">
    <select
        id="x<?= $Page->RowIndex ?>_user_id"
        name="x<?= $Page->RowIndex ?>_user_id"
        class="form-select ew-select<?= $Page->user_id->isInvalidClass() ?>"
        <?php if (!$Page->user_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_user_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_user_id"
        data-value-separator="<?= $Page->user_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_id->getPlaceHolder()) ?>"
        <?= $Page->user_id->editAttributes() ?>>
        <?= $Page->user_id->selectOptionListHtml("x{$Page->RowIndex}_user_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->user_id->getErrorMessage() ?></div>
<?= $Page->user_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_user_id") ?>
<?php if (!$Page->user_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_user_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_user_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.user_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_user_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_user_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
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
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_transfers_user_id" class="el_transfers_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->amount->Visible) { // amount ?>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_transfers_amount" class="el_transfers_amount">
<input type="<?= $Page->amount->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_amount" id="x<?= $Page->RowIndex ?>_amount" data-table="transfers" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->amount->formatPattern()) ?>"<?= $Page->amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="transfers" data-field="x_amount" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_amount" id="o<?= $Page->RowIndex ?>_amount" value="<?= HtmlEncode($Page->amount->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_transfers_amount" class="el_transfers_amount">
<input type="<?= $Page->amount->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_amount" id="x<?= $Page->RowIndex ?>_amount" data-table="transfers" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->amount->formatPattern()) ?>"<?= $Page->amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_transfers_amount" class="el_transfers_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->type->Visible) { // type ?>
        <td data-name="type"<?= $Page->type->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_transfers_type" class="el_transfers_type">
<template id="tp_x<?= $Page->RowIndex ?>_type">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="transfers" data-field="x_type" name="x<?= $Page->RowIndex ?>_type" id="x<?= $Page->RowIndex ?>_type"<?= $Page->type->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_type" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_type"
    name="x<?= $Page->RowIndex ?>_type"
    value="<?= HtmlEncode($Page->type->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_type"
    data-target="dsl_x<?= $Page->RowIndex ?>_type"
    data-repeatcolumn="5"
    class="form-control<?= $Page->type->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_type"
    data-value-separator="<?= $Page->type->displayValueSeparatorAttribute() ?>"
    <?= $Page->type->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="transfers" data-field="x_type" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_type" id="o<?= $Page->RowIndex ?>_type" value="<?= HtmlEncode($Page->type->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_transfers_type" class="el_transfers_type">
<template id="tp_x<?= $Page->RowIndex ?>_type">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="transfers" data-field="x_type" name="x<?= $Page->RowIndex ?>_type" id="x<?= $Page->RowIndex ?>_type"<?= $Page->type->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_type" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_type"
    name="x<?= $Page->RowIndex ?>_type"
    value="<?= HtmlEncode($Page->type->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_type"
    data-target="dsl_x<?= $Page->RowIndex ?>_type"
    data-repeatcolumn="5"
    class="form-control<?= $Page->type->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_type"
    data-value-separator="<?= $Page->type->displayValueSeparatorAttribute() ?>"
    <?= $Page->type->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_transfers_type" class="el_transfers_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->order_id->Visible) { // order_id ?>
        <td data-name="order_id"<?= $Page->order_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_transfers_order_id" class="el_transfers_order_id">
    <select
        id="x<?= $Page->RowIndex ?>_order_id"
        name="x<?= $Page->RowIndex ?>_order_id"
        class="form-select ew-select<?= $Page->order_id->isInvalidClass() ?>"
        <?php if (!$Page->order_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_order_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_order_id"
        data-value-separator="<?= $Page->order_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->order_id->getPlaceHolder()) ?>"
        <?= $Page->order_id->editAttributes() ?>>
        <?= $Page->order_id->selectOptionListHtml("x{$Page->RowIndex}_order_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->order_id->getErrorMessage() ?></div>
<?= $Page->order_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_order_id") ?>
<?php if (!$Page->order_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_order_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_order_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.order_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_order_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_order_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.order_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="transfers" data-field="x_order_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_order_id" id="o<?= $Page->RowIndex ?>_order_id" value="<?= HtmlEncode($Page->order_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_transfers_order_id" class="el_transfers_order_id">
    <select
        id="x<?= $Page->RowIndex ?>_order_id"
        name="x<?= $Page->RowIndex ?>_order_id"
        class="form-select ew-select<?= $Page->order_id->isInvalidClass() ?>"
        <?php if (!$Page->order_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_order_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_order_id"
        data-value-separator="<?= $Page->order_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->order_id->getPlaceHolder()) ?>"
        <?= $Page->order_id->editAttributes() ?>>
        <?= $Page->order_id->selectOptionListHtml("x{$Page->RowIndex}_order_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->order_id->getErrorMessage() ?></div>
<?= $Page->order_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_order_id") ?>
<?php if (!$Page->order_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_order_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_order_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.order_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_order_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_order_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.order_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_transfers_order_id" class="el_transfers_order_id">
<span<?= $Page->order_id->viewAttributes() ?>>
<?= $Page->order_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->approved->Visible) { // approved ?>
        <td data-name="approved"<?= $Page->approved->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_transfers_approved" class="el_transfers_approved">
<template id="tp_x<?= $Page->RowIndex ?>_approved">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="transfers" data-field="x_approved" name="x<?= $Page->RowIndex ?>_approved" id="x<?= $Page->RowIndex ?>_approved"<?= $Page->approved->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_approved" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_approved"
    name="x<?= $Page->RowIndex ?>_approved"
    value="<?= HtmlEncode($Page->approved->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_approved"
    data-target="dsl_x<?= $Page->RowIndex ?>_approved"
    data-repeatcolumn="5"
    class="form-control<?= $Page->approved->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_approved"
    data-value-separator="<?= $Page->approved->displayValueSeparatorAttribute() ?>"
    <?= $Page->approved->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->approved->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="transfers" data-field="x_approved" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_approved" id="o<?= $Page->RowIndex ?>_approved" value="<?= HtmlEncode($Page->approved->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_transfers_approved" class="el_transfers_approved">
<template id="tp_x<?= $Page->RowIndex ?>_approved">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="transfers" data-field="x_approved" name="x<?= $Page->RowIndex ?>_approved" id="x<?= $Page->RowIndex ?>_approved"<?= $Page->approved->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_approved" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_approved"
    name="x<?= $Page->RowIndex ?>_approved"
    value="<?= HtmlEncode($Page->approved->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_approved"
    data-target="dsl_x<?= $Page->RowIndex ?>_approved"
    data-repeatcolumn="5"
    class="form-control<?= $Page->approved->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_approved"
    data-value-separator="<?= $Page->approved->displayValueSeparatorAttribute() ?>"
    <?= $Page->approved->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->approved->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_transfers_approved" class="el_transfers_approved">
<span<?= $Page->approved->viewAttributes() ?>>
<?= $Page->approved->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->verification_code->Visible) { // verification_code ?>
        <td data-name="verification_code"<?= $Page->verification_code->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_transfers_verification_code" class="el_transfers_verification_code">
<input type="<?= $Page->verification_code->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_verification_code" id="x<?= $Page->RowIndex ?>_verification_code" data-table="transfers" data-field="x_verification_code" value="<?= $Page->verification_code->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->verification_code->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->verification_code->formatPattern()) ?>"<?= $Page->verification_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->verification_code->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="transfers" data-field="x_verification_code" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_verification_code" id="o<?= $Page->RowIndex ?>_verification_code" value="<?= HtmlEncode($Page->verification_code->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_transfers_verification_code" class="el_transfers_verification_code">
<input type="<?= $Page->verification_code->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_verification_code" id="x<?= $Page->RowIndex ?>_verification_code" data-table="transfers" data-field="x_verification_code" value="<?= $Page->verification_code->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->verification_code->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->verification_code->formatPattern()) ?>"<?= $Page->verification_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->verification_code->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_transfers_verification_code" class="el_transfers_verification_code">
<span<?= $Page->verification_code->viewAttributes() ?>>
<?= $Page->verification_code->getViewValue() ?></span>
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
    ew.addEventHandlers("transfers");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
