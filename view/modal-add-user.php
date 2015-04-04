
<!-- modal add user -->
<div id="modal-add-user" class="reveal-modal large" data-reveal>

	<div class="row collapse">
		<div class="small-12 columns">
			<h4>Добавить новый контакт</h4>
		</div>
	</div>

<form name="add-user" action="/add-user.php" method="post">
	<!-- ############# name ################ -->
	<div class="row collapse">
		<div class="small-1 columns">
			<span class="prefix"><i class="fa fa-user fa-fw"></i></span>
		</div>
		<div class="small-11 medium-3 columns">
			<input name="name" type="text" placeholder="Имя" required>
		</div>

		<div class="small-1 show-for-small columns">
			<span class="prefix"><i class="fa fa-user"></i></span>
		</div>
		<div class="small-11 medium-4 columns">
			<input name="surname" type="text" placeholder="Фамилия" required>
		</div>

		<div class="small-1 show-for-small columns">
			<span class="prefix"><i class="fa fa-user"></i></span>
		</div>
		<div class="small-11 medium-4 columns">
			<input name="patronymic" type="text" placeholder="Отчество">
		</div>
	</div>
	<!-- ############# phone ############### -->
	<div id="container">
		<div class="row collapse" id="PhoneCollcetion">
			<div class="small-1 columns">
				<span class="prefix"><i class="fa fa-phone"></i></span>
			</div>
			<div class="small-10 medium-10 columns">
				<input name="phone[]" type="tel" placeholder="Телефон" required>
			</div>
			<div class="small-1 columns">
				<a class="button postfix success add" href="#">
					<i class="fa fa-plus"></i>
				</a>
			</div>
		</div>
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
						<select name="city" id="city" required>
							<option value="default">...</option>
							<option value="husker">Владивосток</option>
							<option value="starbuck">Москва</option>
							<option value="hotdog">Самара</option>
							<option value="apollo">Сочи</option>
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
						<select name="street" id="street" required>
							<option value="default">...</option>
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
			<input name="date" type="date" id="datetimepicker">
		</div>
	</div>
	<!-- ############ button ############### -->
	<div class="row">
		<div class="small-12">
			<input type="submit" class="button" value="Добавить">
		</div>
	</div>
</form>

<!-- ############ close modal ############### -->
<a class="close-reveal-modal" aria-label="Close">&#215;</a>

</div>
