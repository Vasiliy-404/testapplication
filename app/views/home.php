<?
	$tasks = json_encode($data['tasks']);
	$isAdmin = $data['isAdmin'];
?>
<div class="container-fluid container-main">
	<div class="container d-flex justify-content-end">
		<?if($isAdmin === true):?>
			<a href="/logout/"><button class="btn btn-secondary btn-sm mt-md-3">Выйти</button></a>
		<?else:?>
			<a href="/auth/"><button class="btn btn-primary btn-sm mt-md-3">Войти</button></a>
		<?endif;?>
	</div>
	<div class="container">
		<h3>Список задач</h3>
		<div class="select-container">
			<div class="btn-group dropup sort-field">
				<button class="btn btn-secondary btn-sm dropdown-toggle mb-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Сортировка по "<span>Последнее добавление</span>"</button>
				<div class="dropdown-menu">
					<a class="dropdown-item active" sort="last">Последнее добавление</a>
					<a class="dropdown-item" sort="name">Имя пользователя</a>
					<a class="dropdown-item" sort="email">E-mail</a>
					<a class="dropdown-item" sort="status">Статус</a>
				</div>
			</div>
			<div class="btn-group dropup sort-up-down">
				<button class="btn btn-secondary btn-sm dropdown-toggle mb-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>По убыванию</span></button>
				<div class="dropdown-menu">
					<a class="dropdown-item active" sort="down">По убыванию</a>
					<a class="dropdown-item" sort="up">По возрастанию</a>
				</div>
			</div>
		</div>
		<table class="table table-hover table-responsive-sm">
			<thead class="thead-light">
				<tr>
					<th scope="col">Имя пользователя</th>
					<th scope="col">E-mail</th>
					<th scope="col">Текст задачи</th>
					<th scope="col">Статус/Отметка</th>
					<?if($isAdmin):?>
						<th>Изменить статус</th>
					<?endif;?>	
				</tr>
			</thead>
			<tbody>
				<tr v-for="(task) in tasks" v-bind:task="task.id_t">
					<td>{{ task.name_u }}</td>
					<td>{{ task.email_u }}</td>
					<td class="<?=$isAdmin ? 'td-text' : '';?>" title="Нажмите для редактирования">{{ task.text_t }}</td>
					<td class="td-status">
						<div class="status-text">* {{ task.status_t == 0 ? 'Не выполнено' : 'Выполнено' }}</div>
						<div class="edit-text">{{ task.is_edit_t == 'N' ? '' : '* Отредактировано администратором' }}</div>
					</td>
					<?if($isAdmin):?>
					<td>
						<div class="form-group">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" v-bind:task="task.id_t" v-bind:id="'task-' + task.id_t" v-bind:checked="task.status_t === 0 ? false : true">
								<label class="form-check-label" v-bind:for="'task-' + task.id_t">Выполнена</label>
							</div>
						</div>
					</td>
					<?endif;?>
				</tr>
			</tbody>
		</table>
		<div id="data-container"></div>
		<div id="pagination-container"></div>
	</div>
	<div class="container">
		<h3>Добавление новой задачи</h3>
		<form class="form-task">
			<div class="form-group">
				<label for="user-name">Ваше имя</label>
				<input type="text" class="form-control" id="user-name" placeholder="Алексей" required>
				<div class="invalid-feedback">Пожалуйста, введите имя</div>
			</div>
			<div class="form-group">
				<label for="user-email">Ваш E-mail</label>
				<input type="email" class="form-control" id="user-email" placeholder="name@example.com" required>
				<div class="invalid-feedback">Пожалуйста, введите E-mail согласно примеру, наведите курсор мыши для подсказки</div>
			</div>
			<div class="form-group">
				<label for="task-text">Введите текст задачи</label>
				<textarea class="form-control" id="task-text" rows="3" required></textarea>
				<div class="invalid-feedback">Пожалуйста, введите текст задачи</div>
			</div>
			<input type="submit" id="save-task" class="btn btn-primary btn-sm" v-on:click="updateTasks" value="Добавить"/>
		</form>
		<div class="alert alert-success save-task hidden" role="alert">Задача успешно добавлена</div>
	</div>
</div>
<div class="modal fade" id="msg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ошибка редактирования</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
				<a href="/auth/"><button type="button" class="btn btn-primary">Перейти</button></a>
			</div>
		</div>
	</div>
</div>
<script>
	let tasks = <?=$tasks?>;
</script>