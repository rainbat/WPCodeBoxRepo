<?php 

// import from JSON
add_filter(
	'upload_mimes',
	function( $types ) {
		return array_merge( $types, [ 'json' => 'text/plain' ] );
	}
);

function syncJSON_admin_bar_button($wp_admin_bar){
    $args = [
        "id" => "custom-button-syncjson",
        "title" => "Sync Product Feed",
        "href" => "#",
        "meta" => [
            "class" => "custom-button-class",
            "onclick" => "syncJson()"
        ]
    ];
    $wp_admin_bar->add_node($args);
}
add_action("admin_bar_menu", "syncJSON_admin_bar_button", 100);

function syncJSON_script(){
?>
    <script type="text/javascript">
        function syncJson() {
            let snippet_post_id = jQuery(".active").attr("data-id");
            console.log(snippet_post_id);
            if (snippet_post_id != "") {
                console.log("Admin Bar Script");
                jQuery.ajax({
                    dataType: 'text',
                    url: 'admin-ajax.php',
                    data: {
                        action: 'exec_synjson',
                        snippet_id: snippet_post_id
                    },
                    success: function(data) {
                        alert("server says " + data);
                    }
                });
            } else {
                alert("Probably no active Snippet");
            }
        }
    </script>
<?php
}
add_action('admin_footer', 'syncJSON_script');

function exec_synjson(){

    global $wpdb;
    //$snippet_name_sql = "select post_title as val from wp_posts where ID = '25878' ";
    //$snippet_name = $wpdb->get_results($snippet_name_sql);
    //echo $snippet_name["0"]->val; die();

    //$useragent = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
    // TEST
    // First get the File to get the sha
    //echo "HELLO"; die();
    ini_set('memory_limit', '2048M');
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "https://www.pfconcept.com/portal/datafeed/productfeed_de_v3.json");
    curl_setopt($ch, CURLOPT_URL, "https://www.rainbat.ch/wp-content/uploads/productfeed_de_v3.json");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    $response = curl_exec($ch);
    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $response_json = json_decode($response);
    //$response_json_pretty = json_encode($response_json, JSON_PRETTY_PRINT);
    //$response_file_content = base64_decode($response_json->content);
    curl_close($ch);
    //echo $responseCode;
    //echo $response_json->pfcProductfeed->productfeed->creationDateTime;
    $message = "\n";
    $message .= "Models: "  . count( $response_json->pfcProductfeed->productfeed->models ) . "\n";
    $message .= "Code  : "  . $response_json->pfcProductfeed->productfeed->models[0]->model->modelCode . "\n";
    $message .= "Items  : " . count( $response_json->pfcProductfeed->productfeed->models[0]->model->items );
    echo $message;
    die();
}
add_action('wp_ajax_exec_synjson', 'exec_synjson');
