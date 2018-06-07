<?php
//Подскажите нужно создать базу на основе кода которые вы показывали с транзакциями? в один файл или нужно создавать дополнительные папки
//или хватит index.php?
define('DB_DRIVER','mysql');
define('DB_HOST','localhost');
define('DB_NAME','tasks');
define('DB_USER','root');
define('DB_PASS','');

try
{
	$connect_str = DB_DRIVER . ':host='. DB_HOST . ';dbname=' . DB_NAME;
	$db = new PDO($connect_str,DB_USER,DB_PASS);
 
	$rows = $db->exec("CREATE TABLE `tasks`(
		id INT PRIMARY KEY AUTO_INCREMENT,
		fname VARCHAR(20) NOT NULL DEFAULT '',
		email VARCHAR(50) NOT NULL DEFAULT '',
		money INT NOT NULL DEFAULT 0) ENGINE=InnoDB;");
 
	$rows = $db->exec("INSERT INTO `tasks` VALUES
		(null, 'Ivan', 'ivan@test.com', 15000),
		(null, 'Petr', 'petr@test.com', 411000),
		(null, 'Vasiliy', 'vasiliy@test.com', 1500000)
	");
 
	
	$summ = 50000;
 
	$transaction = true;           
 
	$db->beginTransaction();
 
	$sth1 = $db->query("SELECT money FROM testing WHERE fname='Ivan'");
	$sth2 = $db->query("SELECT money FROM testing WHERE fname='Petr'");
	$row1 = $sth1->fetch();
	$row2 = $sth2->fetch();
 
	if(!$row1 || !$row2) $transaction = false;
 
	$total2 = $summ + $row2['money'];
	$total1 = $row1['money'] - $summ;
 
	if($total1 < 0 || $total2 < 0) $transaction = false;
 
	$num_rows1 = $db->exec("UPDATE `testing` SET money='" . $total1 . "' WHERE fname='Ivan'");
	$num_rows2 = $db->exec("UPDATE `testing` SET money='" . $total2 . "' WHERE fname='Petr'");
 
	if($transaction)
	{
    if($db->commit())
    		echo "Транзакция успешно прошла";
	}
	else
	{
		echo "Транзакция не прошла";
		$db->rollback();
	}
}
catch(PDOException $e)
{
	die("Error: ".$e->getMessage());
}
//свой код (черновик)
$task = new Tasks;
$allTasks = $tasks->getAllTasks(); 

if (!empty($_POST['addTasks'])) {
    $tasks->addTasks();
    echo $tasks->getLastTasks();
}
if (!empty($_POST['done'])) {
    echo $tasks->setTaskIsDone() ? 'Выполнено' : 'В процессе';
}
if (!empty($_POST['delete'])) {
    $task->deleteTask();
}
if (!empty($_POST['editDescription'])) {
    echo $task->editTasks();
}
if (!empty($_POST['sortBy'])) {
    $table = new TasksTable;
    echo $table->sortTable($_POST['sortBy']);
}
