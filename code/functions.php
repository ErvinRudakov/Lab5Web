<?php
function connectDatabase(array $connectionData)
{
    $mysqli = new mysqli($connectionData['hostname'], $connectionData['username'], $connectionData['password'], $connectionData['database']);

    if (mysqli_connect_errno())
    {
        printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
        exit;
    }

    return $mysqli;
}

function hasNeededParametersToAddAd(array $request): bool
{
    return array_key_exists('email', $request)
        && array_key_exists('category', $request)
        && array_key_exists('header', $request)
        && array_key_exists('content', $request)
        ;
}

function addAd(mysqli $database, array $data)
{
    $query = "INSERT INTO ad (EMAIL, TITLE, DESCRIPTION, CATEGORY) VALUES ('{$data['email']}', '{$data['header']}', '{$data['content']}', '{$data['category']}')";
    $database->query($query);
}

function printForm(array $categories)
{
    echo '<form action="" method="post">
		<p>Введите email<p>
    	<input type="email" name="email"/>
    	<p>Выберите категорию<p>
    	<select name="category">'
        . getCategoryOptionsForSelectField($categories) .
        '</select>
    	<p>Введите заголовок объявления<p>
    	<input type="text" name="header"/>
    	<p>Введите текст объявления<p>
    	<textarea rows="10" cols="40" name="content"></textarea>
    	<input type="submit" value="Отправить">
  	  </form>';
}

function getCategoryOptionsForSelectField(array $categories): string
{
    $categoryOptionsForSelectField = '';
    foreach ($categories as $category)
    {
        $categoryOptionsForSelectField .= "<option>$category</option>";
    }

    return $categoryOptionsForSelectField;
}

function getAds(mysqli $database): array
{
    $ads = [];
    $query = 'SELECT * FROM ad ORDER BY CREATED DESC';
    $result = $database->query($query);
    if ($result)
    {
        while ($row = $result->fetch_assoc())
        {
            $ads[] = $row;
        }

        $result->close();
    }

    return $ads;
}

function printAds($ads)
{
    $tableContent = '';

    print("Ads:\n");
    foreach ($ads as $ad)
    {
        $tableContent .=
            '<tr>
				<td>'.htmlspecialchars($ad['EMAIL']).'</td>
				<td>'.htmlspecialchars($ad['CATEGORY']).'</td>
				<td>'.htmlspecialchars($ad['TITLE']).'</td>
				<td>'.htmlspecialchars($ad['DESCRIPTION']).'</td>
			</tr>'
        ;
    }

    echo '<table border="1">
  			<tr>
			<th>E-Mail</th>
    		<th>Категория</th>
			<th>Заголовок</th>
    		<th>Текст</th>
  			</tr>
  			'.$tableContent.'
		  </table>';
}