<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmployeeView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { employee: currentTable } });
var currentForm, currentPageID;
var femployeeview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femployeeview = new ew.Form("femployeeview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = femployeeview;
    loadjs.done("femployeeview");
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
<form name="femployeeview" id="femployeeview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employee">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_employee_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->employee_id->Visible) { // employee_id ?>
    <tr id="r_employee_id"<?= $Page->employee_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_employee_id"><?= $Page->employee_id->caption() ?></span></td>
        <td data-name="employee_id"<?= $Page->employee_id->cellAttributes() ?>>
<span id="el_employee_employee_id">
<span<?= $Page->employee_id->viewAttributes() ?>>
<?= $Page->employee_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
    <tr id="r_lastname"<?= $Page->lastname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_lastname"><?= $Page->lastname->caption() ?></span></td>
        <td data-name="lastname"<?= $Page->lastname->cellAttributes() ?>>
<span id="el_employee_lastname">
<span<?= $Page->lastname->viewAttributes() ?>>
<?= $Page->lastname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->firstname->Visible) { // firstname ?>
    <tr id="r_firstname"<?= $Page->firstname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_firstname"><?= $Page->firstname->caption() ?></span></td>
        <td data-name="firstname"<?= $Page->firstname->cellAttributes() ?>>
<span id="el_employee_firstname">
<span<?= $Page->firstname->viewAttributes() ?>>
<?= $Page->firstname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
    <tr id="r_middlename"<?= $Page->middlename->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_middlename"><?= $Page->middlename->caption() ?></span></td>
        <td data-name="middlename"<?= $Page->middlename->cellAttributes() ?>>
<span id="el_employee_middlename">
<span<?= $Page->middlename->viewAttributes() ?>>
<?= $Page->middlename->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dateOfBirth->Visible) { // dateOfBirth ?>
    <tr id="r_dateOfBirth"<?= $Page->dateOfBirth->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_dateOfBirth"><?= $Page->dateOfBirth->caption() ?></span></td>
        <td data-name="dateOfBirth"<?= $Page->dateOfBirth->cellAttributes() ?>>
<span id="el_employee_dateOfBirth">
<span<?= $Page->dateOfBirth->viewAttributes() ?>>
<?= $Page->dateOfBirth->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->picture->Visible) { // picture ?>
    <tr id="r_picture"<?= $Page->picture->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_picture"><?= $Page->picture->caption() ?></span></td>
        <td data-name="picture"<?= $Page->picture->cellAttributes() ?>>
<span id="el_employee_picture">
<span>
<?= GetFileViewTag($Page->picture, $Page->picture->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <tr id="r_address"<?= $Page->address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_address"><?= $Page->address->caption() ?></span></td>
        <td data-name="address"<?= $Page->address->cellAttributes() ?>>
<span id="el_employee_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contactNo->Visible) { // contactNo ?>
    <tr id="r_contactNo"<?= $Page->contactNo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_contactNo"><?= $Page->contactNo->caption() ?></span></td>
        <td data-name="contactNo"<?= $Page->contactNo->cellAttributes() ?>>
<span id="el_employee_contactNo">
<span<?= $Page->contactNo->viewAttributes() ?>>
<?= $Page->contactNo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
    <tr id="r_officeDepartment"<?= $Page->officeDepartment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_officeDepartment"><?= $Page->officeDepartment->caption() ?></span></td>
        <td data-name="officeDepartment"<?= $Page->officeDepartment->cellAttributes() ?>>
<span id="el_employee_officeDepartment">
<span<?= $Page->officeDepartment->viewAttributes() ?>>
<?= $Page->officeDepartment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->empPosition->Visible) { // empPosition ?>
    <tr id="r_empPosition"<?= $Page->empPosition->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employee_empPosition"><?= $Page->empPosition->caption() ?></span></td>
        <td data-name="empPosition"<?= $Page->empPosition->cellAttributes() ?>>
<span id="el_employee_empPosition">
<span<?= $Page->empPosition->viewAttributes() ?>>
<?= $Page->empPosition->getViewValue() ?></span>
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
