<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$CashAdvanceRequestEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cash_advance_request: currentTable } });
var currentForm, currentPageID;
var fcash_advance_requestedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fcash_advance_requestedit = new ew.Form("fcash_advance_requestedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fcash_advance_requestedit;

    // Add fields
    var fields = currentTable.fields;
    fcash_advance_requestedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["expCategory_id", [fields.expCategory_id.visible && fields.expCategory_id.required ? ew.Validators.required(fields.expCategory_id.caption) : null], fields.expCategory_id.isInvalid],
        ["expSubcategory_id", [fields.expSubcategory_id.visible && fields.expSubcategory_id.required ? ew.Validators.required(fields.expSubcategory_id.caption) : null], fields.expSubcategory_id.isInvalid],
        ["budget_id", [fields.budget_id.visible && fields.budget_id.required ? ew.Validators.required(fields.budget_id.caption) : null], fields.budget_id.isInvalid],
        ["machine_id", [fields.machine_id.visible && fields.machine_id.required ? ew.Validators.required(fields.machine_id.caption) : null], fields.machine_id.isInvalid],
        ["dateReceived", [fields.dateReceived.visible && fields.dateReceived.required ? ew.Validators.required(fields.dateReceived.caption) : null, ew.Validators.datetime(fields.dateReceived.clientFormatPattern)], fields.dateReceived.isInvalid],
        ["submittedBy", [fields.submittedBy.visible && fields.submittedBy.required ? ew.Validators.required(fields.submittedBy.caption) : null], fields.submittedBy.isInvalid],
        ["note", [fields.note.visible && fields.note.required ? ew.Validators.required(fields.note.caption) : null], fields.note.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Form_CustomValidate
    fcash_advance_requestedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcash_advance_requestedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fcash_advance_requestedit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fcash_advance_requestedit");
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
<form name="fcash_advance_requestedit" id="fcash_advance_requestedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cash_advance_request">
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
        <label id="elh_cash_advance_request_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_request_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_request_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
    <div id="r_expCategory_id"<?= $Page->expCategory_id->rowAttributes() ?>>
        <label id="elh_cash_advance_request_expCategory_id" for="x_expCategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expCategory_id->caption() ?><?= $Page->expCategory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expCategory_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_request_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expCategory_id->getDisplayValue($Page->expCategory_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_expCategory_id" data-hidden="1" name="x_expCategory_id" id="x_expCategory_id" value="<?= HtmlEncode($Page->expCategory_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_request_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expCategory_id->getDisplayValue($Page->expCategory_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_expCategory_id" data-hidden="1" name="x_expCategory_id" id="x_expCategory_id" value="<?= HtmlEncode($Page->expCategory_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
    <div id="r_expSubcategory_id"<?= $Page->expSubcategory_id->rowAttributes() ?>>
        <label id="elh_cash_advance_request_expSubcategory_id" for="x_expSubcategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expSubcategory_id->caption() ?><?= $Page->expSubcategory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expSubcategory_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_request_expSubcategory_id">
<span<?= $Page->expSubcategory_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expSubcategory_id->getDisplayValue($Page->expSubcategory_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_expSubcategory_id" data-hidden="1" name="x_expSubcategory_id" id="x_expSubcategory_id" value="<?= HtmlEncode($Page->expSubcategory_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_request_expSubcategory_id">
<span<?= $Page->expSubcategory_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expSubcategory_id->getDisplayValue($Page->expSubcategory_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_expSubcategory_id" data-hidden="1" name="x_expSubcategory_id" id="x_expSubcategory_id" value="<?= HtmlEncode($Page->expSubcategory_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->budget_id->Visible) { // budget_id ?>
    <div id="r_budget_id"<?= $Page->budget_id->rowAttributes() ?>>
        <label id="elh_cash_advance_request_budget_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->budget_id->caption() ?><?= $Page->budget_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->budget_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_request_budget_id">
<span<?= $Page->budget_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->budget_id->getDisplayValue($Page->budget_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_budget_id" data-hidden="1" name="x_budget_id" id="x_budget_id" value="<?= HtmlEncode($Page->budget_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_request_budget_id">
<span<?= $Page->budget_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->budget_id->getDisplayValue($Page->budget_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_budget_id" data-hidden="1" name="x_budget_id" id="x_budget_id" value="<?= HtmlEncode($Page->budget_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->machine_id->Visible) { // machine_id ?>
    <div id="r_machine_id"<?= $Page->machine_id->rowAttributes() ?>>
        <label id="elh_cash_advance_request_machine_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->machine_id->caption() ?><?= $Page->machine_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->machine_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_request_machine_id">
<span<?= $Page->machine_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->machine_id->getDisplayValue($Page->machine_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_machine_id" data-hidden="1" name="x_machine_id" id="x_machine_id" value="<?= HtmlEncode($Page->machine_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_request_machine_id">
<span<?= $Page->machine_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->machine_id->getDisplayValue($Page->machine_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_machine_id" data-hidden="1" name="x_machine_id" id="x_machine_id" value="<?= HtmlEncode($Page->machine_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateReceived->Visible) { // dateReceived ?>
    <div id="r_dateReceived"<?= $Page->dateReceived->rowAttributes() ?>>
        <label id="elh_cash_advance_request_dateReceived" for="x_dateReceived" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateReceived->caption() ?><?= $Page->dateReceived->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateReceived->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_request_dateReceived">
<input type="<?= $Page->dateReceived->getInputTextType() ?>" name="x_dateReceived" id="x_dateReceived" data-table="cash_advance_request" data-field="x_dateReceived" value="<?= $Page->dateReceived->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateReceived->getPlaceHolder()) ?>"<?= $Page->dateReceived->editAttributes() ?> aria-describedby="x_dateReceived_help">
<?= $Page->dateReceived->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateReceived->getErrorMessage() ?></div>
<?php if (!$Page->dateReceived->ReadOnly && !$Page->dateReceived->Disabled && !isset($Page->dateReceived->EditAttrs["readonly"]) && !isset($Page->dateReceived->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcash_advance_requestedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fcash_advance_requestedit", "x_dateReceived", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_cash_advance_request_dateReceived">
<span<?= $Page->dateReceived->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateReceived->getDisplayValue($Page->dateReceived->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_dateReceived" data-hidden="1" name="x_dateReceived" id="x_dateReceived" value="<?= HtmlEncode($Page->dateReceived->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
    <div id="r_submittedBy"<?= $Page->submittedBy->rowAttributes() ?>>
        <label id="elh_cash_advance_request_submittedBy" for="x_submittedBy" class="<?= $Page->LeftColumnClass ?>"><?= $Page->submittedBy->caption() ?><?= $Page->submittedBy->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->submittedBy->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_request_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->submittedBy->getDisplayValue($Page->submittedBy->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_submittedBy" data-hidden="1" name="x_submittedBy" id="x_submittedBy" value="<?= HtmlEncode($Page->submittedBy->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_request_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->submittedBy->getDisplayValue($Page->submittedBy->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_submittedBy" data-hidden="1" name="x_submittedBy" id="x_submittedBy" value="<?= HtmlEncode($Page->submittedBy->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <div id="r_note"<?= $Page->note->rowAttributes() ?>>
        <label id="elh_cash_advance_request_note" for="x_note" class="<?= $Page->LeftColumnClass ?>"><?= $Page->note->caption() ?><?= $Page->note->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->note->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_request_note">
<span<?= $Page->note->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->note->getDisplayValue($Page->note->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_note" data-hidden="1" name="x_note" id="x_note" value="<?= HtmlEncode($Page->note->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_request_note">
<span<?= $Page->note->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->note->getDisplayValue($Page->note->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_note" data-hidden="1" name="x_note" id="x_note" value="<?= HtmlEncode($Page->note->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_cash_advance_request_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_request_status">
<template id="tp_x_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cash_advance_request" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_status"
    name="x_status"
    value="<?= HtmlEncode($Page->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status"
    data-bs-target="dsl_x_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status->isInvalidClass() ?>"
    data-table="cash_advance_request"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>></selection-list>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_cash_advance_request_status">
<span<?= $Page->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status->getDisplayValue($Page->status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance_request" data-field="x_status" data-hidden="1" name="x_status" id="x_status" value="<?= HtmlEncode($Page->status->FormValue) ?>">
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
    ew.addEventHandlers("cash_advance_request");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    $(document).ready(function(){ 
        $("#r_machine_id").hide(); 
        if ($("#el_cash_advance_request_expCategory_id")[0].textContent.trim() == "Maintenance") {
            $("#r_machine_id").show(); 
        }
    });
});
</script>
