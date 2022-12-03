<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$CashAdvanceView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cash_advance: currentTable } });
var currentForm, currentPageID;
var fcash_advanceview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fcash_advanceview = new ew.Form("fcash_advanceview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fcash_advanceview;
    loadjs.done("fcash_advanceview");
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
<form name="fcash_advanceview" id="fcash_advanceview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cash_advance">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cash_advance_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_cash_advance_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
    <tr id="r_expCategory_id"<?= $Page->expCategory_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cash_advance_expCategory_id"><?= $Page->expCategory_id->caption() ?></span></td>
        <td data-name="expCategory_id"<?= $Page->expCategory_id->cellAttributes() ?>>
<span id="el_cash_advance_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<?= $Page->expCategory_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
    <tr id="r_expSubcategory_id"<?= $Page->expSubcategory_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cash_advance_expSubcategory_id"><?= $Page->expSubcategory_id->caption() ?></span></td>
        <td data-name="expSubcategory_id"<?= $Page->expSubcategory_id->cellAttributes() ?>>
<span id="el_cash_advance_expSubcategory_id">
<span<?= $Page->expSubcategory_id->viewAttributes() ?>>
<?= $Page->expSubcategory_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->machine_id->Visible) { // machine_id ?>
    <tr id="r_machine_id"<?= $Page->machine_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cash_advance_machine_id"><?= $Page->machine_id->caption() ?></span></td>
        <td data-name="machine_id"<?= $Page->machine_id->cellAttributes() ?>>
<span id="el_cash_advance_machine_id">
<span<?= $Page->machine_id->viewAttributes() ?>>
<?= $Page->machine_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dateReceived->Visible) { // dateReceived ?>
    <tr id="r_dateReceived"<?= $Page->dateReceived->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cash_advance_dateReceived"><?= $Page->dateReceived->caption() ?></span></td>
        <td data-name="dateReceived"<?= $Page->dateReceived->cellAttributes() ?>>
<span id="el_cash_advance_dateReceived">
<span<?= $Page->dateReceived->viewAttributes() ?>>
<?= $Page->dateReceived->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
    <tr id="r_submittedBy"<?= $Page->submittedBy->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cash_advance_submittedBy"><?= $Page->submittedBy->caption() ?></span></td>
        <td data-name="submittedBy"<?= $Page->submittedBy->cellAttributes() ?>>
<span id="el_cash_advance_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<?= $Page->submittedBy->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <tr id="r_note"<?= $Page->note->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cash_advance_note"><?= $Page->note->caption() ?></span></td>
        <td data-name="note"<?= $Page->note->cellAttributes() ?>>
<span id="el_cash_advance_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cash_advance_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_cash_advance_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
    <tr id="r_validatedBy"<?= $Page->validatedBy->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cash_advance_validatedBy"><?= $Page->validatedBy->caption() ?></span></td>
        <td data-name="validatedBy"<?= $Page->validatedBy->cellAttributes() ?>>
<span id="el_cash_advance_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<?= $Page->validatedBy->getViewValue() ?></span>
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
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    $(document).ready(function(){ 
        $("#r_machine_id").hide(); 
        if ($("#el_cash_advance_expCategory_id")[0].textContent.trim() == "Maintenance") {
            $("#r_machine_id").show(); 
        }
    });
});
</script>
<?php } ?>
