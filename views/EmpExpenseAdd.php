<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmpExpenseAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { emp_expense: currentTable } });
var currentForm, currentPageID;
var femp_expenseadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femp_expenseadd = new ew.Form("femp_expenseadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = femp_expenseadd;

    // Add fields
    var fields = currentTable.fields;
    femp_expenseadd.addFields([
        ["cashAdvance_id", [fields.cashAdvance_id.visible && fields.cashAdvance_id.required ? ew.Validators.required(fields.cashAdvance_id.caption) : null], fields.cashAdvance_id.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null, ew.Validators.integer], fields.amount.isInvalid],
        ["dateTrans", [fields.dateTrans.visible && fields.dateTrans.required ? ew.Validators.required(fields.dateTrans.caption) : null, ew.Validators.datetime(fields.dateTrans.clientFormatPattern)], fields.dateTrans.isInvalid],
        ["receiptNumber", [fields.receiptNumber.visible && fields.receiptNumber.required ? ew.Validators.required(fields.receiptNumber.caption) : null], fields.receiptNumber.isInvalid],
        ["receipt", [fields.receipt.visible && fields.receipt.required ? ew.Validators.fileRequired(fields.receipt.caption) : null], fields.receipt.isInvalid],
        ["note", [fields.note.visible && fields.note.required ? ew.Validators.required(fields.note.caption) : null], fields.note.isInvalid],
        ["machine_id", [fields.machine_id.visible && fields.machine_id.required ? ew.Validators.required(fields.machine_id.caption) : null], fields.machine_id.isInvalid]
    ]);

    // Form_CustomValidate
    femp_expenseadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femp_expenseadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    femp_expenseadd.lists.cashAdvance_id = <?= $Page->cashAdvance_id->toClientList($Page) ?>;
    femp_expenseadd.lists.machine_id = <?= $Page->machine_id->toClientList($Page) ?>;
    loadjs.done("femp_expenseadd");
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
<form name="femp_expenseadd" id="femp_expenseadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="emp_expense">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->cashAdvance_id->Visible) { // cashAdvance_id ?>
    <div id="r_cashAdvance_id"<?= $Page->cashAdvance_id->rowAttributes() ?>>
        <label id="elh_emp_expense_cashAdvance_id" for="x_cashAdvance_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cashAdvance_id->caption() ?><?= $Page->cashAdvance_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cashAdvance_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_cashAdvance_id">
    <select
        id="x_cashAdvance_id"
        name="x_cashAdvance_id"
        class="form-select ew-select<?= $Page->cashAdvance_id->isInvalidClass() ?>"
        data-select2-id="femp_expenseadd_x_cashAdvance_id"
        data-table="emp_expense"
        data-field="x_cashAdvance_id"
        data-value-separator="<?= $Page->cashAdvance_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cashAdvance_id->getPlaceHolder()) ?>"
        <?= $Page->cashAdvance_id->editAttributes() ?>>
        <?= $Page->cashAdvance_id->selectOptionListHtml("x_cashAdvance_id") ?>
    </select>
    <?= $Page->cashAdvance_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cashAdvance_id->getErrorMessage() ?></div>
<?= $Page->cashAdvance_id->Lookup->getParamTag($Page, "p_x_cashAdvance_id") ?>
<script>
loadjs.ready("femp_expenseadd", function() {
    var options = { name: "x_cashAdvance_id", selectId: "femp_expenseadd_x_cashAdvance_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (femp_expenseadd.lists.cashAdvance_id.lookupOptions.length) {
        options.data = { id: "x_cashAdvance_id", form: "femp_expenseadd" };
    } else {
        options.ajax = { id: "x_cashAdvance_id", form: "femp_expenseadd", limit: 7 };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.emp_expense.fields.cashAdvance_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
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
<input type="<?= $Page->amount->getInputTextType() ?>" name="x_amount" id="x_amount" data-table="emp_expense" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>"<?= $Page->amount->editAttributes() ?> aria-describedby="x_amount_help">
<?= $Page->amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage() ?></div>
</span>
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
loadjs.ready(["femp_expenseadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("femp_expenseadd", "x_dateTrans", jQuery.extend(true, {"useCurrent":false}, options));
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
<input type="hidden" name="fa_x_receipt" id= "fa_x_receipt" value="0">
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
<input type="hidden" name="fa_x_receipt" id= "fa_x_receipt" value="0">
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
<?php if ($Page->machine_id->Visible) { // machine_id ?>
    <div id="r_machine_id"<?= $Page->machine_id->rowAttributes() ?>>
        <label id="elh_emp_expense_machine_id" for="x_machine_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->machine_id->caption() ?><?= $Page->machine_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->machine_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_machine_id">
    <select
        id="x_machine_id"
        name="x_machine_id"
        class="form-select ew-select<?= $Page->machine_id->isInvalidClass() ?>"
        data-select2-id="femp_expenseadd_x_machine_id"
        data-table="emp_expense"
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
loadjs.ready("femp_expenseadd", function() {
    var options = { name: "x_machine_id", selectId: "femp_expenseadd_x_machine_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (femp_expenseadd.lists.machine_id.lookupOptions.length) {
        options.data = { id: "x_machine_id", form: "femp_expenseadd" };
    } else {
        options.ajax = { id: "x_machine_id", form: "femp_expenseadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.emp_expense.fields.machine_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
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
    ew.addEventHandlers("emp_expense");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    $("#r_machine_id").hide(); 
    $(document).ready(function(){ 
        $("#x_cashAdvance_id").change(function() {
            var str = $("option:selected", this);
            $.get('api/view/cash_advance/' + this.value, function(res) {
                if (res && res.success) {
                    const result = res['cash_advance'];
                    if (result['expCategory_id'] == "3") {
                        $("#r_machine_id").show();
                    } else {
                        $("#r_machine_id").hide();  
                    }
                } else {
                    alert(res.failureMessage)
                }
            })
        });
    });
});
</script>
