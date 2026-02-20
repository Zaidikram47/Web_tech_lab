<?php
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Storing variables (with basic sanitization to prevent breaking the HTML layout)
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $submitted = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form | Dark Mode</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 font-sans text-slate-200">

    <div
        class="bg-slate-800 p-8 rounded-3xl shadow-2xl w-full max-w-md border border-slate-700 relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-2 bg-indigo-500 blur-xl"></div>
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

        <?php if ($submitted): ?>
            <div class="text-center mt-4">
                <div
                    class="w-16 h-16 bg-emerald-900/50 text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_0_15px_rgba(16,185,129,0.3)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">Message Sent!</h1>
                <p class="text-slate-400 text-sm mb-8">Here is a copy of what we received.</p>

                <div class="bg-slate-900/50 rounded-xl p-5 text-left border border-slate-700/50 mb-8 space-y-4">
                    <div>
                        <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Name</span>
                        <span class="text-slate-200 font-medium"><?php echo $name; ?></span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Email</span>
                        <span class="text-slate-200 font-medium"><?php echo $email; ?></span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Message</span>
                        <p class="text-slate-300 mt-1 text-sm leading-relaxed"><?php echo nl2br($message); ?></p>
                    </div>
                </div>

                <a href="index.php"
                    class="inline-block w-full bg-slate-700 text-white py-3.5 rounded-xl font-bold text-md hover:bg-slate-600 transition-all duration-300 active:scale-[0.98]">
                    Send Another Message
                </a>
            </div>

        <?php else: ?>
            <div class="text-center mb-10 mt-2">
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Contact Us</h1>
                <p class="text-slate-400 mt-2 text-sm">Send us a message and we'll get back to you.</p>
            </div>

            <form method="POST" action="index.php" class="space-y-5">
                <div class="group">
                    <label
                        class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 group-focus-within:text-indigo-400 transition-colors">Full
                        Name</label>
                    <input type="text" name="name" required placeholder="Jane Doe"
                        class="w-full p-3.5 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all shadow-inner">
                </div>

                <div class="group">
                    <label
                        class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 group-focus-within:text-indigo-400 transition-colors">Email
                        Address</label>
                    <input type="email" name="email" required placeholder="jane@example.com"
                        class="w-full p-3.5 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all shadow-inner">
                </div>

                <div class="group">
                    <label
                        class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 group-focus-within:text-indigo-400 transition-colors">Message</label>
                    <textarea name="message" required rows="4" placeholder="How can we help you?"
                        class="w-full p-3.5 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all shadow-inner resize-none"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3.5 mt-4 rounded-xl font-bold text-md hover:bg-indigo-500 shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] transition-all duration-300 active:scale-[0.98]">
                    Send Message
                </button>
            </form>
        <?php endif; ?>
    </div>

</body>

</html>