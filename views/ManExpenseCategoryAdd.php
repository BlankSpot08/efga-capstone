<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$ManExpenseCategoryAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { man_expense_category: currentTable } });
var currentForm, currentPageID;
var fman_expense_categoryadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fman_expense_categoryadd = new ew.Form("fman_expense_categoryadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fman_expense_categoryadd;

    // Add fields
    var fields = currentTable.fields;
    fman_expense_categoryadd.addFields([
        ["expCategory", [fields.expCategory.visible && fields.expCategory.required ? ew.Validators.required(fields.expCategory.caption) : null], fields.expCategory.isInvalid]
    ]);

    // Form_CustomValidate
    fman_expense_categoryadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fman_expense_categoryadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fman_expense_categoryadd");
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
<form name="fman_expense_categoryadd" id="fman_expense_categoryadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="man_expense_category">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->expCategory->Visible) { // expCategory ?>
    <div id="r_expCategory"<?= $Page->expCategory->rowAttributes() ?>>
        <label id="elh_man_expense_category_expCategory" for="x_expCategory" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expCategory->caption() ?><?= $Page->expCategory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expCategory->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_category_expCategory">
<input type="<?= $Page->expCategory->getInputTextType() ?>" name="x_expCategory" id="x_expCategory" data-table="man_expense_category" data-field="x_expCategory" value="<?= $Page->expCategory->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->expCategory->getPlaceHolder()) ?>"<?= $Page->expCategory->editAttributes() ?> aria-describedby="x_expCategory_help">
<?= $Page->expCategory->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->expCategory->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_man_expense_category_expCategory">
<span<?= $Page->expCategory->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->expCategory->getDisplayValue($Page->expCategory->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="man_expense_category" data-field="x_expCategory" data-hidden="1" name="x_expCategory" id="x_expCategory" value="<?= HtmlEncode($Page->expCategory->FormValue) ?>">
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
    ew.addEventHandlers("man_expense_category");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
