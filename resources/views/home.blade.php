
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

<h1 id="info">Testando WebGL</h1>

<table>
    <tr rowspan="2">
        <td>
            <a class="nav-link" href="{{ route('regional.index') }}">{{ __('Regionais') }}</a>
        </td>
    </tr>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/102/three.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js"></script>

<script>

    //var scene = new THREE.Scene();
    // script src="./Three/three.js-master/src/Three.js"
    /*
    PerspectiveCamera( fov : Number, aspect : Number, near : Number, far : Number )
    fov — Camera frustum vertical field of view.
    aspect — Camera frustum aspect ratio.
    near — Camera frustum near plane.
    far — Camera frustum far plane.
    */

    //Criando uma nova cena
    var scene = new THREE.Scene();

    // Criando e posicionando uma nova câmera
    var camera01 = new THREE.PerspectiveCamera(
        75,
        window.innerWidth/window.innerHeight,
        0.1,
        1000);

    camera01.position.z = 5;


    //
    var renderer = new THREE.WebGLRenderer({antialias: true});
    renderer.setClearColor("#e5e5e5");
    renderer.setSize(window.innerWidth,window.innerHeight);

    document.body.appendChild(renderer.domElement);

    window.addEventListener('resize', () => {
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera01.aspect = window.innerWidth / window.innerHeight;

        camera01.updateProjectionMatrix();
    })

    var raycaster = new THREE.Raycaster();
    var mouse = new THREE.Vector2();


    var geometry = new THREE.BoxGeometry(1, 1, 1);
    var material = new THREE.MeshLambertMaterial({color: 0xFFCC00});
    var geometry2 = new THREE.SphereGeometry(1, 12, 12);
    var material2 = new THREE.MeshLambertMaterial({color: 0xCCFF00});
    var mesh = new THREE.Mesh(geometry, material);
    var mesh2 = new THREE.Mesh(geometry2, material2);

    mesh.position.x = 0;

    scene.add(mesh);
    scene.add(mesh2);

    for (var i = 0; i < 15; i++) {

        var geometry3 = new THREE.ConeGeometry(0.5, 1, 8);
        var material3 = new THREE.MeshLambertMaterial({color: 0x00CCff});

        var mesh3 = new THREE.Mesh(geometry3, material3);
        mesh3.position.x = (Math.random() - 0.5) * 4;
        mesh3.position.y = (Math.random() - 0.5) * 4;
        mesh3.position.z = (Math.random() - 0.5) * 4;

        mesh3.rotation.x += 0.1;
        mesh3.rotation.z += 0.1;
        //mesh3.id = "Cone_" + i;

        scene.add(mesh3);
    }

    var mesh3 = new THREE.Mesh(geometry3, new THREE.MeshLambertMaterial({color: 0xFF0000}));
    mesh3.position.x = (Math.random() - 0.5) * 10;
    mesh3.position.y = (Math.random() - 0.5) * 10;
    mesh3.position.z = (Math.random() - 0.5) * 10;
    scene.add(mesh3);

    var light = new THREE.PointLight(0xFFFFFf, 1, 500);
    light.position.set(10, 0, 25);
    scene.add(light);

    //renderer.render(scene, camera01);
    var angulo = 0;
    var angulo2 = 0;
    var angulo3 = 0;

    var render = function() {

        requestAnimationFrame(render);

        mesh.rotation.x += 0.05;
        mesh.rotation.z += 0.05;
        mesh2.rotation.x += 0.0125;
        mesh2.rotation.z += 0.0125;

        mesh3.rotation.x += 0.025;
        mesh3.rotation.z += 0.025;

        //mesh.position.x = 1*(Math.sin(5*mesh.rotation.z));
        //mesh.position.y = 1*(Math.cos(5*mesh.rotation.z));


        angulo += 0.05;
        mesh.position.x = 1.8*(Math.sin(angulo));
        mesh.position.y = 1.8*(Math.cos(angulo));
        mesh.position.z = 1*(Math.cos(0.25*angulo)+Math.sin(0.25*angulo));
        angulo2 += 0.025;
        mesh2.position.x = 1.0*(Math.sin(angulo2));
        mesh2.position.y = 1.0*(Math.cos(angulo2));
        mesh2.position.z = 0.75*(Math.cos(0.25*angulo2)+Math.sin(0.25*angulo2));

        angulo3 += 0.0125;
        mesh3.position.x = 1.0*(Math.sin(angulo3));
        mesh3.position.y = 1.0*(Math.cos(angulo3));
        mesh3.position.z = 0.75*(Math.cos(0.125*angulo3)+Math.sin(0.125*angulo3));
        //mesh.position.z = 1.8*(Math.tan(-1*angulo));
        //camera01.updateProjectMatrix();
        renderer.render(scene, camera01);

    }


    //----------------------------------------------------------
    /*
            var loader = new THREE.FontLoader();

            loader.load( 'fonts/helvetiker_regular.typeface.json', function ( font ) {

                var text_geometry = new THREE.TextGeometry( 'Hello three.js!', {
                    font: font,
                    size: 80,
                    height: 5,
                    curveSegments: 12,
                    bevelEnabled: true,
                    bevelThickness: 10,
                    bevelSize: 8,
                    bevelOffset: 0,
                    bevelSegments: 5
                } );
            } );

            var text_mesh = new THREE.Mesh(text_geometry, material);

    */
    //=========================================================

    function onMouseMove(event) {
        // event.preventDefault();

        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;

        document.getElementById("mouse_pos_x").innerHTML = mouse.x;
        document.getElementById("mouse_pos_y").innerHTML = mouse.y;
        document.getElementById("event_client_x").innerHTML = event.clientX;
        document.getElementById("event_client_y").innerHTML = event.clientY;

        raycaster.setFromCamera(mouse, camera01);
        var intersects = raycaster.intersectObjects(scene.children, true);


        var lista_intersects = "";
        for (var i = 0; i < intersects.length; i++) {
            lista_intersects = lista_intersects + 'Objeto ' + intersects[i].object.id + ": " + intersects[i].object.geometry.type + '    ';
        }
        document.getElementById("info").innerHTML = lista_intersects;


        for (var i = 0; i < intersects.length; i++) {

            var cor1 = Math.round(Math.random()*255);
            var cor2 = Math.round(Math.random()*255);
            var cor3 = Math.round(Math.random()*255)
            var cor_rgb = 'rgb('+cor1+','+cor2+','+ cor3+ ')';

            intersects[i].object.material.color.set(cor_rgb);
        }
    }
    render();
    window.addEventListener('click', onMouseMove);
</script>

</body>
</html>
