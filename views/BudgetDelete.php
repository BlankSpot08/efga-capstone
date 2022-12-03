<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$BudgetDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { budget: currentTable } });
var currentForm, currentPageID;
var fbudgetdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbudgetdelete = new ew.Form("fbudgetdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fbudgetdelete;
    loadjs.done("fbudgetdelete");
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
<form name="fbudgetdelete" id="fbudgetdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="budget">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_budget_id" class="budget_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
        <th class="<?= $Page->expCategory->headerCellClass() ?>"><span id="elh_budget_expCategory" class="budget_expCategory"><?= $Page->expCategory->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
        <th class="<?= $Page->expSubcategory->headerCellClass() ?>"><span id="elh_budget_expSubcategory" class="budget_expSubcategory"><?= $Page->expSubcategory->caption() ?></span></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th class="<?= $Page->amount->headerCellClass() ?>"><span id="elh_budget_amount" class="budget_amount"><?= $Page->amount->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_budget_id" class="el_budget_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
        <td<?= $Page->expCategory->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_budget_expCategory" class="el_budget_expCategory">
<span<?= $Page->expCategory->viewAttributes() ?>>
<?= $Page->expCategory->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
        <td<?= $Page->expSubcategory->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_budget_expSubcategory" class="el_budget_expSubcategory">
<span<?= $Page->expSubcategory->viewAttributes() ?>>
<?= $Page->expSubcategory->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <td<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_budget_amount" class="el_budget_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
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
