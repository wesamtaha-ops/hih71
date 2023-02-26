<?php

namespace PHPMaker2023\hih71;

// Page object
$UsersAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fusersadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fusersadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
            ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
            ["phone", [fields.phone.visible && fields.phone.required ? ew.Validators.required(fields.phone.caption) : null], fields.phone.isInvalid],
            ["gender", [fields.gender.visible && fields.gender.required ? ew.Validators.required(fields.gender.caption) : null], fields.gender.isInvalid],
            ["birthday", [fields.birthday.visible && fields.birthday.required ? ew.Validators.required(fields.birthday.caption) : null, ew.Validators.datetime(fields.birthday.clientFormatPattern)], fields.birthday.isInvalid],
            ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid],
            ["country_id", [fields.country_id.visible && fields.country_id.required ? ew.Validators.required(fields.country_id.caption) : null], fields.country_id.isInvalid],
            ["city", [fields.city.visible && fields.city.required ? ew.Validators.required(fields.city.caption) : null], fields.city.isInvalid],
            ["currency_id", [fields.currency_id.visible && fields.currency_id.required ? ew.Validators.required(fields.currency_id.caption) : null], fields.currency_id.isInvalid],
            ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null], fields.type.isInvalid],
            ["is_verified", [fields.is_verified.visible && fields.is_verified.required ? ew.Validators.required(fields.is_verified.caption) : null], fields.is_verified.isInvalid],
            ["is_approved", [fields.is_approved.visible && fields.is_approved.required ? ew.Validators.required(fields.is_approved.caption) : null], fields.is_approved.isInvalid],
            ["is_blocked", [fields.is_blocked.visible && fields.is_blocked.required ? ew.Validators.required(fields.is_blocked.caption) : null], fields.is_blocked.isInvalid],
            ["otp", [fields.otp.visible && fields.otp.required ? ew.Validators.required(fields.otp.caption) : null], fields.otp.isInvalid],
            ["slug", [fields.slug.visible && fields.slug.required ? ew.Validators.required(fields.slug.caption) : null], fields.slug.isInvalid],
            ["remember_token", [fields.remember_token.visible && fields.remember_token.required ? ew.Validators.required(fields.remember_token.caption) : null], fields.remember_token.isInvalid]
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
<form name="fusersadd" id="fusersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_users_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_users_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="users" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name->formatPattern()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_users__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="users" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <label id="elh_users__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<span id="el_users__password">
<input type="<?= $Page->_password->getInputTextType() ?>" name="x__password" id="x__password" data-table="users" data-field="x__password" value="<?= $Page->_password->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_password->formatPattern()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <div id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <label id="elh_users_phone" for="x_phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->phone->caption() ?><?= $Page->phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->phone->cellAttributes() ?>>
<span id="el_users_phone">
<input type="<?= $Page->phone->getInputTextType() ?>" name="x_phone" id="x_phone" data-table="users" data-field="x_phone" value="<?= $Page->phone->EditValue ?>" placeholder="<?= HtmlEncode($Page->phone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->phone->formatPattern()) ?>"<?= $Page->phone->editAttributes() ?> aria-describedby="x_phone_help">
<?= $Page->phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->phone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gender->Visible) { // gender ?>
    <div id="r_gender"<?= $Page->gender->rowAttributes() ?>>
        <label id="elh_users_gender" for="x_gender" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gender->caption() ?><?= $Page->gender->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->gender->cellAttributes() ?>>
<span id="el_users_gender">
    <select
        id="x_gender"
        name="x_gender"
        class="form-select ew-select<?= $Page->gender->isInvalidClass() ?>"
        <?php if (!$Page->gender->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x_gender"
        <?php } ?>
        data-table="users"
        data-field="x_gender"
        data-value-separator="<?= $Page->gender->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->gender->getPlaceHolder()) ?>"
        <?= $Page->gender->editAttributes() ?>>
        <?= $Page->gender->selectOptionListHtml("x_gender") ?>
    </select>
    <?= $Page->gender->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->gender->getErrorMessage() ?></div>
<?php if (!$Page->gender->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x_gender", selectId: "fusersadd_x_gender" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists.gender?.lookupOptions.length) {
        options.data = { id: "x_gender", form: "fusersadd" };
    } else {
        options.ajax = { id: "x_gender", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.gender.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->birthday->Visible) { // birthday ?>
    <div id="r_birthday"<?= $Page->birthday->rowAttributes() ?>>
        <label id="elh_users_birthday" for="x_birthday" class="<?= $Page->LeftColumnClass ?>"><?= $Page->birthday->caption() ?><?= $Page->birthday->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->birthday->cellAttributes() ?>>
<span id="el_users_birthday">
<input type="<?= $Page->birthday->getInputTextType() ?>" name="x_birthday" id="x_birthday" data-table="users" data-field="x_birthday" value="<?= $Page->birthday->EditValue ?>" placeholder="<?= HtmlEncode($Page->birthday->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->birthday->formatPattern()) ?>"<?= $Page->birthday->editAttributes() ?> aria-describedby="x_birthday_help">
<?= $Page->birthday->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->birthday->getErrorMessage() ?></div>
<?php if (!$Page->birthday->ReadOnly && !$Page->birthday->Disabled && !isset($Page->birthday->EditAttrs["readonly"]) && !isset($Page->birthday->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fusersadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fusersadd", "x_birthday", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <div id="r_image"<?= $Page->image->rowAttributes() ?>>
        <label id="elh_users_image" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image->caption() ?><?= $Page->image->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->image->cellAttributes() ?>>
<span id="el_users_image">
<div id="fd_x_image" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_image"
        name="x_image"
        class="form-control ew-file-input"
        title="<?= $Page->image->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="users"
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
<?php if ($Page->country_id->Visible) { // country_id ?>
    <div id="r_country_id"<?= $Page->country_id->rowAttributes() ?>>
        <label id="elh_users_country_id" for="x_country_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->country_id->caption() ?><?= $Page->country_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->country_id->cellAttributes() ?>>
<span id="el_users_country_id">
    <select
        id="x_country_id"
        name="x_country_id"
        class="form-select ew-select<?= $Page->country_id->isInvalidClass() ?>"
        <?php if (!$Page->country_id->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x_country_id"
        <?php } ?>
        data-table="users"
        data-field="x_country_id"
        data-value-separator="<?= $Page->country_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->country_id->getPlaceHolder()) ?>"
        <?= $Page->country_id->editAttributes() ?>>
        <?= $Page->country_id->selectOptionListHtml("x_country_id") ?>
    </select>
    <?= $Page->country_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->country_id->getErrorMessage() ?></div>
<?= $Page->country_id->Lookup->getParamTag($Page, "p_x_country_id") ?>
<?php if (!$Page->country_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x_country_id", selectId: "fusersadd_x_country_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists.country_id?.lookupOptions.length) {
        options.data = { id: "x_country_id", form: "fusersadd" };
    } else {
        options.ajax = { id: "x_country_id", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.country_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
    <div id="r_city"<?= $Page->city->rowAttributes() ?>>
        <label id="elh_users_city" for="x_city" class="<?= $Page->LeftColumnClass ?>"><?= $Page->city->caption() ?><?= $Page->city->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->city->cellAttributes() ?>>
<span id="el_users_city">
<input type="<?= $Page->city->getInputTextType() ?>" name="x_city" id="x_city" data-table="users" data-field="x_city" value="<?= $Page->city->EditValue ?>" placeholder="<?= HtmlEncode($Page->city->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->city->formatPattern()) ?>"<?= $Page->city->editAttributes() ?> aria-describedby="x_city_help">
<?= $Page->city->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->city->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
    <div id="r_currency_id"<?= $Page->currency_id->rowAttributes() ?>>
        <label id="elh_users_currency_id" for="x_currency_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->currency_id->caption() ?><?= $Page->currency_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->currency_id->cellAttributes() ?>>
<span id="el_users_currency_id">
    <select
        id="x_currency_id"
        name="x_currency_id"
        class="form-select ew-select<?= $Page->currency_id->isInvalidClass() ?>"
        <?php if (!$Page->currency_id->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x_currency_id"
        <?php } ?>
        data-table="users"
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
loadjs.ready("fusersadd", function() {
    var options = { name: "x_currency_id", selectId: "fusersadd_x_currency_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists.currency_id?.lookupOptions.length) {
        options.data = { id: "x_currency_id", form: "fusersadd" };
    } else {
        options.ajax = { id: "x_currency_id", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.currency_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type"<?= $Page->type->rowAttributes() ?>>
        <label id="elh_users_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type->cellAttributes() ?>>
<span id="el_users_type">
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
    value="<?= HtmlEncode($Page->type->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_type"
    data-target="dsl_x_type"
    data-repeatcolumn="5"
    class="form-control<?= $Page->type->isInvalidClass() ?>"
    data-table="users"
    data-field="x_type"
    data-value-separator="<?= $Page->type->displayValueSeparatorAttribute() ?>"
    <?= $Page->type->editAttributes() ?>></selection-list>
<?= $Page->type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_verified->Visible) { // is_verified ?>
    <div id="r_is_verified"<?= $Page->is_verified->rowAttributes() ?>>
        <label id="elh_users_is_verified" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_verified->caption() ?><?= $Page->is_verified->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->is_verified->cellAttributes() ?>>
<span id="el_users_is_verified">
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
    value="<?= HtmlEncode($Page->is_verified->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_is_verified"
    data-target="dsl_x_is_verified"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_verified->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_verified"
    data-value-separator="<?= $Page->is_verified->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_verified->editAttributes() ?>></selection-list>
<?= $Page->is_verified->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_verified->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_approved->Visible) { // is_approved ?>
    <div id="r_is_approved"<?= $Page->is_approved->rowAttributes() ?>>
        <label id="elh_users_is_approved" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_approved->caption() ?><?= $Page->is_approved->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->is_approved->cellAttributes() ?>>
<span id="el_users_is_approved">
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
    value="<?= HtmlEncode($Page->is_approved->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_is_approved"
    data-target="dsl_x_is_approved"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_approved->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_approved"
    data-value-separator="<?= $Page->is_approved->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_approved->editAttributes() ?>></selection-list>
<?= $Page->is_approved->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_approved->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_blocked->Visible) { // is_blocked ?>
    <div id="r_is_blocked"<?= $Page->is_blocked->rowAttributes() ?>>
        <label id="elh_users_is_blocked" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_blocked->caption() ?><?= $Page->is_blocked->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->is_blocked->cellAttributes() ?>>
<span id="el_users_is_blocked">
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
    value="<?= HtmlEncode($Page->is_blocked->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_is_blocked"
    data-target="dsl_x_is_blocked"
    data-repeatcolumn="5"
    class="form-control<?= $Page->is_blocked->isInvalidClass() ?>"
    data-table="users"
    data-field="x_is_blocked"
    data-value-separator="<?= $Page->is_blocked->displayValueSeparatorAttribute() ?>"
    <?= $Page->is_blocked->editAttributes() ?>></selection-list>
<?= $Page->is_blocked->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_blocked->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->otp->Visible) { // otp ?>
    <div id="r_otp"<?= $Page->otp->rowAttributes() ?>>
        <label id="elh_users_otp" for="x_otp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->otp->caption() ?><?= $Page->otp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->otp->cellAttributes() ?>>
<span id="el_users_otp">
<input type="<?= $Page->otp->getInputTextType() ?>" name="x_otp" id="x_otp" data-table="users" data-field="x_otp" value="<?= $Page->otp->EditValue ?>" placeholder="<?= HtmlEncode($Page->otp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->otp->formatPattern()) ?>"<?= $Page->otp->editAttributes() ?> aria-describedby="x_otp_help">
<?= $Page->otp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->otp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->slug->Visible) { // slug ?>
    <div id="r_slug"<?= $Page->slug->rowAttributes() ?>>
        <label id="elh_users_slug" for="x_slug" class="<?= $Page->LeftColumnClass ?>"><?= $Page->slug->caption() ?><?= $Page->slug->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->slug->cellAttributes() ?>>
<span id="el_users_slug">
<input type="<?= $Page->slug->getInputTextType() ?>" name="x_slug" id="x_slug" data-table="users" data-field="x_slug" value="<?= $Page->slug->EditValue ?>" placeholder="<?= HtmlEncode($Page->slug->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->slug->formatPattern()) ?>"<?= $Page->slug->editAttributes() ?> aria-describedby="x_slug_help">
<?= $Page->slug->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->slug->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->remember_token->Visible) { // remember_token ?>
    <div id="r_remember_token"<?= $Page->remember_token->rowAttributes() ?>>
        <label id="elh_users_remember_token" for="x_remember_token" class="<?= $Page->LeftColumnClass ?>"><?= $Page->remember_token->caption() ?><?= $Page->remember_token->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->remember_token->cellAttributes() ?>>
<span id="el_users_remember_token">
<input type="<?= $Page->remember_token->getInputTextType() ?>" name="x_remember_token" id="x_remember_token" data-table="users" data-field="x_remember_token" value="<?= $Page->remember_token->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->remember_token->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->remember_token->formatPattern()) ?>"<?= $Page->remember_token->editAttributes() ?> aria-describedby="x_remember_token_help">
<?= $Page->remember_token->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->remember_token->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("transfers", explode(",", $Page->getCurrentDetailTable())) && $transfers->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("transfers", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "TransfersGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fusersadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fusersadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
