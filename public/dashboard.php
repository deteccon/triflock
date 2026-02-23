<?php
session_start();

if (!isset($_SESSION['uId'])) {
    $_SESSION['error'] = "You must login to access";
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profP'])) {
    $res = $userController->uploadProfilePic($_SESSION['uId'], $_FILES['profP']);

    if ($res['success']) {
        $_SESSION['uProfP'] = $res['url'];
        $_SESSION['profPicSuccess'] = $res['message'];
    } else {
        $_SESSION['profPicError'] = $res['message'];
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$pageTitle = "Dashboard | Triflock";
include __DIR__ . '/../views/layout/header.php';
?>

<div class="flex justify-center items-start min-h-[85vh] px-4 sm:px-6 lg:px-8 pt-8">
    <div class="w-full max-w-2xl">

        <!-- Success/Error messages -->
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

        <div class="bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 p-8 sm:p-10 lg:p-12 mb-6">
            <?php if (empty($_SESSION['uProfP'])): ?>
                <div class="border-l-4 border-amber-500 pl-4 mb-6">
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-50 uppercase tracking-tight">
                        Add Profile Picture
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 uppercase tracking-wide">
                        Personalize your account
                    </p>
                </div>

                <?php if (isset($_SESSION['profPicError'])): ?>
                    <div class="bg-rose-50 dark:bg-rose-950 border-l-4 border-rose-600 text-rose-800 dark:text-rose-200 p-4 mb-6">
                        <p class="font-medium"><?php echo $_SESSION['profPicError'];
                                                unset($_SESSION['profPicError']); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['profPicSuccess'])): ?>
                    <div class="bg-emerald-50 dark:bg-emerald-950 border-l-4 border-emerald-600 text-emerald-800 dark:text-emerald-200 p-4 mb-6">
                        <p class="font-medium"><?php echo $_SESSION['profPicSuccess'];
                                                unset($_SESSION['profPicSuccess']); ?></p>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">
                            Choose Profile Picture
                        </label>
                        <input type="file" name="profP" required
                            class="w-full border-2 border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-50 px-4 py-3 focus:outline-none focus:border-amber-500 dark:focus:border-amber-500 transition-all duration-200">
                    </div>

                    <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-slate-950 py-3.5 font-bold uppercase tracking-wide border-2 border-amber-500 hover:border-amber-600 transition-all duration-200">
                        Upload
                    </button>
                </form>
            <?php else: ?>
                <div class="flex flex-col items-center">
                    <img src="<?php echo $_SESSION['uProfP']; ?>" alt="Profile Picture" class="w-20 h-20 rounded-full border-2 border-amber-500 mb-4">
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>