<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmpMonthlyExpenseSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { EmpMonthlyExpense: currentTable } });
var currentForm, currentPageID;
var fEmpMonthlyExpensesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fEmpMonthlyExpensesrch = new ew.Form("fEmpMonthlyExpensesrch", "summary");
    currentSearchForm = fEmpMonthlyExpensesrch;
    currentPageID = ew.PAGE_ID = "summary";

    // Add fields
    var fields = currentTable.fields;
    fEmpMonthlyExpensesrch.addFields([
        ["expSubcategory", [], fields.expSubcategory.isInvalid],
        ["expCategory", [], fields.expCategory.isInvalid],
        ["amount", [], fields.amount.isInvalid],
        ["dateTrans", [], fields.dateTrans.isInvalid],
        ["receiptNumber", [], fields.receiptNumber.isInvalid],
        ["note", [], fields.note.isInvalid],
        ["submittedBy", [], fields.submittedBy.isInvalid],
        ["dateClosed", [], fields.dateClosed.isInvalid],
        ["validatedBy", [], fields.validatedBy.isInvalid],
        ["cash_float", [], fields.cash_float.isInvalid]
    ]);

    // Validate form
    fEmpMonthlyExpensesrch.validate = function () {
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
    fEmpMonthlyExpensesrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fEmpMonthlyExpensesrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fEmpMonthlyExpensesrch.lists.expSubcategory = <?= $Page->expSubcategory->toClientList($Page) ?>;
    fEmpMonthlyExpensesrch.lists.expCategory = <?= $Page->expCategory->toClientList($Page) ?>;
    fEmpMonthlyExpensesrch.lists.dateTrans = <?= $Page->dateTrans->toClientList($Page) ?>;
    fEmpMonthlyExpensesrch.lists.submittedBy = <?= $Page->submittedBy->toClientList($Page) ?>;
    fEmpMonthlyExpensesrch.lists.dateClosed = <?= $Page->dateClosed->toClientList($Page) ?>;
    fEmpMonthlyExpensesrch.lists.validatedBy = <?= $Page->validatedBy->toClientList($Page) ?>;

    // Filters
    fEmpMonthlyExpensesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fEmpMonthlyExpensesrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<a id="top"></a>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Content Container -->
<div id="ew-report" class="ew-report container-fluid">
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
    $Page->FilterOptions->render("body");
}
?>
</div>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<div class="row">
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Center Container -->
<div id="ew-center" class="<?= $Page->CenterContentClass ?>">
<?php } ?>
<!-- Summary report (begin) -->
<div id="report_summary">
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fEmpMonthlyExpensesrch" id="fEmpMonthlyExpensesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fEmpMonthlyExpensesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="EmpMonthlyExpense">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
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
            data-select2-id="fEmpMonthlyExpensesrch_x_expSubcategory"
            data-table="EmpMonthlyExpense"
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
        <div class="invalid-feedback"><?= $Page->expSubcategory->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fEmpMonthlyExpensesrch", function() {
            var options = {
                name: "x_expSubcategory",
                selectId: "fEmpMonthlyExpensesrch_x_expSubcategory",
                ajax: { id: "x_expSubcategory", form: "fEmpMonthlyExpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.EmpMonthlyExpense.fields.expSubcategory.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
            data-select2-id="fEmpMonthlyExpensesrch_x_expCategory"
            data-table="EmpMonthlyExpense"
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
        <div class="invalid-feedback"><?= $Page->expCategory->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fEmpMonthlyExpensesrch", function() {
            var options = {
                name: "x_expCategory",
                selectId: "fEmpMonthlyExpensesrch_x_expCategory",
                ajax: { id: "x_expCategory", form: "fEmpMonthlyExpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.EmpMonthlyExpense.fields.expCategory.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
            data-select2-id="fEmpMonthlyExpensesrch_x_dateTrans"
            data-table="EmpMonthlyExpense"
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
        <div class="invalid-feedback"><?= $Page->dateTrans->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fEmpMonthlyExpensesrch", function() {
            var options = {
                name: "x_dateTrans",
                selectId: "fEmpMonthlyExpensesrch_x_dateTrans",
                ajax: { id: "x_dateTrans", form: "fEmpMonthlyExpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.EmpMonthlyExpense.fields.dateTrans.filterOptions);
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
            data-select2-id="fEmpMonthlyExpensesrch_x_submittedBy"
            data-table="EmpMonthlyExpense"
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
        <div class="invalid-feedback"><?= $Page->submittedBy->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fEmpMonthlyExpensesrch", function() {
            var options = {
                name: "x_submittedBy",
                selectId: "fEmpMonthlyExpensesrch_x_submittedBy",
                ajax: { id: "x_submittedBy", form: "fEmpMonthlyExpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.EmpMonthlyExpense.fields.submittedBy.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
<?php
if (!$Page->dateClosed->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_dateClosed" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->dateClosed->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_dateClosed"
            name="x_dateClosed[]"
            class="form-control ew-select<?= $Page->dateClosed->isInvalidClass() ?>"
            data-select2-id="fEmpMonthlyExpensesrch_x_dateClosed"
            data-table="EmpMonthlyExpense"
            data-field="x_dateClosed"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->dateClosed->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->dateClosed->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->dateClosed->getPlaceHolder()) ?>"
            <?= $Page->dateClosed->editAttributes() ?>>
            <?= $Page->dateClosed->selectOptionListHtml("x_dateClosed", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->dateClosed->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fEmpMonthlyExpensesrch", function() {
            var options = {
                name: "x_dateClosed",
                selectId: "fEmpMonthlyExpensesrch_x_dateClosed",
                ajax: { id: "x_dateClosed", form: "fEmpMonthlyExpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.EmpMonthlyExpense.fields.dateClosed.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
<?php
if (!$Page->validatedBy->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_validatedBy" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->validatedBy->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_validatedBy"
            name="x_validatedBy[]"
            class="form-control ew-select<?= $Page->validatedBy->isInvalidClass() ?>"
            data-select2-id="fEmpMonthlyExpensesrch_x_validatedBy"
            data-table="EmpMonthlyExpense"
            data-field="x_validatedBy"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->validatedBy->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->validatedBy->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->validatedBy->getPlaceHolder()) ?>"
            <?= $Page->validatedBy->editAttributes() ?>>
            <?= $Page->validatedBy->selectOptionListHtml("x_validatedBy", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->validatedBy->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fEmpMonthlyExpensesrch", function() {
            var options = {
                name: "x_validatedBy",
                selectId: "fEmpMonthlyExpensesrch_x_validatedBy",
                ajax: { id: "x_validatedBy", form: "fEmpMonthlyExpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.EmpMonthlyExpense.fields.validatedBy.filterOptions);
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
<?php } ?>
<?php
while ($Page->GroupCount <= count($Page->GroupRecords) && $Page->GroupCount <= $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<?php if ($Page->GroupCount > 1) { ?>
</tbody>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
</div>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?= $Page->PageBreakContent ?>
<?php } ?>
<div class="<?php if (!$Page->isExport("word") && !$Page->isExport("excel")) { ?>card ew-card <?php } ?>ew-grid"<?= $Page->ReportTableStyle ?>>
<!-- Report grid (begin) -->
<div id="gmp_EmpMonthlyExpense" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="<?= $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->expCategory->Visible) { ?>
    <?php if ($Page->expCategory->ShowGroupHeaderAsRow) { ?>
    <th data-name="expCategory">&nbsp;</th>
    <?php } else { ?>
    <th data-name="expCategory" class="<?= $Page->expCategory->headerCellClass() ?>"><div class="EmpMonthlyExpense_expCategory"><?= $Page->renderFieldHeader($Page->expCategory) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { ?>
    <?php if ($Page->expSubcategory->ShowGroupHeaderAsRow) { ?>
    <th data-name="expSubcategory">&nbsp;</th>
    <?php } else { ?>
    <th data-name="expSubcategory" class="<?= $Page->expSubcategory->headerCellClass() ?>"><div class="EmpMonthlyExpense_expSubcategory"><?= $Page->renderFieldHeader($Page->expSubcategory) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { ?>
    <?php if ($Page->submittedBy->ShowGroupHeaderAsRow) { ?>
    <th data-name="submittedBy">&nbsp;</th>
    <?php } else { ?>
    <th data-name="submittedBy" class="<?= $Page->submittedBy->headerCellClass() ?>"><div class="EmpMonthlyExpense_submittedBy"><?= $Page->renderFieldHeader($Page->submittedBy) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
    <?php if ($Page->dateTrans->ShowGroupHeaderAsRow) { ?>
    <th data-name="dateTrans">&nbsp;</th>
    <?php } else { ?>
    <th data-name="dateTrans" class="<?= $Page->dateTrans->headerCellClass() ?>"><div class="EmpMonthlyExpense_dateTrans"><?= $Page->renderFieldHeader($Page->dateTrans) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
    <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div class="EmpMonthlyExpense_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
    <th data-name="receiptNumber" class="<?= $Page->receiptNumber->headerCellClass() ?>"><div class="EmpMonthlyExpense_receiptNumber"><?= $Page->renderFieldHeader($Page->receiptNumber) ?></div></th>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
    <th data-name="note" class="<?= $Page->note->headerCellClass() ?>"><div class="EmpMonthlyExpense_note"><?= $Page->renderFieldHeader($Page->note) ?></div></th>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { ?>
    <th data-name="dateClosed" class="<?= $Page->dateClosed->headerCellClass() ?>"><div class="EmpMonthlyExpense_dateClosed"><?= $Page->renderFieldHeader($Page->dateClosed) ?></div></th>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { ?>
    <th data-name="validatedBy" class="<?= $Page->validatedBy->headerCellClass() ?>"><div class="EmpMonthlyExpense_validatedBy"><?= $Page->renderFieldHeader($Page->validatedBy) ?></div></th>
<?php } ?>
<?php if ($Page->cash_float->Visible) { ?>
    <th data-name="cash_float" class="<?= $Page->cash_float->headerCellClass() ?>"><div class="EmpMonthlyExpense_cash_float"><?= $Page->renderFieldHeader($Page->cash_float) ?></div></th>
<?php } ?>
    </tr>
</thead>
<tbody>
<?php
        if ($Page->TotalGroups == 0) {
            break; // Show header only
        }
        $Page->ShowHeader = false;
    } // End show header
?>
<?php

    // Build detail SQL
    $where = DetailFilterSql($Page->expCategory, $Page->getSqlFirstGroupField(), $Page->expCategory->groupValue(), $Page->Dbid);
    if ($Page->PageFirstGroupFilter != "") {
        $Page->PageFirstGroupFilter .= " OR ";
    }
    $Page->PageFirstGroupFilter .= $where;
    if ($Page->Filter != "") {
        $where = "($Page->Filter) AND ($where)";
    }
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->execute();
    $Page->DetailRecords = $rs ? $rs->fetchAll() : [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->expCategory->Records = &$Page->DetailRecords;
    $Page->expCategory->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->expCategory->getCnt($Page->expCategory->Records); // Get record count
?>
<?php if ($Page->expCategory->Visible && $Page->expCategory->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 1;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expCategory->Visible) { ?>
        <?php $Page->expCategory->CellAttrs->appendClass("ew-rpt-grp-caret"); ?>
        <td data-field="expCategory"<?= $Page->expCategory->cellAttributes(); ?>><i class="ew-group-toggle fas fa-caret-down"></i></td>
        <?php $Page->expCategory->CellAttrs->removeClass("ew-rpt-grp-caret"); ?>
<?php } ?>
        <td data-field="expCategory" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->expCategory->cellAttributes() ?>>
            <span class="ew-summary-caption EmpMonthlyExpense_expCategory"><?= $Page->renderFieldHeader($Page->expCategory) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->expCategory->viewAttributes() ?>><?= $Page->expCategory->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->expCategory->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->expSubcategory->getDistinctValues($Page->expCategory->Records);
    $Page->setGroupCount(count($Page->expSubcategory->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->expSubcategory->DistinctValues as $expSubcategory) { // Load records for this distinct value
        $Page->expSubcategory->setGroupValue($expSubcategory); // Set group value
        $Page->expSubcategory->getDistinctRecords($Page->expCategory->Records, $Page->expSubcategory->groupValue());
        $Page->expSubcategory->LevelBreak = true; // Set field level break
        $Page->GroupCounter[2]++;
        $Page->expSubcategory->getCnt($Page->expSubcategory->Records); // Get record count
?>
<?php if ($Page->expSubcategory->Visible && $Page->expSubcategory->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->expSubcategory->setDbValue($expSubcategory); // Set current value for expSubcategory
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 2;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expCategory->Visible) { ?>
        <td data-field="expCategory"<?= $Page->expCategory->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { ?>
        <?php $Page->expSubcategory->CellAttrs->appendClass("ew-rpt-grp-caret"); ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes(); ?>><i class="ew-group-toggle fas fa-caret-down"></i></td>
        <?php $Page->expSubcategory->CellAttrs->removeClass("ew-rpt-grp-caret"); ?>
<?php } ?>
        <td data-field="expSubcategory" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->expSubcategory->cellAttributes() ?>>
            <span class="ew-summary-caption EmpMonthlyExpense_expSubcategory"><?= $Page->renderFieldHeader($Page->expSubcategory) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->expSubcategory->viewAttributes() ?>><?= $Page->expSubcategory->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->expSubcategory->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->submittedBy->getDistinctValues($Page->expSubcategory->Records);
    $Page->setGroupCount(count($Page->submittedBy->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2]);
    $Page->GroupCounter[3] = 0; // Init group count index
    foreach ($Page->submittedBy->DistinctValues as $submittedBy) { // Load records for this distinct value
        $Page->submittedBy->setGroupValue($submittedBy); // Set group value
        $Page->submittedBy->getDistinctRecords($Page->expSubcategory->Records, $Page->submittedBy->groupValue());
        $Page->submittedBy->LevelBreak = true; // Set field level break
        $Page->GroupCounter[3]++;
        $Page->submittedBy->getCnt($Page->submittedBy->Records); // Get record count
?>
<?php if ($Page->submittedBy->Visible && $Page->submittedBy->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->submittedBy->setDbValue($submittedBy); // Set current value for submittedBy
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 3;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expCategory->Visible) { ?>
        <td data-field="expCategory"<?= $Page->expCategory->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { ?>
        <?php $Page->submittedBy->CellAttrs->appendClass("ew-rpt-grp-caret"); ?>
        <td data-field="submittedBy"<?= $Page->submittedBy->cellAttributes(); ?>><i class="ew-group-toggle fas fa-caret-down"></i></td>
        <?php $Page->submittedBy->CellAttrs->removeClass("ew-rpt-grp-caret"); ?>
<?php } ?>
        <td data-field="submittedBy" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 3) ?>"<?= $Page->submittedBy->cellAttributes() ?>>
            <span class="ew-summary-caption EmpMonthlyExpense_submittedBy"><?= $Page->renderFieldHeader($Page->submittedBy) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->submittedBy->viewAttributes() ?>><?= $Page->submittedBy->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->submittedBy->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->dateTrans->getDistinctValues($Page->submittedBy->Records);
    $Page->setGroupCount(count($Page->dateTrans->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3]);
    $Page->GroupCounter[4] = 0; // Init group count index
    foreach ($Page->dateTrans->DistinctValues as $dateTrans) { // Load records for this distinct value
        $Page->dateTrans->setGroupValue($dateTrans); // Set group value
        $Page->dateTrans->getDistinctRecords($Page->submittedBy->Records, $Page->dateTrans->groupValue());
        $Page->dateTrans->LevelBreak = true; // Set field level break
        $Page->GroupCounter[4]++;
        $Page->dateTrans->getCnt($Page->dateTrans->Records); // Get record count
        $Page->setGroupCount($Page->dateTrans->Count, $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3], $Page->GroupCounter[4]);
?>
<?php if ($Page->dateTrans->Visible && $Page->dateTrans->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->dateTrans->setDbValue($dateTrans); // Set current value for dateTrans
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 4;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expCategory->Visible) { ?>
        <td data-field="expCategory"<?= $Page->expCategory->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { ?>
        <td data-field="submittedBy"<?= $Page->submittedBy->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
        <?php $Page->dateTrans->CellAttrs->appendClass("ew-rpt-grp-caret"); ?>
        <td data-field="dateTrans"<?= $Page->dateTrans->cellAttributes(); ?>><i class="ew-group-toggle fas fa-caret-down"></i></td>
        <?php $Page->dateTrans->CellAttrs->removeClass("ew-rpt-grp-caret"); ?>
<?php } ?>
        <td data-field="dateTrans" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 4) ?>"<?= $Page->dateTrans->cellAttributes() ?>>
            <span class="ew-summary-caption EmpMonthlyExpense_dateTrans"><?= $Page->renderFieldHeader($Page->dateTrans) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->dateTrans->viewAttributes() ?>><?= $Page->dateTrans->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->dateTrans->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->dateTrans->Records as $record) {
            $Page->RecordCount++;
            $Page->RecordIndex++;
            $Page->loadRowValues($record);
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expCategory->Visible) { ?>
    <?php if ($Page->expCategory->ShowGroupHeaderAsRow) { ?>
        <td data-field="expCategory"<?= $Page->expCategory->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="expCategory"<?= $Page->expCategory->cellAttributes() ?>><span<?= $Page->expCategory->viewAttributes() ?>><?= $Page->expCategory->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { ?>
    <?php if ($Page->expSubcategory->ShowGroupHeaderAsRow) { ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes() ?>><span<?= $Page->expSubcategory->viewAttributes() ?>><?= $Page->expSubcategory->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { ?>
    <?php if ($Page->submittedBy->ShowGroupHeaderAsRow) { ?>
        <td data-field="submittedBy"<?= $Page->submittedBy->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="submittedBy"<?= $Page->submittedBy->cellAttributes() ?>><span<?= $Page->submittedBy->viewAttributes() ?>><?= $Page->submittedBy->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
    <?php if ($Page->dateTrans->ShowGroupHeaderAsRow) { ?>
        <td data-field="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>><span<?= $Page->dateTrans->viewAttributes() ?>><?= $Page->dateTrans->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>>
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>>
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>>
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { ?>
        <td data-field="dateClosed"<?= $Page->dateClosed->cellAttributes() ?>>
<span<?= $Page->dateClosed->viewAttributes() ?>>
<?= $Page->dateClosed->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { ?>
        <td data-field="validatedBy"<?= $Page->validatedBy->cellAttributes() ?>>
<span<?= $Page->validatedBy->viewAttributes() ?>>
<?= $Page->validatedBy->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cash_float->Visible) { ?>
        <td data-field="cash_float"<?= $Page->cash_float->cellAttributes() ?>>
<span<?= $Page->cash_float->viewAttributes() ?>>
<?= $Page->cash_float->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
    }
    } // End group level 3
    } // End group level 2
    } // End group level 1
?>
<?php

    // Next group
    $Page->loadGroupRowValues();

    // Show header if page break
    if ($Page->isExport()) {
        $Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? false : ($Page->GroupCount % $Page->ExportPageBreakCount == 0);
    }

    // Page_Breaking server event
    if ($Page->ShowHeader) {
        $Page->pageBreaking($Page->ShowHeader, $Page->PageBreakContent);
    }
    $Page->GroupCount++;
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
<?php
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_TOTAL;
    $Page->RowTotalType = ROWTOTAL_GRAND;
    $Page->RowTotalSubType = ROWTOTAL_FOOTER;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
<?php if ($Page->expCategory->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"></td>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?= $Page->amount->viewAttributes() ?>><?= $Page->amount->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { ?>
        <td data-field="dateClosed"<?= $Page->dateClosed->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { ?>
        <td data-field="validatedBy"<?= $Page->validatedBy->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cash_float->Visible) { ?>
        <td data-field="cash_float"<?= $Page->cash_float->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?= $Page->cash_float->viewAttributes() ?>><?= $Page->cash_float->SumViewValue ?></span></span></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"><?= $Language->phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>>
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { ?>
        <td data-field="dateClosed"<?= $Page->dateClosed->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { ?>
        <td data-field="validatedBy"<?= $Page->validatedBy->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cash_float->Visible) { ?>
        <td data-field="cash_float"<?= $Page->cash_float->cellAttributes() ?>>
<span<?= $Page->cash_float->viewAttributes() ?>>
<?= $Page->cash_float->SumViewValue ?></span>
</td>
<?php } ?>
    </tr>
<?php } ?>
</tfoot>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
</div>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
</div>
<!-- /#report-summary -->
<!-- Summary report (end) -->
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /#ew-center -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Bottom Container -->
<div class="row">
    <div id="ew-bottom" class="<?= $Page->BottomContentClass ?>">
<?php } ?>
<?php
if (!$DashboardReport) {
    // Set up page break
    if (($Page->isExport("print") || $Page->isExport("pdf") || $Page->isExport("email") || $Page->isExport("excel") && Config("USE_PHPEXCEL") || $Page->isExport("word") && Config("USE_PHPWORD")) && $Page->ExportChartPageBreak) {
        // Page_Breaking server event
        $Page->pageBreaking($Page->ExportChartPageBreak, $Page->PageBreakContent);

        // Set up chart page break
        $Page->EmployeeExpenseByCategory->PageBreakType = "before"; // Page break type
        $Page->EmployeeExpenseByCategory->PageBreak = $Page->ExportChartPageBreak;
        $Page->EmployeeExpenseByCategory->PageBreakContent = $Page->PageBreakContent;
    }

    // Set up chart drilldown
    $Page->EmployeeExpenseByCategory->DrillDownInPanel = $Page->DrillDownInPanel;
    $Page->EmployeeExpenseByCategory->render("ew-chart-bottom");
}
?>
<?php if (!$DashboardReport && !$Page->isExport("email") && !$Page->DrillDown && $Page->EmployeeExpenseByCategory->hasData()) { ?>
<?php if (!$Page->isExport()) { ?>
<div class="mb-3"><a class="ew-top-link" data-ew-action="scroll-top"><?= $Language->phrase("Top") ?></a></div>
<?php } ?>
<?php } ?>
<?php
if (!$DashboardReport) {
    // Set up page break
    if (($Page->isExport("print") || $Page->isExport("pdf") || $Page->isExport("email") || $Page->isExport("excel") && Config("USE_PHPEXCEL") || $Page->isExport("word") && Config("USE_PHPWORD")) && $Page->ExportChartPageBreak) {
        // Page_Breaking server event
        $Page->pageBreaking($Page->ExportChartPageBreak, $Page->PageBreakContent);

        // Set up chart page break
        $Page->EmployeeExpenseBySubcategory->PageBreakType = "before"; // Page break type
        $Page->EmployeeExpenseBySubcategory->PageBreak = $Page->ExportChartPageBreak;
        $Page->EmployeeExpenseBySubcategory->PageBreakContent = $Page->PageBreakContent;
    }

    // Set up chart drilldown
    $Page->EmployeeExpenseBySubcategory->DrillDownInPanel = $Page->DrillDownInPanel;
    $Page->EmployeeExpenseBySubcategory->render("ew-chart-bottom");
}
?>
<?php if (!$DashboardReport && !$Page->isExport("email") && !$Page->DrillDown && $Page->EmployeeExpenseBySubcategory->hasData()) { ?>
<?php if (!$Page->isExport()) { ?>
<div class="mb-3"><a class="ew-top-link" data-ew-action="scroll-top"><?= $Language->phrase("Top") ?></a></div>
<?php } ?>
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
    </div>
</div>
<!-- /#ew-bottom -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.ew-report -->
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
