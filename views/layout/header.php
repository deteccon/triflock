<?php
$pageTitle = $pageTitle ?? "Triflock";
$pageDescription = $pageDescription ?? "";
$pageKeywords = $pageKeywords ?? "";
$pageUrl = $pageUrl ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($pageKeywords); ?>">
    <meta name="author" content="IM">

    <link rel="stylesheet" href="/public/assets/css/style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-50 transition-colors duration-300">

    <header class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 border-b-4 border-amber-500">
        <nav class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 py-4">

            <a href="/public/index.php" class="text-2xl sm:text-3xl font-black text-amber-500 tracking-tight uppercase">
                Triflock
            </a>

            <div class="flex items-center gap-4 sm:gap-6 lg:gap-8">

                <ul class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                    <?php if (!isset($_SESSION['uId'])): ?>
                        <li class="hidden sm:block">
                            <a href="/public/login.php"
                                class="text-slate-200 hover:text-amber-400 transition-colors duration-200 font-medium tracking-wide uppercase text-sm">
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="/public/register.php"
                                class="bg-amber-500 hover:bg-amber-600 text-slate-950 px-4 sm:px-6 py-2 sm:py-2.5 transition-all duration-200 font-semibold border-2 border-amber-500 hover:border-amber-600 uppercase text-sm tracking-wide">
                                Register
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['uId'])): ?>
                        <li class="hidden sm:block">
                            <a href="/public/dashboard.php"
                                class="text-slate-200 hover:text-amber-400 transition-colors duration-200 font-medium tracking-wide uppercase text-sm">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="/public/logout.php"
                                class="bg-rose-600 hover:bg-rose-700 text-white px-4 sm:px-6 py-2 sm:py-2.5 transition-all duration-200 font-semibold border-2 border-rose-600 hover:border-rose-700 uppercase text-sm tracking-wide">
                                Logout
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <button id="theme-tog" class="p-2 sm:p-2.5 bg-slate-700 hover:bg-slate-600 text-amber-500 transition-all duration-200 border-2 border-slate-600 hover:border-amber-500">
                    <i data-lucide="moon" id="icon-M" class="block w-4 h-4 sm:w-5 sm:h-5"></i>
                    <i data-lucide="sun" id="icon-S" class="hidden w-4 h-4 sm:w-5 sm:h-5"></i>
                </button>

            </div>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto p-4 sm:p-6">