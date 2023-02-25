<?php

namespace PHPMaker2023\hih71;

// Page object
$TopicsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { topics: currentTable } });
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
            ["name_ar", [fields.name_ar.visible && fields.name_ar.required ? ew.Validators.required(fields.name_ar.caption) : null], fields.name_ar.isInvalid],
            ["name_en", [fields.name_en.visible && fields.name_en.required ? ew.Validators.required(fields.name_en.caption) : null], fields.name_en.isInvalid],
            ["parent_id", [fields.parent_id.visible && fields.parent_id.required ? ew.Validators.required(fields.parent_id.caption) : null], fields.parent_id.isInvalid],
            ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["name_ar",false],["name_en",false],["parent_id",false],["image",false]];
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
            "parent_id": <?= $Page->parent_id->toClientList($Page) ?>,
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
<form name="ftopicssrch" id="ftopicssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="ftopicssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { topics: currentTable } });
var currentForm;
var ftopicssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("ftopicssrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ftopicssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ftopicssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ftopicssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ftopicssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="topics">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_topics" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_topicslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_topics_id" class="topics_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->name_ar->Visible) { // name_ar ?>
        <th data-name="name_ar" class="<?= $Page->name_ar->headerCellClass() ?>"><div id="elh_topics_name_ar" class="topics_name_ar"><?= $Page->renderFieldHeader($Page->name_ar) ?></div></th>
<?php } ?>
<?php if ($Page->name_en->Visible) { // name_en ?>
        <th data-name="name_en" class="<?= $Page->name_en->headerCellClass() ?>"><div id="elh_topics_name_en" class="topics_name_en"><?= $Page->renderFieldHeader($Page->name_en) ?></div></th>
<?php } ?>
<?php if ($Page->parent_id->Visible) { // parent_id ?>
        <th data-name="parent_id" class="<?= $Page->parent_id->headerCellClass() ?>"><div id="elh_topics_parent_id" class="topics_parent_id"><?= $Page->renderFieldHeader($Page->parent_id) ?></div></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th data-name="image" class="<?= $Page->image->headerCellClass() ?>"><div id="elh_topics_image" class="topics_image"><?= $Page->renderFieldHeader($Page->image) ?></div></th>
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
<span id="el<?= $Page->RowCount ?>_topics_id" class="el_topics_id"></span>
<input type="hidden" data-table="topics" data-field="x_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_topics_id" class="el_topics_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="topics" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_topics_id" class="el_topics_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="topics" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->name_ar->Visible) { // name_ar ?>
        <td data-name="name_ar"<?= $Page->name_ar->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_topics_name_ar" class="el_topics_name_ar">
<input type="<?= $Page->name_ar->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_name_ar" id="x<?= $Page->RowIndex ?>_name_ar" data-table="topics" data-field="x_name_ar" value="<?= $Page->name_ar->EditValue ?>" placeholder="<?= HtmlEncode($Page->name_ar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name_ar->formatPattern()) ?>"<?= $Page->name_ar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->name_ar->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="topics" data-field="x_name_ar" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_name_ar" id="o<?= $Page->RowIndex ?>_name_ar" value="<?= HtmlEncode($Page->name_ar->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_topics_name_ar" class="el_topics_name_ar">
<input type="<?= $Page->name_ar->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_name_ar" id="x<?= $Page->RowIndex ?>_name_ar" data-table="topics" data-field="x_name_ar" value="<?= $Page->name_ar->EditValue ?>" placeholder="<?= HtmlEncode($Page->name_ar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name_ar->formatPattern()) ?>"<?= $Page->name_ar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->name_ar->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_topics_name_ar" class="el_topics_name_ar">
<span<?= $Page->name_ar->viewAttributes() ?>>
<?= $Page->name_ar->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->name_en->Visible) { // name_en ?>
        <td data-name="name_en"<?= $Page->name_en->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_topics_name_en" class="el_topics_name_en">
<input type="<?= $Page->name_en->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_name_en" id="x<?= $Page->RowIndex ?>_name_en" data-table="topics" data-field="x_name_en" value="<?= $Page->name_en->EditValue ?>" placeholder="<?= HtmlEncode($Page->name_en->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name_en->formatPattern()) ?>"<?= $Page->name_en->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->name_en->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="topics" data-field="x_name_en" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_name_en" id="o<?= $Page->RowIndex ?>_name_en" value="<?= HtmlEncode($Page->name_en->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_topics_name_en" class="el_topics_name_en">
<input type="<?= $Page->name_en->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_name_en" id="x<?= $Page->RowIndex ?>_name_en" data-table="topics" data-field="x_name_en" value="<?= $Page->name_en->EditValue ?>" placeholder="<?= HtmlEncode($Page->name_en->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name_en->formatPattern()) ?>"<?= $Page->name_en->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->name_en->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_topics_name_en" class="el_topics_name_en">
<span<?= $Page->name_en->viewAttributes() ?>>
<?= $Page->name_en->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->parent_id->Visible) { // parent_id ?>
        <td data-name="parent_id"<?= $Page->parent_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_topics_parent_id" class="el_topics_parent_id">
    <select
        id="x<?= $Page->RowIndex ?>_parent_id"
        name="x<?= $Page->RowIndex ?>_parent_id"
        class="form-select ew-select<?= $Page->parent_id->isInvalidClass() ?>"
        <?php if (!$Page->parent_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_parent_id"
        <?php } ?>
        data-table="topics"
        data-field="x_parent_id"
        data-value-separator="<?= $Page->parent_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->parent_id->getPlaceHolder()) ?>"
        <?= $Page->parent_id->editAttributes() ?>>
        <?= $Page->parent_id->selectOptionListHtml("x{$Page->RowIndex}_parent_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->parent_id->getErrorMessage() ?></div>
<?= $Page->parent_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_parent_id") ?>
<?php if (!$Page->parent_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_parent_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_parent_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.parent_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_parent_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_parent_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.topics.fields.parent_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="topics" data-field="x_parent_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_parent_id" id="o<?= $Page->RowIndex ?>_parent_id" value="<?= HtmlEncode($Page->parent_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_topics_parent_id" class="el_topics_parent_id">
    <select
        id="x<?= $Page->RowIndex ?>_parent_id"
        name="x<?= $Page->RowIndex ?>_parent_id"
        class="form-select ew-select<?= $Page->parent_id->isInvalidClass() ?>"
        <?php if (!$Page->parent_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_parent_id"
        <?php } ?>
        data-table="topics"
        data-field="x_parent_id"
        data-value-separator="<?= $Page->parent_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->parent_id->getPlaceHolder()) ?>"
        <?= $Page->parent_id->editAttributes() ?>>
        <?= $Page->parent_id->selectOptionListHtml("x{$Page->RowIndex}_parent_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->parent_id->getErrorMessage() ?></div>
<?= $Page->parent_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_parent_id") ?>
<?php if (!$Page->parent_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_parent_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_parent_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.parent_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_parent_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_parent_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.topics.fields.parent_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_topics_parent_id" class="el_topics_parent_id">
<span<?= $Page->parent_id->viewAttributes() ?>>
<?= $Page->parent_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->image->Visible) { // image ?>
        <td data-name="image"<?= $Page->image->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_topics_image" class="el_topics_image">
<div id="fd_x<?= $Page->RowIndex ?>_image" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_image"
        name="x<?= $Page->RowIndex ?>_image"
        class="form-control ew-file-input"
        title="<?= $Page->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="topics"
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
<input type="hidden" data-table="topics" data-field="x_image" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_image" id="o<?= $Page->RowIndex ?>_image" value="<?= HtmlEncode($Page->image->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_topics_image" class="el_topics_image">
<div id="fd_x<?= $Page->RowIndex ?>_image" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_image"
        name="x<?= $Page->RowIndex ?>_image"
        class="form-control ew-file-input"
        title="<?= $Page->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="topics"
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
<span id="el<?= $Page->RowCount ?>_topics_image" class="el_topics_image">
<span>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
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
    ew.addEventHandlers("topics");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
