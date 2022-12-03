<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$UserAccountView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { user_account: currentTable } });
var currentForm, currentPageID;
var fuser_accountview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuser_accountview = new ew.Form("fuser_accountview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fuser_accountview;
    loadjs.done("fuser_accountview");
});
</script>
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
<form name="fuser_accountview" id="fuser_accountview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_account">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_account_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_user_account_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->employee_id->Visible) { // employee_id ?>
    <tr id="r_employee_id"<?= $Page->employee_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_account_employee_id"><?= $Page->employee_id->caption() ?></span></td>
        <td data-name="employee_id"<?= $Page->employee_id->cellAttributes() ?>>
<span id="el_user_account_employee_id">
<span<?= $Page->employee_id->viewAttributes() ?>>
<?= $Page->employee_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
    <tr id="r_lastname"<?= $Page->lastname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_account_lastname"><?= $Page->lastname->caption() ?></span></td>
        <td data-name="lastname"<?= $Page->lastname->cellAttributes() ?>>
<span id="el_user_account_lastname">
<span<?= $Page->lastname->viewAttributes() ?>>
<?= $Page->lastname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->firstname->Visible) { // firstname ?>
    <tr id="r_firstname"<?= $Page->firstname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_account_firstname"><?= $Page->firstname->caption() ?></span></td>
        <td data-name="firstname"<?= $Page->firstname->cellAttributes() ?>>
<span id="el_user_account_firstname">
<span<?= $Page->firstname->viewAttributes() ?>>
<?= $Page->firstname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
    <tr id="r_middlename"<?= $Page->middlename->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_account_middlename"><?= $Page->middlename->caption() ?></span></td>
        <td data-name="middlename"<?= $Page->middlename->cellAttributes() ?>>
<span id="el_user_account_middlename">
<span<?= $Page->middlename->viewAttributes() ?>>
<?= $Page->middlename->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
    <tr id="r_photo"<?= $Page->photo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_account_photo"><?= $Page->photo->caption() ?></span></td>
        <td data-name="photo"<?= $Page->photo->cellAttributes() ?>>
<span id="el_user_account_photo">
<span>
<?= GetFileViewTag($Page->photo, $Page->photo->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_account__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username"<?= $Page->_username->cellAttributes() ?>>
<span id="el_user_account__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <tr id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_account__password"><?= $Page->_password->caption() ?></span></td>
        <td data-name="_password"<?= $Page->_password->cellAttributes() ?>>
<span id="el_user_account__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_userlevel->Visible) { // userlevel ?>
    <tr id="r__userlevel"<?= $Page->_userlevel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_account__userlevel"><?= $Page->_userlevel->caption() ?></span></td>
        <td data-name="_userlevel"<?= $Page->_userlevel->cellAttributes() ?>>
<span id="el_user_account__userlevel">
<span<?= $Page->_userlevel->viewAttributes() ?>>
<?= $Page->_userlevel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
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
