<?php

namespace PHPMaker2023\hih71;

// Page object
$OrdersSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { orders: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var forderssearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("forderssearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["id", [ew.Validators.integer], fields.id.isInvalid],
            ["student_id", [], fields.student_id.isInvalid],
            ["teacher_id", [], fields.teacher_id.isInvalid],
            ["topic_id", [], fields.topic_id.isInvalid],
            ["date", [ew.Validators.datetime(fields.date.clientFormatPattern)], fields.date.isInvalid],
            ["time", [], fields.time.isInvalid],
            ["fees", [ew.Validators.float], fields.fees.isInvalid],
            ["currency_id", [], fields.currency_id.isInvalid],
            ["status", [], fields.status.isInvalid],
            ["meeting_id", [], fields.meeting_id.isInvalid],
            ["package_id", [ew.Validators.integer], fields.package_id.isInvalid]
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
            "student_id": <?= $Page->student_id->toClientList($Page) ?>,
            "teacher_id": <?= $Page->teacher_id->toClientList($Page) ?>,
            "topic_id": <?= $Page->topic_id->toClientList($Page) ?>,
            "currency_id": <?= $Page->currency_id->toClientList($Page) ?>,
            "status": <?= $Page->status->toClientList($Page) ?>,
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
<form name="forderssearch" id="forderssearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="orders">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="row"<?= $Page->id->rowAttributes() ?>>
        <label for="x_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_id"><?= $Page->id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id" id="z_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_id" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="orders" data-field="x_id" value="<?= $Page->id->EditValue ?>" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id->formatPattern()) ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->student_id->Visible) { // student_id ?>
    <div id="r_student_id" class="row"<?= $Page->student_id->rowAttributes() ?>>
        <label for="x_student_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_student_id"><?= $Page->student_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_student_id" id="z_student_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->student_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_student_id" class="ew-search-field ew-search-field-single">
    <select
        id="x_student_id"
        name="x_student_id"
        class="form-select ew-select<?= $Page->student_id->isInvalidClass() ?>"
        <?php if (!$Page->student_id->IsNativeSelect) { ?>
        data-select2-id="forderssearch_x_student_id"
        <?php } ?>
        data-table="orders"
        data-field="x_student_id"
        data-value-separator="<?= $Page->student_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->student_id->getPlaceHolder()) ?>"
        <?= $Page->student_id->editAttributes() ?>>
        <?= $Page->student_id->selectOptionListHtml("x_student_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->student_id->getErrorMessage(false) ?></div>
<?= $Page->student_id->Lookup->getParamTag($Page, "p_x_student_id") ?>
<?php if (!$Page->student_id->IsNativeSelect) { ?>
<script>
loadjs.ready("forderssearch", function() {
    var options = { name: "x_student_id", selectId: "forderssearch_x_student_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (forderssearch.lists.student_id?.lookupOptions.length) {
        options.data = { id: "x_student_id", form: "forderssearch" };
    } else {
        options.ajax = { id: "x_student_id", form: "forderssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.student_id.selectOptions);
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
<?php if ($Page->teacher_id->Visible) { // teacher_id ?>
    <div id="r_teacher_id" class="row"<?= $Page->teacher_id->rowAttributes() ?>>
        <label for="x_teacher_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_teacher_id"><?= $Page->teacher_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_teacher_id" id="z_teacher_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->teacher_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_teacher_id" class="ew-search-field ew-search-field-single">
    <select
        id="x_teacher_id"
        name="x_teacher_id"
        class="form-select ew-select<?= $Page->teacher_id->isInvalidClass() ?>"
        <?php if (!$Page->teacher_id->IsNativeSelect) { ?>
        data-select2-id="forderssearch_x_teacher_id"
        <?php } ?>
        data-table="orders"
        data-field="x_teacher_id"
        data-value-separator="<?= $Page->teacher_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->teacher_id->getPlaceHolder()) ?>"
        <?= $Page->teacher_id->editAttributes() ?>>
        <?= $Page->teacher_id->selectOptionListHtml("x_teacher_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->teacher_id->getErrorMessage(false) ?></div>
<?= $Page->teacher_id->Lookup->getParamTag($Page, "p_x_teacher_id") ?>
<?php if (!$Page->teacher_id->IsNativeSelect) { ?>
<script>
loadjs.ready("forderssearch", function() {
    var options = { name: "x_teacher_id", selectId: "forderssearch_x_teacher_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (forderssearch.lists.teacher_id?.lookupOptions.length) {
        options.data = { id: "x_teacher_id", form: "forderssearch" };
    } else {
        options.ajax = { id: "x_teacher_id", form: "forderssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.teacher_id.selectOptions);
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
<?php if ($Page->topic_id->Visible) { // topic_id ?>
    <div id="r_topic_id" class="row"<?= $Page->topic_id->rowAttributes() ?>>
        <label for="x_topic_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_topic_id"><?= $Page->topic_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_topic_id" id="z_topic_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->topic_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_topic_id" class="ew-search-field ew-search-field-single">
    <select
        id="x_topic_id"
        name="x_topic_id"
        class="form-select ew-select<?= $Page->topic_id->isInvalidClass() ?>"
        <?php if (!$Page->topic_id->IsNativeSelect) { ?>
        data-select2-id="forderssearch_x_topic_id"
        <?php } ?>
        data-table="orders"
        data-field="x_topic_id"
        data-value-separator="<?= $Page->topic_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->topic_id->getPlaceHolder()) ?>"
        <?= $Page->topic_id->editAttributes() ?>>
        <?= $Page->topic_id->selectOptionListHtml("x_topic_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->topic_id->getErrorMessage(false) ?></div>
<?= $Page->topic_id->Lookup->getParamTag($Page, "p_x_topic_id") ?>
<?php if (!$Page->topic_id->IsNativeSelect) { ?>
<script>
loadjs.ready("forderssearch", function() {
    var options = { name: "x_topic_id", selectId: "forderssearch_x_topic_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (forderssearch.lists.topic_id?.lookupOptions.length) {
        options.data = { id: "x_topic_id", form: "forderssearch" };
    } else {
        options.ajax = { id: "x_topic_id", form: "forderssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.topic_id.selectOptions);
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
<?php if ($Page->date->Visible) { // date ?>
    <div id="r_date" class="row"<?= $Page->date->rowAttributes() ?>>
        <label for="x_date" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_date"><?= $Page->date->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_date" id="z_date" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->date->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_date" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->date->getInputTextType() ?>" name="x_date" id="x_date" data-table="orders" data-field="x_date" value="<?= $Page->date->EditValue ?>" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->date->formatPattern()) ?>"<?= $Page->date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage(false) ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forderssearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("forderssearch", "x_date", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
    <div id="r_time" class="row"<?= $Page->time->rowAttributes() ?>>
        <label for="x_time" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_time"><?= $Page->time->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_time" id="z_time" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->time->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_time" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->time->getInputTextType() ?>" name="x_time" id="x_time" data-table="orders" data-field="x_time" value="<?= $Page->time->EditValue ?>" placeholder="<?= HtmlEncode($Page->time->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->time->formatPattern()) ?>"<?= $Page->time->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->time->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->fees->Visible) { // fees ?>
    <div id="r_fees" class="row"<?= $Page->fees->rowAttributes() ?>>
        <label for="x_fees" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_fees"><?= $Page->fees->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_fees" id="z_fees" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->fees->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_fees" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->fees->getInputTextType() ?>" name="x_fees" id="x_fees" data-table="orders" data-field="x_fees" value="<?= $Page->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fees->formatPattern()) ?>"<?= $Page->fees->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fees->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
    <div id="r_currency_id" class="row"<?= $Page->currency_id->rowAttributes() ?>>
        <label for="x_currency_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_currency_id"><?= $Page->currency_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_currency_id" id="z_currency_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->currency_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_currency_id" class="ew-search-field ew-search-field-single">
    <select
        id="x_currency_id"
        name="x_currency_id"
        class="form-select ew-select<?= $Page->currency_id->isInvalidClass() ?>"
        <?php if (!$Page->currency_id->IsNativeSelect) { ?>
        data-select2-id="forderssearch_x_currency_id"
        <?php } ?>
        data-table="orders"
        data-field="x_currency_id"
        data-value-separator="<?= $Page->currency_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->currency_id->getPlaceHolder()) ?>"
        <?= $Page->currency_id->editAttributes() ?>>
        <?= $Page->currency_id->selectOptionListHtml("x_currency_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->currency_id->getErrorMessage(false) ?></div>
<?= $Page->currency_id->Lookup->getParamTag($Page, "p_x_currency_id") ?>
<?php if (!$Page->currency_id->IsNativeSelect) { ?>
<script>
loadjs.ready("forderssearch", function() {
    var options = { name: "x_currency_id", selectId: "forderssearch_x_currency_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (forderssearch.lists.currency_id?.lookupOptions.length) {
        options.data = { id: "x_currency_id", form: "forderssearch" };
    } else {
        options.ajax = { id: "x_currency_id", form: "forderssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.currency_id.selectOptions);
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
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="row"<?= $Page->status->rowAttributes() ?>>
        <label for="x_status" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_status"><?= $Page->status->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status" id="z_status" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->status->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_status" class="ew-search-field ew-search-field-single">
    <select
        id="x_status"
        name="x_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        <?php if (!$Page->status->IsNativeSelect) { ?>
        data-select2-id="forderssearch_x_status"
        <?php } ?>
        data-table="orders"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage(false) ?></div>
<?php if (!$Page->status->IsNativeSelect) { ?>
<script>
loadjs.ready("forderssearch", function() {
    var options = { name: "x_status", selectId: "forderssearch_x_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (forderssearch.lists.status?.lookupOptions.length) {
        options.data = { id: "x_status", form: "forderssearch" };
    } else {
        options.ajax = { id: "x_status", form: "forderssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.status.selectOptions);
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
<?php if ($Page->meeting_id->Visible) { // meeting_id ?>
    <div id="r_meeting_id" class="row"<?= $Page->meeting_id->rowAttributes() ?>>
        <label for="x_meeting_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_meeting_id"><?= $Page->meeting_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_meeting_id" id="z_meeting_id" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->meeting_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_meeting_id" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->meeting_id->getInputTextType() ?>" name="x_meeting_id" id="x_meeting_id" data-table="orders" data-field="x_meeting_id" value="<?= $Page->meeting_id->EditValue ?>" placeholder="<?= HtmlEncode($Page->meeting_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->meeting_id->formatPattern()) ?>"<?= $Page->meeting_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->meeting_id->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->package_id->Visible) { // package_id ?>
    <div id="r_package_id" class="row"<?= $Page->package_id->rowAttributes() ?>>
        <label for="x_package_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_orders_package_id"><?= $Page->package_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_package_id" id="z_package_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->package_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_orders_package_id" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->package_id->getInputTextType() ?>" name="x_package_id" id="x_package_id" data-table="orders" data-field="x_package_id" value="<?= $Page->package_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->package_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->package_id->formatPattern()) ?>"<?= $Page->package_id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->package_id->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="forderssearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="forderssearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="forderssearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("orders");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
