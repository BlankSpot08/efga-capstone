<?php

namespace PHPMaker2022\efga_expense_system;

// Table
$machine = Container("machine");
?>
<?php if ($machine->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_machinemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($machine->id->Visible) { // id ?>
        <tr id="r_id"<?= $machine->id->rowAttributes() ?>>
            <td class="<?= $machine->TableLeftColumnClass ?>"><?= $machine->id->caption() ?></td>
            <td<?= $machine->id->cellAttributes() ?>>
<span id="el_machine_id">
<span<?= $machine->id->viewAttributes() ?>>
<?= $machine->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($machine->machine_category_id->Visible) { // machine_category_id ?>
        <tr id="r_machine_category_id"<?= $machine->machine_category_id->rowAttributes() ?>>
            <td class="<?= $machine->TableLeftColumnClass ?>"><?= $machine->machine_category_id->caption() ?></td>
            <td<?= $machine->machine_category_id->cellAttributes() ?>>
<span id="el_machine_machine_category_id">
<span<?= $machine->machine_category_id->viewAttributes() ?>>
<?= $machine->machine_category_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($machine->brand_id->Visible) { // brand_id ?>
        <tr id="r_brand_id"<?= $machine->brand_id->rowAttributes() ?>>
            <td class="<?= $machine->TableLeftColumnClass ?>"><?= $machine->brand_id->caption() ?></td>
            <td<?= $machine->brand_id->cellAttributes() ?>>
<span id="el_machine_brand_id">
<span<?= $machine->brand_id->viewAttributes() ?>>
<?= $machine->brand_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($machine->model->Visible) { // model ?>
        <tr id="r_model"<?= $machine->model->rowAttributes() ?>>
            <td class="<?= $machine->TableLeftColumnClass ?>"><?= $machine->model->caption() ?></td>
            <td<?= $machine->model->cellAttributes() ?>>
<span id="el_machine_model">
<span<?= $machine->model->viewAttributes() ?>>
<?= $machine->model->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($machine->repairCount->Visible) { // repairCount ?>
        <tr id="r_repairCount"<?= $machine->repairCount->rowAttributes() ?>>
            <td class="<?= $machine->TableLeftColumnClass ?>"><?= $machine->repairCount->caption() ?></td>
            <td<?= $machine->repairCount->cellAttributes() ?>>
<span id="el_machine_repairCount">
<span<?= $machine->repairCount->viewAttributes() ?>>
<?= $machine->repairCount->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($machine->photo->Visible) { // photo ?>
        <tr id="r_photo"<?= $machine->photo->rowAttributes() ?>>
            <td class="<?= $machine->TableLeftColumnClass ?>"><?= $machine->photo->caption() ?></td>
            <td<?= $machine->photo->cellAttributes() ?>>
<span id="el_machine_photo">
<span>
<?= GetFileViewTag($machine->photo, $machine->photo->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
