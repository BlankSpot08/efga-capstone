<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$CashAdvanceRequestList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cash_advance_request: currentTable } });
var currentForm, currentPageID;
var fcash_advance_requestlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fcash_advance_requestlist = new ew.Form("fcash_advance_requestlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fcash_advance_requestlist;
    fcash_advance_requestlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fcash_advance_requestlist");
});
var fcash_advance_requestsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fcash_advance_requestsrch = new ew.Form("fcash_advance_requestsrch", "list");
    currentSearchForm = fcash_advance_requestsrch;

    // Dynamic selection lists

    // Filters
    fcash_advance_requestsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fcash_advance_requestsrch");
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
<form name="fcash_advance_requestsrch" id="fcash_advance_requestsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fcash_advance_requestsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cash_advance_request">
<div class="ew-extended-search container-fluid">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fcash_advance_requestsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fcash_advance_requestsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fcash_advance_requestsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fcash_advance_requestsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> cash_advance_request">
<form name="fcash_advance_requestlist" id="fcash_advance_requestlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cash_advance_request">
<div id="gmp_cash_advance_request" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_cash_advance_requestlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_cash_advance_request_id" class="cash_advance_request_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
        <th data-name="expCategory_id" class="<?= $Page->expCategory_id->headerCellClass() ?>"><div id="elh_cash_advance_request_expCategory_id" class="cash_advance_request_expCategory_id"><?= $Page->renderFieldHeader($Page->expCategory_id) ?></div></th>
<?php } ?>
<?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
        <th data-name="expSubcategory_id" class="<?= $Page->expSubcategory_id->headerCellClass() ?>"><div id="elh_cash_advance_request_expSubcategory_id" class="cash_advance_request_expSubcategory_id"><?= $Page->renderFieldHeader($Page->expSubcategory_id) ?></div></th>
<?php } ?>
<?php if ($Page->budget_id->Visible) { // budget_id ?>
        <th data-name="budget_id" class="<?= $Page->budget_id->headerCellClass() ?>"><div id="elh_cash_advance_request_budget_id" class="cash_advance_request_budget_id"><?= $Page->renderFieldHeader($Page->budget_id) ?></div></th>
<?php } ?>
<?php if ($Page->dateReceived->Visible) { // dateReceived ?>
        <th data-name="dateReceived" class="<?= $Page->dateReceived->headerCellClass() ?>"><div id="elh_cash_advance_request_dateReceived" class="cash_advance_request_dateReceived"><?= $Page->renderFieldHeader($Page->dateReceived) ?></div></th>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
        <th data-name="submittedBy" class="<?= $Page->submittedBy->headerCellClass() ?>"><div id="elh_cash_advance_request_submittedBy" class="cash_advance_request_submittedBy"><?= $Page->renderFieldHeader($Page->submittedBy) ?></div></th>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
        <th data-name="note" class="<?= $Page->note->headerCellClass() ?>"><div id="elh_cash_advance_request_note" class="cash_advance_request_note"><?= $Page->renderFieldHeader($Page->note) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_cash_advance_request_status" class="cash_advance_request_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
        <th data-name="validatedBy" class="<?= $Page->validatedBy->headerCellClass() ?>"><div id="elh_cash_advance_request_validatedBy" class="cash_advance_request_validatedBy"><?= $Page->renderFieldHeader($Page->validatedBy) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_cash_advance_request",
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
<span id="el<?= $Page->RowCount ?>_cash_advance_request_id" class="el_cash_advance_request_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
        <td data-name="expCategory_id"<?= $Page->expCategory_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_expCategory_id" class="el_cash_advance_request_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<?= $Page->expCategory_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
        <td data-name="expSubcategory_id"<?= $Page->expSubcategory_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_expSubcategory_id" class="el_cash_advance_request_expSubcategory_id">
<span<?= $Page->expSubcategory_id->viewAttributes() ?>>
<?= $Page->expSubcategory_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->budget_id->Visible) { // budget_id ?>
        <td data-name="budget_id"<?= $Page->budget_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_budget_id" class="el_cash_advance_request_budget_id">
<span<?= $Page->budget_id->viewAttributes() ?>>
<?= $Page->budget_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dateReceived->Visible) { // dateReceived ?>
        <td data-name="dateReceived"<?= $Page->dateReceived->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_dateReceived" class="el_cash_advance_request_dateReceived">
<span<?= $Page->dateReceived->viewAttributes() ?>>
<?= $Page->dateReceived->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->submittedBy->Visible) { // submittedBy ?>
        <td data-name="submittedBy"<?= $Page->submittedBy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_submittedBy" class="el_cash_advance_request_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<?= $Page->submittedBy->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->note->Visible) { // note ?>
        <td data-name="note"<?= $Page->note->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_note" class="el_cash_advance_request_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_status" class="el_cash_advance_request_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->validatedBy->Visible) { // validatedBy ?>
        <td data-name="validatedBy"<?= $Page->validatedBy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_request_validatedBy" class="el_cash_advance_request_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<?= $Page->validatedBy->getViewValue() ?></span>
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
    ew.addEventHandlers("cash_advance_request");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
