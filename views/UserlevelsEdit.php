<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$UserlevelsEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { userlevels: currentTable } });
var currentForm, currentPageID;
var fuserlevelsedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuserlevelsedit = new ew.Form("fuserlevelsedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fuserlevelsedit;

    // Add fields
    var fields = currentTable.fields;
    fuserlevelsedit.addFields([
        ["userlevelid", [fields.userlevelid.visible && fields.userlevelid.required ? ew.Validators.required(fields.userlevelid.caption) : null, ew.Validators.userLevelId, ew.Validators.integer], fields.userlevelid.isInvalid],
        ["userlevelname", [fields.userlevelname.visible && fields.userlevelname.required ? ew.Validators.required(fields.userlevelname.caption) : null, ew.Validators.userLevelName('userlevelid')], fields.userlevelname.isInvalid]
    ]);

    // Form_CustomValidate
    fuserlevelsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuserlevelsedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fuserlevelsedit");
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
<form name="fuserlevelsedit" id="fuserlevelsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevels">
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
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
    <div id="r_userlevelid"<?= $Page->userlevelid->rowAttributes() ?>>
        <label id="elh_userlevels_userlevelid" for="x_userlevelid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->userlevelid->caption() ?><?= $Page->userlevelid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->userlevelid->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<input type="<?= $Page->userlevelid->getInputTextType() ?>" name="x_userlevelid" id="x_userlevelid" data-table="userlevels" data-field="x_userlevelid" value="<?= $Page->userlevelid->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->userlevelid->getPlaceHolder()) ?>"<?= $Page->userlevelid->editAttributes() ?> aria-describedby="x_userlevelid_help">
<?= $Page->userlevelid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->userlevelid->getErrorMessage() ?></div>
<input type="hidden" data-table="userlevels" data-field="x_userlevelid" data-hidden="1" name="o_userlevelid" id="o_userlevelid" value="<?= HtmlEncode($Page->userlevelid->OldValue ?? $Page->userlevelid->CurrentValue) ?>">
<?php } else { ?>
<span id="el_userlevels_userlevelid">
<span<?= $Page->userlevelid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->userlevelid->getDisplayValue($Page->userlevelid->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="userlevels" data-field="x_userlevelid" data-hidden="1" name="x_userlevelid" id="x_userlevelid" value="<?= HtmlEncode($Page->userlevelid->FormValue) ?>">
<input type="hidden" data-table="userlevels" data-field="x_userlevelid" data-hidden="1" name="o_userlevelid" id="o_userlevelid" value="<?= HtmlEncode($Page->userlevelid->OldValue ?? $Page->userlevelid->CurrentValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->userlevelname->Visible) { // userlevelname ?>
    <div id="r_userlevelname"<?= $Page->userlevelname->rowAttributes() ?>>
        <label id="elh_userlevels_userlevelname" for="x_userlevelname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->userlevelname->caption() ?><?= $Page->userlevelname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->userlevelname->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_userlevels_userlevelname">
<input type="<?= $Page->userlevelname->getInputTextType() ?>" name="x_userlevelname" id="x_userlevelname" data-table="userlevels" data-field="x_userlevelname" value="<?= $Page->userlevelname->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->userlevelname->getPlaceHolder()) ?>"<?= $Page->userlevelname->editAttributes() ?> aria-describedby="x_userlevelname_help">
<?= $Page->userlevelname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->userlevelname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_userlevels_userlevelname">
<span<?= $Page->userlevelname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->userlevelname->getDisplayValue($Page->userlevelname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="userlevels" data-field="x_userlevelname" data-hidden="1" name="x_userlevelname" id="x_userlevelname" value="<?= HtmlEncode($Page->userlevelname->FormValue) ?>">
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
    ew.addEventHandlers("userlevels");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
