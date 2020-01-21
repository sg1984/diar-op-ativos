<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
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
            border: 5px solid black;
            padding: .2em;
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
<script id="tree_to_show" type="text/xmldata">
    {!! $treeXml !!}
</script>

<h3 id="info">Testando WebGL</h3>
<h4 id="info_Mais">Mais testes</h4>
<H5 Id="info_Ponto">Qual ponto?</H5>

<table>
    <tr>
        <td><h2 id="mouse_pos_x_label">MOUSE.X</h2></td>
        <td><h2 id="mouse_pos_x">_-_-_</h2></td>
    </tr>
    <tr>
        <td><h2 id="mouse_pos_y_label">MOUSE.Y</h2></td>
        <td><h2 id="mouse_pos_y">_-_-_</h2></td>
    </tr>
    <tr>
        <td><h2 id="event_client_x_label">EVENT.X</h2></td>
        <td><h2 id="event_client_x">_-_-_</h2></td>
    </tr>
    <tr>
        <td><h2 id="event_client_y_label">EVENT.Y</h2></td>
        <td><h2 id="event_client_y">_-_-_</h2></td>
    </tr>
</table>


<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/110/three.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three-orbitcontrols@2/OrbitControls.js"></script>


<script>

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


    var txt="";
    //var dados_xml="";

    //var dados_xml = document.getElementById('myxml').innerHTML;
    var dados_xml = document.getElementById('tree_to_show').innerHTML;

    //var dados_xml = document.getElementById('books').innerHTML;
    //dados_xml.replace(/[\t ]+\</g, "<");

    parser_xml = new DOMParser();
    xmlDoc = parser_xml.parseFromString(dados_xml,"text/xml");
    // documentElement always represents the root node
    //console.dir(dados_xml);
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

        console.log("Início da função XPlore xmlDoc em profundidade " +
            profundidade + ":" );

        console.log(    "Objeto_XML: " +
            (Objeto_XML = xmlDoc));

        console.log(    "nodeName = " +
            Objeto_XML.documentElement.nodeName     )

        console.log(    "Número de Atributos: " +
            Objeto_XML.documentElement.attributes.length);

        for (var atr = 0; atr < Objeto_XML.documentElement.attributes.length; atr++)
        {
            console.log(    "Atributos: " +
                Objeto_XML.documentElement.attributes[atr].nodeName +
                " = " +
                Objeto_XML.documentElement.attributes[atr].nodeValue     )
        }
        console.log(    "Número de childNodes: " +
            (Objeto_XML_Size = Objeto_XML.documentElement.childNodes.length ));

        for (var i=0; i < Objeto_XML_Size; i++) {

            if (Objeto_XML.documentElement.childNodes[i].childNodes[0].nodeType === 1) {

                console.log("   Este elemento de " +
                    Objeto_XML.documentElement.nodeName +
                    " é container de outros elementos!")

                console.log("childNode[" + i +  "].nodeName = " +
                    Objeto_XML.documentElement.childNodes[i].nodeName +
                    ", .nodeType = " +
                    Objeto_XML.documentElement.childNodes[i].nodeType +
                    ", .childNodes.length = " +
                    Objeto_XML.documentElement.childNodes[i].childNodes.length);
            }

            if (Objeto_XML.documentElement.childNodes[i].childNodes[0].nodeType === 3) {

                console.log("   Este elemento de " +
                    Objeto_XML.documentElement.nodeName +
                    " é elemento folha e possui informação!")

                console.log("childNode[" + i +  "].nodeName = " +
                    Objeto_XML.documentElement.childNodes[i].nodeName +
                    ", .nodeType = " +
                    Objeto_XML.documentElement.childNodes[i].nodeType +
                    ", .childNodes[0].nodeValue = " +
                    Objeto_XML.documentElement.childNodes[i].childNodes[0].nodeValue);
            }

        }

        console.log(    "node_Nome = " +
            Objeto_XML.documentElement.childNodes[0].childNodes[0].nodeValue);

        console.log(    "nodeType = " +
            Objeto_XML.documentElement.nodeType     )

        console.log(    "nodeValue = " +
            Objeto_XML.documentElement.childNodes[0].nodeName )

        console.log("");

        Caixas[Caixas.length] = "Caixas[" +
            Caixas.length +
            "]: " +
            Objeto_XML.documentElement.nodeName;
        // +
        //" - " +
        //Objeto_XML.documentElement.childNodes[0].childNodes[0].nodeValue;
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

        console.log("Fim da função XPlore xmlDoc em profundidade " +
            profundidade + ":" );
        console.log("");
        console.log("");
    }

    function XPlore_childNodes(xmlDoc_childNodes) {

        //Registra o contador de elemementos por nível

        conta_Nivel[profundidade]=conta_Nivel[profundidade] + 1;

        var string_nodeValue = "START";
        var Objeto_XML;
        var Objeto_XML_Size = 0;

        console.log("Início da função XPlore childNodes em profundidade " +
            profundidade + ":" );

        console.log("node_Parent: " + node_Parent);
        console.log("profundidade_Parent: " + (profundidade - 1));


        console.log(    "Objeto_XML: " +
            (Objeto_XML = xmlDoc_childNodes));

        console.log(    "Número de Atributos: " +
            Objeto_XML.attributes.length);

        for (var atr = 0; atr < Objeto_XML.attributes.length; atr++)
        {
            console.log(    "Atributos: " +
                Objeto_XML.attributes[atr].nodeName +
                " = " +
                Objeto_XML.attributes[atr].nodeValue     )
        }

        console.log(    "nodeName = " +
            Objeto_XML.nodeName     )

        console.log(    "nodeType = " +
            Objeto_XML.nodeType     )

        if (Objeto_XML.nodeType != 3) {
            console.log(    "nodeValue = " +
                (string_nodeValue =
                    Objeto_XML.childNodes[0].nodeValue)  )
        }

        console.log(    "childNodes length = " +
            (Objeto_XML_Size = Objeto_XML.childNodes.length)  )

        console.log(    "childNodes nodeType = " +
            (node_Type = Objeto_XML.childNodes[0].nodeType)  )
        afastador = "";
        //if (Objeto_XML_Size == 1) {
        if (Objeto_XML_Size == 1 && node_Type == 3) {
            if (Objeto_XML.childNodes[0].nodeType == 3) {
                texto_Caixas = "Caixas[" +
                    Caixas.length +
                    "]: " +
                    "[" + profundidade + "] " +
                    afastador.repeat(profundidade) +
                    Objeto_XML.nodeName +
                    ": " +
                    Objeto_XML.childNodes[0].nodeValue;

                Caixas_Arrays[Caixas_Arrays.length] = [ Caixas.length,
                    profundidade,
                    "Folha",
                    Objeto_XML.nodeName,
                    Objeto_XML.childNodes[0].nodeValue]

            }

            //valores_Caixas = {profundidade, Objeto_XML.nodeName, Objeto_XML.childNodes[0].nodeValue};

        }
        else
        {  texto_Caixas = "Caixas[" +
            Caixas.length +
            "]: " +
            "[" + profundidade + "] " +
            afastador.repeat(profundidade) +
            Objeto_XML.nodeName;

            Caixas_Arrays[Caixas_Arrays.length] = [ Caixas.length,
                profundidade,
                "Container",
                Objeto_XML.nodeName,
                "" ]
        }

        Caixas[Caixas.length] = texto_Caixas;

        if (Objeto_XML_Size > 0) {

            if (Objeto_XML.nodeType != 3) {

                //console.log("Teste string_NodeValue = " +
                //            string_nodeValue);

                if (string_nodeValue !== null) {
                    //     console.log("Valor " + string_nodeValue + " achado!")
                }
                else
                {
                    profundidade++;
                    node_Parent = Objeto_XML.nodeName;
                    for (var ciclo = 0; ciclo < Objeto_XML_Size; ciclo++) {
                        //        console.log("Aplicando ciclo " + ciclo + "...");
                        XPlore_childNodes(Objeto_XML.childNodes[ciclo]);
                    }
                    profundidade--;
                }
            }
        }

        console.log("Fim da função XPlore childNodes em profundidade " +
            profundidade + ":" );
        console.log("");
    }

    //Extração de informações do xmlDoc para Caixas_Arrays[]
    XPlore_xmlDoc(xmlDoc);


    for (i = 0; i < Caixas_Arrays.length; i++) {
        console.log(    Caixas_Arrays[i][0] + " " +
            Caixas_Arrays[i][1] + " " +
            Caixas_Arrays[i][2] + " " +
            Caixas_Arrays[i][3] + " " +
            Caixas_Arrays[i][4] + " "
        );
    }
    /*
         for (i = 0; i < Caixas_Arrays.length; i++) {
             console.log(Caixas[i]);
         }

         for (i = 0; i < conta_Nivel.length; i++) {
             console.log("Número de elementos no nível [" +
                         i + "] = " + conta_Nivel[i]);
         }
 */



    //Criando uma nova cena
    var scene = new THREE.Scene();

    // Criando e posicionando uma nova câmera
    var camera01 = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.1, 1000);
    //var camera01 = new THREE.PerspectiveCamera( -10, 10, -10, 10, 1, 1000 );

    camera01.position.z = 20;
    console.log ("Olha window.innerWidth é " + window.innerWidth);
    console.log ("Olha window.innerHeight é " + window.innerHeight);


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

    var raycaster = new THREE.Raycaster();
    var mouse = new THREE.Vector2();
    /*
            var geometry = new THREE.BoxGeometry(1, 1, 1);
            var material = new THREE.MeshLambertMaterial({color: 0xFFCC00});
            var geometry2 = new THREE.SphereGeometry(1, 12, 12);
            var material2 = new THREE.MeshLambertMaterial({color: 0xCCFF00});
            var mesh = new THREE.Mesh(geometry, material);
            var mesh2 = new THREE.Mesh(geometry2, material2);
    */
    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    //https://cdnjs.cloudflare.com/ajax/libs/three.js/102/three.js
    /*
            var loader = new THREE.FontLoader();
            var geometry_Texto;
            var mesh_Texto;


            loader.load( 'fonts/helvetiker_regular.typeface.json', function ( font ) {

                geometry_Texto = new THREE.TextGeometry( 'Rodando!', {
                font: font,
                size: 3,
                height: 1,
                curveSegments: 12,
                bevelEnabled: false,
                bevelThickness: 10,
                bevelSize: 1,
                bevelOffset: 0,
                bevelSegments: 5
            } );


        mesh_Texto = new THREE.Mesh(geometry_Texto, material2);
        mesh_Texto.position.x = 0;
        mesh_Texto.position.y = 0;
        mesh_Texto.position.z = -30;
        scene.add(mesh_Texto);
        console.log('font: ' + font);
        console.log('geometry_Texto: ' + geometry_Texto);
        console.log('mesh_Texto: ' + mesh_Texto);

        } );
    */
    // console.log('geometry_Texto fora : ' + geometry_Texto);
    //console.log('mesh_Texto : ' + mesh_Texto);


    var Texto_Geometria;
    var Texto_Material;
    var loader;
    var Texto_Mesh;
    var objetos=[];
    var conta_Objetos=0;





    function benda_4(i, texto, x, y, z, anormalidade) {

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

                Texto_Material = new THREE.MeshLambertMaterial({ color : 0xFFFF00});

            } else {

                Texto_Material = new THREE.MeshLambertMaterial({ color : 0x00FF00});

            }

            Texto_Mesh = new THREE.Mesh(Texto_Geometria,Texto_Material);
            Texto_Mesh.name = texto;
            //console.log("Texto_Mesh.name = " + texto);
            scene.add(Texto_Mesh);

            objetos[conta_Objetos]=[Texto_Mesh.name, Texto_Mesh.uuid];
            conta_Objetos++;

            Texto_Mesh.position.x = x;
            Texto_Mesh.position.y = y;
            Texto_Mesh.position.z = z;

            Caixa_Geometria = new THREE.BoxGeometry(5.5, 0.55, 0.36);
            if (anormalidade == "true") {

                Caixa_Material = new THREE.MeshLambertMaterial({ color : 0x880000});

            } else {

                Caixa_Material = new THREE.MeshLambertMaterial({ color : 0x004400});

            }

            Caixa_Mesh = new THREE.Mesh(Caixa_Geometria, Caixa_Material);

            Caixa_Mesh.position.x = x + 2.6;
            Caixa_Mesh.position.y = y+0.10;
            Caixa_Mesh.position.z = z;

            scene.add(Caixa_Mesh);
            /*
               console.log( "Nome e UUID: " +
                             Texto_Mesh.name +
                             " " + Texto_Mesh.uuid +
                             " x:" + x + " y:" + y + " z:" + z

                             );
               console.log("conta_Objetos?????: " + conta_Objetos); */
        });

    }













    function imprime_Caixas(caixas) {

        N_Caixas = caixas.length;
        largura_Caixas = 0.75; //1 metro

        for (i=0; i < N_Caixas; i++) {
            ponto_X = 2*i*largura_Caixas - N_Caixas*largura_Caixas;

            benda_4(i, caixas[i], ponto_X, -1, 0);
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
                benda_4(i, label_Caixa, ponto_X, ponto_Y, 0);
            }

            if (tipo_Caixa == "Folha") {
                benda_4(i, label_Caixa + ": " + valor_Caixa, ponto_X, ponto_Y, 0);
            }
        }
    }










    function imprime_arbusto(arbusto) {

        console.log("-----------------------------------");
        console.log("-----------------------------------");

        largura_Caixa = 3;
        altura_Caixa  = 0.25;
        ponto_Y_Partida = 10;
        ponto_X_Partida = 0;
        nivel_Profundo=0;

        //Determinando quandos qual o nível mais profundo

        for (i=0; i < arbusto.length; i++) {
            if ( arbusto[i][1] > nivel_Profundo) {
                nivel_Profundo = arbusto[i][1];
            }
        }


        // Contando quantas caixas existem no nivel profundo Container
        conta_Nivel_Profundo = 0;
        for (i=0; i < arbusto.length; i++) {
            if ( arbusto[i][1] == (nivel_Profundo - 1)) {
                conta_Nivel_Profundo++;
            }
        }

        largura_Nivel_Profundo = 2 * conta_Nivel_Profundo * largura_Caixa;
        ultima_Caixa_Nivel_Profundo_X = largura_Nivel_Profundo / 2
        ponto_X_Partida	= ultima_Caixa_Nivel_Profundo_X
        ponto_Y_Partida = (-1.0) * (nivel_Profundo + 1) * (altura_Caixa);
        ponto_Z_Partida = 0;
        console.log("Quantidade de caixas no Nível " + nivel_Profundo + ": " + conta_Nivel_Profundo);

        //Criando array de auxílio às coordenadas, com mesmo tamanho do número de elementos no arbusto
        var Array_Coordenadas = [];
        //Criando array de auxílio ao cálculo de coordenadas de elemento superior, com mesmo tamanho de níveis
        var Array_Calculo=[];

        for (i = 1; i < Array_Calculo.length; i++) {
            Array_Calculo = 0;
        }

        //Uma vez que já temos a coordenada X da última caixa, tudo será sincronizado a partir dela.
        //Imprimindo caixas do último nível, da direita para a esquerda
        //Um algoritmo deve caminhar da última folha do arbusto até o topo
        Buffer_Nivel_Anterior = 10000000;
        freio_X = 0;
        passos_X = 0;
        conta_Tipo_Folha = 0;
        flag_Anormalidade = "";
        for (i = Caixas_Arrays.length -1 ; i > 0; i--) {

            //O elemento na minha frente é do mesmo nível que o meu?
            Buffer_Nivel = arbusto[i][1];
            Buffer_Tipo = arbusto[i][2];

            //Se o nivel atual é maior, a coordenada X deste elemento deve ser a mesma da anterior,
            //pois o Y vai aumentar e teremos empilhamento.
            if (Buffer_Nivel > Buffer_Nivel_Anterior) {
                freio_X = 1;
                internivel_Caixa = 5;
                console.log("freio_X = " + freio_X);
            } else {
                freio_X = 0;
                internivel_Caixa = 0;
                console.log("freio_X = " + freio_X);};

            console.log("internivel_Caixa: " + internivel_Caixa);
            if (Buffer_Tipo == "Container"){
                conta_Tipo_Folha = 0
                console.log("internivel_Caixa: " + internivel_Caixa);
                //Gravar as coordenadas do elemento atual.
                //ponto_X = 2 * (i - freio_X) * largura_Caixa - (largura_Nivel_Profundo/2);
                ponto_X = ponto_X_Partida - (passos_X - freio_X) * 2 * largura_Caixa;
                ponto_Y = - 2 * Buffer_Nivel * (altura_Caixa * (1 - internivel_Caixa)) - (nivel_Profundo/2);
                ponto_Z = ponto_Z_Partida;

                Array_Coordenadas[i] = [ponto_X, ponto_Y, ponto_Z];
                passos_X++;
                Buffer_Nivel_Anterior = Buffer_Nivel;
                freio_X = 0;
                internivel_Caixa = 0
            }

            if (Buffer_Tipo == "Folha") {
                console.log("internivel_Caixa: " + internivel_Caixa);
                conta_Tipo_Folha++;

                //Gravar as coordenadas do elemento atual.
                ponto_X = ponto_X_Partida - (passos_X - 0) * 2 * largura_Caixa;
                ponto_Y = - 2 * (Buffer_Nivel) * altura_Caixa - 2 * conta_Tipo_Folha * altura_Caixa - (nivel_Profundo/2);
                ponto_Z = ponto_Z_Partida;

                Array_Coordenadas[i] = [ponto_X, ponto_Y, ponto_Z];
                Buffer_Nivel_Anterior = Buffer_Nivel;
            }

            console.log("X: " + ponto_X + "   Y: " + ponto_Y + "   Z: " + ponto_Z);

            index_Caixa = arbusto[i][0];
            nivel_Caixa = arbusto[i][1];
            tipo_Caixa  = arbusto[i][2];
            label_Caixa = arbusto[i][3];
            valor_Caixa = arbusto[i][4];

            if (label_Caixa == "anormalidade") {
                flag_Anormalidade = valor_Caixa;
                console.log("flag_Anormalidade: " + flag_Anormalidade);
            }

            if (tipo_Caixa == "Container") {
                benda_4(i, label_Caixa, ponto_X, ponto_Y, ponto_Z, flag_Anormalidade);
            }

            if (tipo_Caixa == "Folha") {
                benda_4(i, label_Caixa + ": " + valor_Caixa, ponto_X, ponto_Y, 0, flag_Anormalidade);
            }
            flag_Anormalidade = false;
        }

    }

    /*
            for (i=0; i < Caixas_Arrays.length; i++) {
                index_Caixa = arvore[i][0];
                nivel_Caixa = arvore[i][1];
                tipo_Caixa  = arvore[i][2];
                label_Caixa = arvore[i][3];
                valor_Caixa = arvore[i][4];



                ponto_Y = ponto_Y_Partida - 2 * index_Caixa * altura_Caixa;
                ponto_X = ponto_X_Partida + 2 * nivel_Caixa * largura_Caixa;

            if (tipo_Caixa == "Container") {
                benda_4(i, label_Caixa, ponto_X, ponto_Y, 0);
            }

            if (tipo_Caixa == "Folha") {
                benda_4(i, label_Caixa + ": " + valor_Caixa, ponto_X, ponto_Y, 0);
            }
        }
    */


    //imprime_arvore(Caixas_Arrays);
    imprime_arbusto(Caixas_Arrays);

    /*
            mesh.position.x = 0;

            scene.add(mesh);
            scene.add(mesh2);
    */
    /*
            caixinhas = ["ACD", "BGI", "NTD", "RLD", "MCO"];

            imprime_Caixas(caixinhas);

            console.log("Quantos Objetos, cacete??" + conta_Objetos);
    */
    /*
            for (var i = 0; i < 0; i++) {
            var geometry3 = new THREE.ConeGeometry(0.5, 1, 8);
            var material3 = new THREE.MeshLambertMaterial({color: 0x00CCff});
            var geometry_Texto_2;
            var mesh_Texto_2;
            var loader_2 = new THREE.FontLoader();


                var mesh3 = new THREE.Mesh(geometry3, material3);
                //var mesh3 = new THREE.Mesh(geometry_Texto, material3);
                mesh3.position.x = (Math.random() - 0.5) * 4;
                mesh3.position.y = (Math.random() - 0.5) * 4;
                mesh3.position.z = (Math.random() - 0.5) * 4;
                mesh3.rotation.x += 0.1;
                mesh3.rotation.z += 0.1;
                mesh3.name = "Cone_" + i;
                mesh3.outros = "outros"+ i;

                scene.add(mesh3);
            }
    */
    /*        var mesh3 = new THREE.Mesh(geometry3, new THREE.MeshLambertMaterial({color: 0xFF0000}));
                mesh3.position.x = (Math.random() - 0.5) * 10;
                mesh3.position.y = (Math.random() - 0.5) * 10;
                mesh3.position.z = (Math.random() - 0.5) * 10;
                scene.add(mesh3);

    */

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

    var render = function() {

        requestAnimationFrame(render);

        //Texto_Mesh.rotation.x += 0.075;
        //Texto_Mesh.rotation.z += 0.075;

        /*
                    mesh.rotation.x += 0.05;
                    mesh.rotation.z += 0.05;

                    mesh2.rotation.x += 0.0125;
                    mesh2.rotation.z += 0.0125;

                    //mesh3.rotation.x += 0.025;
                   // mesh3.rotation.z += 0.025;

                    //mesh_Texto.rotation.x += 0.075;
                    //mesh_Texto.rotation.z += 0.075;

                    //mesh_Texto.rotation.x += 0.075;
                    //mesh_Texto.rotation.z += 0.075;

                    mesh.position.x = 1*(Math.sin(5*mesh.rotation.z));
                    mesh.position.y = 1*(Math.cos(5*mesh.rotation.z));

                    //mesh_Texto_2.rotation.x += 0.1;
                    //mesh_Texto_2.rotation.z += 0.1;




                    angulo += 0.05;
                    mesh.position.x = 1.8*(Math.sin(angulo));
                    mesh.position.y = 1.8*(Math.cos(angulo));
                    mesh.position.z = 1*(Math.cos(0.25*angulo)+Math.sin(0.25*angulo));
                    angulo2 += 0.025;
                    mesh2.position.x = 1.0*(Math.sin(angulo2));
                    mesh2.position.y = 1.0*(Math.cos(angulo2));
                    mesh2.position.z = 0.75*(Math.cos(0.25*angulo2)+Math.sin(0.25*angulo2));

                    angulo3 += 0.0125;
                   // mesh3.position.x = 1.0*(Math.sin(angulo3));
                    //mesh3.position.y = 1.0*(Math.cos(angulo3));
                    //mesh3.position.z = 0.75*(Math.cos(0.125*angulo3)+Math.sin(0.125*angulo3));
                    //mesh.position.z = 1.8*(Math.tan(-1*angulo));
                    //camera01.updateProjectMatrix();
        */
        angulo2 += 0.005;
        camera01.position.z = 7 + 1*(Math.cos(0.75*angulo2)+Math.sin(0.75 *angulo2));
        camera01.position.x = 0 + 125*(Math.cos(0.3*angulo2));
        camera01.position.y = -4 + 1*(Math.cos(1 *angulo2));
        //camera01.rotation.z = 0.2*(Math.sin(1 *angulo2));
        camera01.rotation.x = 0.0*(Math.sin(1 *angulo2));
        camera01.rotation.y = 0.0*(Math.sin(1.4 *angulo2));

        light_2.position.z = camera01.position.z;
        light_2.position.x = camera01.position.x;
        light_2.position.y = camera01.position.y;




        renderer.render(scene, camera01);

    }
    /*
    //var CACETA = scene.getObjectById( 2, true );
    //console.log("Aqui fora, Texto_Mesh.name vai ser " + Texto_Mesh.name);
    scene.traverse(function(child) {

        console.log("Traversando por " + child.type);


    })
    */

    for (i=0; i < scene.children.length; i++) {
        console.log("scene.children[" + i + "]: " +
            scene.children[i].id + " " + scene.children[i].type);
        // +
        //" " + scene.children[i].children[0].type);
    }
    // var CACETA = scene.getObjectById( 8, true );
    //console.log("Objetos 3D aqui: " + scene.children[8].type);

    function onMouseMove(event) {


        event.preventDefault();

        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;

        document.getElementById("mouse_pos_x").innerHTML = mouse.x;
        document.getElementById("mouse_pos_y").innerHTML = mouse.y;
        document.getElementById("event_client_x").innerHTML = event.clientX;
        document.getElementById("event_client_y").innerHTML = event.clientY;

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
        document.getElementById("info").innerHTML = lista_intersects;
        document.getElementById("info_Mais").innerHTML = lista_nomes;



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
