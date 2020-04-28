let app = null;
$(document).ready(function()
{
	app = new Vue({
		el: '.container-main',
		data:
		{
			tasks: tasks,
			activePage: 1
		},
		methods:
		{
			updateTasks: function(e)
			{
				let data = this.getFields();
				checkValid();
				
				if($('.form-task').find('.is-invalid').length > 0)
					return;
				if($('.form-task').find('.is-invalid').length === 0)
					e.preventDefault();

				let saveResult = saveTask(data);
				if(saveResult.status == 'ok')
				{
					initPagination();
					setFiltersFefault();
					getLastTasks(this.activePage, (taskResult) => 
					{
						this.tasks = taskResult.result;
						showMsgTask();
						this.clearFields();
						$('#pagination-container').pagination(1);
					});
				}
				else
				{
					console.log(saveResult.description);
				}
			},
			getFields: function()
			{
				let data = {};
				data['name'] = $('#user-name').val();
				data['email'] = $('#user-email').val();
				data['text'] = $('#task-text').val();
				return data;
			},
			clearFields: function()
			{
				$('#user-name').val('');
				$('#user-email').val('');
				$('#task-text').val('');
			}
		}
	});

	initPagination();
});

function setFiltersFefault()
{
	let $sortField = $('.sort-up-down');
	let sortFieldText = $sortField.find('.dropdown-menu').find('a:first').text();
	$sortField.find('.dropdown-item').removeClass('active');
	$sortField.find('.dropdown-item:first').addClass('active');
	$sortField.find('button').find('span').text(sortFieldText);

	let $sortUD = $('.sort-up-down');
	let sortUDText = $sortUD.find('.dropdown-menu').find('a:first').text();
	$sortUD.find('.dropdown-item').removeClass('active');
	$sortUD.find('.dropdown-item:first').addClass('active');
	$sortUD.find('button').find('span').text(sortUDText);
}

function getCountAllTasks(callback)
{
	$.ajax(
	{
		url: '/',
		method: 'post',
		data: 
		{
			'atype'  : 'task',
			'action' : 'get-count-all',
			'model'  : 'main',
		},
		success : (result) => 
		{
			callback(result);
		}
	});
}

function initPagination()
{
	var result = [];
	getCountAllTasks((resultCount) => 
	{
		for (var i = 1; i < resultCount.result.count; i++)
		{
			result.push(i);
		}
		$('#pagination-container').pagination({
			dataSource: result,
			pageSize: 2,
			afterPageOnClick: function(e)
			{
				getTasksAftetPagination(e);
			},
			afterPreviousOnClick: function(e)
			{
				getTasksAftetPagination(e);
			},
			afterNextOnClick: function(e)
			{
				getTasksAftetPagination(e);
			}
		});
	});	
}

function getTasksAftetPagination(e)
{
	let target = e.currentTarget;
	let pageNum = $(target).attr('data-num');
	let sortField = $('.sort-field').find('.active').attr('sort');
	let sortUD = $('.sort-up-down').find('.active').attr('sort');
	getLastTasksBySort(pageNum, sortField, sortUD, (taskResult) => 
	{
		app.tasks = taskResult.result;
	});
}

function showMsgTask()
{
	let $firstTr = $('.table').find('tbody').find('tr:first');
	$('.alert.save-task').fadeIn(500);
	delay(2000).then(() => 
	{
		$firstTr.css('box-shadow', '0 0 10px rgb(103, 175, 30)');
		$('.alert.save-task').fadeOut(500);
		setTimeout(() => { $firstTr.css('box-shadow', 'unset'); }, 1000);
	});	
}

function delay(ms)
{
	return new Promise((resolve, reject) =>
	{
		setTimeout(resolve, ms);
	});
}

function checkValid()
{
	$('.form-task').find('.form-control').each((i, item) => 
	{
		if($(item).val().trim() == '')
		{
			$(item).addClass('is-invalid');
		}
	});
}

$(document).on('input', '.form-control', function()
{
	let type = $(this).attr('type');
	switch (type)
	{
		case 'email':
			let reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+$/;
			if(reg.test($(this).val()) != false)
			{
				$(this).removeClass('is-invalid');
			}
			else
			{
				$(this).addClass('is-invalid');
			}
			break;
	
		default:
			if($(this).val().length > 0)
			{
				$(this).removeClass('is-invalid');
			}
			else
			{
				$(this).addClass('is-invalid');
			}
			break;
	}	
});

function saveTask(data)
{
	return $.ajax(
	{
		url: '/',
		method: 'post',
		async: false,
		data: 
		{
			'atype'  : 'task',
			'action' : 'save',
			'model'  : 'main',
			'name' 	 : data.name,
			'email'  : data.email,
			'text'   : data.text,
		}
	}).responseJSON;
}

function getLastTasks(page, callback)
{
	$.ajax(
	{
		url: '/',
		method: 'post',
		data: 
		{
			'atype'  : 'task',
			'action' : 'get-last',
			'model'  : 'main',
			'page'   : page,
		},
		success : (result) => 
		{
			callback(result);
		}
	});
}

$(document).on('click', '.form-check-input', function()
{
	let taskID = $(this).attr('task');
	let status = $(this).prop('checked');
	status = status === true ? 1 : 0;
	changeTaskStatus(taskID, status, (statusResult) => 
	{
		let statusText = status === 0 ? 'Не выполнено' : 'Выполнено';
		$(this).closest('td').parent().find('.td-status').find('.status-text').text(statusText);
	});
});

function changeTaskStatus(taskID, status, callback)
{
	$.ajax(
	{
		url: '/',
		method: 'post',
		data: 
		{
			'atype'  : 'task',
			'action' : 'change-status',
			'model'  : 'main',
			'status' : status,
			'task_id': taskID,
		},
		success : (result) => 
		{
			callback(result);
		}
	});
}

function changeTaskText(taskID, text, callback)
{
	$.ajax(
	{
		url: '/',
		method: 'post',
		data: 
		{
			'atype'  : 'task',
			'action' : 'change-text',
			'model'  : 'main',
			'text'   : text,
			'task_id': taskID,
		},
		success : (result) => 
		{
			callback(result);
		}
	});
}

function getLastTasksBySort(page, sortField, sortUD, callback)
{
	$.ajax(
	{
		url: '/',
		method: 'post',
		data: 
		{
			'atype'		: 'task',
			'action' 	: 'get-by-sort',
			'model'  	: 'main',
			'page'		: page,
			'sort_field': sortField,
			'sort_ud'	: sortUD,
		},
		success : (result) => 
		{
			callback(result);
		}
	});
}

$(document).on('click', '.td-text', function()
{
	if(!$(this).hasClass('edit'))
	{
		let text = $(this).text();
		let html = `<textarea>${text}</textarea><button id="save-text" class="btn btn-primary btn-sm mt-md-3">Сохранить</button>`;
		$(this).html(html).addClass('edit');
	}	
});

$(document).on('click', '#save-text', function(e)
{
	e.stopPropagation();
	let taskID = $(this).closest('tr').attr('task');	
	let text = $(this).siblings('textarea').val();	
	$('.td-text').removeClass('edit');
	changeTaskText(taskID, text, (textResult) => 
	{
		if(textResult.status == 'ok')
		{
			$(this).closest('tr').find('.edit-text').text('* Отредактировано администратором');
			$(this).closest('.td-text').html(text);			
		}
		else
		{
			$('#msg-modal').find('.modal-body').text(textResult.description);
			$('#msg-modal').modal('show');
		}
	});
});

$(document).on('click', '.dropdown-item', function()
{
	$(this).closest('.dropdown-menu').find('.dropdown-item').removeClass('active');
	$(this).addClass('active');
	let sortText = $(this).text();
	$(this).closest('.btn-group').find('button').find('span').text(sortText);

	let sortField = $('.sort-field').find('.active').attr('sort');
	let sortUD = $('.sort-up-down').find('.active').attr('sort');
	let page = $('.paginationjs-page.active').attr('data-num');

	console.log(sortField, sortUD);
	
	getLastTasksBySort(page, sortField, sortUD, (taskResult) => 
	{
		app.tasks = taskResult.result;
	});
});