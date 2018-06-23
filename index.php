<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
header("Content-Type: text/html; charset=utf-8");
require_once 'upload/core.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task manager</title>
</head>
<body>
        <?php if ($allTasks->rowCount() === 0): ?>
            <p style="text-align: center;">Вы пока не добавили ни одной задачи</p>
        <?php else: ?>

            <form method="POST">
                <label>
                    Сортировать по:
                    <select name="sortBy" id="sortBy">
                        <option value="date">Дате добавления</option>
                        <option value="status">Статусу</option>
                        <option value="description">Описанию</option>
                    </select>
                </label>
                <input type="submit" name="sort" id="sort" value="Сортировка">
            </form>

            <table>
                <tr>
                    <td>Задача</td>
                    <td>Статус</td>
                    <td>Дата добавления</td>
                    <td>Действия</td>
                </tr>
                <?php foreach ($allTasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['description']) ?></td>
                        <?php echo htmlspecialchars($task['is_done']) ? '<td style="color: green">Выполнено</td>' : '<td style="color: orange">В процессе</td>' ?>
                        <td><?php echo htmlspecialchars($task['date_added']) ?></td>
                        <td>
                            <p>Изменить </p>
                            <?php if (!$task['is_done']): ?>
                                <p>Выполнить </p>
                            <?php endif; ?>
                            <p class='delete link'>Удалить </p>
                            <input type="hidden" value="<?php echo $task['id'] ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <div class="forms">
        <form method="POST">
            <textarea name="task" placeholder="Задача" id="task" cols="50" rows="3" required></textarea>
            <input type="submit" name="addTask" value="Добавить задачу" class="button">
        </form>
    </div>

</body>
