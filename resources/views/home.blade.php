<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monitoramento de Medidores de Energia</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
        }

        a {
            position: absolute;
            top: 5em;
            left: 50em;
            font-family: 'Montserrat';
            font-size: 1em;
            width: auto;
            line-height: .6em;
            border: 1px dashed black;
            padding: .3em;
        }

        h1 {
            position: absolute;
            top: 0.1em;
            left: 20em;
            font-family: 'Montserrat';
            font-size: 2em;
            text-transform: uppercase;
            width: auto;
            line-height: .8em;
            border: 0px solid black;
            padding: .2em;
        }

        h2 {
            position: absolute;
            top: 3em;
            left: 50em;
            font-family: 'Montserrat';
            font-size: 1em;

            width: auto;
            line-height: .6em;
            border: 1px dashed black;
            fill: yellow;
            fill-opacity: 100;

            padding: .3em;
        }

        table {
            position: absolute;
            font-family: 'Montserrat';
            font-size: 1em;
            text-transform: uppercase;
            width: auto;
            line-height: .6em;
            border: 1px solid black;
            padding: .1em;
        }

        h3 {
            position: absolute;
            top: 0.1em;
            left: 20em;
            font-family: 'Montserrat';
            font-size: 1em;
            text-transform: uppercase;
            width: auto;
            line-height: .8em;
            border: 5px solid black;
            padding: .2em;
        }

        h4 {
            position: absolute;
            top: 2.1em;
            left: 40em;
            font-family: 'Montserrat';
            font-size: 1em;
            text-transform: uppercase;
            width: auto;
            line-height: .8em;
            border: 5px solid black;
            padding: .2em;
        }

        h5 {
            position: absolute;
            top: 4.1em;
            left: 40em;
            font-family: 'Montserrat';
            font-size: 1em;
            text-transform: uppercase;
            width: auto;
            line-height: .8em;
            border: 5px solid black;
            padding: .2em;
        }

        canvas {
            display: block;

        }
    </style>

</head>
<body>

<h1 id="titulo">MONITORAMENTO DE MEDIDORES DE ENERGIA</h1>

<a id="link-admin" href="{{route('regional.index')}}" target="_blank">Clique aqui para alterar status de medidores</a>


<script id="tree_to_show" type="text/xmldata">
    {!! $treeXml !!}
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/110/three.js"></script>

<script>

    // Função para limpar o XMLDOC de nós de texto com espaços
    function clean(node)
    {
        for(var n = 0; n < node.childNodes.length; n ++)
        {
            var child = node.childNodes[n];
            if
            (
                child.nodeType === 8
                ||
                (child.nodeType === 3 && !/\S/.test(child.nodeValue))
            )
            {
                node.removeChild(child);
                n --;
            }
            else if(child.nodeType === 1)
            {
                clean(child);
            }
        }
    }

    var dados_xml = document.getElementById('tree_to_show').innerHTML;

    parser_xml = new DOMParser();
    xmlDoc = parser_xml.parseFromString(dados_xml,"text/xml");

    //auxílio
    console.dir(xmlDoc);

    //Remover espaços #Text nos nós, que apenas complicam a vida
    clean(xmlDoc);

    //Declarar variável global para monitorar nível
    var profundidade = 0;
    var node_Parent = "";

    //Array que registra quantos elementos em cada nível.
    //As posições são níveis e o conteúdo a quantidade de elementos.
    //Por definição, Nível 0 sempre será igual a 1.
    //A cada novo nível, a nova posição é criada.

    var maior_X = 0;
    var menor_X = 0;

    var conta_Nivel = [];
    conta_Nivel[0]=1;

    var Bloco = function(Pai) {

        this.ID_Pai = Pai;
        this.ID;
        this.nome;
        this.nome_elemento=[];
        this.tipo_Elemento=[];
        this.valor_elemento=[];

    }



    //Array de objetos Mesh
    var Caixas = [];
    var Caixas_Arrays=[];


    function XPlore_xmlDoc(xmlDoc) {

        var Objeto_XML;
        var Objeto_XML_Size = 0;

        Objeto_XML = xmlDoc;
        Objeto_XML_Size = Objeto_XML.documentElement.childNodes.length;


        Caixas_Arrays[Caixas_Arrays.length] = [ 0,
            profundidade,
            "Container",
            Objeto_XML.documentElement.nodeName,
            "" ]

        if (Objeto_XML_Size > 0) {

            if (Objeto_XML.documentElement.nodeType != 3) {

                profundidade++;
                node_Parent = Objeto_XML.documentElement.nodeName;

                for (var ciclo = 0; ciclo < Objeto_XML_Size; ciclo++) {
                    XPlore_childNodes(Objeto_XML.documentElement.childNodes[ciclo]);
                }
                profundidade--;
            }
        }

    }

    function XPlore_childNodes(xmlDoc_childNodes) {

        //Registra o contador de elemementos por nível

        conta_Nivel[profundidade]=conta_Nivel[profundidade] + 1;

        var string_nodeValue = "START";
        var Objeto_XML;
        var Objeto_XML_Size = 0;

        Objeto_XML = xmlDoc_childNodes;

        if (Objeto_XML.nodeType != 3) {
            string_nodeValue = Objeto_XML.childNodes[0].nodeValue;
        }

        Objeto_XML_Size = Objeto_XML.childNodes.length;
        node_Type = Objeto_XML.childNodes[0].nodeType;

        afastador = "";
        //if (Objeto_XML_Size == 1) {
        if (Objeto_XML_Size == 1 && node_Type == 3) {

            if (Objeto_XML.childNodes[0].nodeType == 3) {

                Caixas_Arrays[Caixas_Arrays.length] = [ Caixas.length,
                    profundidade,
                    "Folha",
                    Objeto_XML.nodeName,
                    Objeto_XML.childNodes[0].nodeValue]
            }
        }
        else
        {
            Caixas_Arrays[Caixas_Arrays.length] = [ Caixas.length,
                profundidade,
                "Container",
                Objeto_XML.nodeName,
                "" ]
        }

        if (Objeto_XML_Size > 0) {

            if (Objeto_XML.nodeType != 3) {

                if (string_nodeValue !== null) {

                }
                else
                {
                    profundidade++;
                    node_Parent = Objeto_XML.nodeName;
                    for (var ciclo = 0; ciclo < Objeto_XML_Size; ciclo++) {
                        XPlore_childNodes(Objeto_XML.childNodes[ciclo]);
                    }
                    profundidade--;
                }
            }
        }
    }

    //Extração de informações do xmlDoc para Caixas_Arrays[]
    XPlore_xmlDoc(xmlDoc);

    //Criando uma nova cena
    var scene = new THREE.Scene();

    // Criando e posicionando uma nova câmera
    var camera01 = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.1, 1000);
    //var camera01 = new THREE.PerspectiveCamera( -10, 10, -10, 10, 1, 1000 );

    camera01.position.z = 20;
    var renderer = new THREE.WebGLRenderer({antialias: true});
    renderer.setClearColor("#e5e5e5");
    renderer.setSize(window.innerWidth,window.innerHeight);

    document.body.appendChild(renderer.domElement);

    window.addEventListener('resize', () => {
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera01.aspect = window.innerWidth / window.innerHeight;

        camera01.updateProjectionMatrix();
    })

    //var controls = new THREE.OrbitControls( camera01, renderer );

    //Ativando RayCaster para clicar em objetos

    var raycaster = new THREE.Raycaster();
    var mouse = new THREE.Vector2();

    //Preparando impressor de caixas
    var Texto_Geometria;
    var Texto_Material;
    var loader;
    var Texto_Mesh;
    var objetos=[];
    var conta_Objetos=0;


    function plotar_Caixa(i, texto, x, y, z, anormalidade) {

        loader = new THREE.FontLoader();

        loader.load("helvetiker_bold.typeface.json", function(res) {

            Texto_Geometria = new THREE.TextGeometry(texto, {
                font: res,
                size: 0.3,
                height: 0.2,
                curveSegments: 12,
                bevelEnabled: false,
                bevelThickness: 0.1,
                bevelSize: 0.1,
                bevelOffset: 0,
                bevelSegments: 1
            });

            if (anormalidade == "true") {
                //Se anormalidade = "true", material do texto vai ficar amarelo. Se for "false", verde claro!
                Texto_Material = new THREE.MeshLambertMaterial({ color : 0xFFFF00});

            } else {

                Texto_Material = new THREE.MeshLambertMaterial({ color : 0x00FF00});

            }

            Texto_Mesh = new THREE.Mesh(Texto_Geometria,Texto_Material);
            Texto_Mesh.name = texto;

            scene.add(Texto_Mesh);

            objetos[conta_Objetos]=[Texto_Mesh.name, Texto_Mesh.uuid];
            conta_Objetos++;

            Texto_Mesh.position.x = x;
            Texto_Mesh.position.y = y;
            Texto_Mesh.position.z = z;

            //Criando caixas que vão envolver os textos. As dimensões foram encontrados por experimentação.
            Caixa_Geometria = new THREE.BoxGeometry(5.5, 0.55, 0.36);

            if (anormalidade == "true") {
                //Se anormalidade = "true", material da caixa que envolve o texto vai ficar vermelho escuro. Se for "false", verde escuro!
                Caixa_Material = new THREE.MeshLambertMaterial({ color : 0x880000});
            } else {
                Caixa_Material = new THREE.MeshLambertMaterial({ color : 0x004400});
            }


            Caixa_Mesh = new THREE.Mesh(Caixa_Geometria, Caixa_Material);

            Caixa_Mesh.position.x = x + 2.6;
            Caixa_Mesh.position.y = y+0.10;
            Caixa_Mesh.position.z = z;

            scene.add(Caixa_Mesh);

        });
    }




    function imprime_Caixas(caixas) {

        N_Caixas = caixas.length;
        largura_Caixas = 0.75; //1 metro

        for (i=0; i < N_Caixas; i++) {
            ponto_X = 2*i*largura_Caixas - N_Caixas*largura_Caixas;

            plotar_Caixa(i, caixas[i], ponto_X, -1, 0);
        }
    }




    function imprime_arvore(arvore) {

        for (i=0; i < Caixas_Arrays.length; i++) {

            largura_Caixa = 0.60;
            altura_Caixa  = 0.25;
            ponto_Y_Partida = 10;
            ponto_X_Partida = -1;


            index_Caixa = arvore[i][0];
            nivel_Caixa = arvore[i][1];
            tipo_Caixa  = arvore[i][2];
            label_Caixa = arvore[i][3];
            valor_Caixa = arvore[i][4];



            ponto_Y = ponto_Y_Partida - 2 * index_Caixa * altura_Caixa;
            ponto_X = ponto_X_Partida + 2 * nivel_Caixa * largura_Caixa;

            if (tipo_Caixa == "Container") {
                plotar_Caixa(i, label_Caixa, ponto_X, ponto_Y, 0);
            }

            if (tipo_Caixa == "Folha") {
                plotar_Caixa(i, label_Caixa + ": " + valor_Caixa, ponto_X, ponto_Y, 0);
            }
        }
    }




    //****************************************************************************
    // Função para imprimir o arbusto de caixas
    //****************************************************************************

    function imprime_arbusto(arbusto) {

        console.log("-----------------------------------");
        console.log("-----------------------------------");

        largura_Caixa = 3;
        altura_Caixa  = 0.25;
        ponto_Y_Partida = 0;
        ponto_X_Partida = 0;
        nivel_Profundo=0;
        Cursor_Virtual = [0, 0, 0];
        ponto_X = 0;
        ponto_Y = 0;
        ponto_Z = 0;

        //Determinando qual o nível mais profundo do arbusto

        for (i=0; i < arbusto.length; i++) {
            if ( arbusto[i][1] > nivel_Profundo) {
                nivel_Profundo = arbusto[i][1];
            }
        }
        console.log("nivel_Profundo = " + nivel_Profundo);


        //Determinando as localizações Y dos níveis

        Y_Nivel = [];
        Y_Hiato = 17 * altura_Caixa; // Distância entre os níveis
        Y_Altitude = Y_Hiato * (nivel_Profundo + 1); // Comprimento total entre o nível mais alto e o mais baixo
        ponto_Y_Partida = (-0.5) * Y_Altitude; // Determinação do ponto de partida com centralização vertical

        for (i=0; i <= nivel_Profundo; i++) {
            Y_Nivel[i] = ponto_Y_Partida +
                Y_Hiato * (nivel_Profundo + 1 - i); // Determinando o Y de cada nível

            console.log("Y_Nivel[" + i + "] = " + Y_Nivel[i]);

        }



        // Contando quantas caixas existem no primeiro nível Container,
        // ou seja, o penúltimo nível. Necessário pois os elementos
        // com valores são os de nível mais baixo, ou seja, folhas.
        // Elementos folhas de um mesmo container serão impressos empilhados.
        // Então a largura da base da árvore será do número dos Containeres
        // de nível mais baixo.
        // Importante que nível mais alto é o  profundidade ZERO.
        // Níveis mais baixos têm, portanto, profundidade MAIOR.
        // Um nível mais ALTO tem profundidade MENOR.

        conta_Nivel_Profundo = 0;

        for (i=0; i < arbusto.length; i++) {
            if ( arbusto[i][1] == (nivel_Profundo - 1)) {
                conta_Nivel_Profundo++;
            }
        }

        console.log("conta_Nivel_Profundo = " + conta_Nivel_Profundo);

        // Descobrindo as dimensões do nível de Container mais baixo

        largura_Nivel_Profundo = 2 * conta_Nivel_Profundo * largura_Caixa;
        ultima_Caixa_Nivel_Profundo_X = largura_Nivel_Profundo / 2;

        ponto_X_Partida	= ultima_Caixa_Nivel_Profundo_X;
        ponto_Y_Partida = (-1.0) * (nivel_Profundo + 1) * (altura_Caixa);
        ponto_Z_Partida = 0;


        Cursor_Virtual = [ponto_X_Partida, ponto_Y_Partida, ponto_Z_Partida];

        console.log("Quantidade de caixas no Nível " + nivel_Profundo + ": " + conta_Nivel_Profundo);0

        // Criando array de auxílio à armazenagem de coordenadas.
        var Array_Coordenadas = [];
        // Criando array de auxílio ao cálculo de coordenadas.
        var Array_Calculo=[];

        //for (i = 1; i < Array_Calculo.length; i++) {
        //   Array_Calculo = 0;
        //}

        // Uma vez que já temos a coordenada X da última caixa, tudo será sincronizado a partir dela.
        // Imprimindo caixas do último nível, da direita para a esquerda
        // A varredura do algoritmo de determinação das coordenadas de cada caixa
        // deve caminhar no array <arbusto> da última folha até o topo. tomando decisõs na caminhada
        // de maneira a se desenhar as caixas da maneira desejada.

        //var Buffer_Profundidade = -1000;
        var Buffer_Profundidade = 0;
        var Buffer_Tipo = "";

        //Para inicialização, Buffer_Profundidade_Anterior e Buffer_Tipo_Anterior
        // serão considerados de nível 0
        var Buffer_Profundidade_Anterior = nivel_Profundo; // Para inicialização
        var Buffer_Tipo_Anterior = "Folha"; // Para inicialização,

        var freio_X = 0;
        var passos_X = 0;
        var internivel_Caixa = 0;

        var conta_Tipo_Folha = 0;
        var flag_Anormalidade = "";

        // Os laços e condicionais aninhados tomam as decisões de determinação
        // de coordenadas das caixas de maneira a montar uma árvore.



        for (i = Caixas_Arrays.length -1 ; i > 0; i--) {

            //O elemento na minha frente é do mesmo nível que o meu?
            Buffer_Profundidade = arbusto[i][1];
            Buffer_Tipo = arbusto[i][2];
            Buffer_label = arbusto[i][3] + " " + arbusto[i][4]

            console.log(
                "Index i: " + i + " / " +
                "Buffer_Profundidade: " + Buffer_Profundidade + " / " +
                "Buffer_Profundidade_Anterior: " + Buffer_Profundidade_Anterior + " / " +
                "Buffer_Tipo: " + Buffer_Tipo + " / " +
                "Buffer_Tipo_Anterior: " + Buffer_Tipo_Anterior + " / " +
                "conta_Tipo_Folha: " + conta_Tipo_Folha + " / " +
                "Buffer_Label: " + Buffer_label
            );

            //Se o nivel atual é maior, a coordenada X deste elemento deve ser a mesma da anterior,
            //pois o Y vai aumentar e teremos empilhamento.
            // Para localizar as coordenadas das caixas, utilizaremos o conceito
            // de cursos de Plotter que se move a partir dos X, Y e Z iniciais
            // e vai "gravando" as caixas. As regras de movimentação dele dependem
            // do elemento atual e do anterior.

            // Se o elemento é uma folha, deve se empilhar com as folhas irmãs
            // até que encontre seu Container o qual, obrigatoriamente, sobe
            // de nível. Então, sua coordenada X não deve mudar. Em compensação,
            // as caixas de elementos devem ser renderizadas abaixo da linha dos
            // containeres. O Cursor virtual de renderização deve ser decrementado.

            // Os níveis de Containeres serão fixos e pré determinados
            // Elementos com valores serão incorporados como propriedades
            // dos containeres, e não como subelementos


            //*****************************************************
            // Início de tratamento para Buffer_Tipo = "Folha"
            //*****************************************************
            if (Buffer_Tipo == "Folha") {

                // Se o Buffer_Profundidade desta folha for mais profundo do que o elemento
                // anterior (que deve ser um Container), é uma nova pilha de folhas.
                // O Y deve ser o do nível do container dos valores menos um nível.
                // Os valores serão impressos como elementos do Container.
                // O incremento que imprime as caixas das folhas para baixo deve ser zerado.
                // A priori uma folha com valor não consegue ser inferior a outra folha,
                // pois terá que passar pelo Container antes de mudar de nível. Mas
                // deixaremos esta instrução assim.

                if (Buffer_Profundidade > Buffer_Profundidade_Anterior) {


                    if (Buffer_Tipo_Anterior == "Folha") {
                        conta_Tipo_Folha = 0;
                        console.log("Folha zerada aqui...");
                        // Um caso de folha que cai de nível
                        // a partir de outra folha não existe
                        // neste modelo. Mas deixaremos ajustes
                        // para profilaxia.
                        //Alterações de X e Y para este caso:
                        // Zera contagem de folhas
                        //conta_Tipo_Folha=0; //
                        // X vai para a esquerda
                        // Y assume o nível do elemento
                        ponto_X = ponto_X - 2 * largura_Caixa;
                        ponto_Y = ponto_Y_Partida - Buffer_Profundidade * 1 * altura_Caixa;
                        conta_Tipo_Folha++;


                    }

                    if (Buffer_Tipo_Anterior == "Container") {

                        // Elemento anterior era um container e o elemento novo é uma folha
                        // de nível mais baixo que o elemento container anterior.
                        //Alterações de X e Y para este caso:
                        // Zera contagem de folhas
                        conta_Tipo_Folha=0; //
                        console.log("Folha zerada aqui...");
                        // X vai para a esquerda
                        // Y assume o nível de partida do elemento container superior menos
                        // um degrau para a folha ser desenhada abaixo do container.
                        ponto_X = ponto_X - 2 * largura_Caixa;
                        ponto_Y = Y_Nivel[Buffer_Profundidade - 1]
                            - (conta_Tipo_Folha + 1) * 1 * altura_Caixa;

                        conta_Tipo_Folha++; // Conta que uma folha já se passou
                        Buffer_Tipo_Anterior = Buffer_Tipo; // Guarda informações para próxima iteração
                        Buffer_Profundidade_Anterior = Buffer_Profundidade;  // Guarda informações para próxima iteração

                    }

                }


                // Se o Buffer_Profundidade desta folha é igual ao Buffer_Profundidade_Anterior,
                // o elemento anterior pode ser um Container ou uma folha. Se o
                // o elemento anterior for uma folha com valor, o cursor deve
                // descer o ponto_Y para imprimir abaixo da folha anterior.
                // Se o elemento anterior for um container, esta folha é elemento
                // de Container irmão que possui valor e deve ser representado
                // como atributos da caixa pai, diferente de container irmão
                // que contém outros containers.

                if (Buffer_Profundidade == Buffer_Profundidade_Anterior) {

                    if (Buffer_Tipo_Anterior = "Folha") {
                        //Alterações de X e Y para este caso
                        // X permanece igual
                        // Y desce para empilhar a folha
                        ponto_X = ponto_X;
                        ponto_Y = Y_Nivel[Buffer_Profundidade - 1]
                            - (conta_Tipo_Folha + 1) * 2 * altura_Caixa;

                        //****************************************************
                        if (i == Caixas_Arrays.length -1) {
                            ponto_Y = Y_Nivel[Buffer_Profundidade - 1]
                                - (++conta_Tipo_Folha + 1) * 2 * altura_Caixa;

                        }

                        console.log("conta_Tipo_Folha = " + conta_Tipo_Folha)
                        conta_Tipo_Folha++;
                        console.log("conta_Tipo_Folha++ = " + conta_Tipo_Folha)

                    }

                    if (Buffer_Tipo_Anterior == "Container") {
                        // Alterações de X e Y para este caso
                        // X se move para a esquerda
                        // Se estamos em um novo valor de um container
                        // devemos nos mover para o nível do container
                        // e descer em Y para acrescentar o valor
                        conta_Tipo_Folha=0;
                        console.log("Folha zerada aqui...");

                        ponto_X = ponto_X
                        ponto_Y = Y_Nivel[Buffer_Profundidade - 1]
                            - (conta_Tipo_Folha + 1) * 2 * altura_Caixa;
                        conta_Tipo_Folha++;


                    }
                }


                if (Buffer_Profundidade < Buffer_Profundidade_Anterior) {

                    if (Buffer_Tipo_Anterior == "Folha") {
                        //Alterações de X e Y para este caso
                        // Não há este caso na modelagem atual


                    }

                    if (Buffer_Tipo_Anterior == "Container") {
                        //Alterações de X e Y para este caso
                        // Não há este caso na modelagem atual


                    }
                }
            } //Fim de de tratamento para Buffer_Tipo = "Folha"



            //*****************************************************
            // Início de tratamento para Buffer_Tipo = "Container"
            //*****************************************************

            if (Buffer_Tipo == "Container") {

                // Se o Buffer_Profundidade desta folha for mais profundo do que o elemento
                // anterior (que deve ser um Container), é uma nova pilha de folhas.
                // O Y deve ser o do nível do elemento o incremento que imprime as
                // caixas das folhas para baixo deve ser, por segurança, zerado.

                if (Buffer_Profundidade > Buffer_Profundidade_Anterior) {
                    conta_Tipo_Folha = 0;
                    // X deve se deslocar para a esquerda
                    // Y deve se ajustar com Buffer_Profundidade


                    if (Buffer_Tipo_Anterior == "Folha") {
                        // Um caso de folha que cai de nível
                        // a partir de outra folha não existe
                        // neste modelo. Mas deixaremos ajustes
                        // para profilaxia.
                        //Alterações de X e Y para este caso:
                        // Zera contagem de folhas
                        conta_Tipo_Folha=0; //
                        console.log("Folha zerada aqui...");
                        // X vai para a esquerda
                        // Y assume o nível do elemento
                        ponto_X = ponto_X;
                        ponto_Y = Y_Nivel[Buffer_Profundidade];

                    }

                    if (Buffer_Tipo_Anterior == "Container") {

                        ponto_X = ponto_X - 2 * largura_Caixa;
                        ponto_Y = Y_Nivel[Buffer_Profundidade];

                    }


                }


                // Se o Buffer_Profundidade desta folha é igual ao Buffer_Profundidade_Anterior,
                // o elemento anterior pode ser um Container ou uma folha. Se o
                // o elemento anterior for uma folha, uma folha, o cursor deve
                // descer o ponto_Y para imprimir abaixo da folha anterior.
                // Se o elemento anterior for um container,

                if (Buffer_Profundidade == Buffer_Profundidade_Anterior) {

                    if (Buffer_Tipo_Anterior == "Folha") {
                        //Não existe este caso nesta modelagem

                    }

                    if (Buffer_Tipo_Anterior == "Container") {
                        // Alterações de X e Y para este caso
                        // X se move para a esquerda
                        // Y permanece;
                        ponto_X = ponto_X - 2 * largura_Caixa;
                        ponto_Y = ponto_Y;

                    }
                }


                if (Buffer_Profundidade < Buffer_Profundidade_Anterior) {

                    if (Buffer_Tipo_Anterior == "Folha") {
                        //Alterações de X e Y para este caso
                        conta_Tipo_Folha = 0;
                        console.log("Folha zerada aqui...");
                        // X permanece no mesmo lugar
                        // Y desce para imprimir a caixa
                        ponto_X = ponto_X;
                        ponto_Y = Y_Nivel[Buffer_Profundidade];

                    }

                    if (Buffer_Tipo_Anterior == "Container") {
                        //Alterações de X e Y para este caso
                        // X permanece no mesmo lugar
                        // Y assume o novo nível
                        ponto_X = ponto_X;
                        ponto_Y = Y_Nivel[Buffer_Profundidade];


                    }
                }
            } //Fim de tratamento para Buffer_Tipo = "Container"
            //************************************************************
            //************************************************************


            Array_Coordenadas[i] = [ponto_X, ponto_Y, ponto_Z];
            Buffer_Profundidade_Anterior = Buffer_Profundidade;
            Buffer_Tipo_Anterior = Buffer_Tipo;


            console.log("X: " + ponto_X + "   Y: " + ponto_Y + "   Z: " + ponto_Z);
        }

        // Centralizando as coordenadas X das caixas de nível superior
        // em relação às caixas de nível inferior
        // Criar um Array que guarde a média presente de X de cada nível

        nivel_X_Acumulador = [];
        nivel_X_Divisor = [];
        //filhos_Acumulador = []; // Guarda as coordenadas dos elementos filhos de um pai


        //inicializar nivel_X_Acumulador com 0 e quantidade de elementos igual aos níveis

        for (j = 0; j <= nivel_Profundo; j++) {

            nivel_X_Acumulador[j] = 0;
            nivel_X_Divisor[j] = 0;
            //filhos_Acumulador[j] = 0;

        }



        console.log("");
        console.log("");
        console.log("************************************************************")
        console.log("");
        console.log("");


        console.log("nivel_X_Acumulador.length = " +  nivel_X_Acumulador.length);

        // Inicializando buffers de profundidade e tipo
        Buffer_Profundidade_Anterior = nivel_Profundo;
        Buffer_Tipo_Anterior = "Folha";




        for (i = Caixas_Arrays.length -1 ; i > 0; i--) {

            // Fazer a média de X de todo elemento dentro de um nível

            Buffer_Profundidade = arbusto[i][1];
            Buffer_Tipo = arbusto[i][2];
            Buffer_label = arbusto[i][3] + " " + arbusto[i][4]
            ponto_X = Array_Coordenadas[i][0];

            console.log("");
            console.log(
                "Index i: " + i + " / " +
                "Buffer_Profundidade: " + Buffer_Profundidade + " / " +
                "Buffer_Profundidade_Anterior: " + Buffer_Profundidade_Anterior + " / " +
                "Buffer_Tipo: " + Buffer_Tipo + " / " +
                "Buffer_Tipo_Anterior: " + Buffer_Tipo_Anterior + " / " +
                "Buffer_Label: " + Buffer_label
            );

            for (j = 0; j <= nivel_Profundo; j++) {

                console.log("nivel_X_Acumulador[" + j + "] = " + nivel_X_Acumulador[j] + " / " +
                    "nivel_X_Divisor[" + j + "] = " + nivel_X_Divisor[j]);

            }



            // Acumulando e contabilizando coordenadas X de cada nível
            if (Buffer_Profundidade == Buffer_Profundidade_Anterior) {

                if (Buffer_Tipo_Anterior != "Container") {

                    console.log("Elemento anterior não é container...")
                    console.log(" Array_Coordenadas[" + i + "][0] = " +
                        Array_Coordenadas[i][0] + " / " + Buffer_label)

                    nivel_X_Acumulador[Buffer_Profundidade] =
                        nivel_X_Acumulador[Buffer_Profundidade] + ponto_X;
                    nivel_X_Divisor[Buffer_Profundidade] =
                        nivel_X_Divisor[Buffer_Profundidade] + 1;

                    acumula = nivel_X_Acumulador[Buffer_Profundidade];
                    divide = nivel_X_Divisor[Buffer_Profundidade];

                    console.log("acumula = " + acumula);
                    console.log("divide = " + divide);
                }

                if ((Buffer_Tipo == "Folha") && (Buffer_Tipo_Anterior == "Container")) {

                    // Esta folha é filha de um nível superior. Deve-se lidar como se fosse
                    // coordenada X do nível superior.

                    Buffer_Profundidade = Buffer_Profundidade - 0;
                    Buffer_Profundidade_Anterior = Buffer_Profundidade_Anterior - 0;

                    console.log("Detectada transição de container para folha de mesmo nível...");
                    console.log("Antes --> Array_Coordenadas[" + i + "][0] = " +
                        Array_Coordenadas[i][0])

                    acumula = nivel_X_Acumulador[Buffer_Profundidade_Anterior];
                    divide = nivel_X_Divisor[Buffer_Profundidade_Anterior];

                    // (nivel_X_Acumulador[Buffer_Profundidade_Anterior]) / (nivel_X_Divisor[Buffer_Profundidade_Anterior]);

                    console.log("Dentro do IF nivel_X_Acumulador[" +
                        Buffer_Profundidade_Anterior + "] = " +
                        nivel_X_Acumulador[Buffer_Profundidade_Anterior]
                    )


                    console.log("Dentro do IF nivel_X_Divisor[" +
                        Buffer_Profundidade_Anterior + "] = " +
                        nivel_X_Divisor[Buffer_Profundidade_Anterior]
                    )

                    console.log("acumula = " + acumula);
                    console.log("divide = " + divide);
                    console.log("acumula/divide = " + acumula/divide);
                    Array_Coordenadas[i][0] = acumula/divide;


                    console.log("Depois --> Array_Coordenadas[" + i + "][0] = " +
                        Array_Coordenadas[i][0])

                    console.log("Não resetaremos acumulador e divisor...")
                    //nivel_X_Acumulador[Buffer_Profundidade_Anterior] = 0;
                    //nivel_X_Divisor[Buffer_Profundidade_Anterior] = 0;

                    // Sem alterações nas profundidades
                    Buffer_Profundidade_Anterior = Buffer_Profundidade_Anterior;
                    Buffer_Tipo_Anterior = Buffer_Tipo_Anterior;
                }



            }

            if (Buffer_Profundidade > Buffer_Profundidade_Anterior) {

                console.log("Profundidade maior que a anterior...")
                console.log(" Array_Coordenadas[" + i + "][0] = " +
                    Array_Coordenadas[i][0] + " / " + Buffer_label)

                nivel_X_Acumulador[Buffer_Profundidade] =
                    nivel_X_Acumulador[Buffer_Profundidade] + ponto_X;
                nivel_X_Divisor[Buffer_Profundidade] =
                    nivel_X_Divisor[Buffer_Profundidade] + 1;



                acumula = nivel_X_Acumulador[Buffer_Profundidade];
                divide = nivel_X_Divisor[Buffer_Profundidade];

                console.log("acumula = " + acumula);
                console.log("divide = " + divide);

            }

            // Se há uma transição de nível direta, reescrever a coordenada X do nível atual
            // com a média das coordenadas X do nível anterior e zerar acumuladores e divisor
            // do nível anterior

            if (Buffer_Profundidade < Buffer_Profundidade_Anterior)         {

                //if (Buffer_Tipo_Anterior != "Container") {

                console.log("Detectada transição de nível para cima...");
                console.log("Antes --> Array_Coordenadas[" + i + "][0] = " +
                    Array_Coordenadas[i][0])

                acumula = nivel_X_Acumulador[Buffer_Profundidade_Anterior];
                divide = nivel_X_Divisor[Buffer_Profundidade_Anterior];

                // (nivel_X_Acumulador[Buffer_Profundidade_Anterior]) / (nivel_X_Divisor[Buffer_Profundidade_Anterior]);

                console.log("Dentro do IF nivel_X_Acumulador[" +
                    Buffer_Profundidade_Anterior + "] = " +
                    nivel_X_Acumulador[Buffer_Profundidade_Anterior]
                )


                console.log("Dentro do IF nivel_X_Divisor[" +
                    Buffer_Profundidade_Anterior + "] = " +
                    nivel_X_Divisor[Buffer_Profundidade_Anterior]
                )

                console.log("acumula = " + acumula);
                console.log("divide = " + divide);
                console.log("acumula/divide = " + acumula/divide);
                Array_Coordenadas[i][0] = acumula/divide;

                //Acumulando para nível superior
                nivel_X_Acumulador[Buffer_Profundidade] =
                    nivel_X_Acumulador[Buffer_Profundidade] + Array_Coordenadas[i][0];
                nivel_X_Divisor[Buffer_Profundidade] =
                    nivel_X_Divisor[Buffer_Profundidade] + 1;



                console.log("Resetando acumulador e divisor...")
                nivel_X_Acumulador[Buffer_Profundidade_Anterior] = 0;
                nivel_X_Divisor[Buffer_Profundidade_Anterior] = 0;


                //}
            }

            Buffer_Profundidade_Anterior = Buffer_Profundidade;
            Buffer_Tipo_Anterior = Buffer_Tipo;

        }



        // Imprimindo as caixas
        for (i = Caixas_Arrays.length -1 ; i > 0; i--) {

            index_Caixa = arbusto[i][0];
            nivel_Caixa = arbusto[i][1];
            tipo_Caixa  = arbusto[i][2];
            label_Caixa = arbusto[i][3];
            valor_Caixa = arbusto[i][4];

            ponto_X = Array_Coordenadas[i][0];
            ponto_Y = Array_Coordenadas[i][1];
            ponto_Z = Array_Coordenadas[i][2];

            console.log("X: " + ponto_X + "   Y: " + ponto_Y + "   Z: " + ponto_Z);
            console.log("Elemento: " + label_Caixa + " " + valor_Caixa);


            if (label_Caixa == "anormalidade") {
                flag_Anormalidade = valor_Caixa;
                console.log("flag_Anormalidade: " + flag_Anormalidade);
            }

            if (tipo_Caixa == "Container") {
                plotar_Caixa(i, label_Caixa, ponto_X, ponto_Y, ponto_Z, flag_Anormalidade);
            }

            if (tipo_Caixa == "Folha") {
                plotar_Caixa(i, label_Caixa + ": " + valor_Caixa, ponto_X, ponto_Y, ponto_Z, flag_Anormalidade);
            }
            flag_Anormalidade = false;
        }

        // **********************************************************************************
        // Imprimindo linhas a partir de Array_Coordenadas e arbusto
        // **********************************************************************************
        console.log("");
        console.log("");
        console.log("");
        console.log("********************************************");
        console.log("********************************************");
        console.log("********************************************");
        console.log("");
        console.log("");
        console.log("Imprimindo as linhas das caixas na tela...")
        console.log("");

        //criando array que vai guardar as coordenadas acumuladas de cada nível
        var filhos_Acumulador_X = [];
        var filhos_Acumulador_Y = [];

        //inicializando filhos_Acumulador
        for (j = 0; j <= nivel_Profundo; j++) {

            filhos_Acumulador_X[j] = []; //inicializando elementos deste array como arrays
            filhos_Acumulador_Y[j] = []; //inicializando elementos deste array como arrays

        }

        console.log("Conferindo filhos_Acumulador_X.length = " + filhos_Acumulador_X.length);
        console.log("Conferindo filhos_Acumulador_Y.length = " + filhos_Acumulador_Y.length);

        // Preparando material e geometria das linhas
        var linha_Material = new THREE.LineBasicMaterial( { color: 0x0000ff } );
        var linha_Geometry = new THREE.Geometry();

        // Inicializando variáveis de controle

        Buffer_Profundidade_Anterior = nivel_Profundo;
        Buffer_Tipo_Anterior = "Folha";
        tamanho_Parcial_X = 0;
        tamanho_Parcial_Y = 0;

        // Iniciando laço para percorrer o Array_Coordenadas[] e o arbusto[]

        for (i = Caixas_Arrays.length -1 ; i > 0; i--) {

            console.log("Explorando elemento " + i);

            // Guardando informações das caixas para log
            index_Caixa = arbusto[i][0];
            nivel_Caixa = arbusto[i][1];
            tipo_Caixa  = arbusto[i][2];
            label_Caixa = arbusto[i][3];
            valor_Caixa = arbusto[i][4];

            // Guardando coordenadas do ponto atual
            ponto_X = Array_Coordenadas[i][0];
            ponto_Y = Array_Coordenadas[i][1];
            ponto_Z = Array_Coordenadas[i][2]; // É NECESSÁRIO?

            // Guardando os extremos laterais da cena
            if (ponto_X > maior_X) { maior_X = ponto_X};
            if (ponto_X < menor_X) { menor_X = ponto_X};

            Buffer_Profundidade = nivel_Caixa;

            // Acumulando arrays de 3 coordenadas em cada nivel

            //filhos_Acumulador[nivel_Caixa].push([ponto_X, ponto_Y, ponto_Z]);

            tamanho_Parcial_X = filhos_Acumulador_X[nivel_Caixa].length;
            tamanho_Parcial_Y = filhos_Acumulador_Y[nivel_Caixa].length;

            console.log("X: " + ponto_X + "   Y: " + ponto_Y + "   Z: " + ponto_Z);
            console.log("Elemento: " + label_Caixa + " " + valor_Caixa);

            console.log("Tamanho_Parcial X e Y " + nivel_Caixa + " = " +
                tamanho_Parcial_X + ", " + tamanho_Parcial_Y);

            filhos_Acumulador_X[nivel_Caixa][tamanho_Parcial_X] = ponto_X;
            filhos_Acumulador_Y[nivel_Caixa][tamanho_Parcial_Y] = ponto_Y;

            console.log("filhos_Acumulador_X[" + nivel_Caixa + "] = "
                + filhos_Acumulador_X[nivel_Caixa]);

            console.log("filhos_Acumulador_Y[" + nivel_Caixa + "] = "
                + filhos_Acumulador_Y[nivel_Caixa]);



            // Caso haja transição de nível de Container de menor para maior
            if (Buffer_Profundidade < Buffer_Profundidade_Anterior) {

                console.log("Detectada transição de nível de menor para maior...");
                console.log("Elemento: " + label_Caixa + " " + valor_Caixa);

                ponto_X_Pai = ponto_X;
                ponto_Y_Pai = ponto_Y;

                filhos_Quantidade = filhos_Acumulador_X[Buffer_Profundidade_Anterior].length;
                console.log("filhos_Quantidade = " + filhos_Quantidade);

                console.log("ponto_X_Pai = " + ponto_X_Pai);
                console.log("ponto_Y_Pai = " + ponto_Y_Pai);

                for (k = 0; k < filhos_Quantidade; k++) {

                    ponto_X_Filho = filhos_Acumulador_X[Buffer_Profundidade_Anterior][k];
                    ponto_Y_Filho = filhos_Acumulador_Y[Buffer_Profundidade_Anterior][k];

//linha_Geometry.vertices.push(new THREE.Vector3( 10*Math.sin(k),10*Math.cos(k) , 0) );

                    var linha_Material = new THREE.LineBasicMaterial( { color: 0x00cc00, linewidth: 1 } );
                    var linha_Geometry = new THREE.Geometry();
                    linha_Geometry.vertices.push(new THREE.Vector3( ponto_X_Pai, ponto_Y_Pai, 0) );
                    linha_Geometry.vertices.push(new THREE.Vector3( ponto_X_Filho, ponto_Y_Filho, 0) );
                    var linha_Caixas = new THREE.Line( linha_Geometry, linha_Material );

                    console.log("ponto_X_Filho = " + ponto_X_Filho);
                    console.log("ponto_Y_Filho = " + ponto_Y_Filho);


                    scene.add(linha_Caixas);

                }

                // Resetando acumuladores do nível anterior
                console.log("Resetando acumuladores do nível " + Buffer_Profundidade_Anterior);
                filhos_Acumulador_X[Buffer_Profundidade_Anterior] = []; //inicializando elementos deste array como arrays
                filhos_Acumulador_Y[Buffer_Profundidade_Anterior] = []; //inicializando elementos deste array como arrays
                console.log("");




            }

            Buffer_Profundidade_Anterior = Buffer_Profundidade;
            Buffer_Tipo_Anterior = Buffer_Tipo;

        }



    }
    //}



    //imprime_arvore(Caixas_Arrays);
    imprime_arbusto(Caixas_Arrays);

    // Adicionando luz direcional
    var light = new THREE.PointLight(0xFFFFFf, 1, 500);
    light.position.set(10, 0, 25);
    scene.add(light);

    var light_2 = new THREE.PointLight(0xFFFFFf, 1, 500);
    light_2.position.set(0, 0, 25);
    scene.add(light_2);

    // Renderizando animações
    var angulo = 0;
    var angulo2 = 0;
    var angulo3 = 0;

    console.log("maior e menor X: " + maior_X + " / " + menor_X);

    var render = function() {

        requestAnimationFrame(render);

        angulo2 += 0.005;
        camera01.position.z = 15 + 0*(Math.cos(0.75*angulo2)+Math.sin(0.75 *angulo2));
        camera01.position.x = menor_X + (maior_X - menor_X) * 0.5 *(1 + Math.sin(0.4*angulo2));
        camera01.position.y = 3.0 + 1*(Math.cos(1 *angulo2));
        camera01.rotation.z = 0.0*(Math.sin(1 *angulo2));
        //camera01.rotation.x = 0.05*(Math.sin(1 *angulo2));
        // camera01.rotation.y = 0.05*(Math.sin(1.4 *angulo2));

        light_2.position.z = camera01.position.z;
        light_2.position.x = camera01.position.x;
        light_2.position.y = camera01.position.y;

        //document.getElementById("X_Camera").innerHTML = camera01.position.x;

        renderer.render(scene, camera01);

    }


    for (i=0; i < scene.children.length; i++) {
        console.log("scene.children[" + i + "]: " +
            scene.children[i].id + " " + scene.children[i].type);
        // +
        //" " + scene.children[i].children[0].type);
    }


    function onMouseMove(event) {

        if(event.target.id !== 'link-admin'){
            event.preventDefault();
        }

        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;

        /*
        document.getElementById("mouse_pos_x").innerHTML = mouse.x;
        document.getElementById("mouse_pos_y").innerHTML = mouse.y;
        document.getElementById("event_client_x").innerHTML = event.clientX;
        document.getElementById("event_client_y").innerHTML = event.clientY;
        */

        raycaster.setFromCamera(mouse, camera01);
        var intersects = raycaster.intersectObjects(scene.children, true);


        var lista_intersects = "";
        var lista_nomes = "";
        for (var i = 0; i < intersects.length; i++) {
            lista_intersects = lista_intersects + 'Objeto ' +
                intersects[i].object.id + ": " +
                intersects[i].object.geometry.type + '    ';

            lista_nomes = lista_nomes +

                'Nome: ' + intersects[i].object.name + " " +
                'Outros: ' + intersects[i].object.outros + " " +
                'userData: ' + intersects[i].object.userData + " - " +
                'UUID: ' + intersects[i].object.uuid + " - ";


        }
        //document.getElementById("info").innerHTML = lista_intersects;
        //document.getElementById("info_Mais").innerHTML = lista_nomes;



        for (var i = 0; i < intersects.length; i++) {

            var cor1 = Math.round(Math.random()*255);
            var cor2 = Math.round(Math.random()*255);
            var cor3 = Math.round(Math.random()*255)
            var cor_rgb = 'rgb('+cor1+','+cor2+','+ cor3+ ')';

            intersects[i].object.material.color.set(cor_rgb);
            //document.getElementById("info").innerHTML = intersects[i].object.id & " " & intersects[i].object.geometry.id;
            //document.getElementById("info").innerHTML = 'Objeto ' + intersects[i].object.id + ": " + intersects[i].object.geometry.type

        }
    }



    render();

    window.addEventListener('click', onMouseMove);

</script>

</body>
</html>
