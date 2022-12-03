<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$MachineBrandAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { machine_brand: currentTable } });
var currentForm, currentPageID;
var fmachine_brandadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmachine_brandadd = new ew.Form("fmachine_brandadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fmachine_brandadd;

    // Add fields
    var fields = currentTable.fields;
    fmachine_brandadd.addFields([
        ["brand", [fields.brand.visible && fields.brand.required ? ew.Validators.required(fields.brand.caption) : null], fields.brand.isInvalid]
    ]);

    // Form_CustomValidate
    fmachine_brandadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmachine_brandadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fmachine_brandadd");
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
<form name="fmachine_brandadd" id="fmachine_brandadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="machine_brand">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->brand->Visible) { // brand ?>
    <div id="r_brand"<?= $Page->brand->rowAttributes() ?>>
        <label id="elh_machine_brand_brand" for="x_brand" class="<?= $Page->LeftColumnClass ?>"><?= $Page->brand->caption() ?><?= $Page->brand->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->brand->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_machine_brand_brand">
<input type="<?= $Page->brand->getInputTextType() ?>" name="x_brand" id="x_brand" data-table="machine_brand" data-field="x_brand" value="<?= $Page->brand->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->brand->getPlaceHolder()) ?>"<?= $Page->brand->editAttributes() ?> aria-describedby="x_brand_help">
<?= $Page->brand->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->brand->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_machine_brand_brand">
<span<?= $Page->brand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->brand->getDisplayValue($Page->brand->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="machine_brand" data-field="x_brand" data-hidden="1" name="x_brand" id="x_brand" value="<?= HtmlEncode($Page->brand->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("machine_brand");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
