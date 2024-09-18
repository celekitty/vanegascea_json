<?php
require("conn.php");

$arreglo =  array(
    "success"=>false,
    "status"=>400,
    "data" => "",
    "message" => "",
    "cant" => 0
);


if ($_SERVER["REQUESTED_METHOD"]=== "GET"){
    if(isset($_GET["type"])&& $_GET["type"] != ""){

$conexion = new conexion;
$conn = $conexion->conectar();

$datos = $conn->query('SELECT * FROM empleado');
$resultados = $datos->fetchAll();

switch($GET["type"]){
    case "json":
        result_json($resultados);
        break;
        case"xml":
            result_xmñ($resultados);
            break;
            default:
            echo("Por favor, defina el tipo de resultado");
            break;
}
    
}else{
            $arreglo = array(
                "success"=>false,
                "status"=>array("status_code"=>412, "status_text"=> "Precondition failed"),
                "data" => "",
                "message" => "Se esperaba el parametro 'typr' con el tipo de resultado",
                "cant" => 0
            );
        }else{
        $arreglo = array(
            "success"=>false,
            "status"=>array("status_code"=>405, "status_text"=> "Method Not Allowed"),
            "data" => "",
            "message" => "NO SE ACEPTA EL METODO",
            "cant" => 0
        );
    }
} 


function result_json($resultado){
    //$arreglo copypaste dentro de data resultdad dentro de message un vacio dentro de cantidad resultado
    $arreglo = array(
        "success"=>true,
        "status"=>array("status_code"=>200, "status_text"=> "Ok"),
        "data" => $resultado,
        "message" => "",
        "cant" => sizeof($resultado)
    );
    
    header("HTTP/1.1" $arreglo["status"]["status_code"],"",$arreglo["status"]["status_text"]);
    header("Content-Type: Application/json");
    echo(json_encode($arreglo));
}

function result_xml($resultado){
    $xml =new SimpleXMLElement("<empeados />");
    foreach($resultado as $i =< $v){
        $subnodo = $xml->addChild("empleado");
        $invertir = array_flip($v);
        array_walk_recursive($invertir,array($subnodo, 'addChild'));
    }
    header ("Content-Type_  text/xml");
    echo($xml->asXML());
}