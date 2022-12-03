<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmployeeDashboard2List = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { EmployeeDashboard2: currentTable } });
var currentForm, currentPageID;
var fEmployeeDashboard2list;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fEmployeeDashboard2list = new ew.Form("fEmployeeDashboard2list", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fEmployeeDashboard2list;
    fEmployeeDashboard2list.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Dynamic selection lists
    fEmployeeDashboard2list.lists.cashAdvance_id = <?= $Page->cashAdvance_id->toClientList($Page) ?>;
    fEmployeeDashboard2list.lists.dateTrans = <?= $Page->dateTrans->toClientList($Page) ?>;
    fEmployeeDashboard2list.lists.status = <?= $Page->status->toClientList($Page) ?>;
    fEmployeeDashboard2list.lists.float_status = <?= $Page->float_status->toClientList($Page) ?>;
    loadjs.done("fEmployeeDashboard2list");
});
var fEmployeeDashboard2srch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fEmployeeDashboard2srch = new ew.Form("fEmployeeDashboard2srch", "list");
    currentSearchForm = fEmployeeDashboard2srch;

    // Add fields
    var fields = currentTable.fields;
    fEmployeeDashboard2srch.addFields([
        ["id", [], fields.id.isInvalid],
        ["cashAdvance_id", [], fields.cashAdvance_id.isInvalid],
        ["amount", [], fields.amount.isInvalid],
        ["dateTrans", [], fields.dateTrans.isInvalid],
        ["receiptNumber", [], fields.receiptNumber.isInvalid],
        ["receipt", [], fields.receipt.isInvalid],
        ["note", [], fields.note.isInvalid],
        ["status", [], fields.status.isInvalid],
        ["dateClosed", [], fields.dateClosed.isInvalid],
        ["float_status", [], fields.float_status.isInvalid],
        ["cash_float", [], fields.cash_float.isInvalid]
    ]);

    // Validate form
    fEmployeeDashboard2srch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm();

        // Validate fields
        if (!this.validateFields())
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fEmployeeDashboard2srch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fEmployeeDashboard2srch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fEmployeeDashboard2srch.lists.dateTrans = <?= $Page->dateTrans->toClientList($Page) ?>;
    fEmployeeDashboard2srch.lists.submittedBy = <?= $Page->submittedBy->toClientList($Page) ?>;

    // Filters
    fEmployeeDashboard2srch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fEmployeeDashboard2srch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fEmployeeDashboard2srch" id="fEmployeeDashboard2srch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fEmployeeDashboard2srch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="EmployeeDashboard2">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
<?php
if (!$Page->dateTrans->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_dateTrans" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->dateTrans->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_dateTrans"
            name="x_dateTrans[]"
            class="form-control ew-select<?= $Page->dateTrans->isInvalidClass() ?>"
            data-select2-id="fEmployeeDashboard2srch_x_dateTrans"
            data-table="EmployeeDashboard2"
            data-field="x_dateTrans"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->dateTrans->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->dateTrans->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->dateTrans->getPlaceHolder()) ?>"
            <?= $Page->dateTrans->editAttributes() ?>>
            <?= $Page->dateTrans->selectOptionListHtml("x_dateTrans", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->dateTrans->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fEmployeeDashboard2srch", function() {
            var options = {
                name: "x_dateTrans",
                selectId: "fEmployeeDashboard2srch_x_dateTrans",
                ajax: { id: "x_dateTrans", form: "fEmployeeDashboard2srch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.EmployeeDashboard2.fields.dateTrans.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
<?php
if (!$Page->submittedBy->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_submittedBy" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->submittedBy->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_submittedBy"
            name="x_submittedBy[]"
            class="form-control ew-select<?= $Page->submittedBy->isInvalidClass() ?>"
            data-select2-id="fEmployeeDashboard2srch_x_submittedBy"
            data-table="EmployeeDashboard2"
            data-field="x_submittedBy"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->submittedBy->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->submittedBy->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->submittedBy->getPlaceHolder()) ?>"
            <?= $Page->submittedBy->editAttributes() ?>>
            <?= $Page->submittedBy->selectOptionListHtml("x_submittedBy", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->submittedBy->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fEmployeeDashboard2srch", function() {
            var options = {
                name: "x_submittedBy",
                selectId: "fEmployeeDashboard2srch_x_submittedBy",
                ajax: { id: "x_submittedBy", form: "fEmployeeDashboard2srch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.EmployeeDashboard2.fields.submittedBy.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fEmployeeDashboard2srch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fEmployeeDashboard2srch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fEmployeeDashboard2srch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fEmployeeDashboard2srch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> EmployeeDashboard2">
<form name="fEmployeeDashboard2list" id="fEmployeeDashboard2list" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="EmployeeDashboard2">
<div id="gmp_EmployeeDashboard2" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_EmployeeDashboard2list" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_id" class="EmployeeDashboard2_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->cashAdvance_id->Visible) { // cashAdvance_id ?>
        <th data-name="cashAdvance_id" class="<?= $Page->cashAdvance_id->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_cashAdvance_id" class="EmployeeDashboard2_cashAdvance_id"><?= $Page->renderFieldHeader($Page->cashAdvance_id) ?></div></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_amount" class="EmployeeDashboard2_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
        <th data-name="dateTrans" class="<?= $Page->dateTrans->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_dateTrans" class="EmployeeDashboard2_dateTrans"><?= $Page->renderFieldHeader($Page->dateTrans) ?></div></th>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
        <th data-name="receiptNumber" class="<?= $Page->receiptNumber->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_receiptNumber" class="EmployeeDashboard2_receiptNumber"><?= $Page->renderFieldHeader($Page->receiptNumber) ?></div></th>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
        <th data-name="receipt" class="<?= $Page->receipt->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_receipt" class="EmployeeDashboard2_receipt"><?= $Page->renderFieldHeader($Page->receipt) ?></div></th>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
        <th data-name="note" class="<?= $Page->note->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_note" class="EmployeeDashboard2_note"><?= $Page->renderFieldHeader($Page->note) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_status" class="EmployeeDashboard2_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
        <th data-name="dateClosed" class="<?= $Page->dateClosed->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_dateClosed" class="EmployeeDashboard2_dateClosed"><?= $Page->renderFieldHeader($Page->dateClosed) ?></div></th>
<?php } ?>
<?php if ($Page->float_status->Visible) { // float_status ?>
        <th data-name="float_status" class="<?= $Page->float_status->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_float_status" class="EmployeeDashboard2_float_status"><?= $Page->renderFieldHeader($Page->float_status) ?></div></th>
<?php } ?>
<?php if ($Page->cash_float->Visible) { // cash_float ?>
        <th data-name="cash_float" class="<?= $Page->cash_float->headerCellClass() ?>"><div id="elh_EmployeeDashboard2_cash_float" class="EmployeeDashboard2_cash_float"><?= $Page->renderFieldHeader($Page->cash_float) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_EmployeeDashboard2",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_id" class="el_EmployeeDashboard2_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cashAdvance_id->Visible) { // cashAdvance_id ?>
        <td data-name="cashAdvance_id"<?= $Page->cashAdvance_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_cashAdvance_id" class="el_EmployeeDashboard2_cashAdvance_id">
<span<?= $Page->cashAdvance_id->viewAttributes() ?>>
<?= $Page->cashAdvance_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amount->Visible) { // amount ?>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_amount" class="el_EmployeeDashboard2_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dateTrans->Visible) { // dateTrans ?>
        <td data-name="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_dateTrans" class="el_EmployeeDashboard2_dateTrans">
<span<?= $Page->dateTrans->viewAttributes() ?>>
<?= $Page->dateTrans->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
        <td data-name="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_receiptNumber" class="el_EmployeeDashboard2_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receipt->Visible) { // receipt ?>
        <td data-name="receipt"<?= $Page->receipt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_receipt" class="el_EmployeeDashboard2_receipt">
<span>
<?= GetFileViewTag($Page->receipt, $Page->receipt->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->note->Visible) { // note ?>
        <td data-name="note"<?= $Page->note->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_note" class="el_EmployeeDashboard2_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_status" class="el_EmployeeDashboard2_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dateClosed->Visible) { // dateClosed ?>
        <td data-name="dateClosed"<?= $Page->dateClosed->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_dateClosed" class="el_EmployeeDashboard2_dateClosed">
<span<?= $Page->dateClosed->viewAttributes() ?>>
<?= $Page->dateClosed->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->float_status->Visible) { // float_status ?>
        <td data-name="float_status"<?= $Page->float_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_float_status" class="el_EmployeeDashboard2_float_status">
<span<?= $Page->float_status->viewAttributes() ?>>
<?= $Page->float_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cash_float->Visible) { // cash_float ?>
        <td data-name="cash_float"<?= $Page->cash_float->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_EmployeeDashboard2_cash_float" class="el_EmployeeDashboard2_cash_float">
<span<?= $Page->cash_float->viewAttributes() ?>>
<?= $Page->cash_float->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("EmployeeDashboard2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
