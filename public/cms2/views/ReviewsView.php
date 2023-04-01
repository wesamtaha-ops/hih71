<?php

namespace PHPMaker2023\hih71;

// Page object
$ReviewsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<form name="freviewsview" id="freviewsview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { reviews: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var freviewsview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("freviewsview")
        .setPageId("view")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="reviews">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reviews_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_reviews_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->from_user_id->Visible) { // from_user_id ?>
    <tr id="r_from_user_id"<?= $Page->from_user_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reviews_from_user_id"><?= $Page->from_user_id->caption() ?></span></td>
        <td data-name="from_user_id"<?= $Page->from_user_id->cellAttributes() ?>>
<span id="el_reviews_from_user_id">
<span<?= $Page->from_user_id->viewAttributes() ?>>
<?= $Page->from_user_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->to_user_id->Visible) { // to_user_id ?>
    <tr id="r_to_user_id"<?= $Page->to_user_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reviews_to_user_id"><?= $Page->to_user_id->caption() ?></span></td>
        <td data-name="to_user_id"<?= $Page->to_user_id->cellAttributes() ?>>
<span id="el_reviews_to_user_id">
<span<?= $Page->to_user_id->viewAttributes() ?>>
<?= $Page->to_user_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->points->Visible) { // points ?>
    <tr id="r_points"<?= $Page->points->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reviews_points"><?= $Page->points->caption() ?></span></td>
        <td data-name="points"<?= $Page->points->cellAttributes() ?>>
<span id="el_reviews_points">
<span<?= $Page->points->viewAttributes() ?>>
<?= $Page->points->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->details->Visible) { // details ?>
    <tr id="r_details"<?= $Page->details->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reviews_details"><?= $Page->details->caption() ?></span></td>
        <td data-name="details"<?= $Page->details->cellAttributes() ?>>
<span id="el_reviews_details">
<span<?= $Page->details->viewAttributes() ?>>
<?= $Page->details->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->review->Visible) { // review ?>
    <tr id="r_review"<?= $Page->review->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reviews_review"><?= $Page->review->caption() ?></span></td>
        <td data-name="review"<?= $Page->review->cellAttributes() ?>>
<span id="el_reviews_review">
<span<?= $Page->review->viewAttributes() ?>>
<?= $Page->review->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved->Visible) { // approved ?>
    <tr id="r_approved"<?= $Page->approved->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reviews_approved"><?= $Page->approved->caption() ?></span></td>
        <td data-name="approved"<?= $Page->approved->cellAttributes() ?>>
<span id="el_reviews_approved">
<span<?= $Page->approved->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_approved_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->approved->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->approved->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_approved_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reviews_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at"<?= $Page->created_at->cellAttributes() ?>>
<span id="el_reviews_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at"<?= $Page->updated_at->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reviews_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at"<?= $Page->updated_at->cellAttributes() ?>>
<span id="el_reviews_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
