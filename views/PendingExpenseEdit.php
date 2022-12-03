<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$PendingExpenseEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pending_expense: currentTable } });
var currentForm, currentPageID;
var fpending_expenseedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpending_expenseedit = new ew.Form("fpending_expenseedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fpending_expenseedit;

    // Add fields
    var fields = currentTable.fields;
    fpending_expenseedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["cashAdvance_id", [fields.cashAdvance_id.visible && fields.cashAdvance_id.required ? ew.Validators.required(fields.cashAdvance_id.caption) : null], fields.cashAdvance_id.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null], fields.amount.isInvalid],
        ["dateTrans", [fields.dateTrans.visible && fields.dateTrans.required ? ew.Validators.required(fields.dateTrans.caption) : null], fields.dateTrans.isInvalid],
        ["receipt", [fields.receipt.visible && fields.receipt.required ? ew.Validators.fileRequired(fields.receipt.caption) : null], fields.receipt.isInvalid],
        ["receiptNumber", [fields.receiptNumber.visible && fields.receiptNumber.required ? ew.Validators.required(fields.receiptNumber.caption) : null], fields.receiptNumber.isInvalid],
        ["note", [fields.note.visible && fields.note.required ? ew.Validators.required(fields.note.caption) : null], fields.note.isInvalid],
        ["submittedBy", [fields.submittedBy.visible && fields.submittedBy.required ? ew.Validators.required(fields.submittedBy.caption) : null], fields.submittedBy.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["dateClosed", [fields.dateClosed.visible && fields.dateClosed.required ? ew.Validators.required(fields.dateClosed.caption) : null, ew.Validators.datetime(fields.dateClosed.clientFormatPattern)], fields.dateClosed.isInvalid],
        ["float_status", [fields.float_status.visible && fields.float_status.required ? ew.Validators.required(fields.float_status.caption) : null], fields.float_status.isInvalid],
        ["cash_float", [fields.cash_float.visible && fields.cash_float.required ? ew.Validators.required(fields.cash_float.caption) : null], fields.cash_float.isInvalid],
        ["validatedBy", [fields.validatedBy.visible && fields.validatedBy.required ? ew.Validators.required(fields.validatedBy.caption) : null], fields.validatedBy.isInvalid],
        ["machine_id", [fields.machine_id.visible && fields.machine_id.required ? ew.Validators.required(fields.machine_id.caption) : null], fields.machine_id.isInvalid],
        ["expCategory_id", [fields.expCategory_id.visible && fields.expCategory_id.required ? ew.Validators.required(fields.expCategory_id.caption) : null], fields.expCategory_id.isInvalid]
    ]);

    // Form_CustomValidate
    fpending_expenseedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpending_expenseedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fpending_expenseedit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    fpending_expenseedit.lists.float_status = <?= $Page->float_status->toClientList($Page) ?>;
    loadjs.done("fpending_expenseedit");
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
<form name="fpending_expenseedit" id="fpending_expenseedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pending_expense">
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
        <label id="elh_pending_expense_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cashAdvance_id->Visible) { // cashAdvance_id ?>
    <div id="r_cashAdvance_id"<?= $Page->cashAdvance_id->rowAttributes() ?>>
        <label id="elh_pending_expense_cashAdvance_id" for="x_cashAdvance_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cashAdvance_id->caption() ?><?= $Page->cashAdvance_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cashAdvance_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_cashAdvance_id">
<span<?= $Page->cashAdvance_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->cashAdvance_id->getDisplayValue($Page->cashAdvance_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_cashAdvance_id" data-hidden="1" name="x_cashAdvance_id" id="x_cashAdvance_id" value="<?= HtmlEncode($Page->cashAdvance_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_cashAdvance_id">
<span<?= $Page->cashAdvance_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->cashAdvance_id->getDisplayValue($Page->cashAdvance_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_cashAdvance_id" data-hidden="1" name="x_cashAdvance_id" id="x_cashAdvance_id" value="<?= HtmlEncode($Page->cashAdvance_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <label id="elh_pending_expense_amount" for="x_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount->caption() ?><?= $Page->amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amount->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->amount->getDisplayValue($Page->amount->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_amount" data-hidden="1" name="x_amount" id="x_amount" value="<?= HtmlEncode($Page->amount->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->amount->getDisplayValue($Page->amount->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_amount" data-hidden="1" name="x_amount" id="x_amount" value="<?= HtmlEncode($Page->amount->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
    <div id="r_dateTrans"<?= $Page->dateTrans->rowAttributes() ?>>
        <label id="elh_pending_expense_dateTrans" for="x_dateTrans" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateTrans->caption() ?><?= $Page->dateTrans->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateTrans->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_dateTrans">
<span<?= $Page->dateTrans->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateTrans->getDisplayValue($Page->dateTrans->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_dateTrans" data-hidden="1" name="x_dateTrans" id="x_dateTrans" value="<?= HtmlEncode($Page->dateTrans->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_dateTrans">
<span<?= $Page->dateTrans->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateTrans->getDisplayValue($Page->dateTrans->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_dateTrans" data-hidden="1" name="x_dateTrans" id="x_dateTrans" value="<?= HtmlEncode($Page->dateTrans->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
    <div id="r_receipt"<?= $Page->receipt->rowAttributes() ?>>
        <label id="elh_pending_expense_receipt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receipt->caption() ?><?= $Page->receipt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receipt->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_receipt">
<span>
<?= GetFileViewTag($Page->receipt, $Page->receipt->EditValue, false) ?>
</span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_receipt" data-hidden="1" name="x_receipt" id="x_receipt" value="<?= HtmlEncode($Page->receipt->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_receipt">
<span>
<?= GetFileViewTag($Page->receipt, $Page->receipt->EditValue, false) ?>
</span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_receipt" data-hidden="1" name="x_receipt" id="x_receipt" value="<?= HtmlEncode($Page->receipt->CurrentValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
    <div id="r_receiptNumber"<?= $Page->receiptNumber->rowAttributes() ?>>
        <label id="elh_pending_expense_receiptNumber" for="x_receiptNumber" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receiptNumber->caption() ?><?= $Page->receiptNumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receiptNumber->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->receiptNumber->getDisplayValue($Page->receiptNumber->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_receiptNumber" data-hidden="1" name="x_receiptNumber" id="x_receiptNumber" value="<?= HtmlEncode($Page->receiptNumber->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->receiptNumber->getDisplayValue($Page->receiptNumber->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_receiptNumber" data-hidden="1" name="x_receiptNumber" id="x_receiptNumber" value="<?= HtmlEncode($Page->receiptNumber->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <div id="r_note"<?= $Page->note->rowAttributes() ?>>
        <label id="elh_pending_expense_note" for="x_note" class="<?= $Page->LeftColumnClass ?>"><?= $Page->note->caption() ?><?= $Page->note->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->note->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_note">
<span<?= $Page->note->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->note->getDisplayValue($Page->note->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_note" data-hidden="1" name="x_note" id="x_note" value="<?= HtmlEncode($Page->note->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_note">
<span<?= $Page->note->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->note->getDisplayValue($Page->note->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_note" data-hidden="1" name="x_note" id="x_note" value="<?= HtmlEncode($Page->note->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
    <div id="r_submittedBy"<?= $Page->submittedBy->rowAttributes() ?>>
        <label id="elh_pending_expense_submittedBy" for="x_submittedBy" class="<?= $Page->LeftColumnClass ?>"><?= $Page->submittedBy->caption() ?><?= $Page->submittedBy->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->submittedBy->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->submittedBy->getDisplayValue($Page->submittedBy->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_submittedBy" data-hidden="1" name="x_submittedBy" id="x_submittedBy" value="<?= HtmlEncode($Page->submittedBy->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->submittedBy->getDisplayValue($Page->submittedBy->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_submittedBy" data-hidden="1" name="x_submittedBy" id="x_submittedBy" value="<?= HtmlEncode($Page->submittedBy->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_pending_expense_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_status">
<template id="tp_x_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="pending_expense" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
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
    data-table="pending_expense"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>></selection-list>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_pending_expense_status">
<span<?= $Page->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status->getDisplayValue($Page->status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_status" data-hidden="1" name="x_status" id="x_status" value="<?= HtmlEncode($Page->status->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
    <div id="r_dateClosed"<?= $Page->dateClosed->rowAttributes() ?>>
        <label id="elh_pending_expense_dateClosed" for="x_dateClosed" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateClosed->caption() ?><?= $Page->dateClosed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateClosed->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_dateClosed">
<input type="<?= $Page->dateClosed->getInputTextType() ?>" name="x_dateClosed" id="x_dateClosed" data-table="pending_expense" data-field="x_dateClosed" value="<?= $Page->dateClosed->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateClosed->getPlaceHolder()) ?>"<?= $Page->dateClosed->editAttributes() ?> aria-describedby="x_dateClosed_help">
<?= $Page->dateClosed->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateClosed->getErrorMessage() ?></div>
<?php if (!$Page->dateClosed->ReadOnly && !$Page->dateClosed->Disabled && !isset($Page->dateClosed->EditAttrs["readonly"]) && !isset($Page->dateClosed->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpending_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpending_expenseedit", "x_dateClosed", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_pending_expense_dateClosed">
<span<?= $Page->dateClosed->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateClosed->getDisplayValue($Page->dateClosed->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_dateClosed" data-hidden="1" name="x_dateClosed" id="x_dateClosed" value="<?= HtmlEncode($Page->dateClosed->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->float_status->Visible) { // float_status ?>
    <div id="r_float_status"<?= $Page->float_status->rowAttributes() ?>>
        <label id="elh_pending_expense_float_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->float_status->caption() ?><?= $Page->float_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->float_status->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_float_status">
<template id="tp_x_float_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="pending_expense" data-field="x_float_status" name="x_float_status" id="x_float_status"<?= $Page->float_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_float_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_float_status"
    name="x_float_status"
    value="<?= HtmlEncode($Page->float_status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_float_status"
    data-bs-target="dsl_x_float_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->float_status->isInvalidClass() ?>"
    data-table="pending_expense"
    data-field="x_float_status"
    data-value-separator="<?= $Page->float_status->displayValueSeparatorAttribute() ?>"
    <?= $Page->float_status->editAttributes() ?>></selection-list>
<?= $Page->float_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->float_status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_pending_expense_float_status">
<span<?= $Page->float_status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->float_status->getDisplayValue($Page->float_status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_float_status" data-hidden="1" name="x_float_status" id="x_float_status" value="<?= HtmlEncode($Page->float_status->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cash_float->Visible) { // cash_float ?>
    <div id="r_cash_float"<?= $Page->cash_float->rowAttributes() ?>>
        <label id="elh_pending_expense_cash_float" for="x_cash_float" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cash_float->caption() ?><?= $Page->cash_float->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cash_float->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_cash_float">
<span<?= $Page->cash_float->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cash_float->getDisplayValue($Page->cash_float->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_cash_float" data-hidden="1" name="x_cash_float" id="x_cash_float" value="<?= HtmlEncode($Page->cash_float->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_cash_float">
<span<?= $Page->cash_float->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cash_float->getDisplayValue($Page->cash_float->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_cash_float" data-hidden="1" name="x_cash_float" id="x_cash_float" value="<?= HtmlEncode($Page->cash_float->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
    <div id="r_validatedBy"<?= $Page->validatedBy->rowAttributes() ?>>
        <label id="elh_pending_expense_validatedBy" for="x_validatedBy" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validatedBy->caption() ?><?= $Page->validatedBy->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->validatedBy->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->validatedBy->getDisplayValue($Page->validatedBy->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_validatedBy" data-hidden="1" name="x_validatedBy" id="x_validatedBy" value="<?= HtmlEncode($Page->validatedBy->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->validatedBy->getDisplayValue($Page->validatedBy->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_validatedBy" data-hidden="1" name="x_validatedBy" id="x_validatedBy" value="<?= HtmlEncode($Page->validatedBy->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->machine_id->Visible) { // machine_id ?>
    <div id="r_machine_id"<?= $Page->machine_id->rowAttributes() ?>>
        <label id="elh_pending_expense_machine_id" for="x_machine_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->machine_id->caption() ?><?= $Page->machine_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->machine_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_machine_id">
<span<?= $Page->machine_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->machine_id->getDisplayValue($Page->machine_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_machine_id" data-hidden="1" name="x_machine_id" id="x_machine_id" value="<?= HtmlEncode($Page->machine_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_machine_id">
<span<?= $Page->machine_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->machine_id->getDisplayValue($Page->machine_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_machine_id" data-hidden="1" name="x_machine_id" id="x_machine_id" value="<?= HtmlEncode($Page->machine_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
    <div id="r_expCategory_id"<?= $Page->expCategory_id->rowAttributes() ?>>
        <label id="elh_pending_expense_expCategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expCategory_id->caption() ?><?= $Page->expCategory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expCategory_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_pending_expense_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expCategory_id->getDisplayValue($Page->expCategory_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_expCategory_id" data-hidden="1" name="x_expCategory_id" id="x_expCategory_id" value="<?= HtmlEncode($Page->expCategory_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pending_expense_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expCategory_id->getDisplayValue($Page->expCategory_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="pending_expense" data-field="x_expCategory_id" data-hidden="1" name="x_expCategory_id" id="x_expCategory_id" value="<?= HtmlEncode($Page->expCategory_id->FormValue) ?>">
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
    ew.addEventHandlers("pending_expense");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    $(document).ready(function(){ 
        $("#r_machine_id").hide(); 
        $("#r_expCategory_id").hide();
        if ($("#el_pending_expense_expCategory_id")[0].textContent.trim() == "Maintenance") {
            $("#r_machine_id").show(); 
        }
    });
});
</script>
