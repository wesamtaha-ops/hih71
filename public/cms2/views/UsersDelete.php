<?php

namespace PHPMaker2023\hih71;

// Page object
$UsersDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fusersdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fusersdelete")
        .setPageId("delete")
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
<form name="fusersdelete" id="fusersdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_users_id" class="users_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_users_name" class="users_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_users__email" class="users__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
        <th class="<?= $Page->phone->headerCellClass() ?>"><span id="elh_users_phone" class="users_phone"><?= $Page->phone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gender->Visible) { // gender ?>
        <th class="<?= $Page->gender->headerCellClass() ?>"><span id="elh_users_gender" class="users_gender"><?= $Page->gender->caption() ?></span></th>
<?php } ?>
<?php if ($Page->birthday->Visible) { // birthday ?>
        <th class="<?= $Page->birthday->headerCellClass() ?>"><span id="elh_users_birthday" class="users_birthday"><?= $Page->birthday->caption() ?></span></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th class="<?= $Page->image->headerCellClass() ?>"><span id="elh_users_image" class="users_image"><?= $Page->image->caption() ?></span></th>
<?php } ?>
<?php if ($Page->country_id->Visible) { // country_id ?>
        <th class="<?= $Page->country_id->headerCellClass() ?>"><span id="elh_users_country_id" class="users_country_id"><?= $Page->country_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
        <th class="<?= $Page->city->headerCellClass() ?>"><span id="elh_users_city" class="users_city"><?= $Page->city->caption() ?></span></th>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
        <th class="<?= $Page->currency_id->headerCellClass() ?>"><span id="elh_users_currency_id" class="users_currency_id"><?= $Page->currency_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th class="<?= $Page->type->headerCellClass() ?>"><span id="elh_users_type" class="users_type"><?= $Page->type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_verified->Visible) { // is_verified ?>
        <th class="<?= $Page->is_verified->headerCellClass() ?>"><span id="elh_users_is_verified" class="users_is_verified"><?= $Page->is_verified->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_approved->Visible) { // is_approved ?>
        <th class="<?= $Page->is_approved->headerCellClass() ?>"><span id="elh_users_is_approved" class="users_is_approved"><?= $Page->is_approved->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_blocked->Visible) { // is_blocked ?>
        <th class="<?= $Page->is_blocked->headerCellClass() ?>"><span id="elh_users_is_blocked" class="users_is_blocked"><?= $Page->is_blocked->caption() ?></span></th>
<?php } ?>
<?php if ($Page->otp->Visible) { // otp ?>
        <th class="<?= $Page->otp->headerCellClass() ?>"><span id="elh_users_otp" class="users_otp"><?= $Page->otp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->slug->Visible) { // slug ?>
        <th class="<?= $Page->slug->headerCellClass() ?>"><span id="elh_users_slug" class="users_slug"><?= $Page->slug->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_id" class="el_users_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td<?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_name" class="el_users_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td<?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users__email" class="el_users__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
        <td<?= $Page->phone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_phone" class="el_users_phone">
<span<?= $Page->phone->viewAttributes() ?>>
<?= $Page->phone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gender->Visible) { // gender ?>
        <td<?= $Page->gender->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_gender" class="el_users_gender">
<span<?= $Page->gender->viewAttributes() ?>>
<?= $Page->gender->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->birthday->Visible) { // birthday ?>
        <td<?= $Page->birthday->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_birthday" class="el_users_birthday">
<span<?= $Page->birthday->viewAttributes() ?>>
<?= $Page->birthday->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <td<?= $Page->image->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_image" class="el_users_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->country_id->Visible) { // country_id ?>
        <td<?= $Page->country_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_country_id" class="el_users_country_id">
<span<?= $Page->country_id->viewAttributes() ?>>
<?= $Page->country_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
        <td<?= $Page->city->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_city" class="el_users_city">
<span<?= $Page->city->viewAttributes() ?>>
<?= $Page->city->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->currency_id->Visible) { // currency_id ?>
        <td<?= $Page->currency_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_currency_id" class="el_users_currency_id">
<span<?= $Page->currency_id->viewAttributes() ?>>
<?= $Page->currency_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <td<?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_type" class="el_users_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_verified->Visible) { // is_verified ?>
        <td<?= $Page->is_verified->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_is_verified" class="el_users_is_verified">
<span<?= $Page->is_verified->viewAttributes() ?>>
<?= $Page->is_verified->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_approved->Visible) { // is_approved ?>
        <td<?= $Page->is_approved->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_is_approved" class="el_users_is_approved">
<span<?= $Page->is_approved->viewAttributes() ?>>
<?= $Page->is_approved->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_blocked->Visible) { // is_blocked ?>
        <td<?= $Page->is_blocked->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_is_blocked" class="el_users_is_blocked">
<span<?= $Page->is_blocked->viewAttributes() ?>>
<?= $Page->is_blocked->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->otp->Visible) { // otp ?>
        <td<?= $Page->otp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_otp" class="el_users_otp">
<span<?= $Page->otp->viewAttributes() ?>>
<?= $Page->otp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->slug->Visible) { // slug ?>
        <td<?= $Page->slug->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_slug" class="el_users_slug">
<span<?= $Page->slug->viewAttributes() ?>>
<?= $Page->slug->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
