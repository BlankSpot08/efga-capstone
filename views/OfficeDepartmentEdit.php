<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$OfficeDepartmentEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { office_department: currentTable } });
var currentForm, currentPageID;
var foffice_departmentedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    foffice_departmentedit = new ew.Form("foffice_departmentedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = foffice_departmentedit;

    // Add fields
    var fields = currentTable.fields;
    foffice_departmentedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["officeDepartment", [fields.officeDepartment.visible && fields.officeDepartment.required ? ew.Validators.required(fields.officeDepartment.caption) : null], fields.officeDepartment.isInvalid]
    ]);

    // Form_CustomValidate
    foffice_departmentedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    foffice_departmentedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("foffice_departmentedit");
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
<form name="foffice_departmentedit" id="foffice_departmentedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="office_department">
<input type="hidden" name="k_hash" id="k_hash" value="<?= $Page->HashValue ?>">
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_office_department_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_office_department_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="office_department" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_office_department_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="office_department" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
    <div id="r_officeDepartment"<?= $Page->officeDepartment->rowAttributes() ?>>
        <label id="elh_office_department_officeDepartment" for="x_officeDepartment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->officeDepartment->caption() ?><?= $Page->officeDepartment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->officeDepartment->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_office_department_officeDepartment">
<input type="<?= $Page->officeDepartment->getInputTextType() ?>" name="x_officeDepartment" id="x_officeDepartment" data-table="office_department" data-field="x_officeDepartment" value="<?= $Page->officeDepartment->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->officeDepartment->getPlaceHolder()) ?>"<?= $Page->officeDepartment->editAttributes() ?> aria-describedby="x_officeDepartment_help">
<?= $Page->officeDepartment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->officeDepartment->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_office_department_officeDepartment">
<span<?= $Page->officeDepartment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->officeDepartment->getDisplayValue($Page->officeDepartment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="office_department" data-field="x_officeDepartment" data-hidden="1" name="x_officeDepartment" id="x_officeDepartment" value="<?= HtmlEncode($Page->officeDepartment->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" data-ew-action="set-action" data-value="overwrite"><?= $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" data-ew-action="set-action" data-value="show"><?= $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
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
    ew.addEventHandlers("office_department");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
