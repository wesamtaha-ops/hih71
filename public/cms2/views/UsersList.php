<?php

namespace PHPMaker2023\hih71;

// Page object
$UsersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
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
            ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
            ["phone", [fields.phone.visible && fields.phone.required ? ew.Validators.required(fields.phone.caption) : null], fields.phone.isInvalid],
            ["gender", [fields.gender.visible && fields.gender.required ? ew.Validators.required(fields.gender.caption) : null], fields.gender.isInvalid],
            ["birthday", [fields.birthday.visible && fields.birthday.required ? ew.Validators.required(fields.birthday.caption) : null, ew.Validators.datetime(fields.birthday.clientFormatPattern)], fields.birthday.isInvalid],
            ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid],
            ["country_id", [fields.country_id.visible && fields.country_id.required ? ew.Validators.required(fields.country_id.caption) : null], fields.country_id.isInvalid],
            ["city", [fields.city.visible && fields.city.required ? ew.Validators.required(fields.city.caption) : null], fields.city.isInvalid],
            ["currency_id", [fields.currency_id.visible && fields.currency_id.required ? ew.Validators.required(fields.currency_id.caption) : null], fields.currency_id.isInvalid],
            ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null], fields.type.isInvalid],
            ["is_verified", [fields.is_verified.visible && fields.is_verified.required ? ew.Validators.required(fields.is_verified.caption) : null], fields.is_verified.isInvalid],
            ["is_approved", [fields.is_approved.visible && fields.is_approved.required ? ew.Validators.required(fields.is_approved.caption) : null], fields.is_approved.isInvalid],
            ["is_blocked", [fields.is_blocked.visible && fields.is_blocked.required ? ew.Validators.required(fields.is_blocked.caption) : null], fields.is_blocked.isInvalid],
            ["otp", [fields.otp.visible && fields.otp.required ? ew.Validators.required(fields.otp.caption) : null], fields.otp.isInvalid],
            ["slug", [fields.slug.visible && fields.slug.required ? ew.Validators.required(fields.slug.caption) : null], fields.slug.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["name",false],["_email",false],["phone",false],["gender",false],["birthday",false],["image",false],["country_id",false],["city",false],["currency_id",false],["type",false],["is_verified",true],["is_approved",true],["is_blocked",true],["otp",false],["slug",false]];
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
            "gender": <?= $Page->gender->toClientList($Page) ?>,
            "country_id": <?= $Page->country_id->toClientList($Page) ?>,
            "currency_id": <?= $Page->currency_id->toClientList($Page) ?>,
            "type": <?= $Page->type->toClientList($Page) ?>,
            "is_verified": <?= $Page->is_verified->toClientList($Page) ?>,
            "is_approved": <?= $Page->is_approved->toClientList($Page) ?>,
            "is_blocked": <?= $Page->is_blocked->toClientList($Page) ?>,
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
<form name="fuserssrch" id="fuserssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="fuserssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentForm;
var fuserssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fuserssrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["id", [], fields.id.isInvalid],
            ["name", [], fields.name.isInvalid],
            ["_email", [], fields._email.isInvalid],
            ["phone", [], fields.phone.isInvalid],
            ["gender", [], fields.gender.isInvalid],
            ["birthday", [], fields.birthday.isInvalid],
            ["image", [], fields.image.isInvalid],
            ["country_id", [], fields.country_id.isInvalid],
            ["city", [], fields.city.isInvalid],
            ["currency_id", [], fields.currency_id.isInvalid],
            ["type", [], fields.type.isInvalid],
            ["is_verified", [], fields.is_verified.isInvalid],
            ["is_approved", [], fields.is_approved.isInvalid],
            ["is_blocked", [], fields.is_blocked.isInvalid],
            ["otp", [], fields.otp.isInvalid],
            ["slug", [], fields.slug.isInvalid]
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
            "gender": <?= $Page->gender->toClientList($Page) ?>,
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
<?php if ($Page->gender->Visible) { // gender ?>
<?php
if (!$Page->gender->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_gender" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->gender->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_gender" class="ew-search-caption ew-label"><?= $Page->gender->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_gender" id="z_gender" value="=">
</div>
        </div>
        <div id="el_users_gender" class="ew-search-field">
    <select
        id="x_gender"
        name="x_gender"
        class="form-select ew-select<?= $Page->gender->isInvalidClass() ?>"
        <?php if (!$Page->gender->IsNativeSelect) { ?>
        data-select2-id="fuserssrch_x_gender"
        <?php } ?>
        data-table="users"
        data-field="x_gender"
        data-value-separator="<?= $Page->gender->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->gender->getPlaceHolder()) ?>"
        <?= $Page->gender->editAttributes() ?>>
        <?= $Page->gender->selectOptionListHtml("x_gender") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->gender->getErrorMessage(false) ?></div>
<?php if (!$Page->gender->IsNativeSelect) { ?>
<script>
loadjs.ready("fuserssrch", function() {
    var options = { name: "x_gender", selectId: "fuserssrch_x_gender" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserssrch.lists.gender?.lookupOptions.length) {
        options.data = { id: "x_gender", form: "fuserssrch" };
    } else {
        options.ajax = { id: "x_gender", form: "fuserssrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.gender.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
        <div id="el_users_type" class="ew-search-field">
<template id="tp_x_type">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_type" name="x_type" id="x_type"<?= $Page->type->editAttributes() ?>>
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
    data-table="users"
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fuserssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fuserssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fuserssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fuserssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="users">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_users" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_userslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_users_id" class="users_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div id="elh_users_name" class="users_name"><?= $Page->renderFieldHeader($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Page->_email->headerCellClass() ?>"><div id="elh_users__email" class="users__email"><?= $Page->renderFieldHeader($Page->_email) ?></div></th>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
        <th data-name="phone" class="<?= $Page->phone->headerCellClass() ?>"><div id="elh_users_phone" class="users_phone"><?= $Page->renderFieldHeader($Page->phone) ?></div></th>
<?php } ?>
<?php if ($Page->gender->Visible) { // gender ?>
        <th data-name="gender" class="<?= $Page->gender->headerCellClass() ?>"><div id="elh_users_gender" class="users_gender"><?= $Page->renderFieldHeader($Page->gender) ?></div></th>
<?php } ?>
<?php if ($Page->birthday->Visible) { // birthday ?>
        <th data-name="birthday" class="<?= $Page->birthday->headerCellClass() ?>"><div id="elh_users_birthday" class="users_birthday"><?= $Page->renderFieldHeader($Page->birthday) ?></div></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th data-name="image" class="<?= $Page->image->headerCellClass() ?>"><div id="elh_users_image" class="users_image"><?= $Page->renderFieldHeader($Page->image) ?></div></th>
<?php } ?>
<?php if ($Page->country_id->Visible) { // country_id ?>
        <th data-name="country_id" class="<?= $Page->country_id->headerCellClass() ?>"><div id="elh_users_country_id" class="users_country_id"><?= $Page->renderFieldHeader($Page->country_id) ?></div></th>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
        <th data-name="city" class="<?= $Page->city->headerCellClass() ?>"><div id="elh_users_city" class="users_city"><?= $Page->renderFieldHeader($Page->city) ?></div></th>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
        <th data-name="currency_id" class="<?= $Page->currency_id->headerCellClass() ?>"><div id="elh_users_currency_id" class="users_currency_id"><?= $Page->renderFieldHeader($Page->currency_id) ?></div></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th data-name="type" class="<?= $Page->type->headerCellClass() ?>"><div id="elh_users_type" class="users_type"><?= $Page->renderFieldHeader($Page->type) ?></div></th>
<?php } ?>
<?php if ($Page->is_verified->Visible) { // is_verified ?>
        <th data-name="is_verified" class="<?= $Page->is_verified->headerCellClass() ?>"><div id="elh_users_is_verified" class="users_is_verified"><?= $Page->renderFieldHeader($Page->is_verified) ?></div></th>
<?php } ?>
<?php if ($Page->is_approved->Visible) { // is_approved ?>
        <th data-name="is_approved" class="<?= $Page->is_approved->headerCellClass() ?>"><div id="elh_users_is_approved" class="users_is_approved"><?= $Page->renderFieldHeader($Page->is_approved) ?></div></th>
<?php } ?>
<?php if ($Page->is_blocked->Visible) { // is_blocked ?>
        <th data-name="is_blocked" class="<?= $Page->is_blocked->headerCellClass() ?>"><div id="elh_users_is_blocked" class="users_is_blocked"><?= $Page->renderFieldHeader($Page->is_blocked) ?></div></th>
<?php } ?>
<?php if ($Page->otp->Visible) { // otp ?>
        <th data-name="otp" class="<?= $Page->otp->headerCellClass() ?>"><div id="elh_users_otp" class="users_otp"><?= $Page->renderFieldHeader($Page->otp) ?></div></th>
<?php } ?>
<?php if ($Page->slug->Visible) { // slug ?>
        <th data-name="slug" class="<?= $Page->slug->headerCellClass() ?>"><div id="elh_users_slug" class="users_slug"><?= $Page->renderFieldHeader($Page->slug) ?></div></th>
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
<span id="el<?= $Page->RowCount ?>_users_id" class="el_users_id"></span>
<input type="hidden" data-table="users" data-field="x_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_id" class="el_users_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_id" class="el_users_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="users" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_name" class="el_users_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_name" id="x<?= $Page->RowIndex ?>_name" data-table="users" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name->formatPattern()) ?>"<?= $Page->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_name" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_name" id="o<?= $Page->RowIndex ?>_name" value="<?= HtmlEncode($Page->name->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_name" class="el_users_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_name" id="x<?= $Page->RowIndex ?>_name" data-table="users" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name->formatPattern()) ?>"<?= $Page->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_name" class="el_users_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users__email" class="el_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" data-table="users" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x__email" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>__email" id="o<?= $Page->RowIndex ?>__email" value="<?= HtmlEncode($Page->_email->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users__email" class="el_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" data-table="users" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users__email" class="el_users__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->phone->Visible) { // phone ?>
        <td data-name="phone"<?= $Page->phone->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_phone" class="el_users_phone">
<input type="<?= $Page->phone->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_phone" id="x<?= $Page->RowIndex ?>_phone" data-table="users" data-field="x_phone" value="<?= $Page->phone->EditValue ?>" placeholder="<?= HtmlEncode($Page->phone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->phone->formatPattern()) ?>"<?= $Page->phone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->phone->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_phone" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_phone" id="o<?= $Page->RowIndex ?>_phone" value="<?= HtmlEncode($Page->phone->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_phone" class="el_users_phone">
<input type="<?= $Page->phone->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_phone" id="x<?= $Page->RowIndex ?>_phone" data-table="users" data-field="x_phone" value="<?= $Page->phone->EditValue ?>" placeholder="<?= HtmlEncode($Page->phone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->phone->formatPattern()) ?>"<?= $Page->phone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->phone->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_phone" class="el_users_phone">
<span<?= $Page->phone->viewAttributes() ?>>
<?= $Page->phone->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->gender->Visible) { // gender ?>
        <td data-name="gender"<?= $Page->gender->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_gender" class="el_users_gender">
    <select
        id="x<?= $Page->RowIndex ?>_gender"
        name="x<?= $Page->RowIndex ?>_gender"
        class="form-select ew-select<?= $Page->gender->isInvalidClass() ?>"
        <?php if (!$Page->gender->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_gender"
        <?php } ?>
        data-table="users"
        data-field="x_gender"
        data-value-separator="<?= $Page->gender->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->gender->getPlaceHolder()) ?>"
        <?= $Page->gender->editAttributes() ?>>
        <?= $Page->gender->selectOptionListHtml("x{$Page->RowIndex}_gender") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->gender->getErrorMessage() ?></div>
<?php if (!$Page->gender->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_gender", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_gender" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.gender?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_gender", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_gender", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.gender.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="users" data-field="x_gender" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_gender" id="o<?= $Page->RowIndex ?>_gender" value="<?= HtmlEncode($Page->gender->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_gender" class="el_users_gender">
    <select
        id="x<?= $Page->RowIndex ?>_gender"
        name="x<?= $Page->RowIndex ?>_gender"
        class="form-select ew-select<?= $Page->gender->isInvalidClass() ?>"
        <?php if (!$Page->gender->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_gender"
        <?php } ?>
        data-table="users"
        data-field="x_gender"
        data-value-separator="<?= $Page->gender->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->gender->getPlaceHolder()) ?>"
        <?= $Page->gender->editAttributes() ?>>
        <?= $Page->gender->selectOptionListHtml("x{$Page->RowIndex}_gender") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->gender->getErrorMessage() ?></div>
<?php if (!$Page->gender->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_gender", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_gender" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.gender?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_gender", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_gender", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.gender.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_gender" class="el_users_gender">
<span<?= $Page->gender->viewAttributes() ?>>
<?= $Page->gender->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->birthday->Visible) { // birthday ?>
        <td data-name="birthday"<?= $Page->birthday->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_birthday" class="el_users_birthday">
<input type="<?= $Page->birthday->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_birthday" id="x<?= $Page->RowIndex ?>_birthday" data-table="users" data-field="x_birthday" value="<?= $Page->birthday->EditValue ?>" placeholder="<?= HtmlEncode($Page->birthday->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->birthday->formatPattern()) ?>"<?= $Page->birthday->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->birthday->getErrorMessage() ?></div>
<?php if (!$Page->birthday->ReadOnly && !$Page->birthday->Disabled && !isset($Page->birthday->EditAttrs["readonly"]) && !isset($Page->birthday->EditAttrs["disabled"])) { ?>
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
    ew.createDateTimePicker("<?= $Page->FormName ?>", "x<?= $Page->RowIndex ?>_birthday", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="users" data-field="x_birthday" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_birthday" id="o<?= $Page->RowIndex ?>_birthday" value="<?= HtmlEncode($Page->birthday->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_birthday" class="el_users_birthday">
<input type="<?= $Page->birthday->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_birthday" id="x<?= $Page->RowIndex ?>_birthday" data-table="users" data-field="x_birthday" value="<?= $Page->birthday->EditValue ?>" placeholder="<?= HtmlEncode($Page->birthday->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->birthday->formatPattern()) ?>"<?= $Page->birthday->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->birthday->getErrorMessage() ?></div>
<?php if (!$Page->birthday->ReadOnly && !$Page->birthday->Disabled && !isset($Page->birthday->EditAttrs["readonly"]) && !isset($Page->birthday->EditAttrs["disabled"])) { ?>
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
    ew.createDateTimePicker("<?= $Page->FormName ?>", "x<?= $Page->RowIndex ?>_birthday", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_birthday" class="el_users_birthday">
<span<?= $Page->birthday->viewAttributes() ?>>
<?= $Page->birthday->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->image->Visible) { // image ?>
        <td data-name="image"<?= $Page->image->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_image" class="el_users_image">
<div id="fd_x<?= $Page->RowIndex ?>_image" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_image"
        name="x<?= $Page->RowIndex ?>_image"
        class="form-control ew-file-input"
        title="<?= $Page->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="users"
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
<input type="hidden" data-table="users" data-field="x_image" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_image" id="o<?= $Page->RowIndex ?>_image" value="<?= HtmlEncode($Page->image->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_image" class="el_users_image">
<div id="fd_x<?= $Page->RowIndex ?>_image" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_image"
        name="x<?= $Page->RowIndex ?>_image"
        class="form-control ew-file-input"
        title="<?= $Page->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="users"
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
<span id="el<?= $Page->RowCount ?>_users_image" class="el_users_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->country_id->Visible) { // country_id ?>
        <td data-name="country_id"<?= $Page->country_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_country_id" class="el_users_country_id">
    <select
        id="x<?= $Page->RowIndex ?>_country_id"
        name="x<?= $Page->RowIndex ?>_country_id"
        class="form-select ew-select<?= $Page->country_id->isInvalidClass() ?>"
        <?php if (!$Page->country_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_country_id"
        <?php } ?>
        data-table="users"
        data-field="x_country_id"
        data-value-separator="<?= $Page->country_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->country_id->getPlaceHolder()) ?>"
        <?= $Page->country_id->editAttributes() ?>>
        <?= $Page->country_id->selectOptionListHtml("x{$Page->RowIndex}_country_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->country_id->getErrorMessage() ?></div>
<?= $Page->country_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_country_id") ?>
<?php if (!$Page->country_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_country_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_country_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.country_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_country_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_country_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.country_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="users" data-field="x_country_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_country_id" id="o<?= $Page->RowIndex ?>_country_id" value="<?= HtmlEncode($Page->country_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_country_id" class="el_users_country_id">
    <select
        id="x<?= $Page->RowIndex ?>_country_id"
        name="x<?= $Page->RowIndex ?>_country_id"
        class="form-select ew-select<?= $Page->country_id->isInvalidClass() ?>"
        <?php if (!$Page->country_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_country_id"
        <?php } ?>
        data-table="users"
        data-field="x_country_id"
        data-value-separator="<?= $Page->country_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->country_id->getPlaceHolder()) ?>"
        <?= $Page->country_id->editAttributes() ?>>
        <?= $Page->country_id->selectOptionListHtml("x{$Page->RowIndex}_country_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->country_id->getErrorMessage() ?></div>
<?= $Page->country_id->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_country_id") ?>
<?php if (!$Page->country_id->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_country_id", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_country_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.country_id?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_country_id", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_country_id", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.country_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_country_id" class="el_users_country_id">
<span<?= $Page->country_id->viewAttributes() ?>>
<?= $Page->country_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->city->Visible) { // city ?>
        <td data-name="city"<?= $Page->city->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_city" class="el_users_city">
<input type="<?= $Page->city->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_city" id="x<?= $Page->RowIndex ?>_city" data-table="users" data-field="x_city" value="<?= $Page->city->EditValue ?>" placeholder="<?= HtmlEncode($Page->city->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->city->formatPattern()) ?>"<?= $Page->city->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->city->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_city" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_city" id="o<?= $Page->RowIndex ?>_city" value="<?= HtmlEncode($Page->city->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_city" class="el_users_city">
<input type="<?= $Page->city->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_city" id="x<?= $Page->RowIndex ?>_city" data-table="users" data-field="x_city" value="<?= $Page->city->EditValue ?>" placeholder="<?= HtmlEncode($Page->city->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->city->formatPattern()) ?>"<?= $Page->city->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->city->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_city" class="el_users_city">
<span<?= $Page->city->viewAttributes() ?>>
<?= $Page->city->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->currency_id->Visible) { // currency_id ?>
        <td data-name="currency_id"<?= $Page->currency_id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_currency_id" class="el_users_currency_id">
    <select
        id="x<?= $Page->RowIndex ?>_currency_id"
        name="x<?= $Page->RowIndex ?>_currency_id"
        class="form-select ew-select<?= $Page->currency_id->isInvalidClass() ?>"
        <?php if (!$Page->currency_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_currency_id"
        <?php } ?>
        data-table="users"
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
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.currency_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="users" data-field="x_currency_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_currency_id" id="o<?= $Page->RowIndex ?>_currency_id" value="<?= HtmlEncode($Page->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_currency_id" class="el_users_currency_id">
    <select
        id="x<?= $Page->RowIndex ?>_currency_id"
        name="x<?= $Page->RowIndex ?>_currency_id"
        class="form-select ew-select<?= $Page->currency_id->isInvalidClass() ?>"
        <?php if (!$Page->currency_id->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_currency_id"
        <?php } ?>
        data-table="users"
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
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.currency_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_currency_id" class="el_users_currency_id">
<span<?= $Page->currency_id->viewAttributes() ?>>
<?= $Page->currency_id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->type->Visible) { // type ?>
        <td data-name="type"<?= $Page->type->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_type" class="el_users_type">
<template id="tp_x<?= $Page->RowIndex ?>_type">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_type" name="x<?= $Page->RowIndex ?>_type" id="x<?= $Page->RowIndex ?>_type"<?= $Page->type->editAttributes() ?>>
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
    data-table="users"
    data-field="x_type"
    data-value-separator="<?= $Page->type->displayValueSeparatorAttribute() ?>"
    <?= $Page->type->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_type" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_type" id="o<?= $Page->RowIndex ?>_type" value="<?= HtmlEncode($Page->type->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_type" class="el_users_type">
<template id="tp_x<?= $Page->RowIndex ?>_type">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_type" name="x<?= $Page->RowIndex ?>_type" id="x<?= $Page->RowIndex ?>_type"<?= $Page->type->editAttributes() ?>>
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
    data-table="users"
    data-field="x_type"
    data-value-separator="<?= $Page->type->displayValueSeparatorAttribute() ?>"
    <?= $Page->type->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_type" class="el_users_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->is_verified->Visible) { // is_verified ?>
        <td data-name="is_verified"<?= $Page->is_verified->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_is_verified" class="el_users_is_verified">
<template id="tp_x<?= $Page->RowIndex ?>_is_verified">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_is_verified" name="x<?= $Page->RowIndex ?>_is_verified" id="x<?= $Page->RowIndex ?>_is_verified"<?= $Page->is_verified->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_is_verified" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_is_verified"
    name="x<?= $Page->RowIndex ?>_is_verified"
    value="<?= HtmlEncode($Page->is_verified->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_is_verified"
    data-target="dsl_x<?= $Page->RowIndex ?>_is_verified"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_verified->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_verified"
    data-value-separator="<?= $Page->is_verified->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_verified->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->is_verified->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_is_verified" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_is_verified" id="o<?= $Page->RowIndex ?>_is_verified" value="<?= HtmlEncode($Page->is_verified->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_is_verified" class="el_users_is_verified">
<template id="tp_x<?= $Page->RowIndex ?>_is_verified">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_is_verified" name="x<?= $Page->RowIndex ?>_is_verified" id="x<?= $Page->RowIndex ?>_is_verified"<?= $Page->is_verified->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_is_verified" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_is_verified"
    name="x<?= $Page->RowIndex ?>_is_verified"
    value="<?= HtmlEncode($Page->is_verified->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_is_verified"
    data-target="dsl_x<?= $Page->RowIndex ?>_is_verified"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_verified->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_verified"
    data-value-separator="<?= $Page->is_verified->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_verified->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->is_verified->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_is_verified" class="el_users_is_verified">
<span<?= $Page->is_verified->viewAttributes() ?>>
<?= $Page->is_verified->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->is_approved->Visible) { // is_approved ?>
        <td data-name="is_approved"<?= $Page->is_approved->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_is_approved" class="el_users_is_approved">
<template id="tp_x<?= $Page->RowIndex ?>_is_approved">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_is_approved" name="x<?= $Page->RowIndex ?>_is_approved" id="x<?= $Page->RowIndex ?>_is_approved"<?= $Page->is_approved->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_is_approved" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_is_approved"
    name="x<?= $Page->RowIndex ?>_is_approved"
    value="<?= HtmlEncode($Page->is_approved->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_is_approved"
    data-target="dsl_x<?= $Page->RowIndex ?>_is_approved"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_approved->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_approved"
    data-value-separator="<?= $Page->is_approved->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_approved->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->is_approved->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_is_approved" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_is_approved" id="o<?= $Page->RowIndex ?>_is_approved" value="<?= HtmlEncode($Page->is_approved->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_is_approved" class="el_users_is_approved">
<template id="tp_x<?= $Page->RowIndex ?>_is_approved">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_is_approved" name="x<?= $Page->RowIndex ?>_is_approved" id="x<?= $Page->RowIndex ?>_is_approved"<?= $Page->is_approved->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_is_approved" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_is_approved"
    name="x<?= $Page->RowIndex ?>_is_approved"
    value="<?= HtmlEncode($Page->is_approved->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_is_approved"
    data-target="dsl_x<?= $Page->RowIndex ?>_is_approved"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_approved->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_approved"
    data-value-separator="<?= $Page->is_approved->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_approved->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->is_approved->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_is_approved" class="el_users_is_approved">
<span<?= $Page->is_approved->viewAttributes() ?>>
<?= $Page->is_approved->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->is_blocked->Visible) { // is_blocked ?>
        <td data-name="is_blocked"<?= $Page->is_blocked->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_is_blocked" class="el_users_is_blocked">
<template id="tp_x<?= $Page->RowIndex ?>_is_blocked">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_is_blocked" name="x<?= $Page->RowIndex ?>_is_blocked" id="x<?= $Page->RowIndex ?>_is_blocked"<?= $Page->is_blocked->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_is_blocked" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_is_blocked"
    name="x<?= $Page->RowIndex ?>_is_blocked"
    value="<?= HtmlEncode($Page->is_blocked->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_is_blocked"
    data-target="dsl_x<?= $Page->RowIndex ?>_is_blocked"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_blocked->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_blocked"
    data-value-separator="<?= $Page->is_blocked->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_blocked->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->is_blocked->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_is_blocked" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_is_blocked" id="o<?= $Page->RowIndex ?>_is_blocked" value="<?= HtmlEncode($Page->is_blocked->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_is_blocked" class="el_users_is_blocked">
<template id="tp_x<?= $Page->RowIndex ?>_is_blocked">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_is_blocked" name="x<?= $Page->RowIndex ?>_is_blocked" id="x<?= $Page->RowIndex ?>_is_blocked"<?= $Page->is_blocked->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_is_blocked" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_is_blocked"
    name="x<?= $Page->RowIndex ?>_is_blocked"
    value="<?= HtmlEncode($Page->is_blocked->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_is_blocked"
    data-target="dsl_x<?= $Page->RowIndex ?>_is_blocked"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_blocked->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_blocked"
    data-value-separator="<?= $Page->is_blocked->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_blocked->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->is_blocked->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_is_blocked" class="el_users_is_blocked">
<span<?= $Page->is_blocked->viewAttributes() ?>>
<?= $Page->is_blocked->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->otp->Visible) { // otp ?>
        <td data-name="otp"<?= $Page->otp->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_otp" class="el_users_otp">
<input type="<?= $Page->otp->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_otp" id="x<?= $Page->RowIndex ?>_otp" data-table="users" data-field="x_otp" value="<?= $Page->otp->EditValue ?>" placeholder="<?= HtmlEncode($Page->otp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->otp->formatPattern()) ?>"<?= $Page->otp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->otp->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_otp" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_otp" id="o<?= $Page->RowIndex ?>_otp" value="<?= HtmlEncode($Page->otp->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_otp" class="el_users_otp">
<input type="<?= $Page->otp->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_otp" id="x<?= $Page->RowIndex ?>_otp" data-table="users" data-field="x_otp" value="<?= $Page->otp->EditValue ?>" placeholder="<?= HtmlEncode($Page->otp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->otp->formatPattern()) ?>"<?= $Page->otp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->otp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_otp" class="el_users_otp">
<span<?= $Page->otp->viewAttributes() ?>>
<?= $Page->otp->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->slug->Visible) { // slug ?>
        <td data-name="slug"<?= $Page->slug->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_slug" class="el_users_slug">
<input type="<?= $Page->slug->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_slug" id="x<?= $Page->RowIndex ?>_slug" data-table="users" data-field="x_slug" value="<?= $Page->slug->EditValue ?>" placeholder="<?= HtmlEncode($Page->slug->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->slug->formatPattern()) ?>"<?= $Page->slug->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->slug->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_slug" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_slug" id="o<?= $Page->RowIndex ?>_slug" value="<?= HtmlEncode($Page->slug->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_slug" class="el_users_slug">
<input type="<?= $Page->slug->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_slug" id="x<?= $Page->RowIndex ?>_slug" data-table="users" data-field="x_slug" value="<?= $Page->slug->EditValue ?>" placeholder="<?= HtmlEncode($Page->slug->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->slug->formatPattern()) ?>"<?= $Page->slug->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->slug->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_slug" class="el_users_slug">
<span<?= $Page->slug->viewAttributes() ?>>
<?= $Page->slug->getViewValue() ?></span>
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
    ew.addEventHandlers("users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
