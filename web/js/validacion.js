function validateStringBlur(id)
    {

        document.getElementById(id).addEventListener("blur", Blur, false);

        function Blur()
        {
            let inputString = document.getElementById(id).value;

            if(inputString != "")
            {
                //Letras y Números
                //var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890';

                //Solo Letras
                var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ';//Caracteres validos
                
                for (var i=0; i<inputString.length; i++)
                if (filtro.indexOf(inputString.charAt(i)) != -1)
                {
                    document.getElementById(id).style.border = 'solid 1px #3fe316';
                    return true;
                }
                else
                {
                    document.getElementById(id).style.border = 'solid 1px #e31414';
                    return false;
                }
            }

            if(inputString === ""){
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }

            if(inputString === null){
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }

            if(isNaN(inputString)) {
                document.getElementById(id).style.border = 'solid 1px #3fe316';
                return true;
            }else{
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }
        }
    }

    function validateNumberBlur(id)
    {

        document.getElementById(id).addEventListener("blur", Blur, false);

        function Blur()
        {
            let inputNumber = document.getElementById(id).value;

            if(inputNumber === ""){
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }

            if(inputNumber === null){
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }

            if(isNaN(inputNumber)){
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }else{
                document.getElementById(id).style.border = 'solid 1px #3fe316';
                return true;
            }
        }
    }

    function validateString(id)
    {
            let inputString = document.getElementById(id).value;

            if(inputString != "")
            {
                //Letras y Números
                //var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890';

                //Solo Letras
                var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ';//Caracteres validos
                
                for (var i=0; i<inputString.length; i++)
                if (filtro.indexOf(inputString.charAt(i)) != -1)
                {
                    document.getElementById(id).style.border = 'solid 1px #3fe316';
                    return true;
                }
                else
                {
                    document.getElementById(id).style.border = 'solid 1px #e31414';
                    return false;
                }
            }

            if(inputString === ""){
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }

            if(inputString === null){
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }

            if(isNaN(inputString)) {
                document.getElementById(id).style.border = 'solid 1px #3fe316';
                return true;
            }else{
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }
    }

    function validateNumber(id)
    {
            let inputNumber = document.getElementById(id).value;

            if(inputNumber === ""){
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }

            if(inputNumber === null){
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }

            if(isNaN(inputNumber)){
                document.getElementById(id).style.border = 'solid 1px #e31414';
                return false;
            }else{
                document.getElementById(id).style.border = 'solid 1px #3fe316';
                return true;
            }
    }