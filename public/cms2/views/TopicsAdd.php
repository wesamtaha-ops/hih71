<?php

namespace PHPMaker2023\hih71;

// Page object
$TopicsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { topics: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var ftopicsadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftopicsadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["name_ar", [fields.name_ar.visible && fields.name_ar.required ? ew.Validators.required(fields.name_ar.caption) : null], fields.name_ar.isInvalid],
            ["name_en", [fields.name_en.visible && fields.name_en.required ? ew.Validators.required(fields.name_en.caption) : null], fields.name_en.isInvalid],
            ["parent_id", [fields.parent_id.visible && fields.parent_id.required ? ew.Validators.required(fields.parent_id.caption) : null], fields.parent_id.isInvalid],
            ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ftopicsadd" id="ftopicsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="topics">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->name_ar->Visible) { // name_ar ?>
    <div id="r_name_ar"<?= $Page->name_ar->rowAttributes() ?>>
        <label id="elh_topics_name_ar" for="x_name_ar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name_ar->caption() ?><?= $Page->name_ar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name_ar->cellAttributes() ?>>
<span id="el_topics_name_ar">
<input type="<?= $Page->name_ar->getInputTextType() ?>" name="x_name_ar" id="x_name_ar" data-table="topics" data-field="x_name_ar" value="<?= $Page->name_ar->EditValue ?>" placeholder="<?= HtmlEncode($Page->name_ar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name_ar->formatPattern()) ?>"<?= $Page->name_ar->editAttributes() ?> aria-describedby="x_name_ar_help">
<?= $Page->name_ar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name_ar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name_en->Visible) { // name_en ?>
    <div id="r_name_en"<?= $Page->name_en->rowAttributes() ?>>
        <label id="elh_topics_name_en" for="x_name_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name_en->caption() ?><?= $Page->name_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name_en->cellAttributes() ?>>
<span id="el_topics_name_en">
<input type="<?= $Page->name_en->getInputTextType() ?>" name="x_name_en" id="x_name_en" data-table="topics" data-field="x_name_en" value="<?= $Page->name_en->EditValue ?>" placeholder="<?= HtmlEncode($Page->name_en->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name_en->formatPattern()) ?>"<?= $Page->name_en->editAttributes() ?> aria-describedby="x_name_en_help">
<?= $Page->name_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parent_id->Visible) { // parent_id ?>
    <div id="r_parent_id"<?= $Page->parent_id->rowAttributes() ?>>
        <label id="elh_topics_parent_id" for="x_parent_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parent_id->caption() ?><?= $Page->parent_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parent_id->cellAttributes() ?>>
<span id="el_topics_parent_id">
    <select
        id="x_parent_id"
        name="x_parent_id"
        class="form-select ew-select<?= $Page->parent_id->isInvalidClass() ?>"
        <?php if (!$Page->parent_id->IsNativeSelect) { ?>
        data-select2-id="ftopicsadd_x_parent_id"
        <?php } ?>
        data-table="topics"
        data-field="x_parent_id"
        data-value-separator="<?= $Page->parent_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->parent_id->getPlaceHolder()) ?>"
        <?= $Page->parent_id->editAttributes() ?>>
        <?= $Page->parent_id->selectOptionListHtml("x_parent_id") ?>
    </select>
    <?= $Page->parent_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->parent_id->getErrorMessage() ?></div>
<?= $Page->parent_id->Lookup->getParamTag($Page, "p_x_parent_id") ?>
<?php if (!$Page->parent_id->IsNativeSelect) { ?>
<script>
loadjs.ready("ftopicsadd", function() {
    var options = { name: "x_parent_id", selectId: "ftopicsadd_x_parent_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftopicsadd.lists.parent_id?.lookupOptions.length) {
        options.data = { id: "x_parent_id", form: "ftopicsadd" };
    } else {
        options.ajax = { id: "x_parent_id", form: "ftopicsadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.topics.fields.parent_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <div id="r_image"<?= $Page->image->rowAttributes() ?>>
        <label id="elh_topics_image" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image->caption() ?><?= $Page->image->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->image->cellAttributes() ?>>
<span id="el_topics_image">
<div id="fd_x_image" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_image"
        name="x_image"
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
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ftopicsadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ftopicsadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("topics");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
