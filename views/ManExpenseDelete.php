<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$ManExpenseDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { man_expense: currentTable } });
var currentForm, currentPageID;
var fman_expensedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fman_expensedelete = new ew.Form("fman_expensedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fman_expensedelete;
    loadjs.done("fman_expensedelete");
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
<form name="fman_expensedelete" id="fman_expensedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="man_expense">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_man_expense_id" class="man_expense_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
        <th class="<?= $Page->expCategory->headerCellClass() ?>"><span id="elh_man_expense_expCategory" class="man_expense_expCategory"><?= $Page->expCategory->caption() ?></span></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th class="<?= $Page->amount->headerCellClass() ?>"><span id="elh_man_expense_amount" class="man_expense_amount"><?= $Page->amount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
        <th class="<?= $Page->receipt->headerCellClass() ?>"><span id="elh_man_expense_receipt" class="man_expense_receipt"><?= $Page->receipt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
        <th class="<?= $Page->receiptNumber->headerCellClass() ?>"><span id="elh_man_expense_receiptNumber" class="man_expense_receiptNumber"><?= $Page->receiptNumber->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <th class="<?= $Page->date->headerCellClass() ?>"><span id="elh_man_expense_date" class="man_expense_date"><?= $Page->date->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_man_expense_id" class="el_man_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
        <td<?= $Page->expCategory->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_man_expense_expCategory" class="el_man_expense_expCategory">
<span<?= $Page->expCategory->viewAttributes() ?>>
<?= $Page->expCategory->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <td<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_man_expense_amount" class="el_man_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
        <td<?= $Page->receipt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_man_expense_receipt" class="el_man_expense_receipt">
<span>
<?= GetFileViewTag($Page->receipt, $Page->receipt->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
        <td<?= $Page->receiptNumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_man_expense_receiptNumber" class="el_man_expense_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <td<?= $Page->date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_man_expense_date" class="el_man_expense_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
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
