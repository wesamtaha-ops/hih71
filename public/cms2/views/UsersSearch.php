<?php

namespace PHPMaker2023\hih71;

// Page object
$UsersSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fuserssearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fuserssearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["id", [ew.Validators.integer], fields.id.isInvalid],
            ["name", [], fields.name.isInvalid],
            ["_email", [], fields._email.isInvalid],
            ["_password", [], fields._password.isInvalid],
            ["phone", [], fields.phone.isInvalid],
            ["gender", [], fields.gender.isInvalid],
            ["birthday", [ew.Validators.datetime(fields.birthday.clientFormatPattern)], fields.birthday.isInvalid],
            ["image", [], fields.image.isInvalid],
            ["country_id", [], fields.country_id.isInvalid],
            ["city", [], fields.city.isInvalid],
            ["currency_id", [], fields.currency_id.isInvalid],
            ["type", [], fields.type.isInvalid],
            ["is_verified", [], fields.is_verified.isInvalid],
            ["is_approved", [], fields.is_approved.isInvalid],
            ["is_blocked", [], fields.is_blocked.isInvalid],
            ["otp", [], fields.otp.isInvalid],
            ["slug", [], fields.slug.isInvalid],
            ["remember_token", [], fields.remember_token.isInvalid],
            ["rate", [ew.Validators.integer], fields.rate.isInvalid]
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
            "gender": <?= $Page->gender->toClientList($Page) ?>,
            "country_id": <?= $Page->country_id->toClientList($Page) ?>,
            "currency_id": <?= $Page->currency_id->toClientList($Page) ?>,
            "type": <?= $Page->type->toClientList($Page) ?>,
            "is_verified": <?= $Page->is_verified->toClientList($Page) ?>,
            "is_approved": <?= $Page->is_approved->toClientList($Page) ?>,
            "is_blocked": <?= $Page->is_blocked->toClientList($Page) ?>,
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
<form name="fuserssearch" id="fuserssearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="row"<?= $Page->id->rowAttributes() ?>>
        <label for="x_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_id"><?= $Page->id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id" id="z_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_id" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="users" data-field="x_id" value="<?= $Page->id->EditValue ?>" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id->formatPattern()) ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="row"<?= $Page->name->rowAttributes() ?>>
        <label for="x_name" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_name"><?= $Page->name->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_name" id="z_name" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->name->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_name" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="users" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name->formatPattern()) ?>"<?= $Page->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="row"<?= $Page->_email->rowAttributes() ?>>
        <label for="x__email" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users__email"><?= $Page->_email->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__email" id="z__email" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->_email->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users__email" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="users" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password" class="row"<?= $Page->_password->rowAttributes() ?>>
        <label for="x__password" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users__password"><?= $Page->_password->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__password" id="z__password" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->_password->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users__password" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->_password->getInputTextType() ?>" name="x__password" id="x__password" data-table="users" data-field="x__password" value="<?= $Page->_password->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_password->formatPattern()) ?>"<?= $Page->_password->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <div id="r_phone" class="row"<?= $Page->phone->rowAttributes() ?>>
        <label for="x_phone" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_phone"><?= $Page->phone->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_phone" id="z_phone" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->phone->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_phone" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->phone->getInputTextType() ?>" name="x_phone" id="x_phone" data-table="users" data-field="x_phone" value="<?= $Page->phone->EditValue ?>" placeholder="<?= HtmlEncode($Page->phone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->phone->formatPattern()) ?>"<?= $Page->phone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->phone->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->gender->Visible) { // gender ?>
    <div id="r_gender" class="row"<?= $Page->gender->rowAttributes() ?>>
        <label for="x_gender" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_gender"><?= $Page->gender->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_gender" id="z_gender" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->gender->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_gender" class="ew-search-field ew-search-field-single">
    <select
        id="x_gender"
        name="x_gender"
        class="form-select ew-select<?= $Page->gender->isInvalidClass() ?>"
        <?php if (!$Page->gender->IsNativeSelect) { ?>
        data-select2-id="fuserssearch_x_gender"
        <?php } ?>
        data-table="users"
        data-field="x_gender"
        data-value-separator="<?= $Page->gender->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->gender->getPlaceHolder()) ?>"
        <?= $Page->gender->editAttributes() ?>>
        <?= $Page->gender->selectOptionListHtml("x_gender") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->gender->getErrorMessage(false) ?></div>
<?php if (!$Page->gender->IsNativeSelect) { ?>
<script>
loadjs.ready("fuserssearch", function() {
    var options = { name: "x_gender", selectId: "fuserssearch_x_gender" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserssearch.lists.gender?.lookupOptions.length) {
        options.data = { id: "x_gender", form: "fuserssearch" };
    } else {
        options.ajax = { id: "x_gender", form: "fuserssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.gender.selectOptions);
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
<?php if ($Page->birthday->Visible) { // birthday ?>
    <div id="r_birthday" class="row"<?= $Page->birthday->rowAttributes() ?>>
        <label for="x_birthday" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_birthday"><?= $Page->birthday->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_birthday" id="z_birthday" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->birthday->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_birthday" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->birthday->getInputTextType() ?>" name="x_birthday" id="x_birthday" data-table="users" data-field="x_birthday" value="<?= $Page->birthday->EditValue ?>" placeholder="<?= HtmlEncode($Page->birthday->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->birthday->formatPattern()) ?>"<?= $Page->birthday->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->birthday->getErrorMessage(false) ?></div>
<?php if (!$Page->birthday->ReadOnly && !$Page->birthday->Disabled && !isset($Page->birthday->EditAttrs["readonly"]) && !isset($Page->birthday->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fuserssearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fuserssearch", "x_birthday", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <div id="r_image" class="row"<?= $Page->image->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_image"><?= $Page->image->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_image" id="z_image" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->image->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_image" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->image->getInputTextType() ?>" name="x_image" id="x_image" data-table="users" data-field="x_image" value="<?= $Page->image->EditValue ?>" placeholder="<?= HtmlEncode($Page->image->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->image->formatPattern()) ?>"<?= $Page->image->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->image->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->country_id->Visible) { // country_id ?>
    <div id="r_country_id" class="row"<?= $Page->country_id->rowAttributes() ?>>
        <label for="x_country_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_country_id"><?= $Page->country_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_country_id" id="z_country_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->country_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_country_id" class="ew-search-field ew-search-field-single">
    <select
        id="x_country_id"
        name="x_country_id"
        class="form-select ew-select<?= $Page->country_id->isInvalidClass() ?>"
        <?php if (!$Page->country_id->IsNativeSelect) { ?>
        data-select2-id="fuserssearch_x_country_id"
        <?php } ?>
        data-table="users"
        data-field="x_country_id"
        data-value-separator="<?= $Page->country_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->country_id->getPlaceHolder()) ?>"
        <?= $Page->country_id->editAttributes() ?>>
        <?= $Page->country_id->selectOptionListHtml("x_country_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->country_id->getErrorMessage(false) ?></div>
<?= $Page->country_id->Lookup->getParamTag($Page, "p_x_country_id") ?>
<?php if (!$Page->country_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fuserssearch", function() {
    var options = { name: "x_country_id", selectId: "fuserssearch_x_country_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserssearch.lists.country_id?.lookupOptions.length) {
        options.data = { id: "x_country_id", form: "fuserssearch" };
    } else {
        options.ajax = { id: "x_country_id", form: "fuserssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.country_id.selectOptions);
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
<?php if ($Page->city->Visible) { // city ?>
    <div id="r_city" class="row"<?= $Page->city->rowAttributes() ?>>
        <label for="x_city" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_city"><?= $Page->city->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_city" id="z_city" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->city->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_city" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->city->getInputTextType() ?>" name="x_city" id="x_city" data-table="users" data-field="x_city" value="<?= $Page->city->EditValue ?>" placeholder="<?= HtmlEncode($Page->city->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->city->formatPattern()) ?>"<?= $Page->city->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->city->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
    <div id="r_currency_id" class="row"<?= $Page->currency_id->rowAttributes() ?>>
        <label for="x_currency_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_currency_id"><?= $Page->currency_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_currency_id" id="z_currency_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->currency_id->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_currency_id" class="ew-search-field ew-search-field-single">
    <select
        id="x_currency_id"
        name="x_currency_id"
        class="form-select ew-select<?= $Page->currency_id->isInvalidClass() ?>"
        <?php if (!$Page->currency_id->IsNativeSelect) { ?>
        data-select2-id="fuserssearch_x_currency_id"
        <?php } ?>
        data-table="users"
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
loadjs.ready("fuserssearch", function() {
    var options = { name: "x_currency_id", selectId: "fuserssearch_x_currency_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserssearch.lists.currency_id?.lookupOptions.length) {
        options.data = { id: "x_currency_id", form: "fuserssearch" };
    } else {
        options.ajax = { id: "x_currency_id", form: "fuserssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.currency_id.selectOptions);
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
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type" class="row"<?= $Page->type->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_type"><?= $Page->type->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_type" id="z_type" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->type->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_type" class="ew-search-field ew-search-field-single">
<template id="tp_x_type">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_type" name="x_type" id="x_type"<?= $Page->type->editAttributes() ?>>
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
    data-table="users"
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
<?php if ($Page->is_verified->Visible) { // is_verified ?>
    <div id="r_is_verified" class="row"<?= $Page->is_verified->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_is_verified"><?= $Page->is_verified->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_is_verified" id="z_is_verified" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->is_verified->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_is_verified" class="ew-search-field ew-search-field-single">
<template id="tp_x_is_verified">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_is_verified" name="x_is_verified" id="x_is_verified"<?= $Page->is_verified->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_is_verified" class="ew-item-list"></div>
<selection-list hidden
    id="x_is_verified"
    name="x_is_verified"
    value="<?= HtmlEncode($Page->is_verified->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_is_verified"
    data-target="dsl_x_is_verified"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_verified->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_verified"
    data-value-separator="<?= $Page->is_verified->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_verified->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->is_verified->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->is_approved->Visible) { // is_approved ?>
    <div id="r_is_approved" class="row"<?= $Page->is_approved->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_is_approved"><?= $Page->is_approved->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_is_approved" id="z_is_approved" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->is_approved->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_is_approved" class="ew-search-field ew-search-field-single">
<template id="tp_x_is_approved">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_is_approved" name="x_is_approved" id="x_is_approved"<?= $Page->is_approved->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_is_approved" class="ew-item-list"></div>
<selection-list hidden
    id="x_is_approved"
    name="x_is_approved"
    value="<?= HtmlEncode($Page->is_approved->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_is_approved"
    data-target="dsl_x_is_approved"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_approved->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_approved"
    data-value-separator="<?= $Page->is_approved->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_approved->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->is_approved->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->is_blocked->Visible) { // is_blocked ?>
    <div id="r_is_blocked" class="row"<?= $Page->is_blocked->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_is_blocked"><?= $Page->is_blocked->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_is_blocked" id="z_is_blocked" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->is_blocked->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_is_blocked" class="ew-search-field ew-search-field-single">
<template id="tp_x_is_blocked">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_is_blocked" name="x_is_blocked" id="x_is_blocked"<?= $Page->is_blocked->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_is_blocked" class="ew-item-list"></div>
<selection-list hidden
    id="x_is_blocked"
    name="x_is_blocked"
    value="<?= HtmlEncode($Page->is_blocked->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_is_blocked"
    data-target="dsl_x_is_blocked"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_blocked->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_blocked"
    data-value-separator="<?= $Page->is_blocked->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_blocked->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->is_blocked->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->otp->Visible) { // otp ?>
    <div id="r_otp" class="row"<?= $Page->otp->rowAttributes() ?>>
        <label for="x_otp" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_otp"><?= $Page->otp->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_otp" id="z_otp" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->otp->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_otp" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->otp->getInputTextType() ?>" name="x_otp" id="x_otp" data-table="users" data-field="x_otp" value="<?= $Page->otp->EditValue ?>" placeholder="<?= HtmlEncode($Page->otp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->otp->formatPattern()) ?>"<?= $Page->otp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->otp->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->slug->Visible) { // slug ?>
    <div id="r_slug" class="row"<?= $Page->slug->rowAttributes() ?>>
        <label for="x_slug" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_slug"><?= $Page->slug->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_slug" id="z_slug" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->slug->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_slug" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->slug->getInputTextType() ?>" name="x_slug" id="x_slug" data-table="users" data-field="x_slug" value="<?= $Page->slug->EditValue ?>" placeholder="<?= HtmlEncode($Page->slug->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->slug->formatPattern()) ?>"<?= $Page->slug->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->slug->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->remember_token->Visible) { // remember_token ?>
    <div id="r_remember_token" class="row"<?= $Page->remember_token->rowAttributes() ?>>
        <label for="x_remember_token" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_remember_token"><?= $Page->remember_token->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_remember_token" id="z_remember_token" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->remember_token->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_remember_token" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->remember_token->getInputTextType() ?>" name="x_remember_token" id="x_remember_token" data-table="users" data-field="x_remember_token" value="<?= $Page->remember_token->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->remember_token->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->remember_token->formatPattern()) ?>"<?= $Page->remember_token->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->remember_token->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->rate->Visible) { // rate ?>
    <div id="r_rate" class="row"<?= $Page->rate->rowAttributes() ?>>
        <label for="x_rate" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_rate"><?= $Page->rate->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_rate" id="z_rate" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->rate->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_users_rate" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->rate->getInputTextType() ?>" name="x_rate" id="x_rate" data-table="users" data-field="x_rate" value="<?= $Page->rate->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->rate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->rate->formatPattern()) ?>"<?= $Page->rate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->rate->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fuserssearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fuserssearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fuserssearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
