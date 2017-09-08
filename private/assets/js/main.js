$(document).ready(function() {
    $('#form_pseudoUsers').keyup(function(){
        if($('#form_pseudoUsers').val().length > 2)
        {
            $('#form_pseudoUsers').css('borderColor','green');
        } 

        else{
            $('#form_pseudoUsers').css('borderColor','red');
        }
    });

    $('#form_nomUsers').keyup(function(){
        if($('#form_nomUsers').val().length > 2)
        {
            $('#form_nomUsers').css('borderColor','green');
        } 

        else{
            $('#form_nomUsers').css('borderColor','red');
        }
    });   

    $('#form_emailUsers').keyup(function(){
        function validateEmail($email)
        {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( $email );
        }

        if( !validateEmail($('#form_emailUsers').val()))
        { 
            $('#form_emailUsers').css('borderColor','red');
        }

        else
        {
            $('#form_emailUsers').css('borderColor','green');
        }
    });   

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

    $('#form_prenomUsers').keyup(function(){
        $('#form_prenomUsers').keyup(function(){
            if($('#form_prenomUsers').val().length > 2)
            {
                $('#form_prenomUsers').css('borderColor','green');
            } 

            else{
                $('#form_prenomUsers').css('borderColor','red');
            }
        }); 
    });

    $('#form_adresseUsers').keyup(function(){
        $('#form_adresseUsers').keyup(function(){
            if($('#form_adresseUsers').val().length > 6)
            {
                $('#form_adresseUsers').css('borderColor','green');
            } 

            else{
                $('#form_adresseUsers').css('borderColor','red');
            }
        }); 
    });

    $('#form_cpUsers').keyup(function(){
        function validateCp($codePostal)
        {
            var codePostalReg = /^((0[1-9])|([1-8][0-9])|(9[0-8])|(2A)|(2B))[0-9]{3}$/;
            return codePostalReg.test( $codePostal );
        }

        if( !validateCp($('#form_cpUsers').val()))
        { 
            $('#form_cpUsers').css('borderColor','red');
        }

        else
        {
            $('#form_cpUsers').css('borderColor','green');
        }
    });   

    $('#form_villeUsers').keyup(function(){
        function validateVille($ville)
        {
            var villeReg = /^[a-zA-z] ?([a-zA-z]|[a-zA-z] )*[a-zA-z]$/;
            return villeReg.test( $ville );
        }

        if( !validateVille($('#form_villeUsers').val()))
        { 
            $('#form_villeUsers').css('borderColor','red');
        }

        else
        {
            $('#form_villeUsers').css('borderColor','green');
        }

    });    

    $('#form_paysUsers').keyup(function(){
        function validatePays($pays)
        {
            var paysReg = /^[a-zA-z] ?([a-zA-z]|[a-zA-z] )*[a-zA-z]$/;
            return paysReg.test( $pays );
        }

        if( !validatePays($('#form_paysUsers').val()))
        { 
            $('#form_paysUsers').css('borderColor','red');
        }

        else
        {
            $('#form_paysUsers').css('borderColor','green');
        }
    });   

    $('#form_telephoneUsers').keyup(function(){
        function validateTel($Tel)
        {
            var telReg =  /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
            return telReg.test( $Tel );
        }

        if( !validateTel($('#form_telephoneUsers').val()))
        { 
            $('#form_telephoneUsers').css('borderColor','red');
        }

        else
        {
            $('#form_telephoneUsers').css('borderColor','green');
        }
    });

    $('input').on('keyup',function(){
        if($('#form_pseudoUsers').val() != '' && $('#form_emailUsers').val() != '')
        {
            $('#form_submit').prop("disabled", false); // Element(s) are now enabled.
        }
        else
        {
            $('#form_submit').prop("disabled", true); // Element(s) are now enabled.
            event.preventDefault();
        }
    });
    $('#installImg')on('load', function(){
    	setTimeout('history.go(-2); ', 2000);
    });

});