<?php

namespace PHPMaker2023\hih71;

// Page object
$ReviewsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { reviews: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var freviewsadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("freviewsadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["from_user_id", [fields.from_user_id.visible && fields.from_user_id.required ? ew.Validators.required(fields.from_user_id.caption) : null], fields.from_user_id.isInvalid],
            ["to_user_id", [fields.to_user_id.visible && fields.to_user_id.required ? ew.Validators.required(fields.to_user_id.caption) : null, ew.Validators.integer], fields.to_user_id.isInvalid],
            ["points", [fields.points.visible && fields.points.required ? ew.Validators.required(fields.points.caption) : null, ew.Validators.integer], fields.points.isInvalid],
            ["details", [fields.details.visible && fields.details.required ? ew.Validators.required(fields.details.caption) : null], fields.details.isInvalid],
            ["review", [fields.review.visible && fields.review.required ? ew.Validators.required(fields.review.caption) : null], fields.review.isInvalid],
            ["approved", [fields.approved.visible && fields.approved.required ? ew.Validators.required(fields.approved.caption) : null], fields.approved.isInvalid],
            ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(fields.created_at.clientFormatPattern)], fields.created_at.isInvalid],
            ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(fields.updated_at.clientFormatPattern)], fields.updated_at.isInvalid]
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
            "from_user_id": <?= $Page->from_user_id->toClientList($Page) ?>,
            "to_user_id": <?= $Page->to_user_id->toClientList($Page) ?>,
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
<form name="freviewsadd" id="freviewsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="reviews">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->from_user_id->Visible) { // from_user_id ?>
    <div id="r_from_user_id"<?= $Page->from_user_id->rowAttributes() ?>>
        <label id="elh_reviews_from_user_id" for="x_from_user_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->from_user_id->caption() ?><?= $Page->from_user_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->from_user_id->cellAttributes() ?>>
<span id="el_reviews_from_user_id">
    <select
        id="x_from_user_id"
        name="x_from_user_id"
        class="form-select ew-select<?= $Page->from_user_id->isInvalidClass() ?>"
        <?php if (!$Page->from_user_id->IsNativeSelect) { ?>
        data-select2-id="freviewsadd_x_from_user_id"
        <?php } ?>
        data-table="reviews"
        data-field="x_from_user_id"
        data-value-separator="<?= $Page->from_user_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->from_user_id->getPlaceHolder()) ?>"
        <?= $Page->from_user_id->editAttributes() ?>>
        <?= $Page->from_user_id->selectOptionListHtml("x_from_user_id") ?>
    </select>
    <?= $Page->from_user_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->from_user_id->getErrorMessage() ?></div>
<?= $Page->from_user_id->Lookup->getParamTag($Page, "p_x_from_user_id") ?>
<?php if (!$Page->from_user_id->IsNativeSelect) { ?>
<script>
loadjs.ready("freviewsadd", function() {
    var options = { name: "x_from_user_id", selectId: "freviewsadd_x_from_user_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (freviewsadd.lists.from_user_id?.lookupOptions.length) {
        options.data = { id: "x_from_user_id", form: "freviewsadd" };
    } else {
        options.ajax = { id: "x_from_user_id", form: "freviewsadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.reviews.fields.from_user_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->to_user_id->Visible) { // to_user_id ?>
    <div id="r_to_user_id"<?= $Page->to_user_id->rowAttributes() ?>>
        <label id="elh_reviews_to_user_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->to_user_id->caption() ?><?= $Page->to_user_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->to_user_id->cellAttributes() ?>>
<span id="el_reviews_to_user_id">
<?php
if (IsRTL()) {
    $Page->to_user_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_to_user_id" class="ew-auto-suggest">
    <input type="<?= $Page->to_user_id->getInputTextType() ?>" class="form-control" name="sv_x_to_user_id" id="sv_x_to_user_id" value="<?= RemoveHtml($Page->to_user_id->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->to_user_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->to_user_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->to_user_id->formatPattern()) ?>"<?= $Page->to_user_id->editAttributes() ?> aria-describedby="x_to_user_id_help">
</span>
<selection-list hidden class="form-control" data-table="reviews" data-field="x_to_user_id" data-input="sv_x_to_user_id" data-value-separator="<?= $Page->to_user_id->displayValueSeparatorAttribute() ?>" name="x_to_user_id" id="x_to_user_id" value="<?= HtmlEncode($Page->to_user_id->CurrentValue) ?>"></selection-list>
<?= $Page->to_user_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->to_user_id->getErrorMessage() ?></div>
<script>
loadjs.ready("freviewsadd", function() {
    freviewsadd.createAutoSuggest(Object.assign({"id":"x_to_user_id","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->to_user_id->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.reviews.fields.to_user_id.autoSuggestOptions));
});
</script>
<?= $Page->to_user_id->Lookup->getParamTag($Page, "p_x_to_user_id") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->points->Visible) { // points ?>
    <div id="r_points"<?= $Page->points->rowAttributes() ?>>
        <label id="elh_reviews_points" for="x_points" class="<?= $Page->LeftColumnClass ?>"><?= $Page->points->caption() ?><?= $Page->points->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->points->cellAttributes() ?>>
<span id="el_reviews_points">
<input type="<?= $Page->points->getInputTextType() ?>" name="x_points" id="x_points" data-table="reviews" data-field="x_points" value="<?= $Page->points->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->points->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->points->formatPattern()) ?>"<?= $Page->points->editAttributes() ?> aria-describedby="x_points_help">
<?= $Page->points->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->points->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->details->Visible) { // details ?>
    <div id="r_details"<?= $Page->details->rowAttributes() ?>>
        <label id="elh_reviews_details" for="x_details" class="<?= $Page->LeftColumnClass ?>"><?= $Page->details->caption() ?><?= $Page->details->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->details->cellAttributes() ?>>
<span id="el_reviews_details">
<textarea data-table="reviews" data-field="x_details" name="x_details" id="x_details" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->details->getPlaceHolder()) ?>"<?= $Page->details->editAttributes() ?> aria-describedby="x_details_help"><?= $Page->details->EditValue ?></textarea>
<?= $Page->details->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->details->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->review->Visible) { // review ?>
    <div id="r_review"<?= $Page->review->rowAttributes() ?>>
        <label id="elh_reviews_review" for="x_review" class="<?= $Page->LeftColumnClass ?>"><?= $Page->review->caption() ?><?= $Page->review->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->review->cellAttributes() ?>>
<span id="el_reviews_review">
<textarea data-table="reviews" data-field="x_review" name="x_review" id="x_review" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->review->getPlaceHolder()) ?>"<?= $Page->review->editAttributes() ?> aria-describedby="x_review_help"><?= $Page->review->EditValue ?></textarea>
<?= $Page->review->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->review->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
    <div id="r_approved"<?= $Page->approved->rowAttributes() ?>>
        <label id="elh_reviews_approved" class="<?= $Page->LeftColumnClass ?>"><?= $Page->approved->caption() ?><?= $Page->approved->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->approved->cellAttributes() ?>>
<span id="el_reviews_approved">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->approved->isInvalidClass() ?>" data-table="reviews" data-field="x_approved" data-boolean name="x_approved" id="x_approved" value="1"<?= ConvertToBool($Page->approved->CurrentValue) ? " checked" : "" ?><?= $Page->approved->editAttributes() ?> aria-describedby="x_approved_help">
    <div class="invalid-feedback"><?= $Page->approved->getErrorMessage() ?></div>
</div>
<?= $Page->approved->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <label id="elh_reviews_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->created_at->cellAttributes() ?>>
<span id="el_reviews_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="reviews" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freviewsadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("freviewsadd", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at"<?= $Page->updated_at->rowAttributes() ?>>
        <label id="elh_reviews_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->updated_at->cellAttributes() ?>>
<span id="el_reviews_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" name="x_updated_at" id="x_updated_at" data-table="reviews" data-field="x_updated_at" value="<?= $Page->updated_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->updated_at->formatPattern()) ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freviewsadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("freviewsadd", "x_updated_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="freviewsadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="freviewsadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("reviews");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
