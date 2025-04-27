



        /*Construccion de la tabla Editar Item*/
   const segundaTabla = document.querySelector('.tFicheroE');
     const fichaDiv = document.querySelector('.segundaTablaFicha');
    const anchoPantalla = window.innerWidth;
    
    /* function crearTablaEI(){ */


        /* segundaTabla = document.querySelector('.tFicheroE'); */
        /* const anchoPantalla = window.innerWidth; */



        if(segundaTabla !=null){
            if(anchoPantalla > 480){
                let newHTMLCodeTabla = `<tr>
                <th>Titulo</th>
                <th>Descripcion</th>
                <th>Tamaño</th>
                <th>Formato</th>
                <th></th>
            </tr>
            <tr>
                <td>Ley federal sobre monumentos culturales...</td>
                <td>Residencia profesional</td>
                <td>6.27 MB</td>
                <td>Adobe PDF</td>
                <td>
                    <div class="divBtnEI">
                        <a href="">Ver</a>
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                </td>
            </tr>`;
            segundaTabla.innerHTML += newHTMLCodeTabla;
        
            }else{
                let newHTMLCodeTabla = `<tr>
                <th>Titulo</th>
                <th>Descripcion</th>
                <th>Tamaño</th>
            </tr>
            <tr>
                <td>Ley federal sobre monumentos culturales...</td>
                <td>Residencia Profesional</td>
                <td>6.27 MB</td>
            </tr>
            <tr>
                <th>Formato</th>
                <th colspan="2"></th>
            </tr>
            <tr>
                <td>Adobe PFD</td>
                <td colspan="2">
                <div class="divBtnEI">
                        <a href="">Ver</a>
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                </td>
            </tr>`;
            segundaTabla.innerHTML += newHTMLCodeTabla;
            }
        }else if (fichaDiv != null){
            if(anchoPantalla > 480){
                let newHTMLCode = `<tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Tamaño</th>
            <th>Formato</th>
            <th></th>
        </tr>
        <tr>
            <td>Ley federal sobre monumentos y zonas arqueologicas, artisticas e historicas</td>
            <td>Residencia <br> Profesional</td>
            <td>6.27 MB</td>
            <td>Adobe PDF</td>
            <td><a href="">Visualizar</a></td>
        </tr>`;
                fichaDiv.innerHTML += newHTMLCode;
        
            }else{
                let newHTMLCode = `<tr>
                <td colspan=2></td>
            </tr>
            <tr>
                <th>Titulo</th>
                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero nesciunt velit ipsum</td>
            </tr>
            <tr>
                <th>Descripcion</th>
                <td>Residencia profesional</td>
            </tr>
            <tr>
                <td class="subtablas">
                    <h2>Tamaño</h2>
                    <p>6.27 MB</p>
                </td>
                <td class="subtablas">
                    <h2>Formato</h2>
                    <p>Adobe PDF</p>
                </td>
            </tr>
            <tr class="btnValidar">
                <td colspan=2><a href="">Visualizar</a></td>
            </tr>`;
                fichaDiv.innerHTML += newHTMLCode;
            };
        }
        
  /*   }; */



  /*   function crearTablaFD(){ */
       /*  const fichaDiv = document.querySelector('.segundaTablaFicha'); */


    
/*     } */



        // Obtén la referencia al elemento div con la clase "ficha"
    


    



    /* Codigo para ver el password */

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("passwordInput");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }



        function togglePasswordVisibilityConfirmar() {
            var passwordInput = document.getElementById("passwordInputConfirmar");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }


        $(function() {
            $(".rslides").responsiveSlides();
          });