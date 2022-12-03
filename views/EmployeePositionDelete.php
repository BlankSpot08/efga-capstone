<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmployeePositionDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { employee_position: currentTable } });
var currentForm, currentPageID;
var femployee_positiondelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femployee_positiondelete = new ew.Form("femployee_positiondelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = femployee_positiondelete;
    loadjs.done("femployee_positiondelete");
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
<form name="femployee_positiondelete" id="femployee_positiondelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employee_position">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_employee_position_id" class="employee_position_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
        <th class="<?= $Page->officeDepartment->headerCellClass() ?>"><span id="elh_employee_position_officeDepartment" class="employee_position_officeDepartment"><?= $Page->officeDepartment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->position->Visible) { // position ?>
        <th class="<?= $Page->position->headerCellClass() ?>"><span id="elh_employee_position_position" class="employee_position_position"><?= $Page->position->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_employee_position_id" class="el_employee_position_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
        <td<?= $Page->officeDepartment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_position_officeDepartment" class="el_employee_position_officeDepartment">
<span<?= $Page->officeDepartment->viewAttributes() ?>>
<?= $Page->officeDepartment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->position->Visible) { // position ?>
        <td<?= $Page->position->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_position_position" class="el_employee_position_position">
<span<?= $Page->position->viewAttributes() ?>>
<?= $Page->position->getViewValue() ?></span>
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
