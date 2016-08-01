<head><link rel = "stylesheet" href = "css/semantic.min.css"> <meta charset = "utf-8"></head>
<div id="premial">
<div class="ui huge icon input" style = "margin-top: 20px;">
  <input class="search" type="text" placeholder="Search">
</div>

		<?php
				
		require_once('/settings.php');

		//$stm1 = $pdo->prepare("use inaeksu_ksu");

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
		

		?>

		Усього дисертацій: <?php echo $count ?>



	<table  id="myTable" class="ui celled table tablesorter">

	


        <thead> 
             
            <tr><th>ID </th>
            <th>Автор</th>
            <th>Тема дисертації</th>
			<th>Тип</th>
            <th>Рік</th>
            <th>Додаткова інформація</th>
			<th>Спеціальність</th>
            <th>Скачати</th>
        
        </tr></thead>
		
        
<tbody>
			
	<?php

				$i = 1;
		//$stm1 = $pdo->prepare("use inaeksu_ksu");
		$stm1 = $pdo->prepare("use ksu");

				
		//$stm1 = $pdo->prepare("use inaeksu_ksu");

		$stm1->execute();
		$stm = $pdo->prepare("SELECT * FROM `repo_nbuv_math`");
		$stm->execute();

		while ($res=$stm->fetch())
		{
			$tmp = explode('/', $res['speciality']);
			echo "
				<tr>
					<td class=\"id\">".$i."</td>
					<td class=\"author\">".$res['author']."</td>
					<td class=\"theme\">".$res['title']."</td>
					<td class=\"theme\">".$tmp[1]."</td>
					<td class=\"year\">".$res['year']."</td>
					<td class=\"year\">".$res['info']."</td>
					<td class=\"year\">Математичне моделювання</td>
					<td class=\"year\">".$res['download']."</td>
				</tr> 
			";
			$i++;
        }; 
		
		
		$stm = $pdo->prepare("SELECT * FROM `repo_nbuv_it`");
		$stm->execute();

		while ($res=$stm->fetch())
		{
			$tmp = explode('/', $res['speciality']);
			echo "
				<tr>
					<td class=\"id\">".$i."</td>
					<td class=\"author\">".$res['author']."</td>
					<td class=\"theme\">".$res['title']."</td>
					<td class=\"theme\">".$tmp[1]."</td>
					<td class=\"year\">".$res['year']."</td>
					<td class=\"year\">".$res['info']."</td>
					<td class=\"year\">Інформаційні технології</td>
					<td class=\"year\">".$res['download']."</td>
				</tr> 
			";
			$i++;
        }; 
		
		$stm = $pdo->prepare("SELECT * FROM `repo_nbuv_intelligence`");
		$stm->execute();
		while ($res=$stm->fetch())
		{
			$tmp = explode('/', $res['speciality']);
			echo "
				<tr>
					<td class=\"id\">".$i."</td>
					<td class=\"author\">".$res['author']."</td>
					<td class=\"theme\">".$res['title']."</td>
					<td class=\"theme\">".$tmp[1]."</td>
					<td class=\"year\">".$res['year']."</td>
					<td class=\"year\">".$res['info']."</td>
					<td class=\"year\">Штучний інтелект</td>
					<td class=\"year\">".$res['download']."</td>
				</tr> 
			";
			$i++;
        }; 
	
		
      
		
		$stm = $pdo->prepare("SELECT * FROM `repo_shevchenko`");
		$stm->execute();
		while ($res=$stm->fetch())
		{
			$tmp = explode('/', $res['number']);
			if ($res['number'] == '01.05.02') $s = 'Математичне моделювання';
			else if ($res['number'] == '05.13.23')  $s = 'Інформаційні технології';
			else $s = 'Штучний інтелект';
			echo "
				<tr>
					<td>".$i."</td>
					<td>".$res['author']."</td>
					<td>".$res['title']."</td>
					<td class=\"theme\">".$tmp[1]."</td>
					<td>".$res['year']."</td>
					<td>Київський національний університет імені Тараса Шевченка</td>
					<td>".$s."</td>
					<td><a ".$res['link'].">Aнотація</a></td>
				</tr> 
			";
			$i++;
        }; 
		
	
	
		$stm = $pdo->prepare("SELECT * FROM `repo_ONPU`");
		$stm->execute();


		

		while ($res=$stm->fetch())
		{
			$tmp = explode('/', $res['number']);
				if ($res['number'] == '01.05.02') $s = 'Математичне моделювання';
			else if ($res['number'] == '05.13.23')  $s = 'Інформаційні технології';
			else $s = 'Штучний інтелект';
			echo "
				<tr>
					<td class=\"id\">".$i."</td>
					<td class=\"author\">".$res['author']."</td>
					<td class=\"theme\">".$res['title']."</td>
					<td class=\"theme\">".$tmp[1]."</td>
					<td class=\"year\">".$res['year']."</td>
					<td class=\"year\">Одеський національний технічний університет</td>
					<td class=\"year\">".$s."</td>
					<td class=\"year\"><a ".$res['link'].">Aнотація</a></td>
				</tr> 
			";
			$i++;
        }; 
			
				
			?>
	
		</tbody>
    </table>
</div>
<script type="text/javascript" src="scripts/jquery.min.js"></script> 
<script type="text/javascript" src="scripts/jquery.tablesorter.js"></script>
<script>

	$(document).ready(function() 
    { 
        $("#myTable").tablesorter( {sortList: [[0,0], [1,0]]} ); 
    } 
); 
    
</script>
