<?php
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../../vendor/autoload.php';

class StudentController
{

    public function index()
    {

        $student = new Student();

        $limit  = 5;
        $page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $students      = $student->getPaginated($limit, $offset);
        $totalStudents = $student->getCount();

        $stats     = $student->getStats();
        $examTotal = $student->getExamTotalMarks();

        $totalPages = ceil($totalStudents / $limit);
        $sort       = $_GET['sort'] ?? null;
        $min        = $_GET['min'] ?? null;
        $max        = $_GET['max'] ?? null;
        $from       = $_GET['from'] ?? null;
        $to         = $_GET['to'] ?? null;

        $stats     = $student->getStats();
        $examTotal = $student->getExamTotalMarks();

        include __DIR__ . '/../views/students/index.php';
    }

    public function create()
    {
        include __DIR__ . '/../views/students/create.php';
    }

    public function store()
    {

        $data   = $_POST;
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = "Name required";
        }

        if (! filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email";
        }

        if (! preg_match('/^[0-9]{10}$/', $data['phone'])) {
            $errors['phone'] = "Phone must be 10 digits";
        }

        if (! is_numeric($data['marks'])) {
            $errors['marks'] = "Marks must be numeric";
        }

        if (! empty($errors)) {
            session_start();
            $_SESSION['errors'] = $errors;
            $_SESSION['old']    = $data;
            header("Location: ?action=create");
            return;
        }

        $student = new Student();
        $student->create($data);
        $student->create($data);

        require_once __DIR__ . '/../helpers/MailHelper.php';

        $examTotal = $student->getExamTotalMarks();

        MailHelper::sendResultMail(
            $data['email'],
            $data['name'],
            $data['marks'],
            $examTotal
        );
        header("Location: /student_admin_panel/public/");
    }

    public function delete()
    {
        $student = new Student();
        $student->delete($_GET['id']);

        header("Location: /student_admin_panel/public/");
    }

    public function view()
    {
        $student = new Student();
        $data    = $student->getById($_GET['id']);

        include __DIR__ . '/../views/students/view.php';
    }

    public function edit()
    {
        $student = new Student();
        $data    = $student->getById($_GET['id']);

        include __DIR__ . '/../views/students/edit.php';
    }
    public function update()
    {

        $id   = $_GET['id'];
        $data = $_POST;

        $student = new Student();
        $student->update($id, $data);

        require_once __DIR__ . '/../helpers/MailHelper.php';

        $examTotal = $student->getExamTotalMarks();

        MailHelper::sendResultMail(
            $data['email'],
            $data['name'],
            $data['marks'],
            $examTotal
        );

        header("Location: /student_admin_panel/public/");
    }
    public function send_email()
    {

        $id = $_GET['id'];

        $student   = new Student();
        $data      = $student->getById($id);
        $examTotal = $student->getExamTotalMarks();

        require_once __DIR__ . '/../../vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'yourgmail@gmail.com';
            $mail->Password   = 'your_app_password';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('yourgmail@gmail.com', 'Student System');
            $mail->addAddress($data['email']);

            $status = ($data['marks'] >= ($examTotal / 2)) ? "PASS" : "FAIL";

            $mail->isHTML(true);
            $mail->Subject = "Your Exam Result";

            $mail->Body = "
                <h2>Hello {$data['name']}</h2>
                <p>Your exam result is ready.</p>
                <p><b>Marks:</b> {$data['marks']} / {$examTotal}</p>
                <p><b>Status:</b> {$status}</p>
            ";

            $mail->send();

            header("Location: ?action=view&id=$id&sent=1");

        } catch (Exception $e) {
            echo "Mail Error: " . $mail->ErrorInfo;
        }
    }
    public function update_exam_marks()
    {
        $student = new Student();
        $student->updateExamTotalMarks($_POST['exam_total_marks']);

        header("Location: /student_admin_panel/public/");
    }
    public function exportExcel()
    {

        $student = new Student();
        $data    = $student->getAll()->fetch_all(MYSQLI_ASSOC);

        require_once __DIR__ . '/../../vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Phone');
        $sheet->setCellValue('E1', 'Marks');

        $row = 2;

        foreach ($data as $student) {
            $sheet->setCellValue('A' . $row, $student['id']);
            $sheet->setCellValue('B' . $row, $student['name']);
            $sheet->setCellValue('C' . $row, $student['email']);
            $sheet->setCellValue('D' . $row, $student['phone']);
            $sheet->setCellValue('E' . $row, $student['marks']);
            $row++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="students.xlsx"');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    public function importExcel()
    {

        require_once __DIR__ . '/../../vendor/autoload.php';

        if ($_FILES['file']['name']) {

            $file = $_FILES['file']['tmp_name'];

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray();

            $student = new Student();

            foreach ($rows as $index => $row) {

                if ($index == 0) {
                    continue;
                }

                $data = [
                    'name'  => $row[1],
                    'email' => $row[2],
                    'phone' => $row[3],
                    'marks' => $row[4],
                ];

                $student->create($data);
            }
        }

        header("Location: /student_admin_panel/public/");
    }
    public function exportPdf()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';

        $student = new Student();
        $data    = $student->getAll();

        $html = "<h2>Student List</h2><table border='1' cellpadding='5'>
                    <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Marks</th></tr>";

        while ($row = $data->fetch_assoc()) {
            $html .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['marks']}</td>
                      </tr>";
        }

        $html .= "</table>";

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("students.pdf");
        exit;
    }
}
