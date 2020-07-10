<?php

namespace App\Models;

class PlacesAPI {
    protected $key = "API_KEY_HERE";
	protected $callURL = "https://maps.googleapis.com/maps/api/geocode/json";

    public function request($url) {

        // Initialise the cURL connection
        $connection = curl_init();

        // Specify the URL to connect to - this can be PHP, HTML or anything else!
        curl_setopt($connection, CURLOPT_URL, $url);


        // This option ensures that the HTTP response is *returned* from curl_exec(),
        // (see below) rather than being output to screen.  
        curl_setopt($connection,CURLOPT_RETURNTRANSFER,1);


        // Actually connect to the remote URL. The response is 
        // returned from curl_exec() and placed in $response.
        $result = curl_exec($connection);

        // Close the connection.
        curl_close($connection);

        // Echo the response back from the server (for illustration purposes)
        return $result;

	}

	public function placeSearch($searchQuery){
        $this->callURL = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?";
		$this->callURL .= "fields=photos,rating&";
		$data = [
			"input" => $searchQuery,
			"inputtype" => "textquery",
			"key" => $this->key
        ];
        
        $url = $this->callURL . http_build_query($data);
        $data = $this->request($url);
        return json_decode($data);
    }
    
    public function searchByName($name)
    {
        $this->callURL = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?";
		$this->callURL .= "fields=photos,rating&";
		$data = [
			"input" => $name,
			"inputtype" => "textquery",
			"key" => $this->key
        ];
        // echo $this->callURL;
        $url = $this->callURL . http_build_query($data);
        $data = $this->request($url);
        return json_decode($data);
    }

	public function imageByReference($ref){
		$this->callURL = "https://maps.googleapis.com/maps/api/place/photo";
		$data = [
			"maxwidth" => 400,
			"photoreference" => $ref,
			"key" => $this->key
		];

		$imageData = $this->callURL . "?" . http_build_query($data);
		return $imageData;
		// ?maxwidth=400&photoreference=CnRtAAAATLZNl354RwP_9UKbQ_5Psy40texXePv4oAlgP4qNEkdIrkyse7rPXYGd9D_Uj1rVsQdWT4oRz4QrYAJNpFX7rzqqMlZw2h2E2y5IKMUZ7ouD_SlcHxYq1yL4KbKUv3qtWgTK0A6QbGh87GB3sscrHRIQiG2RrmU_jF4tENr9wGS_YxoUSSDrYjWmrNfeEHSGSc3FyhNLlBU&key=YOUR_API_KEY
		// return json_decode($searchData);
	}
}
