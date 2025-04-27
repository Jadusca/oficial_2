  //Flecha Subir
  $(document).ready(function () {
    $("#subir").click(function () {
      $("html,body").animate(
        {
          scrollTop: "0px",
        },
        1000
      );
    });
  });
  
// Función de Slide de Fotos Principal

$(function() {
    $(".rslides").responsiveSlides();
  });

// Función del carrusel

$(document).ready(function()
{
  $('#contcarrusel').tinycarousel();
});

// Función del Menu desplegable administrativo

$('.iconocerrarsesion').click(function() {
  $('#opcerrar').slideToggle();

});

$('.iconocerrarsesion2').click(function() {
  $('#opcerrar2').slideToggle();

});

// Funciones del SideBar

    var opciones = document.querySelector("#opcionesadmin");
    var cerrarops = document.querySelector("#cerrarop");

    opciones.addEventListener("click",function(){
        document.querySelector("body").classList.toggle("active");
    })
   
    cerrarops.addEventListener("click",function(){
        document.querySelector("body").classList.toggle("active");
    })

   

