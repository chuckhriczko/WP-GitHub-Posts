<?php
namespace Tdw\GitHubPosts\Types;
use Tdw\GitHubPosts\Utils;

class BaseClass
{
    //Array of properties that should be ignored
    private array $notAllowed = ['owner', 'license'];

    /**
     * This base class can be used with any object. It will...
     *  1. Accept JSON or a JSON object
     *  2. Get all the class keys and loop through them
     *  3. If a key matches, the value is added
     *
     * Params:
     * @param string|object|array|null $json_data
     */
    public function __construct(string | object | array | null $json_data = null)
    {
        //If we are passed a string, convert to an object or array
        if (gettype($json_data) === 'string'){
            $json_data = json_decode($json_data, true);
        }

        //Loop through the json data object's properties
        foreach($json_data as $key => $value){
            try{
                //Verify the property exists in the object and if so, set the value
                if (property_exists($this, $key) && !in_array($key, (array)$this->notAllowed) && $value !== null) {
                    $this->{$key} = $value;
                }
            } catch(\Exception $e){
                Utils::getInstance()->log("Error getting GitHub user data: ".$e->getMessage());
            }
        }
    }
}