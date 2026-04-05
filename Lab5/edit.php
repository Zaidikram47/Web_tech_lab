<?php
/**
 * Update Record Handler
 * EduPortal Management System
 */

session_start();
require_once 'functions.php';

// 1. Secure ID Validation
$recordId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$recordId || $recordId <= 0) {
    header('Location: index.php');
    exit;
}

// 2. Fetch the specific student directly (we will build this efficiently in functions.php)
$currentStudent = getStudentById($recordId);

// Redirect if someone types a random ID in the URL that doesn't exist
if (!$currentStudent) {
    header('Location: index.php');
    exit;
}

// 3. Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentName = trim($_POST['name'] ?? '');
    $studentEmail = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $studentCourse = trim($_POST['course'] ?? '');

    // Basic validation
    if ($studentName && $studentEmail && $studentCourse) {

        // Call the abstracted update function
        updateStudent($recordId, $studentName, $studentEmail, $studentCourse);

        // Set success message and redirect
        $_SESSION['message'] = "Record for " . htmlspecialchars($studentName) . " successfully updated.";
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | EduPortal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-blue-600 text-white rounded flex items-center justify-center font-bold text-lg">
                        S</div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">EduPortal</span>
                </div>
                <div class="flex gap-6 text-sm font-medium">
                    <a href="index.php" class="text-slate-500 hover:text-slate-900 py-5 transition-colors">Directory</a>
                    <span class="text-blue-600 border-b-2 border-blue-600 py-5">Edit Record</span>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center p-6">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="bg-slate-50 border-b border-slate-200 px-8 py-6 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Edit Student Profile</h2>
                    <p class="text-sm text-slate-500 mt-1">Modifying records for <strong class="text-slate-700">
                            <?php echo htmlspecialchars($currentStudent['name'] ?? ''); ?>
                        </strong>.</p>
                </div>
                <span
                    class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold tracking-wider uppercase">
                    ID: #
                    <?php echo str_pad($recordId, 4, '0', STR_PAD_LEFT); ?>
                </span>
            </div>

            <div class="p-8">
                <form method="POST" class="space-y-5">

                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Full Name</label>
                        <input type="text" id="name" name="name" required
                            value="<?php echo htmlspecialchars($currentStudent['name'] ?? ''); ?>"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all sm:text-sm">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">University
                            Email</label>
                        <input type="email" id="email" name="email" required
                            value="<?php echo htmlspecialchars($currentStudent['email'] ?? ''); ?>"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all sm:text-sm">
                    </div>

                    <div>
                        <label for="course" class="block text-sm font-semibold text-slate-700 mb-1">Degree /
                            Course</label>
                        <input type="text" id="course" name="course" required
                            value="<?php echo htmlspecialchars($currentStudent['course'] ?? ''); ?>"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all sm:text-sm">
                    </div>

                    <div class="pt-4 flex items-center justify-between">
                        <a href="index.php"
                            class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm transition-colors">
                            Update Records
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>

</html>