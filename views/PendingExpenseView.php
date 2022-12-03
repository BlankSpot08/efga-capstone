<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$PendingExpenseView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pending_expense: currentTable } });
var currentForm, currentPageID;
var fpending_expenseview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpending_expenseview = new ew.Form("fpending_expenseview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fpending_expenseview;
    loadjs.done("fpending_expenseview");
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
<form name="fpending_expenseview" id="fpending_expenseview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pending_expense">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_pending_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cashAdvance_id->Visible) { // cashAdvance_id ?>
    <tr id="r_cashAdvance_id"<?= $Page->cashAdvance_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_cashAdvance_id"><?= $Page->cashAdvance_id->caption() ?></span></td>
        <td data-name="cashAdvance_id"<?= $Page->cashAdvance_id->cellAttributes() ?>>
<span id="el_pending_expense_cashAdvance_id">
<span<?= $Page->cashAdvance_id->viewAttributes() ?>>
<?= $Page->cashAdvance_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <tr id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_amount"><?= $Page->amount->caption() ?></span></td>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el_pending_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
    <tr id="r_dateTrans"<?= $Page->dateTrans->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_dateTrans"><?= $Page->dateTrans->caption() ?></span></td>
        <td data-name="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>>
<span id="el_pending_expense_dateTrans">
<span<?= $Page->dateTrans->viewAttributes() ?>>
<?= $Page->dateTrans->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
    <tr id="r_receipt"<?= $Page->receipt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_receipt"><?= $Page->receipt->caption() ?></span></td>
        <td data-name="receipt"<?= $Page->receipt->cellAttributes() ?>>
<span id="el_pending_expense_receipt">
<span>
<?= GetFileViewTag($Page->receipt, $Page->receipt->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
    <tr id="r_receiptNumber"<?= $Page->receiptNumber->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_receiptNumber"><?= $Page->receiptNumber->caption() ?></span></td>
        <td data-name="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>>
<span id="el_pending_expense_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <tr id="r_note"<?= $Page->note->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_note"><?= $Page->note->caption() ?></span></td>
        <td data-name="note"<?= $Page->note->cellAttributes() ?>>
<span id="el_pending_expense_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
    <tr id="r_submittedBy"<?= $Page->submittedBy->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_submittedBy"><?= $Page->submittedBy->caption() ?></span></td>
        <td data-name="submittedBy"<?= $Page->submittedBy->cellAttributes() ?>>
<span id="el_pending_expense_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<?= $Page->submittedBy->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_pending_expense_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
    <tr id="r_dateClosed"<?= $Page->dateClosed->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_dateClosed"><?= $Page->dateClosed->caption() ?></span></td>
        <td data-name="dateClosed"<?= $Page->dateClosed->cellAttributes() ?>>
<span id="el_pending_expense_dateClosed">
<span<?= $Page->dateClosed->viewAttributes() ?>>
<?= $Page->dateClosed->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->float_status->Visible) { // float_status ?>
    <tr id="r_float_status"<?= $Page->float_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_float_status"><?= $Page->float_status->caption() ?></span></td>
        <td data-name="float_status"<?= $Page->float_status->cellAttributes() ?>>
<span id="el_pending_expense_float_status">
<span<?= $Page->float_status->viewAttributes() ?>>
<?= $Page->float_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cash_float->Visible) { // cash_float ?>
    <tr id="r_cash_float"<?= $Page->cash_float->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_cash_float"><?= $Page->cash_float->caption() ?></span></td>
        <td data-name="cash_float"<?= $Page->cash_float->cellAttributes() ?>>
<span id="el_pending_expense_cash_float">
<span<?= $Page->cash_float->viewAttributes() ?>>
<?= $Page->cash_float->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
    <tr id="r_validatedBy"<?= $Page->validatedBy->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_validatedBy"><?= $Page->validatedBy->caption() ?></span></td>
        <td data-name="validatedBy"<?= $Page->validatedBy->cellAttributes() ?>>
<span id="el_pending_expense_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<?= $Page->validatedBy->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->machine_id->Visible) { // machine_id ?>
    <tr id="r_machine_id"<?= $Page->machine_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_machine_id"><?= $Page->machine_id->caption() ?></span></td>
        <td data-name="machine_id"<?= $Page->machine_id->cellAttributes() ?>>
<span id="el_pending_expense_machine_id">
<span<?= $Page->machine_id->viewAttributes() ?>>
<?= $Page->machine_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
    <tr id="r_expCategory_id"<?= $Page->expCategory_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pending_expense_expCategory_id"><?= $Page->expCategory_id->caption() ?></span></td>
        <td data-name="expCategory_id"<?= $Page->expCategory_id->cellAttributes() ?>>
<span id="el_pending_expense_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<?= $Page->expCategory_id->getViewValue() ?></span>
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
        $("#r_expCategory_id").hide();
        if ($("#el_pending_expense_expCategory_id")[0].textContent.trim() == "Maintenance") {
            $("#r_machine_id").show(); 
        }
    });
});
</script>
<?php } ?>
