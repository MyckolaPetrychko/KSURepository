<head><link rel = "stylesheet" href = "css/semantic.min.css"></head>
<div id="premial">
<div class="ui huge icon input" style = "margin-top: 20px;">
  <input class="search" type="text" placeholder="Search">
</div>

 

  <table class="ui celled table">
  
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
		
		echo "<tr><td>Усього дисертацій:</td> <td>$count</td><td></td><td></td><td></td><td></td><td></td></tr>";
		?>
  
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
			
			<?php
				
				require_once('/settings.php');
				$stm1 = $pdo->prepare("use ksu");
				$stm1->execute();		
		$stm = $pdo->prepare("SELECT * FROM `repo_nbuv_math`");
		$stm->execute();
        echo '<br><tr><td>01.05.02</td><td>Математичне моделювання</td><td></td><td></td><td></td><td></td><td></td></tr>';
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
        echo '<br><tr><td>05.13.23</td><td>Інформаційні технології</td><td></td><td></td><td></td><td></td><td></td></tr>';
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
        echo '<tr><td>05.13.06</td><td>Штучний інтелект</td><td></td><td></td><td></td><td></td><td></td></tr>';
		echo '';
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
        echo '<tr><td>Університет</td><td>Шевченка</td><td></td><td></td><td></td><td></td><td></td></tr>';
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
        echo '<tr><td>Одеський </td><td>політехнічний</td><td>університет</td><td></td><td></td><td></td><td></td></tr>';
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
	
		</tbody>
    </table>
</div>
<script src="scripts/list.js"></script>
<script>var options = {valueNames: [ 'id', 'theme','author','year', 'number', ]};var premialList = new List('premial', options);</script>
