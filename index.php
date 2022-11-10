<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles.css?=<?php echo time() ?>" />
    <title>CRUD</title>
  </head>
  <body>
    <div class="content">

      <form name="crud">
      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dc/Google_Maps_Logo.svg/2560px-Google_Maps_Logo.svg.png">
        <label for="cidade">Cidade </label>
        <input type="text" name="cidade" id="cidade" value="" />
        <label for="estado">Estado </label>
        <input type="text" name="estado" id="estado" value="" />
        <input type="hidden" value="" name="action" />
        <div class="buttons">
            <button
            class="btn"
            type="button"
            onClick="document.crud.action.value='CADASTRAR';webService();"
          >
            CADASTRAR
          </button>
          <button
            class="btn"
            type="button"
            onClick="document.crud.action.value='CONSULTAR';webService();"
          >
            CONSULTAR
          </button>
          <button
            class="btn"
            type="button"
            onClick="document.crud.action.value='ATUALIZAR';webService();"
          >
            ATUALIZAR
          </button>
          <button
            class="btn"
            type="button"
            onClick="document.crud.action.value='DELETAR';webService();"
          >
            DELETAR
          </button>
        </div>
        <div>
          <p id="response" class="response"></p>
        </div>
      </form>
    </div>
  </body>

  <script>
    function webService() {
      
      // define dados a serem enviados para o webservice
      var dados = {
        nomeCidade: document.crud.cidade.value,
        estado: document.crud.estado.value,
        action: document.crud.action.value, //identifica ação a ser relalizada pelo webservice
      };
      // informa início da chamda a execução do webservice
      alert("Webservice vai ser executado");
      $.ajax({
        url: "./server.php", // script a ser chamado
        type: "POST", // Método de envio
        dataType: "json", // Tipo de retorno
        data: dados,
      })
        // .done é executado quando serviço termina, retornando informações na variável data
        .done(function (data) {
          // alert("Webservice retorna dados JSON");
          // percorre json data
          for (var i in data) {
            response = data[i].response.split(';')
            console.log(response)

            if(dados.action == "CADASTRAR") {
              document.getElementById("response").innerHTML =
               `<p> <span> ${response} <span> </p>
               `
            }

            if(dados.action == "CONSULTAR") {
              document.getElementById("response").innerHTML =
               `<p> <span>ID:</span>      ${response[0]} </p>
                <p> <span> Nome: </span>  ${response[1]} </p>
                <p> <span> Estado: </span>${response[2]} </p>
               `
            }

            if(dados.action == "ATUALIZAR") {
              document.getElementById("response").innerHTML =
               `<p> <span> ${response[0]} </span> </p>
               `
            }
            
            if(dados.action == "DELETAR") {
              document.getElementById("response").innerHTML =
               `<p> <span>${response[0]} </span> </p>
               `
            }

          }
          // fim da execução do webservice
          // alert("Webservice finalizado");
        });


    }




  </script>
</html>
