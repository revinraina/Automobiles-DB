<?php
session_start();

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

require_once "pdo.php";

if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
    $sql = "DELETE FROM autos WHERE auto_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['auto_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index2.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['auto_id']) ) {
    $_SESSION['error'] = "Missing user_id";
    header('Location: index2.php');
    return;
}

$stmt = $pdo->prepare("SELECT make FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index2.php');
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Revin Raina</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
    <p>Confirm: Deleting <?php echo $row['make'] ?></p>
    <form method="post"><input type="hidden" name="auto_id" value="<?php echo $_GET['auto_id'] ?>"> <input
                type="submit" value="Delete"
                name="delete"><a
                href="index2.php">Cancel</a>
    </form>
</div>
</body>
