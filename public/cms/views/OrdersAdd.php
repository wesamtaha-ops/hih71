<?php

namespace PHPMaker2023\hih71;

// Page object
$OrdersAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { orders: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fordersadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fordersadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["student_id", [fields.student_id.visible && fields.student_id.required ? ew.Validators.required(fields.student_id.caption) : null], fields.student_id.isInvalid],
            ["teacher_id", [fields.teacher_id.visible && fields.teacher_id.required ? ew.Validators.required(fields.teacher_id.caption) : null], fields.teacher_id.isInvalid],
            ["topic_id", [fields.topic_id.visible && fields.topic_id.required ? ew.Validators.required(fields.topic_id.caption) : null], fields.topic_id.isInvalid],
            ["date", [fields.date.visible && fields.date.required ? ew.Validators.required(fields.date.caption) : null, ew.Validators.datetime(fields.date.clientFormatPattern)], fields.date.isInvalid],
            ["time", [fields.time.visible && fields.time.required ? ew.Validators.required(fields.time.caption) : null], fields.time.isInvalid],
            ["fees", [fields.fees.visible && fields.fees.required ? ew.Validators.required(fields.fees.caption) : null, ew.Validators.float], fields.fees.isInvalid],
            ["currency_id", [fields.currency_id.visible && fields.currency_id.required ? ew.Validators.required(fields.currency_id.caption) : null], fields.currency_id.isInvalid],
            ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
            ["meeting_id", [fields.meeting_id.visible && fields.meeting_id.required ? ew.Validators.required(fields.meeting_id.caption) : null], fields.meeting_id.isInvalid],
            ["package_id", [fields.package_id.visible && fields.package_id.required ? ew.Validators.required(fields.package_id.caption) : null, ew.Validators.integer], fields.package_id.isInvalid]
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
            "student_id": <?= $Page->student_id->toClientList($Page) ?>,
            "teacher_id": <?= $Page->teacher_id->toClientList($Page) ?>,
            "topic_id": <?= $Page->topic_id->toClientList($Page) ?>,
            "currency_id": <?= $Page->currency_id->toClientList($Page) ?>,
            "status": <?= $Page->status->toClientList($Page) ?>,
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
<form name="fordersadd" id="fordersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="orders">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->student_id->Visible) { // student_id ?>
    <div id="r_student_id"<?= $Page->student_id->rowAttributes() ?>>
        <label id="elh_orders_student_id" for="x_student_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->student_id->caption() ?><?= $Page->student_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->student_id->cellAttributes() ?>>
<span id="el_orders_student_id">
    <select
        id="x_student_id"
        name="x_student_id"
        class="form-select ew-select<?= $Page->student_id->isInvalidClass() ?>"
        <?php if (!$Page->student_id->IsNativeSelect) { ?>
        data-select2-id="fordersadd_x_student_id"
        <?php } ?>
        data-table="orders"
        data-field="x_student_id"
        data-value-separator="<?= $Page->student_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->student_id->getPlaceHolder()) ?>"
        <?= $Page->student_id->editAttributes() ?>>
        <?= $Page->student_id->selectOptionListHtml("x_student_id") ?>
    </select>
    <?= $Page->student_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->student_id->getErrorMessage() ?></div>
<?= $Page->student_id->Lookup->getParamTag($Page, "p_x_student_id") ?>
<?php if (!$Page->student_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersadd", function() {
    var options = { name: "x_student_id", selectId: "fordersadd_x_student_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersadd.lists.student_id?.lookupOptions.length) {
        options.data = { id: "x_student_id", form: "fordersadd" };
    } else {
        options.ajax = { id: "x_student_id", form: "fordersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.student_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->teacher_id->Visible) { // teacher_id ?>
    <div id="r_teacher_id"<?= $Page->teacher_id->rowAttributes() ?>>
        <label id="elh_orders_teacher_id" for="x_teacher_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->teacher_id->caption() ?><?= $Page->teacher_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->teacher_id->cellAttributes() ?>>
<span id="el_orders_teacher_id">
    <select
        id="x_teacher_id"
        name="x_teacher_id"
        class="form-select ew-select<?= $Page->teacher_id->isInvalidClass() ?>"
        <?php if (!$Page->teacher_id->IsNativeSelect) { ?>
        data-select2-id="fordersadd_x_teacher_id"
        <?php } ?>
        data-table="orders"
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
loadjs.ready("fordersadd", function() {
    var options = { name: "x_teacher_id", selectId: "fordersadd_x_teacher_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersadd.lists.teacher_id?.lookupOptions.length) {
        options.data = { id: "x_teacher_id", form: "fordersadd" };
    } else {
        options.ajax = { id: "x_teacher_id", form: "fordersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.teacher_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->topic_id->Visible) { // topic_id ?>
    <div id="r_topic_id"<?= $Page->topic_id->rowAttributes() ?>>
        <label id="elh_orders_topic_id" for="x_topic_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->topic_id->caption() ?><?= $Page->topic_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->topic_id->cellAttributes() ?>>
<span id="el_orders_topic_id">
    <select
        id="x_topic_id"
        name="x_topic_id"
        class="form-select ew-select<?= $Page->topic_id->isInvalidClass() ?>"
        <?php if (!$Page->topic_id->IsNativeSelect) { ?>
        data-select2-id="fordersadd_x_topic_id"
        <?php } ?>
        data-table="orders"
        data-field="x_topic_id"
        data-value-separator="<?= $Page->topic_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->topic_id->getPlaceHolder()) ?>"
        <?= $Page->topic_id->editAttributes() ?>>
        <?= $Page->topic_id->selectOptionListHtml("x_topic_id") ?>
    </select>
    <?= $Page->topic_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->topic_id->getErrorMessage() ?></div>
<?= $Page->topic_id->Lookup->getParamTag($Page, "p_x_topic_id") ?>
<?php if (!$Page->topic_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersadd", function() {
    var options = { name: "x_topic_id", selectId: "fordersadd_x_topic_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersadd.lists.topic_id?.lookupOptions.length) {
        options.data = { id: "x_topic_id", form: "fordersadd" };
    } else {
        options.ajax = { id: "x_topic_id", form: "fordersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.topic_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
    <div id="r_date"<?= $Page->date->rowAttributes() ?>>
        <label id="elh_orders_date" for="x_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date->caption() ?><?= $Page->date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date->cellAttributes() ?>>
<span id="el_orders_date">
<input type="<?= $Page->date->getInputTextType() ?>" name="x_date" id="x_date" data-table="orders" data-field="x_date" value="<?= $Page->date->EditValue ?>" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->date->formatPattern()) ?>"<?= $Page->date->editAttributes() ?> aria-describedby="x_date_help">
<?= $Page->date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage() ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fordersadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fordersadd", "x_date", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
    <div id="r_time"<?= $Page->time->rowAttributes() ?>>
        <label id="elh_orders_time" for="x_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->time->caption() ?><?= $Page->time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->time->cellAttributes() ?>>
<span id="el_orders_time">
<input type="<?= $Page->time->getInputTextType() ?>" name="x_time" id="x_time" data-table="orders" data-field="x_time" value="<?= $Page->time->EditValue ?>" placeholder="<?= HtmlEncode($Page->time->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->time->formatPattern()) ?>"<?= $Page->time->editAttributes() ?> aria-describedby="x_time_help">
<?= $Page->time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->time->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fees->Visible) { // fees ?>
    <div id="r_fees"<?= $Page->fees->rowAttributes() ?>>
        <label id="elh_orders_fees" for="x_fees" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fees->caption() ?><?= $Page->fees->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fees->cellAttributes() ?>>
<span id="el_orders_fees">
<input type="<?= $Page->fees->getInputTextType() ?>" name="x_fees" id="x_fees" data-table="orders" data-field="x_fees" value="<?= $Page->fees->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->fees->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fees->formatPattern()) ?>"<?= $Page->fees->editAttributes() ?> aria-describedby="x_fees_help">
<?= $Page->fees->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fees->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
    <div id="r_currency_id"<?= $Page->currency_id->rowAttributes() ?>>
        <label id="elh_orders_currency_id" for="x_currency_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->currency_id->caption() ?><?= $Page->currency_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->currency_id->cellAttributes() ?>>
<span id="el_orders_currency_id">
    <select
        id="x_currency_id"
        name="x_currency_id"
        class="form-select ew-select<?= $Page->currency_id->isInvalidClass() ?>"
        <?php if (!$Page->currency_id->IsNativeSelect) { ?>
        data-select2-id="fordersadd_x_currency_id"
        <?php } ?>
        data-table="orders"
        data-field="x_currency_id"
        data-value-separator="<?= $Page->currency_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->currency_id->getPlaceHolder()) ?>"
        <?= $Page->currency_id->editAttributes() ?>>
        <?= $Page->currency_id->selectOptionListHtml("x_currency_id") ?>
    </select>
    <?= $Page->currency_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->currency_id->getErrorMessage() ?></div>
<?= $Page->currency_id->Lookup->getParamTag($Page, "p_x_currency_id") ?>
<?php if (!$Page->currency_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersadd", function() {
    var options = { name: "x_currency_id", selectId: "fordersadd_x_currency_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersadd.lists.currency_id?.lookupOptions.length) {
        options.data = { id: "x_currency_id", form: "fordersadd" };
    } else {
        options.ajax = { id: "x_currency_id", form: "fordersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.currency_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_orders_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_orders_status">
    <select
        id="x_status"
        name="x_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        <?php if (!$Page->status->IsNativeSelect) { ?>
        data-select2-id="fordersadd_x_status"
        <?php } ?>
        data-table="orders"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <?= $Page->status->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<?php if (!$Page->status->IsNativeSelect) { ?>
<script>
loadjs.ready("fordersadd", function() {
    var options = { name: "x_status", selectId: "fordersadd_x_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fordersadd.lists.status?.lookupOptions.length) {
        options.data = { id: "x_status", form: "fordersadd" };
    } else {
        options.ajax = { id: "x_status", form: "fordersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.orders.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->meeting_id->Visible) { // meeting_id ?>
    <div id="r_meeting_id"<?= $Page->meeting_id->rowAttributes() ?>>
        <label id="elh_orders_meeting_id" for="x_meeting_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->meeting_id->caption() ?><?= $Page->meeting_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->meeting_id->cellAttributes() ?>>
<span id="el_orders_meeting_id">
<input type="<?= $Page->meeting_id->getInputTextType() ?>" name="x_meeting_id" id="x_meeting_id" data-table="orders" data-field="x_meeting_id" value="<?= $Page->meeting_id->EditValue ?>" placeholder="<?= HtmlEncode($Page->meeting_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->meeting_id->formatPattern()) ?>"<?= $Page->meeting_id->editAttributes() ?> aria-describedby="x_meeting_id_help">
<?= $Page->meeting_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->meeting_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->package_id->Visible) { // package_id ?>
    <div id="r_package_id"<?= $Page->package_id->rowAttributes() ?>>
        <label id="elh_orders_package_id" for="x_package_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->package_id->caption() ?><?= $Page->package_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->package_id->cellAttributes() ?>>
<span id="el_orders_package_id">
<input type="<?= $Page->package_id->getInputTextType() ?>" name="x_package_id" id="x_package_id" data-table="orders" data-field="x_package_id" value="<?= $Page->package_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->package_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->package_id->formatPattern()) ?>"<?= $Page->package_id->editAttributes() ?> aria-describedby="x_package_id_help">
<?= $Page->package_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->package_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fordersadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fordersadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
