<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$MachineView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { machine: currentTable } });
var currentForm, currentPageID;
var fmachineview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmachineview = new ew.Form("fmachineview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fmachineview;
    loadjs.done("fmachineview");
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
<form name="fmachineview" id="fmachineview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="machine">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_machine_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_machine_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->machine_category_id->Visible) { // machine_category_id ?>
    <tr id="r_machine_category_id"<?= $Page->machine_category_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_machine_machine_category_id"><?= $Page->machine_category_id->caption() ?></span></td>
        <td data-name="machine_category_id"<?= $Page->machine_category_id->cellAttributes() ?>>
<span id="el_machine_machine_category_id">
<span<?= $Page->machine_category_id->viewAttributes() ?>>
<?= $Page->machine_category_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
    <tr id="r_brand_id"<?= $Page->brand_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_machine_brand_id"><?= $Page->brand_id->caption() ?></span></td>
        <td data-name="brand_id"<?= $Page->brand_id->cellAttributes() ?>>
<span id="el_machine_brand_id">
<span<?= $Page->brand_id->viewAttributes() ?>>
<?= $Page->brand_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->model->Visible) { // model ?>
    <tr id="r_model"<?= $Page->model->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_machine_model"><?= $Page->model->caption() ?></span></td>
        <td data-name="model"<?= $Page->model->cellAttributes() ?>>
<span id="el_machine_model">
<span<?= $Page->model->viewAttributes() ?>>
<?= $Page->model->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->repairCount->Visible) { // repairCount ?>
    <tr id="r_repairCount"<?= $Page->repairCount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_machine_repairCount"><?= $Page->repairCount->caption() ?></span></td>
        <td data-name="repairCount"<?= $Page->repairCount->cellAttributes() ?>>
<span id="el_machine_repairCount">
<span<?= $Page->repairCount->viewAttributes() ?>>
<?= $Page->repairCount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
    <tr id="r_photo"<?= $Page->photo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_machine_photo"><?= $Page->photo->caption() ?></span></td>
        <td data-name="photo"<?= $Page->photo->cellAttributes() ?>>
<span id="el_machine_photo">
<span>
<?= GetFileViewTag($Page->photo, $Page->photo->getViewValue(), false) ?>
</span>
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
