<?php

namespace PHPMaker2023\hih71;

// Page object
$CurriculumsEdit = &$Page;
?>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fcurriculumsedit" id="fcurriculumsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { curriculums: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fcurriculumsedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcurriculumsedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["name_ar", [fields.name_ar.visible && fields.name_ar.required ? ew.Validators.required(fields.name_ar.caption) : null], fields.name_ar.isInvalid],
            ["name_en", [fields.name_en.visible && fields.name_en.required ? ew.Validators.required(fields.name_en.caption) : null], fields.name_en.isInvalid]
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
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="curriculums">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_curriculums_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_curriculums_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="curriculums" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name_ar->Visible) { // name_ar ?>
    <div id="r_name_ar"<?= $Page->name_ar->rowAttributes() ?>>
        <label id="elh_curriculums_name_ar" for="x_name_ar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name_ar->caption() ?><?= $Page->name_ar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name_ar->cellAttributes() ?>>
<span id="el_curriculums_name_ar">
<input type="<?= $Page->name_ar->getInputTextType() ?>" name="x_name_ar" id="x_name_ar" data-table="curriculums" data-field="x_name_ar" value="<?= $Page->name_ar->EditValue ?>" placeholder="<?= HtmlEncode($Page->name_ar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name_ar->formatPattern()) ?>"<?= $Page->name_ar->editAttributes() ?> aria-describedby="x_name_ar_help">
<?= $Page->name_ar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name_ar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name_en->Visible) { // name_en ?>
    <div id="r_name_en"<?= $Page->name_en->rowAttributes() ?>>
        <label id="elh_curriculums_name_en" for="x_name_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name_en->caption() ?><?= $Page->name_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name_en->cellAttributes() ?>>
<span id="el_curriculums_name_en">
<input type="<?= $Page->name_en->getInputTextType() ?>" name="x_name_en" id="x_name_en" data-table="curriculums" data-field="x_name_en" value="<?= $Page->name_en->EditValue ?>" placeholder="<?= HtmlEncode($Page->name_en->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name_en->formatPattern()) ?>"<?= $Page->name_en->editAttributes() ?> aria-describedby="x_name_en_help">
<?= $Page->name_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcurriculumsedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcurriculumsedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("curriculums");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
