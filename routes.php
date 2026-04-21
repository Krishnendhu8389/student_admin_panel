<?php
require_once __DIR__ . '/app/controllers/StudentController.php';

$controller = new StudentController();

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'create':
        $controller->create();
        break;

    case 'store':
        $controller->store();
        break;

    case 'delete':
        $controller->delete();
        break;

    case 'view':
        $controller->view();
        break;

    case 'edit':
        $controller->edit();
        break;

    case 'update_exam_marks':
        $controller->update_exam_marks();
        break;
    case 'update':
        $controller->update();
        break;
    case 'export_excel':
        $controller->exportExcel();
        break;
        
    case 'import_excel':
        $controller->importExcel();
        break;
    
    case 'export_pdf':
        $controller->exportPdf();
        break;
    default:
        $controller->index();
        break;
}