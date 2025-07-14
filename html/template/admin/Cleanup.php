<?php
// Redirect to index.php if 'admin=true' is not in the URL
if (!isset($_GET['admin']) || $_GET['admin'] !== 'true') {
    header("Location: index.php");
    exit();
}

// Path to the html folder (one level above /template/admin/)
$targetDir = realpath(__DIR__ . '/../../'); // This points to /html

// Safety check: Don't allow deletion of root or empty path
if ($targetDir === false || $targetDir === '/' || trim($targetDir) === '') {
    die("Invalid target directory.");
}

// Recursive deletion function
function deleteFolder($folder) {
    $files = array_diff(scandir($folder), ['.', '..']);
    foreach ($files as $file) {
        $path = $folder . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            deleteFolder($path);
            rmdir($path);
        } else {
            unlink($path);
        }
    }
}

// Final confirmation step
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    deleteFolder($targetDir);
    rmdir($targetDir); // Delete the html folder itself
    echo "<h3>The entire 'html' folder and its contents have been deleted.</h3>";
} else {
    echo "<h3>Are you absolutely sure you want to delete the entire 'html' folder and ALL its files?</h3>";
    echo "<a href='?admin=true&confirm=yes'>Yes, DELETE EVERYTHING</a>";
}
?>
