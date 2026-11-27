<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    (!isset($profile) || empty($profile['first_name'])) &&
    isset($_SESSION['user_id'])
) {
    require_once __DIR__ . '/../../../config/Database.php';

    $database = new Database();
    $headerDb = $database->getConnection();

    $stmt = $headerDb->prepare(
        "SELECT js.first_name,
                js.last_name,
                u.email,
                u.phone_number
         FROM Job_seeker js
         JOIN User u ON js.user_id = u.user_id
         WHERE js.user_id = :user_id"
    );

    $stmt->execute([
        ':user_id' => $_SESSION['user_id']
    ]);

    $headerProfile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($headerProfile) {
        if (!isset($profile) || !is_array($profile)) {
            $profile = [];
        }

        $profile = array_merge($profile, $headerProfile);
    }
}

$fullName = trim(
    ($profile['first_name'] ?? '') . ' ' .
    ($profile['last_name'] ?? '')
);

$fullName = $fullName !== '' ? $fullName : 'Job Seeker';

$email = $profile['email'] ?? ($_SESSION['email'] ?? '');

$initial = strtoupper(substr($fullName, 0, 1));
?>

<header class="top-header">
    <div class="user-profile" id="userProfile">

        <button
            class="user-profile-button"
            id="profileButton"
            type="button"
        >
            <div
                class="user-avatar"
                style="display:flex; align-items:center; justify-content:center; font-weight:700;"
            >
                <?php echo htmlspecialchars($initial); ?>
            </div>

            <span class="user-name">
                <?php echo htmlspecialchars($fullName); ?>
            </span>

            <span class="user-arrow">▼</span>
        </button>

        <div class="profile-dropdown" id="profileDropdown">

            <div class="dropdown-user">

                <div
                    class="user-avatar"
                    style="display:flex; align-items:center; justify-content:center; font-weight:700;"
                >
                    <?php echo htmlspecialchars($initial); ?>
                </div>

                <div class="dropdown-user-info">
                    <strong>
                        <?php echo htmlspecialchars($fullName); ?>
                    </strong>

                    <span>
                        <?php echo htmlspecialchars($email); ?>
                    </span>
                </div>

            </div>

            <a href="index.php?action=edit_jobseeker_profile">
                Edit Profile
            </a>

            <a
                href="index.php?action=logout"
                class="dropdown-logout"
            >
                Log Out
            </a>

        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const profileButton = document.getElementById('profileButton');
    const profileDropdown = document.getElementById('profileDropdown');
    const userProfile = document.getElementById('userProfile');

    if (profileButton && profileDropdown && userProfile) {

        profileButton.addEventListener('click', function (event) {
            event.stopPropagation();
            profileDropdown.classList.toggle('show');
        });

        document.addEventListener('click', function (event) {
            if (!userProfile.contains(event.target)) {
                profileDropdown.classList.remove('show');
            }
        });

    }
});
</script>