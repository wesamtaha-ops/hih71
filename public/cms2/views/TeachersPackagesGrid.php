<?php

namespace PHPMaker2023\hih71;

// Set up and run Grid object
$Grid = Container("TeachersPackagesGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fteachers_packagesgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { teachers_packages: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fteachers_packagesgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

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
            "teacher_id": <?= $Grid->teacher_id->toClientList($Grid) ?>,
            "currency_id": <?= $Grid->currency_id->toClientList($Grid) ?>,
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
<div id="fteachers_packagesgrid" class="ew-form ew-list-form">
<div id="gmp_teachers_packages" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_teachers_packagesgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_teachers_packages_id" class="teachers_packages_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->teacher_id->Visible) { // teacher_id ?>
        <th data-name="teacher_id" class="<?= $Grid->teacher_id->headerCellClass() ?>"><div id="elh_teachers_packages_teacher_id" class="teachers_packages_teacher_id"><?= $Grid->renderFieldHeader($Grid->teacher_id) ?></div></th>
<?php } ?>
<?php if ($Grid->title_en->Visible) { // title_en ?>
        <th data-name="title_en" class="<?= $Grid->title_en->headerCellClass() ?>"><div id="elh_teachers_packages_title_en" class="teachers_packages_title_en"><?= $Grid->renderFieldHeader($Grid->title_en) ?></div></th>
<?php } ?>
<?php if ($Grid->title_ar->Visible) { // title_ar ?>
        <th data-name="title_ar" class="<?= $Grid->title_ar->headerCellClass() ?>"><div id="elh_teachers_packages_title_ar" class="teachers_packages_title_ar"><?= $Grid->renderFieldHeader($Grid->title_ar) ?></div></th>
<?php } ?>
<?php if ($Grid->description_en->Visible) { // description_en ?>
        <th data-name="description_en" class="<?= $Grid->description_en->headerCellClass() ?>"><div id="elh_teachers_packages_description_en" class="teachers_packages_description_en"><?= $Grid->renderFieldHeader($Grid->description_en) ?></div></th>
<?php } ?>
<?php if ($Grid->description_ar->Visible) { // description_ar ?>
        <th data-name="description_ar" class="<?= $Grid->description_ar->headerCellClass() ?>"><div id="elh_teachers_packages_description_ar" class="teachers_packages_description_ar"><?= $Grid->renderFieldHeader($Grid->description_ar) ?></div></th>
<?php } ?>
<?php if ($Grid->image->Visible) { // image ?>
        <th data-name="image" class="<?= $Grid->image->headerCellClass() ?>"><div id="elh_teachers_packages_image" class="teachers_packages_image"><?= $Grid->renderFieldHeader($Grid->image) ?></div></th>
<?php } ?>
<?php if ($Grid->fees->Visible) { // fees ?>
        <th data-name="fees" class="<?= $Grid->fees->headerCellClass() ?>"><div id="elh_teachers_packages_fees" class="teachers_packages_fees"><?= $Grid->renderFieldHeader($Grid->fees) ?></div></th>
<?php } ?>
<?php if ($Grid->currency_id->Visible) { // currency_id ?>
        <th data-name="currency_id" class="<?= $Grid->currency_id->headerCellClass() ?>"><div id="elh_teachers_packages_currency_id" class="teachers_packages_currency_id"><?= $Grid->renderFieldHeader($Grid->currency_id) ?></div></th>
<?php } ?>
<?php if ($Grid->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Grid->created_at->headerCellClass() ?>"><div id="elh_teachers_packages_created_at" class="teachers_packages_created_at"><?= $Grid->renderFieldHeader($Grid->created_at) ?></div></th>
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
<span id="el<?= $Grid->RowCount ?>_teachers_packages_id" class="el_teachers_packages_id"></span>
<input type="hidden" data-table="teachers_packages" data-field="x_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_id" class="el_teachers_packages_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="teachers_packages" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_id" class="el_teachers_packages_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_id" data-hidden="1" name="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_id" id="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_id" data-hidden="1" data-old name="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_id" id="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="teachers_packages" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->teacher_id->Visible) { // teacher_id ?>
        <td data-name="teacher_id"<?= $Grid->teacher_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_teacher_id" class="el_teachers_packages_teacher_id">
    <select
        id="x<?= $Grid->RowIndex ?>_teacher_id"
        name="x<?= $Grid->RowIndex ?>_teacher_id"
        class="form-select ew-select<?= $Grid->teacher_id->isInvalidClass() ?>"
        <?php if (!$Grid->teacher_id->IsNativeSelect) { ?>
        data-select2-id="fteachers_packagesgrid_x<?= $Grid->RowIndex ?>_teacher_id"
        <?php } ?>
        data-table="teachers_packages"
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
loadjs.ready("fteachers_packagesgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_teacher_id", selectId: "fteachers_packagesgrid_x<?= $Grid->RowIndex ?>_teacher_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fteachers_packagesgrid.lists.teacher_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_teacher_id", form: "fteachers_packagesgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_teacher_id", form: "fteachers_packagesgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.teachers_packages.fields.teacher_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_teacher_id" id="o<?= $Grid->RowIndex ?>_teacher_id" value="<?= HtmlEncode($Grid->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_teacher_id" class="el_teachers_packages_teacher_id">
    <select
        id="x<?= $Grid->RowIndex ?>_teacher_id"
        name="x<?= $Grid->RowIndex ?>_teacher_id"
        class="form-select ew-select<?= $Grid->teacher_id->isInvalidClass() ?>"
        <?php if (!$Grid->teacher_id->IsNativeSelect) { ?>
        data-select2-id="fteachers_packagesgrid_x<?= $Grid->RowIndex ?>_teacher_id"
        <?php } ?>
        data-table="teachers_packages"
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
loadjs.ready("fteachers_packagesgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_teacher_id", selectId: "fteachers_packagesgrid_x<?= $Grid->RowIndex ?>_teacher_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fteachers_packagesgrid.lists.teacher_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_teacher_id", form: "fteachers_packagesgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_teacher_id", form: "fteachers_packagesgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.teachers_packages.fields.teacher_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_teacher_id" class="el_teachers_packages_teacher_id">
<span<?= $Grid->teacher_id->viewAttributes() ?>>
<?= $Grid->teacher_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" data-hidden="1" name="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_teacher_id" id="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_teacher_id" value="<?= HtmlEncode($Grid->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" data-hidden="1" data-old name="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_teacher_id" id="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_teacher_id" value="<?= HtmlEncode($Grid->teacher_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->title_en->Visible) { // title_en ?>
        <td data-name="title_en"<?= $Grid->title_en->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_title_en" class="el_teachers_packages_title_en">
<input type="<?= $Grid->title_en->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_title_en" id="x<?= $Grid->RowIndex ?>_title_en" data-table="teachers_packages" data-field="x_title_en" value="<?= $Grid->title_en->EditValue ?>" placeholder="<?= HtmlEncode($Grid->title_en->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->title_en->formatPattern()) ?>"<?= $Grid->title_en->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title_en->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_title_en" id="o<?= $Grid->RowIndex ?>_title_en" value="<?= HtmlEncode($Grid->title_en->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_title_en" class="el_teachers_packages_title_en">
<input type="<?= $Grid->title_en->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_title_en" id="x<?= $Grid->RowIndex ?>_title_en" data-table="teachers_packages" data-field="x_title_en" value="<?= $Grid->title_en->EditValue ?>" placeholder="<?= HtmlEncode($Grid->title_en->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->title_en->formatPattern()) ?>"<?= $Grid->title_en->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title_en->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_title_en" class="el_teachers_packages_title_en">
<span<?= $Grid->title_en->viewAttributes() ?>>
<?= $Grid->title_en->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" data-hidden="1" name="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_title_en" id="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_title_en" value="<?= HtmlEncode($Grid->title_en->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" data-hidden="1" data-old name="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_title_en" id="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_title_en" value="<?= HtmlEncode($Grid->title_en->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->title_ar->Visible) { // title_ar ?>
        <td data-name="title_ar"<?= $Grid->title_ar->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_title_ar" class="el_teachers_packages_title_ar">
<input type="<?= $Grid->title_ar->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_title_ar" id="x<?= $Grid->RowIndex ?>_title_ar" data-table="teachers_packages" data-field="x_title_ar" value="<?= $Grid->title_ar->EditValue ?>" placeholder="<?= HtmlEncode($Grid->title_ar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->title_ar->formatPattern()) ?>"<?= $Grid->title_ar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title_ar->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_title_ar" id="o<?= $Grid->RowIndex ?>_title_ar" value="<?= HtmlEncode($Grid->title_ar->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_title_ar" class="el_teachers_packages_title_ar">
<input type="<?= $Grid->title_ar->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_title_ar" id="x<?= $Grid->RowIndex ?>_title_ar" data-table="teachers_packages" data-field="x_title_ar" value="<?= $Grid->title_ar->EditValue ?>" placeholder="<?= HtmlEncode($Grid->title_ar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->title_ar->formatPattern()) ?>"<?= $Grid->title_ar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title_ar->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_title_ar" class="el_teachers_packages_title_ar">
<span<?= $Grid->title_ar->viewAttributes() ?>>
<?= $Grid->title_ar->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" data-hidden="1" name="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_title_ar" id="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_title_ar" value="<?= HtmlEncode($Grid->title_ar->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" data-hidden="1" data-old name="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_title_ar" id="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_title_ar" value="<?= HtmlEncode($Grid->title_ar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->description_en->Visible) { // description_en ?>
        <td data-name="description_en"<?= $Grid->description_en->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_description_en" class="el_teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x<?= $Grid->RowIndex ?>_description_en" id="x<?= $Grid->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->description_en->getPlaceHolder()) ?>"<?= $Grid->description_en->editAttributes() ?>><?= $Grid->description_en->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->description_en->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_description_en" id="o<?= $Grid->RowIndex ?>_description_en" value="<?= HtmlEncode($Grid->description_en->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_description_en" class="el_teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x<?= $Grid->RowIndex ?>_description_en" id="x<?= $Grid->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->description_en->getPlaceHolder()) ?>"<?= $Grid->description_en->editAttributes() ?>><?= $Grid->description_en->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->description_en->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_description_en" class="el_teachers_packages_description_en">
<span<?= $Grid->description_en->viewAttributes() ?>>
<?= $Grid->description_en->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" data-hidden="1" name="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_description_en" id="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_description_en" value="<?= HtmlEncode($Grid->description_en->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" data-hidden="1" data-old name="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_description_en" id="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_description_en" value="<?= HtmlEncode($Grid->description_en->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->description_ar->Visible) { // description_ar ?>
        <td data-name="description_ar"<?= $Grid->description_ar->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_description_ar" class="el_teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x<?= $Grid->RowIndex ?>_description_ar" id="x<?= $Grid->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->description_ar->getPlaceHolder()) ?>"<?= $Grid->description_ar->editAttributes() ?>><?= $Grid->description_ar->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->description_ar->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_description_ar" id="o<?= $Grid->RowIndex ?>_description_ar" value="<?= HtmlEncode($Grid->description_ar->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_description_ar" class="el_teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x<?= $Grid->RowIndex ?>_description_ar" id="x<?= $Grid->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->description_ar->getPlaceHolder()) ?>"<?= $Grid->description_ar->editAttributes() ?>><?= $Grid->description_ar->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->description_ar->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_description_ar" class="el_teachers_packages_description_ar">
<span<?= $Grid->description_ar->viewAttributes() ?>>
<?= $Grid->description_ar->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" data-hidden="1" name="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_description_ar" id="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_description_ar" value="<?= HtmlEncode($Grid->description_ar->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" data-hidden="1" data-old name="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_description_ar" id="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_description_ar" value="<?= HtmlEncode($Grid->description_ar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->image->Visible) { // image ?>
        <td data-name="image"<?= $Grid->image->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $rowIndex ?>_teachers_packages_image" class="el_teachers_packages_image">
<div id="fd_x<?= $Grid->RowIndex ?>_image" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_image"
        name="x<?= $Grid->RowIndex ?>_image"
        class="form-control ew-file-input"
        title="<?= $Grid->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="teachers_packages"
        data-field="x_image"
        data-size="65535"
        data-accept-file-types="<?= $Grid->image->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->image->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->image->ImageCropper ? 0 : 1 ?>"
        <?= ($Grid->image->ReadOnly || $Grid->image->Disabled) ? " disabled" : "" ?>
        <?= $Grid->image->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Grid->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_image" id= "fn_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_image" id= "fa_x<?= $Grid->RowIndex ?>_image" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $rowIndex ?>_teachers_packages_image" class="el_teachers_packages_image">
<div id="fd_x<?= $Grid->RowIndex ?>_image">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_image"
        name="x<?= $Grid->RowIndex ?>_image"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="teachers_packages"
        data-field="x_image"
        data-size="65535"
        data-accept-file-types="<?= $Grid->image->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->image->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->image->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->image->editAttributes() ?>
    >
</div>
<div class="invalid-feedback"><?= $Grid->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_image" id= "fn_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_image" id= "fa_x<?= $Grid->RowIndex ?>_image" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_image" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_image" id="o<?= $Grid->RowIndex ?>_image" value="<?= HtmlEncode($Grid->image->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_image" class="el_teachers_packages_image">
<span<?= $Grid->image->viewAttributes() ?>>
<?= GetFileViewTag($Grid->image, $Grid->image->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_image" class="el_teachers_packages_image">
<div id="fd_x<?= $Grid->RowIndex ?>_image">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_image"
        name="x<?= $Grid->RowIndex ?>_image"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="teachers_packages"
        data-field="x_image"
        data-size="65535"
        data-accept-file-types="<?= $Grid->image->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->image->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->image->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->image->editAttributes() ?>
    >
</div>
<div class="invalid-feedback"><?= $Grid->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_image" id= "fn_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_image" id= "fa_x<?= $Grid->RowIndex ?>_image" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_image") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_image" class="el_teachers_packages_image">
<div id="fd_x<?= $Grid->RowIndex ?>_image">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_image"
        name="x<?= $Grid->RowIndex ?>_image"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="teachers_packages"
        data-field="x_image"
        data-size="65535"
        data-accept-file-types="<?= $Grid->image->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->image->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->image->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->image->editAttributes() ?>
    >
</div>
<div class="invalid-feedback"><?= $Grid->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_image" id= "fn_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_image" id= "fa_x<?= $Grid->RowIndex ?>_image" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_image") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fees->Visible) { // fees ?>
        <td data-name="fees"<?= $Grid->fees->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_fees" class="el_teachers_packages_fees">
<input type="<?= $Grid->fees->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fees" id="x<?= $Grid->RowIndex ?>_fees" data-table="teachers_packages" data-field="x_fees" value="<?= $Grid->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fees->formatPattern()) ?>"<?= $Grid->fees->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fees->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_fees" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fees" id="o<?= $Grid->RowIndex ?>_fees" value="<?= HtmlEncode($Grid->fees->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_fees" class="el_teachers_packages_fees">
<input type="<?= $Grid->fees->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fees" id="x<?= $Grid->RowIndex ?>_fees" data-table="teachers_packages" data-field="x_fees" value="<?= $Grid->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fees->formatPattern()) ?>"<?= $Grid->fees->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fees->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_fees" class="el_teachers_packages_fees">
<span<?= $Grid->fees->viewAttributes() ?>>
<?= $Grid->fees->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_fees" data-hidden="1" name="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_fees" id="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_fees" value="<?= HtmlEncode($Grid->fees->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_fees" data-hidden="1" data-old name="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_fees" id="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_fees" value="<?= HtmlEncode($Grid->fees->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->currency_id->Visible) { // currency_id ?>
        <td data-name="currency_id"<?= $Grid->currency_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_currency_id" class="el_teachers_packages_currency_id">
<?php
if (IsRTL()) {
    $Grid->currency_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_currency_id" class="ew-auto-suggest">
    <input type="<?= $Grid->currency_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_currency_id" id="sv_x<?= $Grid->RowIndex ?>_currency_id" value="<?= RemoveHtml($Grid->currency_id->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Grid->currency_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->currency_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->currency_id->formatPattern()) ?>"<?= $Grid->currency_id->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="teachers_packages" data-field="x_currency_id" data-input="sv_x<?= $Grid->RowIndex ?>_currency_id" data-value-separator="<?= $Grid->currency_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_currency_id" id="x<?= $Grid->RowIndex ?>_currency_id" value="<?= HtmlEncode($Grid->currency_id->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->currency_id->getErrorMessage() ?></div>
<script>
loadjs.ready("fteachers_packagesgrid", function() {
    fteachers_packagesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_currency_id","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->currency_id->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.teachers_packages.fields.currency_id.autoSuggestOptions));
});
</script>
<?= $Grid->currency_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_currency_id") ?>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_currency_id" id="o<?= $Grid->RowIndex ?>_currency_id" value="<?= HtmlEncode($Grid->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_currency_id" class="el_teachers_packages_currency_id">
<?php
if (IsRTL()) {
    $Grid->currency_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_currency_id" class="ew-auto-suggest">
    <input type="<?= $Grid->currency_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_currency_id" id="sv_x<?= $Grid->RowIndex ?>_currency_id" value="<?= RemoveHtml($Grid->currency_id->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Grid->currency_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->currency_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->currency_id->formatPattern()) ?>"<?= $Grid->currency_id->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="teachers_packages" data-field="x_currency_id" data-input="sv_x<?= $Grid->RowIndex ?>_currency_id" data-value-separator="<?= $Grid->currency_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_currency_id" id="x<?= $Grid->RowIndex ?>_currency_id" value="<?= HtmlEncode($Grid->currency_id->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->currency_id->getErrorMessage() ?></div>
<script>
loadjs.ready("fteachers_packagesgrid", function() {
    fteachers_packagesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_currency_id","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->currency_id->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.teachers_packages.fields.currency_id.autoSuggestOptions));
});
</script>
<?= $Grid->currency_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_currency_id") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_currency_id" class="el_teachers_packages_currency_id">
<span<?= $Grid->currency_id->viewAttributes() ?>>
<?= $Grid->currency_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" data-hidden="1" name="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_currency_id" id="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_currency_id" value="<?= HtmlEncode($Grid->currency_id->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" data-hidden="1" data-old name="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_currency_id" id="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_currency_id" value="<?= HtmlEncode($Grid->currency_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at"<?= $Grid->created_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_created_at" class="el_teachers_packages_created_at">
<input type="<?= $Grid->created_at->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" data-table="teachers_packages" data-field="x_created_at" value="<?= $Grid->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->created_at->formatPattern()) ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_created_at" class="el_teachers_packages_created_at">
<input type="<?= $Grid->created_at->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" data-table="teachers_packages" data-field="x_created_at" value="<?= $Grid->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->created_at->formatPattern()) ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_teachers_packages_created_at" class="el_teachers_packages_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<?= $Grid->created_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" data-hidden="1" name="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_created_at" id="fteachers_packagesgrid$x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" data-hidden="1" data-old name="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_created_at" id="fteachers_packagesgrid$o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
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
loadjs.ready(["fteachers_packagesgrid","load"], () => fteachers_packagesgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fteachers_packagesgrid">
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
    ew.addEventHandlers("teachers_packages");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
