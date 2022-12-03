<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$UserAccountDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { user_account: currentTable } });
var currentForm, currentPageID;
var fuser_accountdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuser_accountdelete = new ew.Form("fuser_accountdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fuser_accountdelete;
    loadjs.done("fuser_accountdelete");
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
<form name="fuser_accountdelete" id="fuser_accountdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_account">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_user_account_id" class="user_account_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->employee_id->Visible) { // employee_id ?>
        <th class="<?= $Page->employee_id->headerCellClass() ?>"><span id="elh_user_account_employee_id" class="user_account_employee_id"><?= $Page->employee_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
        <th class="<?= $Page->lastname->headerCellClass() ?>"><span id="elh_user_account_lastname" class="user_account_lastname"><?= $Page->lastname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->firstname->Visible) { // firstname ?>
        <th class="<?= $Page->firstname->headerCellClass() ?>"><span id="elh_user_account_firstname" class="user_account_firstname"><?= $Page->firstname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
        <th class="<?= $Page->middlename->headerCellClass() ?>"><span id="elh_user_account_middlename" class="user_account_middlename"><?= $Page->middlename->caption() ?></span></th>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
        <th class="<?= $Page->photo->headerCellClass() ?>"><span id="elh_user_account_photo" class="user_account_photo"><?= $Page->photo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_user_account__username" class="user_account__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_userlevel->Visible) { // userlevel ?>
        <th class="<?= $Page->_userlevel->headerCellClass() ?>"><span id="elh_user_account__userlevel" class="user_account__userlevel"><?= $Page->_userlevel->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_user_account_id" class="el_user_account_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->employee_id->Visible) { // employee_id ?>
        <td<?= $Page->employee_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_account_employee_id" class="el_user_account_employee_id">
<span<?= $Page->employee_id->viewAttributes() ?>>
<?= $Page->employee_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
        <td<?= $Page->lastname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_account_lastname" class="el_user_account_lastname">
<span<?= $Page->lastname->viewAttributes() ?>>
<?= $Page->lastname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->firstname->Visible) { // firstname ?>
        <td<?= $Page->firstname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_account_firstname" class="el_user_account_firstname">
<span<?= $Page->firstname->viewAttributes() ?>>
<?= $Page->firstname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
        <td<?= $Page->middlename->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_account_middlename" class="el_user_account_middlename">
<span<?= $Page->middlename->viewAttributes() ?>>
<?= $Page->middlename->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
        <td<?= $Page->photo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_account_photo" class="el_user_account_photo">
<span>
<?= GetFileViewTag($Page->photo, $Page->photo->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <td<?= $Page->_username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_account__username" class="el_user_account__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_userlevel->Visible) { // userlevel ?>
        <td<?= $Page->_userlevel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_account__userlevel" class="el_user_account__userlevel">
<span<?= $Page->_userlevel->viewAttributes() ?>>
<?= $Page->_userlevel->getViewValue() ?></span>
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
<div>
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
