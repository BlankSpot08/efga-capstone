<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmployeeList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { employee: currentTable } });
var currentForm, currentPageID;
var femployeelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femployeelist = new ew.Form("femployeelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = femployeelist;
    femployeelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("femployeelist");
});
var femployeesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    femployeesrch = new ew.Form("femployeesrch", "list");
    currentSearchForm = femployeesrch;

    // Dynamic selection lists

    // Filters
    femployeesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("femployeesrch");
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
<form name="femployeesrch" id="femployeesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="femployeesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="employee">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="femployeesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="femployeesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="femployeesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="femployeesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> employee">
<form name="femployeelist" id="femployeelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employee">
<div id="gmp_employee" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_employeelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_employee_id" class="employee_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->employee_id->Visible) { // employee_id ?>
        <th data-name="employee_id" class="<?= $Page->employee_id->headerCellClass() ?>"><div id="elh_employee_employee_id" class="employee_employee_id"><?= $Page->renderFieldHeader($Page->employee_id) ?></div></th>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
        <th data-name="lastname" class="<?= $Page->lastname->headerCellClass() ?>"><div id="elh_employee_lastname" class="employee_lastname"><?= $Page->renderFieldHeader($Page->lastname) ?></div></th>
<?php } ?>
<?php if ($Page->firstname->Visible) { // firstname ?>
        <th data-name="firstname" class="<?= $Page->firstname->headerCellClass() ?>"><div id="elh_employee_firstname" class="employee_firstname"><?= $Page->renderFieldHeader($Page->firstname) ?></div></th>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
        <th data-name="middlename" class="<?= $Page->middlename->headerCellClass() ?>"><div id="elh_employee_middlename" class="employee_middlename"><?= $Page->renderFieldHeader($Page->middlename) ?></div></th>
<?php } ?>
<?php if ($Page->dateOfBirth->Visible) { // dateOfBirth ?>
        <th data-name="dateOfBirth" class="<?= $Page->dateOfBirth->headerCellClass() ?>"><div id="elh_employee_dateOfBirth" class="employee_dateOfBirth"><?= $Page->renderFieldHeader($Page->dateOfBirth) ?></div></th>
<?php } ?>
<?php if ($Page->picture->Visible) { // picture ?>
        <th data-name="picture" class="<?= $Page->picture->headerCellClass() ?>"><div id="elh_employee_picture" class="employee_picture"><?= $Page->renderFieldHeader($Page->picture) ?></div></th>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
        <th data-name="address" class="<?= $Page->address->headerCellClass() ?>"><div id="elh_employee_address" class="employee_address"><?= $Page->renderFieldHeader($Page->address) ?></div></th>
<?php } ?>
<?php if ($Page->contactNo->Visible) { // contactNo ?>
        <th data-name="contactNo" class="<?= $Page->contactNo->headerCellClass() ?>"><div id="elh_employee_contactNo" class="employee_contactNo"><?= $Page->renderFieldHeader($Page->contactNo) ?></div></th>
<?php } ?>
<?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
        <th data-name="officeDepartment" class="<?= $Page->officeDepartment->headerCellClass() ?>"><div id="elh_employee_officeDepartment" class="employee_officeDepartment"><?= $Page->renderFieldHeader($Page->officeDepartment) ?></div></th>
<?php } ?>
<?php if ($Page->empPosition->Visible) { // empPosition ?>
        <th data-name="empPosition" class="<?= $Page->empPosition->headerCellClass() ?>"><div id="elh_employee_empPosition" class="employee_empPosition"><?= $Page->renderFieldHeader($Page->empPosition) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_employee",
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
<span id="el<?= $Page->RowCount ?>_employee_id" class="el_employee_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->employee_id->Visible) { // employee_id ?>
        <td data-name="employee_id"<?= $Page->employee_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_employee_id" class="el_employee_employee_id">
<span<?= $Page->employee_id->viewAttributes() ?>>
<?= $Page->employee_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lastname->Visible) { // lastname ?>
        <td data-name="lastname"<?= $Page->lastname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_lastname" class="el_employee_lastname">
<span<?= $Page->lastname->viewAttributes() ?>>
<?= $Page->lastname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->firstname->Visible) { // firstname ?>
        <td data-name="firstname"<?= $Page->firstname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_firstname" class="el_employee_firstname">
<span<?= $Page->firstname->viewAttributes() ?>>
<?= $Page->firstname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->middlename->Visible) { // middlename ?>
        <td data-name="middlename"<?= $Page->middlename->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_middlename" class="el_employee_middlename">
<span<?= $Page->middlename->viewAttributes() ?>>
<?= $Page->middlename->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dateOfBirth->Visible) { // dateOfBirth ?>
        <td data-name="dateOfBirth"<?= $Page->dateOfBirth->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_dateOfBirth" class="el_employee_dateOfBirth">
<span<?= $Page->dateOfBirth->viewAttributes() ?>>
<?= $Page->dateOfBirth->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->picture->Visible) { // picture ?>
        <td data-name="picture"<?= $Page->picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_picture" class="el_employee_picture">
<span>
<?= GetFileViewTag($Page->picture, $Page->picture->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->address->Visible) { // address ?>
        <td data-name="address"<?= $Page->address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_address" class="el_employee_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contactNo->Visible) { // contactNo ?>
        <td data-name="contactNo"<?= $Page->contactNo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_contactNo" class="el_employee_contactNo">
<span<?= $Page->contactNo->viewAttributes() ?>>
<?= $Page->contactNo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
        <td data-name="officeDepartment"<?= $Page->officeDepartment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_officeDepartment" class="el_employee_officeDepartment">
<span<?= $Page->officeDepartment->viewAttributes() ?>>
<?= $Page->officeDepartment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->empPosition->Visible) { // empPosition ?>
        <td data-name="empPosition"<?= $Page->empPosition->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employee_empPosition" class="el_employee_empPosition">
<span<?= $Page->empPosition->viewAttributes() ?>>
<?= $Page->empPosition->getViewValue() ?></span>
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
    ew.addEventHandlers("employee");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
