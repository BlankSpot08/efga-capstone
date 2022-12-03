<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$ManExpenseList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { man_expense: currentTable } });
var currentForm, currentPageID;
var fman_expenselist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fman_expenselist = new ew.Form("fman_expenselist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fman_expenselist;
    fman_expenselist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Dynamic selection lists
    fman_expenselist.lists.expCategory = <?= $Page->expCategory->toClientList($Page) ?>;
    loadjs.done("fman_expenselist");
});
var fman_expensesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fman_expensesrch = new ew.Form("fman_expensesrch", "list");
    currentSearchForm = fman_expensesrch;

    // Add fields
    var fields = currentTable.fields;
    fman_expensesrch.addFields([
        ["id", [], fields.id.isInvalid],
        ["expCategory", [], fields.expCategory.isInvalid],
        ["amount", [], fields.amount.isInvalid],
        ["receipt", [], fields.receipt.isInvalid],
        ["receiptNumber", [], fields.receiptNumber.isInvalid],
        ["date", [], fields.date.isInvalid]
    ]);

    // Validate form
    fman_expensesrch.validate = function () {
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
    fman_expensesrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fman_expensesrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fman_expensesrch.lists.expCategory = <?= $Page->expCategory->toClientList($Page) ?>;
    fman_expensesrch.lists.expSubcategory = <?= $Page->expSubcategory->toClientList($Page) ?>;

    // Filters
    fman_expensesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fman_expensesrch");
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
<form name="fman_expensesrch" id="fman_expensesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fman_expensesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="man_expense">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
<?php
if (!$Page->expCategory->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_expCategory" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->expCategory->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_expCategory"
            name="x_expCategory[]"
            class="form-control ew-select<?= $Page->expCategory->isInvalidClass() ?>"
            data-select2-id="fman_expensesrch_x_expCategory"
            data-table="man_expense"
            data-field="x_expCategory"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->expCategory->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->expCategory->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->expCategory->getPlaceHolder()) ?>"
            <?= $Page->expCategory->editAttributes() ?>>
            <?= $Page->expCategory->selectOptionListHtml("x_expCategory", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->expCategory->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fman_expensesrch", function() {
            var options = {
                name: "x_expCategory",
                selectId: "fman_expensesrch_x_expCategory",
                ajax: { id: "x_expCategory", form: "fman_expensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.man_expense.fields.expCategory.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
<?php
if (!$Page->expSubcategory->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_expSubcategory" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->expSubcategory->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_expSubcategory"
            name="x_expSubcategory[]"
            class="form-control ew-select<?= $Page->expSubcategory->isInvalidClass() ?>"
            data-select2-id="fman_expensesrch_x_expSubcategory"
            data-table="man_expense"
            data-field="x_expSubcategory"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->expSubcategory->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->expSubcategory->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->expSubcategory->getPlaceHolder()) ?>"
            <?= $Page->expSubcategory->editAttributes() ?>>
            <?= $Page->expSubcategory->selectOptionListHtml("x_expSubcategory", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->expSubcategory->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fman_expensesrch", function() {
            var options = {
                name: "x_expSubcategory",
                selectId: "fman_expensesrch_x_expSubcategory",
                ajax: { id: "x_expSubcategory", form: "fman_expensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.man_expense.fields.expSubcategory.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> man_expense">
<form name="fman_expenselist" id="fman_expenselist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="man_expense">
<div id="gmp_man_expense" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_man_expenselist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_man_expense_id" class="man_expense_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
        <th data-name="expCategory" class="<?= $Page->expCategory->headerCellClass() ?>"><div id="elh_man_expense_expCategory" class="man_expense_expCategory"><?= $Page->renderFieldHeader($Page->expCategory) ?></div></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div id="elh_man_expense_amount" class="man_expense_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
        <th data-name="receipt" class="<?= $Page->receipt->headerCellClass() ?>"><div id="elh_man_expense_receipt" class="man_expense_receipt"><?= $Page->renderFieldHeader($Page->receipt) ?></div></th>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
        <th data-name="receiptNumber" class="<?= $Page->receiptNumber->headerCellClass() ?>"><div id="elh_man_expense_receiptNumber" class="man_expense_receiptNumber"><?= $Page->renderFieldHeader($Page->receiptNumber) ?></div></th>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <th data-name="date" class="<?= $Page->date->headerCellClass() ?>"><div id="elh_man_expense_date" class="man_expense_date"><?= $Page->renderFieldHeader($Page->date) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_man_expense",
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
<span id="el<?= $Page->RowCount ?>_man_expense_id" class="el_man_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expCategory->Visible) { // expCategory ?>
        <td data-name="expCategory"<?= $Page->expCategory->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_man_expense_expCategory" class="el_man_expense_expCategory">
<span<?= $Page->expCategory->viewAttributes() ?>>
<?= $Page->expCategory->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amount->Visible) { // amount ?>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_man_expense_amount" class="el_man_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receipt->Visible) { // receipt ?>
        <td data-name="receipt"<?= $Page->receipt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_man_expense_receipt" class="el_man_expense_receipt">
<span>
<?= GetFileViewTag($Page->receipt, $Page->receipt->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
        <td data-name="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_man_expense_receiptNumber" class="el_man_expense_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date->Visible) { // date ?>
        <td data-name="date"<?= $Page->date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_man_expense_date" class="el_man_expense_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
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
    ew.addEventHandlers("man_expense");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
