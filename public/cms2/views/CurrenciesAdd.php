<?php

namespace PHPMaker2023\hih71;

// Page object
$CurrenciesAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { currencies: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fcurrenciesadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcurrenciesadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["name_ar", [fields.name_ar.visible && fields.name_ar.required ? ew.Validators.required(fields.name_ar.caption) : null], fields.name_ar.isInvalid],
            ["name_en", [fields.name_en.visible && fields.name_en.required ? ew.Validators.required(fields.name_en.caption) : null], fields.name_en.isInvalid],
            ["rate", [fields.rate.visible && fields.rate.required ? ew.Validators.required(fields.rate.caption) : null, ew.Validators.float], fields.rate.isInvalid],
            ["symbol", [fields.symbol.visible && fields.symbol.required ? ew.Validators.required(fields.symbol.caption) : null], fields.symbol.isInvalid]
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
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcurrenciesadd" id="fcurrenciesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="currencies">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->name_ar->Visible) { // name_ar ?>
    <div id="r_name_ar"<?= $Page->name_ar->rowAttributes() ?>>
        <label id="elh_currencies_name_ar" for="x_name_ar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name_ar->caption() ?><?= $Page->name_ar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name_ar->cellAttributes() ?>>
<span id="el_currencies_name_ar">
<input type="<?= $Page->name_ar->getInputTextType() ?>" name="x_name_ar" id="x_name_ar" data-table="currencies" data-field="x_name_ar" value="<?= $Page->name_ar->EditValue ?>" placeholder="<?= HtmlEncode($Page->name_ar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name_ar->formatPattern()) ?>"<?= $Page->name_ar->editAttributes() ?> aria-describedby="x_name_ar_help">
<?= $Page->name_ar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name_ar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name_en->Visible) { // name_en ?>
    <div id="r_name_en"<?= $Page->name_en->rowAttributes() ?>>
        <label id="elh_currencies_name_en" for="x_name_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name_en->caption() ?><?= $Page->name_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name_en->cellAttributes() ?>>
<span id="el_currencies_name_en">
<input type="<?= $Page->name_en->getInputTextType() ?>" name="x_name_en" id="x_name_en" data-table="currencies" data-field="x_name_en" value="<?= $Page->name_en->EditValue ?>" placeholder="<?= HtmlEncode($Page->name_en->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name_en->formatPattern()) ?>"<?= $Page->name_en->editAttributes() ?> aria-describedby="x_name_en_help">
<?= $Page->name_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rate->Visible) { // rate ?>
    <div id="r_rate"<?= $Page->rate->rowAttributes() ?>>
        <label id="elh_currencies_rate" for="x_rate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rate->caption() ?><?= $Page->rate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rate->cellAttributes() ?>>
<span id="el_currencies_rate">
<input type="<?= $Page->rate->getInputTextType() ?>" name="x_rate" id="x_rate" data-table="currencies" data-field="x_rate" value="<?= $Page->rate->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->rate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->rate->formatPattern()) ?>"<?= $Page->rate->editAttributes() ?> aria-describedby="x_rate_help">
<?= $Page->rate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rate->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->symbol->Visible) { // symbol ?>
    <div id="r_symbol"<?= $Page->symbol->rowAttributes() ?>>
        <label id="elh_currencies_symbol" for="x_symbol" class="<?= $Page->LeftColumnClass ?>"><?= $Page->symbol->caption() ?><?= $Page->symbol->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->symbol->cellAttributes() ?>>
<span id="el_currencies_symbol">
<input type="<?= $Page->symbol->getInputTextType() ?>" name="x_symbol" id="x_symbol" data-table="currencies" data-field="x_symbol" value="<?= $Page->symbol->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->symbol->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->symbol->formatPattern()) ?>"<?= $Page->symbol->editAttributes() ?> aria-describedby="x_symbol_help">
<?= $Page->symbol->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->symbol->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcurrenciesadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcurrenciesadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("currencies");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
