<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['data'])) {
    // Використовуємо htmlspecialchars для уникнення XSS атак
    $data = htmlspecialchars($_POST['data'], ENT_QUOTES, 'UTF-8');

    try {
        // Підключення до бази даних через PDO
        $dsn = 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME');
        $pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWORD'));

        // Встановлюємо атрибути для PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Підготовка запиту
        $stmt = $pdo->prepare("INSERT INTO requests_log (data) VALUES (:data)");
        $stmt->bindParam(':data', $data);

        // Виконання запиту
        if ($stmt->execute()) {
            echo "Data inserted successfully";
        } else {
            echo "Error: Data could not be inserted";
        }
    } catch (PDOException $e) {
        // Обробка помилок
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo "Send a POST request with 'data' parameter.";
}