<?php

namespace PHPMaker2023\hih71;

// Table
$users = Container("users");
?>
<?php if ($users->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_usersmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($users->id->Visible) { // id ?>
        <tr id="r_id"<?= $users->id->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->id->caption() ?></td>
            <td<?= $users->id->cellAttributes() ?>>
<span id="el_users_id">
<span<?= $users->id->viewAttributes() ?>>
<?= $users->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
        <tr id="r_name"<?= $users->name->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->name->caption() ?></td>
            <td<?= $users->name->cellAttributes() ?>>
<span id="el_users_name">
<span<?= $users->name->viewAttributes() ?>>
<?= $users->name->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
        <tr id="r__email"<?= $users->_email->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->_email->caption() ?></td>
            <td<?= $users->_email->cellAttributes() ?>>
<span id="el_users__email">
<span<?= $users->_email->viewAttributes() ?>>
<?= $users->_email->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->phone->Visible) { // phone ?>
        <tr id="r_phone"<?= $users->phone->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->phone->caption() ?></td>
            <td<?= $users->phone->cellAttributes() ?>>
<span id="el_users_phone">
<span<?= $users->phone->viewAttributes() ?>>
<?= $users->phone->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->gender->Visible) { // gender ?>
        <tr id="r_gender"<?= $users->gender->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->gender->caption() ?></td>
            <td<?= $users->gender->cellAttributes() ?>>
<span id="el_users_gender">
<span<?= $users->gender->viewAttributes() ?>>
<?= $users->gender->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->image->Visible) { // image ?>
        <tr id="r_image"<?= $users->image->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->image->caption() ?></td>
            <td<?= $users->image->cellAttributes() ?>>
<span id="el_users_image">
<span>
<?= GetFileViewTag($users->image, $users->image->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->country_id->Visible) { // country_id ?>
        <tr id="r_country_id"<?= $users->country_id->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->country_id->caption() ?></td>
            <td<?= $users->country_id->cellAttributes() ?>>
<span id="el_users_country_id">
<span<?= $users->country_id->viewAttributes() ?>>
<?= $users->country_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->city->Visible) { // city ?>
        <tr id="r_city"<?= $users->city->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->city->caption() ?></td>
            <td<?= $users->city->cellAttributes() ?>>
<span id="el_users_city">
<span<?= $users->city->viewAttributes() ?>>
<?= $users->city->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->type->Visible) { // type ?>
        <tr id="r_type"<?= $users->type->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->type->caption() ?></td>
            <td<?= $users->type->cellAttributes() ?>>
<span id="el_users_type">
<span<?= $users->type->viewAttributes() ?>>
<?= $users->type->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->is_approved->Visible) { // is_approved ?>
        <tr id="r_is_approved"<?= $users->is_approved->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->is_approved->caption() ?></td>
            <td<?= $users->is_approved->cellAttributes() ?>>
<span id="el_users_is_approved">
<span<?= $users->is_approved->viewAttributes() ?>>
<?= $users->is_approved->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->is_blocked->Visible) { // is_blocked ?>
        <tr id="r_is_blocked"<?= $users->is_blocked->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->is_blocked->caption() ?></td>
            <td<?= $users->is_blocked->cellAttributes() ?>>
<span id="el_users_is_blocked">
<span<?= $users->is_blocked->viewAttributes() ?>>
<?= $users->is_blocked->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($users->otp->Visible) { // otp ?>
        <tr id="r_otp"<?= $users->otp->rowAttributes() ?>>
            <td class="<?= $users->TableLeftColumnClass ?>"><?= $users->otp->caption() ?></td>
            <td<?= $users->otp->cellAttributes() ?>>
<span id="el_users_otp">
<span<?= $users->otp->viewAttributes() ?>>
<?= $users->otp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
