<?php

namespace PHPMaker2022\efga_expense_system;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
$topMenu->addMenuItem(18, "mci_Employee_Record", $MenuLanguage->MenuPhrase("18", "MenuText"), "", -1, "", true, false, true, "fas fa-address-book", "", true, false);
$topMenu->addMenuItem(6, "mi_employee", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "EmployeeList", 18, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}employee'), false, false, "fa fa-user", "", true, false);
$topMenu->addMenuItem(11, "mi_office_department", $MenuLanguage->MenuPhrase("11", "MenuText"), $MenuRelativePath . "OfficeDepartmentList", 18, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}office_department'), false, false, "fas fa-sitemap", "", true, false);
$topMenu->addMenuItem(7, "mi_employee_position", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "EmployeePositionList", 18, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}employee_position'), false, false, "far fa-address-card", "", true, false);
$topMenu->addMenuItem(12, "mci_Security_Settings", $MenuLanguage->MenuPhrase("12", "MenuText"), "", -1, "", true, false, true, "fas fa-users-cog", "", true, false);
$topMenu->addMenuItem(19, "mi_user_account", $MenuLanguage->MenuPhrase("19", "MenuText"), $MenuRelativePath . "UserAccountList", 12, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}user_account'), false, false, "fa fa-user-plus", "", true, false);
$topMenu->addMenuItem(21, "mi_userlevels", $MenuLanguage->MenuPhrase("21", "MenuText"), $MenuRelativePath . "UserlevelsList", 12, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}userlevels'), false, false, "fas fa-user-cog", "", true, false);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(88, "mi_EmployeeDashboarddd", $MenuLanguage->MenuPhrase("88", "MenuText"), $MenuRelativePath . "EmployeeDashboarddd", -1, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}Employee Dashboarddd'), false, false, "", "", false, true);
$sideMenu->addMenuItem(77, "mi_Dashboard2", $MenuLanguage->MenuPhrase("77", "MenuText"), $MenuRelativePath . "Dashboard2", -1, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}Dashboard'), false, false, "", "", false, true);
$sideMenu->addMenuItem(18, "mci_Employee_Record", $MenuLanguage->MenuPhrase("18", "MenuText"), "", -1, "", true, false, true, "fas fa-address-book", "", true, true);
$sideMenu->addMenuItem(6, "mi_employee", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "EmployeeList", 18, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}employee'), false, false, "fa fa-user", "", true, true);
$sideMenu->addMenuItem(11, "mi_office_department", $MenuLanguage->MenuPhrase("11", "MenuText"), $MenuRelativePath . "OfficeDepartmentList", 18, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}office_department'), false, false, "fas fa-sitemap", "", true, true);
$sideMenu->addMenuItem(7, "mi_employee_position", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "EmployeePositionList", 18, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}employee_position'), false, false, "far fa-address-card", "", true, true);
$sideMenu->addMenuItem(17, "mci_Expense", $MenuLanguage->MenuPhrase("17", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(3, "mi_emp_expense", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "EmpExpenseList", 17, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}emp_expense'), false, false, "fas fa-file-invoice", "", false, true);
$sideMenu->addMenuItem(25, "mi_man_expense", $MenuLanguage->MenuPhrase("25", "MenuText"), $MenuRelativePath . "ManExpenseList", 17, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}man_expense'), false, false, "fas fa-file-invoice", "", false, true);
$sideMenu->addMenuItem(2, "mi_cash_advance", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "CashAdvanceList", 17, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}cash_advance'), false, false, "fas fa-file-invoice-dollar", "", false, true);
$sideMenu->addMenuItem(22, "mi_cash_advance_request", $MenuLanguage->MenuPhrase("22", "MenuText"), $MenuRelativePath . "CashAdvanceRequestList", 17, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}cash_advance_request'), false, false, "fas fa-file-invoice-dollar", "", false, true);
$sideMenu->addMenuItem(24, "mi_pending_expense", $MenuLanguage->MenuPhrase("24", "MenuText"), $MenuRelativePath . "PendingExpenseList", 17, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}pending_expense'), false, false, "fas fa-file-archive", "", false, true);
$sideMenu->addMenuItem(12, "mci_Security_Settings", $MenuLanguage->MenuPhrase("12", "MenuText"), "", -1, "", true, false, true, "fas fa-users-cog", "", true, true);
$sideMenu->addMenuItem(19, "mi_user_account", $MenuLanguage->MenuPhrase("19", "MenuText"), $MenuRelativePath . "UserAccountList", 12, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}user_account'), false, false, "fa fa-user-plus", "", true, true);
$sideMenu->addMenuItem(21, "mi_userlevels", $MenuLanguage->MenuPhrase("21", "MenuText"), $MenuRelativePath . "UserlevelsList", 12, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}userlevels'), false, false, "fas fa-user-cog", "", true, true);
$sideMenu->addMenuItem(15, "mci_Expense_Settings", $MenuLanguage->MenuPhrase("15", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(4, "mi_emp_expense_category", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "EmpExpenseCategoryList", 15, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}emp_expense_category'), false, false, "fas fa-box", "", false, true);
$sideMenu->addMenuItem(5, "mi_emp_expense_subcategory", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "EmpExpenseSubcategoryList", 15, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}emp_expense_subcategory'), false, false, "fas fa-boxes", "", false, true);
$sideMenu->addMenuItem(26, "mi_man_expense_category", $MenuLanguage->MenuPhrase("26", "MenuText"), $MenuRelativePath . "ManExpenseCategoryList", 15, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}man_expense_category'), false, false, "fas fa-box", "", false, true);
$sideMenu->addMenuItem(27, "mi_man_expense_subcategory", $MenuLanguage->MenuPhrase("27", "MenuText"), $MenuRelativePath . "ManExpenseSubcategoryList", 15, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}man_expense_subcategory'), false, false, "fas fa-boxes", "", false, true);
$sideMenu->addMenuItem(1, "mi_budget", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "BudgetList", 15, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}budget'), false, false, "fas fa-money-check-alt", "", false, true);
$sideMenu->addMenuItem(16, "mci_Machine_", $MenuLanguage->MenuPhrase("16", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(8, "mi_machine", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "MachineList", 16, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}machine'), false, false, "fas fa-truck-pickup", "", false, true);
$sideMenu->addMenuItem(86, "mi_MachineRepairHistory", $MenuLanguage->MenuPhrase("86", "MenuText"), $MenuRelativePath . "MachineRepairHistory", 16, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}Machine Repair History'), false, false, "fas fa-tools", "", false, true);
$sideMenu->addMenuItem(10, "mi_machine_category", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "MachineCategoryList", 16, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}machine_category'), false, false, "fas fa-pencil-ruler", "", false, true);
$sideMenu->addMenuItem(9, "mi_machine_brand", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "MachineBrandList", 16, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}machine_brand'), false, false, "fas fa-tools", "", false, true);
$sideMenu->addMenuItem(70, "mci_Report", $MenuLanguage->MenuPhrase("70", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(80, "mi_EmpMonthlyExpense", $MenuLanguage->MenuPhrase("80", "MenuText"), $MenuRelativePath . "EmpMonthlyExpense", 70, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}Emp Monthly Expense'), false, false, "fas fa-file-invoice-dollar", "", false, true);
$sideMenu->addMenuItem(82, "mi_ManagerMonthlyExpense", $MenuLanguage->MenuPhrase("82", "MenuText"), $MenuRelativePath . "ManagerMonthlyExpense", 70, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}Manager Monthly Expense'), false, false, "fas fa-file-invoice", "", false, true);
$sideMenu->addMenuItem(84, "mi_UtilitiesExpense", $MenuLanguage->MenuPhrase("84", "MenuText"), $MenuRelativePath . "UtilitiesExpense", 70, "", AllowListMenu('{4EB84F2A-5676-4E71-AB80-D3ECF349B44C}Utilities Expense'), false, false, "fas fa-file-medical-alt", "", false, true);
$sideMenu->Compact = true;
echo $sideMenu->toScript();
