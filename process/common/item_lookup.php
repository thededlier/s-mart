<?php

function itemLookup($pid) {
    include './connect.php';
    include './credentials/secret.php';
    
    // Suppress warnings
    error_reporting(0);
    
    // The region you are interested in
    $endpoint = "webservices.amazon.in";

    $uri = "/onca/xml";

    $params = array(
        "Service" => "AWSECommerceService",
        "Operation" => "ItemLookup",
        "AWSAccessKeyId" => "AKIAJDFOBDG56PTMTDDQ",
        "AssociateTag" => "rohananand-21",
        "ItemId" => $pid,
        "IdType" => "ASIN",
        "ResponseGroup" => "Images,ItemAttributes,Offers"
    );

    // Set current timestamp if not set
    if (!isset($params["Timestamp"])) {
        $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
    }

    // Sort the parameters by key
    ksort($params);

    $pairs = array();

    foreach ($params as $key => $value) {
        array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
    }

    // Generate the canonical query
    $canonical_query_string = join("&", $pairs);

    // Generate the string to be signed
    $string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

    // Generate the signature required by the Product Advertising API
    $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));

    // Generate the signed URL
    $request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

    echo "Signed URL: \"".$request_url."\"";

    $response = file_get_contents($request_url);
    $parsed_xml = simplexml_load_string($response);

    // Verify Request
    foreach($parsed_xml->OperationRequest->Errors->Error as $error){
        echo "Error code: " . $error->Code . "\r\n";
        echo $error->Message . "\r\n";
        echo "\r\n";
    }

    // echo $parsed_xml->OperationRequest->RequestId;

    $html = "";
    $attr = "";
    
    $current = $parsed_xml->Items->Item;

    foreach($current->ItemAttributes->Feature as $itemFeature) {
        // Determining RAM rating
        $rating = 0;
        if(strpos($itemFeature, "RAM") !==false || strpos($itemFeature, "DDR3") !==false || strpos($itemFeature, "DDR4") !==false) {
            $found = 0;
            $sql = "SELECT * FROM spec_ram";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $specs = explode(",", $row["amount"]);
                    foreach($specs as $i) {
                        if(strpos($itemFeature, $i, 0) !== false) {
                            $rating = ($row["rating"] * 10)/ 32;
                            $found = 1;
                            break;
                        }
                    }
                    if($found === 1) break;
                }
            }
        } 
        // Determining processor rating
        else if(strpos($itemFeature, "processor")) {
            $found = 0;
            $sql = "SELECT * FROM spec_processor";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $specs = explode(",", $row["amount"]);
                    foreach($specs as $i) {
                        if(strpos($itemFeature, $i, 0) !== false) {
                            $rating = $row["rating"];
                            $found = 1;
                            break;
                        }
                    }
                    if($found === 1) break;
                }
            }
        } else if(strpos($itemFeature, "Graphics")) {
            $found = 0;
            $sql = "SELECT * FROM spec_gpu";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $specs = explode(",", $row["amount"]);
                    foreach($specs as $i) {
                        if(strpos($itemFeature, $i, 0) !== false) {
                            $rating = $row["rating"];
                            $found = 1;
                            break;
                        }
                    }
                    if($found === 1) break;
                }
            }
        }
        $attr .= '<li class="list-group-item">' . $itemFeature . '<span class="rate pull-right"> Rate : ' . $rating . '</span>' . '</li>';    
    }

    $html =     '<div class="row">' .
                    '<div class="item col-md-12">' .
                        '<div class="col-md-12">' .
                            '<img src="' . $current->LargeImage->URL . '" class="img-responsive">' . 
                        '</div>' .
                        '<div class="col-md-12">' .
                            '<input type="hidden" name="product_id" value="' . $current->ASIN . '">' .
                            '<h4><a href="' . $current->DetailPageURL . '">' . $current->ItemAttributes->Title . '</a></h4>' .
                            '<h5>' . 'Lowest Price : <b>' . $current->OfferSummary->LowestNewPrice->FormattedPrice . '</b></h5>' .
                            '<ul class="list-group">' . 
                                $attr .
                            '</ul>' .
                            // '<button class="btn btn-default" type="submit" name="compare_button">Compare</button>' .
                        '</div>' .
                    '</div>' .
                '</div>';
    
    return $html;
}
?>