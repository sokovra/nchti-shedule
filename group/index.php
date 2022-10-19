<?php
include '../ops.php';
include '../sql.php';
//change 2022.10.19
?>

<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
<script>
function get_rsp(){
	group = $('#set_group').val();
	$.post('load.php',{group:group},function(rsp){
		$('[week]').html('');
		rsp = rsp.trim();
		rsp = JSON.parse(rsp);
		
		count_rsp = rsp.length;
		
		for(i=0;i<count_rsp;i++){
			week = rsp[i][0];
			time = rsp[i][1];
			pair = rsp[i][2];
			
			if(pair*1!==0){
				
				text_time = $('#for_time').find('div[tim]').eq(time).html();
				
                pair = JSON.parse(pair);
		
				pr_htm = '';
                for(a=0;a<pair.length;a++){
					pr_htm = pr_htm+', '+pair[a]
               
			}
			
			pr_htm = pr_htm.trim()+' ('+text_time+');';
			
			
			 $('#bild_rsp').find('div[week='+week+']').append(pr_htm);
			
		}
		}
	});
}
</script>

<style>
   .none{
	   display:none;
   }
   [week]{
	   display:inline-block;
   }
</style>


Группа: <input value='3812' id='set_group'><input type='submit' value='найти' onclick='get_rsp()'><br>



<div id='bild_rsp'>

Пн: <div week='1'></div><br>
Вт: <div week='2'></div><br>
Ср: <div week='3'></div><br>
Чт: <div week='4'></div><br>
Пт: <div week='5'></div><br>
Сб: <div week='6'></div><br>

</div>

<div class='none' id='for_time'>
<div class='watch'>
    <div tim>8<sup>00</sup>-9<sup>30</sup></div>
    <div tim>9<sup>40</sup>-11<sup>10</sup></div>
    <div tim>11<sup>20</sup>-12<sup>50</sup></div>
    <div tim>13<sup>00</sup>-14<sup>30</sup></div>
    <div tim>14<sup>40</sup>-16<sup>10</sup></div>
    <div tim>16<sup>20</sup>-17<sup>50</sup></div>
    <div tim>18<sup>10</sup>-19<sup>40</sup></div>
    <div tim>19<sup>50</sup>-21<sup>20</sup></div>
</div>
</div>

<font id='inf'></font>


