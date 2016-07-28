
<div id="premial">
    <input class="search" type="text" placeholder="Search">


    
    <br><br><br><br><br><table class="table table-striped table-bordered">
        <thead> 
            <tr><th><buttun class="sort" data-sort="id">ID </buttun></th>
            <th><buttun class="sort" data-sort="theme">Автор ▲▼</buttun></th>
            <th><buttun class="sort" data-sort="author">Тема дисертації </buttun></th>
            <th><buttun class="sort" data-sort="year">Рік</buttun></th>
            <th><buttun class="sort asc" datd-sort="number">Додаткова інформація</buttun></th>
			<th><buttun class="sort asc" datd-sort="number">Спеціальність</buttun></th>
            <th><buttun class="sort asc" datd-sort="number">Скачати</buttun></th>
        </tr></thead>
        
<tbody class="list">
			<tr>
			<td>
			<?php
				
				require_once('/settings.php');
				$stm1 = $pdo->prepare("use ksu");
				$stm1->execute();
			
				$stm1 = $pdo->prepare("SELECT COUNT(*) as count FROM `repo_nbuv_math`");
		$stm1->execute();
		$res = $stm1->fetch();
		$count = $res['count'];
		
		$stm1 = $pdo->prepare("SELECT COUNT(*) as count FROM `repo_nbuv_it`");
		$stm1->execute();
		$res = $stm1->fetch();
		$count += $res['count'];
		
		$stm1 = $pdo->prepare("SELECT COUNT(*) as count FROM `repo_nbuv_intelligence`");
		$stm1->execute();
		$res = $stm1->fetch();
		$count += $res['count'];
		
		$stm1 = $pdo->prepare("SELECT COUNT(*) as count FROM `repo_shevchenko`");
		$stm1->execute();
		$res = $stm1->fetch();
		$count += $res['count'];
		
		$stm1 = $pdo->prepare("SELECT COUNT(*) as count FROM `repo_ONPU`");
		$stm1->execute();
		$res = $stm1->fetch();
		$count += $res['count'];
		
		echo "<tr><td>Усього дисертацій:</td> <td>$count</td></tr>";
		
		
		$stm = $pdo->prepare("SELECT * FROM `repo_nbuv_math`");
		$stm->execute();
        echo '<br><tr><td>01.05.02</td><td>Математичне моделювання</td></tr>';
		while ($res=$stm->fetch())
		{
			echo "
				<tr>
					<td class=\"id\">".$res['id']."</td>
					<td class=\"author\">".$res['author']."</td>
					<td class=\"theme\">".$res['title']."</td>
					<td class=\"year\">".$res['year']."</td>
					<td class=\"year\">".$res['info']."</td>
					<td class=\"year\">".$res['speciality']." Математичне моделювання</td>
					<td class=\"year\">".$res['download']."</td>
				</tr> 
			";
        }; 
		
		
		$stm = $pdo->prepare("SELECT * FROM `repo_nbuv_it`");
		$stm->execute();
        echo '<br><tr><td>05.13.23</td><td>Інформаційні технології</td></tr>';
		while ($res=$stm->fetch())
		{
			echo "
				<tr>
					<td class=\"id\">".$res['id']."</td>
					<td class=\"author\">".$res['author']."</td>
					<td class=\"theme\">".$res['title']."</td>
					<td class=\"year\">".$res['year']."</td>
					<td class=\"year\">".$res['info']."</td>
					<td class=\"year\">".$res['speciality']." Інформаційні технології</td>
					<td class=\"year\">".$res['download']."</td>
				</tr> 
			";
        }; 
		
		$stm = $pdo->prepare("SELECT * FROM `repo_nbuv_intelligence`");
		$stm->execute();
        echo '<br><tr><td>05.13.06</td><td>Штучний інтелект</td></tr>';
		while ($res=$stm->fetch())
		{
			echo "
				<tr>
					<td class=\"id\">".$res['id']."</td>
					<td class=\"author\">".$res['author']."</td>
					<td class=\"theme\">".$res['title']."</td>
					<td class=\"year\">".$res['year']."</td>
					<td class=\"year\">".$res['info']."</td>
					<td class=\"year\">".$res['speciality']." Штучний інтелект</td>
					<td class=\"year\">".$res['download']."</td>
				</tr> 
			";
        }; 
		
		$stm = $pdo->prepare("SELECT * FROM `repo_shevchenko`");
		$stm->execute();
        echo '<br><tr><td>Університет</td><td>Шевченка</td></tr>';
		while ($res=$stm->fetch())
		{
			if ($res['speciality'] == '01.05.02') $s = 'Математичне моделювання';
			else if ($res['speciality'] == '05.13.23')  $s = 'Інформаційні технології';
			else $s = 'Штучний інтелект';
			echo "
				<tr>
					<td class=\"id\">".$res['id']."</td>
					<td class=\"author\">".$res['author']."</td>
					<td class=\"theme\">".$res['title']."</td>
					<td class=\"year\">".$res['year']."</td>
					<td class=\"year\">".$res['number']."</td>
					<td class=\"year\">".$s."</td>
					<td class=\"year\"><a ".$res['link'].">Aнотація</a></td>
				</tr> 
			";
        }; 
		
		$stm = $pdo->prepare("SELECT * FROM `repo_ONPU`");
		$stm->execute();
        echo '<br><tr><td>Одеський </td><td>політехнічний</td><td>університет</td></tr>';
		while ($res=$stm->fetch())
		{
				if ($res['speciality'] == '01.05.02') $s = 'Математичне моделювання';
			else if ($res['speciality'] == '05.13.23')  $s = 'Інформаційні технології';
			else $s = 'Штучний інтелект';
			echo "
				<tr>
					<td class=\"id\">".$res['id']."</td>
					<td class=\"author\">".$res['author']."</td>
					<td class=\"theme\"><b>".$res['title']."</b></td>
					<td class=\"year\">".$res['year']."</td>
					<td class=\"year\">".$res['number']."</td>
					<td class=\"year\">".$s."</td>
					<td class=\"year\"><a ".$res['link'].">Aнотація</a></td>
				</tr> 
			";
        }; 
			
				
			?>
			</td>
		</tr>
		</tbody>
    </table>
</div>
<script src="scripts/list.js"></script>
<script>var options = {valueNames: [ 'id', 'theme','author','year', 'number', ]};var premialList = new List('premial', options);</script>
