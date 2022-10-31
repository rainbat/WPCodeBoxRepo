<?php

function commitsnippet_admin_bar_button($wp_admin_bar)
{
    $args = [
        "id" => "custom-button-commitsnippet",
        "title" => "Commit Snippet",
        "href" => "#",
        "meta" => [
            "class" => "custom-button-class",
            // "onclick" => "alert('hello')"
        ]
    ];
    $wp_admin_bar->add_node($args);
}

add_action("admin_bar_menu", "commitsnippet_admin_bar_button", 100);


// https://www.rainbat.ch/github-api-tester/
// https://github.com/rainbat/WPCodeBoxRepo/tree/main
// https://github.com/settings/apps/rainbatgitapp

add_shortcode( 'commit', function ( $atts = [], $content = null, $tag = '' ) {

    $today = date( 'Y-m-d' );
    $username = "rainbat";
    $password = "riwtuj-Gycza4-pofryx";
    
    $token = "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";
	$useragent = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
    
    /* List Repos
    curl -X GET -u rainbat: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 https://api.github.com/users/rainbat/repos | grep -w clone_url
    */
    
    /* Public Repos of User rainbat
    $ch = curl_init();
	$payload = [
	];
	curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/users/rainbat/repos');
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$token");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent );
	//curl_setopt($ch, CURLOPT_POST, true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $response = curl_exec($ch);
	$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$response_json = json_decode($response);
	$response_jspon_pretty = json_encode( $response_json, JSON_PRETTY_PRINT );
	curl_close($ch);	
    */
    
    /* Create (and more) WPCodeBoxRepo for User rainbat 
    curl -X POST -u rainbat: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 https://api.github.com/user/repos -d “{\”name\”: \”WPCodeBoxRepo\”}”
    Extended available Params:
    curl -X POST -u <UserName>:<Generated-Token>https://api.github.com/user/repos -d “{\”name\”: \”Demo_Repo\”,\”description\”: \”This is first repo through API\”,\”homepage\”: \”https://github.com\”,\”public\”: \”true\”,\”has_issues\”: \”true\”,\”has_projects\”:\”true\”,\”has_wiki\”: \”true\”}”
    Rename Repository:
    curl -X POST -u <UserName>:<Generated-Token> -X PATCH -d “{\”name\”:\”<NewRepoName>\”}” https://api.github.com/repos/<user-name>/<OldRepoName>
    Update Param of Repository:
    curl -u <UserName>:<Generated-Token>-X PATCH -d “{\”has_wiki\”:\”false\”}” https://api.github.com/repos/user-name/<reponame>
    Delete Repository:
    curl -X DELETE -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<reponame>
    Create in Organization:
    curl -X POST -u <UserName>:<Generated-Token>https://api.github.com/orgs/<Enter-Org-name>/repos“{\”name\”: \”Demo_Repo_In_Org\”,\”description\”: \”This is first repo in org through API\”,\”homepage\”: \”https://github.com\”,\”public\”: \”true\”,\”has_issues\”: \”true\”,\”has_projects\”:\”true\”,\”has_wiki\”: \”true\”}”
    List Forks:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<User-Repo>/forks | grep -w html_url
    List Logins:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/collaborators | grep -w login
    List Clone URLS:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<User-Repo>/forks | grep -w clone_url
    Fork Repository:
    curl -X POST -u <UserName>:<Generated-Token>-d “{\”organization\”: \”<Org-Name-To-Fork>\”}” https://api.github.com/repos/<user-name>/<repo-name>/forks
    List Collaborators:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/collaborators | grep -w login
    Check for Collaborators:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/collaborators/<user-name-to-check>
    Check for Permissions of User:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/collaborators/<user-name-to-check–for-permission>/permission| grep -w permission
    Add Collaborator:
    curl -X PUT -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name-to-add-collaborator>/collaborators/<user-name-to-add-as-collaborator>
    Removing Collaborator:
    curl -X DELETE -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name-to-remove-collaborator>/collaborators/<user-name-to-remove>
    List Organizations:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/user/orgs | grep -w login
    Update Organization:
    curl -X PATCH -u <UserName>:<Generated-Token>-d “{\”name\”: \”TeamVN\”,\”billing_email\”: \”vniranjan72@outlook.com\”,\”email\”: \”vniranjan72@outlook.com\”,\”location\”:\”Bangalore\”,\”\”description\”: \”Updating the organization details\”}”https://api.github.com/orgs/<Org-Name>
    Branches:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/branches | grep -w name
    Protected Branches:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/branches?protected=true | grep -w name
    Unprotected Branches:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/branches?protected=false | grep -w name
    Remove Protection:
    curl -X DELETE -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/branches/master/protection
    Pull Requests:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/pulls?state=open | grep -w title
    Create Pull Request:
    curl -X POST -u <UserName>:<Generated-Token>-d “{\”title\”:\”Great feature added\”,\”body\”: \”Please pull the great change made in to master branch\”,\”head\”: \”feature\”,\”base\”: \”master\”}” https://api.github.com/repos/<user-name>/<repo-name>/pulls
    List Number of Pull Requests:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/pulls?state=open | grep -w number
    Update Pull Request:
    curl -X PATCH -u <UserName>:<Generated-Token>-d “{\”body\”: \”Mandatory to pull the great change made in feature branch to master branch\”}” https://api.github.com/repos/<user-name>/<repo-name>/pulls/31
    List Pull Request Commits:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/pulls/31/commits
    List Pull Request Files:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/pulls/31/files| grep -w filename
    Merge Pull Requests:
    curl -X PUT -u <UserName>:<Generated-Token>-d “{\”commit_message\”: \”Good Commit\”}”https://api.github.com/repos/<user-name>/<repo-name>/pulls/31/merge
    List Labels:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/labels | grep -w name
    List Specific Label:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/labels/bug
    Create Label:
    curl -X POST -u <UserName>:<Generated-Token>-d “{\”name\”: \”defect\”,\”description\”: \”To raise a defect\”,\”color\”: \”ff493b\”}”https://api.github.com/repos/<user-name>/<repo-name>/labels
    Update Label:
    curl -X PATCH -u <UserName>:<Generated-Token> -d “{\”color\”: \”255b89\”}” https://api.github.com/repos/<user-name>/<repo-name>/labels/defect
    Delete Label
    curl -X DELETE -u <UserName>:<Generated-Token>https://api.github.com/repos/vniranjan1972/Demo_Project_Repo_VN/labels/defect
    List Specific Issue:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/issues/20 | grep -w title
    List all Issues:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/issues | grep -w title
    Create Issue:
    curl -X POST -u <UserName>:<Generated-Token>-d “{\”title\”: \”New welcome page\”,\”body\”: \”To design a new page\”,\”labels\”: [\”enhancement\”],\”milestone\”: \”3\”,\”assignees\”: [\”<user-name1>\”,\”<user-name2\”],\”state\”: \”open\”}” https://api.github.com/repos/<user-name>/<repo-name>/issues
    Add Label to Issue:
    curl -X POST -u <UserName>:<Generated-Token> -d “{\”labels\”: [\”enhancement\”]}” https://api.github.com/repos/<user-name>/<repo-name>/issues/30/labels
    Update an Issue and update Label:
    curl -X PATCH -u <UserName>:<Generated-Token>-d “{\”labels\”: [\”bug\”,\”enhancement\”]}” https://api.github.com/repos/<user-name>/<repo-name>/issues/30
    Remove a Label from an Issue:
    curl -X DELETE -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/issues/30/labels/bug
    Remove All Labels from an Issue:
    curl -X DELETE -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/issues/30/labels
    List all Milestones:
    curl -X GET -u <UserName>:<Generated-Token>-d “{\”state\”: [\”open\”]}”https://api.github.com/repos/<user-name>/<repo-name>/milestones | grep -w title
    List Details of a Milestone:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/milestones/1 | grep -w title
    Create a Milestone:
    curl -X POST -u <UserName>:<Generated-Token>-d “{\”title\”: \”R5\”,\”state\”: \”open\”,\”description\”: \”Track for milestone R5\”,\”due_on\”: \”2019-12-05T17:00:01Z\”}” https://api.github.com/repos/<user-name>/<repo-name>/milestones
    Update a Milestone:
    curl -X PATCH -u <UserName>:<Generated-Token>-d “{\”state\”: \”closed\”}” https://api.github.com/repos/<user-name>/<repo-name>/milestones/3
    Delete a Milestone:
    curl -X DELETE -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/milestones/3
    List Teams:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/orgs/<Org-Name>/teams| grep -w name
    List by Teams ID:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/orgs/<Org-Name>/teams| grep -w id
    List Teams by User:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/user/teams | grep -w name
    Create Team:
    curl -X POST -u <UserName>:<Generated-Token>-d “{\”name\”:\”<Team Name>\”,\”description\”: \”Enter brief description\”,\”maintainers\”: [\”<user-name>\”],\”repo_names\”: [\”<Org-name>/<Repo-Name>\”]}” https://api.github.com/orgs/Demo-Proj-Org/teams
    Edit Team Name and Descrition:
    curl -X PATCH -u <user-name>:<Generated-Token>-d “{\”name\”: \”New Team Name\”,\”description\”: \”Latest Description\”}”https://api.github.com/teams/<Team-Id>
    Add Repository to Team:
    curl -X PUT -u <user-name>:<Generated-Token>https://api.github.com/teams/<Team-Id>/repos/<Org-Name>/<repo-name>
    Remove Repository from Team:
    curl -X DELETE -u <user-name>:<Generated-Token>https://api.github.com/teams/<Team-Id/repos/<Org-Name>/<repo-name-to-be-deleted-from-team>
    Delete a Team:
    curl -X DELETE -u <UserName>:<Generated-Token>https://api.github.com/teams/<Team-Id>
    Search Repository, Code, Issues:
    curl -X GET https://api.github.com/search/repositories?q=user:<user-name> | grep -w “name”
    Search Repository by User, with V and Niranjam:
    curl -X GET https://api.github.com/search/repositories?q=V+Niranjan+in:readme+user:<user-name>| grep -w name
    Search for Keyword in File:
    curl -X GET https://api.github.com/search/code?q=System+addEmployee+in:file+language:java+repo:<user-name>/<repo-name> | grep -w name
    Search for Keyword welcome in open issues and label:
    curl -X GET https://api.github.com/search/issues?q=welcome+label:enhancement+state:open+repo:<user-name>/<repo-name>| grep -w name
    Search for Keyword address in closed issues and label:
    curl -X GET https://api.github.com/search/issues?q=address+label:enhancement+state:closed+repo:<user-name>/<repo-name> | grep -w name
    Search for Release:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/releases | grep -w tag_name
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/releases | grep -w id
    Details of Release:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/releases/<rel-id> | grep -w tag_name
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/releases/<rel-id> | grep -w body
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/releases/<rel-id> | grep -w name
    Details of Latest Release:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/releases/latest| grep -w tag_name
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/releases/latest| grep -w name
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/releases/latest| grep -w body
    Details of Release by Tags:
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/releases/tags/<Tag-Name>| grep -w name
    curl -X GET -u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name>/releases/tags/<Tag-Name>| grep -w body
    Create a Release:
    curl -X POST -u <UserName>:<Generated-Token>-d “{\”tag_name\”: \”R3.0\”,\”target_commitish\”: \”master\”,\”name\”: \”Release 3.0\”,\”body\”: \”This is for Release 3.0 of the product\”,\”draft\”: “false”,\”prerelease\”: “false”}” https://api.github.com/repos/<user-name>/<repo-name/releases
    Edit/Update Release:
    curl -X PATCH-u <UserName>:<Generated-Token>-d “{\”tag_name\”: \”R3.1\”}” https://api.github.com/repos/<user-name>/<repo-name/releases/<rel-id>
    Delete Release:
    curl -X DELETE-u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name/releases/<rel-id>
    List Assets for Release:
    curl -X DELETE-u <UserName>:<Generated-Token>https://api.github.com/repos/<user-name>/<repo-name/releases/<rel-id>/assets
    */
    
    /*$ch = curl_init();
	$payload = [
		'name' => 'WPCodeBoxRepo'
	];
	curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/user/repos');
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$token");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent );
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $payload ) );
    $response = curl_exec($ch);
	$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$response_json = json_decode($response);
	$response_jspon_pretty = json_encode( $response_json, JSON_PRETTY_PRINT );
	curl_close($ch);
	*/	
	
	// Post to File
	// First get the File
	// https://github.com/rainbat/WPCodeBoxRepo/blob/main/test.php
	$ch = curl_init();
	$payload = [
		'name' => 'WPCodeBoxRepo'
	];
	curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/rainbat/WPCodeBoxRepo/contents/test.php');
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent );
	//curl_setopt($ch, CURLOPT_POST, true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $payload ) );
    $response = curl_exec($ch);
	$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$response_json = json_decode($response);
	$response_json_pretty = json_encode( $response_json, JSON_PRETTY_PRINT );
	$response_file_content = base64_decode( $response_json->content );
	curl_close($ch);
	
    
$html = <<<HTML
    <pre>$response</pre>
HTML;

    return $html;
    
});
