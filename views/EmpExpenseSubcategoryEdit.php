<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmpExpenseSubcategoryEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { emp_expense_subcategory: currentTable } });
var currentForm, currentPageID;
var femp_expense_subcategoryedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femp_expense_subcategoryedit = new ew.Form("femp_expense_subcategoryedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = femp_expense_subcategoryedit;

    // Add fields
    var fields = currentTable.fields;
    femp_expense_subcategoryedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["expCategory", [fields.expCategory.visible && fields.expCategory.required ? ew.Validators.required(fields.expCategory.caption) : null], fields.expCategory.isInvalid],
        ["expSubcategory", [fields.expSubcategory.visible && fields.expSubcategory.required ? ew.Validators.required(fields.expSubcategory.caption) : null], fields.expSubcategory.isInvalid]
    ]);

    // Form_CustomValidate
    femp_expense_subcategoryedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femp_expense_subcategoryedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    femp_expense_subcategoryedit.lists.expCategory = <?= $Page->expCategory->toClientList($Page) ?>;
    loadjs.done("femp_expense_subcategoryedit");
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
<form name="femp_expense_subcategoryedit" id="femp_expense_subcategoryedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="emp_expense_subcategory">
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
        <label id="elh_emp_expense_subcategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_subcategory_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense_subcategory" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_emp_expense_subcategory_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense_subcategory" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
    <div id="r_expCategory"<?= $Page->expCategory->rowAttributes() ?>>
        <label id="elh_emp_expense_subcategory_expCategory" for="x_expCategory" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expCategory->caption() ?><?= $Page->expCategory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expCategory->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_subcategory_expCategory">
    <select
        id="x_expCategory"
        name="x_expCategory"
        class="form-select ew-select<?= $Page->expCategory->isInvalidClass() ?>"
        data-select2-id="femp_expense_subcategoryedit_x_expCategory"
        data-table="emp_expense_subcategory"
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
loadjs.ready("femp_expense_subcategoryedit", function() {
    var options = { name: "x_expCategory", selectId: "femp_expense_subcategoryedit_x_expCategory" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (femp_expense_subcategoryedit.lists.expCategory.lookupOptions.length) {
        options.data = { id: "x_expCategory", form: "femp_expense_subcategoryedit" };
    } else {
        options.ajax = { id: "x_expCategory", form: "femp_expense_subcategoryedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.emp_expense_subcategory.fields.expCategory.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_emp_expense_subcategory_expCategory">
<span<?= $Page->expCategory->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expCategory->getDisplayValue($Page->expCategory->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="emp_expense_subcategory" data-field="x_expCategory" data-hidden="1" name="x_expCategory" id="x_expCategory" value="<?= HtmlEncode($Page->expCategory->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
    <div id="r_expSubcategory"<?= $Page->expSubcategory->rowAttributes() ?>>
        <label id="elh_emp_expense_subcategory_expSubcategory" for="x_expSubcategory" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expSubcategory->caption() ?><?= $Page->expSubcategory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expSubcategory->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_emp_expense_subcategory_expSubcategory">
<input type="<?= $Page->expSubcategory->getInputTextType() ?>" name="x_expSubcategory" id="x_expSubcategory" data-table="emp_expense_subcategory" data-field="x_expSubcategory" value="<?= $Page->expSubcategory->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->expSubcategory->getPlaceHolder()) ?>"<?= $Page->expSubcategory->editAttributes() ?> aria-describedby="x_expSubcategory_help">
<?= $Page->expSubcategory->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->expSubcategory->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_emp_expense_subcategory_expSubcategory">
<span<?= $Page->expSubcategory->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->expSubcategory->getDisplayValue($Page->expSubcategory->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="emp_expense_subcategory" data-field="x_expSubcategory" data-hidden="1" name="x_expSubcategory" id="x_expSubcategory" value="<?= HtmlEncode($Page->expSubcategory->FormValue) ?>">
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
    ew.addEventHandlers("emp_expense_subcategory");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
