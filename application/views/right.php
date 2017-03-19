<div class="col-md-8">
	
	<div class="panel panel-default">
	  <div class="panel-heading">
		<h3 class="panel-title">Listado de usuarios</h3>
	  </div>
	  <div class="panel-body">
		<div id="responseright"></div>
		<?php if (empty($all_users)) ; ?>
		<?php if (!empty($all_users))
			{
				echo '<table class="table table-stripped">
				<thead>
				<tr>
				<th>Nombre</th>
				<th>Email</th>
				<th>Teléfono</th>
				<th>Edad</th>';
				
				if (!empty($can_update))
					echo '<th>Actualizar</th>';
				if (!empty($can_delete))
					echo '<th>Borrar</th>';
				
				
				echo '</thead>
				<tbody>';
				
				foreach ($all_users as $user)
				{
					echo '<tr><td class="name">'.$user['name'].'</td><td class="email">'.$user['email'].'</td><td class="phone">'.$user['phone'].'</td><td class="age">'.$user['age'].'</td>';
					if (!empty($can_update))
					{
						echo '<td><button type="button" class="btn btn-primary updateuser" >Actualizar</button>';
						echo '<div class="updateroles">';
						foreach($user['roles'] as $role)
							echo '<span>'.$role.'</span>';
						echo '</div>';
						echo '</td>';
					}
					if (!empty($can_delete))
						echo '<td><button type="button" class="btn btn-primary deleteuser" >Borrar</button></td>';
					
					echo '</tr>';
				}
					
				
				echo '</tbody></table>';
			}
			else
			{
				echo '<div class="margin20"></div> <span class="alert alert-danger">No hay un usuario activo o el usuario activo no tiene permiso de lectura</span> <div class="margin20"></div>';
			}
		?>
	  </div>
	</div>
	
	<script>
		$(".updateuser").click(function () {
			$("#create_edit_form").show();
			$(".titulo").html("Actualizar Usuario");
			$("#update_user_submit").html("Actualizar");
			$("#name").val($(this).closest("tr").find(".name").html());
			$("#email").val($(this).closest("tr").find(".email").html()).prop('disabled', true);
			$("#phone").val($(this).closest("tr").find(".phone").html());
			$("#age").val($(this).closest("tr").find(".age").html());
			
			$(".checkboxinput").each(function() {
				$(this).prop("checked", false);
			});
			$(this).closest("tr").find(".updateroles").find("span").each(function (){
				$("#role"+$(this).html()).prop("checked", true);
			});
			
			if($("#mode").length == 0)
			{
				$('<input>').attr({
					type: 'hidden',
					name: 'mode',
					value: 'update',
					id: 'mode',
				}).appendTo('#update_user');
			}
			else
			{
				$("#mode").val("update");
			}
			
		});
		
		$(".deleteuser").click(function () {
			$.ajax({
				type: "POST",
				url: "<?php echo site_url().'/users/delete_user';?>",
				data: "email=" + $(this).closest("tr").find(".email").html(),
				success: function (data)
				{
					$("#responseright").addClass("alert alert-success").html(jQuery.parseJSON(data).message);
					setTimeout(location.reload.bind(location), 3000);
				},
				error: function(data)
				{
					$("#responseright").addClass("alert alert-danger").html(jQuery.parseJSON(data.responseText).message);
					setTimeout(location.reload.bind(location), 3000);
				}
			});
		});
	</script>
	
</div>