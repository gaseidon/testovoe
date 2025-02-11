<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadStatus = 'error';
    $lines = [];
    $delimiter = $_POST['delimiter'] ?? '';

    if (strlen($delimiter) === 1 && isset($_FILES['file'])) {
        $file = $_FILES['file'];
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            $filename = $file['name'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if ($extension === 'txt') {
                if (!file_exists('files')) {
                    mkdir('files', 0755, true);
                }
                
                $targetPath = 'files/' . basename($filename);
                
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $uploadStatus = 'success';
                    $content = file_get_contents($targetPath);
                    $lines = explode($delimiter, $content);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Processor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Upload TXT File</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file" accept=".txt" required>
        <input type="text" name="delimiter" placeholder="Enter delimiter" required pattern="." title="One character">
        <button type="submit">Upload</button>
    </form>

    <?php if (isset($uploadStatus)): ?>
        <div class="status-circle <?= $uploadStatus ?>"></div>
    <?php endif; ?>

    <?php if (!empty($lines) && $uploadStatus === 'success'): ?>
        <div class="results">
            <h2>Analysis Results:</h2>
            <?php foreach ($lines as $line): ?>
                <?php
                preg_match_all('/\d/', $line, $matches);
                $digitsCount = count($matches[0]);
                $cleanLine = trim($line);
                ?>
                <?php if ($cleanLine !== ''): ?>
                    <p><?= htmlspecialchars($cleanLine) ?> = <?= $digitsCount ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>