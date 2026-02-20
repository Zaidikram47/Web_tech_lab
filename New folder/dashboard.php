<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Dark Mode</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 h-screen flex items-center justify-center p-4 font-sans text-slate-200">

    <div
        class="bg-slate-800 p-8 rounded-3xl shadow-2xl w-full max-w-lg border border-slate-700 relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-2 bg-indigo-500 blur-xl"></div>
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

        <div class="flex items-center justify-between mb-10 mt-2">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Dashboard</h1>
                <p class="text-slate-400 mt-1 text-sm">Account Overview</p>
            </div>
            <div
                class="h-14 w-14 bg-indigo-900/50 border border-indigo-700/50 rounded-full flex items-center justify-center text-indigo-400 font-extrabold text-2xl shadow-inner">
                <?php echo strtoupper(substr($_SESSION["user"], 0, 1)); ?>
            </div>
        </div>

        <div class="bg-slate-900/50 rounded-2xl p-6 border border-slate-700/50 mb-8 shadow-inner">
            <div class="space-y-5">
                <div class="flex justify-between items-center border-b border-slate-700/50 pb-4">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Username</span>
                    <span class="text-white font-medium"><?php echo htmlspecialchars($_SESSION["user"]); ?></span>
                </div>
                <div class="flex justify-between items-center pt-1">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Email Address</span>
                    <span class="text-white font-medium"><?php echo htmlspecialchars($_SESSION["email"]); ?></span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <a href="logout.php" class="flex-1 w-full block">
                <button
                    class="w-full bg-red-900/20 text-red-400 border border-red-800/50 py-3.5 rounded-xl font-bold text-md hover:bg-red-900/40 hover:text-red-300 transition-all duration-300 active:scale-[0.98]">
                    Logout
                </button>
            </a>
        </div>
    </div>

</body>

</html>