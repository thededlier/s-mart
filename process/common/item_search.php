<?php

function itemSearch($searchIndex, $keywords) {
    // Suppress warnings
    error_reporting(0);
    // AWS Access Key
    $aws_access_key_id = "AKIAJDFOBDG56PTMTDDQ";

    // AWS Secret Key
    $aws_secret_key = "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";

    // Region
    $endpoint = "webservices.amazon.in";

    $uri = "/onca/xml";

    $params = array(
        "Service" => "AWSECommerceService",
        "Operation" => "ItemSearch",
        "AWSAccessKeyId" => "AKIAJDFOBDG56PTMTDDQ",
        "AssociateTag" => "rohananand-21",
        "SearchIndex" => $searchIndex,
        "ResponseGroup" => "Images,ItemAttributes,Offers",
        "Sort" => "relevancerank",
        "Keywords" => $keywords
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

    // echo $request_url;

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

    foreach($parsed_xml->Items->Item as $current) {
        $html =     '<div class="row">' .
                        '<div class="item col-md-12">' .
                            '<form action="compare-load.php" method="POST"' .
                                '<div class="row">' .
                                    '<div class="col-md-4">' .
                                        '<img src="' . $current->LargeImage->URL . '" class="img-responsive">' .
                                    '</div>' .
                                    '<div class="col-md-8">' .
                                        '<input type="hidden" name="product_id" value="' . $current->ASIN . '">' .
                                        '<h4><a href="' . $current->DetailPageURL . '">' . $current->ItemAttributes->Title . '</a></h4>' .
                                        '<h5>' . 'Lowest Price : <b>' . $current->OfferSummary->LowestNewPrice->FormattedPrice . '</b></h5>' .
                                        '<button class="btn btn-default" type="submit" name="compare-button">Compare</button>' .
                                    '</div>' .
                                '</div>' .
                            '</form>' .
                        '</div>' .
                    '</div>';
        echo $html;
    }
}
?>