<?php
require_once 'config.php';
require_once 'DatabaseConnection.php';
require_once 'UserRepository.php';
require_once 'SendSurvey.php';

$user_id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $db = new DatabaseConnection($GLOBALS['host'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
    $userRepository = new UserRepository($db);

    if (!$userRepository->userExists($user_id)) {
        echo "Пользователь не найден";
    } else {

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Оставьте отзыв</title>
        </head>
        <body>
            <h2>Оставьте отзыв</h2>
            <form action="index.php" method="post">

			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

			<input type="radio" id="mark5" name="mark" value="5" />
			<label for="mark5">5</label><br>

			<input type="radio" id="mark4" name="mark" value="4" />
			<label for="mark4">4</label><br>

			<input type="radio" id="mark3" name="mark" value="3" />
			<label for="mark3">3</label><br>

			<input type="radio" id="mark2" name="mark" value="2" />
			<label for="mark2">2</label><br>

			<input type="radio" id="mark1" name="mark" value="1" />
			<label for="mark1">1</label><br>

			<label for="text">Оставьте комментарий к отзыву:</label><br>
			<textarea id="text" name="text" rows="4" cols="50"></textarea><br>
			
			<input type="submit" value="Отправить">
			</form>
        </body>
        </html>
        <?php
    }
	$db->closeConnection();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['id'];
    $mark = $_POST['mark'];
    $text = $_POST['text'];

    $db = new DatabaseConnection($GLOBALS['host'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
    $SendSurvey = new SendSurvey($db);

    if ($SendSurvey->insertData($user_id, $mark, $text)) {
        echo '<script>alert("Данные успешно сохранены");</script>';
    } else {
        echo "Произошла ошибка";
    }

    $db->closeConnection();
}
?>