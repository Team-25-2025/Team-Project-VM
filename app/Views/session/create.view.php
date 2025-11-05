<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - Make-It-All</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="style/session/session.view.css">
</head>
<body>

<div class="login-container">
    <div class="login-left">
        <div class="login-illustration">
            <i class="fas fa-tasks"></i>
        </div>
        <h1>Make-It-All</h1>
        <p>Productivity & Knowledge Management System</p>
        
    </div>

    <div class="login-right">
        <div class="login-header">
            <h2>Welcome Back!</h2>
            <p>Please login to your account</p>
        </div>

        <div class="logout-message" id="logoutMessage">
            <i class="fas fa-check-circle me-2"></i>You have been successfully logged out.
        </div>

        <form id="loginForm" action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Corporate Email Address</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="text" class="form-control" id="email" name="email" placeholder="your.name@make-it-all.com" value="<?= old("email")?>">
                </div>
                <small class="text-muted">Must be a @make-it-all.com email address</small>
            </div>
            <?php if (isset($errors["email"])) : ?>
              <p class="error-message"><?= $errors["email"]?></p>
            <?php endif; ?>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                    <span class="input-group-text password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>
            <?php if (isset($errors["password"])) : ?>
              <p class="error-message"><?= $errors["password"]?></p>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">
                        Remember me
                    </label>
                </div>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </form>

        <div class="text-center">
            <p class="text-muted mt-3">
                Don't have an account? <a href="/register" class="forgot-password">Register</a>
            </p>
        </div>

        <div class="divider">
            <span>Need Help?</span>
        </div>

        <div class="text-center">
            <p class="text-muted mb-0">
                Contact IT Support: <a href="mailto:support@make-it-all.co.uk" class="forgot-password">support@make-it-all.co.uk</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php requireModule(['session/login.view']) ?>
</body>
</html>