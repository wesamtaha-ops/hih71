<?php

namespace PHPMaker2023\hih71;

// Page object
$TransfersSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { transfers: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var ftransferssearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("ftransferssearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["id", [ew.Validators.integer], fields.id.isInvalid],
            ["user_id", [], fields.user_id.isInvalid],
            ["amount", [ew.Validators.integer], fields.amount.isInvalid],
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
            "user_id": <?= $Page->user_id->toClientList($Page) ?>,
            "type": <?= $Page->type->toClientList($Page) ?>,
            "order_id": <?= $Page->order_id->toClientList($Page) ?>,
            "approved": <?= $Page->approved->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
<?php if ($Page->IsModal) { ?>
    currentAdvancedSearchForm = form;
<?php } else { ?>
    currentForm = form;
<?php } ?>
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
<form name="ftransferssearch" id="ftransferssearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="transfers">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="row"<?= $Page->id->rowAttributes() ?>>
        <label for="x_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_transfers_id"><?= $Page->id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id" id="z_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_transfers_id" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="transfers" data-field="x_id" value="<?= $Page->id->EditValue ?>" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id->formatPattern()) ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <div id="r_user_id" class="row"<?= $Page->user_id->rowAttributes() ?>>
        <label for="x_user_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_transfers_user_id"><?= $Page->user_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_user_id" id="z_user_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->user_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_transfers_user_id" class="ew-search-field ew-search-field-single">
    <select
        id="x_user_id"
        name="x_user_id"
        class="form-select ew-select<?= $Page->user_id->isInvalidClass() ?>"
        <?php if (!$Page->user_id->IsNativeSelect) { ?>
        data-select2-id="ftransferssearch_x_user_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_user_id"
        data-value-separator="<?= $Page->user_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_id->getPlaceHolder()) ?>"
        <?= $Page->user_id->editAttributes() ?>>
        <?= $Page->user_id->selectOptionListHtml("x_user_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->user_id->getErrorMessage(false) ?></div>
<?= $Page->user_id->Lookup->getParamTag($Page, "p_x_user_id") ?>
<?php if (!$Page->user_id->IsNativeSelect) { ?>
<script>
loadjs.ready("ftransferssearch", function() {
    var options = { name: "x_user_id", selectId: "ftransferssearch_x_user_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftransferssearch.lists.user_id?.lookupOptions.length) {
        options.data = { id: "x_user_id", form: "ftransferssearch" };
    } else {
        options.ajax = { id: "x_user_id", form: "ftransferssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.user_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount" class="row"<?= $Page->amount->rowAttributes() ?>>
        <label for="x_amount" class="<?= $Page->LeftColumnClass ?>"><span id="elh_transfers_amount"><?= $Page->amount->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_amount" id="z_amount" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->amount->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_transfers_amount" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->amount->getInputTextType() ?>" name="x_amount" id="x_amount" data-table="transfers" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->amount->formatPattern()) ?>"<?= $Page->amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type" class="row"<?= $Page->type->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_transfers_type"><?= $Page->type->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_type" id="z_type" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->type->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_transfers_type" class="ew-search-field ew-search-field-single">
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
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->order_id->Visible) { // order_id ?>
    <div id="r_order_id" class="row"<?= $Page->order_id->rowAttributes() ?>>
        <label for="x_order_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_transfers_order_id"><?= $Page->order_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_order_id" id="z_order_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->order_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_transfers_order_id" class="ew-search-field ew-search-field-single">
    <select
        id="x_order_id"
        name="x_order_id"
        class="form-select ew-select<?= $Page->order_id->isInvalidClass() ?>"
        <?php if (!$Page->order_id->IsNativeSelect) { ?>
        data-select2-id="ftransferssearch_x_order_id"
        <?php } ?>
        data-table="transfers"
        data-field="x_order_id"
        data-value-separator="<?= $Page->order_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->order_id->getPlaceHolder()) ?>"
        <?= $Page->order_id->editAttributes() ?>>
        <?= $Page->order_id->selectOptionListHtml("x_order_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->order_id->getErrorMessage(false) ?></div>
<?= $Page->order_id->Lookup->getParamTag($Page, "p_x_order_id") ?>
<?php if (!$Page->order_id->IsNativeSelect) { ?>
<script>
loadjs.ready("ftransferssearch", function() {
    var options = { name: "x_order_id", selectId: "ftransferssearch_x_order_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftransferssearch.lists.order_id?.lookupOptions.length) {
        options.data = { id: "x_order_id", form: "ftransferssearch" };
    } else {
        options.ajax = { id: "x_order_id", form: "ftransferssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.transfers.fields.order_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
    <div id="r_approved" class="row"<?= $Page->approved->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_transfers_approved"><?= $Page->approved->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_approved" id="z_approved" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->approved->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_transfers_approved" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->approved->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_approved"
    data-target="dsl_x_approved"
    data-repeatcolumn="5"
    class="form-control<?= $Page->approved->isInvalidClass() ?>"
    data-table="transfers"
    data-field="x_approved"
    data-value-separator="<?= $Page->approved->displayValueSeparatorAttribute() ?>"
    <?= $Page->approved->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->approved->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->verification_code->Visible) { // verification_code ?>
    <div id="r_verification_code" class="row"<?= $Page->verification_code->rowAttributes() ?>>
        <label for="x_verification_code" class="<?= $Page->LeftColumnClass ?>"><span id="elh_transfers_verification_code"><?= $Page->verification_code->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_verification_code" id="z_verification_code" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->verification_code->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_transfers_verification_code" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->verification_code->getInputTextType() ?>" name="x_verification_code" id="x_verification_code" data-table="transfers" data-field="x_verification_code" value="<?= $Page->verification_code->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->verification_code->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->verification_code->formatPattern()) ?>"<?= $Page->verification_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->verification_code->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ftransferssearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ftransferssearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="ftransferssearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
