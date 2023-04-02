<style>
    <?php include 'style.css'; ?>
</style>

<?php
echo '<table>';
echo '<thead>
<tr>
    <th>Имя</th>
    <th>Фамилия</th>
    <th>Факультет</th>
    <th>Настроение</th>
    <th>Любовь к универу</th>
    <th>Картинка</th>
</tr>
</thead>';
echo '<tr><td>';
$file = implode('---', file('./dates/data.dat'));
$file = str_replace('|', '</td><td>', $file);
$file = str_replace('---', '</td></tr><tr><td>', $file);
echo $file;
echo '</td></tr></table>';
?>