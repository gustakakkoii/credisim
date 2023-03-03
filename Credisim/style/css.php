<style>
    @font-face {
        font-family: 'Poppins-Light';
        src: url('style/fontes/Poppins-Light.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    * {
        margin: 0;
        padding: 0;
        font-family: 'Poppins-Light', Arial, Helvetica, sans-serif;
    }


    ::-webkit-scrollbar {
        width: 0px;
        height: 0px;
    }

    main,
    body,
    html {
        position: fixed;
        width: 100%;
        height: 100%;
        overflow-y: hidden;
        overflow-x: hidden;
        background-color: rgba(235, 235, 235, 1);
    }

    section {
        margin-top: 20px;
    }

    .navbar {
        overflow-y: hidden;
        overflow-x: hidden;
        background-color: rgba(235, 235, 235, 1);
    }

    .nav-link,
    .nav-item {
        color: #fff;
    }


    .corpo {
        border-radius: 13px 13px 0px 0px;
        outline: 1px solid rgba(252, 145, 80, 1);
        margin-top: 1vh;
        width: 100vw;
        height: 95vh;
        overflow-y: scroll;
        overflow-x: hidden;
        background-color: #fff;
        padding-bottom: 5vh;
    }

    .resultado,
    .dados {
        margin: 50px;
    }

    .resultado>article {
        margin-bottom: 30px;
    }

    .corpo>h1 {
        margin-top: 20px;
        width: 100%;
        text-align: center;
        font-family: 'Poppins-Light', Arial, Helvetica, sans-serif;
    }


    .campos {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .setanexosimg {
        margin: 4.6px;
        cursor: pointer;
    }

    .setanexosimg>img {
        width: 250px;
        height: 250px;
        border-radius: 5px 5px 0 0;
        border: 1px solid rgba(103, 103, 103, 1);
        border-bottom: 0px;
    }

    .cardanexos {
        margin: 4.6px;
    }


    .getanexosimg {
        text-decoration: none;
        height: auto;
        cursor: pointer;
    }

    .getanexosimg>img {
        width: 250px;
        height: 250px;
        border-radius: 5px 5px 0 0;
        border: 1px solid rgba(103, 103, 103, 1);
        border-bottom: 0px;
    }

    .setanexos {
        display: flex;
        flex-direction: column;
        flex-direction: column-reverse;
        flex-direction: row-reverse;
        flex-direction: row;

        flex-wrap: wrap;

        justify-content: center;

        align-items: stretch;
        align-items: baseline;
        align-items: flex-start;
        align-items: flex-end;
        align-items: center;
    }

    #preview {
        width: 250px;
        height: 300px;
        border-radius: 5px 5px 0 0;
        border: 1px solid rgba(103, 103, 103, 1);
        border-bottom: 0px;
    }

    #clientefoto {
        width: 250px;
        height: 300px;
        border-radius: 5px;
        border: 1px solid rgba(103, 103, 103, 1);
    }

    .fotolabel {
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 250px;
        height: 38px;
        color: #fff;
        background-color: rgba(252, 145, 80, 1);
        border-radius: 0 0 5px 5px;
        border: 1px solid rgba(103, 103, 103, 1);
        border-top: 0px;
    }

    p {
        margin-bottom: 20px;
    }

    input [type='file'] {
        display: none;
    }

    .notexist {
        visibility: hidden;
        position: absolute;
    }

    input[type='date'],
    input[type='email'],
    input[type='text'] {
        width: 100%;
        padding-left: 1%;
        height: 38px;
        border: none;
        border-radius: 5px;
        outline: 1px solid rgba(103, 103, 103, 1);
        margin-bottom: 20px;
    }

    input[type='date']:focus,
    input[type='email']:focus,
    input[type='text']:focus,
    input[type='number']:focus,
    select:focus,
    input[type='date']:hover,
    input[type='email']:hover,
    input[type='text']:hover,
    input[type='number']:hover,
    select:hover {
        outline: 2px solid rgba(103, 103, 103, 1);
    }

    input[type='number'],
    input[type='date'],
    select {
        width: 100%;
        height: 38px;
        border: none;
        border-radius: 5px;
        outline: 1px solid rgba(103, 103, 103, 1);
        margin-bottom: 20px;
    }

    .block {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .blockchild {
        flex: 1;
    }

    select {
        padding-left: 5px;
        ;
    }

    input[type='number'],
    input[type='email'],
    input[type='text'] {
        padding-left: 10px;
    }

    .atencao {
        border-radius: 5px;
        background-color: rgba(255, 163, 163, 1);
        border: 2px solid rgba(255, 0, 0, 1);
        display: block;
        text-align: center;
        padding: 10px;
        margin: 0 auto;
        width: 100%;
        max-width: 500px;
    }

    .mensagem {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .sucesso {
        border-radius: 5px;
        background-color: rgba(146, 231, 191, 1);
        border: 2px solid rgba(25, 135, 84, 1);
        display: block;
        text-align: center;
        padding: 10px;
        margin: 0 auto;
        width: 90%;
        max-width: 500px;
    }

    .campotexto {
        min-height: 25px;
        width: auto;
        border-bottom: 1px solid black;
    }

    #offcanvasDarkNavbarLabel {
        margin-top: 10px;
        height: 30px;
    }

    .accordion {
        width: 100%;
    }

    .accordion-button:not(.collapsed) {
        color: #fff;
        background-color: rgba(252, 145, 80, 1);
    }

    .accordion-button:focus {
        border-color: none;
        box-shadow: none;
    }

    .articlecard {
        height: 100%;
        border-radius: 5px;
        margin-top: 40px;
        margin: 5px;
        outline: 1px solid rgba(103, 103, 103, 1);
    }

    .articlecard-img {
        min-height: 150px;
        border-radius: 5px 0 0 5px;
        background-size: cover;
        background-position: center center;
    }

    .enviar {
        cursor: pointer;
        font-size: 1.2rem;
        color: #fff;
        border-radius: 5px;
        background-image: linear-gradient(rgba(25, 135, 84, 1), rgba(50, 107, 81, 1));
        display: block;
        text-align: center;
        padding: 10px;
        margin: 0 auto;
    }

    .copiar {
        position: relative;
        top: -43px;
        left: calc(100% - 20px);
        width: 20px;
        height: 20px;
        background-color: red;
    }

    .pdf {
        margin-bottom: 30px !important;
        width: 100%;
        cursor: pointer;
        font-size: 1.2rem;
        color: #fff;
        border-radius: 5px;
        background-image: linear-gradient(rgba(25, 135, 84, 1), rgba(50, 107, 81, 1));
        display: block;
        text-align: center;
        padding: 10px;
        margin: 0 auto;
    }

    .excluir {
        width: 100%;
        cursor: pointer;
        font-size: 1.2rem;
        color: #fff;
        border-radius: 5px;
        background-image: linear-gradient(rgba(226, 63, 63, 1), rgba(142, 28, 28, 1));
        display: block;
        text-align: center;
        padding: 10px;
        margin: 0 auto;
    }

    .editar {
        border: none;
        width: 100%;
        cursor: pointer;
        font-size: 1.2rem;
        color: #fff;
        border-radius: 5px;
        background-image: linear-gradient(rgba(252, 145, 80, 1), rgba(178, 81, 22, 1));
        display: block;
        text-align: center;
        padding: 10px;
        margin: 0 auto;
    }

    .ficha {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .verfichabutton {
        margin-top: 20px;
        width: 100%;
        text-decoration: none;
        cursor: pointer;
        color: #fff;
        border-radius: 5px;
        background-color: rgba(25, 135, 84, 1);
        display: block;
        text-align: center;
    }

    .pdf:hover,
    .enviar:hover {
        background-image: linear-gradient(rgba(50, 107, 81, 1), rgba(25, 135, 84, 1));
    }

    .verfichabutton:hover {
        background-color: rgba(50, 107, 81, 1);
        color: #fff;
    }

    .articlecard-body>.block {
        height: 100%;
        padding-bottom: 10px;
    }
</style>