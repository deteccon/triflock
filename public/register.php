<?php
session_start();

if (isset($_SESSION['uId'])) {
    header("Location: dashboard.php");
    exit;
}

require_once __DIR__ . '/../app/controllers/AuthController.php';
$auth = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $result = $auth->register($name, $email, $password);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header("Location: register.php");
        exit;
    }
}

$pageTitle = "Register | Triflock";
include __DIR__ . '/../views/layout/header.php';
?>

<div class="flex justify-center items-center min-h-[85vh] px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 p-8 sm:p-10 lg:p-12 w-full max-w-md">

        <div class="border-l-4 border-amber-500 pl-4 mb-8">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-50 uppercase tracking-tight">
                Register
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 uppercase tracking-wide">
                Create New Account
            </p>
        </div>

        <!-- // Server side errors -->
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



        <form method="post" class="space-y-6 js-validate-form">
            <!-- // Form validation errors -->
            <div class="js-err bg-rose-50 dark:bg-rose-950 border-l-4 border-rose-600 text-rose-800 dark:text-rose-200 p-4 mb-6 hidden"></div>
            <div>
                <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">
                    Full Name
                </label>
                <input type="text" name="name" placeholder="Abiral Parajuli" required
                    class="w-full border-2 border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-50 px-4 py-3 focus:outline-none focus:border-amber-500 dark:focus:border-amber-500 transition-all duration-200">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">
                    Email Address
                </label>
                <input type="email" name="email" placeholder="your@email.com" required
                    class="w-full border-2 border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-50 px-4 py-3 focus:outline-none focus:border-amber-500 dark:focus:border-amber-500 transition-all duration-200">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">
                    Password
                </label>
                <input type="password" name="password" placeholder="Create password" required
                    class="w-full border-2 border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-50 px-4 py-3 focus:outline-none focus:border-amber-500 dark:focus:border-amber-500 transition-all duration-200">
            </div>

            <button type="submit"
                class="w-full bg-amber-500 hover:bg-amber-600 text-slate-950 py-3.5 font-bold uppercase tracking-wide border-2 border-amber-500 hover:border-amber-600 transition-all duration-200">
                Register
            </button>
        </form>

        <div class="mt-8 pt-6 border-t-2 border-slate-200 dark:border-slate-700">
            <p class="text-sm text-slate-600 dark:text-slate-400 text-center">
                Already have an account?
                <a href="/public/login.php" class="text-amber-600 dark:text-amber-500 hover:text-amber-700 dark:hover:text-amber-400 font-semibold uppercase tracking-wide">
                    Login
                </a>
            </p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>