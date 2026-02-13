
<?php
include 'fruitkha_db.php';
include 'cart.php';
// include 'fruitkha_db.php';

// $data = json_decode(file_get_contents("php://input"), true);

// if(!isset($data['product_id'])){
//     echo json_encode(["error" => "No product ID"]);
//     exit;
// }

// $product_id = (int)$data['product_id'];

// $select = "SELECT id,p_name from products WHERE id = ?";
// $stmt = $conn->prepare($select);
// $stmt->bind_param("i", $product_id);
// $stmt->execute();

// $result = $stmt->get_result();


// if($row = $result->fetch_assoc()){
//     echo json_encode([
//         "id" => $row['id'],
//         "name" => $row['name']
//     ]);

// }
// else{
//     echo json_encode(["error" => "product not found"]);
// }
header("Content-Type:application/json");

$row = file_get_contents("php://input");

if(!$row){
    echo json_encode(["error" => "No data"]);
    exit;
}

$data = json_decode($row, true);

echo json_encode(["product_id" => $data["product_id"]]);

$sql = "SELECT id, p_name, price, picture FROM products WHERE id = ? [ LIMIT 1";
$qry = mysqli_query($conn, $sql);
$fetch = mysqli_fetch_assoc($qry);

?>