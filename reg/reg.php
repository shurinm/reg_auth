<?php
/*регистрация пользователя*/
	include "base.php";	//подключение файла с функциями
	$data = $_POST;	//получаем с формы данные
	/*делаем проверки и в массив ошибок записываем их*/
	if( isset($data['do_signup']))	// если поле do_signup пришло - продолжаем
	{

		$errors = array();	//массив ошибок
		if ( trim($data['nname']) == '') // проверяем имя на пустоту, если пустое в массив записываем ошибку
		{
			$errors[] = 'Введите Имя!';
		}

		if ( trim($data['login']) == '') // проверяем логин на пустоту, если пустое в массив записываем ошибку
		{
			$errors[] = 'Введите логин!';
		}

		if ( trim($data['email']) == '') // проверяем email на пустоту, если пустое в массив записываем ошибку
		{
			$errors[] = 'Введите Email!';
		}

		if ( $data['password'] == '') // проверяем пароль на пустоту, если пустое в массив записываем ошибку
		{
			$errors[] = 'Введите пароль!';
		}

		if ( $data['password_2'] != $data['password']) // сравниваем пароли, если не равны в массив записываем ошибку
		{
			$errors[] = 'Повторный пароль введен не верно!';
		}

		if( countSELECT($data['login'], 'login') )	// проверяем свободен ли логин

		{
			$errors[] = 'Пользователь с таким логином уже существует!';
		}
		if( countSELECT($data['email'], 'email') )	// проверяем используется ли данный email 
		{
			$errors[] = 'Пользователь с таким email уже существует!';
		}

		$tocken = md5($data['email']);	//формируем токен

		if( empty($errors))	//массив ошибок проверяем на пустоту
		{
			/*вызов функции регистрации*/ 
		$reg = pushSELECT($data['nname'], $data['login'], md5($data['password']), $data['email'], $tocken);
		/*при успешной регистрации на почту отправляется письмо с подтверждением и происходит переход на главную страницу*/
		if($reg == true){
			/*вызываем функцию отправки сообщения и выводим пользователю сообщение о успехе или отказе*/
			$otv = message_add(trim($data['email']), trim($data['login']), $tocken);
			echo $otv;
		}else{
			/*ошибка отправки сообщения*/
			$qwe = false;
			echo $qwe;
		}

		} else
		{
			/*выводим ошибку*/
			echo array_shift($errors);
		}
	}
	

?>


