<?php

namespace PHPMaker2022\efga_expense_system;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // budget
    $app->map(["GET","POST","OPTIONS"], '/BudgetList[/{id}]', BudgetController::class . ':list')->add(PermissionMiddleware::class)->setName('BudgetList-budget-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/BudgetAdd[/{id}]', BudgetController::class . ':add')->add(PermissionMiddleware::class)->setName('BudgetAdd-budget-add'); // add
    $app->map(["GET","OPTIONS"], '/BudgetView[/{id}]', BudgetController::class . ':view')->add(PermissionMiddleware::class)->setName('BudgetView-budget-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/BudgetEdit[/{id}]', BudgetController::class . ':edit')->add(PermissionMiddleware::class)->setName('BudgetEdit-budget-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/BudgetDelete[/{id}]', BudgetController::class . ':delete')->add(PermissionMiddleware::class)->setName('BudgetDelete-budget-delete'); // delete
    $app->group(
        '/budget',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', BudgetController::class . ':list')->add(PermissionMiddleware::class)->setName('budget/list-budget-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', BudgetController::class . ':add')->add(PermissionMiddleware::class)->setName('budget/add-budget-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', BudgetController::class . ':view')->add(PermissionMiddleware::class)->setName('budget/view-budget-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', BudgetController::class . ':edit')->add(PermissionMiddleware::class)->setName('budget/edit-budget-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', BudgetController::class . ':delete')->add(PermissionMiddleware::class)->setName('budget/delete-budget-delete-2'); // delete
        }
    );

    // cash_advance
    $app->map(["GET","POST","OPTIONS"], '/CashAdvanceList[/{id}]', CashAdvanceController::class . ':list')->add(PermissionMiddleware::class)->setName('CashAdvanceList-cash_advance-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/CashAdvanceAdd[/{id}]', CashAdvanceController::class . ':add')->add(PermissionMiddleware::class)->setName('CashAdvanceAdd-cash_advance-add'); // add
    $app->map(["GET","OPTIONS"], '/CashAdvanceView[/{id}]', CashAdvanceController::class . ':view')->add(PermissionMiddleware::class)->setName('CashAdvanceView-cash_advance-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/CashAdvanceEdit[/{id}]', CashAdvanceController::class . ':edit')->add(PermissionMiddleware::class)->setName('CashAdvanceEdit-cash_advance-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/CashAdvanceDelete[/{id}]', CashAdvanceController::class . ':delete')->add(PermissionMiddleware::class)->setName('CashAdvanceDelete-cash_advance-delete'); // delete
    $app->group(
        '/cash_advance',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', CashAdvanceController::class . ':list')->add(PermissionMiddleware::class)->setName('cash_advance/list-cash_advance-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', CashAdvanceController::class . ':add')->add(PermissionMiddleware::class)->setName('cash_advance/add-cash_advance-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', CashAdvanceController::class . ':view')->add(PermissionMiddleware::class)->setName('cash_advance/view-cash_advance-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', CashAdvanceController::class . ':edit')->add(PermissionMiddleware::class)->setName('cash_advance/edit-cash_advance-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', CashAdvanceController::class . ':delete')->add(PermissionMiddleware::class)->setName('cash_advance/delete-cash_advance-delete-2'); // delete
        }
    );

    // emp_expense
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseList[/{id}]', EmpExpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('EmpExpenseList-emp_expense-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseAdd[/{id}]', EmpExpenseController::class . ':add')->add(PermissionMiddleware::class)->setName('EmpExpenseAdd-emp_expense-add'); // add
    $app->map(["GET","OPTIONS"], '/EmpExpenseView[/{id}]', EmpExpenseController::class . ':view')->add(PermissionMiddleware::class)->setName('EmpExpenseView-emp_expense-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseEdit[/{id}]', EmpExpenseController::class . ':edit')->add(PermissionMiddleware::class)->setName('EmpExpenseEdit-emp_expense-edit'); // edit
    $app->group(
        '/emp_expense',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', EmpExpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('emp_expense/list-emp_expense-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', EmpExpenseController::class . ':add')->add(PermissionMiddleware::class)->setName('emp_expense/add-emp_expense-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', EmpExpenseController::class . ':view')->add(PermissionMiddleware::class)->setName('emp_expense/view-emp_expense-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', EmpExpenseController::class . ':edit')->add(PermissionMiddleware::class)->setName('emp_expense/edit-emp_expense-edit-2'); // edit
        }
    );

    // emp_expense_category
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseCategoryList[/{id}]', EmpExpenseCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('EmpExpenseCategoryList-emp_expense_category-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseCategoryAdd[/{id}]', EmpExpenseCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('EmpExpenseCategoryAdd-emp_expense_category-add'); // add
    $app->map(["GET","OPTIONS"], '/EmpExpenseCategoryView[/{id}]', EmpExpenseCategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('EmpExpenseCategoryView-emp_expense_category-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseCategoryEdit[/{id}]', EmpExpenseCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('EmpExpenseCategoryEdit-emp_expense_category-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseCategoryDelete[/{id}]', EmpExpenseCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('EmpExpenseCategoryDelete-emp_expense_category-delete'); // delete
    $app->group(
        '/emp_expense_category',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', EmpExpenseCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('emp_expense_category/list-emp_expense_category-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', EmpExpenseCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('emp_expense_category/add-emp_expense_category-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', EmpExpenseCategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('emp_expense_category/view-emp_expense_category-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', EmpExpenseCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('emp_expense_category/edit-emp_expense_category-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', EmpExpenseCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('emp_expense_category/delete-emp_expense_category-delete-2'); // delete
        }
    );

    // emp_expense_subcategory
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseSubcategoryList[/{id}]', EmpExpenseSubcategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('EmpExpenseSubcategoryList-emp_expense_subcategory-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseSubcategoryAdd[/{id}]', EmpExpenseSubcategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('EmpExpenseSubcategoryAdd-emp_expense_subcategory-add'); // add
    $app->map(["GET","OPTIONS"], '/EmpExpenseSubcategoryView[/{id}]', EmpExpenseSubcategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('EmpExpenseSubcategoryView-emp_expense_subcategory-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseSubcategoryEdit[/{id}]', EmpExpenseSubcategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('EmpExpenseSubcategoryEdit-emp_expense_subcategory-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/EmpExpenseSubcategoryDelete[/{id}]', EmpExpenseSubcategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('EmpExpenseSubcategoryDelete-emp_expense_subcategory-delete'); // delete
    $app->group(
        '/emp_expense_subcategory',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', EmpExpenseSubcategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('emp_expense_subcategory/list-emp_expense_subcategory-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', EmpExpenseSubcategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('emp_expense_subcategory/add-emp_expense_subcategory-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', EmpExpenseSubcategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('emp_expense_subcategory/view-emp_expense_subcategory-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', EmpExpenseSubcategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('emp_expense_subcategory/edit-emp_expense_subcategory-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', EmpExpenseSubcategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('emp_expense_subcategory/delete-emp_expense_subcategory-delete-2'); // delete
        }
    );

    // employee
    $app->map(["GET","POST","OPTIONS"], '/EmployeeList[/{id}]', EmployeeController::class . ':list')->add(PermissionMiddleware::class)->setName('EmployeeList-employee-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/EmployeeAdd[/{id}]', EmployeeController::class . ':add')->add(PermissionMiddleware::class)->setName('EmployeeAdd-employee-add'); // add
    $app->map(["GET","OPTIONS"], '/EmployeeView[/{id}]', EmployeeController::class . ':view')->add(PermissionMiddleware::class)->setName('EmployeeView-employee-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/EmployeeEdit[/{id}]', EmployeeController::class . ':edit')->add(PermissionMiddleware::class)->setName('EmployeeEdit-employee-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/EmployeeDelete[/{id}]', EmployeeController::class . ':delete')->add(PermissionMiddleware::class)->setName('EmployeeDelete-employee-delete'); // delete
    $app->group(
        '/employee',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', EmployeeController::class . ':list')->add(PermissionMiddleware::class)->setName('employee/list-employee-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', EmployeeController::class . ':add')->add(PermissionMiddleware::class)->setName('employee/add-employee-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', EmployeeController::class . ':view')->add(PermissionMiddleware::class)->setName('employee/view-employee-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', EmployeeController::class . ':edit')->add(PermissionMiddleware::class)->setName('employee/edit-employee-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', EmployeeController::class . ':delete')->add(PermissionMiddleware::class)->setName('employee/delete-employee-delete-2'); // delete
        }
    );

    // employee_position
    $app->map(["GET","POST","OPTIONS"], '/EmployeePositionList[/{id}]', EmployeePositionController::class . ':list')->add(PermissionMiddleware::class)->setName('EmployeePositionList-employee_position-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/EmployeePositionAdd[/{id}]', EmployeePositionController::class . ':add')->add(PermissionMiddleware::class)->setName('EmployeePositionAdd-employee_position-add'); // add
    $app->map(["GET","OPTIONS"], '/EmployeePositionView[/{id}]', EmployeePositionController::class . ':view')->add(PermissionMiddleware::class)->setName('EmployeePositionView-employee_position-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/EmployeePositionEdit[/{id}]', EmployeePositionController::class . ':edit')->add(PermissionMiddleware::class)->setName('EmployeePositionEdit-employee_position-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/EmployeePositionDelete[/{id}]', EmployeePositionController::class . ':delete')->add(PermissionMiddleware::class)->setName('EmployeePositionDelete-employee_position-delete'); // delete
    $app->group(
        '/employee_position',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', EmployeePositionController::class . ':list')->add(PermissionMiddleware::class)->setName('employee_position/list-employee_position-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', EmployeePositionController::class . ':add')->add(PermissionMiddleware::class)->setName('employee_position/add-employee_position-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', EmployeePositionController::class . ':view')->add(PermissionMiddleware::class)->setName('employee_position/view-employee_position-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', EmployeePositionController::class . ':edit')->add(PermissionMiddleware::class)->setName('employee_position/edit-employee_position-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', EmployeePositionController::class . ':delete')->add(PermissionMiddleware::class)->setName('employee_position/delete-employee_position-delete-2'); // delete
        }
    );

    // machine
    $app->map(["GET","POST","OPTIONS"], '/MachineList[/{id}]', MachineController::class . ':list')->add(PermissionMiddleware::class)->setName('MachineList-machine-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/MachineAdd[/{id}]', MachineController::class . ':add')->add(PermissionMiddleware::class)->setName('MachineAdd-machine-add'); // add
    $app->map(["GET","OPTIONS"], '/MachineView[/{id}]', MachineController::class . ':view')->add(PermissionMiddleware::class)->setName('MachineView-machine-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/MachineEdit[/{id}]', MachineController::class . ':edit')->add(PermissionMiddleware::class)->setName('MachineEdit-machine-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/MachineDelete[/{id}]', MachineController::class . ':delete')->add(PermissionMiddleware::class)->setName('MachineDelete-machine-delete'); // delete
    $app->group(
        '/machine',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', MachineController::class . ':list')->add(PermissionMiddleware::class)->setName('machine/list-machine-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', MachineController::class . ':add')->add(PermissionMiddleware::class)->setName('machine/add-machine-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', MachineController::class . ':view')->add(PermissionMiddleware::class)->setName('machine/view-machine-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', MachineController::class . ':edit')->add(PermissionMiddleware::class)->setName('machine/edit-machine-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', MachineController::class . ':delete')->add(PermissionMiddleware::class)->setName('machine/delete-machine-delete-2'); // delete
        }
    );

    // machine_brand
    $app->map(["GET","POST","OPTIONS"], '/MachineBrandList[/{id}]', MachineBrandController::class . ':list')->add(PermissionMiddleware::class)->setName('MachineBrandList-machine_brand-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/MachineBrandAdd[/{id}]', MachineBrandController::class . ':add')->add(PermissionMiddleware::class)->setName('MachineBrandAdd-machine_brand-add'); // add
    $app->map(["GET","OPTIONS"], '/MachineBrandView[/{id}]', MachineBrandController::class . ':view')->add(PermissionMiddleware::class)->setName('MachineBrandView-machine_brand-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/MachineBrandEdit[/{id}]', MachineBrandController::class . ':edit')->add(PermissionMiddleware::class)->setName('MachineBrandEdit-machine_brand-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/MachineBrandDelete[/{id}]', MachineBrandController::class . ':delete')->add(PermissionMiddleware::class)->setName('MachineBrandDelete-machine_brand-delete'); // delete
    $app->group(
        '/machine_brand',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', MachineBrandController::class . ':list')->add(PermissionMiddleware::class)->setName('machine_brand/list-machine_brand-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', MachineBrandController::class . ':add')->add(PermissionMiddleware::class)->setName('machine_brand/add-machine_brand-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', MachineBrandController::class . ':view')->add(PermissionMiddleware::class)->setName('machine_brand/view-machine_brand-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', MachineBrandController::class . ':edit')->add(PermissionMiddleware::class)->setName('machine_brand/edit-machine_brand-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', MachineBrandController::class . ':delete')->add(PermissionMiddleware::class)->setName('machine_brand/delete-machine_brand-delete-2'); // delete
        }
    );

    // machine_category
    $app->map(["GET","POST","OPTIONS"], '/MachineCategoryList[/{id}]', MachineCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('MachineCategoryList-machine_category-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/MachineCategoryAdd[/{id}]', MachineCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('MachineCategoryAdd-machine_category-add'); // add
    $app->map(["GET","OPTIONS"], '/MachineCategoryView[/{id}]', MachineCategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('MachineCategoryView-machine_category-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/MachineCategoryEdit[/{id}]', MachineCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('MachineCategoryEdit-machine_category-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/MachineCategoryDelete[/{id}]', MachineCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('MachineCategoryDelete-machine_category-delete'); // delete
    $app->group(
        '/machine_category',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', MachineCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('machine_category/list-machine_category-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', MachineCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('machine_category/add-machine_category-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', MachineCategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('machine_category/view-machine_category-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', MachineCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('machine_category/edit-machine_category-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', MachineCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('machine_category/delete-machine_category-delete-2'); // delete
        }
    );

    // office_department
    $app->map(["GET","POST","OPTIONS"], '/OfficeDepartmentList[/{id}]', OfficeDepartmentController::class . ':list')->add(PermissionMiddleware::class)->setName('OfficeDepartmentList-office_department-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/OfficeDepartmentAdd[/{id}]', OfficeDepartmentController::class . ':add')->add(PermissionMiddleware::class)->setName('OfficeDepartmentAdd-office_department-add'); // add
    $app->map(["GET","OPTIONS"], '/OfficeDepartmentView[/{id}]', OfficeDepartmentController::class . ':view')->add(PermissionMiddleware::class)->setName('OfficeDepartmentView-office_department-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/OfficeDepartmentEdit[/{id}]', OfficeDepartmentController::class . ':edit')->add(PermissionMiddleware::class)->setName('OfficeDepartmentEdit-office_department-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/OfficeDepartmentDelete[/{id}]', OfficeDepartmentController::class . ':delete')->add(PermissionMiddleware::class)->setName('OfficeDepartmentDelete-office_department-delete'); // delete
    $app->group(
        '/office_department',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', OfficeDepartmentController::class . ':list')->add(PermissionMiddleware::class)->setName('office_department/list-office_department-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', OfficeDepartmentController::class . ':add')->add(PermissionMiddleware::class)->setName('office_department/add-office_department-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', OfficeDepartmentController::class . ':view')->add(PermissionMiddleware::class)->setName('office_department/view-office_department-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', OfficeDepartmentController::class . ':edit')->add(PermissionMiddleware::class)->setName('office_department/edit-office_department-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', OfficeDepartmentController::class . ':delete')->add(PermissionMiddleware::class)->setName('office_department/delete-office_department-delete-2'); // delete
        }
    );

    // user_account
    $app->map(["GET","POST","OPTIONS"], '/UserAccountList[/{id}]', UserAccountController::class . ':list')->add(PermissionMiddleware::class)->setName('UserAccountList-user_account-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UserAccountAdd[/{id}]', UserAccountController::class . ':add')->add(PermissionMiddleware::class)->setName('UserAccountAdd-user_account-add'); // add
    $app->map(["GET","OPTIONS"], '/UserAccountView[/{id}]', UserAccountController::class . ':view')->add(PermissionMiddleware::class)->setName('UserAccountView-user_account-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UserAccountEdit[/{id}]', UserAccountController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserAccountEdit-user_account-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UserAccountDelete[/{id}]', UserAccountController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserAccountDelete-user_account-delete'); // delete
    $app->group(
        '/user_account',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', UserAccountController::class . ':list')->add(PermissionMiddleware::class)->setName('user_account/list-user_account-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', UserAccountController::class . ':add')->add(PermissionMiddleware::class)->setName('user_account/add-user_account-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', UserAccountController::class . ':view')->add(PermissionMiddleware::class)->setName('user_account/view-user_account-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', UserAccountController::class . ':edit')->add(PermissionMiddleware::class)->setName('user_account/edit-user_account-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', UserAccountController::class . ':delete')->add(PermissionMiddleware::class)->setName('user_account/delete-user_account-delete-2'); // delete
        }
    );

    // userlevelpermissions
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsList[/{keys:.*}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsList-userlevelpermissions-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsAdd[/{keys:.*}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsAdd-userlevelpermissions-add'); // add
    $app->map(["GET","OPTIONS"], '/UserlevelpermissionsView[/{keys:.*}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsView-userlevelpermissions-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsEdit[/{keys:.*}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsEdit-userlevelpermissions-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsDelete[/{keys:.*}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsDelete-userlevelpermissions-delete'); // delete
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissions/add-userlevelpermissions-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissions/view-userlevelpermissions-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissions/edit-userlevelpermissions-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissions/delete-userlevelpermissions-delete-2'); // delete
        }
    );

    // userlevels
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsList[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelsList-userlevels-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsAdd[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelsAdd-userlevels-add'); // add
    $app->map(["GET","OPTIONS"], '/UserlevelsView[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelsView-userlevels-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsEdit[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelsEdit-userlevels-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsDelete[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelsDelete-userlevels-delete'); // delete
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevels/view-userlevels-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevels/edit-userlevels-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevels/delete-userlevels-delete-2'); // delete
        }
    );

    // cash_advance_request
    $app->map(["GET","POST","OPTIONS"], '/CashAdvanceRequestList[/{id}]', CashAdvanceRequestController::class . ':list')->add(PermissionMiddleware::class)->setName('CashAdvanceRequestList-cash_advance_request-list'); // list
    $app->map(["GET","OPTIONS"], '/CashAdvanceRequestView[/{id}]', CashAdvanceRequestController::class . ':view')->add(PermissionMiddleware::class)->setName('CashAdvanceRequestView-cash_advance_request-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/CashAdvanceRequestEdit[/{id}]', CashAdvanceRequestController::class . ':edit')->add(PermissionMiddleware::class)->setName('CashAdvanceRequestEdit-cash_advance_request-edit'); // edit
    $app->group(
        '/cash_advance_request',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', CashAdvanceRequestController::class . ':list')->add(PermissionMiddleware::class)->setName('cash_advance_request/list-cash_advance_request-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', CashAdvanceRequestController::class . ':view')->add(PermissionMiddleware::class)->setName('cash_advance_request/view-cash_advance_request-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', CashAdvanceRequestController::class . ':edit')->add(PermissionMiddleware::class)->setName('cash_advance_request/edit-cash_advance_request-edit-2'); // edit
        }
    );

    // homepage
    $app->map(["GET", "POST", "OPTIONS"], '/Homepage[/{params:.*}]', HomepageController::class)->add(PermissionMiddleware::class)->setName('Homepage-homepage-custom'); // custom

    // pending_expense
    $app->map(["GET","POST","OPTIONS"], '/PendingExpenseList[/{id}]', PendingExpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('PendingExpenseList-pending_expense-list'); // list
    $app->map(["GET","OPTIONS"], '/PendingExpenseView[/{id}]', PendingExpenseController::class . ':view')->add(PermissionMiddleware::class)->setName('PendingExpenseView-pending_expense-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/PendingExpenseEdit[/{id}]', PendingExpenseController::class . ':edit')->add(PermissionMiddleware::class)->setName('PendingExpenseEdit-pending_expense-edit'); // edit
    $app->group(
        '/pending_expense',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', PendingExpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('pending_expense/list-pending_expense-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', PendingExpenseController::class . ':view')->add(PermissionMiddleware::class)->setName('pending_expense/view-pending_expense-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', PendingExpenseController::class . ':edit')->add(PermissionMiddleware::class)->setName('pending_expense/edit-pending_expense-edit-2'); // edit
        }
    );

    // man_expense
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseList[/{id}]', ManExpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('ManExpenseList-man_expense-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseAdd[/{id}]', ManExpenseController::class . ':add')->add(PermissionMiddleware::class)->setName('ManExpenseAdd-man_expense-add'); // add
    $app->map(["GET","OPTIONS"], '/ManExpenseView[/{id}]', ManExpenseController::class . ':view')->add(PermissionMiddleware::class)->setName('ManExpenseView-man_expense-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseEdit[/{id}]', ManExpenseController::class . ':edit')->add(PermissionMiddleware::class)->setName('ManExpenseEdit-man_expense-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseDelete[/{id}]', ManExpenseController::class . ':delete')->add(PermissionMiddleware::class)->setName('ManExpenseDelete-man_expense-delete'); // delete
    $app->group(
        '/man_expense',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ManExpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('man_expense/list-man_expense-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ManExpenseController::class . ':add')->add(PermissionMiddleware::class)->setName('man_expense/add-man_expense-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ManExpenseController::class . ':view')->add(PermissionMiddleware::class)->setName('man_expense/view-man_expense-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ManExpenseController::class . ':edit')->add(PermissionMiddleware::class)->setName('man_expense/edit-man_expense-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ManExpenseController::class . ':delete')->add(PermissionMiddleware::class)->setName('man_expense/delete-man_expense-delete-2'); // delete
        }
    );

    // man_expense_category
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseCategoryList[/{id}]', ManExpenseCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('ManExpenseCategoryList-man_expense_category-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseCategoryAdd[/{id}]', ManExpenseCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('ManExpenseCategoryAdd-man_expense_category-add'); // add
    $app->map(["GET","OPTIONS"], '/ManExpenseCategoryView[/{id}]', ManExpenseCategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('ManExpenseCategoryView-man_expense_category-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseCategoryEdit[/{id}]', ManExpenseCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('ManExpenseCategoryEdit-man_expense_category-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseCategoryDelete[/{id}]', ManExpenseCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('ManExpenseCategoryDelete-man_expense_category-delete'); // delete
    $app->group(
        '/man_expense_category',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ManExpenseCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('man_expense_category/list-man_expense_category-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ManExpenseCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('man_expense_category/add-man_expense_category-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ManExpenseCategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('man_expense_category/view-man_expense_category-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ManExpenseCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('man_expense_category/edit-man_expense_category-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ManExpenseCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('man_expense_category/delete-man_expense_category-delete-2'); // delete
        }
    );

    // man_expense_subcategory
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseSubcategoryList[/{id}]', ManExpenseSubcategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('ManExpenseSubcategoryList-man_expense_subcategory-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseSubcategoryAdd[/{id}]', ManExpenseSubcategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('ManExpenseSubcategoryAdd-man_expense_subcategory-add'); // add
    $app->map(["GET","OPTIONS"], '/ManExpenseSubcategoryView[/{id}]', ManExpenseSubcategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('ManExpenseSubcategoryView-man_expense_subcategory-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseSubcategoryEdit[/{id}]', ManExpenseSubcategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('ManExpenseSubcategoryEdit-man_expense_subcategory-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ManExpenseSubcategoryDelete[/{id}]', ManExpenseSubcategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('ManExpenseSubcategoryDelete-man_expense_subcategory-delete'); // delete
    $app->group(
        '/man_expense_subcategory',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ManExpenseSubcategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('man_expense_subcategory/list-man_expense_subcategory-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ManExpenseSubcategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('man_expense_subcategory/add-man_expense_subcategory-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ManExpenseSubcategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('man_expense_subcategory/view-man_expense_subcategory-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ManExpenseSubcategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('man_expense_subcategory/edit-man_expense_subcategory-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ManExpenseSubcategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('man_expense_subcategory/delete-man_expense_subcategory-delete-2'); // delete
        }
    );

    // yesterday
    $app->map(["GET","POST","OPTIONS"], '/YesterdayList', YesterdayController::class . ':list')->add(PermissionMiddleware::class)->setName('YesterdayList-yesterday-list'); // list
    $app->group(
        '/yesterday',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', YesterdayController::class . ':list')->add(PermissionMiddleware::class)->setName('yesterday/list-yesterday-list-2'); // list
        }
    );

    // weekly
    $app->map(["GET","POST","OPTIONS"], '/WeeklyList', WeeklyController::class . ':list')->add(PermissionMiddleware::class)->setName('WeeklyList-weekly-list'); // list
    $app->group(
        '/weekly',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', WeeklyController::class . ':list')->add(PermissionMiddleware::class)->setName('weekly/list-weekly-list-2'); // list
        }
    );

    // monthly
    $app->map(["GET","POST","OPTIONS"], '/MonthlyList', MonthlyController::class . ':list')->add(PermissionMiddleware::class)->setName('MonthlyList-monthly-list'); // list
    $app->group(
        '/monthly',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', MonthlyController::class . ':list')->add(PermissionMiddleware::class)->setName('monthly/list-monthly-list-2'); // list
        }
    );

    // todayy
    $app->map(["GET","POST","OPTIONS"], '/TodayyList', TodayyController::class . ':list')->add(PermissionMiddleware::class)->setName('TodayyList-todayy-list'); // list
    $app->group(
        '/todayy',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', TodayyController::class . ':list')->add(PermissionMiddleware::class)->setName('todayy/list-todayy-list-2'); // list
        }
    );

    // ExpenseYesterday
    $app->map(["GET", "POST", "OPTIONS"], '/ExpenseYesterday', ExpenseYesterdayController::class)->add(PermissionMiddleware::class)->setName('ExpenseYesterday-ExpenseYesterday-summary'); // summary

    // ExpenseToday
    $app->map(["GET", "POST", "OPTIONS"], '/ExpenseToday', ExpenseTodayController::class)->add(PermissionMiddleware::class)->setName('ExpenseToday-ExpenseToday-summary'); // summary

    // ExpenseMonthly
    $app->map(["GET", "POST", "OPTIONS"], '/ExpenseMonthly', ExpenseMonthlyController::class)->add(PermissionMiddleware::class)->setName('ExpenseMonthly-ExpenseMonthly-summary'); // summary

    // ExpenseWeekly
    $app->map(["GET", "POST", "OPTIONS"], '/ExpenseWeekly', ExpenseWeeklyController::class)->add(PermissionMiddleware::class)->setName('ExpenseWeekly-ExpenseWeekly-summary'); // summary

    // Dashboard2
    $app->map(["GET", "POST", "OPTIONS"], '/Dashboard2', Dashboard2Controller::class)->add(PermissionMiddleware::class)->setName('Dashboard2-Dashboard2-dashboard'); // dashboard

    // summary
    $app->map(["GET","POST","OPTIONS"], '/SummaryList', SummaryController::class . ':list')->add(PermissionMiddleware::class)->setName('SummaryList-summary-list'); // list
    $app->group(
        '/summary',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', SummaryController::class . ':list')->add(PermissionMiddleware::class)->setName('summary/list-summary-list-2'); // list
        }
    );

    // employeemonthlyexpense
    $app->map(["GET","POST","OPTIONS"], '/EmployeemonthlyexpenseList', EmployeemonthlyexpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('EmployeemonthlyexpenseList-employeemonthlyexpense-list'); // list
    $app->group(
        '/employeemonthlyexpense',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', EmployeemonthlyexpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('employeemonthlyexpense/list-employeemonthlyexpense-list-2'); // list
        }
    );

    // EmpMonthlyExpense
    $app->map(["GET", "POST", "OPTIONS"], '/EmpMonthlyExpense', EmpMonthlyExpenseController::class)->add(PermissionMiddleware::class)->setName('EmpMonthlyExpense-EmpMonthlyExpense-summary'); // summary

    // manmonthlyexpense
    $app->map(["GET","POST","OPTIONS"], '/ManmonthlyexpenseList', ManmonthlyexpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('ManmonthlyexpenseList-manmonthlyexpense-list'); // list
    $app->group(
        '/manmonthlyexpense',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', ManmonthlyexpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('manmonthlyexpense/list-manmonthlyexpense-list-2'); // list
        }
    );

    // ManagerMonthlyExpense
    $app->map(["GET", "POST", "OPTIONS"], '/ManagerMonthlyExpense', ManagerMonthlyExpenseController::class)->add(PermissionMiddleware::class)->setName('ManagerMonthlyExpense-ManagerMonthlyExpense-summary'); // summary

    // utilities
    $app->map(["GET","POST","OPTIONS"], '/UtilitiesList', UtilitiesController::class . ':list')->add(PermissionMiddleware::class)->setName('UtilitiesList-utilities-list'); // list
    $app->group(
        '/utilities',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', UtilitiesController::class . ':list')->add(PermissionMiddleware::class)->setName('utilities/list-utilities-list-2'); // list
        }
    );

    // UtilitiesExpense
    $app->map(["GET", "POST", "OPTIONS"], '/UtilitiesExpense', UtilitiesExpenseController::class)->add(PermissionMiddleware::class)->setName('UtilitiesExpense-UtilitiesExpense-summary'); // summary

    // machinerepairhistory2
    $app->map(["GET","POST","OPTIONS"], '/Machinerepairhistory2List', Machinerepairhistory2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('Machinerepairhistory2List-machinerepairhistory2-list'); // list
    $app->group(
        '/machinerepairhistory2',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', Machinerepairhistory2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('machinerepairhistory2/list-machinerepairhistory2-list-2'); // list
        }
    );

    // MachineRepairHistory
    $app->map(["GET", "POST", "OPTIONS"], '/MachineRepairHistory', MachineRepairHistoryController::class)->add(PermissionMiddleware::class)->setName('MachineRepairHistory-MachineRepairHistory-summary'); // summary

    // EmployeeDashboard2
    $app->map(["GET","POST","OPTIONS"], '/EmployeeDashboard2List[/{id}]', EmployeeDashboard2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('EmployeeDashboard2List-EmployeeDashboard2-list'); // list
    $app->map(["GET","OPTIONS"], '/EmployeeDashboard2View[/{id}]', EmployeeDashboard2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('EmployeeDashboard2View-EmployeeDashboard2-view'); // view
    $app->group(
        '/EmployeeDashboard2',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', EmployeeDashboard2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('EmployeeDashboard2/list-EmployeeDashboard2-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', EmployeeDashboard2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('EmployeeDashboard2/view-EmployeeDashboard2-view-2'); // view
        }
    );

    // EmployeeDashboarddd
    $app->map(["GET", "POST", "OPTIONS"], '/EmployeeDashboarddd', EmployeeDashboardddController::class)->add(PermissionMiddleware::class)->setName('EmployeeDashboarddd-EmployeeDashboarddd-summary'); // summary

    // error
    $app->map(["GET","POST","OPTIONS"], '/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->map(["GET","POST","OPTIONS"], '/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->map(["GET","POST","OPTIONS"], '/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // change_password
    $app->map(["GET","POST","OPTIONS"], '/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // userpriv
    $app->map(["GET","POST","OPTIONS"], '/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->map(["GET","POST","OPTIONS"], '/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // captcha
    $app->map(["GET","OPTIONS"], '/captcha[/{page}]', OthersController::class . ':captcha')->add(PermissionMiddleware::class)->setName('captcha');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->get('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
