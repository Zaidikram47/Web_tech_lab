<?php
require_once 'db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dob = trim($_POST['dob'] ?? null);
    $course = trim($_POST['course'] ?? '');

    if ($first === '' || $last === '')
        $errors[] = 'First and last name are required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = 'A valid email is required.';

    if (empty($errors)) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('INSERT INTO students (first_name,last_name,email,dob,course,created_at) VALUES (?,?,?,?,?,NOW())');
        $stmt->execute([$first, $last, $email, $dob, $course]);
        header('Location: index.php');
        exit;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Enroll Student | EduPortal</title>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-blue-600 text-white rounded flex items-center justify-center font-bold text-lg">
                        S
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">EduPortal</span>
                </div>
                <div class="flex gap-6 text-sm font-medium">
                    <a href="index.php" class="text-slate-500 hover:text-slate-900 py-5 transition-colors">Dashboard</a>
                    <a href="create.php" class="text-blue-600 border-b-2 border-blue-600 py-5">Add Student</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center p-6">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="bg-slate-50 border-b border-slate-200 px-8 py-6">
                <h2 class="text-2xl font-bold text-slate-900">Student Enrollment</h2>
                <p class="text-sm text-slate-500 mt-1">Enter the student's personal and academic details below.</p>
            </div>

            <div class="p-8">
                <?php if ($errors): ?>
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-md">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-sm font-bold text-red-800">Please correct the following errors:</h3>
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-700 ml-7 space-y-1">
                            <?php foreach ($errors as $e)
                                echo '<li>' . htmlspecialchars($e) . '</li>'; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" class="space-y-6">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-slate-700 mb-1">First
                                Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="e.g. Sarah"
                                value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all sm:text-sm">
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-slate-700 mb-1">Last
                                Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="e.g. Connor"
                                value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="sarah.connor@university.edu"
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all sm:text-sm">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="dob" class="block text-sm font-semibold text-slate-700 mb-1">Date of
                                Birth</label>
                            <input type="date" id="dob" name="dob"
                                value="<?php echo htmlspecialchars($_POST['dob'] ?? ''); ?>"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all sm:text-sm text-slate-700">
                        </div>

                        <div>
                            <label for="course" class="block text-sm font-semibold text-slate-700 mb-1">Assigned
                                Course</label>
                            <input type="text" id="course" name="course" placeholder="e.g. Computer Science"
                                value="<?php echo htmlspecialchars($_POST['course'] ?? ''); ?>"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all sm:text-sm">
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3">
                        <a href="index.php"
                            class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm transition-colors">
                            Enroll Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <p class="text-sm text-slate-500">&copy; <?php echo date('Y'); ?> EduPortal Management.</p>
        </div>
    </footer>

</body>

</html>