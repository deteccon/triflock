<?php
session_start();

if (!isset($_SESSION['uId'])) {
    $_SESSION['error'] = "You must login to access";
    header("Location: login.php");
    exit;
}

$pageTitle = "Dashboard | Triflock";
include __DIR__ . '/../views/layout/header.php';
?>

<div class="flex justify-center items-center min-h-[85vh] px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 p-8 sm:p-10 lg:p-12 w-full max-w-2xl">

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-rose-50 dark:bg-rose-950 border-l-4 border-rose-600 text-rose-800 dark:text-rose-200 p-4 mb-6">
                <p class="font-medium"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-emerald-50 dark:bg-emerald-950 border-l-4 border-emerald-600 text-emerald-800 dark:text-emerald-200 p-4 mb-6">
                <p class="font-medium"><?php echo $_SESSION['success'];
                                        unset($_SESSION['success']); ?></p>
            </div>
        <?php endif; ?>

        <div class="border-l-4 border-amber-500 pl-4 mb-8">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-50 uppercase tracking-tight">
                Dashboard
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 uppercase tracking-wide">
                Welcome Back, <?php echo htmlspecialchars($_SESSION['uName']); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8">
            <div class="border-2 border-slate-200 dark:border-slate-700 p-6 bg-slate-50 dark:bg-slate-800">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-3 h-3 bg-amber-500"></div>
                    <h3 class="font-bold text-slate-900 dark:text-slate-50 uppercase text-sm tracking-wider">
                        Account Status
                    </h3>
                </div>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-500">ACTIVE</p>
            </div>

            <div class="border-2 border-slate-200 dark:border-slate-700 p-6 bg-slate-50 dark:bg-slate-800">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-3 h-3 bg-amber-500"></div>
                    <h3 class="font-bold text-slate-900 dark:text-slate-50 uppercase text-sm tracking-wider">
                        User ID
                    </h3>
                </div>
                <p class="text-2xl font-black text-slate-900 dark:text-slate-50">#<?php echo htmlspecialchars($_SESSION['uId']); ?></p>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>