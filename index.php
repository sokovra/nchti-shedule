<?php
include 'ops.php';
?>


<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
<script>

function add_row(){
    $("#what_do").text('row');
}

function add_string(){
    $("#what_do").text('string');
}

function del_row(){
    $("#what_do").text('del_row');
}

function del_string(){
    $("#what_do").text('del_string');
}

function fill(){
    $("#what_do").text('fill');
}

function share(){
    $("#what_do").text('share');
}

function unshare(){
    $("#what_do").text('unshare');
}

function hasattr(attr){
    if(typeof attr !== typeof undefined && attr !== false){
            return true;
        }else{
            return false;
        }
}




function save_tbl(){
	$('#week').find('[cp]').remove();
    count_groups = $('#week').find('tr').eq(0).find('td').length;

     error = 'false';
     for(i=2;i<count_groups;i++){
        text = $('#week').find('tr').eq(0).find('td').eq(i).find('.writ').text();
    
        if(text*1==0){
        error = 'true';
    }
    }

    //being_groups = 1;

	name = $('#project_name').val();
	
	if((error!=='true')&(name!=='')&(/[a-zA-Z0-9]/.test(name))){
	
    count_tr = $('#week').find('tr').length;
   
    count_row = $('#week').find('tr').eq(0).find('td').length;

    $('#inf_tbl').text('');
	
	groups = '';
	
	send = [];
	
	 for(i=2;i<count_row;i++){
		group = $('#week').find('tr').eq(0).find('td').eq(i).find('.writ').text();
		groups = groups+group+' ';
	 }
	groups = groups.slice(0,-1);

    for(i=2;i<count_row;i++){

        group = $('#week').find('tr').eq(0).find('td').eq(i).find('.writ').text();

		col_time = $("#for_time").find('.watch').find('div').length;

		//$("#inf").text(col_time);

        for(a=1;a<count_tr;a++){

        findmajor = $('#week').find('tr').eq(a).find('td').eq(0).attr('major');

            if(hasattr(findmajor)){
                time_i = 1;
                eq = i;
            }else{
                time_i-1;
                eq = i-1;
                }

        pair_count = $('#week').find('tr').eq(a).find('td').eq(eq).find('.writ').length;
        
                writ = [];
                for(b=0;b<pair_count;b++){
                    writ.push($('#week').find('tr').eq(a).find('td').eq(eq).find('.writ').eq(b).html());
				}
				
				if(writ[0]!==''){
				
				pair = JSON.stringify(writ);}else{
					pair = '';
				}
    

        time = $('#week').find('tr').eq(a).find('td[time]').attr('id_time');
        week = $('#week').find('tr').eq(a).attr('week');

        //$('#inf_tbl').append('группы:'+groups+', группа: '+group+' неделя: '+week+' время: '+time+' предмет: '+pair+'<br>');
		
		
		for_send = [name,groups,group,week,time,pair];
		
		send.push(for_send);
	
		
		//$('#inf_tbl').append(for_send+"<br>");
		
        }

    }
send = JSON.stringify(send);


$('#inf_tbl').text('<?=$e[2]?>');


$.post('base.php',{send:send},function(base){
	if(base==1){
		$('#inf_tbl').text('<?=$e[1]?>');
        send = JSON.parse(send);
	}
});

//$('#inf_tbl').text(send);
}else{
    op('<?=$e[0]?>');
}
}


function op(o){
    $('#inf_tbl').text(o);
}


function correct_times(){
	col_time = $("#for_time").find('.watch').find('div').length;
	
	och = $('#och option:selected').attr('och');
	
	count_tr = $("#week").find('tr[week]').last().attr('week')-(-1);
	for(i=1;i<count_tr;i++){
		count_this_week_tr = $("#week").find('tr[week='+i+']').length;
		
		if(och == 0){
			aa = 0;
		}else if(och == 1){
			aa = 6;
		}
		
		for(a=0;a<count_this_week_tr;a++){
			time = $("#for_time").find('.watch').find('div').eq(aa).html();
			
			$("#week").find('tr[week='+i+']').eq(a).find('td[time]').eq(0).html(time);
			
			$("#week").find('tr[week='+i+']').eq(a).find('td[time]').eq(0).attr('id_time',aa);
			aa++;
			if(aa==col_time){break;}
		}
	}
	//$("#inf").text(och);
}


$(function(){
	
	
	$("#och").bind('change',function(){
		correct_times();
	});
	
	correct_times();
	
	
    $('.writ').attr('contenteditable','true');
   
    /*$("#week").on('mousedown','.down_size',function(){
      
        bottom = $(this).closest('td').find('.writ').css('margin-bottom').replace('px','');

        bottom = bottom-10;
        $(this).closest('td').find('.writ').css('margin-bottom',bottom+'px');
        $(this).closest('td').find('.wri').focus();
   });*/

   /*$("#week").on('mousedown','.up_size',function(){
      
      bottom = $(this).closest('td').find('.writ').css('margin-bottom').replace('px','');

      bottom = bottom-(-10);
      $(this).closest('td').find('.writ').css('margin-bottom',bottom+'px');
 });*/


 
	$('#week').on('click',"[cp]",function(){
		
		cp = $(this).attr('cp');
		
		this_eq = $(this).closest('td').index();
		
		this_tr_eq = $(this).closest('tr').index();
		
		this_html = $(this).closest('td').html();
		
		if(this_tr_eq>0){
		
		if(cp=='right'){
			$(this).closest('tr').find('td').eq(this_eq-(-1)).html(this_html);
		}else if(cp=='left'){
			$(this).closest('tr').find('td').eq(this_eq-1).html(this_html);
		}else if(cp=='up'){
			find_maj_this_el = $(this).closest('tr').find('td').eq(0).attr('major');
	
			if(!hasattr(find_maj_this_el)){
				this_td_eq = this_eq;
			}else{
				this_td_eq = this_eq-1;
			}
			
			find_maj_up_el = $(this).closest('table').find('tr').eq(this_tr_eq-1).find('td').eq(0).attr('major');
			
			if(!hasattr(find_maj_up_el)){
				up_td_eq = this_td_eq;
			}else{
				up_td_eq = this_td_eq-(-1);
			}
			
			$(this).closest('table').find('tr').eq(this_tr_eq-1).find('td').eq(up_td_eq).html(this_html);
			
		}else if(cp=='down'){
			find_maj_this_el = $(this).closest('tr').find('td').eq(0).attr('major');
		
			if(!hasattr(find_maj_this_el)){
				this_td_eq = this_eq;
			}else{
				this_td_eq = this_eq-1;
			}
			find_maj_down_el = $(this).closest('table').find('tr').eq(this_tr_eq-(-1)).find('td').eq(0).attr('major');
			if(!hasattr(find_maj_down_el)){
				down_td_eq = this_td_eq;
			}else{
				down_td_eq = this_td_eq-(-1);
			}
			$(this).closest('table').find('tr').eq(this_tr_eq-(-1)).find('td').eq(down_td_eq).html(this_html);	
		}
		}
	});
 
 
 
 
    $("#week").on('click','.writ',function(){
        week =  $(this).closest('tr').attr('week');

        what_do = $("#what_do").text();
        if(what_do=='share'){
            if(week>0){
                $(this).after('<div contenteditable=true class=writ>&nbsp;&nbsp;</div>');
            }
        }else if(what_do=='unshare'){
            if($(this).parent('td').find('.writ').length>1){
            $(this).remove();
        }}
        $('#what_do').text('');
    });


	
	
	$("#week").on('focus','.writ',function(){
		 what_do = $("#what_do").text();
		
		this_tr_eq = $(this).closest('tr').index();
		
		if(what_do=='fill'){
			
		$(this).closest('table').find('[cp]').remove();
	
			if(this_tr_eq>0){
				$(this).closest('td').append("<div cp='up'>↑</div><div cp='down'>↓</div><div cp='right'>→</div><div cp='left'>←</div>");
			}
		}
		
	});
	
	
	

    $("#week").on('click','td',function(){
	
        what_do = $("#what_do").text();

        index = $(this).index();

        findmajor = $(this).parent('tr').find('td').eq(0).attr('major');

        if(hasattr(findmajor)){
            index--;
        }

        thismajor = $(this).attr('major');


        week =  $(this).parent('tr').attr('week');


        if(what_do=='row'){

        if(!hasattr(thismajor)){

        count_tr = $(this).closest("table").find("tr").length;
        

        for(i=0;i<count_tr;i++){

            findmajor =  $(this).closest("table").find("tr").eq(i).find("td").eq(0).attr('major');

            if(typeof findmajor !== typeof undefined && findmajor !== false){
                eq = index-(-1);
            }else{
                eq = index;
                }

           
            $(this).closest("table").find("tr").eq(i).find('td').eq(eq).after('<td><div contenteditable=true class=writ></div></td>');
        }

        $("#inf").text(count_tr);
        }
        }else if(what_do=='string'){
			
			col_time = $("#for_time").find('.watch').find('div').length;

			last_id_time = $(this).closest('table').find('tr[week='+week+']').last().find('td').eq(0).attr('id_time');

			findmajor = $(this).attr('major');

            this_week_count = $(this).closest('table').find('tr[week='+week+']').length;

            //$('#inf').text(this_week_count);

			if((((last_id_time-(-1)<col_time)&(!hasattr(findmajor)))||(this_week_count==1))&(week>0)){

			count_row = $(this).closest('table').find('tr[week='+week+']').eq(0).find('td').length-1;

            rowspan_week = $(this).closest('table').find('tr[week='+week+']').eq(0).find('td').eq(0).attr('rowspan');

            if(!hasattr(rowspan_week)){
                rowspan_week=1; 
            }

            $(this).closest('table').find('tr[week='+week+']').eq(0).find('td').eq(0).attr('rowspan',rowspan_week-(-1));

            tds = '';

            for(i=0;i<count_row;i++){
                if(i==0){tdattr = 'time';}else{tdattr = '';}
                tds = tds+'<td '+tdattr+'><div contenteditable=true class=writ></div></td>';
            }


            
            $(this).closest('tr').after('<tr week='+week+'>'+tds+'</tr>');
			
			correct_times();
            }
         }else if(what_do == 'del_row'){

        this_tr_index = $(this).parent('tr').index();
            
            
            if(!hasattr(thismajor)){
                if(index>=1){
            count_tr = $(this).closest("table").find("tr").length;

            for(i=0;i<count_tr;i++){

            findmajor =  $(this).closest("table").find("tr").eq(i).find("td").eq(0).attr('major');

            if(!hasattr(findmajor)){
            eq = index;
            }else{
             eq = index-(-1);
            }


            if(i !== this_tr_index){
            $(this).closest("table").find("tr").eq(i).find("td").eq(eq).remove();
            }
            }

            $(this).remove();
             $("#inf").text(count_tr);
             }}

         }else if(what_do=='del_string'){
            

            hasmaj = $(this).parent('tr').find('td').eq(0).attr('major');

            if(!hasattr(hasmaj)){
               
            num_string = $(this).parent('tr').index();


            rowspan_week = $(this).closest('table').find('tr[week='+week+']').eq(0).find('td').eq(0).attr('rowspan');

            $(this).closest('table').find('tr[week='+week+']').eq(0).find('td').eq(0).attr('rowspan',rowspan_week-1);

            
            $(this).closest('table').find('tr').eq(num_string).remove();
            }
         }
         correct_times();

         
         $("#what_do").text('fill');
    });
});

function to_pdf(){

    first_html_from_tbl = $("#week").html();




	$('#week').find('[cp]').remove();
	
	count_row = $("#week").find('tr').eq(0).find('td').length;
	count_str = $("#week").find('tr').length;
	
	for(i=1;i<count_str;i++){
		
		for(a=2;a<count_row;a++){
			
			if(typeof old_txt == "undefined"){
			old_txt = 'sdfasdf';
			
		}
			
			findmajor =  $("#week").find("tr").eq(i).find('td').eq(0).attr('major');
			
			if(!hasattr(findmajor)){
            eq = a-1;
            }else{
             eq = a;
            }
			
		new_txt = $("#week").find('tr').eq(i).find('td').eq(eq).text();
		
		if((old_txt==new_txt)&(old_txt*1!==0)){
			old_colspan = $("#week").find('tr').eq(i).find('td').eq(eq-1).attr('colspan');
			
			if(!hasattr(old_colspan)){
				old_colspan = 1;
			}
			
			$("#week").find('tr').eq(i).find('td').eq(eq-1).attr('colspan',old_colspan-(-1));
			
			a--;
			
			$("#week").find('tr').eq(i).find('td').eq(eq).remove();
		}
		old_txt = new_txt;
		}
	}
	
	for(i=2;i<count_row;i++){
			
	for(a=1;a<count_str;a++){
				if(typeof old_txt == "undefined"){
				old_txt = 'sdfasdf';
				//old_eq = 2;
				}
				
				if((typeof minus_eq == "undefined")||(minus_eq=='')){
					minus_eq = 1;
				}
				
		findmajor =  $("#week").find("tr").eq(a).find('td').eq(0).attr('major');
			
		if(!hasattr(findmajor)){
        eq = i-1;
        }else{
        eq = i;
        }
		
		old_e = $("#week").find('tr').eq(a-minus_eq).find('td').eq(0).attr('major');
			
			if(!hasattr(old_e)){
				old_eq = i-1;
			}else{
				old_eq = i;
			}
				
	new_txt = $("#week").find('tr').eq(a).find('td').eq(eq).text();
	
	if((old_txt==new_txt)&(old_txt*1!==0)){
		old_rowspan = $("#week").find('tr').eq(a-minus_eq).find('td').eq(old_eq).attr('rowspan');
		
		old_colspan = $("#week").find('tr').eq(a-minus_eq).find('td').eq(old_eq).attr('colspan');
		
		new_colspan = $("#week").find('tr').eq(a).find('td').eq(eq).attr('colspan');
		
		if(!hasattr(old_colspan)){
				old_colspan = 1;
			}
		
		if(!hasattr(new_colspan)){
				new_colspan = 1;
			}
		
		if(!hasattr(old_rowspan)){
				old_rowspan = 1;
			}
			if(old_colspan==new_colspan){
					
			old_rowspan = old_rowspan-(-1);
			
			$("#week").find('tr').eq(a-minus_eq).find('td').eq(old_eq).attr('rowspan',old_rowspan);
			
			$("#week").find('tr').eq(a).find('td').eq(eq).hide();
			
			}
			
			//if(old_colspan>1){
			//a=a-(-old_colspan)-2; //разобраться
			//}
			
			minus_eq = old_rowspan;
			
	}else{
        minus_eq = '';
    }
	
	old_txt = new_txt;
	
		}
	}
	
	$('input').hide();

    last_html_from_tbl = $("#week").html();

    $("#week").html(first_html_from_tbl);

    tbl = "<table id='tbl_to_pdf' border=1>"+last_html_from_tbl+"</table>";

    project_name = $('#project_name').val();


    $.post('topdf.php',{tbl:tbl,project_name:project_name},function(inf){

        window.open(inf, '_blank');

        $('#inf').html(inf);
    });


}
</script>

<style>
	[cp]{
		width:13px;
		height:13px;
		border:solid 1px;
		position:absolute;
		background:#FFEBCD;
		z-index:5;
		cursor:pointer;
		font-size:10px;
	}
	[cp]:hover{
		background:silver;
		transition:.2s;
	}
	[cp='down']{
		bottom:-15px;
		right:20px;
	}
	
	[cp='up']{
		top:-15px;
		left:20px;
	}
	
	[cp='left']{
		top:20px;
		left:-15px;
	}
	
	[cp='right']{
		bottom:20px;
		right:-15px;
	}

	*{
		font-family: sans-serif;
	}
    #week{
        border-collapse: collapse;
        z-index:3;
    }
   #week td{
        height:30px;
        text-align:center;
        overflow:visible;
        padding:5px;
        position:relative;
    }
    .writ{
        display:inline-block;
        max-width:150px;
        text-align:center;
        padding:0px;
        background:white;
        margin:9px;
        margin-bottom:5px;
        z-index:5;
        position:relative;
    }
    .none{
        display:none;
    }
</style>

<input onclick='add_row()' value='добавить столбец' type='submit'>
<input onclick='del_row()' value='удалить столбец' type='submit'>

<input onclick='add_string()' value='добавить строку' type='submit'>
<input onclick='del_string()' value='удалить строку' type='submit'>

<input onclick='share()' value='добавить ячейку' type='submit'>
<input onclick='unshare()' value='убрать ячейку' type='submit'>

<br><br>
<input value='в документ' type='submit' onclick='to_pdf()'>
<br><br>

Имя проекта: <input id='project_name' value='3812 3811' placeholder='Имя проекта'>


<input onclick='save_tbl()' type='submit' value='Сохранить' id='SaveTbl'>
<input onclick='load_tbl()' type='submit' value='Открыть' id='LoadTbl'><br>
<br>

<div id='inf_tbl'>информационая таблица</div>

<br>


<select id='och'>
    <option och=0>Очное</option>
    <option och=1>Вечернее</option>
</select><br><br>

<table class='non' border='1' id='week'>

<tr week=0>
    <td major>Нед\Гр</td><td>Время</td><td><div class='writ'></div></td>
</tr>

<tr week=1>
    <td major rowspan='2'>Пн</td><td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=1>
    <td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=2>
    <td major rowspan='2'>Вт</td><td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=2>
    <td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=3>
    <td major rowspan='2'>Ср</td><td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=3>
    <td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=4>
    <td major rowspan='2'>Чт</td><td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=4>
    <td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=5>
    <td major rowspan='2'>Пт</td><td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=5>
    <td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=6>
    <td major rowspan='2'>Сб</td><td time>1</td><td><div class='writ'></div></td>
</tr>

<tr week=6>
    <td time>1</td><td><div class='writ'></div></td>
</tr>


</table><br>


<table class='none' border='1' id='bild_tbl'>
<tr week=0>
<td major>Нед\Гр</td><td>Время</td>
</tr>
<tr week=1>
    <td major rowspan='1'>Пн</td>
</tr>
<tr week=2>
    <td major rowspan='1'>Вт</td>
</tr>
<tr week=3>
    <td major rowspan='1'>Ср</td>
</tr>
<tr week=4>
    <td major rowspan='1'>Чт</td>
</tr>
<tr week=5>
    <td major rowspan='1'>Пт</td>
</tr>
<tr week=6>
    <td major rowspan='1'>Сб</td>
</tr>
</table>


<script>
    function load_tbl(){
    
    pr_name = $('#project_name').val();
        $.post('load.php',{'pr_name':pr_name},function(base){


            tbls = base.slice(1);

            //$('#inf').text(tbls);

            for_bild = $('#bild_tbl').html();

            tbls = JSON.parse(tbls);
            
            groups = tbls[0][1];

            first_time = tbls[0][4];

            groups = groups.split(' ');

            gr_count = groups.length;


            for(i=0;i<gr_count;i++){
                $('#bild_tbl').find('tr').eq(0).append("<td><div contenteditable class='writ'>"+groups[i]+"</div></td>");
            }
    
            for(i=0;i<tbls.length;i++){

                el_week = tbls[i][3];
                pair = tbls[i][5];
                group = tbls[i][2];
                time = tbls[i][4];

               pair_dv = '';

                if(pair*1!==0){

                pair = JSON.parse(pair);

                for(a=0;a<pair.length;a++){
                    pair_dv = pair_dv+"<div contenteditable class='writ'>"+pair[a]+"</div>";
                }
                }else{
                    pair_dv = "<div contenteditable class='writ'></div>";
                }
               

                rowspan = $('#bild_tbl').find('[week='+el_week+']').find('td').eq(0).attr('rowspan');


               if(group==tbls[0][2]){
                    if(time>first_time){
                         $('#bild_tbl').find('[week='+el_week+']').find('td').eq(0).attr('rowspan',rowspan-(-1));


                    $('#bild_tbl').find('[week='+el_week+']').last().after('<tr week='+el_week+'><td id_time='+time+' time>'+time+'</td><td>'+pair_dv+'</td></tr>');
                    }else{
                         $('#bild_tbl').find('[week='+el_week+']').last().append('<td id_time='+time+' time>'+time+'</td><td>'+pair_dv+'</td>');
                    }
                }else{
                    $('#bild_tbl').find('[week='+el_week+']').find('[id_time='+time+']').parent('tr').find('td').last().after('<td>'+pair_dv+'</td>');
                }

                
            }

            inner_bild_tbl = $("#bild_tbl").html();
            $("#week").html(inner_bild_tbl);



            if(first_time==0){
                $('#och option[och=0]').attr("selected", "selected");
            }else if(first_time==6){
                $('#och option[och=1]').attr("selected", "selected");
            }

            correct_times();
            $("#bild_tbl").html(for_bild);
            
        });

        
    }

    //for_send = [name,groups,group,week,time,pair];
</script>





inf: <font id='inf'></font>
операция: <font id='what_do'></font><br>




<style>

#for_time{
   display:none;
}

</style>


<div id='for_time'>
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


<div id='now_time'></div>

