<?
/**
 * This class will help you to convert objects, strings, arrays, etc... into xml strings.
 * The resulting xmls look like json_encode result.
 */
class StuffToXml {

    
    /**
     * Return a valid xml document...as a string. The first node will always be "root".
     * @param * $stuff  The "what you want" to get as a valid xml document.
     * @return string Yes it returns a string and not an xml element.
     */
    public static function getCompleteXml($stuff) {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>';

        $xml .= '<root>';
        $xml .= self::getNode($stuff,  self::getType($stuff));
        $xml .= '</root>';

        return $xml;
    }


    /**
     *
     * @param * $stuff The "what you want" to get as an xml node.
     * @param * $nodeName Well...I'm sure you know.
     * @return String A string XML formated of the object $stuff. 
     */
    public static function getNode($stuff,$nodeName=null) {
        if(!$nodeName){
          $nodeName="I-AM-A-".self::getType($stuff);  
        }
        $xml = "<$nodeName type=\"".self::getType($stuff)."\">";
        if (is_array($stuff) || is_object($stuff)) {
            foreach ($stuff as $key=>$value) {
                if (is_numeric($key)) {
                    $key = $node_name;
                }
                $xml.=self::getNode($value, $key);
            }
        } else {
            if(gettype($stuff)=="string"){
                $stuff="<![CDATA[".$stuff."]]>";
            }
            $xml.=$stuff;
            //$xml = htmlspecialchars($array, ENT_QUOTES);
        }
        $xml.="</$nodeName>";
        return $xml;
    }
    
    /**
     * Will return something like "string" or "array" or "YourClassName"...
     * @param * $stuff What you want, an object, a string, a cat, an array...
     * @return String The object type.
     */
    public static function getType($stuff){
        switch(gettype($stuff)){
            case "object";
            return get_class($stuff);
            break;

            default:
            return gettype($stuff);
        }
    }

}