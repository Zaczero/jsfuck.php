<?php
class JSFuck {

    private const MIN = 32;
    private const MAX = 126;
    private const USE_CHAR_CODE = 'USE_CHAR_CODE';

    private const SIMPLE = [
        'false' => '![]',
        'true' => '!![]',
        'undefined' => '[][[]]',
        'NaN' => '+[![]]',
        'Infinity' => '+(+!+[]+(!+[]+[])[!+[]+!+[]+!+[]]+[+!+[]]+[+[]]+[+[]]+[+[]])',
    ];

    private const CONSTRUCTORS = [
        'Array' => '[]',
        'Number' => '(+[])',
        'String' => '([]+[])',
        'Boolean' => '(![])',
        'RegExp' => 'Function("return/"+false+"/")()',
        'Function' => '[]["fill"]',
    ];

    private $_MAPPING = [
        'a' => '(false+"")[1]',
        'b' => '([]["entries"]()+"")[2]',
        'c' => '([]["fill"]+"")[3]',
        'd' => '(undefined+"")[2]',
        'e' => '(true+"")[3]',
        'f' => '(false+"")[0]',
        'g' => '(false+[0]+String)[20]',
        'h' => '(+(101))["to"+String["name"]](21)[1]',
        'i' => '([false]+undefined)[10]',
        'j' => '([]["entries"]()+"")[3]',
        'k' => '(+(20))["to"+String["name"]](21)',
        'l' => '(false+"")[2]',
        'm' => '(Number+"")[11]',
        'n' => '(undefined+"")[1]',
        'o' => '(true+[]["fill"])[10]',
        'p' => '(+(211))["to"+String["name"]](31)[1]',
        'q' => '(+(212))["to"+String["name"]](31)[1]',
        'r' => '(true+"")[1]',
        's' => '(false+"")[3]',
        't' => '(true+"")[0]',
        'u' => '(undefined+"")[0]',
        'v' => '(+(31))["to"+String["name"]](32)',
        'w' => '(+(32))["to"+String["name"]](33)',
        'x' => '(+(101))["to"+String["name"]](34)[1]',
        'y' => '(NaN+[Infinity])[10]',
        'z' => '(+(35))["to"+String["name"]](36)',
        
        'A' => '(+[]+Array)[10]',
        'B' => '(+[]+Boolean)[10]',
        'C' => 'Function("return escape")()(("")["italics"]())[2]',
        'D' => 'Function("return escape")()([]["fill"])["slice"]("-1")',
        'E' => '(RegExp+"")[12]',
        'F' => '(+[]+Function)[10]',
        'G' => '(false+Function("return Date")()())[30]',
        'H' => JSFuck::USE_CHAR_CODE,
        'I' => '(Infinity+"")[0]',
        'J' => JSFuck::USE_CHAR_CODE,
        'K' => JSFuck::USE_CHAR_CODE,
        'L' => JSFuck::USE_CHAR_CODE,
        'M' => '(true+Function("return Date")()())[30]',
        'N' => '(NaN+"")[0]',
        'O' => '(NaN+Function("return{}")())[11]',
        'P' => JSFuck::USE_CHAR_CODE,
        'Q' => JSFuck::USE_CHAR_CODE,
        'R' => '(+[]+RegExp)[10]',
        'S' => '(+[]+String)[10]',
        'T' => '(NaN+Function("return Date")()())[30]',
        'U' => '(NaN+Function("return{}")()["to"+String["name"]]["call"]())[11]',
        'V' => JSFuck::USE_CHAR_CODE,
        'W' => JSFuck::USE_CHAR_CODE,
        'X' => JSFuck::USE_CHAR_CODE,
        'Y' => JSFuck::USE_CHAR_CODE,
        'Z' => JSFuck::USE_CHAR_CODE,
        
        ' ' => '(NaN+[]["fill"])[11]',
        '!' => JSFuck::USE_CHAR_CODE,
        '"' => '("")["fontcolor"]()[12]',
        '#' => JSFuck::USE_CHAR_CODE,
        '$' => JSFuck::USE_CHAR_CODE,
        '%' => 'Function("return escape")()([]["fill"])[21]',
        '&' => '("")["link"](0+")[10]',
        '\'' => JSFuck::USE_CHAR_CODE,
        '(' => '(undefined+[]["fill"])[22]',
        ')' => '([0]+false+[]["fill"])[20]',
        '*' => JSFuck::USE_CHAR_CODE,
        '+' => '(+(+!+[]+(!+[]+[])[!+[]+!+[]+!+[]]+[+!+[]]+[+[]]+[+[]])+[])[2]',
        ',' => '([]["slice"]["call"](false+"")+"")[1]',
        '-' => '(+(.+[0000000001])+"")[2]',
        '.' => '(+(+!+[]+[+!+[]]+(!![]+[])[!+[]+!+[]+!+[]]+[!+[]+!+[]]+[+[]])+[])[+!+[]]',
        '/' => '(false+[0])["italics"]()[10]',
        ':' => '(RegExp()+"")[3]',
        ';' => '("")["link"](")[14]',
        '<' => '("")["italics"]()[0]',
        '=' => '("")["fontcolor"]()[11]',
        '>' => '("")["italics"]()[2]',
        '?' => '(RegExp()+"")[2]',
        '@' => JSFuck::USE_CHAR_CODE,
        '[' => '([]["entries"]()+"")[0]',
        '\\' => JSFuck::USE_CHAR_CODE,
        ']' => '([]["entries"]()+"")[22]',
        '^' => JSFuck::USE_CHAR_CODE,
        '_' => JSFuck::USE_CHAR_CODE,
        '`' => JSFuck::USE_CHAR_CODE,
        '{' => '(true+[]["fill"])[20]',
        '|' => JSFuck::USE_CHAR_CODE,
        '}' => '([]["fill"]+"")["slice"]("-1")',
        '~' => JSFuck::USE_CHAR_CODE,
    ];

    private const GLOBAL = 'Function("return this")()';

    public function __construct(string $compilePath = "jsfuck.data") {
        if(file_exists($compilePath)) {
            $data = file_get_contents("jsfuck.data");
            $this->_MAPPING = unserialize($data);
        }
        else {
            $this->FillMissingChars();
            $this->FillMissingDigits();
            $this->ReplaceMap();
            $this->ReplaceStrings();

            $data = serialize($this->_MAPPING);
            file_put_contents("jsfuck.data", $data);
        }
    }

    public function Encode(string $input, bool $wrapWithEval = false, bool $runInParentScope = false) : string {
        $output = [];
        
        $r = "";
        foreach(JSFuck::SIMPLE as $i => $val) {
            $r .= "$i|";
        }
        $r .= ".";

        if(preg_match_all("/$r/", $input, $matches)) {
            foreach($matches[0] as $find) {
                if(key_exists($find, JSFuck::SIMPLE)) {
                    $output[] = "[".JSFuck::SIMPLE[$find]."]+[]";
                }
                else if(key_exists($find, $this->_MAPPING)) {
                    $output[] = $this->_MAPPING[$find];
                }
                else {
                    $replacement = "([]+[])[".$this->Encode("constructor")."][".$this->Encode("fromCharCode")."](".$this->Encode((string) ord($find)).")";
                    $output[] = $replacement;
                    $this->_MAPPING[$find] = $replacement;
                }
            }
        }

        $output = join("+", $output);

        if(preg_match("/^\d$/", $input)) {
            $output .= "+[]";
        }

        if($wrapWithEval) {
            if($runInParentScope) {
                $output = "[][".$this->Encode("fill")."][".$this->Encode("constructor")."](".$this->Encode("return eval").")()($output)";
            }
            else {
                $output = "[][".$this->Encode("fill")."][".$this->Encode("constructor")."]($output)()";
            }
        }

        return $output;
    }

    private function FillMissingChars() {
        foreach($this->_MAPPING as $key => $value) {
            if($value === JSFuck::USE_CHAR_CODE) {
                $charCode = ord($key);
                $charCodeHex = dechex($charCode);
                $replace = preg_replace('/(\d+)/', '+($1)+"', $charCodeHex);
                $this->_MAPPING[$key] = 'Function("return unescape")()("%"'.$replace.'")';
            }
        }
    }

    private function FillMissingDigits() {
        for($number = 0; $number < 10; $number++) {
            $output = "+[]";

            if($number > 0) {
                $output = "+!$output";
            }

            for($i = 1; $i < $number; $i++) {
                $output = "+!+[]$output";
            }

            if($number > 1) {
                $output = substr($output, 1);
            }

            $this->_MAPPING[$number] = "[$output]";
        }
    }

    private function ReplaceMap() {
        for($i = JSFuck::MIN; $i <= JSFuck::MAX; $i++) {
            $char = chr($i);
            $value = $this->_MAPPING[$char];

            if(empty($value)) {
                continue;
            }

            foreach(JSFuck::CONSTRUCTORS as $key => $val) {
                $value = preg_replace("/\b$key/", $val.'["constructor"]', $value);
            }

            foreach(JSFuck::SIMPLE as $key => $val) {
                $value = preg_replace("/$key/", $val, $value);
            }

            $value = $this->NumberReplacer($value, "/(\d\d+)/i");
            $value = $this->DigitReplacer($value, "/\((\d)\)/i");
            $value = $this->DigitReplacer($value, "/\[(\d)\]/i");

            $value = preg_replace("/GLOBAL/", JSFuck::GLOBAL, $value);
            $value = preg_replace("/\+\"\"/", "+[]", $value);
            $value = preg_replace("/\"\"/", "[]+[]", $value);

            $this->_MAPPING[$char] = $value;
        }
    }

    private function ReplaceStrings() {
        foreach($this->_MAPPING as $key => $value) {
            $this->_MAPPING[$key] = $this->MappingReplacer((string) $value, "/\"([^\"]+)\"/i");
        }

        $count = JSFuck::MAX - JSFuck::MIN;

        while(true) {
            $missing = $this->FindMissing();

            if(count($missing) == 0) {
                break;
            }
            
            foreach($missing as $key => $value) {
                $value = $this->ValueReplacer($value, "/[^\[\]\(\)\!\+]{1}/", $missing);
                $this->_MAPPING[$key] = $value;
            }
            
            if($count-- === 0) {
                throw new Exception("Could not compile the following chars: ".json_encode($this->FindMissing()));
            }
        }
    }

    private function FindMissing() : array {
        $missing = [];
        foreach($this->_MAPPING as $key => $value) {
            if(preg_match("/[^\[\]\(\)\!\+]{1}/", $value)) {
                $missing[$key] = $value;
            }
        }
        return $missing;
    }

    private function NumberReplacer(string $value, string $pattern) : string {
        if(preg_match_all($pattern, $value, $matches, PREG_OFFSET_CAPTURE)) {
            for($i = count($matches[0]) - 1; $i >= 0; $i--) {
                $find = $matches[0][$i][0];
                $offs = $matches[0][$i][1];
    
                $begin = substr($value, 0, $offs);
                $end = substr($value, $offs + strlen($find));
    
                $values = [];
                for($j = 0; $j < strlen($find); $j++) {
                    $values[$j] = $find[$j];
                }
    
                $head = (int) array_shift($values);
                $output = "+[]";
    
                if($head > 0) {
                    $output = "+!$output";
                }
    
                for($j = 1; $j < $head; $j++) {
                    $output = "+!+[]$output";
                }
    
                if($head > 1) {
                    $output = substr($output, 1);
                }
    
                $merged = array_merge([$output], $values);
                $joined = join("+", $merged);
                
                $value = $begin.$this->DigitReplacer($joined, "/(\d)/").$end;
            }
        }

        return $value;
    }

    private function DigitReplacer(string $value, string $pattern) : string {
        if(preg_match_all($pattern, $value, $matches, PREG_OFFSET_CAPTURE)) {
            for($i = count($matches[1]) - 1; $i >= 0; $i--) {
                $find = $matches[1][$i][0];
                $offs = $matches[1][$i][1];
    
                $begin = substr($value, 0, $offs);
                $end = substr($value, $offs + strlen($find));
    
                $value = $begin.$this->_MAPPING[$find].$end;
            }
        }

        return $value;
    }

    private function MappingReplacer(string $value, string $pattern) : string {
        if(preg_match_all($pattern, $value, $matches, PREG_OFFSET_CAPTURE)) {
            for($i = count($matches[1]) - 1; $i >= 0; $i--) {
                $find = $matches[1][$i][0];
                $offs = $matches[1][$i][1];
    
                $begin = substr($value, 0, $offs - 1);
                $end = substr($value, $offs + strlen($find) + 1);
    
                $values = [];
                for($j = 0; $j < strlen($find); $j++) {
                    $values[$j] = $find[$j];
                }

                $value = $begin.join("+", $values).$end;
            }
        }

        return $value;
    }

    private function ValueReplacer(string $value, string $pattern, array $missing) : string {
        if(preg_match_all($pattern, $value, $matches, PREG_OFFSET_CAPTURE)) {
            for($i = count($matches[0]) - 1; $i >= 0; $i--) {
                $find = $matches[0][$i][0];
                $offs = $matches[0][$i][1];
    
                $begin = substr($value, 0, $offs);
                $end = substr($value, $offs + strlen($find));

                if(!key_exists($find, $missing)) {
                    $value = $begin.$this->_MAPPING[$find].$end;
                }
                else {
                    $value = $value;
                }
            }
        }

        return $value;
    }

}