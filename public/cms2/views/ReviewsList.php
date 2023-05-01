<?php

namespace PHPMaker2023\hih71;

// Page object
$ReviewsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { reviews: currentTable } });
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
            ["from_user_id", [fields.from_user_id.visible && fields.from_user_id.required ? ew.Validators.required(fields.from_user_id.caption) : null], fields.from_user_id.isInvalid],
            ["to_user_id", [fields.to_user_id.visible && fields.to_user_id.required ? ew.Validators.required(fields.to_user_id.caption) : null, ew.Validators.integer], fields.to_user_id.isInvalid],
            ["points", [fields.points.visible && fields.points.required ? ew.Validators.required(fields.points.caption) : null, ew.Validators.integer], fields.points.isInvalid],
            ["approved", [fields.approved.visible && fields.approved.required ? ew.Validators.required(fields.approved.caption) : null], fields.approved.isInvalid],
            ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(fields.created_at.clientFormatPattern)], fields.created_at.isInvalid],
            ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(fields.updated_at.clientFormatPattern)], fields.updated_at.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["from_user_id",false],["to_user_id",false],["points",false],["approved",true],["created_at",false],["updated_at",false]];
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
            "from_user_id": <?= $Page->from_user_id->toClientList($Page) ?>,
            "to_user_id": <?= $Page->to_user_id->toClientList($Page) ?>,
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
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="freviewssrch" id="freviewssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="freviewssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { reviews: currentTable } });
var currentForm;
var freviewssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("freviewssrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["id", [], fields.id.isInvalid],
            ["from_user_id", [], fields.from_user_id.isInvalid],
            ["to_user_id", [], fields.to_user_id.isInvalid],
            ["points", [], fields.points.isInvalid],
            ["approved", [], fields.approved.isInvalid],
            ["created_at", [], fields.created_at.isInvalid],
            ["updated_at", [], fields.updated_at.isInvalid]
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
            "approved": <?= $Page->approved->toClientList($Page) ?>,
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
<?php if ($Page->approved->Visible) { // approved ?>
<?php
if (!$Page->approved->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_approved" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->approved->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->approved->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_approved" id="z_approved" value="=">
</div>
        </div>
        <div id="el_reviews_approved" class="ew-search-field">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->approved->isInvalidClass() ?>" data-table="reviews" data-field="x_approved" data-boolean name="x_approved" id="x_approved" value="1"<?= ConvertToBool($Page->approved->AdvancedSearch->SearchValue) ? " checked" : "" ?><?= $Page->approved->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->approved->getErrorMessage(false) ?></div>
</div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="freviewssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="freviewssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="freviewssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="freviewssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="reviews">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_reviews" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_reviewslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_reviews_id" class="reviews_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->from_user_id->Visible) { // from_user_id ?>
        <th data-name="from_user_id" class="<?= $Page->from_user_id->headerCellClass() ?>"><div id="elh_reviews_from_user_id" class="reviews_from_user_id"><?= $Page->renderFieldHeader($Page->from_user_id) ?></div></th>
<?php } ?>
<?php if ($Page->to_user_id->Visible) { // to_user_id ?>
        <th data-name="to_user_id" class="<?= $Page->to_user_id->headerCellClass() ?>"><div id="elh_reviews_to_user_id" class="reviews_to_user_id"><?= $Page->renderFieldHeader($Page->to_user_id) ?></div></th>
<?php } ?>
<?php if ($Page->points->Visible) { // points ?>
        <th data-name="points" class="<?= $Page->points->headerCellClass() ?>"><div id="elh_reviews_points" class="reviews_points"><?= $Page->renderFieldHeader($Page->points) ?></div></th>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
        <th data-name="approved" class="<?= $Page->approved->headerCellClass() ?>"><div id="elh_reviews_approved" class="reviews_approved"><?= $Page->renderFieldHeader($Page->approved) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_reviews_created_at" class="reviews_created_at"><?= $Page->renderFieldHeader($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th data-name="updated_at" class="<?= $Page->updated_at->headerCellClass() ?>"><div id="elh_reviews_updated_at" class="reviews_updated_at"><?= $Page->renderFieldHeader($Page->updated_at) ?></div></th>
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
<span id="el<?= $Page->RowCount ?>_reviews_id" class="el_reviews_id"></span>
<input type="hidden" data-table="reviews" data-field="x_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_reviews_id" class="el_reviews_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->from_user_id->Visible) { // from_user_id ?>
        <td data-name="from_user_id"<?= $Page->from_user_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_reviews_from_user_id" class="el_reviews_from_user_id">
    <select
        id="x<?= $Page->RowIndex ?>_from_user_id"
        name="x<?= $Page->RowIndex ?>_from_user_id"
        class="form-select ew-select<?= $Page->from_user_id->isInvalidClass() ?>"
        <?php if (!$Page->from_user_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_from_user_id"
        <?php } ?>
        data-table="reviews"
        data-field="x_from_user_id"
        data-value-separator="<?= $Page->from_user_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->from_user_id->getPlaceHolder()) ?>"
        <?= $Page->from_user_id->editAttributes() ?>>
        <?= $Page->from_user_id->selectOptionListHtml("x{$Page->RowIndex}_from_user_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->from_user_id->getErrorMessage() ?></div>
<?= $Page->from_user_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_from_user_id") ?>
<?php if (!$Page->from_user_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_from_user_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_from_user_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.from_user_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_from_user_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_from_user_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.reviews.fields.from_user_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="reviews" data-field="x_from_user_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_from_user_id" id="o<?= $Page->RowIndex ?>_from_user_id" value="<?= HtmlEncode($Page->from_user_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_reviews_from_user_id" class="el_reviews_from_user_id">
<span<?= $Page->from_user_id->viewAttributes() ?>>
<?= $Page->from_user_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->to_user_id->Visible) { // to_user_id ?>
        <td data-name="to_user_id"<?= $Page->to_user_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_reviews_to_user_id" class="el_reviews_to_user_id">
<?php
if (IsRTL()) {
    $Page->to_user_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Page->RowIndex ?>_to_user_id" class="ew-auto-suggest">
    <input type="<?= $Page->to_user_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_to_user_id" id="sv_x<?= $Page->RowIndex ?>_to_user_id" value="<?= RemoveHtml($Page->to_user_id->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->to_user_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->to_user_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->to_user_id->formatPattern()) ?>"<?= $Page->to_user_id->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="reviews" data-field="x_to_user_id" data-input="sv_x<?= $Page->RowIndex ?>_to_user_id" data-value-separator="<?= $Page->to_user_id->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_to_user_id" id="x<?= $Page->RowIndex ?>_to_user_id" value="<?= HtmlEncode($Page->to_user_id->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Page->to_user_id->getErrorMessage() ?></div>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    <?= $Page->FormName ?>.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_to_user_id","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->to_user_id->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.reviews.fields.to_user_id.autoSuggestOptions));
});
</script>
<?= $Page->to_user_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_to_user_id") ?>
</span>
<input type="hidden" data-table="reviews" data-field="x_to_user_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_to_user_id" id="o<?= $Page->RowIndex ?>_to_user_id" value="<?= HtmlEncode($Page->to_user_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_reviews_to_user_id" class="el_reviews_to_user_id">
<span<?= $Page->to_user_id->viewAttributes() ?>>
<?= $Page->to_user_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->points->Visible) { // points ?>
        <td data-name="points"<?= $Page->points->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_reviews_points" class="el_reviews_points">
<input type="<?= $Page->points->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_points" id="x<?= $Page->RowIndex ?>_points" data-table="reviews" data-field="x_points" value="<?= $Page->points->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->points->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->points->formatPattern()) ?>"<?= $Page->points->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->points->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="reviews" data-field="x_points" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_points" id="o<?= $Page->RowIndex ?>_points" value="<?= HtmlEncode($Page->points->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_reviews_points" class="el_reviews_points">
<span<?= $Page->points->viewAttributes() ?>>
<?= $Page->points->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->approved->Visible) { // approved ?>
        <td data-name="approved"<?= $Page->approved->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_reviews_approved" class="el_reviews_approved">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->approved->isInvalidClass() ?>" data-table="reviews" data-field="x_approved" data-boolean name="x<?= $Page->RowIndex ?>_approved" id="x<?= $Page->RowIndex ?>_approved" value="1"<?= ConvertToBool($Page->approved->CurrentValue) ? " checked" : "" ?><?= $Page->approved->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->approved->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="reviews" data-field="x_approved" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_approved" id="o<?= $Page->RowIndex ?>_approved" value="<?= HtmlEncode($Page->approved->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_reviews_approved" class="el_reviews_approved">
<span<?= $Page->approved->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_approved_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->approved->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->approved->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_approved_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at"<?= $Page->created_at->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_reviews_created_at" class="el_reviews_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_created_at" id="x<?= $Page->RowIndex ?>_created_at" data-table="reviews" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
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
    ew.createDateTimePicker("<?= $Page->FormName ?>", "x<?= $Page->RowIndex ?>_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="reviews" data-field="x_created_at" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_created_at" id="o<?= $Page->RowIndex ?>_created_at" value="<?= HtmlEncode($Page->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_reviews_created_at" class="el_reviews_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at"<?= $Page->updated_at->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_reviews_updated_at" class="el_reviews_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_updated_at" id="x<?= $Page->RowIndex ?>_updated_at" data-table="reviews" data-field="x_updated_at" value="<?= $Page->updated_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->updated_at->formatPattern()) ?>"<?= $Page->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
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
    ew.createDateTimePicker("<?= $Page->FormName ?>", "x<?= $Page->RowIndex ?>_updated_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="reviews" data-field="x_updated_at" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_updated_at" id="o<?= $Page->RowIndex ?>_updated_at" value="<?= HtmlEncode($Page->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_reviews_updated_at" class="el_reviews_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
    ew.addEventHandlers("reviews");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});

const tds = document.querySelectorAll('td[data-name="approved"]');

tds.forEach(td => {
  const checkbox = td.querySelector('input[type="checkbox"]');
  if (checkbox.checked) {
    td.style.backgroundColor = '#cbf7cb';
  } else {
    td.style.backgroundColor = '#f1c4c4';
  }
});

</script>
<?php } ?>
