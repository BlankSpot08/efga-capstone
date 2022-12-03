<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$PendingexpenseDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pendingexpense: currentTable } });
var currentForm, currentPageID;
var fpendingexpensedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpendingexpensedelete = new ew.Form("fpendingexpensedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fpendingexpensedelete;
    loadjs.done("fpendingexpensedelete");
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
<form name="fpendingexpensedelete" id="fpendingexpensedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendingexpense">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_pendingexpense_id" class="pendingexpense_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cashAdvance_id->Visible) { // cashAdvance_id ?>
        <th class="<?= $Page->cashAdvance_id->headerCellClass() ?>"><span id="elh_pendingexpense_cashAdvance_id" class="pendingexpense_cashAdvance_id"><?= $Page->cashAdvance_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th class="<?= $Page->amount->headerCellClass() ?>"><span id="elh_pendingexpense_amount" class="pendingexpense_amount"><?= $Page->amount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
        <th class="<?= $Page->dateTrans->headerCellClass() ?>"><span id="elh_pendingexpense_dateTrans" class="pendingexpense_dateTrans"><?= $Page->dateTrans->caption() ?></span></th>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
        <th class="<?= $Page->receipt->headerCellClass() ?>"><span id="elh_pendingexpense_receipt" class="pendingexpense_receipt"><?= $Page->receipt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
        <th class="<?= $Page->note->headerCellClass() ?>"><span id="elh_pendingexpense_note" class="pendingexpense_note"><?= $Page->note->caption() ?></span></th>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
        <th class="<?= $Page->submittedBy->headerCellClass() ?>"><span id="elh_pendingexpense_submittedBy" class="pendingexpense_submittedBy"><?= $Page->submittedBy->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_pendingexpense_status" class="pendingexpense_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
        <th class="<?= $Page->dateClosed->headerCellClass() ?>"><span id="elh_pendingexpense_dateClosed" class="pendingexpense_dateClosed"><?= $Page->dateClosed->caption() ?></span></th>
<?php } ?>
<?php if ($Page->float_status->Visible) { // float_status ?>
        <th class="<?= $Page->float_status->headerCellClass() ?>"><span id="elh_pendingexpense_float_status" class="pendingexpense_float_status"><?= $Page->float_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cash_float->Visible) { // cash_float ?>
        <th class="<?= $Page->cash_float->headerCellClass() ?>"><span id="elh_pendingexpense_cash_float" class="pendingexpense_cash_float"><?= $Page->cash_float->caption() ?></span></th>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
        <th class="<?= $Page->validatedBy->headerCellClass() ?>"><span id="elh_pendingexpense_validatedBy" class="pendingexpense_validatedBy"><?= $Page->validatedBy->caption() ?></span></th>
<?php } ?>
<?php if ($Page->machine_id->Visible) { // machine_id ?>
        <th class="<?= $Page->machine_id->headerCellClass() ?>"><span id="elh_pendingexpense_machine_id" class="pendingexpense_machine_id"><?= $Page->machine_id->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_pendingexpense_id" class="el_pendingexpense_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cashAdvance_id->Visible) { // cashAdvance_id ?>
        <td<?= $Page->cashAdvance_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_cashAdvance_id" class="el_pendingexpense_cashAdvance_id">
<span<?= $Page->cashAdvance_id->viewAttributes() ?>>
<?= $Page->cashAdvance_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <td<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_amount" class="el_pendingexpense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
        <td<?= $Page->dateTrans->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_dateTrans" class="el_pendingexpense_dateTrans">
<span<?= $Page->dateTrans->viewAttributes() ?>>
<?= $Page->dateTrans->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
        <td<?= $Page->receipt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_receipt" class="el_pendingexpense_receipt">
<span>
<?= GetFileViewTag($Page->receipt, $Page->receipt->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
        <td<?= $Page->note->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_note" class="el_pendingexpense_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
        <td<?= $Page->submittedBy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_submittedBy" class="el_pendingexpense_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<?= $Page->submittedBy->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_status" class="el_pendingexpense_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
        <td<?= $Page->dateClosed->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_dateClosed" class="el_pendingexpense_dateClosed">
<span<?= $Page->dateClosed->viewAttributes() ?>>
<?= $Page->dateClosed->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->float_status->Visible) { // float_status ?>
        <td<?= $Page->float_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_float_status" class="el_pendingexpense_float_status">
<span<?= $Page->float_status->viewAttributes() ?>>
<?= $Page->float_status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cash_float->Visible) { // cash_float ?>
        <td<?= $Page->cash_float->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_cash_float" class="el_pendingexpense_cash_float">
<span<?= $Page->cash_float->viewAttributes() ?>>
<?= $Page->cash_float->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
        <td<?= $Page->validatedBy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_validatedBy" class="el_pendingexpense_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<?= $Page->validatedBy->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->machine_id->Visible) { // machine_id ?>
        <td<?= $Page->machine_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendingexpense_machine_id" class="el_pendingexpense_machine_id">
<span<?= $Page->machine_id->viewAttributes() ?>>
<?= $Page->machine_id->getViewValue() ?></span>
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
