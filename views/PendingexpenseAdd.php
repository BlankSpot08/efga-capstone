<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$PendingexpenseAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pendingexpense: currentTable } });
var currentForm, currentPageID;
var fpendingexpenseadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpendingexpenseadd = new ew.Form("fpendingexpenseadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fpendingexpenseadd;

    // Add fields
    var fields = currentTable.fields;
    fpendingexpenseadd.addFields([
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["dateClosed", [fields.dateClosed.visible && fields.dateClosed.required ? ew.Validators.required(fields.dateClosed.caption) : null, ew.Validators.datetime(fields.dateClosed.clientFormatPattern)], fields.dateClosed.isInvalid],
        ["float_status", [fields.float_status.visible && fields.float_status.required ? ew.Validators.required(fields.float_status.caption) : null], fields.float_status.isInvalid]
    ]);

    // Form_CustomValidate
    fpendingexpenseadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpendingexpenseadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fpendingexpenseadd.lists.status = <?= $Page->status->toClientList($Page) ?>;
    fpendingexpenseadd.lists.float_status = <?= $Page->float_status->toClientList($Page) ?>;
    loadjs.done("fpendingexpenseadd");
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
<form name="fpendingexpenseadd" id="fpendingexpenseadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendingexpense">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_pendingexpense_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_pendingexpense_status">
<template id="tp_x_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="pendingexpense" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_status"
    name="x_status"
    value="<?= HtmlEncode($Page->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status"
    data-bs-target="dsl_x_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status->isInvalidClass() ?>"
    data-table="pendingexpense"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>></selection-list>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
    <div id="r_dateClosed"<?= $Page->dateClosed->rowAttributes() ?>>
        <label id="elh_pendingexpense_dateClosed" for="x_dateClosed" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateClosed->caption() ?><?= $Page->dateClosed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateClosed->cellAttributes() ?>>
<span id="el_pendingexpense_dateClosed">
<input type="<?= $Page->dateClosed->getInputTextType() ?>" name="x_dateClosed" id="x_dateClosed" data-table="pendingexpense" data-field="x_dateClosed" value="<?= $Page->dateClosed->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateClosed->getPlaceHolder()) ?>"<?= $Page->dateClosed->editAttributes() ?> aria-describedby="x_dateClosed_help">
<?= $Page->dateClosed->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateClosed->getErrorMessage() ?></div>
<?php if (!$Page->dateClosed->ReadOnly && !$Page->dateClosed->Disabled && !isset($Page->dateClosed->EditAttrs["readonly"]) && !isset($Page->dateClosed->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendingexpenseadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpendingexpenseadd", "x_dateClosed", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->float_status->Visible) { // float_status ?>
    <div id="r_float_status"<?= $Page->float_status->rowAttributes() ?>>
        <label id="elh_pendingexpense_float_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->float_status->caption() ?><?= $Page->float_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->float_status->cellAttributes() ?>>
<span id="el_pendingexpense_float_status">
<template id="tp_x_float_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="pendingexpense" data-field="x_float_status" name="x_float_status" id="x_float_status"<?= $Page->float_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_float_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_float_status"
    name="x_float_status"
    value="<?= HtmlEncode($Page->float_status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_float_status"
    data-bs-target="dsl_x_float_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->float_status->isInvalidClass() ?>"
    data-table="pendingexpense"
    data-field="x_float_status"
    data-value-separator="<?= $Page->float_status->displayValueSeparatorAttribute() ?>"
    <?= $Page->float_status->editAttributes() ?>></selection-list>
<?= $Page->float_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->float_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("pendingexpense");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
