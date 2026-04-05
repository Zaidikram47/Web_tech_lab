<?php
/**
 * Core Data Operations
 * EduPortal Management System - Flat File Edition
 */

define('DATA_FILE', 'students.txt');

/**
 * Retrieves all students from the text file.
 * Returns an array of associative arrays.
 */
function getStudents()
{
    if (!file_exists(DATA_FILE)) {
        return [];
    }

    // Read file, ignoring empty lines at the end
    $lines = file(DATA_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $students = [];

    foreach ($lines as $line) {
        // Explode the pipe-delimited string safely
        $parts = explode("|", $line);
        if (count($parts) === 4) {
            $students[] = [
                "id" => $parts[0],
                "name" => $parts[1],
                "email" => $parts[2],
                "course" => $parts[3]
            ];
        }
    }

    return $students;
}

/**
 * Retrieves a single student record by their timestamp ID.
 */
function getStudentById($id)
{
    $students = getStudents();

    // Array column allows us to quickly search without a manual loop
    $key = array_search($id, array_column($students, 'id'));

    if ($key !== false) {
        return $students[$key];
    }
    return null;
}

/**
 * Appends a new student to the text file.
 */
function addStudent($name, $email, $course)
{
    // Generate a unique ID using the current timestamp
    $id = time();

    // Format: ID|Name|Email|Course
    $record = sprintf("%s|%s|%s|%s" . PHP_EOL, $id, $name, $email, $course);

    // FILE_APPEND ensures we add to the end of the file, not overwrite it
    file_put_contents(DATA_FILE, $record, FILE_APPEND | LOCK_EX);
}

/**
 * Removes a student from the text file by rebuilding it.
 */
function deleteStudent($id)
{
    $students = getStudents();

    // Filter out the student whose ID matches the one we want to delete
    $updatedStudents = array_filter($students, function ($student) use ($id) {
        return $student['id'] != $id;
    });

    _saveDataToFile($updatedStudents);
}

/**
 * Updates an existing student record in the text file.
 */
function updateStudent($id, $name, $email, $course)
{
    $students = getStudents();

    // Map over the array and replace the matching record
    $updatedStudents = array_map(function ($student) use ($id, $name, $email, $course) {
        if ($student['id'] == $id) {
            return [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'course' => $course
            ];
        }
        return $student;
    }, $students);

    _saveDataToFile($updatedStudents);
}

/**
 * Internal Helper: Rebuilds the text file from an array of student data.
 */
function _saveDataToFile($studentsArray)
{
    $fileContent = "";

    foreach ($studentsArray as $student) {
        $fileContent .= sprintf(
            "%s|%s|%s|%s" . PHP_EOL,
            $student['id'],
            $student['name'],
            $student['email'],
            $student['course']
        );
    }

    // Overwrite the file with the newly built string
    file_put_contents(DATA_FILE, $fileContent, LOCK_EX);
}
?>