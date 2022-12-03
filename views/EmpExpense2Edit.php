<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmpExpense2Edit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { emp_expense2: currentTable } });
var currentForm, currentPageID;
var femp_expense2edit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femp_expense2edit = new ew.Form("femp_expense2edit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = femp_expense2edit;

    // Add fields
    var fields = currentTable.fields;
    femp_expense2edit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["cashAdvance_id", [fields.cashAdvance_id.visible && fields.cashAdvance_id.required ? ew.Validators.required(fields.cashAdvance_id.caption) : null], fields.cashAdvance_id.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null], fields.amount.isInvalid],
        ["dateTrans", [fields.dateTrans.visible && fields.dateTrans.required ? ew.Validators.required(fields.dateTrans.caption) : null, ew.Validators.datetime(fields.dateTrans.clientFormatPattern)], fields.dateTrans.isInvalid],
        ["receipt", [fields.receipt.visible && fields.receipt.required ? ew.Validators.fileRequired(fields.receipt.caption) : null], fields.receipt.isInvalid],
        ["note", [fields.note.visible && fields.note.required ? ew.Validators.required(fields.note.caption) : null], fields.note.isInvalid],
        ["submittedBy", [fields.submittedBy.visible && fields.submittedBy.required ? ew.Validators.required(fields.submittedBy.caption) : null], fields.submittedBy.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["dateClosed", [fields.dateClosed.visible && fields.dateClosed.required ? ew.Validators.required(fields.dateClosed.caption) : null], fields.dateClosed.isInvalid],
        ["float_status", [fields.float_status.visible && fields.float_status.required ? ew.Validators.required(fields.float_status.caption) : null], fields.float_status.isInvalid],
        ["cash_float", [fields.cash_float.visible && fields.cash_float.required ? ew.Validators.required(fields.cash_float.caption) : null], fields.cash_float.isInvalid],
        ["validatedBy", [fields.validatedBy.visible && fields.validatedBy.required ? ew.Validators.required(fields.validatedBy.caption) : null], fields.validatedBy.isInvalid],
        ["machine_id", [fields.machine_id.visible && fields.machine_id.required ? ew.Validators.required(fields.machine_id.caption) : null], fields.machine_id.isInvalid]
    ]);

    // Form_CustomValidate
    femp_expense2edit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femp_expense2edit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    femp_expense2edit.lists.machine_id = <?= $Page->machine_id->toClientList($Page) ?>;
    loadjs.done("femp_expense2edit");
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
<form name="femp_expense2edit" id="femp_expense2edit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="emp_expense2">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_emp_expense2_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_emp_expense2_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense2" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cashAdvance_id->Visible) { // cashAdvance_id ?>
    <div id="r_cashAdvance_id"<?= $Page->cashAdvance_id->rowAttributes() ?>>
        <label id="elh_emp_expense2_cashAdvance_id" for="x_cashAdvance_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cashAdvance_id->caption() ?><?= $Page->cashAdvance_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cashAdvance_id->cellAttributes() ?>>
<span id="el_emp_expense2_cashAdvance_id">
<span<?= $Page->cashAdvance_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->cashAdvance_id->getDisplayValue($Page->cashAdvance_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense2" data-field="x_cashAdvance_id" data-hidden="1" name="x_cashAdvance_id" id="x_cashAdvance_id" value="<?= HtmlEncode($Page->cashAdvance_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <label id="elh_emp_expense2_amount" for="x_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount->caption() ?><?= $Page->amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amount->cellAttributes() ?>>
<span id="el_emp_expense2_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->amount->getDisplayValue($Page->amount->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense2" data-field="x_amount" data-hidden="1" name="x_amount" id="x_amount" value="<?= HtmlEncode($Page->amount->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
    <div id="r_dateTrans"<?= $Page->dateTrans->rowAttributes() ?>>
        <label id="elh_emp_expense2_dateTrans" for="x_dateTrans" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateTrans->caption() ?><?= $Page->dateTrans->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateTrans->cellAttributes() ?>>
<span id="el_emp_expense2_dateTrans">
<input type="<?= $Page->dateTrans->getInputTextType() ?>" name="x_dateTrans" id="x_dateTrans" data-table="emp_expense2" data-field="x_dateTrans" value="<?= $Page->dateTrans->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateTrans->getPlaceHolder()) ?>"<?= $Page->dateTrans->editAttributes() ?> aria-describedby="x_dateTrans_help">
<?= $Page->dateTrans->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateTrans->getErrorMessage() ?></div>
<?php if (!$Page->dateTrans->ReadOnly && !$Page->dateTrans->Disabled && !isset($Page->dateTrans->EditAttrs["readonly"]) && !isset($Page->dateTrans->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["femp_expense2edit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("femp_expense2edit", "x_dateTrans", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
    <div id="r_receipt"<?= $Page->receipt->rowAttributes() ?>>
        <label id="elh_emp_expense2_receipt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receipt->caption() ?><?= $Page->receipt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receipt->cellAttributes() ?>>
<span id="el_emp_expense2_receipt">
<div id="fd_x_receipt" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->receipt->title() ?>" data-table="emp_expense2" data-field="x_receipt" name="x_receipt" id="x_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Page->receipt->editAttributes() ?> aria-describedby="x_receipt_help"<?= ($Page->receipt->ReadOnly || $Page->receipt->Disabled) ? " disabled" : "" ?>>
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
</div></div>
    </div>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <div id="r_note"<?= $Page->note->rowAttributes() ?>>
        <label id="elh_emp_expense2_note" for="x_note" class="<?= $Page->LeftColumnClass ?>"><?= $Page->note->caption() ?><?= $Page->note->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->note->cellAttributes() ?>>
<span id="el_emp_expense2_note">
<input type="<?= $Page->note->getInputTextType() ?>" name="x_note" id="x_note" data-table="emp_expense2" data-field="x_note" value="<?= $Page->note->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->note->getPlaceHolder()) ?>"<?= $Page->note->editAttributes() ?> aria-describedby="x_note_help">
<?= $Page->note->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->note->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
    <div id="r_submittedBy"<?= $Page->submittedBy->rowAttributes() ?>>
        <label id="elh_emp_expense2_submittedBy" for="x_submittedBy" class="<?= $Page->LeftColumnClass ?>"><?= $Page->submittedBy->caption() ?><?= $Page->submittedBy->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->submittedBy->cellAttributes() ?>>
<span id="el_emp_expense2_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->submittedBy->getDisplayValue($Page->submittedBy->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense2" data-field="x_submittedBy" data-hidden="1" name="x_submittedBy" id="x_submittedBy" value="<?= HtmlEncode($Page->submittedBy->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_emp_expense2_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_emp_expense2_status">
<span<?= $Page->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status->getDisplayValue($Page->status->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense2" data-field="x_status" data-hidden="1" name="x_status" id="x_status" value="<?= HtmlEncode($Page->status->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
    <div id="r_dateClosed"<?= $Page->dateClosed->rowAttributes() ?>>
        <label id="elh_emp_expense2_dateClosed" for="x_dateClosed" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateClosed->caption() ?><?= $Page->dateClosed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateClosed->cellAttributes() ?>>
<span id="el_emp_expense2_dateClosed">
<span<?= $Page->dateClosed->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateClosed->getDisplayValue($Page->dateClosed->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense2" data-field="x_dateClosed" data-hidden="1" name="x_dateClosed" id="x_dateClosed" value="<?= HtmlEncode($Page->dateClosed->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->float_status->Visible) { // float_status ?>
    <div id="r_float_status"<?= $Page->float_status->rowAttributes() ?>>
        <label id="elh_emp_expense2_float_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->float_status->caption() ?><?= $Page->float_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->float_status->cellAttributes() ?>>
<span id="el_emp_expense2_float_status">
<span<?= $Page->float_status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->float_status->getDisplayValue($Page->float_status->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense2" data-field="x_float_status" data-hidden="1" name="x_float_status" id="x_float_status" value="<?= HtmlEncode($Page->float_status->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cash_float->Visible) { // cash_float ?>
    <div id="r_cash_float"<?= $Page->cash_float->rowAttributes() ?>>
        <label id="elh_emp_expense2_cash_float" for="x_cash_float" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cash_float->caption() ?><?= $Page->cash_float->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cash_float->cellAttributes() ?>>
<span id="el_emp_expense2_cash_float">
<span<?= $Page->cash_float->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cash_float->getDisplayValue($Page->cash_float->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense2" data-field="x_cash_float" data-hidden="1" name="x_cash_float" id="x_cash_float" value="<?= HtmlEncode($Page->cash_float->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
    <div id="r_validatedBy"<?= $Page->validatedBy->rowAttributes() ?>>
        <label id="elh_emp_expense2_validatedBy" for="x_validatedBy" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validatedBy->caption() ?><?= $Page->validatedBy->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->validatedBy->cellAttributes() ?>>
<span id="el_emp_expense2_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->validatedBy->getDisplayValue($Page->validatedBy->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense2" data-field="x_validatedBy" data-hidden="1" name="x_validatedBy" id="x_validatedBy" value="<?= HtmlEncode($Page->validatedBy->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->machine_id->Visible) { // machine_id ?>
    <div id="r_machine_id"<?= $Page->machine_id->rowAttributes() ?>>
        <label id="elh_emp_expense2_machine_id" for="x_machine_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->machine_id->caption() ?><?= $Page->machine_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->machine_id->cellAttributes() ?>>
<span id="el_emp_expense2_machine_id">
    <select
        id="x_machine_id"
        name="x_machine_id"
        class="form-select ew-select<?= $Page->machine_id->isInvalidClass() ?>"
        data-select2-id="femp_expense2edit_x_machine_id"
        data-table="emp_expense2"
        data-field="x_machine_id"
        data-value-separator="<?= $Page->machine_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->machine_id->getPlaceHolder()) ?>"
        <?= $Page->machine_id->editAttributes() ?>>
        <?= $Page->machine_id->selectOptionListHtml("x_machine_id") ?>
    </select>
    <?= $Page->machine_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->machine_id->getErrorMessage() ?></div>
<?= $Page->machine_id->Lookup->getParamTag($Page, "p_x_machine_id") ?>
<script>
loadjs.ready("femp_expense2edit", function() {
    var options = { name: "x_machine_id", selectId: "femp_expense2edit_x_machine_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (femp_expense2edit.lists.machine_id.lookupOptions.length) {
        options.data = { id: "x_machine_id", form: "femp_expense2edit" };
    } else {
        options.ajax = { id: "x_machine_id", form: "femp_expense2edit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.emp_expense2.fields.machine_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("emp_expense2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
