<?php

    class FilterValidator{

        function filterString($string){

            $str = $string;
            $str = trim($str);
            $str = htmlspecialchars($str);
            $str = filter_var($str, FILTER_SANITIZE_STRING);

            return $str;

        }

        function strictFilterString($string){
            $str = stripcslashes($string);
            $str = $this->{'filterString'}($str);

            return $str;
        }

        function filterEmail($email){

            $validEmail = trim($email);
            $validEmail = stripcslashes($validEmail);
            $validEmail = htmlspecialchars($validEmail);
            $validEmail = filter_var($validEmail, FILTER_SANITIZE_EMAIL);

            return $validEmail;

        }

        function filterPhone($number){
            $pattern = '/^\+([0-9]{1,3})( )([0-9]{3})( )([0-9]{3})( )([0-9]{2})( )([0-9]{2})$/';

            $patterns = array($pattern);

            foreach($patterns as $currPattern){
                if(preg_match($currPattern, $number)){
                    return $number;
                }
            }

            return false;

        }

        function filterURL($URL){

            $validURL = trim($URL);
            $validURL = filter_var($URL, FILTER_SANITIZE_URL);

            return $validURL;

        }

        function filterNumber($num){
            try {

                if(gettype($num) == "integer" || gettype($num) == "float"){
                    return $num;
                }else if(gettype($num) == "string"){
                    
                    $cnum = filter_var($num, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    
                    if($cnum != $num || (empty($cnum) && $cnum !== "0")){
                        return false;
                    }else{
                        return 0 + $cnum;
                    }

                }else{
                    return false;
                }

            } catch (\Throwable $th) {
                return false;
            }
        }

        function filterDate($date){
            return boolval(preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date)) ? $date : false;
        }

        function filterByType($val, $type){
            switch($type){
                case "date":
                    return $this->filterDate($this->strictFilterString($val));

                case "text":
                    return $this->strictFilterString($val);

                case "number":
                    return $this->filterNumber($val);

                case "email":
                    return $this->filterEmail($val);

                default:
                    return $val;
            }
        }

        public static function checkVariables($var){
            foreach(REGISTER_PARAMETERS as $key => $param){
                if(!isset($var[$key])) return false;
            }
    
            return true;
        }
    
        public static function validateEmptyFields($var){
            foreach(REGISTER_PARAMETERS as $key => $param){
                if(empty(trim($var[$key])) && $var[$key] !== "0") return false;
            }
    
            return true;
        }

    }

?>