<?php

namespace PHPMaker2023\hih71;

// Page object
$TransfersAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { transfers: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var ftransfersadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftransfersadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid],
            ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null, ew.Validators.integer], fields.amount.isInvalid],
            ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null], fields.type.isInvalid],
            ["order_id", [fields.order_id.visible && fields.order_id.required ? ew.Validators.required(fields.order_id.caption) : null], fields.order_id.isInvalid],
            ["approved", [fields.approved.visible && fields.approved.required ? ew.Validators.required(fields.approved.caption) : null], fields.approved.isInvalid],
            ["verification_code", [fields.verification_code.visible && fields.verification_code.required ? ew.Validators.required(fields.verification_code.caption) : null], fields.verification_code.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ftransfersadd" id="ftransfersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="transfers">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "users") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="users">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->user_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->user_id->Visible) { // user_id ?>
    <div id="r_user_id"<?= $Page->user_id->rowAttributes() ?>>
        <label id="elh_transfers_user_id" for="x_user_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_id->caption() ?><?= $Page->user_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->user_id->cellAttributes() ?>>
<?php if ($Page->user_id->getSessionValue() != "") { ?>
<span<?= $Page->user_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->user_id->getDisplayValue($Page->user_id->ViewValue) ?></span></span>
<input type="hidden" id="x_user_id" name="x_user_id" value="<?= HtmlEncode($Page->user_id->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_transfers_user_id">
    <select
        id="x_user_id"
        name="x_user_id"
        class="form-select ew-select<?= $Page->user_id->isInvalidClass() ?>"
        <?php if (!$Page->user_id->IsNativeSelect) { ?>
        data-select2-id="ftransfersadd_x_user_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_user_id"
        data-value-separator="<?= $Page->user_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_id->getPlaceHolder()) ?>"
        <?= $Page->user_id->editAttributes() ?>>
        <?= $Page->user_id->selectOptionListHtml("x_user_id") ?>
    </select>
    <?= $Page->user_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->user_id->getErrorMessage() ?></div>
<?= $Page->user_id->Lookup->getParamTag($Page, "p_x_user_id") ?>
<?php if (!$Page->user_id->IsNativeSelect) { ?>
<script>
loadjs.ready("ftransfersadd", function() {
    var options = { name: "x_user_id", selectId: "ftransfersadd_x_user_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftransfersadd.lists.user_id?.lookupOptions.length) {
        options.data = { id: "x_user_id", form: "ftransfersadd" };
    } else {
        options.ajax = { id: "x_user_id", form: "ftransfersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.user_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <label id="elh_transfers_amount" for="x_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount->caption() ?><?= $Page->amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amount->cellAttributes() ?>>
<span id="el_transfers_amount">
<input type="<?= $Page->amount->getInputTextType() ?>" name="x_amount" id="x_amount" data-table="transfers" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->amount->formatPattern()) ?>"<?= $Page->amount->editAttributes() ?> aria-describedby="x_amount_help">
<?= $Page->amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type"<?= $Page->type->rowAttributes() ?>>
        <label id="elh_transfers_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type->cellAttributes() ?>>
<span id="el_transfers_type">
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
    value="<?= HtmlEncode($Page->type->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_type"
    data-target="dsl_x_type"
    data-repeatcolumn="5"
    class="form-control<?= $Page->type->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_type"
    data-value-separator="<?= $Page->type->displayValueSeparatorAttribute() ?>"
    <?= $Page->type->editAttributes() ?>></selection-list>
<?= $Page->type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->order_id->Visible) { // order_id ?>
    <div id="r_order_id"<?= $Page->order_id->rowAttributes() ?>>
        <label id="elh_transfers_order_id" for="x_order_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->order_id->caption() ?><?= $Page->order_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->order_id->cellAttributes() ?>>
<span id="el_transfers_order_id">
    <select
        id="x_order_id"
        name="x_order_id"
        class="form-select ew-select<?= $Page->order_id->isInvalidClass() ?>"
        <?php if (!$Page->order_id->IsNativeSelect) { ?>
        data-select2-id="ftransfersadd_x_order_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_order_id"
        data-value-separator="<?= $Page->order_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->order_id->getPlaceHolder()) ?>"
        <?= $Page->order_id->editAttributes() ?>>
        <?= $Page->order_id->selectOptionListHtml("x_order_id") ?>
    </select>
    <?= $Page->order_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->order_id->getErrorMessage() ?></div>
<?= $Page->order_id->Lookup->getParamTag($Page, "p_x_order_id") ?>
<?php if (!$Page->order_id->IsNativeSelect) { ?>
<script>
loadjs.ready("ftransfersadd", function() {
    var options = { name: "x_order_id", selectId: "ftransfersadd_x_order_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftransfersadd.lists.order_id?.lookupOptions.length) {
        options.data = { id: "x_order_id", form: "ftransfersadd" };
    } else {
        options.ajax = { id: "x_order_id", form: "ftransfersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.order_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
    <div id="r_approved"<?= $Page->approved->rowAttributes() ?>>
        <label id="elh_transfers_approved" class="<?= $Page->LeftColumnClass ?>"><?= $Page->approved->caption() ?><?= $Page->approved->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->approved->cellAttributes() ?>>
<span id="el_transfers_approved">
<template id="tp_x_approved">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="transfers" data-field="x_approved" name="x_approved" id="x_approved"<?= $Page->approved->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_approved" class="ew-item-list"></div>
<selection-list hidden
    id="x_approved"
    name="x_approved"
    value="<?= HtmlEncode($Page->approved->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_approved"
    data-target="dsl_x_approved"
    data-repeatcolumn="5"
    class="form-control<?= $Page->approved->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_approved"
    data-value-separator="<?= $Page->approved->displayValueSeparatorAttribute() ?>"
    <?= $Page->approved->editAttributes() ?>></selection-list>
<?= $Page->approved->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->approved->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->verification_code->Visible) { // verification_code ?>
    <div id="r_verification_code"<?= $Page->verification_code->rowAttributes() ?>>
        <label id="elh_transfers_verification_code" for="x_verification_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->verification_code->caption() ?><?= $Page->verification_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->verification_code->cellAttributes() ?>>
<span id="el_transfers_verification_code">
<input type="<?= $Page->verification_code->getInputTextType() ?>" name="x_verification_code" id="x_verification_code" data-table="transfers" data-field="x_verification_code" value="<?= $Page->verification_code->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->verification_code->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->verification_code->formatPattern()) ?>"<?= $Page->verification_code->editAttributes() ?> aria-describedby="x_verification_code_help">
<?= $Page->verification_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->verification_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ftransfersadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ftransfersadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("transfers");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
