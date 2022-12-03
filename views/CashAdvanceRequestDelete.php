<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$CashAdvanceRequestDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cash_advance_request: currentTable } });
var currentForm, currentPageID;
var fcash_advance_requestdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fcash_advance_requestdelete = new ew.Form("fcash_advance_requestdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fcash_advance_requestdelete;
    loadjs.done("fcash_advance_requestdelete");
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
<form name="fcash_advance_requestdelete" id="fcash_advance_requestdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cash_advance_request">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_cash_advance_request_id" class="cash_advance_request_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
        <th class="<?= $Page->expCategory_id->headerCellClass() ?>"><span id="elh_cash_advance_request_expCategory_id" class="cash_advance_request_expCategory_id"><?= $Page->expCategory_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
        <th class="<?= $Page->expSubcategory_id->headerCellClass() ?>"><span id="elh_cash_advance_request_expSubcategory_id" class="cash_advance_request_expSubcategory_id"><?= $Page->expSubcategory_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->budget_id->Visible) { // budget_id ?>
        <th class="<?= $Page->budget_id->headerCellClass() ?>"><span id="elh_cash_advance_request_budget_id" class="cash_advance_request_budget_id"><?= $Page->budget_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dateReceived->Visible) { // dateReceived ?>
        <th class="<?= $Page->dateReceived->headerCellClass() ?>"><span id="elh_cash_advance_request_dateReceived" class="cash_advance_request_dateReceived"><?= $Page->dateReceived->caption() ?></span></th>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
        <th class="<?= $Page->submittedBy->headerCellClass() ?>"><span id="elh_cash_advance_request_submittedBy" class="cash_advance_request_submittedBy"><?= $Page->submittedBy->caption() ?></span></th>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
        <th class="<?= $Page->note->headerCellClass() ?>"><span id="elh_cash_advance_request_note" class="cash_advance_request_note"><?= $Page->note->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_cash_advance_request_status" class="cash_advance_request_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
        <th class="<?= $Page->validatedBy->headerCellClass() ?>"><span id="elh_cash_advance_request_validatedBy" class="cash_advance_request_validatedBy"><?= $Page->validatedBy->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_cash_advance_request_id" class="el_cash_advance_request_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
        <td<?= $Page->expCategory_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_expCategory_id" class="el_cash_advance_request_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<?= $Page->expCategory_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
        <td<?= $Page->expSubcategory_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_expSubcategory_id" class="el_cash_advance_request_expSubcategory_id">
<span<?= $Page->expSubcategory_id->viewAttributes() ?>>
<?= $Page->expSubcategory_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->budget_id->Visible) { // budget_id ?>
        <td<?= $Page->budget_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_budget_id" class="el_cash_advance_request_budget_id">
<span<?= $Page->budget_id->viewAttributes() ?>>
<?= $Page->budget_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dateReceived->Visible) { // dateReceived ?>
        <td<?= $Page->dateReceived->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_dateReceived" class="el_cash_advance_request_dateReceived">
<span<?= $Page->dateReceived->viewAttributes() ?>>
<?= $Page->dateReceived->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
        <td<?= $Page->submittedBy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_submittedBy" class="el_cash_advance_request_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<?= $Page->submittedBy->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
        <td<?= $Page->note->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_note" class="el_cash_advance_request_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_status" class="el_cash_advance_request_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
        <td<?= $Page->validatedBy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_validatedBy" class="el_cash_advance_request_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<?= $Page->validatedBy->getViewValue() ?></span>
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
