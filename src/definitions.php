<?php

namespace PHPMaker2022\efga_expense_system;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "budget" => \DI\create(Budget::class),
    "cash_advance" => \DI\create(CashAdvance::class),
    "emp_expense" => \DI\create(EmpExpense::class),
    "emp_expense_category" => \DI\create(EmpExpenseCategory::class),
    "emp_expense_subcategory" => \DI\create(EmpExpenseSubcategory::class),
    "employee" => \DI\create(Employee::class),
    "employee_position" => \DI\create(EmployeePosition::class),
    "machine" => \DI\create(Machine::class),
    "machine_brand" => \DI\create(MachineBrand::class),
    "machine_category" => \DI\create(MachineCategory::class),
    "office_department" => \DI\create(OfficeDepartment::class),
    "user_account" => \DI\create(UserAccount::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "cash_advance_request" => \DI\create(CashAdvanceRequest::class),
    "homepage" => \DI\create(Homepage::class),
    "pending_expense" => \DI\create(PendingExpense::class),
    "man_expense" => \DI\create(ManExpense::class),
    "man_expense_category" => \DI\create(ManExpenseCategory::class),
    "man_expense_subcategory" => \DI\create(ManExpenseSubcategory::class),
    "yesterday" => \DI\create(Yesterday::class),
    "weekly" => \DI\create(Weekly::class),
    "monthly" => \DI\create(Monthly::class),
    "todayy" => \DI\create(Todayy::class),
    "ExpenseYesterday" => \DI\create(ExpenseYesterday::class),
    "ExpenseToday" => \DI\create(ExpenseToday::class),
    "ExpenseMonthly" => \DI\create(ExpenseMonthly::class),
    "ExpenseWeekly" => \DI\create(ExpenseWeekly::class),
    "Dashboard2" => \DI\create(Dashboard2::class),
    "summary" => \DI\create(Summary::class),
    "employeemonthlyexpense" => \DI\create(Employeemonthlyexpense::class),
    "EmpMonthlyExpense" => \DI\create(EmpMonthlyExpense::class),
    "manmonthlyexpense" => \DI\create(Manmonthlyexpense::class),
    "ManagerMonthlyExpense" => \DI\create(ManagerMonthlyExpense::class),
    "utilities" => \DI\create(Utilities::class),
    "UtilitiesExpense" => \DI\create(UtilitiesExpense::class),
    "machinerepairhistory2" => \DI\create(Machinerepairhistory2::class),
    "MachineRepairHistory" => \DI\create(MachineRepairHistory::class),
    "EmployeeDashboard2" => \DI\create(EmployeeDashboard2::class),
    "EmployeeDashboarddd" => \DI\create(EmployeeDashboarddd::class),

    // User table
    "usertable" => \DI\get("user_account"),
];
