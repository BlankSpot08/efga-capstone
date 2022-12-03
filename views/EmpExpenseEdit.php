<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmpExpenseEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { emp_expense: currentTable } });
var currentForm, currentPageID;
var femp_expenseedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femp_expenseedit = new ew.Form("femp_expenseedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = femp_expenseedit;

    // Add fields
    var fields = currentTable.fields;
    femp_expenseedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["cashAdvance_id", [fields.cashAdvance_id.visible && fields.cashAdvance_id.required ? ew.Validators.required(fields.cashAdvance_id.caption) : null], fields.cashAdvance_id.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null], fields.amount.isInvalid],
        ["dateTrans", [fields.dateTrans.visible && fields.dateTrans.required ? ew.Validators.required(fields.dateTrans.caption) : null, ew.Validators.datetime(fields.dateTrans.clientFormatPattern)], fields.dateTrans.isInvalid],
        ["receiptNumber", [fields.receiptNumber.visible && fields.receiptNumber.required ? ew.Validators.required(fields.receiptNumber.caption) : null], fields.receiptNumber.isInvalid],
        ["receipt", [fields.receipt.visible && fields.receipt.required ? ew.Validators.fileRequired(fields.receipt.caption) : null], fields.receipt.isInvalid],
        ["note", [fields.note.visible && fields.note.required ? ew.Validators.required(fields.note.caption) : null], fields.note.isInvalid],
        ["submittedBy", [fields.submittedBy.visible && fields.submittedBy.required ? ew.Validators.required(fields.submittedBy.caption) : null], fields.submittedBy.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["dateClosed", [fields.dateClosed.visible && fields.dateClosed.required ? ew.Validators.required(fields.dateClosed.caption) : null], fields.dateClosed.isInvalid],
        ["float_status", [fields.float_status.visible && fields.float_status.required ? ew.Validators.required(fields.float_status.caption) : null], fields.float_status.isInvalid],
        ["validatedBy", [fields.validatedBy.visible && fields.validatedBy.required ? ew.Validators.required(fields.validatedBy.caption) : null], fields.validatedBy.isInvalid],
        ["machine_id", [fields.machine_id.visible && fields.machine_id.required ? ew.Validators.required(fields.machine_id.caption) : null], fields.machine_id.isInvalid],
        ["cash_float", [fields.cash_float.visible && fields.cash_float.required ? ew.Validators.required(fields.cash_float.caption) : null], fields.cash_float.isInvalid],
        ["expCategory_id", [fields.expCategory_id.visible && fields.expCategory_id.required ? ew.Validators.required(fields.expCategory_id.caption) : null, ew.Validators.integer], fields.expCategory_id.isInvalid]
    ]);

    // Form_CustomValidate
    femp_expenseedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femp_expenseedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("femp_expenseedit");
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
<form name="femp_expenseedit" id="femp_expenseedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="emp_expense">
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
        <label id="elh_emp_expense_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cashAdvance_id->Visible) { // cashAdvance_id ?>
    <div id="r_cashAdvance_id"<?= $Page->cashAdvance_id->rowAttributes() ?>>
        <label id="elh_emp_expense_cashAdvance_id" for="x_cashAdvance_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cashAdvance_id->caption() ?><?= $Page->cashAdvance_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cashAdvance_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_cashAdvance_id">
<span<?= $Page->cashAdvance_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->cashAdvance_id->getDisplayValue($Page->cashAdvance_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_cashAdvance_id" data-hidden="1" name="x_cashAdvance_id" id="x_cashAdvance_id" value="<?= HtmlEncode($Page->cashAdvance_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_cashAdvance_id">
<span<?= $Page->cashAdvance_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->cashAdvance_id->getDisplayValue($Page->cashAdvance_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_cashAdvance_id" data-hidden="1" name="x_cashAdvance_id" id="x_cashAdvance_id" value="<?= HtmlEncode($Page->cashAdvance_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <label id="elh_emp_expense_amount" for="x_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount->caption() ?><?= $Page->amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amount->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->amount->getDisplayValue($Page->amount->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_amount" data-hidden="1" name="x_amount" id="x_amount" value="<?= HtmlEncode($Page->amount->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->amount->getDisplayValue($Page->amount->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_amount" data-hidden="1" name="x_amount" id="x_amount" value="<?= HtmlEncode($Page->amount->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
    <div id="r_dateTrans"<?= $Page->dateTrans->rowAttributes() ?>>
        <label id="elh_emp_expense_dateTrans" for="x_dateTrans" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateTrans->caption() ?><?= $Page->dateTrans->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateTrans->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_dateTrans">
<input type="<?= $Page->dateTrans->getInputTextType() ?>" name="x_dateTrans" id="x_dateTrans" data-table="emp_expense" data-field="x_dateTrans" value="<?= $Page->dateTrans->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateTrans->getPlaceHolder()) ?>"<?= $Page->dateTrans->editAttributes() ?> aria-describedby="x_dateTrans_help">
<?= $Page->dateTrans->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateTrans->getErrorMessage() ?></div>
<?php if (!$Page->dateTrans->ReadOnly && !$Page->dateTrans->Disabled && !isset($Page->dateTrans->EditAttrs["readonly"]) && !isset($Page->dateTrans->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["femp_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("femp_expenseedit", "x_dateTrans", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_emp_expense_dateTrans">
<span<?= $Page->dateTrans->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateTrans->getDisplayValue($Page->dateTrans->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_dateTrans" data-hidden="1" name="x_dateTrans" id="x_dateTrans" value="<?= HtmlEncode($Page->dateTrans->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
    <div id="r_receiptNumber"<?= $Page->receiptNumber->rowAttributes() ?>>
        <label id="elh_emp_expense_receiptNumber" for="x_receiptNumber" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receiptNumber->caption() ?><?= $Page->receiptNumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receiptNumber->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_receiptNumber">
<input type="<?= $Page->receiptNumber->getInputTextType() ?>" name="x_receiptNumber" id="x_receiptNumber" data-table="emp_expense" data-field="x_receiptNumber" value="<?= $Page->receiptNumber->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->receiptNumber->getPlaceHolder()) ?>"<?= $Page->receiptNumber->editAttributes() ?> aria-describedby="x_receiptNumber_help">
<?= $Page->receiptNumber->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receiptNumber->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_emp_expense_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->receiptNumber->getDisplayValue($Page->receiptNumber->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_receiptNumber" data-hidden="1" name="x_receiptNumber" id="x_receiptNumber" value="<?= HtmlEncode($Page->receiptNumber->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
    <div id="r_receipt"<?= $Page->receipt->rowAttributes() ?>>
        <label id="elh_emp_expense_receipt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receipt->caption() ?><?= $Page->receipt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receipt->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_receipt">
<div id="fd_x_receipt" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->receipt->title() ?>" data-table="emp_expense" data-field="x_receipt" name="x_receipt" id="x_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Page->receipt->editAttributes() ?> aria-describedby="x_receipt_help"<?= ($Page->receipt->ReadOnly || $Page->receipt->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->receipt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receipt->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_receipt" id= "fn_x_receipt" value="<?= $Page->receipt->Upload->FileName ?>">
<input type="hidden" name="fa_x_receipt" id= "fa_x_receipt" value="<?= (Post("fa_x_receipt") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_receipt" id= "fs_x_receipt" value="0">
<input type="hidden" name="fx_x_receipt" id= "fx_x_receipt" value="<?= $Page->receipt->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_receipt" id= "fm_x_receipt" value="<?= $Page->receipt->UploadMaxFileSize ?>">
<table id="ft_x_receipt" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el_emp_expense_receipt">
<div id="fd_x_receipt">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Page->receipt->title() ?>" data-table="emp_expense" data-field="x_receipt" name="x_receipt" id="x_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Page->receipt->editAttributes() ?> aria-describedby="x_receipt_help">
</div>
<?= $Page->receipt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receipt->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_receipt" id= "fn_x_receipt" value="<?= $Page->receipt->Upload->FileName ?>">
<input type="hidden" name="fa_x_receipt" id= "fa_x_receipt" value="<?= (Post("fa_x_receipt") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_receipt" id= "fs_x_receipt" value="0">
<input type="hidden" name="fx_x_receipt" id= "fx_x_receipt" value="<?= $Page->receipt->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_receipt" id= "fm_x_receipt" value="<?= $Page->receipt->UploadMaxFileSize ?>">
<table id="ft_x_receipt" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <div id="r_note"<?= $Page->note->rowAttributes() ?>>
        <label id="elh_emp_expense_note" for="x_note" class="<?= $Page->LeftColumnClass ?>"><?= $Page->note->caption() ?><?= $Page->note->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->note->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_note">
<input type="<?= $Page->note->getInputTextType() ?>" name="x_note" id="x_note" data-table="emp_expense" data-field="x_note" value="<?= $Page->note->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->note->getPlaceHolder()) ?>"<?= $Page->note->editAttributes() ?> aria-describedby="x_note_help">
<?= $Page->note->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->note->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_emp_expense_note">
<span<?= $Page->note->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->note->getDisplayValue($Page->note->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_note" data-hidden="1" name="x_note" id="x_note" value="<?= HtmlEncode($Page->note->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
    <div id="r_submittedBy"<?= $Page->submittedBy->rowAttributes() ?>>
        <label id="elh_emp_expense_submittedBy" for="x_submittedBy" class="<?= $Page->LeftColumnClass ?>"><?= $Page->submittedBy->caption() ?><?= $Page->submittedBy->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->submittedBy->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->submittedBy->getDisplayValue($Page->submittedBy->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_submittedBy" data-hidden="1" name="x_submittedBy" id="x_submittedBy" value="<?= HtmlEncode($Page->submittedBy->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->submittedBy->getDisplayValue($Page->submittedBy->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_submittedBy" data-hidden="1" name="x_submittedBy" id="x_submittedBy" value="<?= HtmlEncode($Page->submittedBy->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_emp_expense_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_status">
<span<?= $Page->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status->getDisplayValue($Page->status->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_status" data-hidden="1" name="x_status" id="x_status" value="<?= HtmlEncode($Page->status->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_status">
<span<?= $Page->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status->getDisplayValue($Page->status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_status" data-hidden="1" name="x_status" id="x_status" value="<?= HtmlEncode($Page->status->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
    <div id="r_dateClosed"<?= $Page->dateClosed->rowAttributes() ?>>
        <label id="elh_emp_expense_dateClosed" for="x_dateClosed" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateClosed->caption() ?><?= $Page->dateClosed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateClosed->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_dateClosed">
<span<?= $Page->dateClosed->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateClosed->getDisplayValue($Page->dateClosed->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_dateClosed" data-hidden="1" name="x_dateClosed" id="x_dateClosed" value="<?= HtmlEncode($Page->dateClosed->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_dateClosed">
<span<?= $Page->dateClosed->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateClosed->getDisplayValue($Page->dateClosed->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_dateClosed" data-hidden="1" name="x_dateClosed" id="x_dateClosed" value="<?= HtmlEncode($Page->dateClosed->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->float_status->Visible) { // float_status ?>
    <div id="r_float_status"<?= $Page->float_status->rowAttributes() ?>>
        <label id="elh_emp_expense_float_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->float_status->caption() ?><?= $Page->float_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->float_status->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_float_status">
<span<?= $Page->float_status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->float_status->getDisplayValue($Page->float_status->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_float_status" data-hidden="1" name="x_float_status" id="x_float_status" value="<?= HtmlEncode($Page->float_status->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_float_status">
<span<?= $Page->float_status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->float_status->getDisplayValue($Page->float_status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_float_status" data-hidden="1" name="x_float_status" id="x_float_status" value="<?= HtmlEncode($Page->float_status->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
    <div id="r_validatedBy"<?= $Page->validatedBy->rowAttributes() ?>>
        <label id="elh_emp_expense_validatedBy" for="x_validatedBy" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validatedBy->caption() ?><?= $Page->validatedBy->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->validatedBy->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->validatedBy->getDisplayValue($Page->validatedBy->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_validatedBy" data-hidden="1" name="x_validatedBy" id="x_validatedBy" value="<?= HtmlEncode($Page->validatedBy->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->validatedBy->getDisplayValue($Page->validatedBy->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_validatedBy" data-hidden="1" name="x_validatedBy" id="x_validatedBy" value="<?= HtmlEncode($Page->validatedBy->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->machine_id->Visible) { // machine_id ?>
    <div id="r_machine_id"<?= $Page->machine_id->rowAttributes() ?>>
        <label id="elh_emp_expense_machine_id" for="x_machine_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->machine_id->caption() ?><?= $Page->machine_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->machine_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_machine_id">
<span<?= $Page->machine_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->machine_id->getDisplayValue($Page->machine_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_machine_id" data-hidden="1" name="x_machine_id" id="x_machine_id" value="<?= HtmlEncode($Page->machine_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_machine_id">
<span<?= $Page->machine_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->machine_id->getDisplayValue($Page->machine_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_machine_id" data-hidden="1" name="x_machine_id" id="x_machine_id" value="<?= HtmlEncode($Page->machine_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cash_float->Visible) { // cash_float ?>
    <div id="r_cash_float"<?= $Page->cash_float->rowAttributes() ?>>
        <label id="elh_emp_expense_cash_float" for="x_cash_float" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cash_float->caption() ?><?= $Page->cash_float->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cash_float->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_cash_float">
<span<?= $Page->cash_float->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cash_float->getDisplayValue($Page->cash_float->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_cash_float" data-hidden="1" name="x_cash_float" id="x_cash_float" value="<?= HtmlEncode($Page->cash_float->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_cash_float">
<span<?= $Page->cash_float->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cash_float->getDisplayValue($Page->cash_float->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_cash_float" data-hidden="1" name="x_cash_float" id="x_cash_float" value="<?= HtmlEncode($Page->cash_float->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
    <div id="r_expCategory_id"<?= $Page->expCategory_id->rowAttributes() ?>>
        <label id="elh_emp_expense_expCategory_id" for="x_expCategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expCategory_id->caption() ?><?= $Page->expCategory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expCategory_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_expCategory_id">
<input type="<?= $Page->expCategory_id->getInputTextType() ?>" name="x_expCategory_id" id="x_expCategory_id" data-table="emp_expense" data-field="x_expCategory_id" value="<?= $Page->expCategory_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->expCategory_id->getPlaceHolder()) ?>"<?= $Page->expCategory_id->editAttributes() ?> aria-describedby="x_expCategory_id_help">
<?= $Page->expCategory_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->expCategory_id->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_emp_expense_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->expCategory_id->getDisplayValue($Page->expCategory_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense" data-field="x_expCategory_id" data-hidden="1" name="x_expCategory_id" id="x_expCategory_id" value="<?= HtmlEncode($Page->expCategory_id->FormValue) ?>">
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
    ew.addEventHandlers("emp_expense");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    $(document).ready(function(){ 
        $("#r_machine_id").hide(); 
        if ($("#x_expCategory_id").value() == "3") {  
            $("#r_machine_id").show(); 
        }
        $("#r_expCategory_id").hide(); 
    });
});
</script>
