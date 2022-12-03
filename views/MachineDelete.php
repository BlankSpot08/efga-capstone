<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$MachineDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { machine: currentTable } });
var currentForm, currentPageID;
var fmachinedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmachinedelete = new ew.Form("fmachinedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fmachinedelete;
    loadjs.done("fmachinedelete");
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
<form name="fmachinedelete" id="fmachinedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="machine">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_machine_id" class="machine_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->machine_category_id->Visible) { // machine_category_id ?>
        <th class="<?= $Page->machine_category_id->headerCellClass() ?>"><span id="elh_machine_machine_category_id" class="machine_machine_category_id"><?= $Page->machine_category_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
        <th class="<?= $Page->brand_id->headerCellClass() ?>"><span id="elh_machine_brand_id" class="machine_brand_id"><?= $Page->brand_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->model->Visible) { // model ?>
        <th class="<?= $Page->model->headerCellClass() ?>"><span id="elh_machine_model" class="machine_model"><?= $Page->model->caption() ?></span></th>
<?php } ?>
<?php if ($Page->repairCount->Visible) { // repairCount ?>
        <th class="<?= $Page->repairCount->headerCellClass() ?>"><span id="elh_machine_repairCount" class="machine_repairCount"><?= $Page->repairCount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
        <th class="<?= $Page->photo->headerCellClass() ?>"><span id="elh_machine_photo" class="machine_photo"><?= $Page->photo->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_machine_id" class="el_machine_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->machine_category_id->Visible) { // machine_category_id ?>
        <td<?= $Page->machine_category_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machine_machine_category_id" class="el_machine_machine_category_id">
<span<?= $Page->machine_category_id->viewAttributes() ?>>
<?= $Page->machine_category_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
        <td<?= $Page->brand_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machine_brand_id" class="el_machine_brand_id">
<span<?= $Page->brand_id->viewAttributes() ?>>
<?= $Page->brand_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->model->Visible) { // model ?>
        <td<?= $Page->model->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machine_model" class="el_machine_model">
<span<?= $Page->model->viewAttributes() ?>>
<?= $Page->model->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->repairCount->Visible) { // repairCount ?>
        <td<?= $Page->repairCount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machine_repairCount" class="el_machine_repairCount">
<span<?= $Page->repairCount->viewAttributes() ?>>
<?= $Page->repairCount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
        <td<?= $Page->photo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machine_photo" class="el_machine_photo">
<span>
<?= GetFileViewTag($Page->photo, $Page->photo->getViewValue(), false) ?>
</span>
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
