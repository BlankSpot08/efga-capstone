<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$BudgetEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { budget: currentTable } });
var currentForm, currentPageID;
var fbudgetedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbudgetedit = new ew.Form("fbudgetedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fbudgetedit;

    // Add fields
    var fields = currentTable.fields;
    fbudgetedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["expCategory", [fields.expCategory.visible && fields.expCategory.required ? ew.Validators.required(fields.expCategory.caption) : null], fields.expCategory.isInvalid],
        ["expSubcategory", [fields.expSubcategory.visible && fields.expSubcategory.required ? ew.Validators.required(fields.expSubcategory.caption) : null], fields.expSubcategory.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null, ew.Validators.integer], fields.amount.isInvalid]
    ]);

    // Form_CustomValidate
    fbudgetedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbudgetedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbudgetedit.lists.expCategory = <?= $Page->expCategory->toClientList($Page) ?>;
    fbudgetedit.lists.expSubcategory = <?= $Page->expSubcategory->toClientList($Page) ?>;
    loadjs.done("fbudgetedit");
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
<form name="fbudgetedit" id="fbudgetedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="budget">
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
        <label id="elh_budget_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_budget_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="budget" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_budget_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="budget" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
    <div id="r_expCategory"<?= $Page->expCategory->rowAttributes() ?>>
        <label id="elh_budget_expCategory" for="x_expCategory" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expCategory->caption() ?><?= $Page->expCategory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expCategory->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_budget_expCategory">
<?php $Page->expCategory->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_expCategory"
        name="x_expCategory"
        class="form-select ew-select<?= $Page->expCategory->isInvalidClass() ?>"
        data-select2-id="fbudgetedit_x_expCategory"
        data-table="budget"
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
loadjs.ready("fbudgetedit", function() {
    var options = { name: "x_expCategory", selectId: "fbudgetedit_x_expCategory" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbudgetedit.lists.expCategory.lookupOptions.length) {
        options.data = { id: "x_expCategory", form: "fbudgetedit" };
    } else {
        options.ajax = { id: "x_expCategory", form: "fbudgetedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.budget.fields.expCategory.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_budget_expCategory">
<span<?= $Page->expCategory->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expCategory->getDisplayValue($Page->expCategory->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="budget" data-field="x_expCategory" data-hidden="1" name="x_expCategory" id="x_expCategory" value="<?= HtmlEncode($Page->expCategory->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
    <div id="r_expSubcategory"<?= $Page->expSubcategory->rowAttributes() ?>>
        <label id="elh_budget_expSubcategory" for="x_expSubcategory" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expSubcategory->caption() ?><?= $Page->expSubcategory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expSubcategory->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_budget_expSubcategory">
    <select
        id="x_expSubcategory"
        name="x_expSubcategory"
        class="form-select ew-select<?= $Page->expSubcategory->isInvalidClass() ?>"
        data-select2-id="fbudgetedit_x_expSubcategory"
        data-table="budget"
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
loadjs.ready("fbudgetedit", function() {
    var options = { name: "x_expSubcategory", selectId: "fbudgetedit_x_expSubcategory" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbudgetedit.lists.expSubcategory.lookupOptions.length) {
        options.data = { id: "x_expSubcategory", form: "fbudgetedit" };
    } else {
        options.ajax = { id: "x_expSubcategory", form: "fbudgetedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.budget.fields.expSubcategory.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_budget_expSubcategory">
<span<?= $Page->expSubcategory->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expSubcategory->getDisplayValue($Page->expSubcategory->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="budget" data-field="x_expSubcategory" data-hidden="1" name="x_expSubcategory" id="x_expSubcategory" value="<?= HtmlEncode($Page->expSubcategory->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <label id="elh_budget_amount" for="x_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount->caption() ?><?= $Page->amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amount->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_budget_amount">
<input type="<?= $Page->amount->getInputTextType() ?>" name="x_amount" id="x_amount" data-table="budget" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>"<?= $Page->amount->editAttributes() ?> aria-describedby="x_amount_help">
<?= $Page->amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_budget_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->amount->getDisplayValue($Page->amount->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="budget" data-field="x_amount" data-hidden="1" name="x_amount" id="x_amount" value="<?= HtmlEncode($Page->amount->FormValue) ?>">
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
    ew.addEventHandlers("budget");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
