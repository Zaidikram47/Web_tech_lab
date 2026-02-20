<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
$success = "";

if (isset($_GET["success"])) {
    $success = "Account created! Please login.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (file_exists("users.txt")) {
        $lines = file("users.txt");
        foreach ($lines as $line) {
            $data = explode("|", trim($line));
            if ($data[1] == $email && $data[2] == $password) {
                $_SESSION["user"] = $data[0];
                $_SESSION["email"] = $data[1];
                header("Location: dashboard.php");
                exit;
            }
        }
    }

    $error = "Wrong email or password!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Dark Mode</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 h-screen flex items-center justify-center p-4 font-sans text-slate-200">

    <div
        class="bg-slate-800 p-8 rounded-3xl shadow-2xl w-full max-w-md border border-slate-700 relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-2 bg-indigo-500 blur-xl"></div>
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

        <div class="text-center mb-10 mt-2">
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Welcome Back</h1>
            <p class="text-slate-400 mt-2 text-sm">Enter your credentials to access your account.</p>
        </div>

        <?php if (isset($success) && $success != "") { ?>
            <div
                class="mb-6 p-4 rounded-xl bg-emerald-900/30 text-emerald-400 border border-emerald-800/50 text-sm font-medium flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <?php echo $success; ?>
            </div>
        <?php } ?>

        <?php if (isset($error) && $error != "") { ?>
            <div
                class="mb-6 p-4 rounded-xl bg-red-900/30 text-red-400 border border-red-800/50 text-sm font-medium flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST" action="login.php" class="space-y-5">
            <div class="group">
                <label
                    class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 group-focus-within:text-indigo-400 transition-colors">Email
                    Address</label>
                <input type="email" name="email" required placeholder="hello@example.com"
                    class="w-full p-3.5 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all shadow-inner">
            </div>

            <div class="group">
                <label
                    class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 group-focus-within:text-indigo-400 transition-colors">Password</label>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full p-3.5 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all shadow-inner">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-3.5 mt-4 rounded-xl font-bold text-md hover:bg-indigo-500 shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] transition-all duration-300 active:scale-[0.98]">
                Login
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-700/50 text-center">
            <p class="text-slate-400 text-sm">
                Don't have an account?
                <a href="signup.php" class="text-indigo-400 font-semibold hover:text-indigo-300 transition-colors">Sign
                    up here</a>
            </p>
        </div>
    </div>

</body>

</html>