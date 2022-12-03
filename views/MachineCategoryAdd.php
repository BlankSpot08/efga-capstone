<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$MachineCategoryAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { machine_category: currentTable } });
var currentForm, currentPageID;
var fmachine_categoryadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmachine_categoryadd = new ew.Form("fmachine_categoryadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fmachine_categoryadd;

    // Add fields
    var fields = currentTable.fields;
    fmachine_categoryadd.addFields([
        ["machine_category", [fields.machine_category.visible && fields.machine_category.required ? ew.Validators.required(fields.machine_category.caption) : null], fields.machine_category.isInvalid]
    ]);

    // Form_CustomValidate
    fmachine_categoryadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmachine_categoryadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fmachine_categoryadd");
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
<form name="fmachine_categoryadd" id="fmachine_categoryadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="machine_category">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->machine_category->Visible) { // machine_category ?>
    <div id="r_machine_category"<?= $Page->machine_category->rowAttributes() ?>>
        <label id="elh_machine_category_machine_category" for="x_machine_category" class="<?= $Page->LeftColumnClass ?>"><?= $Page->machine_category->caption() ?><?= $Page->machine_category->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->machine_category->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_machine_category_machine_category">
<input type="<?= $Page->machine_category->getInputTextType() ?>" name="x_machine_category" id="x_machine_category" data-table="machine_category" data-field="x_machine_category" value="<?= $Page->machine_category->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->machine_category->getPlaceHolder()) ?>"<?= $Page->machine_category->editAttributes() ?> aria-describedby="x_machine_category_help">
<?= $Page->machine_category->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->machine_category->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_machine_category_machine_category">
<span<?= $Page->machine_category->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->machine_category->getDisplayValue($Page->machine_category->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="machine_category" data-field="x_machine_category" data-hidden="1" name="x_machine_category" id="x_machine_category" value="<?= HtmlEncode($Page->machine_category->FormValue) ?>">
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
    ew.addEventHandlers("machine_category");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
