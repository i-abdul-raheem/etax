<?php
include_once '../includes/db.php'; // adjust path if needed
include_once '../includes/header.php';

// Fetch current info
$stmt = $pdo->query("SELECT * FROM website_info ORDER BY id DESC LIMIT 1");
$info = $stmt->fetch(PDO::FETCH_ASSOC);

$site_name = $info['site_name'] ?? SITE_NAME;
$contact_email = $info['contact_email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = $_POST['site_name'];
    $contact_email = $_POST['contact_email'];

    // Insert or update
    if ($info) {
        $stmt = $pdo->prepare("UPDATE website_info SET site_name=?, contact_email=? WHERE id=?");
        $stmt->execute([$site_name, $contact_email, $info['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO website_info (site_name, contact_email) VALUES (?, ?)");
        $stmt->execute([$site_name, $contact_email]);
    }
    $success = true;
}
?>

<div class="container">
    <h2>Update Website Information</h2>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success">Website info updated!</div>
    <?php endif; ?>
    <form method="post">
        <div>
            <label>Website Name:</label>
            <input type="text" name="site_name" value="<?php echo htmlspecialchars($site_name); ?>" required>
        </div>
        <div>
            <label>Contact Email:</label>
            <input type="email" name="contact_email" value="<?php echo htmlspecialchars($contact_email); ?>" required>
        </div>
        <button type="submit">Save Changes</button>
    </form>
</div>

<?php include_once '../includes/footer.php'; ?>