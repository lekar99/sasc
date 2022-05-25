<?php

if( isset( $_GET[ 'Submit' ] ) ) {
    // Проверка Anti-CSRF токена
    checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'index.php' );

    // Получаем id
    $id = $_GET[ 'id' ];

    // Проверка было ли введено число
    if(is_numeric( $id )) {
        // Проверяем бд
        $data = $db->prepare( 'SELECT first_name, last_name FROM users WHERE user_id = (:id) LIMIT 1;' );
        $data->bindParam( ':id', $id, PDO::PARAM_INT );
        $data->execute();

        // Получаем результат
        if( $data->rowCount() == 1 ) {
            // Выводим сообщение пользователю
	    $html .= '<pre>User ID exists in the database.</pre>';
        }
        else {
            // Пользователь не был найден
            header( $_SERVER[ 'SERVER_PROTOCOL' ] . ' 404 Not Found' );

            // Выводим сообщение
            $html .= '<pre>User ID is MISSING from the database.</pre>';
        }
    }
}

// Генерируем Anti-CSRF токен
generateSessionToken();

?> 