<?php
if (isset($_GET['error'])) {
    $errCode = $_GET['error'];
    switch ($errCode) {
        case 0:
            $label = LABEL_ERROR_0;
            break;
        case 1:
            $label = LABEL_ERROR_1;
            break;
        case 2:
            $label = LABEL_ERROR_2;
            break;
    }
} else {
    $label = LABEL_ERROR_0;
}
?>

<html>
    <div style="margin-left: auto; margin-right: auto; margin-bottom: auto; margin-top: auto; width: 70%">
        <?php echo '<h1>' . LABEL_ERROR_TITLE . '</h1>'; ?>
        <?php echo '<p>' . $label . '</p>'; ?>
    </div>
</html>