<?php
require_once "DBController.php";
class ShoppingCart extends DBController
{
    function getAllProduct($searchTerm = '')
    {
        $query = "SELECT * FROM produse";
        if (!empty($searchTerm)) {
            $query .= " WHERE nume_produs LIKE '%" . $searchTerm . "%'";
        }

        $productResult = $this->getDBResult($query);
        return $productResult;
    }
    function getAllcategories($searchTerm = '')
    {
        $query = "SELECT * FROM categorii";
        if (!empty($searchTerm)) {
            $query .= " WHERE nume_categorie LIKE '%" . $searchTerm . "%'";
        }
        $categoryResult = $this->getDBResult($query);
        return $categoryResult;
    }
    function getAllproducers($searchTerm = '')
    {
        $query = "SELECT * FROM producatori";
        if (!empty($searchTerm)) {
            $query .= " WHERE nume_producator LIKE '%" . $searchTerm . "%'";
        }
        $producerResult = $this->getDBResult($query);
        return $producerResult;
    }
    function countCartItems()
    {
        $query = "SELECT COUNT(*) FROM cos";
        $productResult = $this->getDBResult($query);
        return $productResult;

    }
    
    function getMemberCartItem($member_id)
    {
        $query = "SELECT produse.nume_produs, produse.imagine, produse.id_produs, produse.pret, cos.cantitate, cos.raspuns  FROM produse, cos WHERE produse.id_produs = cos.product_id AND cos.user_id = ?";
        $params = array( 
            array(
                "param_type" => "i",
                "param_value" => $member_id
            )
        );

        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    }
    function getProductByCode($product_code)
    {
        $query = "SELECT * FROM produse WHERE id_produs=?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $product_code
            )
        );

        $productResult = $this->getDBResult($query, $params);
        return $productResult;
    }
    function getCartItemByProduct($product_id, $member_id)
    {
        $query = "SELECT * FROM cos WHERE product_id = ? AND user_id = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $product_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $member_id
            )
        );
        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    }
    function addToCart($cantitate, $product_id, $member_id, $status, $raspuns)
    {
        $query = "INSERT INTO cos (cantitate, product_id, user_id, status, raspuns) VALUES (?,?,?,?,?)";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $cantitate
            ),
            array(
                "param_type" => "i",
                "param_value" => $product_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $member_id
            ),
            array(
                "param_type" => "s",
                "param_value" => $status
            ),
            array(
                "param_type" => "s",
                "param_value" => $raspuns
            )

        );

        $this->updateDB($query, $params);
    }
    function updateCartQuantity($cantitate, $cart_id)
    {
        $query = "UPDATE cos SET cantitate = ? WHERE id_cos= ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $cantitate
            ),
            array(
                "param_type" => "i",
                "param_value" => $cart_id
            )
        );
        $this->updateDB($query, $params);
    }
    function deleteCartItem($cart_id)
    {
        $user_id = $_SESSION['id_user'];
        $query = "DELETE FROM cos WHERE product_id = ? AND user_id = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $cart_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $user_id
            )
        );
        $this->updateDB($query, $params);
    }
    function emptyCart($member_id)
    {
        $query = "DELETE FROM cos WHERE user_id = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $member_id
            )
        );

        $this->updateDB($query, $params);
    }
}