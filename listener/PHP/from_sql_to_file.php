<?php //phpinfo(INFO_MODULES);
	/*		C:/OSPanel/modules/php/PHP-7.1-x64/php.exe from_sql_to_file.php		*/
	echo Hi;
	//����������� � ��
    $mysqli = new mysqli("localhost", "root", "", "h96046yr__base");

    // �������� ���������� 
    if (mysqli_connect_errno()) 
    {
        echo "Connect failed";
        exit();
    }
    
    //����������� ������� �� ���� url ��� ������������ id
    $query = "SELECT url FROM `list_of_url` WHERE id=(SELECT MAX(id) FROM  `list_of_url`)";
    
    if ($stmt = $mysqli->prepare($query)) 
    {

        // ���������� ������� 
        $stmt->execute();

        // �������� ���������� � �������.  bind_result($id,$url) ������ ��� ������� � �������
        $stmt->bind_result($url);

        // ������� ��������
        while ($stmt->fetch()) {
            echo '<h1>'.$url.'</h1>';
            //$_SESSION['url']=$url;
        }
        // ������� ����������
        $stmt->close();
    }
    
    // ������� ��
    $mysqli->close();

?>