<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$ManExpenseView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { man_expense: currentTable } });
var currentForm, currentPageID;
var fman_expenseview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fman_expenseview = new ew.Form("fman_expenseview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fman_expenseview;
    loadjs.done("fman_expenseview");
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
<form name="fman_expenseview" id="fman_expenseview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="man_expense">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_man_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
    <tr id="r_expCategory"<?= $Page->expCategory->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_expCategory"><?= $Page->expCategory->caption() ?></span></td>
        <td data-name="expCategory"<?= $Page->expCategory->cellAttributes() ?>>
<span id="el_man_expense_expCategory">
<span<?= $Page->expCategory->viewAttributes() ?>>
<?= $Page->expCategory->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
    <tr id="r_expSubcategory"<?= $Page->expSubcategory->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_expSubcategory"><?= $Page->expSubcategory->caption() ?></span></td>
        <td data-name="expSubcategory"<?= $Page->expSubcategory->cellAttributes() ?>>
<span id="el_man_expense_expSubcategory">
<span<?= $Page->expSubcategory->viewAttributes() ?>>
<?= $Page->expSubcategory->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <tr id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_amount"><?= $Page->amount->caption() ?></span></td>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el_man_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
    <tr id="r_receipt"<?= $Page->receipt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_receipt"><?= $Page->receipt->caption() ?></span></td>
        <td data-name="receipt"<?= $Page->receipt->cellAttributes() ?>>
<span id="el_man_expense_receipt">
<span>
<?= GetFileViewTag($Page->receipt, $Page->receipt->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
    <tr id="r_receiptNumber"<?= $Page->receiptNumber->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_receiptNumber"><?= $Page->receiptNumber->caption() ?></span></td>
        <td data-name="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>>
<span id="el_man_expense_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
    <tr id="r_date"<?= $Page->date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_date"><?= $Page->date->caption() ?></span></td>
        <td data-name="date"<?= $Page->date->cellAttributes() ?>>
<span id="el_man_expense_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dateFrom->Visible) { // dateFrom ?>
    <tr id="r_dateFrom"<?= $Page->dateFrom->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_dateFrom"><?= $Page->dateFrom->caption() ?></span></td>
        <td data-name="dateFrom"<?= $Page->dateFrom->cellAttributes() ?>>
<span id="el_man_expense_dateFrom">
<span<?= $Page->dateFrom->viewAttributes() ?>>
<?= $Page->dateFrom->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dateTo->Visible) { // dateTo ?>
    <tr id="r_dateTo"<?= $Page->dateTo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_dateTo"><?= $Page->dateTo->caption() ?></span></td>
        <td data-name="dateTo"<?= $Page->dateTo->cellAttributes() ?>>
<span id="el_man_expense_dateTo">
<span<?= $Page->dateTo->viewAttributes() ?>>
<?= $Page->dateTo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->consumption->Visible) { // consumption ?>
    <tr id="r_consumption"<?= $Page->consumption->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_consumption"><?= $Page->consumption->caption() ?></span></td>
        <td data-name="consumption"<?= $Page->consumption->cellAttributes() ?>>
<span id="el_man_expense_consumption">
<span<?= $Page->consumption->viewAttributes() ?>>
<?= $Page->consumption->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <tr id="r_note"<?= $Page->note->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_man_expense_note"><?= $Page->note->caption() ?></span></td>
        <td data-name="note"<?= $Page->note->cellAttributes() ?>>
<span id="el_man_expense_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
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
    // Write your table-specific startup script here, no need to add script tags.\\
    $("#r_dateFrom").hide(); 
    $("#r_dateTo").hide(); 
    $("#r_consumption").hide(); 
    $("#r_expSubcategory").hide(); 
    if ($("#el_man_expense_expCategory")[0].textContent.trim() == "Utilities") {
        if ($("#el_man_expense_expSubcategory")[0].textContent.trim() != "Internet Bill") {
            $("#r_consumption").show();
        }
        $("#r_date").hide(); 
        $("#r_dateFrom").show();
        $("#r_dateTo").show();
        $("#r_expSubcategory").show();
    }
});
</script>
<?php } ?>
