<?php
require_once 'db.php';

try {
    $pdo = getPDO();
    $stmt = $pdo->query('SELECT * FROM `students` ORDER BY `id` DESC');
    $students = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Connection Failed: " . htmlspecialchars($e->getMessage()));
}

// Handle success/notification messages
$notification = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'updated')
        $notification = "Student record has been successfully updated.";
    if ($_GET['msg'] === 'deleted')
        $notification = "Student record was permanently removed.";
    if ($_GET['msg'] === 'created')
        $notification = "New student successfully enrolled.";
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Student Directory | EduPortal</title>
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
                        S</div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">EduPortal</span>
                </div>
                <div class="flex gap-6 text-sm font-medium">
                    <span class="text-blue-600 border-b-2 border-blue-600 py-5">Dashboard</span>
                    <a href="create.php" class="text-slate-500 hover:text-slate-900 py-5 transition-colors">Add
                        Student</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Student Directory</h1>
                <p class="mt-1 text-sm text-slate-500">Manage, monitor, and update all registered student profiles.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="create.php"
                    class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Enroll New Student
                </a>
            </div>
        </div>

        <?php if ($notification): ?>
            <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-center shadow-sm">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-emerald-800">
                        <?php echo htmlspecialchars($notification); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                ID</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Student Name</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Contact Info</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Course</th>
                            <th scope="col"
                                class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <?php if (count($students) > 0): ?>
                            <?php foreach ($students as $student): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-medium">
                                        #
                                        <?php echo str_pad($student['id'], 4, '0', STR_PAD_LEFT); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-slate-900">
                                            <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-600">
                                            <?php echo htmlspecialchars($student['email']); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($student['course']): ?>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                <?php echo htmlspecialchars($student['course']); ?>
                                            </span>
                                        <?php else: ?>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                                Unassigned
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-3">
                                            <a href="update.php?id=<?php echo $student['id']; ?>"
                                                class="text-slate-400 hover:text-blue-600 transition-colors"
                                                title="Edit Record">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <a href="delete.php?id=<?php echo $student['id']; ?>"
                                                class="text-slate-400 hover:text-red-600 transition-colors"
                                                onclick="return confirm('WARNING: Are you sure you want to permanently delete this student record?');"
                                                title="Delete Record">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-300 mb-4"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <h3 class="text-sm font-semibold text-slate-900">No students enrolled</h3>
                                    <p class="mt-1 text-sm text-slate-500">Get started by adding a new student to the
                                        database.</p>
                                    <div class="mt-6">
                                        <a href="create.php"
                                            class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 border border-transparent rounded-lg hover:bg-blue-100 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Add First Student
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex justify-between items-center">
            <p class="text-sm text-slate-500">&copy;
                <?php echo date('Y'); ?> EduPortal Management Systems.
            </p>
            <p class="text-sm text-slate-400">Version 2.0</p>
        </div>
    </footer>

</body>

</html>