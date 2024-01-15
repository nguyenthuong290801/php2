<?php

namespace Illuminate\framework;

class Debug
{
    public static function var_dump($variable = [])
    {
        echo "<style> ::-webkit-scrollbar { display: none; } </style>";
        echo '<pre style=" font-weight: 600; color:#1dff74;">';
        echo "<div style=\"position: fixed; top:0; left:0; right:0; bottom:0; z-index:9999; background-color: #1E1E1E; padding:20px 30px;overflow-y: scroll; \">";

        if (is_array($variable)) {
            echo "<div>";
            self::recursive_var_dump($variable);
            echo "</div>";

        } elseif (is_object($variable)) {
            var_dump($variable);
            
        } else {
            var_dump($variable);
        }

        echo '</pre>';
        echo "</div>";
        return;
    }

    public static function backtrace()
    {
        $trace = debug_backtrace();
        self::var_dump($trace);
    }

    public static function recursive_var_dump($array, $depth = 1)
    {
        
        foreach ($array as $key => $value) {
            echo "<div style=\"display:flex; align-items:center; margin-top:10px;\">";
            echo "<div style=\" width:auto; text-align:left; border-radius: 5px; margin-left:20px;\">$key =></div>" . "<div style=\"margin-left:20px; color:#fff;\">";

            for ($i = 0; $i < $depth; $i++) {
            }

            if (is_array($value)) {
                echo "<div style=\"color:#ffb011;\">Array: quantity = " . count($value) . " [</div>";
                self::recursive_var_dump($value, $depth + 1);
                echo "<div style=\"margin-top:20px;\"></div>" . "<div style=\"color:#ffb011;\">]</div>" . "<div></div>";

            } elseif (is_object($value)) {
                echo "<div style=\"color:#ffb011;\">Object:</div>";
                var_dump($value);

            } else {
                var_dump($value);
            }
            echo "</div>";
            echo "</div>";
        }
    }
}
