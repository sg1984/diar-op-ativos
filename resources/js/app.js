/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$(".form-delete").on("submit", function(){
    return confirm("Confirma exclusão?");
});

// ####### Testes WebGL #######
// ####### Testes WebGL #######
// ####### Testes WebGL #######
// ####### Testes WebGL #######
// ####### Testes WebGL #######

//var scene = new THREE.Scene();
// script src="./Three/three.js-master/src/Three.js"
/*
PerspectiveCamera( fov : Number, aspect : Number, near : Number, far : Number )
fov — Camera frustum vertical field of view.
aspect — Camera frustum aspect ratio.
near — Camera frustum near plane.
far — Camera frustum far plane.
*/

const WIDTH = 1000;
const HEIGHT = 650;

//Criando uma nova cena
var scene = new THREE.Scene();

// Criando e posicionando uma nova câmera
var camera01 = new THREE.PerspectiveCamera(
    75,
    WIDTH/HEIGHT,
    0.1,
    1000);

camera01.position.z = 5;

//
var renderer = new THREE.WebGLRenderer({antialias: true});
renderer.setClearColor("#e5e5e5");
renderer.setSize(WIDTH,HEIGHT);

document.getElementById("webgl-object").appendChild(renderer.domElement);

window.addEventListener('resize', () => {
    renderer.setSize(WIDTH,HEIGHT);
    camera01.aspect = WIDTH/HEIGHT;
    camera01.updateProjectionMatrix();
});

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
    scene.add(mesh3);
}

// var mesh3 = new THREE.Mesh(geometry3, new THREE.MeshLambertMaterial({color: 0xFF0000}));
// mesh3.position.x = (Math.random() - 0.5) * 10;
// mesh3.position.y = (Math.random() - 0.5) * 10;
// mesh3.position.z = (Math.random() - 0.5) * 10;
// scene.add(mesh3);

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

    renderer.render(scene, camera01);
};

function onMouseMove(event) {
    event.preventDefault();

    mouse.x = (event.clientX / WIDTH) * 2 - 1;
    mouse.y = - (event.clientY / HEIGHT) * 2 + 1;

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
