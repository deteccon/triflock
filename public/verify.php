<?php
session_start();

if (isset($_SESSION['uId'])) {
    header("Location: dashboard.php");
    exit;
}

if (!isset($_GET['token'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../app/controllers/AuthController.php';

$auth = new AuthController($pdo);

$token = htmlspecialchars($_GET['token']);

$result = $auth->verifyEmail($token);
$success = $result['success'];
$message = $result['message'];

$pageTitle = "Verify | Triflock";
include __DIR__ . '/../views/layout/header.php';
?>

<div class="flex justify-center items-center min-h-[85vh] px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 p-8 sm:p-10 lg:p-12 w-full max-w-md">


        <div class="border-l-4 border-amber-500 pl-4 mb-8">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-50 uppercase tracking-tight">
                Email Verification
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 uppercase tracking-wide">
                Secure Account Activation
            </p>
        </div>


        <?php if ($success): ?>
            <div class="bg-emerald-50 dark:bg-emerald-950 border-l-4 border-emerald-600 text-emerald-800 dark:text-emerald-200 p-6 mb-6 flex items-start gap-3">


                <i data-lucide="check-circle" class="w-6 h-6 mt-1"></i>

                <div>
                    <p class="font-semibold uppercase tracking-wide">
                        Verified Successfully
                    </p>
                    <p class="text-sm mt-1">
                        <?php echo htmlspecialchars($message); ?>
                    </p>
                </div>
            </div>

            <a href="/public/login.php"
                class="w-full block text-center bg-amber-500 hover:bg-amber-600 text-slate-950 py-3.5 font-bold uppercase tracking-wide border-2 border-amber-500 hover:border-amber-600 transition-all duration-200">
                Continue to Login
            </a>

        <?php else: ?>
            <div class="bg-rose-50 dark:bg-rose-950 border-l-4 border-rose-600 text-rose-800 dark:text-rose-200 p-6 mb-6 flex items-start gap-3">


                <i data-lucide="x-circle" class="w-6 h-6 mt-1"></i>

                <div>
                    <p class="font-semibold uppercase tracking-wide">
                        Verification Failed
                    </p>
                    <p class="text-sm mt-1">
                        <?php echo htmlspecialchars($message); ?>
                    </p>
                </div>
            </div>

            <a href="/public/login.php"
                class="w-full block text-center bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-100 py-3.5 font-bold uppercase tracking-wide border-2 border-slate-300 dark:border-slate-600 transition-all duration-200">
                Back to Login
            </a>
        <?php endif; ?>

    </div>
</div>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>