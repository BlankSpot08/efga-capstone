<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmployeePositionAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { employee_position: currentTable } });
var currentForm, currentPageID;
var femployee_positionadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femployee_positionadd = new ew.Form("femployee_positionadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = femployee_positionadd;

    // Add fields
    var fields = currentTable.fields;
    femployee_positionadd.addFields([
        ["officeDepartment", [fields.officeDepartment.visible && fields.officeDepartment.required ? ew.Validators.required(fields.officeDepartment.caption) : null], fields.officeDepartment.isInvalid],
        ["position", [fields.position.visible && fields.position.required ? ew.Validators.required(fields.position.caption) : null], fields.position.isInvalid]
    ]);

    // Form_CustomValidate
    femployee_positionadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femployee_positionadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    femployee_positionadd.lists.officeDepartment = <?= $Page->officeDepartment->toClientList($Page) ?>;
    loadjs.done("femployee_positionadd");
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
<form name="femployee_positionadd" id="femployee_positionadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employee_position">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
    <div id="r_officeDepartment"<?= $Page->officeDepartment->rowAttributes() ?>>
        <label id="elh_employee_position_officeDepartment" for="x_officeDepartment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->officeDepartment->caption() ?><?= $Page->officeDepartment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->officeDepartment->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_position_officeDepartment">
    <select
        id="x_officeDepartment"
        name="x_officeDepartment"
        class="form-select ew-select<?= $Page->officeDepartment->isInvalidClass() ?>"
        data-select2-id="femployee_positionadd_x_officeDepartment"
        data-table="employee_position"
        data-field="x_officeDepartment"
        data-value-separator="<?= $Page->officeDepartment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->officeDepartment->getPlaceHolder()) ?>"
        <?= $Page->officeDepartment->editAttributes() ?>>
        <?= $Page->officeDepartment->selectOptionListHtml("x_officeDepartment") ?>
    </select>
    <?= $Page->officeDepartment->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->officeDepartment->getErrorMessage() ?></div>
<?= $Page->officeDepartment->Lookup->getParamTag($Page, "p_x_officeDepartment") ?>
<script>
loadjs.ready("femployee_positionadd", function() {
    var options = { name: "x_officeDepartment", selectId: "femployee_positionadd_x_officeDepartment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (femployee_positionadd.lists.officeDepartment.lookupOptions.length) {
        options.data = { id: "x_officeDepartment", form: "femployee_positionadd" };
    } else {
        options.ajax = { id: "x_officeDepartment", form: "femployee_positionadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.employee_position.fields.officeDepartment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_employee_position_officeDepartment">
<span<?= $Page->officeDepartment->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->officeDepartment->getDisplayValue($Page->officeDepartment->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="employee_position" data-field="x_officeDepartment" data-hidden="1" name="x_officeDepartment" id="x_officeDepartment" value="<?= HtmlEncode($Page->officeDepartment->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->position->Visible) { // position ?>
    <div id="r_position"<?= $Page->position->rowAttributes() ?>>
        <label id="elh_employee_position_position" for="x_position" class="<?= $Page->LeftColumnClass ?>"><?= $Page->position->caption() ?><?= $Page->position->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->position->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_position_position">
<input type="<?= $Page->position->getInputTextType() ?>" name="x_position" id="x_position" data-table="employee_position" data-field="x_position" value="<?= $Page->position->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->position->getPlaceHolder()) ?>"<?= $Page->position->editAttributes() ?> aria-describedby="x_position_help">
<?= $Page->position->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->position->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_employee_position_position">
<span<?= $Page->position->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->position->getDisplayValue($Page->position->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="employee_position" data-field="x_position" data-hidden="1" name="x_position" id="x_position" value="<?= HtmlEncode($Page->position->FormValue) ?>">
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
    ew.addEventHandlers("employee_position");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
