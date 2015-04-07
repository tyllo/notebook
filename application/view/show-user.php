<!-- show user -->
<!-- ############# name ################ -->
<div class="row collapse">
	<div class="small-1 columns">
		<span class="prefix"><i class="fa fa-user fa-fw"></i></span>
	</div>
	<div class="small-11 medium-3 columns">
		<input name="name" type="text" placeholder="Имя" value="<?=$contact_name?>" required disabled>
	</div>

	<div class="small-1 show-for-small columns">
		<span class="prefix"><i class="fa fa-user"></i></span>
	</div>
	<div class="small-11 medium-4 columns">
		<input name="surname" type="text" placeholder="Фамилия" value="<?=$contact_surname?>" required disabled>
	</div>

	<div class="small-1 show-for-small columns">
		<span class="prefix"><i class="fa fa-user"></i></span>
	</div>
	<div class="small-11 medium-4 columns">
		<input name="patronymic" type="text" placeholder="Отчество" value="<?=$contact_patronymic?>" disabled>
	</div>
</div>
<!-- ############# phone ############### -->
<div id="container">
<?php foreach ($phoneArr as $phone): ?>
	<div class="row collapse" id="PhoneCollcetion">
		<div class="small-1 columns">
			<span class="prefix"><i class="fa fa-phone"></i></span>
		</div>
		<div class="small-10 medium-10 columns">
			<input name="phone[]" type="tel" placeholder="Телефон" value="<?=$phone?>" required disabled>
		</div>
		<div class="small-1 columns">
			<a class="button postfix success add" href="#" disabled>
				<i class="fa fa-plus"></i>
			</a>
		</div>
	</div>
<?php endforeach; ?>
</div>
<!-- ############# street ############## -->
<div class="row collapse">
	<div class="small-12 medium-6 columns">
		<div class="row collapse">
			<div class="small-2 columns">
				<span class="prefix"><i class="fa fa-map-marker"></i></span>
			</div>
			<div class="small-10 columns">
					<label>
					<select name="city" id="city" required disabled>
						<option value="<?=$city_id?>"><?=$city_name?></option>
					</select>
				</label>
			</div>
		</div>
	</div>
	<div class="small-12 medium-6 columns">
		<div class="row collapse">
			<div class="small-2 columns">
				<span class="prefix"><i class="fa fa-street-view"></i></span>
			</div>
			<div class="small-10 columns">
				<label>
					<select name="street" id="street" required disabled>
						<option value="<?=$street_id?>"><?=$street_name?></option>
					</select>
				</label>
			</div>
		</div>
	</div>
</div>
<!-- ############# date ################ -->
<div class="row collapse">
	<div class="small-2 medium-1 columns">
		<span class="prefix"><i class="fa fa-calendar"></i></span>
	</div>
	<div class="small-10 medium-11 columns">
		<input name="date" type="date" id="datetimepicker" value="<?=$contact_date?>" disabled>
	</div>
</div>
<!-- ############ button ############### -->
<div class="row collapse">
	<form style="display: inline-block" action="/contact/update/<?=$contact_id?>">
		<input type="submit" class="button" value="Редактировать">
	</form>
	<form style="display: inline-block" action="/contact/delete/<?=$contact_id?>">
		<input type="submit" class="button alert" value="Удалить">
	</form>
</div>
