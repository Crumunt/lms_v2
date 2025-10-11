<?php
declare(strict_types=1);

class CourseManagementController extends Controller
{

    protected Course $course;

    public function __construct()
    {
        parent::__construct();
        $this->course = new Course();
    }

    public function index()
    {
        $data = $this->course->all();

        if ($this->isAjaxRequest()) {
            $datas = [];

            while ($row = $data->fetch_assoc()) {
                array_push($datas, $row);
            }
            echo json_encode($datas);
            return;
        }

        $this->view('courses/index', compact('data'));
    }

    public function show($courseId)
    {
        $userId = $_SESSION['user_id'] ?? null;
        $userRole = $_SESSION['user_role'] ?? null;

        if(!$userId || !$userRole) {
            throw new InvalidArgumentException('Invaid access.');
        }

        // CHECK IF HAS COURSE
        $hasRecord = $this->course->all('course_view', '*', ['id' => $courseId])->fetch_assoc();

        if (!$hasRecord) {
            throw new Exception('Course not found', 404);
        }

        $contentResult = $this->course->all('course_content', '*', ['course_id' => $courseId]);
        $contentData = $contentResult ? $contentResult->fetch_all(MYSQLI_ASSOC) : [];

        $courseData = $this->course->processCourseData($hasRecord);

        $contentView = $this->course->processContentView($contentData);


        $this->view('courses/content/show', compact('contentView', 'courseData', 'userRole'));

    }

    public function edit($courseId)
    {
        try {
            $user_id = $_SESSION['user_id'] ?? null;
            $user_role = $_SESSION['user_role'] ?? null;

            if (!$user_id || !$user_role) {
                throw new Exception('Unauthorized');
            }

            $data = $this->course->find((int) $courseId);
            $this->view('courses/edit', compact('data'));
        } catch (Exception $e) {
            throw new Exception('Invalid action.');
        }
    }

    public function update()
    {

        try {

            $requiredFields = ['course_id', 'course_name', 'short_description'];
            $allowedFields = ['course_name', 'short_description', 'status', 'difficulty'];
            $data = [];

            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    throw new InvalidArgumentException("Field '{$field}' is required");
                }
            }

            foreach ($allowedFields as $field) {
                if (isset($_POST[$field]) && !empty($_POST[$field])) {
                    $data[$field] = $this->validateAndSanitizeField($field, $_POST[$field]);
                }
            }

            if (!isset($data['status'])) {
                $data['status'] = 'pending';
            }

            if (!isset($data['difficulty'])) {
                $data['difficulty'] = 'beginner';
            }

            $course_id = $this->validateAndSanitizeField('course_id', $_POST['course_id']);
            $this->validateCourseData($data, $course_id);

            $this->course->beginTransaction();

            $courseId = $this->course->update(['id' => $course_id], $data, 'courses');

            if (!$course_id) {
                throw new Exception("Failed to update course");
            }

            $this->course->commit();
        } catch (InvalidArgumentException $e) {
            $this->course->rollback();
            http_response_code(400); // Bad Request
            echo json_encode([
                'error' => 'Validation Error',
                'message' => $e->getMessage()
            ]);
            exit;
        } catch (Exception $e) {
            $this->course->rollback();
            http_response_code(500); // Internal Server Error

            // Return generic error to client
            echo json_encode([
                'error' => 'Server Error',
                'message' => 'An error occurred while updating the course'
            ]);
            exit;
        }

    }

    public function destroy()
    {
        try {
            header('Content-Type: application/json');

            $data = json_decode(file_get_contents("php://input"), true);
            $course_id = $data['table_id'] ?? null;

            $this->course->beginTransaction();
            $this->course->delete(['id' => $course_id], 'courses');
            $this->course->commit();

            http_response_code(200);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $this->course->rollback();

            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function validateCourseData($data, $courseId = null)
    {
        if (!$courseId) {
            $courses = $this->course->all('courses', 'course_name', ['course_name' => $data['course_name']])->num_rows;
        } else {
            $courses = $this->course->all('courses', 'course_name', ['course_name' => $data['course_name']], ['id' => $courseId])->num_rows;

        }

        if ($courses > 0) {
            throw new InvalidArgumentException('A course with this title already exists');
        }
    }

    private function validateAndSanitizeField($field, $value)
    {
        $value = trim($value);

        switch ($field) {
            case 'course_name':
                if (strlen($value) > 100) {
                    throw new InvalidArgumentException("Title cannot exceed 100 characters");
                }
                if (strlen($value) < 3) {
                    throw new InvalidArgumentException("Title must be at least 3 characters");
                }
                return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            case 'short_description':
            case 'content':
                if (strlen($value) > 250) {
                    throw new InvalidArgumentException("Description cannot exceed 250 characters");
                }
                if (strlen($value) < 10) {
                    throw new InvalidArgumentException("Description must be at least 10 characters");
                }
                return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            case 'status':
                $allowedStatuses = ['pending', 'approved', 'rejected', 'active', 'inactive', 'archived', 'draft'];
                if (!in_array($value, $allowedStatuses)) {
                    throw new InvalidArgumentException("Invalid status value");
                }
                return $value;
            case 'difficulty':
                $allowedDifficulties = ['beginner', 'intermediate', 'advanced'];
                if (!in_array($value, $allowedDifficulties)) {
                    throw new InvalidArgumentException('Invalid difficulty value');
                }
                return $value;
            default:
                return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    }

}