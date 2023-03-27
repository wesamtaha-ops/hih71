<?php

namespace PHPMaker2023\hih71;

// Page object
$ReviewsSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { reviews: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var freviewssearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("freviewssearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["id", [ew.Validators.integer], fields.id.isInvalid],
            ["from_user_id", [], fields.from_user_id.isInvalid],
            ["to_user_id", [ew.Validators.integer], fields.to_user_id.isInvalid],
            ["points", [ew.Validators.integer], fields.points.isInvalid],
            ["details", [], fields.details.isInvalid],
            ["review", [], fields.review.isInvalid],
            ["approved", [], fields.approved.isInvalid],
            ["created_at", [ew.Validators.datetime(fields.created_at.clientFormatPattern)], fields.created_at.isInvalid],
            ["updated_at", [ew.Validators.datetime(fields.updated_at.clientFormatPattern)], fields.updated_at.isInvalid]
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
            "from_user_id": <?= $Page->from_user_id->toClientList($Page) ?>,
            "to_user_id": <?= $Page->to_user_id->toClientList($Page) ?>,
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
<form name="freviewssearch" id="freviewssearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="reviews">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="row"<?= $Page->id->rowAttributes() ?>>
        <label for="x_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_reviews_id"><?= $Page->id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id" id="z_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_reviews_id" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="reviews" data-field="x_id" value="<?= $Page->id->EditValue ?>" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id->formatPattern()) ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->from_user_id->Visible) { // from_user_id ?>
    <div id="r_from_user_id" class="row"<?= $Page->from_user_id->rowAttributes() ?>>
        <label for="x_from_user_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_reviews_from_user_id"><?= $Page->from_user_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_from_user_id" id="z_from_user_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->from_user_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_reviews_from_user_id" class="ew-search-field ew-search-field-single">
    <select
        id="x_from_user_id"
        name="x_from_user_id"
        class="form-select ew-select<?= $Page->from_user_id->isInvalidClass() ?>"
        <?php if (!$Page->from_user_id->IsNativeSelect) { ?>
        data-select2-id="freviewssearch_x_from_user_id"
        <?php } ?>
        data-table="reviews"
        data-field="x_from_user_id"
        data-value-separator="<?= $Page->from_user_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->from_user_id->getPlaceHolder()) ?>"
        <?= $Page->from_user_id->editAttributes() ?>>
        <?= $Page->from_user_id->selectOptionListHtml("x_from_user_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->from_user_id->getErrorMessage(false) ?></div>
<?= $Page->from_user_id->Lookup->getParamTag($Page, "p_x_from_user_id") ?>
<?php if (!$Page->from_user_id->IsNativeSelect) { ?>
<script>
loadjs.ready("freviewssearch", function() {
    var options = { name: "x_from_user_id", selectId: "freviewssearch_x_from_user_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (freviewssearch.lists.from_user_id?.lookupOptions.length) {
        options.data = { id: "x_from_user_id", form: "freviewssearch" };
    } else {
        options.ajax = { id: "x_from_user_id", form: "freviewssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.reviews.fields.from_user_id.selectOptions);
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
<?php if ($Page->to_user_id->Visible) { // to_user_id ?>
    <div id="r_to_user_id" class="row"<?= $Page->to_user_id->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_reviews_to_user_id"><?= $Page->to_user_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_to_user_id" id="z_to_user_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->to_user_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_reviews_to_user_id" class="ew-search-field ew-search-field-single">
<?php
if (IsRTL()) {
    $Page->to_user_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_to_user_id" class="ew-auto-suggest">
    <input type="<?= $Page->to_user_id->getInputTextType() ?>" class="form-control" name="sv_x_to_user_id" id="sv_x_to_user_id" value="<?= RemoveHtml($Page->to_user_id->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->to_user_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->to_user_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->to_user_id->formatPattern()) ?>"<?= $Page->to_user_id->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="reviews" data-field="x_to_user_id" data-input="sv_x_to_user_id" data-value-separator="<?= $Page->to_user_id->displayValueSeparatorAttribute() ?>" name="x_to_user_id" id="x_to_user_id" value="<?= HtmlEncode($Page->to_user_id->AdvancedSearch->SearchValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Page->to_user_id->getErrorMessage(false) ?></div>
<script>
loadjs.ready("freviewssearch", function() {
    freviewssearch.createAutoSuggest(Object.assign({"id":"x_to_user_id","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->to_user_id->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.reviews.fields.to_user_id.autoSuggestOptions));
});
</script>
<?= $Page->to_user_id->Lookup->getParamTag($Page, "p_x_to_user_id") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->points->Visible) { // points ?>
    <div id="r_points" class="row"<?= $Page->points->rowAttributes() ?>>
        <label for="x_points" class="<?= $Page->LeftColumnClass ?>"><span id="elh_reviews_points"><?= $Page->points->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_points" id="z_points" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->points->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_reviews_points" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->points->getInputTextType() ?>" name="x_points" id="x_points" data-table="reviews" data-field="x_points" value="<?= $Page->points->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->points->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->points->formatPattern()) ?>"<?= $Page->points->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->points->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->details->Visible) { // details ?>
    <div id="r_details" class="row"<?= $Page->details->rowAttributes() ?>>
        <label for="x_details" class="<?= $Page->LeftColumnClass ?>"><span id="elh_reviews_details"><?= $Page->details->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_details" id="z_details" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->details->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_reviews_details" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->details->getInputTextType() ?>" name="x_details" id="x_details" data-table="reviews" data-field="x_details" value="<?= $Page->details->EditValue ?>" size="35" placeholder="<?= HtmlEncode($Page->details->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->details->formatPattern()) ?>"<?= $Page->details->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->details->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->review->Visible) { // review ?>
    <div id="r_review" class="row"<?= $Page->review->rowAttributes() ?>>
        <label for="x_review" class="<?= $Page->LeftColumnClass ?>"><span id="elh_reviews_review"><?= $Page->review->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_review" id="z_review" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->review->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_reviews_review" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->review->getInputTextType() ?>" name="x_review" id="x_review" data-table="reviews" data-field="x_review" value="<?= $Page->review->EditValue ?>" size="35" placeholder="<?= HtmlEncode($Page->review->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->review->formatPattern()) ?>"<?= $Page->review->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->review->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
    <div id="r_approved" class="row"<?= $Page->approved->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_reviews_approved"><?= $Page->approved->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_approved" id="z_approved" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->approved->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_reviews_approved" class="ew-search-field ew-search-field-single">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->approved->isInvalidClass() ?>" data-table="reviews" data-field="x_approved" data-boolean name="x_approved" id="x_approved" value="1"<?= ConvertToBool($Page->approved->AdvancedSearch->SearchValue) ? " checked" : "" ?><?= $Page->approved->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->approved->getErrorMessage(false) ?></div>
</div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="row"<?= $Page->created_at->rowAttributes() ?>>
        <label for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><span id="elh_reviews_created_at"><?= $Page->created_at->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_created_at" id="z_created_at" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->created_at->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_reviews_created_at" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="reviews" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage(false) ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freviewssearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("freviewssearch", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="row"<?= $Page->updated_at->rowAttributes() ?>>
        <label for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><span id="elh_reviews_updated_at"><?= $Page->updated_at->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_updated_at" id="z_updated_at" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->updated_at->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_reviews_updated_at" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->updated_at->getInputTextType() ?>" name="x_updated_at" id="x_updated_at" data-table="reviews" data-field="x_updated_at" value="<?= $Page->updated_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->updated_at->formatPattern()) ?>"<?= $Page->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage(false) ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freviewssearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("freviewssearch", "x_updated_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="freviewssearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="freviewssearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="freviewssearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
