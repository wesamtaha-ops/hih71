<?php

namespace PHPMaker2023\hih71;

// Page object
$TeachersPackagesAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { teachers_packages: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fteachers_packagesadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fteachers_packagesadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["teacher_id", [fields.teacher_id.visible && fields.teacher_id.required ? ew.Validators.required(fields.teacher_id.caption) : null], fields.teacher_id.isInvalid],
            ["title_en", [fields.title_en.visible && fields.title_en.required ? ew.Validators.required(fields.title_en.caption) : null], fields.title_en.isInvalid],
            ["title_ar", [fields.title_ar.visible && fields.title_ar.required ? ew.Validators.required(fields.title_ar.caption) : null], fields.title_ar.isInvalid],
            ["description_en", [fields.description_en.visible && fields.description_en.required ? ew.Validators.required(fields.description_en.caption) : null], fields.description_en.isInvalid],
            ["description_ar", [fields.description_ar.visible && fields.description_ar.required ? ew.Validators.required(fields.description_ar.caption) : null], fields.description_ar.isInvalid],
            ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid],
            ["fees", [fields.fees.visible && fields.fees.required ? ew.Validators.required(fields.fees.caption) : null, ew.Validators.integer], fields.fees.isInvalid],
            ["currency_id", [fields.currency_id.visible && fields.currency_id.required ? ew.Validators.required(fields.currency_id.caption) : null, ew.Validators.integer], fields.currency_id.isInvalid]
        ])

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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fteachers_packagesadd" id="fteachers_packagesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="teachers_packages">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->teacher_id->Visible) { // teacher_id ?>
    <div id="r_teacher_id"<?= $Page->teacher_id->rowAttributes() ?>>
        <label id="elh_teachers_packages_teacher_id" for="x_teacher_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->teacher_id->caption() ?><?= $Page->teacher_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->teacher_id->cellAttributes() ?>>
<span id="el_teachers_packages_teacher_id">
    <select
        id="x_teacher_id"
        name="x_teacher_id"
        class="form-select ew-select<?= $Page->teacher_id->isInvalidClass() ?>"
        <?php if (!$Page->teacher_id->IsNativeSelect) { ?>
        data-select2-id="fteachers_packagesadd_x_teacher_id"
        <?php } ?>
        data-table="teachers_packages"
        data-field="x_teacher_id"
        data-value-separator="<?= $Page->teacher_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->teacher_id->getPlaceHolder()) ?>"
        <?= $Page->teacher_id->editAttributes() ?>>
        <?= $Page->teacher_id->selectOptionListHtml("x_teacher_id") ?>
    </select>
    <?= $Page->teacher_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->teacher_id->getErrorMessage() ?></div>
<?= $Page->teacher_id->Lookup->getParamTag($Page, "p_x_teacher_id") ?>
<?php if (!$Page->teacher_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fteachers_packagesadd", function() {
    var options = { name: "x_teacher_id", selectId: "fteachers_packagesadd_x_teacher_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fteachers_packagesadd.lists.teacher_id?.lookupOptions.length) {
        options.data = { id: "x_teacher_id", form: "fteachers_packagesadd" };
    } else {
        options.ajax = { id: "x_teacher_id", form: "fteachers_packagesadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.teachers_packages.fields.teacher_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
    <div id="r_title_en"<?= $Page->title_en->rowAttributes() ?>>
        <label id="elh_teachers_packages_title_en" for="x_title_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->title_en->caption() ?><?= $Page->title_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->title_en->cellAttributes() ?>>
<span id="el_teachers_packages_title_en">
<input type="<?= $Page->title_en->getInputTextType() ?>" name="x_title_en" id="x_title_en" data-table="teachers_packages" data-field="x_title_en" value="<?= $Page->title_en->EditValue ?>" placeholder="<?= HtmlEncode($Page->title_en->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->title_en->formatPattern()) ?>"<?= $Page->title_en->editAttributes() ?> aria-describedby="x_title_en_help">
<?= $Page->title_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->title_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->title_ar->Visible) { // title_ar ?>
    <div id="r_title_ar"<?= $Page->title_ar->rowAttributes() ?>>
        <label id="elh_teachers_packages_title_ar" for="x_title_ar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->title_ar->caption() ?><?= $Page->title_ar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->title_ar->cellAttributes() ?>>
<span id="el_teachers_packages_title_ar">
<input type="<?= $Page->title_ar->getInputTextType() ?>" name="x_title_ar" id="x_title_ar" data-table="teachers_packages" data-field="x_title_ar" value="<?= $Page->title_ar->EditValue ?>" placeholder="<?= HtmlEncode($Page->title_ar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->title_ar->formatPattern()) ?>"<?= $Page->title_ar->editAttributes() ?> aria-describedby="x_title_ar_help">
<?= $Page->title_ar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->title_ar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description_en->Visible) { // description_en ?>
    <div id="r_description_en"<?= $Page->description_en->rowAttributes() ?>>
        <label id="elh_teachers_packages_description_en" for="x_description_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description_en->caption() ?><?= $Page->description_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description_en->cellAttributes() ?>>
<span id="el_teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x_description_en" id="x_description_en" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description_en->getPlaceHolder()) ?>"<?= $Page->description_en->editAttributes() ?> aria-describedby="x_description_en_help"><?= $Page->description_en->EditValue ?></textarea>
<?= $Page->description_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description_ar->Visible) { // description_ar ?>
    <div id="r_description_ar"<?= $Page->description_ar->rowAttributes() ?>>
        <label id="elh_teachers_packages_description_ar" for="x_description_ar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description_ar->caption() ?><?= $Page->description_ar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description_ar->cellAttributes() ?>>
<span id="el_teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x_description_ar" id="x_description_ar" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description_ar->getPlaceHolder()) ?>"<?= $Page->description_ar->editAttributes() ?> aria-describedby="x_description_ar_help"><?= $Page->description_ar->EditValue ?></textarea>
<?= $Page->description_ar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description_ar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <div id="r_image"<?= $Page->image->rowAttributes() ?>>
        <label id="elh_teachers_packages_image" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image->caption() ?><?= $Page->image->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->image->cellAttributes() ?>>
<span id="el_teachers_packages_image">
<div id="fd_x_image" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_image"
        name="x_image"
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
        aria-describedby="x_image_help"
        <?= ($Page->image->ReadOnly || $Page->image->Disabled) ? " disabled" : "" ?>
        <?= $Page->image->editAttributes() ?>
    >
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->image->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_image" id= "fn_x_image" value="<?= $Page->image->Upload->FileName ?>">
<input type="hidden" name="fa_x_image" id= "fa_x_image" value="0">
<table id="ft_x_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fees->Visible) { // fees ?>
    <div id="r_fees"<?= $Page->fees->rowAttributes() ?>>
        <label id="elh_teachers_packages_fees" for="x_fees" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fees->caption() ?><?= $Page->fees->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fees->cellAttributes() ?>>
<span id="el_teachers_packages_fees">
<input type="<?= $Page->fees->getInputTextType() ?>" name="x_fees" id="x_fees" data-table="teachers_packages" data-field="x_fees" value="<?= $Page->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fees->formatPattern()) ?>"<?= $Page->fees->editAttributes() ?> aria-describedby="x_fees_help">
<?= $Page->fees->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fees->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
    <div id="r_currency_id"<?= $Page->currency_id->rowAttributes() ?>>
        <label id="elh_teachers_packages_currency_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->currency_id->caption() ?><?= $Page->currency_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->currency_id->cellAttributes() ?>>
<span id="el_teachers_packages_currency_id">
<?php
if (IsRTL()) {
    $Page->currency_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_currency_id" class="ew-auto-suggest">
    <input type="<?= $Page->currency_id->getInputTextType() ?>" class="form-control" name="sv_x_currency_id" id="sv_x_currency_id" value="<?= RemoveHtml($Page->currency_id->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->currency_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->currency_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->currency_id->formatPattern()) ?>"<?= $Page->currency_id->editAttributes() ?> aria-describedby="x_currency_id_help">
</span>
<selection-list hidden class="form-control" data-table="teachers_packages" data-field="x_currency_id" data-input="sv_x_currency_id" data-value-separator="<?= $Page->currency_id->displayValueSeparatorAttribute() ?>" name="x_currency_id" id="x_currency_id" value="<?= HtmlEncode($Page->currency_id->CurrentValue) ?>"></selection-list>
<?= $Page->currency_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->currency_id->getErrorMessage() ?></div>
<script>
loadjs.ready("fteachers_packagesadd", function() {
    fteachers_packagesadd.createAutoSuggest(Object.assign({"id":"x_currency_id","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->currency_id->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.teachers_packages.fields.currency_id.autoSuggestOptions));
});
</script>
<?= $Page->currency_id->Lookup->getParamTag($Page, "p_x_currency_id") ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fteachers_packagesadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fteachers_packagesadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
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
