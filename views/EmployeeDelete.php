<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmployeeDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { employee: currentTable } });
var currentForm, currentPageID;
var femployeedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femployeedelete = new ew.Form("femployeedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = femployeedelete;
    loadjs.done("femployeedelete");
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
<form name="femployeedelete" id="femployeedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employee">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_employee_id" class="employee_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->employee_id->Visible) { // employee_id ?>
        <th class="<?= $Page->employee_id->headerCellClass() ?>"><span id="elh_employee_employee_id" class="employee_employee_id"><?= $Page->employee_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
        <th class="<?= $Page->lastname->headerCellClass() ?>"><span id="elh_employee_lastname" class="employee_lastname"><?= $Page->lastname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->firstname->Visible) { // firstname ?>
        <th class="<?= $Page->firstname->headerCellClass() ?>"><span id="elh_employee_firstname" class="employee_firstname"><?= $Page->firstname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
        <th class="<?= $Page->middlename->headerCellClass() ?>"><span id="elh_employee_middlename" class="employee_middlename"><?= $Page->middlename->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dateOfBirth->Visible) { // dateOfBirth ?>
        <th class="<?= $Page->dateOfBirth->headerCellClass() ?>"><span id="elh_employee_dateOfBirth" class="employee_dateOfBirth"><?= $Page->dateOfBirth->caption() ?></span></th>
<?php } ?>
<?php if ($Page->picture->Visible) { // picture ?>
        <th class="<?= $Page->picture->headerCellClass() ?>"><span id="elh_employee_picture" class="employee_picture"><?= $Page->picture->caption() ?></span></th>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
        <th class="<?= $Page->address->headerCellClass() ?>"><span id="elh_employee_address" class="employee_address"><?= $Page->address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contactNo->Visible) { // contactNo ?>
        <th class="<?= $Page->contactNo->headerCellClass() ?>"><span id="elh_employee_contactNo" class="employee_contactNo"><?= $Page->contactNo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
        <th class="<?= $Page->officeDepartment->headerCellClass() ?>"><span id="elh_employee_officeDepartment" class="employee_officeDepartment"><?= $Page->officeDepartment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->empPosition->Visible) { // empPosition ?>
        <th class="<?= $Page->empPosition->headerCellClass() ?>"><span id="elh_employee_empPosition" class="employee_empPosition"><?= $Page->empPosition->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_employee_id" class="el_employee_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->employee_id->Visible) { // employee_id ?>
        <td<?= $Page->employee_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_employee_id" class="el_employee_employee_id">
<span<?= $Page->employee_id->viewAttributes() ?>>
<?= $Page->employee_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
        <td<?= $Page->lastname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_lastname" class="el_employee_lastname">
<span<?= $Page->lastname->viewAttributes() ?>>
<?= $Page->lastname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->firstname->Visible) { // firstname ?>
        <td<?= $Page->firstname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_firstname" class="el_employee_firstname">
<span<?= $Page->firstname->viewAttributes() ?>>
<?= $Page->firstname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
        <td<?= $Page->middlename->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_middlename" class="el_employee_middlename">
<span<?= $Page->middlename->viewAttributes() ?>>
<?= $Page->middlename->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dateOfBirth->Visible) { // dateOfBirth ?>
        <td<?= $Page->dateOfBirth->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_dateOfBirth" class="el_employee_dateOfBirth">
<span<?= $Page->dateOfBirth->viewAttributes() ?>>
<?= $Page->dateOfBirth->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->picture->Visible) { // picture ?>
        <td<?= $Page->picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_picture" class="el_employee_picture">
<span>
<?= GetFileViewTag($Page->picture, $Page->picture->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
        <td<?= $Page->address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_address" class="el_employee_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contactNo->Visible) { // contactNo ?>
        <td<?= $Page->contactNo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_contactNo" class="el_employee_contactNo">
<span<?= $Page->contactNo->viewAttributes() ?>>
<?= $Page->contactNo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
        <td<?= $Page->officeDepartment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_officeDepartment" class="el_employee_officeDepartment">
<span<?= $Page->officeDepartment->viewAttributes() ?>>
<?= $Page->officeDepartment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->empPosition->Visible) { // empPosition ?>
        <td<?= $Page->empPosition->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_empPosition" class="el_employee_empPosition">
<span<?= $Page->empPosition->viewAttributes() ?>>
<?= $Page->empPosition->getViewValue() ?></span>
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
