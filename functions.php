<?php
/**
 * Functions for HubSpot
 */

// Populate ACF select list with HubSpot tags
$apiKey = get_field('hubspot_api_key', 'option'); 

if($apiKey):
    function acf_load_hubspot_tag_choices( $field ) {

        // reset choices
        $field['choices'] = array();

        // Load HubSpot tags
        $apiKey = get_field('hubspot_api_key', 'option'); // Pull HubSpot API key from ACF theme options
        $url = "https://api.hubapi.com/blogs/v3/topics?hapikey=$apiKey"; // path to your JSON file
        $data = file_get_contents($url); // put the contents of the file into a variable
        $tags = json_decode($data,true); // decode the JSON feed

        foreach( $tags['objects'] as $tag ) {

            $field['choices'][ $tag['id'] ] = $tag['name'];

        }
            
        // return the field
        return $field;
    }

    add_filter('acf/load_field/name=hubspot_tags', 'acf_load_hubspot_tag_choices'); // The ACF field name must be "hubspot_tags"
endif;
 
?>