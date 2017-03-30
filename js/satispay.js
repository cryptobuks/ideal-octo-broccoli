/**
 * Created by marco.bevilacqua on 30/03/2017.
 */

function ajaxSubmitForm(){

    $('form').on('submit', function(e){

        e.preventDefault();
        var $form = $('form');

        $.ajax({
            type    : $(this).attr('method'),
            url     : $(this).attr('action'),
            data    : $form.serialize(),
            beforeSend: function(){
              $('[type="submit"]').attr('disabled', true);

                if(!$('#dialog').hasClass('hidden')){
                    //empty dialog div
                    emptyDialog();
                }

            },
            success : function (data) {
                console.log(data);
                if(data){
                    fillDialog(data);
                }
            },
            error   : function (error, string, request) {
                fillErrorDialog(error)
            },
            complete : function () {
                //reactive submit
                $('[type="submit"]').attr('disabled', false );
            }
        });

    });

}

function fillDialog(data) {

    var parsed = $.parseJSON(data),
        $dialog = $('#dialog');

    if(parsed.code && parsed.code != "" ){
        //error
        $dialog.addClass('alert alert-danger')
            .find('#dialog-title').text('Error');

        $('#dialog-message').text(parsed.message);

    } else {

        $dialog.addClass('alert alert-success')
            .find('#dialog-title').text('Success');

        if(parsed.list){
            //user list
            $.each(parsed.list, function (i, e) {
                var value = (e.phone_number != "") ? e.phone_number : e.amount;
                $('#dialog-list').append('<li><span><b>UUID: </b>' + e.uuid + " (" + value + ')</span></li>')
            })
        } else {
            //other options
            if(parsed.phone_number){
                $('#dialog-message').text('Phone Number: ' + parsed.phone_number);
            } else {
                $('#dialog-message').text('amount: ' + parsed.amount);
            }

        }
    }

    //show dialog
    $dialog.removeClass('hidden');

}

function fillErrorDialog(message){
    var $dialog = $('#dialog');

    $dialog.addClass('alert alert-danger')
        .find('#dialog-title').text('Error');

    $('#dialog-message').text(message);
}

function emptyDialog() {

    var $dialog = $('#dialog');
    
    $dialog.find('#dialog-title').text('');
    $dialog.find('#dialog-message').text('');
    $dialog.find('#dialog-list li').remove();

    $dialog.addClass('hidden');

}

