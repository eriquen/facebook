<?php 
session_start();
require_once __DIR__ . '/Facebook/autoload.php';

$fb = new \Facebook\Facebook([
  'app_id' => '267300427630678',
  'app_secret' => '21a11c0f0594bc603704f3b324d52b07',
  'default_graph_version' => 'v6.0',
]);

   $permissions = []; // optional
   $helper = $fb->getRedirectLoginHelper();
   $accessToken = $helper->getAccessToken();
   
if (isset($accessToken)) {
	
 		$url = "https://graph.facebook.com/v2.6/me?fields=friends{first_name,gender,birthday}&access_token={$accessToken}";
		$headers = array("Content-type: application/json");
		
			 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		 curl_setopt($ch, CURLOPT_URL, $url);
	     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		 curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
		 curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		 curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		   
		 $st = curl_exec($ch); 
		 $result = json_decode($st,TRUE);
		 $friends = $result['friends']['data'];

		 
		 foreach ($friends as $friend){
             echo $friend['first_name'] . "<br>";
             gettype($friend['first_name']);
         }
         var_dump($friends);
         $total = count($friends);
         $total = $total;
         $rowCol = ceil(sqrt($total));
		 //  echo "My name: ".$result['friends']['data']['first_name'];
?>	


<!DOCTYPE html>
<html>
<head>
    <title>Three.js Periodic Table Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <style>
        html, body {
            height: 100%;
        }

        body {
            background-color: #000000;
            margin: 0;
            font-family: Helvetica, sans-serif;;
            overflow: hidden;
        }

        a {
            color: #ffffff;
        }

        #menu {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }

        .element {
            width: 120px;
            height: 160px;
            box-shadow: 0px 0px 12px rgba(0, 255, 255, 0.5);
            border: 1px solid rgba(127, 255, 255, 0.25);
            text-align: center;
            cursor: default;

        }

        .element:hover {
            box-shadow: 0px 0px 12px rgba(0, 255, 255, 0.75);
            border: 1px solid rgba(127, 255, 255, 0.75);
            backdrop-filter: blur(16px);
        }

        .element .number {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 12px;
            color: rgba(127, 255, 255, 0.75);
        }

        .element .name {
            position: absolute;
            top: 40px;
            left: 0px;
            right: 0px;
            font-size: 20px;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.75);
            text-shadow: 0 0 10px rgba(0, 255, 255, 0.95);
        }

        .element .details {
            position: absolute;
            bottom: 15px;
            left: 0px;
            right: 0px;
            font-size: 12px;
            color: rgba(127, 255, 255, 0.75);
        }

/* Female */
        .element1 {
            width: 120px;
            height: 160px;
            box-shadow: 0px 0px 12px rgb(247,133,255,0.25);
            border: 1px solid rgb(247, 133, 255, 0.25);
            text-align: center;
            cursor: default;

        }

        .element1:hover {
            box-shadow: 0px 0px 12px rgb(247,133,255,0.75);
            border: 1px solid rgb(247, 133, 255, 0.75);
            backdrop-filter: blur(16px);
        }

        .element1 .number {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 12px;
            color: rgb(255,171,241,0.75);
        }

        .element1 .name {
            position: absolute;
            top: 40px;
            left: 0px;
            right: 0px;
            font-size: 20px;
            font-weight: bold;
            color: rgb(255,171,241,0.75);
            text-shadow: 0 0 10px rgb(255,171,241,0.95);
        }

        .element1 .details {
            position: absolute;
            bottom: 15px;
            left: 0px;
            right: 0px;
            font-size: 12px;
            color: rgb(255,171,241,0.75);
        }
        button {
            color: rgba(127, 255, 255, 0.75);
            background: transparent;
            outline: 1px solid rgba(127, 255, 255, 0.75);
            border: 0px;
            padding: 5px 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgba(0, 255, 255, 0.5);
        }

        button:active {
            color: #000000;
            background-color: rgba(0, 255, 255, 0.75);
        }
        .login{
            background-color: green;
        }
    </style>
</head>
<body>

<script src="./lib/three.js"></script>
<script src="./lib/Tween.min.js"></script>
<script src="./lib/controls/TrackballControls.js"></script>
<script src="./lib/renderers/CSS3DRenderer.js"></script>

<div id="container"></div>


<div id="menu">
    <button id="table">TABLE</button>
    <button id="sphere">SPHERE</button>
    <button id="helix">HELIX</button>
    <button id="grid">GRID</button>
</div>
<script>
   <?php echo $rowCol; 
   $x = 0;
   $y = 0;
   ?>
   
const table = [
    <?php foreach ($friends as $friend){?>

    <?php if($y == $rowCol)
        $x = $x + 1;
        $y = 0;
    ?>

    "<?php echo $friend['first_name'];?>","<?php echo $friend['gender'];?>","<?php echo $friend['birthday'];?>", <?php echo $x;?>, <?php echo $y;?>,

    <?php $y = $y + 1; } ?>  

    "Aishah", "female", "<?php echo $friend['birthday'];?>", <?php echo $x;?>, <?php echo $y;?>,
];
console.log(table);
let camera, scene, renderer, controls, composer;
var hblur, vblur;
let targets = {simple: [], table: [], sphere: [], helix: [], grid: []};

init();
animate();

function init() {

    initCamera();

    initScene();

    initObjects();

    addClickListeners();

    initRenderer();

    initTrackbarControls();

    transform(targets.table, 2000);

    window.addEventListener('resize', onWindowResize, false);

}

function initCamera() {

    camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 1, 10000);
    camera.position.z = 3000;

}

function initScene() {

    scene = new THREE.Scene();

}

function initRenderer() {

    renderer = new THREE.CSS3DRenderer();
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.getElementById('container').appendChild(renderer.domElement);
}

function initObjects() {

    simpleObjectsLayout();
    generateGeometricLayouts();

}

function addClickListeners() {

    addClickListener(targets.table, 'table');
    addClickListener(targets.sphere, 'sphere');
    addClickListener(targets.helix, 'helix');
    addClickListener(targets.grid, 'grid');

}

function simpleObjectsLayout() {

    for (let i = 0; i < table.length; i += 5) {

        let object = new THREE.CSS3DObject(htmlElement(table, i));
        object.position.x = Math.random() * 4000 - 2000;
        object.position.y = Math.random() * 4000 - 2000;
        object.position.z = Math.random() * 4000 - 2000;

        scene.add(object);
        targets.simple.push(object);
        tableLayout(table, i);

    }

}

function htmlElement(table, i) {
    let element = document.createElement('div');
    if(table[i+1] == "female"){
        element.className = 'element1';
    }else{
        element.className = 'element';
    }
    if(table[i+1] == "female"){
        element.style.backgroundColor = 'rgba(161, 42, 121,' + (Math.random() * 0.5 + 0.25) + ')';
    }else{
        element.style.backgroundColor = 'rgba(0, 127, 127,' + (Math.random() * 0.5 + 0.25) + ')';
    }
    let number = document.createElement('div');
    number.className = 'number';
    number.textContent = (i / 5) + 1;
    element.appendChild(number);

    let name = document.createElement('div');
    name.className = 'name';
    name.textContent = table[i];
    element.appendChild(name);

    let details = document.createElement('div');
    details.className = 'details';
    details.innerHTML = table[i + 1] + '<br>' + table[i + 2];
    element.appendChild(details);

    element.addEventListener('click', ()=>elementClickHandler(i), false);

    return element;
}

function elementClickHandler(i){

    transform(targets.table,1000);

    new TWEEN.Tween(targets.simple[i / 5].position)
        .to({
            x: 0,
            y: 0,
            z: 2500
        }, Math.random() * 2000 + 2000)
        .easing(TWEEN.Easing.Exponential.InOut)
        .start();

    new TWEEN.Tween(this)
        .to({}, 2000 * 2)
        .onUpdate(render)
        .start();
}

function tableLayout(table, index) {

    let object = new THREE.Object3D();

    object.position.x = (table[index + 3] * 140) - 1330;
    object.position.y = -(table[index + 4] * 180) + 990;
    targets.table.push(object);

}

function addClickListener(target, elementId) {

    const button = document.getElementById(elementId);

    button.addEventListener('click', function () {
        transform(target, 2000);
    }, false);

}

function initTrackbarControls() {
    controls = new THREE.TrackballControls(camera, renderer.domElement);
    controls.rotateSpeed = 0.5;
    controls.minDistance = 500;
    controls.maxDistance = 6000;
    controls.addEventListener('change', render);
}

function generateGeometricLayouts() {

    let sphereVector = new THREE.Vector3();
    let helixVector = new THREE.Vector3();

    for (let i = 0, l = targets.simple.length; i < l; i++) {
        addSphereObject(sphereVector, i, l);
        addHelixObject(helixVector, i);
        addGridObject(i);
    }

}

function addSphereObject(sphereVector, index, length) {

    const phi = Math.acos(-1 + (2 * index) / length);
    const theta = Math.sqrt(length * Math.PI) * phi;
    let object = new THREE.Object3D();

    object.position.setFromSphericalCoords(800, phi, theta);

    sphereVector.copy(object.position).multiplyScalar(2);

    object.lookAt(sphereVector);

    targets.sphere.push(object);
}

function addHelixObject(helixVector, index) {

    const theta = index * 0.175 + Math.PI;
    const y = -(index * 8) + 450;
    let object = new THREE.Object3D();

    object.position.setFromCylindricalCoords(900, theta, y);

    helixVector.x = object.position.x * 2;
    helixVector.y = object.position.y;
    helixVector.z = object.position.z * 2;

    object.lookAt(helixVector);

    targets.helix.push(object);
}

function addGridObject(index) {

    let object = new THREE.Object3D();
    object.position.x = ((index % 5) * 400) - 800;
    object.position.y = (-(Math.floor(index / 5) % 5) * 400) + 800;
    object.position.z = (Math.floor(index / 25)) * 1000 - 2000;
    targets.grid.push(object);

}

function transform(target, duration) {

    TWEEN.removeAll();

    for (let i = 0; i < targets.simple.length; i++) {
        let object = targets.simple[i];
        let targetObject = target[i];
        transformObjectPosition(object, targetObject, duration);
        transformObjectRotation(object, targetObject, duration);
    }

    new TWEEN.Tween(this)
        .to({}, duration * 2)
        .onUpdate(render)
        .start();

}

function transformObjectPosition(object, targetObject, duration) {

    new TWEEN.Tween(object.position)
        .to({
            x: targetObject.position.x,
            y: targetObject.position.y,
            z: targetObject.position.z
        }, Math.random() * duration + duration)
        .easing(TWEEN.Easing.Exponential.InOut)
        .start();

}

function transformObjectRotation(object, targetObject, duration) {

    new TWEEN.Tween(object.rotation)
        .to({
            x: targetObject.rotation.x,
            y: targetObject.rotation.y,
            z: targetObject.rotation.z
        }, Math.random() * duration + duration)
        .easing(TWEEN.Easing.Exponential.InOut)
        .start();

}

function onWindowResize() {

    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
    render();

}

function render() {

    renderer.render(scene, camera);

}

function animate() {

    requestAnimationFrame(animate);
    TWEEN.update();
    controls.update();
    composer.render();
}

</script>
</body>
</html>

<?php 
} else {

	$loginUrl = $helper->getLoginUrl('http://localhost/facebook2/', $permissions);
	echo '<a style="color:white;background-color:#3b5998;padding:20px;text-decoration:none;display:flex;justify-content:center;align-item:center " href="' . $loginUrl . '">Login with Facebook</a>';
}
?>
