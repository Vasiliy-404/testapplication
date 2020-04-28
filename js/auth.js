$(document).on('click', '#sign', function(e)
{
    e.preventDefault();
    let login = $('#auth-login').val();
    let pass = $('#auth-pass').val();
    if(login == '' || pass == '')
    {
        $('.alert.check-empty').removeClass('hidden');
        return;
    }
    checkAuth(login, pass, (checkResult) => 
    {
        let result = checkResult.result;
        if(result === true)
        {
            location.href = '/';
        }
        else
        {
            $('.alert.check-auth').removeClass('hidden');
        }
    });
});

$(document).on('input', 'form input', function()
{
    $('.alert').addClass('hidden');
})

function checkAuth(login, pass, callback)
{
    $.ajax(
    {
        url: '/',
        method: 'post',
        data: 
        {
            'atype'  : 'auth',
            'action' : 'check',
            'model'  : 'auth',
            'login'  : login,
            'pass'   : pass,
        },
        success : (result) => 
        {
            callback(result);
        }
    });
}