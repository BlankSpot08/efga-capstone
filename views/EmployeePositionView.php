<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmployeePositionView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { employee_position: currentTable } });
var currentForm, currentPageID;
var femployee_positionview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femployee_positionview = new ew.Form("femployee_positionview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = femployee_positionview;
    loadjs.done("femployee_positionview");
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
<form name="femployee_positionview" id="femployee_positionview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employee_position">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_position_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_employee_position_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
    <tr id="r_officeDepartment"<?= $Page->officeDepartment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_position_officeDepartment"><?= $Page->officeDepartment->caption() ?></span></td>
        <td data-name="officeDepartment"<?= $Page->officeDepartment->cellAttributes() ?>>
<span id="el_employee_position_officeDepartment">
<span<?= $Page->officeDepartment->viewAttributes() ?>>
<?= $Page->officeDepartment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->position->Visible) { // position ?>
    <tr id="r_position"<?= $Page->position->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_position_position"><?= $Page->position->caption() ?></span></td>
        <td data-name="position"<?= $Page->position->cellAttributes() ?>>
<span id="el_employee_position_position">
<span<?= $Page->position->viewAttributes() ?>>
<?= $Page->position->getViewValue() ?></span>
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
