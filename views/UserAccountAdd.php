<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$UserAccountAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { user_account: currentTable } });
var currentForm, currentPageID;
var fuser_accountadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuser_accountadd = new ew.Form("fuser_accountadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fuser_accountadd;

    // Add fields
    var fields = currentTable.fields;
    fuser_accountadd.addFields([
        ["employee_id", [fields.employee_id.visible && fields.employee_id.required ? ew.Validators.required(fields.employee_id.caption) : null, ew.Validators.integer], fields.employee_id.isInvalid],
        ["lastname", [fields.lastname.visible && fields.lastname.required ? ew.Validators.required(fields.lastname.caption) : null], fields.lastname.isInvalid],
        ["firstname", [fields.firstname.visible && fields.firstname.required ? ew.Validators.required(fields.firstname.caption) : null], fields.firstname.isInvalid],
        ["middlename", [fields.middlename.visible && fields.middlename.required ? ew.Validators.required(fields.middlename.caption) : null], fields.middlename.isInvalid],
        ["photo", [fields.photo.visible && fields.photo.required ? ew.Validators.fileRequired(fields.photo.caption) : null], fields.photo.isInvalid],
        ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
        ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
        ["_userlevel", [fields._userlevel.visible && fields._userlevel.required ? ew.Validators.required(fields._userlevel.caption) : null], fields._userlevel.isInvalid]
    ]);

    // Form_CustomValidate
    fuser_accountadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuser_accountadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fuser_accountadd.lists._userlevel = <?= $Page->_userlevel->toClientList($Page) ?>;
    loadjs.done("fuser_accountadd");
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
<form name="fuser_accountadd" id="fuser_accountadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_account">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->employee_id->Visible) { // employee_id ?>
    <div id="r_employee_id"<?= $Page->employee_id->rowAttributes() ?>>
        <label id="elh_user_account_employee_id" for="x_employee_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->employee_id->caption() ?><?= $Page->employee_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->employee_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user_account_employee_id">
<input type="<?= $Page->employee_id->getInputTextType() ?>" name="x_employee_id" id="x_employee_id" data-table="user_account" data-field="x_employee_id" value="<?= $Page->employee_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->employee_id->getPlaceHolder()) ?>"<?= $Page->employee_id->editAttributes() ?> aria-describedby="x_employee_id_help">
<?= $Page->employee_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->employee_id->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user_account_employee_id">
<span<?= $Page->employee_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->employee_id->getDisplayValue($Page->employee_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user_account" data-field="x_employee_id" data-hidden="1" name="x_employee_id" id="x_employee_id" value="<?= HtmlEncode($Page->employee_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
    <div id="r_lastname"<?= $Page->lastname->rowAttributes() ?>>
        <label id="elh_user_account_lastname" for="x_lastname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lastname->caption() ?><?= $Page->lastname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lastname->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user_account_lastname">
<input type="<?= $Page->lastname->getInputTextType() ?>" name="x_lastname" id="x_lastname" data-table="user_account" data-field="x_lastname" value="<?= $Page->lastname->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->lastname->getPlaceHolder()) ?>"<?= $Page->lastname->editAttributes() ?> aria-describedby="x_lastname_help">
<?= $Page->lastname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lastname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user_account_lastname">
<span<?= $Page->lastname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->lastname->getDisplayValue($Page->lastname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user_account" data-field="x_lastname" data-hidden="1" name="x_lastname" id="x_lastname" value="<?= HtmlEncode($Page->lastname->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->firstname->Visible) { // firstname ?>
    <div id="r_firstname"<?= $Page->firstname->rowAttributes() ?>>
        <label id="elh_user_account_firstname" for="x_firstname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->firstname->caption() ?><?= $Page->firstname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->firstname->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user_account_firstname">
<input type="<?= $Page->firstname->getInputTextType() ?>" name="x_firstname" id="x_firstname" data-table="user_account" data-field="x_firstname" value="<?= $Page->firstname->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->firstname->getPlaceHolder()) ?>"<?= $Page->firstname->editAttributes() ?> aria-describedby="x_firstname_help">
<?= $Page->firstname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->firstname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user_account_firstname">
<span<?= $Page->firstname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->firstname->getDisplayValue($Page->firstname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user_account" data-field="x_firstname" data-hidden="1" name="x_firstname" id="x_firstname" value="<?= HtmlEncode($Page->firstname->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
    <div id="r_middlename"<?= $Page->middlename->rowAttributes() ?>>
        <label id="elh_user_account_middlename" for="x_middlename" class="<?= $Page->LeftColumnClass ?>"><?= $Page->middlename->caption() ?><?= $Page->middlename->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->middlename->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user_account_middlename">
<input type="<?= $Page->middlename->getInputTextType() ?>" name="x_middlename" id="x_middlename" data-table="user_account" data-field="x_middlename" value="<?= $Page->middlename->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->middlename->getPlaceHolder()) ?>"<?= $Page->middlename->editAttributes() ?> aria-describedby="x_middlename_help">
<?= $Page->middlename->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->middlename->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user_account_middlename">
<span<?= $Page->middlename->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->middlename->getDisplayValue($Page->middlename->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user_account" data-field="x_middlename" data-hidden="1" name="x_middlename" id="x_middlename" value="<?= HtmlEncode($Page->middlename->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
    <div id="r_photo"<?= $Page->photo->rowAttributes() ?>>
        <label id="elh_user_account_photo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->photo->caption() ?><?= $Page->photo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->photo->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user_account_photo">
<div id="fd_x_photo" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->photo->title() ?>" data-table="user_account" data-field="x_photo" name="x_photo" id="x_photo" lang="<?= CurrentLanguageID() ?>"<?= $Page->photo->editAttributes() ?> aria-describedby="x_photo_help"<?= ($Page->photo->ReadOnly || $Page->photo->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->photo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_photo" id= "fn_x_photo" value="<?= $Page->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x_photo" id= "fa_x_photo" value="0">
<input type="hidden" name="fs_x_photo" id= "fs_x_photo" value="0">
<input type="hidden" name="fx_x_photo" id= "fx_x_photo" value="<?= $Page->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_photo" id= "fm_x_photo" value="<?= $Page->photo->UploadMaxFileSize ?>">
<table id="ft_x_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el_user_account_photo">
<div id="fd_x_photo">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Page->photo->title() ?>" data-table="user_account" data-field="x_photo" name="x_photo" id="x_photo" lang="<?= CurrentLanguageID() ?>"<?= $Page->photo->editAttributes() ?> aria-describedby="x_photo_help">
</div>
<?= $Page->photo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_photo" id= "fn_x_photo" value="<?= $Page->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x_photo" id= "fa_x_photo" value="0">
<input type="hidden" name="fs_x_photo" id= "fs_x_photo" value="0">
<input type="hidden" name="fx_x_photo" id= "fx_x_photo" value="<?= $Page->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_photo" id= "fm_x_photo" value="<?= $Page->photo->UploadMaxFileSize ?>">
<table id="ft_x_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <div id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <label id="elh_user_account__username" for="x__username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_username->caption() ?><?= $Page->_username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_username->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("add")) { // Non system admin ?>
<span id="el_user_account__username">
<span<?= $Page->_username->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_username->getDisplayValue($Page->_username->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="user_account" data-field="x__username" data-hidden="1" name="x__username" id="x__username" value="<?= HtmlEncode($Page->_username->CurrentValue) ?>">
<?php } else { ?>
<span id="el_user_account__username">
<input type="<?= $Page->_username->getInputTextType() ?>" name="x__username" id="x__username" data-table="user_account" data-field="x__username" value="<?= $Page->_username->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>"<?= $Page->_username->editAttributes() ?> aria-describedby="x__username_help">
<?= $Page->_username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_user_account__username">
<span<?= $Page->_username->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_username->getDisplayValue($Page->_username->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user_account" data-field="x__username" data-hidden="1" name="x__username" id="x__username" value="<?= HtmlEncode($Page->_username->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <label id="elh_user_account__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user_account__password">
<div class="input-group">
    <input type="password" name="x__password" id="x__password" autocomplete="new-password" data-field="x__password" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fas fa-eye"></i></button>
</div>
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user_account__password">
<span<?= $Page->_password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_password->getDisplayValue($Page->_password->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user_account" data-field="x__password" data-hidden="1" name="x__password" id="x__password" value="<?= HtmlEncode($Page->_password->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_userlevel->Visible) { // userlevel ?>
    <div id="r__userlevel"<?= $Page->_userlevel->rowAttributes() ?>>
        <label id="elh_user_account__userlevel" for="x__userlevel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_userlevel->caption() ?><?= $Page->_userlevel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_userlevel->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_user_account__userlevel">
<span class="form-control-plaintext"><?= $Page->_userlevel->getDisplayValue($Page->_userlevel->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_user_account__userlevel">
    <select
        id="x__userlevel"
        name="x__userlevel"
        class="form-select ew-select<?= $Page->_userlevel->isInvalidClass() ?>"
        data-select2-id="fuser_accountadd_x__userlevel"
        data-table="user_account"
        data-field="x__userlevel"
        data-value-separator="<?= $Page->_userlevel->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_userlevel->getPlaceHolder()) ?>"
        <?= $Page->_userlevel->editAttributes() ?>>
        <?= $Page->_userlevel->selectOptionListHtml("x__userlevel") ?>
    </select>
    <?= $Page->_userlevel->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->_userlevel->getErrorMessage() ?></div>
<?= $Page->_userlevel->Lookup->getParamTag($Page, "p_x__userlevel") ?>
<script>
loadjs.ready("fuser_accountadd", function() {
    var options = { name: "x__userlevel", selectId: "fuser_accountadd_x__userlevel" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuser_accountadd.lists._userlevel.lookupOptions.length) {
        options.data = { id: "x__userlevel", form: "fuser_accountadd" };
    } else {
        options.ajax = { id: "x__userlevel", form: "fuser_accountadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.user_account.fields._userlevel.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_user_account__userlevel">
<span<?= $Page->_userlevel->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->_userlevel->getDisplayValue($Page->_userlevel->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="user_account" data-field="x__userlevel" data-hidden="1" name="x__userlevel" id="x__userlevel" value="<?= HtmlEncode($Page->_userlevel->FormValue) ?>">
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
    ew.addEventHandlers("user_account");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
