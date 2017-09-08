$(document).ready(function(){
    $('#form_email').keyup(function(){
        function validateEmailConnect($emailConnect)
        {
            var emailConnectReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailConnectReg.test( $emailConnect );
        }

        if( !validateEmailConnect($('#form_email').val()))
        { 
            $('#form_email').css('borderColor','red');
        }

        else
        {
            $('#form_email').css('borderColor','green');
        }
    });

});