let addMsg =    (msg, success=true) => {
                    $('#msg').html(msg);
                    (success) ? $('#msg').addClass('alert-success') : $('#msg').addClass('alert-danger');
                    $('#msg').removeClass('d-none');
                }

let removeMsg = () => {
                    $('#msg').html('');
                    $('#msg').removeClass('alert-danger');
                    $('#msg').removeClass('alert-success');
                    $('#msg').addClass('d-none');
                }

