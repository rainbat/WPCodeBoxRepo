<?php 

function commitsnippet_admin_bar_button($wp_admin_bar){
    $args = [
        "id" => "custom-button-commitsnippet",
        "title" => "Commit Active Snippet",
        "href" => "#",
        "meta" => [
            "class" => "custom-button-class",
            "onclick" => "commitSnippet()"
        ]
    ];
    $wp_admin_bar->add_node($args);
}
add_action("admin_bar_menu", "commitsnippet_admin_bar_button", 100);

function commitsnippet_script() {
?>
    <script type="text/javascript">
        function commitSnippet(){
            let snippet_post_id = jQuery(".active").attr("data-id");
            console.log( snippet_post_id );
            if( snippet_post_id != "" ){
                console.log( "Admin Bar Script" );
                jQuery.ajax({
                    dataType: 'text',
                    url: 'admin-ajax.php',
                    data: {
                        action: 'exec_commitsnippet',
                        snippet_id: snippet_post_id
                    },
                    success: function(data) {
                        alert( "server says " + data );
                    }
                });
            }else{
                alert( "Probably no active Snippet" );   
            }
        }
    </script>
<?php
}
add_action( 'admin_footer', 'commitsnippet_script' );

function exec_commitsnippet() {
	global $wpdb;
    
    $snippet_id = $_GET["snippet_id"];
    
    $snippet_name_sql = "select post_title as val from wp_posts where ID = '25878' ";
    $snippet_name = $wpdb->get_results( $snippet_name_sql );
    //echo $snippet_name["0"]->val; die();

    $snippet_content_sql = "select meta_value as val from wp_postmeta where post_id = '25878' and meta_key = 'wpcb_code' ";
    $snippet_content = $wpdb->get_results( $snippet_content_sql );
    //echo $snippet_content["0"]->val; die();

    //$filename = "test.php";
    //we just replace spaces with _ to determine filename (Neanderthal #1)
    $filename = str_replace( " ", "_", $snippet_name["0"]->val ) . ".php";
    $content = $snippet_content[0]->val;
    //echo $content; die();
    $reponame = "WPCodeBoxRepo";
    
    $username = "rainbat";
    $nickname = "Domi";
    $email = "info@rainbat.ch";
    
    // https://github.com/settings/tokens
	$token = "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";
	
    $useragent = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';

    // First get the File to get the sha
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/$username/$reponame/contents/$filename");
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$token" );
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent );
    $response = curl_exec($ch);
	$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$response_json = json_decode($response);
	$response_json_pretty = json_encode( $response_json, JSON_PRETTY_PRINT );
	$response_file_content = base64_decode( $response_json->content );
	$response_file_hash = $response_json->sha;
 	curl_close($ch);
 	
 	//Uncomment to see if we can find the file hash first
 	//echo "previous sha " . $response_file_hash; die();
	
	if( $response_file_hash == "" ){
	    echo "Did not find previous Version, Token maybe expired.";
	}
	
	// Post to this file hash
	$ch = curl_init();
	$comitter = [
	        "name" => "$nickname",
	        "email" => "$email"
	];
	$payload = [
	    "message" => "Commited from PHP",
	    "path" => "$filename",
	    "repo" => "$reponame",
	    "owner" => "$username",
	    "committer" => $comitter,
	    "sha" => $response_file_hash,
	    "content" => base64_encode( $content )
	];
	$payload_json = json_encode( $payload, JSON_PRETTY_PRINT );
    //echo $payload_json; die();
    
	curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/$username/$reponame/contents/$filename");
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$token");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/vnd.github.VERSION.raw']);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent );
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_json );
    $response = curl_exec($ch);
    //$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$response_json = json_decode($response);
	curl_close($ch);
	echo "Commited " . $response_json->content->name;
    die();
}
add_action( 'wp_ajax_exec_commitsnippet', 'exec_commitsnippet' );
