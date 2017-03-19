<div class="col-md-4">
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Usuario activo</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="active_user">Selecciona un usuario:</label>
				<?php 
					$attributes = ['id' => 'active_user'];
					echo form_open('users/activate_user', $attributes); 
				?>
				<select class="form-control" name="active_user" name="PreviousReceiver" onchange="if(this.value != 0) { this.form.submit(); }">
					<option value="none">------------Selecciona Usuario------------</option>
					<?php foreach($user_list as $user):?>
					<option value="<?php echo $user?>" <?php if ($user == $active_user)  echo "selected='selected'"; ?> > <?php echo $user?></option>
					<?php endforeach;?>
				</select>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	
	<?php if (!empty($can_create)) echo '<button type="button" class="btn btn-primary pull-right" id="create">Crear usuario</button> <div class="clearfix"></div>'; ?>
	
	<div class="margin20"></div>
	
	<div class="panel panel-default" id="create_edit_form">
		<div class="panel-heading">
			<h3 class="panel-title titulo">Crear Usuario</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<?php
					$attributes = ['id' => 'update_user'];
					echo form_open('users/update_user', $attributes);
				?>
				<label for="name"><span class="required">*</span>Name:</label>
				<input type="text" class="form-control" id="name" name="name">
				<label for="email"><span class="required">*</span>Email:</label>
				<input type="text" class="form-control" id="email" name="email">
				<label for="phone">Teléfono:</label>
				<input type="text" class="form-control" id="phone" name="phone">
				<label for="age">Edad:</label>
				<input type="text" class="form-control" id="age" name="age">
				<label>Roles:</label>
				<?php foreach ($roles as $key => $role): ?>
					<span class="checkbox marginleft20"><input class="checkboxinput" type="checkbox" value="1" id="role<?php echo $key; ?>" name="role<?php echo $key; ?>"><?php echo $role; ?></span>
				<?php endforeach; ?>
				<?php echo form_close(); ?>
			</div>
			<div id="response"></div>
		</div>
		<div class="panel-footer">
			<button type="button" class="btn btn-primary pull-right" id="update_user_submit">Crear</button>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<script>
	$(document).ready(
    function(){
        $("#create").click(function () {
            $("#create_edit_form").show();
			$(".titulo").html("Crear Usuario");
			$("#update_user_submit").html("Crear");
			
			$(".checkboxinput").each(function() {
				$(this).prop("checked", false);
			});
			$("#email").prop("disabled", false);
			
			if($("#mode").length == 0)
			{
				$('<input>').attr({
					type: 'hidden',
					name: 'mode',
					value: 'create',
					id: 'mode',
				}).appendTo('#update_user');
			}
			else
			{
				$("#mode").val("create");
			}
        });
			
		
		$("#update_user_submit").click(function(event) {
			event.preventDefault();
			
			if (($("#name").val() != "") && ($("#email").val()!= ""))
			{
				$("#email").prop("disabled", false);
				$(this).prop("disabled", true);
				$.ajax({
					type: "POST",
					url: "<?php echo site_url().'/users/update_user';?>",
					data: $('#update_user').serialize(),
					success: function(data)
					{
						$("#response").removeClass().addClass("alert alert-success").html(jQuery.parseJSON(data).message);
						setTimeout(location.reload.bind(location), 3000);
					},
					error: function(data)
					{
						$("#response").addClass("alert alert-danger").html(jQuery.parseJSON(data.responseText).message);
						setTimeout(location.reload.bind(location), 3000);
					}
				});
			}
			else
			{
				$("#response").addClass("alert alert-danger").html("Nombre y email son requeridos para continuar");
			}
			
		});

    });
	
	</script>
	
	
</div>