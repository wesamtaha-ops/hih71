<?php

namespace PHPMaker2023\hih71;

// Page object
$TeachersPackagesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { teachers_packages: currentTable } });
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
            ["teacher_id", [fields.teacher_id.visible && fields.teacher_id.required ? ew.Validators.required(fields.teacher_id.caption) : null], fields.teacher_id.isInvalid],
            ["title_en", [fields.title_en.visible && fields.title_en.required ? ew.Validators.required(fields.title_en.caption) : null], fields.title_en.isInvalid],
            ["title_ar", [fields.title_ar.visible && fields.title_ar.required ? ew.Validators.required(fields.title_ar.caption) : null], fields.title_ar.isInvalid],
            ["description_en", [fields.description_en.visible && fields.description_en.required ? ew.Validators.required(fields.description_en.caption) : null], fields.description_en.isInvalid],
            ["description_ar", [fields.description_ar.visible && fields.description_ar.required ? ew.Validators.required(fields.description_ar.caption) : null], fields.description_ar.isInvalid],
            ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid],
            ["fees", [fields.fees.visible && fields.fees.required ? ew.Validators.required(fields.fees.caption) : null, ew.Validators.integer], fields.fees.isInvalid],
            ["currency_id", [fields.currency_id.visible && fields.currency_id.required ? ew.Validators.required(fields.currency_id.caption) : null, ew.Validators.integer], fields.currency_id.isInvalid],
            ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(fields.created_at.clientFormatPattern)], fields.created_at.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["teacher_id",false],["title_en",false],["title_ar",false],["description_en",false],["description_ar",false],["image",false],["fees",false],["currency_id",false],["created_at",false]];
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
            "teacher_id": <?= $Page->teacher_id->toClientList($Page) ?>,
            "currency_id": <?= $Page->currency_id->toClientList($Page) ?>,
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
<?php if (!$Page->IsModal) { ?>
<form name="fteachers_packagessrch" id="fteachers_packagessrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="fteachers_packagessrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { teachers_packages: currentTable } });
var currentForm;
var fteachers_packagessrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fteachers_packagessrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
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
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fteachers_packagessrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fteachers_packagessrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fteachers_packagessrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fteachers_packagessrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="teachers_packages">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_teachers_packages" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_teachers_packageslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_teachers_packages_id" class="teachers_packages_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->teacher_id->Visible) { // teacher_id ?>
        <th data-name="teacher_id" class="<?= $Page->teacher_id->headerCellClass() ?>"><div id="elh_teachers_packages_teacher_id" class="teachers_packages_teacher_id"><?= $Page->renderFieldHeader($Page->teacher_id) ?></div></th>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
        <th data-name="title_en" class="<?= $Page->title_en->headerCellClass() ?>"><div id="elh_teachers_packages_title_en" class="teachers_packages_title_en"><?= $Page->renderFieldHeader($Page->title_en) ?></div></th>
<?php } ?>
<?php if ($Page->title_ar->Visible) { // title_ar ?>
        <th data-name="title_ar" class="<?= $Page->title_ar->headerCellClass() ?>"><div id="elh_teachers_packages_title_ar" class="teachers_packages_title_ar"><?= $Page->renderFieldHeader($Page->title_ar) ?></div></th>
<?php } ?>
<?php if ($Page->description_en->Visible) { // description_en ?>
        <th data-name="description_en" class="<?= $Page->description_en->headerCellClass() ?>"><div id="elh_teachers_packages_description_en" class="teachers_packages_description_en"><?= $Page->renderFieldHeader($Page->description_en) ?></div></th>
<?php } ?>
<?php if ($Page->description_ar->Visible) { // description_ar ?>
        <th data-name="description_ar" class="<?= $Page->description_ar->headerCellClass() ?>"><div id="elh_teachers_packages_description_ar" class="teachers_packages_description_ar"><?= $Page->renderFieldHeader($Page->description_ar) ?></div></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th data-name="image" class="<?= $Page->image->headerCellClass() ?>"><div id="elh_teachers_packages_image" class="teachers_packages_image"><?= $Page->renderFieldHeader($Page->image) ?></div></th>
<?php } ?>
<?php if ($Page->fees->Visible) { // fees ?>
        <th data-name="fees" class="<?= $Page->fees->headerCellClass() ?>"><div id="elh_teachers_packages_fees" class="teachers_packages_fees"><?= $Page->renderFieldHeader($Page->fees) ?></div></th>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
        <th data-name="currency_id" class="<?= $Page->currency_id->headerCellClass() ?>"><div id="elh_teachers_packages_currency_id" class="teachers_packages_currency_id"><?= $Page->renderFieldHeader($Page->currency_id) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_teachers_packages_created_at" class="teachers_packages_created_at"><?= $Page->renderFieldHeader($Page->created_at) ?></div></th>
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
<span id="el<?= $Page->RowCount ?>_teachers_packages_id" class="el_teachers_packages_id"></span>
<input type="hidden" data-table="teachers_packages" data-field="x_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_id" class="el_teachers_packages_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="teachers_packages" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_id" class="el_teachers_packages_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="teachers_packages" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->teacher_id->Visible) { // teacher_id ?>
        <td data-name="teacher_id"<?= $Page->teacher_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_teacher_id" class="el_teachers_packages_teacher_id">
    <select
        id="x<?= $Page->RowIndex ?>_teacher_id"
        name="x<?= $Page->RowIndex ?>_teacher_id"
        class="form-select ew-select<?= $Page->teacher_id->isInvalidClass() ?>"
        <?php if (!$Page->teacher_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_teacher_id"
        <?php } ?>
        data-table="teachers_packages"
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
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.teachers_packages.fields.teacher_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_teacher_id" id="o<?= $Page->RowIndex ?>_teacher_id" value="<?= HtmlEncode($Page->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_teacher_id" class="el_teachers_packages_teacher_id">
    <select
        id="x<?= $Page->RowIndex ?>_teacher_id"
        name="x<?= $Page->RowIndex ?>_teacher_id"
        class="form-select ew-select<?= $Page->teacher_id->isInvalidClass() ?>"
        <?php if (!$Page->teacher_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_teacher_id"
        <?php } ?>
        data-table="teachers_packages"
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
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.teachers_packages.fields.teacher_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_teacher_id" class="el_teachers_packages_teacher_id">
<span<?= $Page->teacher_id->viewAttributes() ?>>
<?= $Page->teacher_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->title_en->Visible) { // title_en ?>
        <td data-name="title_en"<?= $Page->title_en->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_title_en" class="el_teachers_packages_title_en">
<input type="<?= $Page->title_en->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_title_en" id="x<?= $Page->RowIndex ?>_title_en" data-table="teachers_packages" data-field="x_title_en" value="<?= $Page->title_en->EditValue ?>" placeholder="<?= HtmlEncode($Page->title_en->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->title_en->formatPattern()) ?>"<?= $Page->title_en->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title_en->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_title_en" id="o<?= $Page->RowIndex ?>_title_en" value="<?= HtmlEncode($Page->title_en->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_title_en" class="el_teachers_packages_title_en">
<input type="<?= $Page->title_en->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_title_en" id="x<?= $Page->RowIndex ?>_title_en" data-table="teachers_packages" data-field="x_title_en" value="<?= $Page->title_en->EditValue ?>" placeholder="<?= HtmlEncode($Page->title_en->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->title_en->formatPattern()) ?>"<?= $Page->title_en->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title_en->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_title_en" class="el_teachers_packages_title_en">
<span<?= $Page->title_en->viewAttributes() ?>>
<?= $Page->title_en->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->title_ar->Visible) { // title_ar ?>
        <td data-name="title_ar"<?= $Page->title_ar->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_title_ar" class="el_teachers_packages_title_ar">
<input type="<?= $Page->title_ar->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_title_ar" id="x<?= $Page->RowIndex ?>_title_ar" data-table="teachers_packages" data-field="x_title_ar" value="<?= $Page->title_ar->EditValue ?>" placeholder="<?= HtmlEncode($Page->title_ar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->title_ar->formatPattern()) ?>"<?= $Page->title_ar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title_ar->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_title_ar" id="o<?= $Page->RowIndex ?>_title_ar" value="<?= HtmlEncode($Page->title_ar->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_title_ar" class="el_teachers_packages_title_ar">
<input type="<?= $Page->title_ar->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_title_ar" id="x<?= $Page->RowIndex ?>_title_ar" data-table="teachers_packages" data-field="x_title_ar" value="<?= $Page->title_ar->EditValue ?>" placeholder="<?= HtmlEncode($Page->title_ar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->title_ar->formatPattern()) ?>"<?= $Page->title_ar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title_ar->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_title_ar" class="el_teachers_packages_title_ar">
<span<?= $Page->title_ar->viewAttributes() ?>>
<?= $Page->title_ar->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->description_en->Visible) { // description_en ?>
        <td data-name="description_en"<?= $Page->description_en->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_description_en" class="el_teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x<?= $Page->RowIndex ?>_description_en" id="x<?= $Page->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description_en->getPlaceHolder()) ?>"<?= $Page->description_en->editAttributes() ?>><?= $Page->description_en->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->description_en->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_description_en" id="o<?= $Page->RowIndex ?>_description_en" value="<?= HtmlEncode($Page->description_en->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_description_en" class="el_teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x<?= $Page->RowIndex ?>_description_en" id="x<?= $Page->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description_en->getPlaceHolder()) ?>"<?= $Page->description_en->editAttributes() ?>><?= $Page->description_en->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->description_en->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_description_en" class="el_teachers_packages_description_en">
<span<?= $Page->description_en->viewAttributes() ?>>
<?= $Page->description_en->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->description_ar->Visible) { // description_ar ?>
        <td data-name="description_ar"<?= $Page->description_ar->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_description_ar" class="el_teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x<?= $Page->RowIndex ?>_description_ar" id="x<?= $Page->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description_ar->getPlaceHolder()) ?>"<?= $Page->description_ar->editAttributes() ?>><?= $Page->description_ar->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->description_ar->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_description_ar" id="o<?= $Page->RowIndex ?>_description_ar" value="<?= HtmlEncode($Page->description_ar->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_description_ar" class="el_teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x<?= $Page->RowIndex ?>_description_ar" id="x<?= $Page->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description_ar->getPlaceHolder()) ?>"<?= $Page->description_ar->editAttributes() ?>><?= $Page->description_ar->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->description_ar->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_description_ar" class="el_teachers_packages_description_ar">
<span<?= $Page->description_ar->viewAttributes() ?>>
<?= $Page->description_ar->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->image->Visible) { // image ?>
        <td data-name="image"<?= $Page->image->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_image" class="el_teachers_packages_image">
<div id="fd_x<?= $Page->RowIndex ?>_image" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_image"
        name="x<?= $Page->RowIndex ?>_image"
        class="form-control ew-file-input"
        title="<?= $Page->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="teachers_packages"
        data-field="x_image"
        data-size="65535"
        data-accept-file-types="<?= $Page->image->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->image->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->image->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->image->ReadOnly || $Page->image->Disabled) ? " disabled" : "" ?>
        <?= $Page->image->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Page->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_image" id= "fn_x<?= $Page->RowIndex ?>_image" value="<?= $Page->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_image" id= "fa_x<?= $Page->RowIndex ?>_image" value="0">
<table id="ft_x<?= $Page->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_image" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_image" id="o<?= $Page->RowIndex ?>_image" value="<?= HtmlEncode($Page->image->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_image" class="el_teachers_packages_image">
<div id="fd_x<?= $Page->RowIndex ?>_image" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_image"
        name="x<?= $Page->RowIndex ?>_image"
        class="form-control ew-file-input"
        title="<?= $Page->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="teachers_packages"
        data-field="x_image"
        data-size="65535"
        data-accept-file-types="<?= $Page->image->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->image->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->image->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->image->ReadOnly || $Page->image->Disabled) ? " disabled" : "" ?>
        <?= $Page->image->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Page->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_image" id= "fn_x<?= $Page->RowIndex ?>_image" value="<?= $Page->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_image" id= "fa_x<?= $Page->RowIndex ?>_image" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_image") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Page->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_image" class="el_teachers_packages_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->fees->Visible) { // fees ?>
        <td data-name="fees"<?= $Page->fees->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_fees" class="el_teachers_packages_fees">
<input type="<?= $Page->fees->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_fees" id="x<?= $Page->RowIndex ?>_fees" data-table="teachers_packages" data-field="x_fees" value="<?= $Page->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fees->formatPattern()) ?>"<?= $Page->fees->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fees->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_fees" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_fees" id="o<?= $Page->RowIndex ?>_fees" value="<?= HtmlEncode($Page->fees->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_fees" class="el_teachers_packages_fees">
<input type="<?= $Page->fees->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_fees" id="x<?= $Page->RowIndex ?>_fees" data-table="teachers_packages" data-field="x_fees" value="<?= $Page->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fees->formatPattern()) ?>"<?= $Page->fees->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fees->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_fees" class="el_teachers_packages_fees">
<span<?= $Page->fees->viewAttributes() ?>>
<?= $Page->fees->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->currency_id->Visible) { // currency_id ?>
        <td data-name="currency_id"<?= $Page->currency_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_currency_id" class="el_teachers_packages_currency_id">
<?php
if (IsRTL()) {
    $Page->currency_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Page->RowIndex ?>_currency_id" class="ew-auto-suggest">
    <input type="<?= $Page->currency_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_currency_id" id="sv_x<?= $Page->RowIndex ?>_currency_id" value="<?= RemoveHtml($Page->currency_id->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->currency_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->currency_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->currency_id->formatPattern()) ?>"<?= $Page->currency_id->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="teachers_packages" data-field="x_currency_id" data-input="sv_x<?= $Page->RowIndex ?>_currency_id" data-value-separator="<?= $Page->currency_id->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_currency_id" id="x<?= $Page->RowIndex ?>_currency_id" value="<?= HtmlEncode($Page->currency_id->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Page->currency_id->getErrorMessage() ?></div>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    <?= $Page->FormName ?>.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_currency_id","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->currency_id->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.teachers_packages.fields.currency_id.autoSuggestOptions));
});
</script>
<?= $Page->currency_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_currency_id") ?>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_currency_id" id="o<?= $Page->RowIndex ?>_currency_id" value="<?= HtmlEncode($Page->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_currency_id" class="el_teachers_packages_currency_id">
<?php
if (IsRTL()) {
    $Page->currency_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Page->RowIndex ?>_currency_id" class="ew-auto-suggest">
    <input type="<?= $Page->currency_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_currency_id" id="sv_x<?= $Page->RowIndex ?>_currency_id" value="<?= RemoveHtml($Page->currency_id->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->currency_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->currency_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->currency_id->formatPattern()) ?>"<?= $Page->currency_id->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="teachers_packages" data-field="x_currency_id" data-input="sv_x<?= $Page->RowIndex ?>_currency_id" data-value-separator="<?= $Page->currency_id->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_currency_id" id="x<?= $Page->RowIndex ?>_currency_id" value="<?= HtmlEncode($Page->currency_id->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Page->currency_id->getErrorMessage() ?></div>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    <?= $Page->FormName ?>.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_currency_id","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->currency_id->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.teachers_packages.fields.currency_id.autoSuggestOptions));
});
</script>
<?= $Page->currency_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_currency_id") ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_currency_id" class="el_teachers_packages_currency_id">
<span<?= $Page->currency_id->viewAttributes() ?>>
<?= $Page->currency_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at"<?= $Page->created_at->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_created_at" class="el_teachers_packages_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_created_at" id="x<?= $Page->RowIndex ?>_created_at" data-table="teachers_packages" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_created_at" id="o<?= $Page->RowIndex ?>_created_at" value="<?= HtmlEncode($Page->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_created_at" class="el_teachers_packages_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_created_at" id="x<?= $Page->RowIndex ?>_created_at" data-table="teachers_packages" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_teachers_packages_created_at" class="el_teachers_packages_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
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
    ew.addEventHandlers("teachers_packages");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
