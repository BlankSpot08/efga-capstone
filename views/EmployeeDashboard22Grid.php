<?php

namespace PHPMaker2022\efga_expense_system;

// Set up and run Grid object
$Grid = Container("EmployeeDashboard22Grid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fEmployeeDashboard22grid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fEmployeeDashboard22grid = new ew.Form("fEmployeeDashboard22grid", "grid");
    fEmployeeDashboard22grid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { EmployeeDashboard22: currentTable } });
    var fields = currentTable.fields;
    fEmployeeDashboard22grid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["cashAdvance_id", [fields.cashAdvance_id.visible && fields.cashAdvance_id.required ? ew.Validators.required(fields.cashAdvance_id.caption) : null], fields.cashAdvance_id.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null], fields.amount.isInvalid],
        ["dateTrans", [fields.dateTrans.visible && fields.dateTrans.required ? ew.Validators.required(fields.dateTrans.caption) : null, ew.Validators.datetime(fields.dateTrans.clientFormatPattern)], fields.dateTrans.isInvalid],
        ["receiptNumber", [fields.receiptNumber.visible && fields.receiptNumber.required ? ew.Validators.required(fields.receiptNumber.caption) : null], fields.receiptNumber.isInvalid],
        ["receipt", [fields.receipt.visible && fields.receipt.required ? ew.Validators.fileRequired(fields.receipt.caption) : null], fields.receipt.isInvalid],
        ["note", [fields.note.visible && fields.note.required ? ew.Validators.required(fields.note.caption) : null], fields.note.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["dateClosed", [fields.dateClosed.visible && fields.dateClosed.required ? ew.Validators.required(fields.dateClosed.caption) : null], fields.dateClosed.isInvalid],
        ["float_status", [fields.float_status.visible && fields.float_status.required ? ew.Validators.required(fields.float_status.caption) : null], fields.float_status.isInvalid],
        ["cash_float", [fields.cash_float.visible && fields.cash_float.required ? ew.Validators.required(fields.cash_float.caption) : null], fields.cash_float.isInvalid]
    ]);

    // Check empty row
    fEmployeeDashboard22grid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["cashAdvance_id",false],["amount",false],["dateTrans",false],["receiptNumber",false],["receipt",false],["note",false],["status",false],["dateClosed",false],["float_status",false],["cash_float",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fEmployeeDashboard22grid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fEmployeeDashboard22grid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fEmployeeDashboard22grid.lists.cashAdvance_id = <?= $Grid->cashAdvance_id->toClientList($Grid) ?>;
    fEmployeeDashboard22grid.lists.status = <?= $Grid->status->toClientList($Grid) ?>;
    fEmployeeDashboard22grid.lists.float_status = <?= $Grid->float_status->toClientList($Grid) ?>;
    loadjs.done("fEmployeeDashboard22grid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> EmployeeDashboard22">
<div id="fEmployeeDashboard22grid" class="ew-form ew-list-form">
<div id="gmp_EmployeeDashboard22" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_EmployeeDashboard22grid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_id" class="EmployeeDashboard22_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->cashAdvance_id->Visible) { // cashAdvance_id ?>
        <th data-name="cashAdvance_id" class="<?= $Grid->cashAdvance_id->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_cashAdvance_id" class="EmployeeDashboard22_cashAdvance_id"><?= $Grid->renderFieldHeader($Grid->cashAdvance_id) ?></div></th>
<?php } ?>
<?php if ($Grid->amount->Visible) { // amount ?>
        <th data-name="amount" class="<?= $Grid->amount->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_amount" class="EmployeeDashboard22_amount"><?= $Grid->renderFieldHeader($Grid->amount) ?></div></th>
<?php } ?>
<?php if ($Grid->dateTrans->Visible) { // dateTrans ?>
        <th data-name="dateTrans" class="<?= $Grid->dateTrans->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_dateTrans" class="EmployeeDashboard22_dateTrans"><?= $Grid->renderFieldHeader($Grid->dateTrans) ?></div></th>
<?php } ?>
<?php if ($Grid->receiptNumber->Visible) { // receiptNumber ?>
        <th data-name="receiptNumber" class="<?= $Grid->receiptNumber->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_receiptNumber" class="EmployeeDashboard22_receiptNumber"><?= $Grid->renderFieldHeader($Grid->receiptNumber) ?></div></th>
<?php } ?>
<?php if ($Grid->receipt->Visible) { // receipt ?>
        <th data-name="receipt" class="<?= $Grid->receipt->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_receipt" class="EmployeeDashboard22_receipt"><?= $Grid->renderFieldHeader($Grid->receipt) ?></div></th>
<?php } ?>
<?php if ($Grid->note->Visible) { // note ?>
        <th data-name="note" class="<?= $Grid->note->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_note" class="EmployeeDashboard22_note"><?= $Grid->renderFieldHeader($Grid->note) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_status" class="EmployeeDashboard22_status"><?= $Grid->renderFieldHeader($Grid->status) ?></div></th>
<?php } ?>
<?php if ($Grid->dateClosed->Visible) { // dateClosed ?>
        <th data-name="dateClosed" class="<?= $Grid->dateClosed->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_dateClosed" class="EmployeeDashboard22_dateClosed"><?= $Grid->renderFieldHeader($Grid->dateClosed) ?></div></th>
<?php } ?>
<?php if ($Grid->float_status->Visible) { // float_status ?>
        <th data-name="float_status" class="<?= $Grid->float_status->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_float_status" class="EmployeeDashboard22_float_status"><?= $Grid->renderFieldHeader($Grid->float_status) ?></div></th>
<?php } ?>
<?php if ($Grid->cash_float->Visible) { // cash_float ?>
        <th data-name="cash_float" class="<?= $Grid->cash_float->headerCellClass() ?>"><div id="elh_EmployeeDashboard22_cash_float" class="EmployeeDashboard22_cash_float"><?= $Grid->renderFieldHeader($Grid->cash_float) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif ($Grid->isGridAdd() && !$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isAdd() || $Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row attributes
        $Grid->RowAttrs->merge([
            "data-rowindex" => $Grid->RowCount,
            "id" => "r" . $Grid->RowCount . "_EmployeeDashboard22",
            "data-rowtype" => $Grid->RowType,
            "class" => ($Grid->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Grid->isAdd() && $Grid->RowType == ROWTYPE_ADD || $Grid->isEdit() && $Grid->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Grid->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id"<?= $Grid->id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_id" class="el_EmployeeDashboard22_id"></span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_id" class="el_EmployeeDashboard22_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_id" class="el_EmployeeDashboard22_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_id" data-hidden="1" name="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_id" id="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_id" data-hidden="1" name="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_id" id="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="EmployeeDashboard22" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->cashAdvance_id->Visible) { // cashAdvance_id ?>
        <td data-name="cashAdvance_id"<?= $Grid->cashAdvance_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_cashAdvance_id" class="el_EmployeeDashboard22_cashAdvance_id">
    <select
        id="x<?= $Grid->RowIndex ?>_cashAdvance_id"
        name="x<?= $Grid->RowIndex ?>_cashAdvance_id"
        class="form-select ew-select<?= $Grid->cashAdvance_id->isInvalidClass() ?>"
        data-select2-id="fEmployeeDashboard22grid_x<?= $Grid->RowIndex ?>_cashAdvance_id"
        data-table="EmployeeDashboard22"
        data-field="x_cashAdvance_id"
        data-value-separator="<?= $Grid->cashAdvance_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cashAdvance_id->getPlaceHolder()) ?>"
        <?= $Grid->cashAdvance_id->editAttributes() ?>>
        <?= $Grid->cashAdvance_id->selectOptionListHtml("x{$Grid->RowIndex}_cashAdvance_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cashAdvance_id->getErrorMessage() ?></div>
<?= $Grid->cashAdvance_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cashAdvance_id") ?>
<script>
loadjs.ready("fEmployeeDashboard22grid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cashAdvance_id", selectId: "fEmployeeDashboard22grid_x<?= $Grid->RowIndex ?>_cashAdvance_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fEmployeeDashboard22grid.lists.cashAdvance_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cashAdvance_id", form: "fEmployeeDashboard22grid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cashAdvance_id", form: "fEmployeeDashboard22grid", limit: 7 };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.EmployeeDashboard22.fields.cashAdvance_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cashAdvance_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cashAdvance_id" id="o<?= $Grid->RowIndex ?>_cashAdvance_id" value="<?= HtmlEncode($Grid->cashAdvance_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_cashAdvance_id" class="el_EmployeeDashboard22_cashAdvance_id">
<span<?= $Grid->cashAdvance_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->cashAdvance_id->getDisplayValue($Grid->cashAdvance_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cashAdvance_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cashAdvance_id" id="x<?= $Grid->RowIndex ?>_cashAdvance_id" value="<?= HtmlEncode($Grid->cashAdvance_id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_cashAdvance_id" class="el_EmployeeDashboard22_cashAdvance_id">
<span<?= $Grid->cashAdvance_id->viewAttributes() ?>>
<?= $Grid->cashAdvance_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cashAdvance_id" data-hidden="1" name="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_cashAdvance_id" id="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_cashAdvance_id" value="<?= HtmlEncode($Grid->cashAdvance_id->FormValue) ?>">
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cashAdvance_id" data-hidden="1" name="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_cashAdvance_id" id="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_cashAdvance_id" value="<?= HtmlEncode($Grid->cashAdvance_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->amount->Visible) { // amount ?>
        <td data-name="amount"<?= $Grid->amount->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_amount" class="el_EmployeeDashboard22_amount">
<input type="<?= $Grid->amount->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_amount" id="x<?= $Grid->RowIndex ?>_amount" data-table="EmployeeDashboard22" data-field="x_amount" value="<?= $Grid->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->amount->getPlaceHolder()) ?>"<?= $Grid->amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_amount" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amount" id="o<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_amount" class="el_EmployeeDashboard22_amount">
<span<?= $Grid->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->amount->getDisplayValue($Grid->amount->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_amount" data-hidden="1" name="x<?= $Grid->RowIndex ?>_amount" id="x<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_amount" class="el_EmployeeDashboard22_amount">
<span<?= $Grid->amount->viewAttributes() ?>>
<?= $Grid->amount->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_amount" data-hidden="1" name="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_amount" id="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->FormValue) ?>">
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_amount" data-hidden="1" name="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_amount" id="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dateTrans->Visible) { // dateTrans ?>
        <td data-name="dateTrans"<?= $Grid->dateTrans->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_dateTrans" class="el_EmployeeDashboard22_dateTrans">
<input type="<?= $Grid->dateTrans->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateTrans" id="x<?= $Grid->RowIndex ?>_dateTrans" data-table="EmployeeDashboard22" data-field="x_dateTrans" value="<?= $Grid->dateTrans->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateTrans->getPlaceHolder()) ?>"<?= $Grid->dateTrans->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateTrans->getErrorMessage() ?></div>
<?php if (!$Grid->dateTrans->ReadOnly && !$Grid->dateTrans->Disabled && !isset($Grid->dateTrans->EditAttrs["readonly"]) && !isset($Grid->dateTrans->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fEmployeeDashboard22grid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fEmployeeDashboard22grid", "x<?= $Grid->RowIndex ?>_dateTrans", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateTrans" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dateTrans" id="o<?= $Grid->RowIndex ?>_dateTrans" value="<?= HtmlEncode($Grid->dateTrans->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_dateTrans" class="el_EmployeeDashboard22_dateTrans">
<input type="<?= $Grid->dateTrans->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateTrans" id="x<?= $Grid->RowIndex ?>_dateTrans" data-table="EmployeeDashboard22" data-field="x_dateTrans" value="<?= $Grid->dateTrans->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateTrans->getPlaceHolder()) ?>"<?= $Grid->dateTrans->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateTrans->getErrorMessage() ?></div>
<?php if (!$Grid->dateTrans->ReadOnly && !$Grid->dateTrans->Disabled && !isset($Grid->dateTrans->EditAttrs["readonly"]) && !isset($Grid->dateTrans->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fEmployeeDashboard22grid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fEmployeeDashboard22grid", "x<?= $Grid->RowIndex ?>_dateTrans", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_dateTrans" class="el_EmployeeDashboard22_dateTrans">
<span<?= $Grid->dateTrans->viewAttributes() ?>>
<?= $Grid->dateTrans->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateTrans" data-hidden="1" name="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_dateTrans" id="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_dateTrans" value="<?= HtmlEncode($Grid->dateTrans->FormValue) ?>">
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateTrans" data-hidden="1" name="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_dateTrans" id="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_dateTrans" value="<?= HtmlEncode($Grid->dateTrans->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->receiptNumber->Visible) { // receiptNumber ?>
        <td data-name="receiptNumber"<?= $Grid->receiptNumber->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_receiptNumber" class="el_EmployeeDashboard22_receiptNumber">
<input type="<?= $Grid->receiptNumber->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_receiptNumber" id="x<?= $Grid->RowIndex ?>_receiptNumber" data-table="EmployeeDashboard22" data-field="x_receiptNumber" value="<?= $Grid->receiptNumber->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->receiptNumber->getPlaceHolder()) ?>"<?= $Grid->receiptNumber->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->receiptNumber->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_receiptNumber" data-hidden="1" name="o<?= $Grid->RowIndex ?>_receiptNumber" id="o<?= $Grid->RowIndex ?>_receiptNumber" value="<?= HtmlEncode($Grid->receiptNumber->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_receiptNumber" class="el_EmployeeDashboard22_receiptNumber">
<input type="<?= $Grid->receiptNumber->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_receiptNumber" id="x<?= $Grid->RowIndex ?>_receiptNumber" data-table="EmployeeDashboard22" data-field="x_receiptNumber" value="<?= $Grid->receiptNumber->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->receiptNumber->getPlaceHolder()) ?>"<?= $Grid->receiptNumber->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->receiptNumber->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_receiptNumber" class="el_EmployeeDashboard22_receiptNumber">
<span<?= $Grid->receiptNumber->viewAttributes() ?>>
<?= $Grid->receiptNumber->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_receiptNumber" data-hidden="1" name="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_receiptNumber" id="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_receiptNumber" value="<?= HtmlEncode($Grid->receiptNumber->FormValue) ?>">
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_receiptNumber" data-hidden="1" name="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_receiptNumber" id="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_receiptNumber" value="<?= HtmlEncode($Grid->receiptNumber->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->receipt->Visible) { // receipt ?>
        <td data-name="receipt"<?= $Grid->receipt->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_receipt" class="el_EmployeeDashboard22_receipt">
<div id="fd_x<?= $Grid->RowIndex ?>_receipt" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Grid->receipt->title() ?>" data-table="EmployeeDashboard22" data-field="x_receipt" name="x<?= $Grid->RowIndex ?>_receipt" id="x<?= $Grid->RowIndex ?>_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Grid->receipt->editAttributes() ?><?= ($Grid->receipt->ReadOnly || $Grid->receipt->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Grid->receipt->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_receipt" id= "fn_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_receipt" id= "fa_x<?= $Grid->RowIndex ?>_receipt" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_receipt" id= "fs_x<?= $Grid->RowIndex ?>_receipt" value="0">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_receipt" id= "fx_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_receipt" id= "fm_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_receipt" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_receipt" class="el_EmployeeDashboard22_receipt">
<div id="fd_x<?= $Grid->RowIndex ?>_receipt">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->receipt->title() ?>" data-table="EmployeeDashboard22" data-field="x_receipt" name="x<?= $Grid->RowIndex ?>_receipt" id="x<?= $Grid->RowIndex ?>_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Grid->receipt->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->receipt->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_receipt" id= "fn_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_receipt" id= "fa_x<?= $Grid->RowIndex ?>_receipt" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_receipt" id= "fs_x<?= $Grid->RowIndex ?>_receipt" value="0">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_receipt" id= "fx_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_receipt" id= "fm_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_receipt" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_receipt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_receipt" id="o<?= $Grid->RowIndex ?>_receipt" value="<?= HtmlEncode($Grid->receipt->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_receipt" class="el_EmployeeDashboard22_receipt">
<span>
<?= GetFileViewTag($Grid->receipt, $Grid->receipt->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_receipt" class="el_EmployeeDashboard22_receipt">
<div id="fd_x<?= $Grid->RowIndex ?>_receipt">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->receipt->title() ?>" data-table="EmployeeDashboard22" data-field="x_receipt" name="x<?= $Grid->RowIndex ?>_receipt" id="x<?= $Grid->RowIndex ?>_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Grid->receipt->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->receipt->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_receipt" id= "fn_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_receipt" id= "fa_x<?= $Grid->RowIndex ?>_receipt" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_receipt") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_receipt" id= "fs_x<?= $Grid->RowIndex ?>_receipt" value="0">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_receipt" id= "fx_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_receipt" id= "fm_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_receipt" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_receipt" class="el_EmployeeDashboard22_receipt">
<div id="fd_x<?= $Grid->RowIndex ?>_receipt">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->receipt->title() ?>" data-table="EmployeeDashboard22" data-field="x_receipt" name="x<?= $Grid->RowIndex ?>_receipt" id="x<?= $Grid->RowIndex ?>_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Grid->receipt->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->receipt->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_receipt" id= "fn_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_receipt" id= "fa_x<?= $Grid->RowIndex ?>_receipt" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_receipt") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_receipt" id= "fs_x<?= $Grid->RowIndex ?>_receipt" value="0">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_receipt" id= "fx_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_receipt" id= "fm_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_receipt" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->note->Visible) { // note ?>
        <td data-name="note"<?= $Grid->note->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_note" class="el_EmployeeDashboard22_note">
<input type="<?= $Grid->note->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_note" id="x<?= $Grid->RowIndex ?>_note" data-table="EmployeeDashboard22" data-field="x_note" value="<?= $Grid->note->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->note->getPlaceHolder()) ?>"<?= $Grid->note->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->note->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_note" data-hidden="1" name="o<?= $Grid->RowIndex ?>_note" id="o<?= $Grid->RowIndex ?>_note" value="<?= HtmlEncode($Grid->note->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_note" class="el_EmployeeDashboard22_note">
<input type="<?= $Grid->note->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_note" id="x<?= $Grid->RowIndex ?>_note" data-table="EmployeeDashboard22" data-field="x_note" value="<?= $Grid->note->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->note->getPlaceHolder()) ?>"<?= $Grid->note->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->note->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_note" class="el_EmployeeDashboard22_note">
<span<?= $Grid->note->viewAttributes() ?>>
<?= $Grid->note->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_note" data-hidden="1" name="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_note" id="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_note" value="<?= HtmlEncode($Grid->note->FormValue) ?>">
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_note" data-hidden="1" name="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_note" id="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_note" value="<?= HtmlEncode($Grid->note->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status"<?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_status" class="el_EmployeeDashboard22_status">
<template id="tp_x<?= $Grid->RowIndex ?>_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="EmployeeDashboard22" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status"<?= $Grid->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status"
    name="x<?= $Grid->RowIndex ?>_status"
    value="<?= HtmlEncode($Grid->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status->isInvalidClass() ?>"
    data-table="EmployeeDashboard22"
    data-field="x_status"
    data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_status" class="el_EmployeeDashboard22_status">
<span<?= $Grid->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status->getDisplayValue($Grid->status->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_status" class="el_EmployeeDashboard22_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_status" data-hidden="1" name="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_status" id="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_status" data-hidden="1" name="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_status" id="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dateClosed->Visible) { // dateClosed ?>
        <td data-name="dateClosed"<?= $Grid->dateClosed->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_dateClosed" class="el_EmployeeDashboard22_dateClosed">
<input type="<?= $Grid->dateClosed->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateClosed" id="x<?= $Grid->RowIndex ?>_dateClosed" data-table="EmployeeDashboard22" data-field="x_dateClosed" value="<?= $Grid->dateClosed->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateClosed->getPlaceHolder()) ?>"<?= $Grid->dateClosed->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateClosed->getErrorMessage() ?></div>
<?php if (!$Grid->dateClosed->ReadOnly && !$Grid->dateClosed->Disabled && !isset($Grid->dateClosed->EditAttrs["readonly"]) && !isset($Grid->dateClosed->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fEmployeeDashboard22grid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fEmployeeDashboard22grid", "x<?= $Grid->RowIndex ?>_dateClosed", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateClosed" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dateClosed" id="o<?= $Grid->RowIndex ?>_dateClosed" value="<?= HtmlEncode($Grid->dateClosed->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_dateClosed" class="el_EmployeeDashboard22_dateClosed">
<span<?= $Grid->dateClosed->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->dateClosed->getDisplayValue($Grid->dateClosed->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateClosed" data-hidden="1" name="x<?= $Grid->RowIndex ?>_dateClosed" id="x<?= $Grid->RowIndex ?>_dateClosed" value="<?= HtmlEncode($Grid->dateClosed->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_dateClosed" class="el_EmployeeDashboard22_dateClosed">
<span<?= $Grid->dateClosed->viewAttributes() ?>>
<?= $Grid->dateClosed->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateClosed" data-hidden="1" name="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_dateClosed" id="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_dateClosed" value="<?= HtmlEncode($Grid->dateClosed->FormValue) ?>">
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateClosed" data-hidden="1" name="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_dateClosed" id="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_dateClosed" value="<?= HtmlEncode($Grid->dateClosed->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->float_status->Visible) { // float_status ?>
        <td data-name="float_status"<?= $Grid->float_status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_float_status" class="el_EmployeeDashboard22_float_status">
<template id="tp_x<?= $Grid->RowIndex ?>_float_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="EmployeeDashboard22" data-field="x_float_status" name="x<?= $Grid->RowIndex ?>_float_status" id="x<?= $Grid->RowIndex ?>_float_status"<?= $Grid->float_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_float_status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_float_status"
    name="x<?= $Grid->RowIndex ?>_float_status"
    value="<?= HtmlEncode($Grid->float_status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_float_status"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_float_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->float_status->isInvalidClass() ?>"
    data-table="EmployeeDashboard22"
    data-field="x_float_status"
    data-value-separator="<?= $Grid->float_status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->float_status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->float_status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_float_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_float_status" id="o<?= $Grid->RowIndex ?>_float_status" value="<?= HtmlEncode($Grid->float_status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_float_status" class="el_EmployeeDashboard22_float_status">
<span<?= $Grid->float_status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->float_status->getDisplayValue($Grid->float_status->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_float_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_float_status" id="x<?= $Grid->RowIndex ?>_float_status" value="<?= HtmlEncode($Grid->float_status->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_float_status" class="el_EmployeeDashboard22_float_status">
<span<?= $Grid->float_status->viewAttributes() ?>>
<?= $Grid->float_status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_float_status" data-hidden="1" name="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_float_status" id="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_float_status" value="<?= HtmlEncode($Grid->float_status->FormValue) ?>">
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_float_status" data-hidden="1" name="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_float_status" id="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_float_status" value="<?= HtmlEncode($Grid->float_status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cash_float->Visible) { // cash_float ?>
        <td data-name="cash_float"<?= $Grid->cash_float->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_cash_float" class="el_EmployeeDashboard22_cash_float">
<input type="<?= $Grid->cash_float->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cash_float" id="x<?= $Grid->RowIndex ?>_cash_float" data-table="EmployeeDashboard22" data-field="x_cash_float" value="<?= $Grid->cash_float->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->cash_float->getPlaceHolder()) ?>"<?= $Grid->cash_float->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cash_float->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cash_float" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cash_float" id="o<?= $Grid->RowIndex ?>_cash_float" value="<?= HtmlEncode($Grid->cash_float->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_cash_float" class="el_EmployeeDashboard22_cash_float">
<span<?= $Grid->cash_float->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cash_float->getDisplayValue($Grid->cash_float->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cash_float" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cash_float" id="x<?= $Grid->RowIndex ?>_cash_float" value="<?= HtmlEncode($Grid->cash_float->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_EmployeeDashboard22_cash_float" class="el_EmployeeDashboard22_cash_float">
<span<?= $Grid->cash_float->viewAttributes() ?>>
<?= $Grid->cash_float->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cash_float" data-hidden="1" name="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_cash_float" id="fEmployeeDashboard22grid$x<?= $Grid->RowIndex ?>_cash_float" value="<?= HtmlEncode($Grid->cash_float->FormValue) ?>">
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cash_float" data-hidden="1" name="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_cash_float" id="fEmployeeDashboard22grid$o<?= $Grid->RowIndex ?>_cash_float" value="<?= HtmlEncode($Grid->cash_float->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fEmployeeDashboard22grid","load"], () => fEmployeeDashboard22grid.updateLists(<?= $Grid->RowIndex ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
    $Grid->RowIndex = '$rowindex$';
    $Grid->loadRowValues();

    // Set row properties
    $Grid->resetAttributes();
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_EmployeeDashboard22", "data-rowtype" => ROWTYPE_ADD]);
    $Grid->RowAttrs->appendClass("ew-template");

    // Reset previous form error if any
    $Grid->resetFormError();

    // Render row
    $Grid->RowType = ROWTYPE_ADD;
    $Grid->renderRow();

    // Render list options
    $Grid->renderListOptions();
    $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_id" class="el_EmployeeDashboard22_id"></span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_id" class="el_EmployeeDashboard22_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cashAdvance_id->Visible) { // cashAdvance_id ?>
        <td data-name="cashAdvance_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_cashAdvance_id" class="el_EmployeeDashboard22_cashAdvance_id">
    <select
        id="x<?= $Grid->RowIndex ?>_cashAdvance_id"
        name="x<?= $Grid->RowIndex ?>_cashAdvance_id"
        class="form-select ew-select<?= $Grid->cashAdvance_id->isInvalidClass() ?>"
        data-select2-id="fEmployeeDashboard22grid_x<?= $Grid->RowIndex ?>_cashAdvance_id"
        data-table="EmployeeDashboard22"
        data-field="x_cashAdvance_id"
        data-value-separator="<?= $Grid->cashAdvance_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cashAdvance_id->getPlaceHolder()) ?>"
        <?= $Grid->cashAdvance_id->editAttributes() ?>>
        <?= $Grid->cashAdvance_id->selectOptionListHtml("x{$Grid->RowIndex}_cashAdvance_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cashAdvance_id->getErrorMessage() ?></div>
<?= $Grid->cashAdvance_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cashAdvance_id") ?>
<script>
loadjs.ready("fEmployeeDashboard22grid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cashAdvance_id", selectId: "fEmployeeDashboard22grid_x<?= $Grid->RowIndex ?>_cashAdvance_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fEmployeeDashboard22grid.lists.cashAdvance_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cashAdvance_id", form: "fEmployeeDashboard22grid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cashAdvance_id", form: "fEmployeeDashboard22grid", limit: 7 };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.EmployeeDashboard22.fields.cashAdvance_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_cashAdvance_id" class="el_EmployeeDashboard22_cashAdvance_id">
<span<?= $Grid->cashAdvance_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->cashAdvance_id->getDisplayValue($Grid->cashAdvance_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cashAdvance_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cashAdvance_id" id="x<?= $Grid->RowIndex ?>_cashAdvance_id" value="<?= HtmlEncode($Grid->cashAdvance_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cashAdvance_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cashAdvance_id" id="o<?= $Grid->RowIndex ?>_cashAdvance_id" value="<?= HtmlEncode($Grid->cashAdvance_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->amount->Visible) { // amount ?>
        <td data-name="amount">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_amount" class="el_EmployeeDashboard22_amount">
<input type="<?= $Grid->amount->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_amount" id="x<?= $Grid->RowIndex ?>_amount" data-table="EmployeeDashboard22" data-field="x_amount" value="<?= $Grid->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->amount->getPlaceHolder()) ?>"<?= $Grid->amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_amount" class="el_EmployeeDashboard22_amount">
<span<?= $Grid->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->amount->getDisplayValue($Grid->amount->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_amount" data-hidden="1" name="x<?= $Grid->RowIndex ?>_amount" id="x<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_amount" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amount" id="o<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->dateTrans->Visible) { // dateTrans ?>
        <td data-name="dateTrans">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_dateTrans" class="el_EmployeeDashboard22_dateTrans">
<input type="<?= $Grid->dateTrans->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateTrans" id="x<?= $Grid->RowIndex ?>_dateTrans" data-table="EmployeeDashboard22" data-field="x_dateTrans" value="<?= $Grid->dateTrans->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateTrans->getPlaceHolder()) ?>"<?= $Grid->dateTrans->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateTrans->getErrorMessage() ?></div>
<?php if (!$Grid->dateTrans->ReadOnly && !$Grid->dateTrans->Disabled && !isset($Grid->dateTrans->EditAttrs["readonly"]) && !isset($Grid->dateTrans->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fEmployeeDashboard22grid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fEmployeeDashboard22grid", "x<?= $Grid->RowIndex ?>_dateTrans", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_dateTrans" class="el_EmployeeDashboard22_dateTrans">
<span<?= $Grid->dateTrans->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->dateTrans->getDisplayValue($Grid->dateTrans->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateTrans" data-hidden="1" name="x<?= $Grid->RowIndex ?>_dateTrans" id="x<?= $Grid->RowIndex ?>_dateTrans" value="<?= HtmlEncode($Grid->dateTrans->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateTrans" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dateTrans" id="o<?= $Grid->RowIndex ?>_dateTrans" value="<?= HtmlEncode($Grid->dateTrans->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->receiptNumber->Visible) { // receiptNumber ?>
        <td data-name="receiptNumber">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_receiptNumber" class="el_EmployeeDashboard22_receiptNumber">
<input type="<?= $Grid->receiptNumber->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_receiptNumber" id="x<?= $Grid->RowIndex ?>_receiptNumber" data-table="EmployeeDashboard22" data-field="x_receiptNumber" value="<?= $Grid->receiptNumber->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->receiptNumber->getPlaceHolder()) ?>"<?= $Grid->receiptNumber->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->receiptNumber->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_receiptNumber" class="el_EmployeeDashboard22_receiptNumber">
<span<?= $Grid->receiptNumber->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->receiptNumber->getDisplayValue($Grid->receiptNumber->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_receiptNumber" data-hidden="1" name="x<?= $Grid->RowIndex ?>_receiptNumber" id="x<?= $Grid->RowIndex ?>_receiptNumber" value="<?= HtmlEncode($Grid->receiptNumber->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_receiptNumber" data-hidden="1" name="o<?= $Grid->RowIndex ?>_receiptNumber" id="o<?= $Grid->RowIndex ?>_receiptNumber" value="<?= HtmlEncode($Grid->receiptNumber->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->receipt->Visible) { // receipt ?>
        <td data-name="receipt">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_receipt" class="el_EmployeeDashboard22_receipt">
<div id="fd_x<?= $Grid->RowIndex ?>_receipt" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Grid->receipt->title() ?>" data-table="EmployeeDashboard22" data-field="x_receipt" name="x<?= $Grid->RowIndex ?>_receipt" id="x<?= $Grid->RowIndex ?>_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Grid->receipt->editAttributes() ?><?= ($Grid->receipt->ReadOnly || $Grid->receipt->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Grid->receipt->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_receipt" id= "fn_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_receipt" id= "fa_x<?= $Grid->RowIndex ?>_receipt" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_receipt" id= "fs_x<?= $Grid->RowIndex ?>_receipt" value="0">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_receipt" id= "fx_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_receipt" id= "fm_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_receipt" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_receipt" class="el_EmployeeDashboard22_receipt">
<div id="fd_x<?= $Grid->RowIndex ?>_receipt">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->receipt->title() ?>" data-table="EmployeeDashboard22" data-field="x_receipt" name="x<?= $Grid->RowIndex ?>_receipt" id="x<?= $Grid->RowIndex ?>_receipt" lang="<?= CurrentLanguageID() ?>"<?= $Grid->receipt->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->receipt->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_receipt" id= "fn_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_receipt" id= "fa_x<?= $Grid->RowIndex ?>_receipt" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_receipt" id= "fs_x<?= $Grid->RowIndex ?>_receipt" value="0">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_receipt" id= "fx_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_receipt" id= "fm_x<?= $Grid->RowIndex ?>_receipt" value="<?= $Grid->receipt->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_receipt" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_receipt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_receipt" id="o<?= $Grid->RowIndex ?>_receipt" value="<?= HtmlEncode($Grid->receipt->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->note->Visible) { // note ?>
        <td data-name="note">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_note" class="el_EmployeeDashboard22_note">
<input type="<?= $Grid->note->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_note" id="x<?= $Grid->RowIndex ?>_note" data-table="EmployeeDashboard22" data-field="x_note" value="<?= $Grid->note->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->note->getPlaceHolder()) ?>"<?= $Grid->note->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->note->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_note" class="el_EmployeeDashboard22_note">
<span<?= $Grid->note->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->note->getDisplayValue($Grid->note->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_note" data-hidden="1" name="x<?= $Grid->RowIndex ?>_note" id="x<?= $Grid->RowIndex ?>_note" value="<?= HtmlEncode($Grid->note->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_note" data-hidden="1" name="o<?= $Grid->RowIndex ?>_note" id="o<?= $Grid->RowIndex ?>_note" value="<?= HtmlEncode($Grid->note->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_status" class="el_EmployeeDashboard22_status">
<template id="tp_x<?= $Grid->RowIndex ?>_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="EmployeeDashboard22" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status"<?= $Grid->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status"
    name="x<?= $Grid->RowIndex ?>_status"
    value="<?= HtmlEncode($Grid->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status->isInvalidClass() ?>"
    data-table="EmployeeDashboard22"
    data-field="x_status"
    data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_status" class="el_EmployeeDashboard22_status">
<span<?= $Grid->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status->getDisplayValue($Grid->status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->dateClosed->Visible) { // dateClosed ?>
        <td data-name="dateClosed">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_dateClosed" class="el_EmployeeDashboard22_dateClosed">
<input type="<?= $Grid->dateClosed->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateClosed" id="x<?= $Grid->RowIndex ?>_dateClosed" data-table="EmployeeDashboard22" data-field="x_dateClosed" value="<?= $Grid->dateClosed->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateClosed->getPlaceHolder()) ?>"<?= $Grid->dateClosed->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateClosed->getErrorMessage() ?></div>
<?php if (!$Grid->dateClosed->ReadOnly && !$Grid->dateClosed->Disabled && !isset($Grid->dateClosed->EditAttrs["readonly"]) && !isset($Grid->dateClosed->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fEmployeeDashboard22grid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fEmployeeDashboard22grid", "x<?= $Grid->RowIndex ?>_dateClosed", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_dateClosed" class="el_EmployeeDashboard22_dateClosed">
<span<?= $Grid->dateClosed->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->dateClosed->getDisplayValue($Grid->dateClosed->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateClosed" data-hidden="1" name="x<?= $Grid->RowIndex ?>_dateClosed" id="x<?= $Grid->RowIndex ?>_dateClosed" value="<?= HtmlEncode($Grid->dateClosed->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_dateClosed" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dateClosed" id="o<?= $Grid->RowIndex ?>_dateClosed" value="<?= HtmlEncode($Grid->dateClosed->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->float_status->Visible) { // float_status ?>
        <td data-name="float_status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_float_status" class="el_EmployeeDashboard22_float_status">
<template id="tp_x<?= $Grid->RowIndex ?>_float_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="EmployeeDashboard22" data-field="x_float_status" name="x<?= $Grid->RowIndex ?>_float_status" id="x<?= $Grid->RowIndex ?>_float_status"<?= $Grid->float_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_float_status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_float_status"
    name="x<?= $Grid->RowIndex ?>_float_status"
    value="<?= HtmlEncode($Grid->float_status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_float_status"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_float_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->float_status->isInvalidClass() ?>"
    data-table="EmployeeDashboard22"
    data-field="x_float_status"
    data-value-separator="<?= $Grid->float_status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->float_status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->float_status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_float_status" class="el_EmployeeDashboard22_float_status">
<span<?= $Grid->float_status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->float_status->getDisplayValue($Grid->float_status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_float_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_float_status" id="x<?= $Grid->RowIndex ?>_float_status" value="<?= HtmlEncode($Grid->float_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_float_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_float_status" id="o<?= $Grid->RowIndex ?>_float_status" value="<?= HtmlEncode($Grid->float_status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cash_float->Visible) { // cash_float ?>
        <td data-name="cash_float">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_EmployeeDashboard22_cash_float" class="el_EmployeeDashboard22_cash_float">
<input type="<?= $Grid->cash_float->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cash_float" id="x<?= $Grid->RowIndex ?>_cash_float" data-table="EmployeeDashboard22" data-field="x_cash_float" value="<?= $Grid->cash_float->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->cash_float->getPlaceHolder()) ?>"<?= $Grid->cash_float->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cash_float->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_EmployeeDashboard22_cash_float" class="el_EmployeeDashboard22_cash_float">
<span<?= $Grid->cash_float->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cash_float->getDisplayValue($Grid->cash_float->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cash_float" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cash_float" id="x<?= $Grid->RowIndex ?>_cash_float" value="<?= HtmlEncode($Grid->cash_float->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="EmployeeDashboard22" data-field="x_cash_float" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cash_float" id="o<?= $Grid->RowIndex ?>_cash_float" value="<?= HtmlEncode($Grid->cash_float->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fEmployeeDashboard22grid","load"], () => fEmployeeDashboard22grid.updateLists(<?= $Grid->RowIndex ?>, true));
</script>
    </tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fEmployeeDashboard22grid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("EmployeeDashboard22");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
