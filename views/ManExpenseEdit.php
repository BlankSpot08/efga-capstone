<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$ManExpenseEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { man_expense: currentTable } });
var currentForm, currentPageID;
var fman_expenseedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fman_expenseedit = new ew.Form("fman_expenseedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fman_expenseedit;

    // Add fields
    var fields = currentTable.fields;
    fman_expenseedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["expCategory", [fields.expCategory.visible && fields.expCategory.required ? ew.Validators.required(fields.expCategory.caption) : null], fields.expCategory.isInvalid],
        ["expSubcategory", [fields.expSubcategory.visible && fields.expSubcategory.required ? ew.Validators.required(fields.expSubcategory.caption) : null], fields.expSubcategory.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null, ew.Validators.integer], fields.amount.isInvalid],
        ["receipt", [fields.receipt.visible && fields.receipt.required ? ew.Validators.fileRequired(fields.receipt.caption) : null], fields.receipt.isInvalid],
        ["receiptNumber", [fields.receiptNumber.visible && fields.receiptNumber.required ? ew.Validators.required(fields.receiptNumber.caption) : null], fields.receiptNumber.isInvalid],
        ["date", [fields.date.visible && fields.date.required ? ew.Validators.required(fields.date.caption) : null, ew.Validators.datetime(fields.date.clientFormatPattern)], fields.date.isInvalid],
        ["dateFrom", [fields.dateFrom.visible && fields.dateFrom.required ? ew.Validators.required(fields.dateFrom.caption) : null, ew.Validators.datetime(fields.dateFrom.clientFormatPattern)], fields.dateFrom.isInvalid],
        ["dateTo", [fields.dateTo.visible && fields.dateTo.required ? ew.Validators.required(fields.dateTo.caption) : null, ew.Validators.datetime(fields.dateTo.clientFormatPattern)], fields.dateTo.isInvalid],
        ["consumption", [fields.consumption.visible && fields.consumption.required ? ew.Validators.required(fields.consumption.caption) : null, ew.Validators.integer], fields.consumption.isInvalid],
        ["note", [fields.note.visible && fields.note.required ? ew.Validators.required(fields.note.caption) : null], fields.note.isInvalid]
    ]);

    // Form_CustomValidate
    fman_expenseedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fman_expenseedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fman_expenseedit.lists.expCategory = <?= $Page->expCategory->toClientList($Page) ?>;
    fman_expenseedit.lists.expSubcategory = <?= $Page->expSubcategory->toClientList($Page) ?>;
    loadjs.done("fman_expenseedit");
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
<form name="fman_expenseedit" id="fman_expenseedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="man_expense">
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
        <label id="elh_man_expense_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_man_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
    <div id="r_expCategory"<?= $Page->expCategory->rowAttributes() ?>>
        <label id="elh_man_expense_expCategory" for="x_expCategory" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expCategory->caption() ?><?= $Page->expCategory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expCategory->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_expCategory">
<?php $Page->expCategory->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_expCategory"
        name="x_expCategory"
        class="form-select ew-select<?= $Page->expCategory->isInvalidClass() ?>"
        data-select2-id="fman_expenseedit_x_expCategory"
        data-table="man_expense"
        data-field="x_expCategory"
        data-value-separator="<?= $Page->expCategory->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->expCategory->getPlaceHolder()) ?>"
        <?= $Page->expCategory->editAttributes() ?>>
        <?= $Page->expCategory->selectOptionListHtml("x_expCategory") ?>
    </select>
    <?= $Page->expCategory->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->expCategory->getErrorMessage() ?></div>
<?= $Page->expCategory->Lookup->getParamTag($Page, "p_x_expCategory") ?>
<script>
loadjs.ready("fman_expenseedit", function() {
    var options = { name: "x_expCategory", selectId: "fman_expenseedit_x_expCategory" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fman_expenseedit.lists.expCategory.lookupOptions.length) {
        options.data = { id: "x_expCategory", form: "fman_expenseedit" };
    } else {
        options.ajax = { id: "x_expCategory", form: "fman_expenseedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.man_expense.fields.expCategory.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_man_expense_expCategory">
<span<?= $Page->expCategory->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expCategory->getDisplayValue($Page->expCategory->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_expCategory" data-hidden="1" name="x_expCategory" id="x_expCategory" value="<?= HtmlEncode($Page->expCategory->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
    <div id="r_expSubcategory"<?= $Page->expSubcategory->rowAttributes() ?>>
        <label id="elh_man_expense_expSubcategory" for="x_expSubcategory" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expSubcategory->caption() ?><?= $Page->expSubcategory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expSubcategory->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_expSubcategory">
    <select
        id="x_expSubcategory"
        name="x_expSubcategory"
        class="form-select ew-select<?= $Page->expSubcategory->isInvalidClass() ?>"
        data-select2-id="fman_expenseedit_x_expSubcategory"
        data-table="man_expense"
        data-field="x_expSubcategory"
        data-value-separator="<?= $Page->expSubcategory->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->expSubcategory->getPlaceHolder()) ?>"
        <?= $Page->expSubcategory->editAttributes() ?>>
        <?= $Page->expSubcategory->selectOptionListHtml("x_expSubcategory") ?>
    </select>
    <?= $Page->expSubcategory->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->expSubcategory->getErrorMessage() ?></div>
<?= $Page->expSubcategory->Lookup->getParamTag($Page, "p_x_expSubcategory") ?>
<script>
loadjs.ready("fman_expenseedit", function() {
    var options = { name: "x_expSubcategory", selectId: "fman_expenseedit_x_expSubcategory" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fman_expenseedit.lists.expSubcategory.lookupOptions.length) {
        options.data = { id: "x_expSubcategory", form: "fman_expenseedit" };
    } else {
        options.ajax = { id: "x_expSubcategory", form: "fman_expenseedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.man_expense.fields.expSubcategory.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_man_expense_expSubcategory">
<span<?= $Page->expSubcategory->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expSubcategory->getDisplayValue($Page->expSubcategory->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_expSubcategory" data-hidden="1" name="x_expSubcategory" id="x_expSubcategory" value="<?= HtmlEncode($Page->expSubcategory->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <label id="elh_man_expense_amount" for="x_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount->caption() ?><?= $Page->amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amount->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_amount">
<input type="<?= $Page->amount->getInputTextType() ?>" name="x_amount" id="x_amount" data-table="man_expense" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>"<?= $Page->amount->editAttributes() ?> aria-describedby="x_amount_help">
<?= $Page->amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_man_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->amount->getDisplayValue($Page->amount->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_amount" data-hidden="1" name="x_amount" id="x_amount" value="<?= HtmlEncode($Page->amount->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
    <div id="r_receipt"<?= $Page->receipt->rowAttributes() ?>>
        <label id="elh_man_expense_receipt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receipt->caption() ?><?= $Page->receipt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receipt->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_receipt">
<div id="fd_x_receipt" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->receipt->title() ?>" data-table="man_expense" data-field="x_receipt" name="x_receipt" id="x_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Page->receipt->editAttributes() ?> aria-describedby="x_receipt_help"<?= ($Page->receipt->ReadOnly || $Page->receipt->Disabled) ? " disabled" : "" ?>>
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
<span id="el_man_expense_receipt">
<div id="fd_x_receipt">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Page->receipt->title() ?>" data-table="man_expense" data-field="x_receipt" name="x_receipt" id="x_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Page->receipt->editAttributes() ?> aria-describedby="x_receipt_help">
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
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
    <div id="r_receiptNumber"<?= $Page->receiptNumber->rowAttributes() ?>>
        <label id="elh_man_expense_receiptNumber" for="x_receiptNumber" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receiptNumber->caption() ?><?= $Page->receiptNumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receiptNumber->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_receiptNumber">
<input type="<?= $Page->receiptNumber->getInputTextType() ?>" name="x_receiptNumber" id="x_receiptNumber" data-table="man_expense" data-field="x_receiptNumber" value="<?= $Page->receiptNumber->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->receiptNumber->getPlaceHolder()) ?>"<?= $Page->receiptNumber->editAttributes() ?> aria-describedby="x_receiptNumber_help">
<?= $Page->receiptNumber->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receiptNumber->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_man_expense_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->receiptNumber->getDisplayValue($Page->receiptNumber->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_receiptNumber" data-hidden="1" name="x_receiptNumber" id="x_receiptNumber" value="<?= HtmlEncode($Page->receiptNumber->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
    <div id="r_date"<?= $Page->date->rowAttributes() ?>>
        <label id="elh_man_expense_date" for="x_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date->caption() ?><?= $Page->date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_date">
<input type="<?= $Page->date->getInputTextType() ?>" name="x_date" id="x_date" data-table="man_expense" data-field="x_date" value="<?= $Page->date->EditValue ?>" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>"<?= $Page->date->editAttributes() ?> aria-describedby="x_date_help">
<?= $Page->date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage() ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fman_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fman_expenseedit", "x_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_man_expense_date">
<span<?= $Page->date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->date->getDisplayValue($Page->date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_date" data-hidden="1" name="x_date" id="x_date" value="<?= HtmlEncode($Page->date->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateFrom->Visible) { // dateFrom ?>
    <div id="r_dateFrom"<?= $Page->dateFrom->rowAttributes() ?>>
        <label id="elh_man_expense_dateFrom" for="x_dateFrom" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateFrom->caption() ?><?= $Page->dateFrom->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateFrom->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_dateFrom">
<input type="<?= $Page->dateFrom->getInputTextType() ?>" name="x_dateFrom" id="x_dateFrom" data-table="man_expense" data-field="x_dateFrom" value="<?= $Page->dateFrom->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateFrom->getPlaceHolder()) ?>"<?= $Page->dateFrom->editAttributes() ?> aria-describedby="x_dateFrom_help">
<?= $Page->dateFrom->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateFrom->getErrorMessage() ?></div>
<?php if (!$Page->dateFrom->ReadOnly && !$Page->dateFrom->Disabled && !isset($Page->dateFrom->EditAttrs["readonly"]) && !isset($Page->dateFrom->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fman_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fman_expenseedit", "x_dateFrom", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_man_expense_dateFrom">
<span<?= $Page->dateFrom->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateFrom->getDisplayValue($Page->dateFrom->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_dateFrom" data-hidden="1" name="x_dateFrom" id="x_dateFrom" value="<?= HtmlEncode($Page->dateFrom->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateTo->Visible) { // dateTo ?>
    <div id="r_dateTo"<?= $Page->dateTo->rowAttributes() ?>>
        <label id="elh_man_expense_dateTo" for="x_dateTo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateTo->caption() ?><?= $Page->dateTo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateTo->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_dateTo">
<input type="<?= $Page->dateTo->getInputTextType() ?>" name="x_dateTo" id="x_dateTo" data-table="man_expense" data-field="x_dateTo" value="<?= $Page->dateTo->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateTo->getPlaceHolder()) ?>"<?= $Page->dateTo->editAttributes() ?> aria-describedby="x_dateTo_help">
<?= $Page->dateTo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateTo->getErrorMessage() ?></div>
<?php if (!$Page->dateTo->ReadOnly && !$Page->dateTo->Disabled && !isset($Page->dateTo->EditAttrs["readonly"]) && !isset($Page->dateTo->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fman_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fman_expenseedit", "x_dateTo", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_man_expense_dateTo">
<span<?= $Page->dateTo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateTo->getDisplayValue($Page->dateTo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_dateTo" data-hidden="1" name="x_dateTo" id="x_dateTo" value="<?= HtmlEncode($Page->dateTo->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->consumption->Visible) { // consumption ?>
    <div id="r_consumption"<?= $Page->consumption->rowAttributes() ?>>
        <label id="elh_man_expense_consumption" for="x_consumption" class="<?= $Page->LeftColumnClass ?>"><?= $Page->consumption->caption() ?><?= $Page->consumption->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->consumption->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_consumption">
<input type="<?= $Page->consumption->getInputTextType() ?>" name="x_consumption" id="x_consumption" data-table="man_expense" data-field="x_consumption" value="<?= $Page->consumption->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->consumption->getPlaceHolder()) ?>"<?= $Page->consumption->editAttributes() ?> aria-describedby="x_consumption_help">
<?= $Page->consumption->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->consumption->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_man_expense_consumption">
<span<?= $Page->consumption->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->consumption->getDisplayValue($Page->consumption->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_consumption" data-hidden="1" name="x_consumption" id="x_consumption" value="<?= HtmlEncode($Page->consumption->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <div id="r_note"<?= $Page->note->rowAttributes() ?>>
        <label id="elh_man_expense_note" for="x_note" class="<?= $Page->LeftColumnClass ?>"><?= $Page->note->caption() ?><?= $Page->note->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->note->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_man_expense_note">
<input type="<?= $Page->note->getInputTextType() ?>" name="x_note" id="x_note" data-table="man_expense" data-field="x_note" value="<?= $Page->note->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->note->getPlaceHolder()) ?>"<?= $Page->note->editAttributes() ?> aria-describedby="x_note_help">
<?= $Page->note->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->note->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_man_expense_note">
<span<?= $Page->note->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->note->getDisplayValue($Page->note->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="man_expense" data-field="x_note" data-hidden="1" name="x_note" id="x_note" value="<?= HtmlEncode($Page->note->FormValue) ?>">
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
    ew.addEventHandlers("man_expense");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    $("#r_consumption").hide(); 
    $("#r_dateTo").hide(); 
    $("#r_dateFrom").hide(); 
    $("#r_date").hide(); 
    $("#r_expSubcategory").hide(); 
    if ($("#x_expCategory").value() == "3") {
        $("#r_expSubcategory").show(); 
        if ($("#x_expSubcategory").value() != "3") {
            $("#r_consumption").show(); 
        }
        $("#r_dateTo").show(); 
        $("#r_dateFrom").show(); 
    }
    $(document).ready(function(){
        $("#x_expSubcategory").change(function() {
            var str = $("option:selected", this);
            if (str.value()) {
                if (str.value() != "3") {
                    $("#r_consumption").show(); 
                } else {
                    $("#r_consumption").hide(); 
                }
            }
        })
        $("#x_expCategory").change(function() {
            var str = $("option:selected", this);
            if (str.value() == "3") {
                $("#r_consumption").show(); 
                $("#r_dateTo").show(); 
                $("#r_dateFrom").show();
                $("#r_expSubcategory").show();
                $("#r_date").hide();
            } else {
                $("#r_consumption").hide(); 
                $("#r_expSubcategory").hide(); 
                $("#r_dateTo").hide(); 
                $("#r_dateFrom").hide(); 
                $("#r_date").show();
            }
        })
    });
});
</script>
