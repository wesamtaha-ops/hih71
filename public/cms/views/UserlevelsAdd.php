<?php

namespace PHPMaker2023\hih71;

// Page object
$UserlevelsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { userlevels: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fuserlevelsadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fuserlevelsadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["UserLevelID", [fields.UserLevelID.visible && fields.UserLevelID.required ? ew.Validators.required(fields.UserLevelID.caption) : null, ew.Validators.userLevelId, ew.Validators.integer], fields.UserLevelID.isInvalid],
            ["UserLevelName", [fields.UserLevelName.visible && fields.UserLevelName.required ? ew.Validators.required(fields.UserLevelName.caption) : null, ew.Validators.userLevelName('UserLevelID')], fields.UserLevelName.isInvalid]
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
<form name="fuserlevelsadd" id="fuserlevelsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->UserLevelID->Visible) { // UserLevelID ?>
    <div id="r_UserLevelID"<?= $Page->UserLevelID->rowAttributes() ?>>
        <label id="elh_userlevels_UserLevelID" for="x_UserLevelID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UserLevelID->caption() ?><?= $Page->UserLevelID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UserLevelID->cellAttributes() ?>>
<span id="el_userlevels_UserLevelID">
<input type="<?= $Page->UserLevelID->getInputTextType() ?>" name="x_UserLevelID" id="x_UserLevelID" data-table="userlevels" data-field="x_UserLevelID" value="<?= $Page->UserLevelID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->UserLevelID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UserLevelID->formatPattern()) ?>"<?= $Page->UserLevelID->editAttributes() ?> aria-describedby="x_UserLevelID_help">
<?= $Page->UserLevelID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UserLevelID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UserLevelName->Visible) { // UserLevelName ?>
    <div id="r_UserLevelName"<?= $Page->UserLevelName->rowAttributes() ?>>
        <label id="elh_userlevels_UserLevelName" for="x_UserLevelName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UserLevelName->caption() ?><?= $Page->UserLevelName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UserLevelName->cellAttributes() ?>>
<span id="el_userlevels_UserLevelName">
<input type="<?= $Page->UserLevelName->getInputTextType() ?>" name="x_UserLevelName" id="x_UserLevelName" data-table="userlevels" data-field="x_UserLevelName" value="<?= $Page->UserLevelName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->UserLevelName->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UserLevelName->formatPattern()) ?>"<?= $Page->UserLevelName->editAttributes() ?> aria-describedby="x_UserLevelName_help">
<?= $Page->UserLevelName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UserLevelName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <!-- row for permission values -->
    <div id="rp_permission" class="row">
        <label id="elh_permission" class="<?= $Page->LeftColumnClass ?>"><?= HtmlTitle($Language->phrase("Permission")) ?></label>
        <div class="<?= $Page->RightColumnClass ?>">
        <?php
            foreach (PRIVILEGES as $priv) {
                if ($priv != "admin" || IsSysAdmin()) {
                    $priv = ucfirst($priv);
        ?>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__Allow<?= $priv ?>" id="<?= $priv ?>" value="<?= constant(PROJECT_NAMESPACE . "ALLOW_" . strtoupper($priv)) ?>" /><label class="form-check-label" for="<?= $priv ?>"><?= $Language->phrase("Permission" . $priv) ?></label>
            </div>
        <?php
                }
            }
        ?>
        </div>
    </div>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fuserlevelsadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fuserlevelsadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("userlevels");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
